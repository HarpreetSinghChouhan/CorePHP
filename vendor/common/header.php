<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

 if(!isset($_SESSION['user_id'])){
    header("Location:  /CorePHP/login.php");
    exit;
 }
$pageTitle  = $pageTitle  ?? 'Vendor Panel';
$activePage = $activePage ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | Vendor Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/CorePHP/vendor/assets/style/vendor.css">
      <link rel="stylesheet" href="/CorePHP/vendor/assets/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/CorePHP/vendor/assets/js/mainscript.js" defer></script>
</head>
<body>
<div class="vr-layout">