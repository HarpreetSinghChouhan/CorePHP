<?php 
include "../config/database.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["Email"] ?? "";
    $password = $_POST["Password"] ?? "";

    if ($email == "" || $password == "") {
        echo "All fields are required";
        exit;
    }
    // AND Is_deleted='0' 
$query = "SELECT * FROM user WHERE email = '$email' AND Is_deleted='0' LIMIT 1 ";
 $result =  mysqli_query($conn,$query);
if (!$result) {
        echo "Database error: " . mysqli_error($conn);
        exit;
    }
    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);
        // print_r($user["password"]);
        if (password_verify($password, $user["password"])) {
           $_SESSION["email"] = $user["email"];
           $_SESSION["user_name"] = $user["name"];
           $_SESSION["user_id"] = $user["id"];
            echo $user["role"];
        //    }
            // echo "success";

        } else {

            echo "Invalid email or password";

        }

    } else {

        echo "User Are Deleted Or Not Exited";

    }

}
?>