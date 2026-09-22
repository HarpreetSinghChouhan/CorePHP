 <?php 
session_start();
include '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die();
}
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if ($id <= 0 || $quantity <= 0) {
    echo json_encode(["error" => "Invalid data"]);
    exit;
}
$cart_query = "SELECT product_id FROM cart WHERE id = '$id'";
$cart_result = mysqli_query($conn, $cart_query);
$cart_row = mysqli_fetch_assoc($cart_result);

if (!$cart_row) {
    echo json_encode(["error" => "Cart item not found"]);
    exit;
}
$product_id = $cart_row['product_id'];

$stock_query = "SELECT stock_quantity FROM product WHERE id = '$product_id'";
$stock_result = mysqli_query($conn, $stock_query);
$stock_row = mysqli_fetch_assoc($stock_result);

if (!$stock_row) {
    echo json_encode(["error" => "Product not found"]);
    exit;
}
$available_stock = (int)$stock_row['stock_quantity'];

$limited = false;
if ($quantity > $available_stock) {
    $quantity = $available_stock;
    $limited = true;
}

$update_query = "UPDATE cart SET quantity = '$quantity' WHERE id = '$id'";
mysqli_query($conn, $update_query);

echo json_encode([
    "quantity" => $quantity,
    "limited" => $limited,
    "available_stock" => $available_stock
]);
?>