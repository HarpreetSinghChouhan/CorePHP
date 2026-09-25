<?php
include "../../../config/database.php";
include "../verify.php";

 if($_SERVER["REQUEST_METHOD"] != "GET" || $_GET['id'] == ''){
    echo json_encode(["error"=> "something Are Wrong"]);
 }
 else{
  $orderid = $_GET['id'];
  $orderidr = mysqli_real_escape_string($conn,$orderid);
$SelectQuery = "SELECT o.order_id,o.total_amount,o.user_id, o.product_quantity,
        u.id AS uuser_id, u.name AS uuser_name, u.email,
        p.id AS product_id, p.image, p.sku, p.category_id, p.price, p.name AS pproduct_name,
        c.id AS cat_id, c.name AS cat_name,
        oi.order_id AS oiorder_id, oi.product_price, oi.product_quantity, oi.user_id,oi.product_name 
        FROM `order_item` AS oi 
        INNER JOIN `product` AS p
        ON oi.product_id =  p.id
        INNER JOIN `user` AS u 
        ON oi.user_id = u.id
        INNER JOIN `category` AS c
        ON p.category_id = c.id
        INNER JOIN `order` AS o
        ON oi.order_id = o.order_id
        WHERE oi.order_id = '$orderidr'";
      $result = mysqli_query($conn,$SelectQuery);
      $order_items = []; 
      while( $row = mysqli_fetch_assoc($result)){
        //  print_r($row);
         $image =  'data:image/jpeg;base64,' . base64_encode($row['image']);
        $object = [
            "order_id" => $row["oiorder_id"],
            "product_name" => $row["pproduct_name"],
            "product_price" => $row["product_price"],
            "product_quantity" => $row["product_quantity"],
            "product_sku" =>$row["sku"],
            "category_name" => $row["cat_name"],
            "total_product_amount" => $row["product_quantity"] * $row ["product_price"],
            "total_amount" => $row["total_amount"],
            "user_name" => $row["uuser_name"],
            "user_email" => $row["email"],
            "product_image"=> $image,
        ];
        $order_items[] = $object; 
        //   echo 
      };
      echo json_encode($order_items);
 }

// echo json_encode(["message" =>"This Are Working"]);