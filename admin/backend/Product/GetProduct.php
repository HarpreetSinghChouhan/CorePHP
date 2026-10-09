<?php
include "../../../config/database.php";
session_start();
if(!isset($_SESSION['user_id'])){
    echo json_encode(["error"=>"Something Are Wrong"]);
    exit;
    }
//  print_r($conn);
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $user_id = $_SESSION['user_id'];
 $userquery = "SELECT id, role FROM user WHERE id ='$user_id' LIMIT 1 ";
 $userresult = mysqli_query($conn,$userquery);
 if(mysqli_num_rows($userresult) <= 0){
  echo json_encode(["error" => "something are wrong"]);
 exit;
 }
 $user = mysqli_fetch_assoc($userresult);
 $query = "";  
if($user['role'] == 'vendor'){
 $query = "SELECT product.id, product.name, product.price, product.sku, product.description, product.stock_quantity, product.image, product.created_at, category.name AS category_name
 FROM product INNER JOIN category ON category.id=product.category_id WHERE product.is_deleted !='1' AND product.user_id = '$user_id'"; 
} 
else if($user["role"] == 'admin'){
    $query = "SELECT product.id, product.name, product.price, product.sku, product.description, product.stock_quantity, product.image, product.created_at, category.name AS category_name
 FROM product INNER JOIN category ON category.id=product.category_id WHERE product.is_deleted !='1' ";
}
$result = mysqli_query($conn,$query);
 
 $product = [];
 while($row = mysqli_fetch_assoc($result)){
    // $product[] = $row;
    $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
    $stock = "In Stock";
    if($row["stock_quantity"] == 0){
        $stock = "Out of Stock";
     };
    $object = [   
        "stock" =>$stock,
        "id" => $row['id'],
        "name" => $row['name'],
        "category_name" => $row['category_name'],
        "sku" => $row['sku'],
        "price"=>$row['price'],
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