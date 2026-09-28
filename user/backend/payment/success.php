
<?php
include "../../../config/config.php";
include "../../../config/database.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /CorePHP/login.php");
    exit;
}
if (isset($_GET['session_id'])) {
    ?>
    <style>
    ._failed{ border-bottom: solid 4px red !important; }
._failed i{  color:red !important;  }

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 450px;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}
 
 a{
    text-decoration:none;

 }
._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
</style><?php
    $session_id = $_GET['session_id'];
       $curl = curl_init();
       $options = [
         CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions/'. $session_id,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_HTTPHEADER => [
           "Authorization: Bearer $secret_key",
           "Content-Type: application/x-www-form-urlencoded",
          ],
          CURLOPT_HTTPGET => true,
          CURLOPT_TIMEOUT => 15,
    ];
     curl_setopt_array($curl,$options);
     $response = curl_exec($curl);
     if ($response === false) {
        die("Curl error: " . curl_error($curl));
        }
    // $context  = stream_context_create($options);
    //  $response = file_get_contents('https://api.stripe.com/v1/checkout/sessions/' . $session_id, false, $context);
    $session  = json_decode($response, true);
    if (isset($session['payment_status']) && $session['payment_status'] === 'paid') {
         
         $selectorder = "SELECT * FROM `order` WHERE session_id = '$session_id'";
$runorderquery = mysqli_query($conn,$selectorder);

if(mysqli_num_rows($runorderquery) == 0){

     $maxidquery = "SELECT MAX(order_id) as max_id FROM `order`";
     $maxidresult = mysqli_query($conn, $maxidquery);
     $maxidrow = mysqli_fetch_assoc($maxidresult);

     if($maxidrow['max_id'] == null){
          $order_id = 1001; 
     } else {
          $order_id = $maxidrow['max_id'] + 1;
     }

     $total_amount = $session['amount_total'] / 100;
     $user_id = $_SESSION['user_id'];

     $selectcart = "SELECT cart.product_id, cart.quantity, product.name, product.price, product.stock_quantity, product.sku
            FROM cart 
            JOIN product ON cart.product_id = product.id 
            WHERE cart.user_id = '$user_id'";
     $result = mysqli_query($conn, $selectcart);
     $product_quantity = 0;

     while ($row = mysqli_fetch_assoc($result)) {
                $product_id = (int) $row["product_id"];
                $product_sku = $row["sku"];
                $product_qty1   = (int) $row["quantity"];
                $product_name   = $row["name"];
                $product_price  = $row["price"];
                $product_quantity += $product_qty1;
                $stock = $row["stock_quantity"]-$product_qty1;
                $productquery = "UPDATE `product` SET stock_quantity='$stock' WHERE sku='$product_sku'";
                mysqli_query($conn,$productquery);
                $insertorderitem = "INSERT INTO `order_item` (order_id, product_id, user_id, product_name, product_quantity, product_price) 
                    VALUES ('$order_id','$product_id','$user_id','$product_name','$product_qty1','$product_price')";
                mysqli_query($conn, $insertorderitem);
            }

     $insertquery = "INSERT INTO `order` (order_id, user_id, total_amount, product_quantity, session_id, status) 
                     VALUES ('$order_id', '$user_id', '$total_amount', '$product_quantity', '$session_id','paid')";
     $runquery = mysqli_query($conn,$insertquery);
}
            // $selectorder = "SELECT * FROM `order` WHERE session_id = '$session_id'";
            // $runorderquery = mysqli_query($conn,$selectorder);
            // if(mysqli_num_rows($runorderquery) == 0){
            //     $order_id =  uniqid();
            //     // order 
            // $total_amount = $session['amount_total'] / 100;
            // $user_id = $_SESSION['user_id'];
            // $selectcart = "SELECT cart.product_id, cart.quantity, product.name, product.price 
            //     FROM cart 
            //     JOIN product ON cart.product_id = product.id 
            //     WHERE cart.user_id = '$user_id'";
            //             $result = mysqli_query($conn, $selectcart);
            //             $product_quantity = 0;
            //         while ($row = mysqli_fetch_assoc($result)) {
            //             $product_id     = (int) $row["product_id"];
            //             $product_qty1   = (int) $row["quantity"];
            //             $product_name   = $row["name"];
            //             $product_price  = $row["price"];
            //             $product_quantity += $product_qty1;
            //             $insertorderitem = "INSERT INTO `order_item` (order_id, product_id, user_id, product_name, product_quantity, product_price) 
            //                 VALUES ('$order_id','$product_id','$user_id','$product_name','$product_qty1','$product_price')";
            //             mysqli_query($conn, $insertorderitem);
            //         }
            // // echo  " <br/> All Product Quantity : === "  . $product_quantity;
            // $insertquery = "INSERT INTO `order` (order_id, user_id, total_amount, product_quantity,session_id,status) VALUES ('$order_id', '$user_id', '$total_amount', '$product_quantity', '$session_id','paid')";
            // $runquery = mysqli_query($conn,$insertquery);
        //  }          
        ?> 
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                     <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                   <p> Thank you for your payment. we will <br>
                      be in contact with more details shortly </p> 
                      <h3><a href="/CorePHP/home.php">Back to Home Page</a> </h3>    
            </div> 
        </div> 
    </div> 
</div> 

        <?php


          $id = $_SESSION['user_id'];
          $updateproduct = 
          $DeleteCart = "DELETE FROM cart WHERE user_id = '$id'";
          $runquery = mysqli_query($conn,$DeleteCart);
 
        // echo "<h1>Payment Successful!</h1>";
    } else {
        ?>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                     <i class="fa fa-times-circle" aria-hidden="true"></i>
                    <h2> Your payment failed </h2>
                   <p>  Try again later </p> 
                    <h3><a href="/CorePHP/home.php">Back To Home Page</a></h3>
            </div> 
        </div> 
    </div> 
        <?php
    }
} else {
    echo "<h1>No session ID found.</h1>";
}
curl_close($curl);
?>
