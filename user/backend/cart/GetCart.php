<?php 
session_start();
include '../../../config/database.php';
 if(!isset($_SESSION["email"])){
   echo json_encode(["error" => "Session not set"]);
   die();
} 
else if(isset($_GET['id'])) {
   $email = $_SESSION["email"];
            $SelectUser = "SELECT id FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $SelectUser);
            $user = mysqli_fetch_assoc($result);
            if (!$user) {
                echo json_encode(["error" => "User Are not Found"]);
                die();
            }
            else{
                $user_id = $user['id'];
                $cart_id = $_GET['id'];
                $SelectCart = "SELECT c.id, c.quantity, c.user_id, c.product_id, p.name, p.price, p.category_id
                    p.stock_quantity, p.sku p.image, p.is_deleted, cat.name, cat.id 
                    FROM `cart` AS c 
                    INNER JOIN `product` AS p 
                    ON p.id = c.product_id
                    INNER JOIN `category` AS cat
                    ON p.category_id = cat.id
                    WHERE c.id = '$cart_id' AND c.user_id = '$user_id'";
                    $result = mysqli_query($conn, $SelectCart);
            }

  
}
else{
        echo json_encode(["error" => "Something Are Wrong "]);
    }  


