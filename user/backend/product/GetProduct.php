<?php
include "../../../config/database.php";
//  print_r($conn);
if($_SERVER["REQUEST_METHOD"] === "GET"){
//  $query = "SELECT * FROM product WHERE is_deleted != '1' ";
 // 
 $query = "SELECT product.id, product.name, product.price, product.sku, product.description, product.stock_quantity, product.image, product.created_at, category.name AS category_name
 FROM product INNER JOIN category ON category.id=product.category_id WHERE product.is_deleted !='1' ";
 $result = mysqli_query($conn,$query);
 
 $product = [];
 while($row = mysqli_fetch_assoc($result)){
    $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
    $object = [   
        "id" => $row['id'],
        "name" => $row['name'],
        "category_name" => $row['category_name'],
        "sku" => $row['sku'],
        "price"=> $row['price'],
        "description" => $row['description'],
        "stock_quantity" => $row['stock_quantity'],
        "created_at" => $row['created_at'],
        "image" => $base64Image,
   ];
    $product[] = $object;
    
 }
echo json_encode($product);
 exit;

}
else{
    echo "Somthing Are Wrong";
}
?>