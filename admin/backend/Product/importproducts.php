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
    echo json_encode(['success' => false, 'message' => 'File upload nahi hui']);
    exit;
}

$file = $_FILES['csv_file'];
if (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'csv') {
    echo json_encode(['success' => false, 'message' => 'Sirf CSV file allowed hai']);
    exit;
}

$handle = fopen($file['tmp_name'], 'r');
if ($handle === false) {
    echo json_encode(['success' => false, 'message' => 'File read nahi ho payi']);
    exit;
}

$header = fgetcsv($handle);
if (!$header) {
    echo json_encode(['success' => false, 'message' => 'CSV khali hai']);
    exit;
}
$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
$header    = array_map(fn($h) => strtolower(trim($h)), $header);

foreach (['category_name', 'name', 'price', 'sku'] as $col) {
    if (!in_array($col, $header, true)) {
        echo json_encode(['success' => false, 'message' => "CSV me '$col' column nahi mila"]);
        exit;
    }
}

$categoryCache = [];   
$inserted = 0;
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
            $errors[] = "Row $rowNum: category/sku/name khali hai";
            continue;
        }

        $skuEsc = mysqli_real_escape_string($conn, $sku);
        $query  = "SELECT id FROM $productTable WHERE sku = '$skuEsc' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (!$result) throw new Exception(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $skipped++;
            $errors[] = "Row $rowNum: SKU '$sku' pehle se hai";
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

        $nameEsc   = mysqli_real_escape_string($conn, $name);
        $descEsc   = mysqli_real_escape_string($conn, $row['description'] ?? '');
        $price     = (float) $row['price'];
        $stock     = (int) ($row['stock_quantity'] ?? 0);
        $image     = '';
        $status    = mysqli_real_escape_string($conn, $row['status'] !== '' ? $row['status'] : 'publish');
        $isDeleted = (int) ($row['is_deleted'] ?? 0);
        $createdAt = mysqli_real_escape_string($conn, $row['created_at'] !== '' ? $row['created_at'] : date('Y-m-d H:i:s'));
        $updatedAt = mysqli_real_escape_string($conn, $row['updated_at'] !== '' ? $row['updated_at'] : $createdAt);

        $query = "INSERT INTO $productTable
                  (category_id, name, price, sku, description, stock_quantity, image, status, is_deleted, created_at, updated_at)
                  VALUES
                  ($categoryId, '$nameEsc', $price, '$skuEsc', '$descEsc', $stock, '$image', '$status', $isDeleted, '$createdAt', '$updatedAt')";

        $result = mysqli_query($conn, $query);
        if (!$result) throw new Exception(mysqli_error($conn));

        $inserted++;
    }

    mysqli_commit($conn);
} catch (Throwable $e) {
    mysqli_rollback($conn);
    fclose($handle);
    echo json_encode(['success' => false, 'message' => 'Import fail: ' . $e->getMessage()]);
    exit;
}

fclose($handle);

echo json_encode([
    'success' => true,
    'message' => "$inserted product add hue, $skipped skip hue, $newCats nayi category bani.",
    'errors'  => $errors
]);