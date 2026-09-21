<?php
// user/header.php
require_once __DIR__ . '/../../config/database.php';

session_start();
$email = $_SESSION['email'];
// echo $email;
if(!isset($email)){
    header("Location:  /CorePHP/login.php");
    exit;
}
  $query = "SELECT * FROM user WHERE email = '$email' AND Is_deleted='0' LIMIT 1";
    $result = mysqli_query($conn,$query);
    // print_r($result);
     if(!$result){
    header("Location:  /CorePHP/login.php");   
    exit;
     }
     else if(mysqli_num_rows($result) > 0){
        // print_r($result);
             $user = mysqli_fetch_assoc($result);
             if($user["role"] == "admin" ){
            header("Location: /CorePHP/admin/index.php");
             exit;
            } 
            else {
            $username = $user["name"];
            }
     }
     else{
     header("Location:  /CorePHP/auth/logout.php");   
     exit;
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="/CorePHP/assets/style/user-style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="user-wrapper">
