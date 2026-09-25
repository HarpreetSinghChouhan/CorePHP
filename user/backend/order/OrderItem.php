<?php
include '../../../config/database.php';
include "../../../admin/backend/verify.php";
if($_SERVER["REQUEST_METHOD"] === "GET"){
   $user_id = (int) $_SESSION["user_id"];
   $order_id = (int) $_GET["id"];
    $query = "SELECT o.order_id, o.total_amount, o.user_id, o.product_quantity,
                 u.id AS user_id, u.name AS user_name, u.email,
                 p.id AS product_id, p.image, p.sku, p.price, p.name AS product_name,
                 c.id AS cat_id, c.name AS cat_name,
                 oi.product_price, oi.product_quantity AS oi_qty, oi.product_name AS oi_product_name
          FROM `order_item` AS oi
          INNER JOIN `product` AS p ON oi.product_id = p.id
          INNER JOIN `user` AS u ON oi.user_id = u.id
          INNER JOIN `category` AS c ON p.category_id = c.id
          INNER JOIN `order` AS o ON oi.order_id = o.order_id
          WHERE oi.order_id = '$order_id'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo json_encode(["error" => mysqli_error($conn)]);
        exit;
    }
   $data = [];

while ($row = mysqli_fetch_assoc($result)) {
    // print_r($row); 
     $image =  'data:image/jpeg;base64,' . base64_encode($row['image']);
    $object = [
        "product_id"    => $row['product_id'],
        "product_name"  => $row['product_name'],
        "image"         => $image,
        "sku"           => $row['sku'],
        "price"         => $row['price'],
        "quantity"      => $row['oi_qty'],
        "category_name" => $row['cat_name'],
    ];
    $data [] = $object; 

}

// header('Content-Type: application/json');
echo json_encode($data);
exit;
} else {
    echo "Somthing Are Wrong";
}
?>