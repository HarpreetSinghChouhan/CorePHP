<?php
session_start();
include '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["email"])) {
        echo json_encode(['status' => 'error', 'message' => "User can't add in Wishlist product without Login"]);
        die();
    }

    $email = mysqli_real_escape_string($conn, $_SESSION["email"]);
    $id = (int) $_POST["product_id"];

    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        die();
    }

    $query = "SELECT id, role FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        die();
    }
    if ($user["role"] != "user") {
        echo json_encode(['status' => 'error', 'message' => "Admin can't able to wishlist Product "]);
        die();
    }
    $user_id = $user["id"];

    $query = "SELECT id FROM product WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        die();
    }

    $query = "SELECT id ,is_active FROM wishlist WHERE user_id = '$user_id' AND product_id = '$id'";
    $result = mysqli_query($conn, $query);
    $existing = mysqli_fetch_assoc($result);
   
        if ($existing) {
         $isactive =  $existing["is_active"];
    $isactivevalue = 0;
    if($isactive == 0){
        $isactivevalue = 1; 
    }
    else{
        $isactivevalue = 0;
    }
        $query = "UPDATE `wishlist` SET is_active='$isactivevalue' WHERE id = '{$existing['id']}'";
        mysqli_query($conn, $query);
         $query2 = "SELECT * FROM `wishlist` WHERE id = '{$existing['id']}'";
         $mysqlresult = mysqli_query($conn,$query2);
          $wishlist =  mysqli_fetch_assoc($mysqlresult);
          if($wishlist["is_active"] == 1){
        echo json_encode([
            'status' => 'success',
            'action' => 'removed',
            'message' => 'Product removed from Wishlist!'
        ]);}
        else{
        echo json_encode([
            'status' => 'success',
            'action' => 'added',
            'message' => 'Product added in Wishlist successfully!'
        ]);
        }

    } else {
        $query = "INSERT INTO `wishlist` (user_id, product_id) VALUES ('$user_id', '$id')";
        mysqli_query($conn, $query);

        echo json_encode([
            'status' => 'success',
            'action' => 'added',
            'message' => 'Product added in Wishlist successfully!'
        ]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>