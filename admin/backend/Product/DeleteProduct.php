<?php
include "../../../config/database.php";
// print_r($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST["id"]) || trim($_POST["id"]) === "") {
        echo "id is required";
        exit;
    }

    $id = $_POST["id"];
    $query = "UPDATE product SET Is_deleted='1' WHERE id='$id' ";
    $result = mysqli_query($conn, $query);

    if ($result) {

        if (mysqli_affected_rows($conn) > 0) {
            echo "success";
        } else {
            echo "Product not found  __" . mysqli_error($conn) ;
        }

    } else {
        echo "Something went wrong: " . mysqli_error($conn);
    }

} else {
    echo "this is not correct";
}
?>