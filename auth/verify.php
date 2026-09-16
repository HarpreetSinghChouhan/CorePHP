<?php
include "./config/database.php";
session_start();
if(isset($_SESSION['email'])){
$email = $_SESSION['email'];
// echo $email;
$query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
     if(!$result){
    header("Location:  http://localhost/harpreet_task/login.php");   
    exit;
     }
     else if(mysqli_num_rows($result) > 0){
             $user = mysqli_fetch_assoc($result);
             if($user["role"] == "admin"){
             header("Location:  http://localhost/harpreet_task/admin/index.php");
             exit;
            } 
           else if($user["role"] == "user" ){
            header("Location:  http://localhost/harpreet_task/user/index.php");
              exit;
            }
     }
}

// if(!$email){
//     header("Location :  http://localhost/harpreet_task/view/login.php");
//     exit;
// }
// else{
//     $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
//     $result = mysqli_query($conn,$query);
//      if(!$result){
//     header("Location:  http://localhost/harpreet_task/view/login.php");   
//     exit;
//      }
//      else if(mysqli_num_rows($result) > 0){
//              $user = mysqli_fetch_assoc($result);
//              if($user["role"] == "admin"){
//              header("Location:  http://localhost/harpreet_task/view/admindashboad.php");
//              exit;
//             } 
//            else if($user["role"] == "user" ){
//             header("Location:  http://localhost/harpreet_task/view/userdashboad.php");
//               exit;
//             }

//     }
     
// }
?>