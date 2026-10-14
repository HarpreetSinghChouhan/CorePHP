<?php
include "../../../config/database.php";

if($_SERVER["REQUEST_METHOD"] === "GET"){
session_start();
$user_id = $_SESSION['user_id'];

 $query = "SELECT * FROM category WHERE is_deleted != '1' AND user_id='$user_id' ";
 $result = mysqli_query($conn,$query);
 $category = [];

 while($row = mysqli_fetch_assoc($result)){
  // edit access = $user

   $object = [    
        "id" => $row['id'],
        "name" => $row['name'],
        'created'=> $row['created_at'],
   ];
   $category[] = $object;
 };
echo json_encode($category);
 exit;
}
else{
    echo "Somthing Are Wrong";
}
?>