<?php
include "./../../../config/database.php";
session_start();

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

$userid = $_SESSION["user_id"] ?? "";

$userselect = "SELECT id FROM `user` WHERE id = '$userid'";
$userresult = mysqli_query($conn, $userselect);

if (mysqli_num_rows($userresult) == 0) {
    echo json_encode(["error" => "User does not exist"]);
    exit;
}

       $selectwishlist = "SELECT w.id,w.user_id,w.product_id, 
        p.name AS product_name, p.price, p.description, p.sku, p.image
        FROM `wishlist` AS w
        LEFT JOIN `product` AS p
        ON p.id = w.product_id
        WHERE w.user_id = '$userid' AND w.is_active != '1'";

$resultwishlist = mysqli_query($conn, $selectwishlist);

$data = [];
while ($row = mysqli_fetch_assoc($resultwishlist)) {
    $image = !empty($row['image'])
        ? 'data:image/jpeg;base64,' . base64_encode($row['image'])
        : null;

    $object = [
        "id" => $row["id"],
        "product_name" => $row["product_name"],
        "product_price" => $row["price"],
        "description" => $row["description"],
        "product_sku" => $row["sku"],
        "product_id" => $row["product_id"],
        "product_image" => $image,
    ];
    $data[] = $object;
}

echo json_encode($data);
exit;
?>