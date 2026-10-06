<?php
include "../../../config/database.php";
include "../verify.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET" || empty($_GET['id'])) {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$userid = (int) $_GET['id'];

$query = "SELECT id FROM `user` WHERE id = $userid";
$mysql = mysqli_query($conn, $query);

if (!$mysql || mysqli_num_rows($mysql) === 0) {
    echo json_encode(["error" => "User does not exist"]);
    exit;
}

$selectcart = "SELECT c.*, p.*, u.id AS user_id, u.name AS user_name, u.email AS user_email
               FROM `user` AS u
               INNER JOIN `cart` AS c ON c.user_id = u.id
               INNER JOIN `product` AS p ON c.product_id = p.id
               WHERE u.id = $userid";
$result = mysqli_query($conn, $selectcart);

$cart_item = [];
while ($row = mysqli_fetch_assoc($result)) {
    $image = !empty($row['image'])
        ? 'data:image/jpeg;base64,' . base64_encode($row['image'])
        : null;
    
    $cart_item[] = [
        "product_id"           => $row["product_id"],
        "product_name"         => $row["name"],
        "product_price"        => $row["price"],
        "product_quantity"     => $row["quantity"],
        "product_sku"          => $row["sku"],
        "stock_quantity"       => $row["stock_quantity"],
        "total_product_amount" => $row["quantity"] * $row["price"],
        "user_name"            => $row["user_name"],
        "description"          => $row["description"],
        "user_email"           => $row["user_email"],
        "product_image"        => $image,
    ];
}

echo json_encode($cart_item);