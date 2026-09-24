<?php
session_start();
include "../../../config/config.php";
include "../../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST" || !isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Request Are Invalid"]);
    exit;
}

  $user_id = (int) $_POST["user_id"]; 
// $user_id = (int) $_SESSION['user_id']; 
$Email   = $_SESSION['email'];

$query  = "SELECT product_id, quantity FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

$totalprice = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $product_id      = (int)$row['product_id'];
    $productquantity = (int) $row['quantity'];
    $productquery  = "SELECT id, price FROM product WHERE id = '$product_id'";
    $productresult = mysqli_query($conn, $productquery);
    $product = mysqli_fetch_assoc($productresult);

    if ($product) {
        $totalprice += $product['price'] * $productquantity;
    }
}

if ($totalprice <= 0) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "error" => "Cart is empty or invalid"]);
    exit;
}

$data = [
    'payment_method_types[]' => 'card',
    'line_items[0][price_data][currency]' => 'inr',
    'line_items[0][price_data][product_data][name]' => 'Test Product',
    'line_items[0][price_data][unit_amount]' => $totalprice * 100,
    'line_items[0][quantity]' => 1,
    'customer_email' => $Email,
    'mode' => 'payment',
    'success_url' => 'http://localhost/CorePHP/user/backend/payment/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/CorePHP/cancel.php',
];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $secret_key",
        "Content-Type: application/x-www-form-urlencoded",
    ],
    CURLOPT_TIMEOUT => 15,
]);

$response = curl_exec($ch);

header('Content-Type: application/json');

if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$session = json_decode($response, true);

if (isset($session['url'])) {
    echo json_encode(['success' => true, 'url' => $session['url']]);
} else {
    echo json_encode(['success' => false, 'error' => $session]);
}
exit;