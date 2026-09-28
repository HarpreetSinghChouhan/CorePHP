<?php
include '../../../config/database.php';
include "../../../admin/backend/verify.php";
if($_SERVER["REQUEST_METHOD"] === "GET"){
   $user_id = (int) $_SESSION["user_id"];
    $query = "SELECT o.id, o.is_deleted, o.order_id, o.user_id, o.total_amount, o.product_quantity, o.created_at,
        u.name, u.email, u.id AS user_table_id,
        COUNT(oi.id) AS total_order_items
        FROM `order` AS o
        INNER JOIN order_item AS oi ON o.order_id = oi.order_id
        INNER JOIN user AS u ON o.user_id = u.id 
        WHERE u.id = '$user_id' AND o.is_deleted != '1'
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