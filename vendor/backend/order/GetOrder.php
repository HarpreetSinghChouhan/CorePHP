<?php
include "../../../config/database.php";
include "../verify.php";
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $user_id =  $_SESSION['user_id'] ?? 0;
    $query = "SELECT o.id, o.is_deleted, o.order_id, o.user_id, o.total_amount, o.product_quantity, o.created_at,
        u.name, u.email, u.id AS user_table_id,oi.id AS orderitem_id , oi.order_id As oi_orderitem ,oi.product_id, 
        COUNT(oi.id) AS total_order_items, p.id,p.user_id AS puser_id , SUM(oi.product_quantity) AS all_product_quantity , SUM(oi.product_quantity * oi.product_price) AS total_price
        FROM `order` AS o
        INNER JOIN `user` AS u
        ON o.user_id = u.id
        LEFT JOIN order_item AS oi 
        ON o.order_id = oi.order_id
        RIGHT JOIN `product` AS p 
        ON p.id = oi.product_id 
        WHERE o.is_deleted != '1' AND p.user_id = '$user_id' 
        GROUP BY o.id";

    $result = mysqli_query($conn, $query);

    if(!$result){
        echo json_encode(["error" => mysqli_error($conn)]);
        exit;
    }
    $product = [];
    while($row = mysqli_fetch_assoc($result)){
    //    $productquantity = $    
    $object = [ 

            "order_id" => $row['order_id'],
            "user_name" => $row['name'],
            "user_email" => $row['email'],
            "total_quantity" => $row['all_product_quantity'],
            "total_price" => $row['total_price'],
            "order_items" => $row['total_order_items'],
            "perchange_at" => $row['created_at'],
        ];
        $product[] = $object;
    }
    echo json_encode($product);
    exit;

} else {
    echo "Somthing Are Wrong";
}
?>