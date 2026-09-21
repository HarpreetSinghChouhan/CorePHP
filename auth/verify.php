<?php
include "./config/database.php";
session_start();
if(isset($_SESSION['email'])){
$email = $_SESSION['email'];
// echo $email;
$query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
     if(!$result){
    // header("Location:  http://localhost/CorePHP/login.php"); 
    header("Location:  /CorePHP/login.php");   

    exit;
     }
     else if(mysqli_num_rows($result) > 0){
             $user = mysqli_fetch_assoc($result);
             if($user["role"] == "admin"){
             header("Location: /CorePHP/admin/index.php");
             exit;
            } 
           else if($user["role"] == "user" ){
            header("Location:  /CorePHP/user/index.php");
              exit;
            }
     }
}

?>