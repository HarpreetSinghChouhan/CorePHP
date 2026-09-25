<?php
session_start();
include '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["email"])) {
        echo json_encode(['status' => 'error', 'message' => "User can't add product without Login"]);
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
        echo json_encode(['status' => 'error', 'message' => "Admin can't able to Add Product "]);
        die();
    }
    $user_id = $user["id"];

    $query = "SELECT id, stock_quantity FROM product WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        die();
    }
    if ($product["stock_quantity"] == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product Out Of Stock']);
        die();
    }

    $query = "SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$id'";
    $result = mysqli_query($conn, $query);
    $existing = mysqli_fetch_assoc($result);

    // $newStock = $product["stock_quantity"] - 1;
    // $productquery = "UPDATE product SET stock_quantity = '$newStock' WHERE id = '$id'";
    // mysqli_query($conn, $productquery);

    if ($existing) {
        $newQty = $existing["quantity"] + 1;
        $query = "UPDATE cart SET quantity = '$newQty' WHERE id = '{$existing['id']}'";
        mysqli_query($conn, $query);

        echo json_encode([
            'status' => 'success',
            'message' => 'Product quantity increased in cart!'
        ]);

    } else {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$id', 1)";
        mysqli_query($conn, $query);

        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart successfully!'
        ]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>