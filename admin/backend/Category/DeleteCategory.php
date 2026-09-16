<?php
include "../../../config/database.php";
// print_r($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["name"]) || trim($_POST["name"]) === "") {
        echo "   Name is required";
        exit;
    }

    $name = $_POST["name"];
    $query = "UPDATE category SET Is_deleted='1' WHERE name='$name' ";
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