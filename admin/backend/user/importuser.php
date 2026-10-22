<?php

header('Content-Type: application/json');
include "../../../config/database.php";

$userTable    = 'user';  
$allowedRoles = ['user', 'vendor'];   

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'CSV file select karo']);
    exit;
}

$file = $_FILES['csv_file'];
if (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'csv') {
    echo json_encode(['success' => false, 'message' => 'Sirf CSV file allowed hai']);
    exit;
}

$handle = fopen($file['tmp_name'], 'r');
$header = fgetcsv($handle);
if (!$header) {
    echo json_encode(['success' => false, 'message' => 'CSV file khaali hai']);
    exit;
}

$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
$header    = array_map(fn($h) => strtolower(trim($h)), $header);

foreach (['name', 'email'] as $col) {
    if (!in_array($col, $header, true)) {
        echo json_encode(['success' => false, 'message' => "CSV  '$col' column Never Found"]);
        exit;
    }
}

$inserted = 0;
$updated  = 0;
$skipped  = 0;
$errors   = [];
$rowNum   = 1;

mysqli_begin_transaction($conn);

try {
    while (($line = fgetcsv($handle)) !== false) {
        $rowNum++;

        if (count($line) === 1 && trim($line[0]) === '') continue;

        $line = array_pad($line, count($header), '');
        $row  = array_combine($header, array_map('trim', array_slice($line, 0, count($header))));

        $name  = $row['name'];
        $email = strtolower($row['email']);
        $phone = $row['phonenumber'];
        if ($name === '' || $email === '' ) {
            $skipped++;
            $errors[] = "Row $rowNum: name, and email Empty";
            continue;
        }

        $phoneverify = '/^[6-9][0-9]{9}$/';
        if(!preg_match($phoneverify,$phone)){
        $skipped++;
        $errors[] = "Row  $rowNum: phone Number are Valid";
        continue;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $skipped++;
            $errors[] = "Row $rowNum: email '$email' Is Valid";
            continue;
        }

        $nameEsc  = mysqli_real_escape_string($conn, $name);
        $emailEsc = mysqli_real_escape_string($conn, $email);
        $phoneEsc = mysqli_real_escape_string($conn,$phone);
        $query  = "SELECT id FROM $userTable WHERE email = '$emailEsc' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (!$result) throw new Exception(mysqli_error($conn));

        if (mysqli_num_rows($result) > 0) {
            $id    = (int) mysqli_fetch_assoc($result)['id'];
            $query = "UPDATE $userTable
                      SET name = '$nameEsc',phonenumber = '$phoneEsc',  updated_at = NOW()
                      WHERE id = $id";
            if (!mysqli_query($conn, $query)) throw new Exception(mysqli_error($conn));
            $updated++;
            continue;
        }
        $password = $row['password'] ?? '';
        if ($password === '') {
            $skipped++;
            $errors[] = "Row $rowNum:  password are Required";
            continue;
        }

        $age = $row['age'] ?? '';
        if ($age !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $age)) {
            $skipped++;
            $errors[] = "Row $rowNum: age/date format YYYY-MM-DD In this Format";
            continue;
        }

        $role = strtolower($row['role'] ?? '');
        if (!in_array($role, $allowedRoles, true)) {
            $role = 'user';  
        }

        $phoneEsc  = mysqli_real_escape_string($conn, $row['phonenumber'] ?? '');
        $ageEsc    = mysqli_real_escape_string($conn, $age);
        $genderEsc = mysqli_real_escape_string($conn, $row['gender'] ?? '');
        $roleEsc   = mysqli_real_escape_string($conn, $role);
        $hash      = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));

        $query = "INSERT INTO $userTable
                  (name, email, phonenumber, age, gender, role, password, token, is_deleted, created_at, updated_at)
                  VALUES
                  ('$nameEsc', '$emailEsc', '$phoneEsc', '$ageEsc', '$genderEsc', '$roleEsc', '$hash', '', 0, NOW(), NOW())";
        if (!mysqli_query($conn, $query)) throw new Exception(mysqli_error($conn));
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
    'message' => "$inserted user added, $updated user  updated, $skipped skip users.",
    'errors'  => $errors
]);