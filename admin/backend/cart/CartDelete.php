<?php
include "../../../config/database.php";
// print_r($conn);

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    if (!isset($_GET["id"]) === "") {
        echo " Id is required";
        exit;
    }

    $id = $_GET["id"];
    $query = "DELETE FROM cart  WHERE user_id='$id' ";
    // $query = "DELETE FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_affected_rows($conn) > 0) {
            echo "success";
        } else {
            
            echo "Cart not found  __" . mysqli_error($conn) ;
        }

    } else {
        echo "Something went wrong: " . mysqli_error($conn);
    }

} else {
    echo "this is not correct";
}
?>