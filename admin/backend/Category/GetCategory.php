<?php
include "../../../config/database.php";

if($_SERVER["REQUEST_METHOD"] === "GET"){
session_start();
//   $name = $_POST['CategoryName'];
 $query = "SELECT * FROM category WHERE is_deleted != '1' ";
 $result = mysqli_query($conn,$query);
 $category = [];

 while($row = mysqli_fetch_assoc($result)){
  $cat_user = $row['user_id'];
  $userselect = "SELECT id, name FROM `user` WHERE  id='$cat_user'  LIMIT 1";
  $userresult = mysqli_query($conn, $userselect);
  $user = mysqli_fetch_assoc($userresult);
  $user_name = $user['name'] ?? 'admin' ;
  $user_id = $_SESSION['user_id'];
  // edit access = $user

   $object = [    
        "id" => $row['id'],
        "name" => $row['name'],
        "created_by" => $user_name,  
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