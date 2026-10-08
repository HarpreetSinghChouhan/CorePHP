<?php
 include "./../../../config/database.php";
 include "./../verify.php";

if($_SERVER["REQUEST_METHOD"] != "GET"){
    echo json_encode(["error" => "Method Not Allowed)"],405);
    die();
}
 $email = mysqli_real_escape_string($conn,$_SESSION['email']);
 $query = "SELECT id, email, role FROM `user` WHERE email='$email'";
 $queryresult = mysqli_query($conn,$query);
 $result = mysqli_fetch_assoc($queryresult);
 $userrole = $result["role"];
 if($userrole === "admin"){
    $selectwishlist = "SELECT w.*, Count(u.id) AS wishlist_item, 
        u.id AS user_id, u.email, u.name AS user_name,
        p.id AS p_id, p.sku, p.description,p.price 
        FROM `wishlist` AS w 
        LEFT JOIN `product` AS p 
        ON p.id = w.product_id
        LEFT JOIN `user` AS u 
        ON u.id = w.user_id 
        WHERE w.is_active != '1'
        GROUP BY u.id, u.email";
        $resultwishlist = mysqli_query($conn,$selectwishlist);
         $data = [];
   while ($row =  mysqli_fetch_assoc($resultwishlist)){
      $object = [
        "user_id" => $row["user_id"],
        "username" => $row["user_name"],
        "useremail" => $row["email"],
        "total_item" => $row["wishlist_item"],
      ];
       $data [] = $object;
 }
 echo json_encode($data);
 exit;
 }
 else{
     echo json_encode(["error" => "Access Denied"],403);
     exit;
 }


?>
