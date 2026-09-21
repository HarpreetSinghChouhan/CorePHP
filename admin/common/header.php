<?php
// admin/header.php
require_once __DIR__ . '/../../config/database.php';
// require_once dirname(__DIR__, 2) . '/includes/database.php';
session_start();
 if(!isset($_SESSION['email'])){
    header("Location:  /CorePHP/login.php");
    exit;
 }
$email = $_SESSION['email'];
//  echo $email;
// if(!isset($email)){
//     header("Location :  http://localhost/CorePHP/view/login.php");
//     exit;
// }
  $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
     if(!$result){
    header("Location:  /CorePHP/login.php");   
    exit;
     }
     else if(mysqli_num_rows($result) > 0){
             $user = mysqli_fetch_assoc($result);
           if($user["role"] == "user" ){
            header("Location:  /CorePHP/user/index.php");
             exit;
            }
            else{
                $username = $user["name"];
            }
     }
// echo "Harpreet Singh";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel<?php // echo SITE_NAME; ?></title>
   
    <link rel="stylesheet" href="/CorePHP/assets/style/admin-style.css">
    <!-- <link rel="stylesheet" href="https://cloudflare.com" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/CorePHP/admin/assets/js/script.js" defer></script>
<body>
<div class="admin-wrapper">
    
 <!-- <?php // echo SITE_NAME; ?> -->