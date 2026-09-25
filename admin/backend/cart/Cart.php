<?php 
include "../../../config/database.php";
include "../verify.php";
if($_SERVER["REQUEST_METHOD"] === "GET"){
   $selectquery = "SELECT c.*, u.id AS uuser_id, u.name AS uuser_name, u.email,u.is_deleted AS uis_deleted,
        COUNT(c.id) AS total_items, SUM(c.quantity) AS cart_total_quantity , SUM(c.quantity * p.price) AS total_price,
        p.name AS p_name, p.sku, p.price
        FROM `cart` AS c
        INNER JOIN `product` AS p
        ON c.product_id = p.id
        INNER JOIN `user` AS u 
        ON c.user_id = u.id 
        WHERE c.is_deleted != '1' AND u.role != 'admin'
        GROUP BY u.id";
     $result = mysqli_query($conn, $selectquery);
     
      $data = [];
     while($row = mysqli_fetch_assoc($result)){
       $object = [
        "user_id"        => $row['user_id'],
        "user_name"      => $row['uuser_name'],
        "email"          => $row['email'],
        "total_items"    => $row['total_items'],
        "total_quantity" => $row['cart_total_quantity'],
        "total_price"    => $row['total_price'],
    ];

    $data[] = $object;

     }
     echo json_encode($data);
}
else{
    echo json_encode(["status"=>"404", "message" => "somthing are wrong"]);
}
?>