    <?php
    include "../../../config/database.php";
    session_start();
    $user_id = $_SESSION["user_id"] ?? 0;   
    //  print_r($conn);
    if($_SERVER["REQUEST_METHOD"] === "GET"){
    //  $query = "SELECT * FROM product WHERE is_deleted != '1' ";
    // 
     
    $query = "SELECT product.id, product.name, product.price,product.image_url, product.sku, product.description, product.stock_quantity, product.image, product.created_at,
    category.name AS category_name,
    w.user_id,w.product_id, w.id AS wishlist_id , w.is_active
    FROM `product` 
    INNER JOIN `category` 
    ON category.id=product.category_id 
    LEFT JOIN  `wishlist` AS w
    ON w.product_id = product.id AND
    w.user_id = '$user_id' AND w.is_active != '1'
    WHERE product.is_deleted !='1' 
    ORDER BY product.id ASC ";

    $result = mysqli_query($conn,$query);
    
    $product = [];
    
        //   echo "<pre>";
    while($row = mysqli_fetch_assoc($result)){
    if (!empty($row['image_url'])) {
        $imageSrc = '/CorePHP/public/uploads/' . $row['image_url'];
    } elseif (!empty($row['image'])) {
        $imageSrc = 'data:image/jpeg;base64,' . base64_encode($row['image']);
    } else {
        $imageSrc = '/CorePHP/public/uploads/placeholder.png';
    }
    $base64Image = $imageSrc;
        // $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        $object = [   
            "id" => $row['id'],
            "name" => $row['name'],
            "category_name" => $row['category_name'],
            "sku" => $row['sku'],
            "price"=> $row['price'],
            "description" => $row['description'],
            "stock_quantity" => $row['stock_quantity'],
            "created_at" => $row['created_at'],
            "image" => $base64Image,
            "wishlist" => $row['wishlist_id'] !== null,
    ];
        $product[] = $object;
//   print_r($row);
    }
    
//   echo "</pre>";
    echo json_encode($product);
    exit;

    }
    else{
        echo "Somthing Are Wrong";
    }
    ?>