<?php 
session_start();
include '../../../config/database.php';
  if(!isset($_SESSION["email"])){
   die();
  }
   $email = $_SESSION["email"];

            $query = "SELECT id FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($result);

            if (!$user) {
                echo "User not found";
                die();
            }
            $user_id = $user["id"];

            $query2 = "SELECT quantity FROM cart WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $query2);
            $quantity = 0;
            while($row = mysqli_fetch_assoc($cart_result)){
                $quantity += $row["quantity"];
            }
            // $cart_row = mysqli_fetch_assoc($cart_result);
            // $cart_count = $cart_row['cnt'];
            echo $quantity;
          ?>