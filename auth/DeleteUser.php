<?php
include "../config/database.php";
// print_r($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["email"]) || trim($_POST["email"]) === "") {
        echo "Email is required";
        exit;
    }

    $email = $_POST["email"];
    $query = "UPDATE user SET Is_deleted='1' WHERE email='$email' ";
    // $query = "DELETE FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_affected_rows($conn) > 0) {
            echo "success";
        } else {
            
            echo "User not found  __" . mysqli_error($conn) ;
        }

    } else {
        echo "Something went wrong: " . mysqli_error($conn);
    }

} else {
    echo "this is not correct";
}
?>