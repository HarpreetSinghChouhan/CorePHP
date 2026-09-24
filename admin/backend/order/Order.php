<?php
include "../../../config/database.php";

if($_SERVER["REQUEST_METHOD"] === "GET"){

    $query = "SELECT o.id, o.order_id, o.user_id, o.total_amount, o.product_quantity, o.created_at,
        u.name, u.email, u.id AS user_table_id,
        COUNT(oi.id) AS total_order_items
        FROM `order` o
        INNER JOIN order_item oi ON o.order_id = oi.order_id
        INNER JOIN user u ON o.user_id = u.id
        GROUP BY o.id";

    $result = mysqli_query($conn, $query);

    if(!$result){
        echo json_encode(["error" => mysqli_error($conn)]);
        exit;
    }
    $product = [];
    while($row = mysqli_fetch_assoc($result)){
        $object = [ 
            "order_id" => $row['order_id'],
            "user_name" => $row['name'],
            "user_email" => $row['email'],
            "total_quantity" => $row['product_quantity'],
            "total_price" => $row['total_amount'],
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