<?php 
session_start();
include '../../../config/database.php';
 if(!isset($_SESSION["email"])){
   echo json_encode(["error" => "Session not set"]);
   die();
} 
  $email = $_SESSION["email"];

            $SelectUser = "SELECT id FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $SelectUser);
            $user = mysqli_fetch_assoc($result);
        //    echo json_encode($user);
            if (!$user) {
                echo json_encode(["error" => "User Are not Found"]);
                die();
            }
            $user_id = $user["id"];                                                                                       
            $cart = "SELECT cart.id AS cart_id, cart.product_id, cart.user_id, cart.quantity, 
            product.id AS product_id, product.name,product.price, product.description, product.category_id AS Product_cate_id,  product.image,
            category.name AS category_name 
            FROM cart 
            INNER JOIN product ON product.id = cart.product_id 
            INNER JOIN category ON category.id = product.category_id WHERE cart.user_id='$user_id'";
            $result = mysqli_query($conn,$cart);
            // echo json_encode($result);
             $cart = [];
            while($row = mysqli_fetch_assoc($result)){
                
    $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
                // print_r($row);
                   $object = [
                   "id" => $row["cart_id"], 
                   "name" => $row["name"],
                   "price" => $row["price"],
                    "description" => $row["description"],
                    "category_name" => $row["category_name"],
                    "image" => $base64Image,
                    "quantity" => $row["quantity"],
                   ];
                   $cart[] = $object;
                   }
            echo json_encode($cart);
            exit;
?>