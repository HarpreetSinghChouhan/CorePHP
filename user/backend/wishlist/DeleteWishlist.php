<?php
include "./../../../config/database.php";
session_start();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$userid = $_SESSION["user_id"] ?? "";

if (!$userid) {
    echo json_encode(["error" => "Please login first"]);
    exit;
}

$userselect = "SELECT id FROM `user` WHERE id = '$userid'";
$userresult = mysqli_query($conn, $userselect);

if (mysqli_num_rows($userresult) == 0) {
    echo json_encode(["error" => "User does not exist"]);
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if (!$id) {
    echo json_encode(["error" => "Invalid wishlist item"]);
    exit;
}

$deletequery = "UPDATE  `wishlist` SET is_active='1' WHERE id = $id AND user_id = '$userid'";
$resultdelete = mysqli_query($conn, $deletequery);

if ($resultdelete && mysqli_affected_rows($conn) > 0) {
    echo json_encode(["message" => "Item removed from wishlist"]);
} else {
    echo json_encode(["error" => "Item not found"]);
}
exit;
?>