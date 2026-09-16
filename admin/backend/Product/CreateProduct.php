<?php

include "../../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['ProductName'] ?? '';
    $sku = $_POST['ProductSku'] ?? '';
    $price = $_POST['Price'] ?? '';
    $quantity = $_POST['ProductQuantity'] ?? '';
    $description = $_POST['Description'] ?? '';
    $categoryname = $_POST['ProductCategory'] ?? '';

    $query = "SELECT * FROM product WHERE sku='$sku'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        echo "Exited";

    } else {

        $query = "SELECT * FROM category WHERE name='$categoryname' AND is_deleted != 1 LIMIT 1";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            echo "Category Not Found";
            exit;
        }

        $cat_name = mysqli_fetch_assoc($result);
        $cat_id = $cat_name['id'];

        $image = "";

        if (isset($_FILES['ProductImage']) && $_FILES['ProductImage']['error'] === 0) {
            $image = file_get_contents($_FILES['ProductImage']['tmp_name']);
            $image = mysqli_real_escape_string($conn, $image);
        }

        $query = "INSERT INTO product
        (category_id, name,price, sku, description, stock_quantity,  image)
        VALUES
        ('$cat_id', '$name','$price', '$sku', '$description', '$quantity', '$image')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Success";
        } else {
            echo mysqli_error($conn);
        }
    }

} else {
    echo "Something Are Wrong";
}
?>