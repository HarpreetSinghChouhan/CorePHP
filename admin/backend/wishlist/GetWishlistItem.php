<?php
 include "./../../../config/database.php";
 include "./../verify.php";

if($_SERVER["REQUEST_METHOD"] != "GET"){
    echo json_encode(["error" => "Method Not Allowed)"],405);
    die();
}
  if(!isset($_GET["id"])){
     echo json_encode(["error" => "Somthing Are Wrong)"],405);
    die();
  }
  else{
 $email = mysqli_real_escape_string($conn,$_SESSION['email']);
 $userid  = $_GET["id"] ?? "";
 $userselect = "SELECT id FROM `user` WHERE id = '$userid' ";
 $userresult = mysqli_query($conn,$userselect);
       if(mysqli_fetch_assoc($userresult) == 0){
        echo json_encode(["error" => "user are not exited"]);
        exit;
        }
        else{
 $query = "SELECT id, email, role FROM `user` WHERE email='$email'";
 $queryresult = mysqli_query($conn,$query);
 $result = mysqli_fetch_assoc($queryresult);
 $userrole = $result["role"];
 if($userrole === "admin"){
    $selectwishlist = "SELECT w.*, Count(u.id) AS wishlist_item, 
        u.id AS user_id, u.email, u.name AS user_name,
        p.id AS p_id, p.sku, p.description,p.price,p.name AS product_name,p.image
        FROM `wishlist` AS w 
        LEFT JOIN `product` AS p 
        ON p.id = w.product_id
        LEFT JOIN `user` AS u 
        ON u.id = w.user_id 
        WHERE w.user_id='$userid' AND w.is_active != '1'
        GROUP BY w.id" ;
        $resultwishlist = mysqli_query($conn,$selectwishlist);
        // echo "<pre>";
   while ($row =  mysqli_fetch_assoc($resultwishlist)){
    $image = !empty($row['image'])
        ? 'data:image/jpeg;base64,' . base64_encode($row['image'])
        : null;
      $object = [
         "product_name" => $row["product_name"],
        "username" => $row["user_name"],
        "useremail" => $row["email"],
        "total_item" => $row["wishlist_item"],
        "product_price" => $row["price"],
        "description" => $row["description"],
        "product_sku" => $row["sku"],
        "product_image" => $image,
      ];
       $data [] = $object;
    //    print_r($row);
 }
//  echo "</pre>";
 echo json_encode($data);
 exit;
 }
 else{
     echo json_encode(["error" => "Access Denied"],403);
     exit;
 }
}
  }
?>
