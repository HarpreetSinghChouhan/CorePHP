<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';
require './../verify.php';   

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$user_id   = (int)($_SESSION['user_id'] ?? 0);
$vendor_id = (int)($_POST['id'] ?? 0);

if (!$user_id || !$vendor_id) {
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

$select = "SELECT id, role FROM user WHERE id = $user_id LIMIT 1";
$runquery = mysqli_query($conn, $select);
$admin = mysqli_fetch_assoc($runquery);

if (!$admin || $admin['role'] !== 'admin') {   
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$select2 = "SELECT id, email FROM user WHERE id = $vendor_id LIMIT 1";
$runquery2 = mysqli_query($conn, $select2);
$vendor = mysqli_fetch_assoc($runquery2);

if (!$vendor) {
    echo json_encode(["error" => "Vendor not found"]);
    exit;
}

$_SESSION['admin_id'] = $admin['id'];
$_SESSION['user_id']  = $vendor['id'];
$_SESSION['email']    = $vendor['email'];

echo json_encode(["status" => "success"]);
exit;