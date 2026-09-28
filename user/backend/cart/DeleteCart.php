<?php 
session_start();
include '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(["error" => "Invalid data"]);
    exit;
}

$dltcart = "DELETE FROM cart WHERE id='$id'";
$result = mysqli_query($conn, $dltcart);

if ($result) {
    echo json_encode(["success" => true,"message"=>"Your cart Item Are Removed Successfully"]);
} else {
    echo json_encode(["error" => "Delete failed"]);
}
?>