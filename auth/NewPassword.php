<?php 
include "../config/database.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["Email"];
    $token = $_POST["Token"];
    $newtoken = "";
    $password = password_hash($_POST["Password"],PASSWORD_DEFAULT);
    $query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
    if (!$result) {
        echo "Database error";
        exit;
    } if(mysqli_num_rows($result) > 0){
         $user = mysqli_fetch_assoc($result);
         if($token==$user["token"]){

           $query = "UPDATE user SET token='$newtoken', password='$password' WHERE email='$email' LIMIT 1";
           $result = mysqli_query($conn,$query);
           echo "changed";
           }
         else{
            echo "failed";

         }

    }
    else{
        echo "failed";
    }

}
else{
    echo "something are wrong ";
}
?>