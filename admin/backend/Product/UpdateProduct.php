<?php

include "../../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['ProductName'] ?? '';
    $id = $_POST['ProductId'] ?? '';
    $sku = $_POST['ProductSku'] ?? '';
    $price = $_POST['Price'] ?? '';
    $quantity = $_POST['ProductQuantity'] ?? '';
    $description = $_POST['Description'] ?? '';
    $categoryname = $_POST['ProductCategory'] ?? '';

    $query = "SELECT * FROM product WHERE id ='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die(mysqli_error($conn));
    }else {
        $product = mysqli_fetch_assoc($result);
       
        $query = "SELECT * FROM category WHERE name='$categoryname' AND is_deleted != 1 LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0) {
            echo "Category Not Found";
            exit;
        }

        $cat_name = mysqli_fetch_assoc($result);
        $cat_id = $cat_name['id'];
        $image = '';
        $query = '';
        // print_r($_FILES['ProductImage']);
        // die();
        if($_FILES['ProductImage']['name'] === ''){
          $query = "UPDATE product SET category_id = '$cat_id', name='$name', price = '$price', sku = '$sku', description ='$description' , stock_quantity = '$quantity' WHERE id='$id'";
         }
       else if (isset($_FILES['ProductImage']) && $_FILES['ProductImage']['error'] === 0) {
            $image = file_get_contents($_FILES['ProductImage']['tmp_name']);
            $image = mysqli_real_escape_string($conn, $image);
            $query = "UPDATE product SET category_id = '$cat_id', name='$name', price = '$price', sku = '$sku', description ='$description' , stock_quantity = '$quantity',  image = '$image' WHERE id='$id'";
                    
            }
 
        // $query = "UPDATE product SET category_id = '$cat_id', name='$name', price = '$price', sku = '$sku', description ='$description' , stock_quantity = '$quantity',  image = '$image' WHERE id='$id'";
     
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