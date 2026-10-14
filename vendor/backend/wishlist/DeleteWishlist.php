<?php
include "./../../../config/database.php";
include "./../verify.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$email = mysqli_real_escape_string($conn, $_SESSION['email']);
$query = "SELECT id, email, role FROM `user` WHERE email='$email'";
$queryresult = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($queryresult);

if (!$result || $result["role"] == "user") {
    http_response_code(403);
    echo json_encode(["error" => "Access Denied"]);
    exit;
}

$id = (int) ($_GET["id"] ?? 0);
$user_id = $_SESSION['user_id'];
if (!$id) {
    echo json_encode(["error" => "Invalid user"]);
    exit;
}
$deletequery = "UPDATE `product` p
                INNER JOIN `wishlist` w ON p.id = w.product_id  
                SET w.is_active = 1
                WHERE w.user_id = '$id' 
                  AND p.user_id IS NOT NULL 
                  AND p.user_id = '$user_id'
                  AND w.is_active = 0";

// $deletequery = "UPDATE `wishlist` SET is_active = `1` WHERE user_id = '$id'  AND is_active = 0";
$resultdelete = mysqli_query($conn, $deletequery);

if ($resultdelete && mysqli_affected_rows($conn) > 0) {
    echo json_encode(["status"=>"success","message" => "Wishlist removed successfully"]);
} else {
    echo json_encode(["error" => "Wishlist not found"]);
}
exit;
?>