<?php

header('Content-Type: application/json');
include "../../../config/database.php";

$categoryTable = 'category';
$productTable  = 'product';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'File are valid']);
    exit;
}

$file = $_FILES['csv_file'];
if (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'csv') {
    echo json_encode(['success' => false, 'message' => 'Only Allowed CSV file']);
    exit;
}

$uploadDir   = dirname(__DIR__, 3) . '/public/uploads/product/';
$allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
$savedFiles  = [];
$zip         = null;
$zipMap      = [];

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    echo json_encode(['success' => false, 'message' => 'Upload folder not found']);
    exit;
}

if (isset($_FILES['images_zip']) && $_FILES['images_zip']['error'] === UPLOAD_ERR_OK) {
    $zip = new ZipArchive();
    if ($zip->open($_FILES['images_zip']['tmp_name']) !== true || $zip->numFiles > 500) {
        echo json_encode(['success' => false, 'message' => 'Invalid ZIP file or too many files']);
        exit;
    }
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $name = $zip->statIndex($i)['name'];
        if (substr($name, -1) === '/' || str_contains($name, '__MACOSX')) continue;
        $zipMap[strtolower(basename($name))] = $i;
    }
}

function saveZipImage($imgName, $zip, $zipMap, $uploadDir, $allowedMime, &$savedFiles, &$error)
{
    $error = '';
    if ($imgName === '') return '';

    if (!$zip) {
        $error = "image '$imgName' name Are given csv but ZIP not Have named image";
        return '';
    }
    if (!isset($zipMap[$imgName])) {
        $error = "image '$imgName' ZIP Not Found";
        return '';
    }
    if ($zip->statIndex($zipMap[$imgName])['size'] > 2 * 1024 * 1024) {
        $error = "image size are Bigger that 2MB";
        return '';
    }

    $data = $zip->getFromIndex($zipMap[$imgName]);
    $mime = $data !== false ? (new finfo(FILEINFO_MIME_TYPE))->buffer($data) : '';
    if (!isset($allowedMime[$mime])) {
        $error = "image type Are not allowed";
        return '';
    }

    $newName = bin2hex(random_bytes(16)) . '.' . $allowedMime[$mime];
    if (file_put_contents($uploadDir . $newName, $data) === false) {
        $error = "image Are NOt Saved";
        return '';
    }

    $savedFiles[] = $uploadDir . $newName;
    return 'product/' . $newName;
}

$handle = fopen($file['tmp_name'], 'r');
if ($handle === false) {
    echo json_encode(['success' => false, 'message' => 'Files Are In Readng Process']);
    exit;
}

$header = fgetcsv($handle);
if (!$header) {
    echo json_encode(['success' => false, 'message' => 'CSV File Are Empty']);
    exit;
}
$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
$header    = array_map(fn($h) => strtolower(trim($h)), $header);

foreach (['category_name', 'name', 'price', 'sku'] as $col) {
    if (!in_array($col, $header, true)) {
        echo json_encode(['success' => false, 'message' => " In CSV '$col' column Not Found"]);
        exit;
    }
}

$categoryCache = [];
$inserted = 0;
$updated  = 0;
$skipped  = 0;
$newCats  = 0;
$errors   = [];
$rowNum   = 1;

mysqli_begin_transaction($conn);

try {
    while (($line = fgetcsv($handle)) !== false) {
        $rowNum++;

        if (count($line) === 1 && trim($line[0]) === '') continue;

        $line = array_pad($line, count($header), '');
        $row  = array_combine($header, array_map('trim', array_slice($line, 0, count($header))));

        $catName = $row['category_name'];
        $sku     = $row['sku'];
        $name    = $row['name'];

        if ($catName === '' || $sku === '' || $name === '') {
            $skipped++;
            $errors[] = "Row $rowNum: category/sku/name Are empty";
            continue;
        }

        $imgName = strtolower(basename($row['image'] ?? ''));

        $skuEsc = mysqli_real_escape_string($conn, $sku);
        $query  = "SELECT id, image_url, LENGTH(image) AS img_len
                   FROM $productTable WHERE sku = '$skuEsc' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (!$result) throw new Exception(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $existing = mysqli_fetch_assoc($result);
            $hasBlob  = (int) $existing['img_len'] > 0;
            $hasUrl   = trim((string) $existing['image_url']) !== '';

            if (!$hasBlob && !$hasUrl && $imgName !== '') {
                $imgError = '';
                $imageUrl = saveZipImage($imgName, $zip, $zipMap, $uploadDir, $allowedMime, $savedFiles, $imgError);

                if ($imageUrl === '') {
                    $skipped++;
                    $errors[] = "Row $rowNum: SKU '$sku' Image are Empty, But update fail: $imgError";
                } else {
                    $existingId  = (int) $existing['id'];
                    $imageUrlEsc = mysqli_real_escape_string($conn, $imageUrl);
                    $query = "UPDATE $productTable
                              SET image_url = '$imageUrlEsc', updated_at = NOW()
                              WHERE id = $existingId";
                    $result = mysqli_query($conn, $query);
                    if (!$result) throw new Exception(mysqli_error($conn));
                    $updated++;
                }
            } else {
                $skipped++;
                $errors[] = ($hasBlob || $hasUrl)
                    ? "Row $rowNum: SKU '$sku' Product Are Allready exited "
                    : "Row $rowNum: SKU '$sku' Product Are Allready exited";
            }
            continue;
        }

        $key = strtolower($catName);

        if (isset($categoryCache[$key])) {
            $categoryId = $categoryCache[$key];
        } else {
            $catEsc = mysqli_real_escape_string($conn, $catName);

            $query  = "SELECT id FROM $categoryTable WHERE LOWER(name) = LOWER('$catEsc') LIMIT 1";
            $result = mysqli_query($conn, $query);
            if (!$result) throw new Exception(mysqli_error($conn));

            if (mysqli_num_rows($result) > 0) {
                $categoryId = (int) mysqli_fetch_assoc($result)['id'];
            } else {
                $query  = "INSERT INTO $categoryTable (name) VALUES ('$catEsc')";
                $result = mysqli_query($conn, $query);
                if (!$result) throw new Exception(mysqli_error($conn));

                $categoryId = mysqli_insert_id($conn);
                $newCats++;
            }
            $categoryCache[$key] = $categoryId;
        }
        $imgError = '';
        $imageUrl = saveZipImage($imgName, $zip, $zipMap, $uploadDir, $allowedMime, $savedFiles, $imgError);
        if ($imgError !== '') {
            $errors[] = "Row $rowNum: $imgError";
        }
        $user_id =(int) $_SESSION['user_is'];
        $nameEsc     = mysqli_real_escape_string($conn, $name);
        $descEsc     = mysqli_real_escape_string($conn, $row['description'] ?? '');
        $imageUrlEsc = mysqli_real_escape_string($conn, $imageUrl);
        $price       = (float) $row['price'];
        $stock       = (int) ($row['stock_quantity'] ?? 0);
        $status      = mysqli_real_escape_string($conn, ($row['status'] ?? '') !== '' ? $row['status'] : 'publish');
        $isDeleted   = (int) ($row['is_deleted'] ?? 0);
        $createdAt   = mysqli_real_escape_string($conn, ($row['created_at'] ?? '') !== '' ? $row['created_at'] : date('Y-m-d H:i:s'));
        $updatedAt   = mysqli_real_escape_string($conn, ($row['updated_at'] ?? '') !== '' ? $row['updated_at'] : $createdAt);

        $query = "INSERT INTO $productTable
                  (category_id, name, price,user_id, sku, description, stock_quantity, image, image_url, status, is_deleted, created_at, updated_at)
                  VALUES
                  ($categoryId, '$nameEsc', $price,'$user_id', '$skuEsc', '$descEsc', $stock, '', '$imageUrlEsc', '$status', $isDeleted, '$createdAt', '$updatedAt')";

        $result = mysqli_query($conn, $query);
        if (!$result) throw new Exception(mysqli_error($conn));

        $inserted++;
    }
    // vhaa porpermision lene ke liye jaaye ki jo bhi reape product hai uski quantity increase karni hai ya nahi ja to uske baad jab uska response aaye ga or fir sabi ka accoring to increase quantity ho jaae. or yhaa pe ye bhi set karna hai ki jo bhi jaiada product aane pe jaise ki  2000 ja 4000 row aa jae to kaise handle karni padde gi  

    mysqli_commit($conn);
} catch (Throwable $e) {
    mysqli_rollback($conn);
    fclose($handle);
    foreach ($savedFiles as $f) {
        if (is_file($f)) unlink($f);
    }
    echo json_encode(['success' => false, 'message' => 'Import fail: ' . $e->getMessage()]);
    exit;
}

fclose($handle);
if ($zip) $zip->close();

echo json_encode([
    'success' => true,
    'message' => "$inserted product Are Added, $updated product ki image update hui, $skipped skip Product, $newCats Create New Category.",
    'errors'  => $errors
]);