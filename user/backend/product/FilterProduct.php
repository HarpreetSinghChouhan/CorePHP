    <?php
    include "../../../config/database.php";
    session_start();
    $user_id = $_SESSION["user_id"] ?? 0;   
    //  print_r($conn);
    if($_SERVER["REQUEST_METHOD"] === "POST"){
    //  $query = "SELECT * FROM product WHERE is_deleted != '1' ";
    // 
    $search = $_POST["search"] ?? "";       
    $query = "SELECT p.id, p.name, p.price, p.sku, p.description, p.stock_quantity, p.image, p.created_at,
    category.name AS category_name,
    w.user_id,w.product_id, w.id AS wishlist_id , w.is_active
    FROM `product` AS p
    INNER JOIN `category` 
    ON category.id=p.category_id 
    LEFT JOIN  `wishlist` AS w
    ON w.product_id = p.id AND
    w.user_id = '$user_id' AND w.is_active != '1'
    WHERE p.is_deleted !='1'  AND (
    p.name LIKE '%$search%'
    OR category.name LIKE '%$search%'
    OR p.price LIKE '%$search%'
    OR p.description LIKE '%$search%' )
    ORDER BY CASE WHEN p.name LIKE '%$search%' THEN 1
    WHEN category.name LIKE '%$search%' THEN 2
    WHEN p.price LIKE '%$search%' THEN 3 
    WHEN p.description LIKE '%$search%' THEN 4
    ELSE 5 END";

    $result = mysqli_query($conn,$query);
    
    $product = [];
    
        //   echo "<pre>";
    while($row = mysqli_fetch_assoc($result)){
        $base64Image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
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