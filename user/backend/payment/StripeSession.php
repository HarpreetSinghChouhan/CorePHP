<?php
session_start();
include "../../../config/config.php";
if($_SERVER['REQUEST_METHOD'] !== "POST" || !$_SESSION['email']){
    echo json_encode(["error"=>"Request Are Invalid"]);
die();
}
else{
$price = $_POST['price'];
$itemQuantity = $_POST['item'];
$Email = $_SESSION['email'];
$data = [
    'payment_method_types[]' => 'card',
    'line_items[0][price_data][currency]' => 'usd',
    'line_items[0][price_data][product_data][name]' => 'Test Product',
    'line_items[0][price_data][unit_amount]' => $price,
    'line_items[0][quantity]' => 1,
    'customer_email' => $Email,
    'mode' => 'payment',
    'success_url' => 'http://localhost/CorePHP/user/backend/payment/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/CorePHP/cancel.php',
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Authorization: Bearer $secret_key\r\n" .
                     "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data),
        'ignore_errors' => true,
    ],
];

$context = stream_context_create($options);
$response = file_get_contents('https://api.stripe.com/v1/checkout/sessions', false, $context);
$session = json_decode($response, true);

header('Content-Type: application/json');

if (isset($session['url'])) {
    echo json_encode(['success' => true, 'url' => $session['url']]);
} else {
    echo json_encode(['success' => false, 'error' => $session]);
}
exit;
}