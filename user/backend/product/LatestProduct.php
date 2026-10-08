<?php
include "../../../config/database.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    $query = "SELECT product.id, product.name, product.price, product.sku, product.description, product.stock_quantity, product.image, product.created_at,
     category.name AS category_name,
     w.product_id,  w.user_id, w.id AS wishlist_id
    FROM `product`
    INNER JOIN `category`
    ON category.id = product.category_id
    LEFT JOIN `wishlist` AS w
    ON w.product_id = product.id AND w.user_id = '$user_id' AND w.is_active != '1'
    WHERE product.is_deleted != '1' AND product.created_at >= NOW() - INTERVAL 168 HOUR
    ORDER BY product.created_at DESC";

    $result = mysqli_query($conn, $query);

    $product = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        $object = [
            "id" => $row['id'],
            "name" => $row['name'],
            "category_name" => $row['category_name'],
            "sku" => $row['sku'],
            "price" => $row['price'],
            "description" => $row['description'],
            "stock_quantity" => $row['stock_quantity'],
            "created_at" => $row['created_at'],
            "image" => $base64Image,
            "wishlist" => $row['wishlist_id'] !== null,
        ];
        $product[] = $object;
    }
    echo json_encode($product);
    exit;

} else {
    echo "Something is wrong";
}
?>