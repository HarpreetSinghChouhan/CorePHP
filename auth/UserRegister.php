<?php 
include "../config/database.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["UserName"];
    $gender = $_POST["Gender"];
    $age = $_POST["Age"];
    // $age ='2008-09-14';

    $email = $_POST["Email"];
    $PhoneNumber = $_POST["PhoneNumber"];
    // $gender = $_POST["Gender"];
    $password = password_hash($_POST["Password"],PASSWORD_DEFAULT);
    
    $dob =  new DateTime($age,$timezone);
      $newdate = $date->format('Y-m-d');
    $diff = date_diff($date,$dob);
    $year = $diff->y;
    if($year < 18){
                echo "AgeWrong";
                exit;
    }else{
    $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result  = mysqli_query($conn,$query);
    if (!$result) {
        echo "Database error";
        exit;
    }

    if (mysqli_num_rows($result) > 0) {

        echo "User-Exited";
        exit;

    } else {
// $name = $_POST["UserName"];
  $query = "INSERT INTO user (name, email, phonenumber, age, gender, role, password) VALUE ('$name', '$email', '$PhoneNumber', '$age', '$gender', 'user', '$password')";
//   echo "$name , $gender , $age , $email , $password";     
 $result = mysqli_query($conn, $query);

        if ($result) {     
            echo "Success";
            
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    }

}
?>