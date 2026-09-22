
<?php
include "../../../config/config.php";
include "../../../config/database.php";
session_start();
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
       
    $options = [
        'http' => [
            'method'  => 'GET',
            'header'  => "Authorization: Bearer $secret_key\r\n",
            'ignore_errors' => true,
        ],
    ];
    $context  = stream_context_create($options);
     $response = file_get_contents('https://api.stripe.com/v1/checkout/sessions/' . $session_id, false, $context);



    $session  = json_decode($response, true);
    if (isset($session['payment_status']) && $session['payment_status'] === 'paid') {
        // print_r($session);
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
       
          $email = $_SESSION['email'];
          $SelectUser = "SELECT * FROM user WHERE email = '$email'";
          $result = mysqli_query($conn,$SelectUser);
          $user = mysqli_fetch_assoc($result);
          $id = $user['id'];
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
        // echo "<h1>Payment Verification Failed!</h1>";
        // print_r($session); 
    }
} else {
    echo "<h1>No session ID found.</h1>";
}
?>
