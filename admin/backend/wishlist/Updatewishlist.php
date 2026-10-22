<?php
include "./../../../config/database.php";
include "./../verify.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$email = mysqli_real_escape_string($conn, $_SESSION['email']);
$query = "SELECT id, email, role FROM `user` WHERE email='$email'";
$queryresult = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($queryresult);

if (!$result || $result["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["error" => "Access Denied"]);
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if (!$id) {
    echo json_encode(["error" => "Invalid wishlist"]);
    exit;
}

$deletequery = "UPDATE `wishlist` SET is_active = 1 WHERE id = '$id' AND is_active = 0";
$resultdelete = mysqli_query($conn, $deletequery);

if ($resultdelete && mysqli_affected_rows($conn) > 0) {
    echo json_encode(["message" => "Wishlist removed successfully"]);
} else {
    echo json_encode(["error" => "Wishlist not found"]);
}
exit;
?>