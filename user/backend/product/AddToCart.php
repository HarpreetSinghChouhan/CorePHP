<?php
session_start();
include '../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION["email"])) {
        echo "Please login first";
        die();
    }
    $email = mysqli_real_escape_string($conn, $_SESSION["email"]);
    $id = (int) $_POST["product_id"];

    if ($id <= 0) {
        echo "Invalid product";
        die();
    }

    $query = "SELECT id FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo "User not found";
        die();
    }
    $user_id = $user["id"];

    $query = "SELECT id FROM product WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found";
        die();
    }

    $query = "SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$id'";
    $result = mysqli_query($conn, $query);
    $existing = mysqli_fetch_assoc($result);

    if ($existing) {
        $newQty = $existing["quantity"] + 1;
        $query = "UPDATE cart SET quantity = '$newQty' WHERE id = '{$existing['id']}'";
        mysqli_query($conn, $query);
        echo "Quantity Increase";
    } else {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$id', 1)";
        mysqli_query($conn, $query);
            $query2 = "SELECT COUNT(*) AS cnt FROM cart WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $query2);
            $cart_row = mysqli_fetch_assoc($cart_result);
            $cart_count = $cart_row['cnt'];
        echo $cart_count;
    }

} else {
    echo "Invalid request";
}
?>