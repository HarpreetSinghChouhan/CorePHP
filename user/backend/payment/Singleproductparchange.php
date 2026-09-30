<?php
session_start();
include "../../../config/config.php";
include "../../../config/database.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== "POST" || !isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "error" => "Request Are Invalid"]);
    exit;
}

$id    = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$Email = $_SESSION['email'];

if ($id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid product id"]);
    exit;
}

/* ---------- Product fetch (prepared statement) ---------- */
$stmt = mysqli_prepare($conn, "SELECT id, name, sku, price, stock_quantity FROM product WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row    = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$row) {
    echo json_encode(["success" => false, "error" => "Product not found"]);
    exit;
}

$productId       = (int) $row['id'];
$productName     = $row['name'];
$productSku      = $row['sku'];
$productStock    = (int) $row['stock_quantity'];
$productQuantity = 1;

if ($productStock < $productQuantity) {
    echo json_encode([
        "success" => false,
        "error"   => "$productName stock quantity is $productStock"
    ]);
    exit;
}

$unitAmount = (int) round($row['price'] * 100); // paise

if ($unitAmount <= 0) {
    echo json_encode(["success" => false, "error" => "Product is invalid or price is zero"]);
    exit;
}

/* ---------- (Optional) Order pehle DB me bana lo ----------
   Isse asli order_id milega. Agar orders table hai to use karo:

$userId = (int) ($_SESSION['user_id'] ?? 0);
$status = 'pending';
$ostmt  = mysqli_prepare($conn, "INSERT INTO orders (user_id, product_id, amount, status) VALUES (?, ?, ?, ?)");
$amount = $unitAmount / 100;
mysqli_stmt_bind_param($ostmt, "iids", $userId, $productId, $amount, $status);
mysqli_stmt_execute($ostmt);
$orderId = mysqli_insert_id($conn);
mysqli_stmt_close($ostmt);
*/
$orderId = 0; // orders table ho to upar wala code uncomment karo aur ye line hata do

/* ---------- Stripe data ---------- */
$data = [
    'payment_method_types[]' => 'card',
    'mode'                   => 'payment',
    'customer_email'         => $Email,
    'client_reference_id'    => (string) $orderId,

    // Line item
    'line_items[0][price_data][currency]'                           => 'inr',
    'line_items[0][price_data][unit_amount]'                        => $unitAmount,
    'line_items[0][price_data][product_data][name]'                 => $productName,
    'line_items[0][price_data][product_data][metadata][product_id]' => (string) $productId,
    'line_items[0][price_data][product_data][metadata][sku]'        => (string) $productSku,
    'line_items[0][quantity]'                                       => $productQuantity,

    // Checkout Session metadata
    'metadata[order_id]'   => (string) $orderId,
    'metadata[product_id]' => (string) $productId,
    'metadata[sku]'        => (string) $productSku,

    // PaymentIntent metadata (Stripe dashboard me Payment par dikhega)
    'payment_intent_data[metadata][order_id]'   => (string) $orderId,
    'payment_intent_data[metadata][product_id]' => (string) $productId,
    'payment_intent_data[metadata][sku]'        => (string) $productSku,
    'payment_intent_data[description]'          => "Order #$orderId - $productName",

    'success_url' => 'http://localhost/CorePHP/user/backend/payment/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url'  => 'http://localhost/CorePHP/cancel.php',
];

/* ---------- Stripe API call ---------- */
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => 'https://api.stripe.com/v1/checkout/sessions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($data),
    CURLOPT_HTTPHEADER     => [
        "Authorization: Bearer $secret_key",
        "Content-Type: application/x-www-form-urlencoded",
    ],
    CURLOPT_TIMEOUT        => 15,
]);

$response = curl_exec($ch);

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
    echo json_encode(['success' => false, 'error' => $session['error']['message'] ?? $session]);
}
exit;