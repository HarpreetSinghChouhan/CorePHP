<?php
require_once __DIR__ . '/../../../config/database.php';
require './../verify.php';   
$admin_id = (int)($_SESSION['admin_id'] ?? 0);

if (!$admin_id) {
    header("Location: /CorePHP/home.php");  
    exit;
}
$select = "SELECT id, email, role FROM user WHERE id = $admin_id LIMIT 1";
$runquery = mysqli_query($conn, $select);
$admin = mysqli_fetch_assoc($runquery);

if (!$admin || $admin['role'] !== 'admin') {
    header("Location: /CorePHP/home.php");
    exit;
}

$_SESSION['user_id'] = $admin['id'];
$_SESSION['email']   = $admin['email'];
unset($_SESSION['admin_id']);

header("Location: /CorePHP/admin/index.php");  
exit;