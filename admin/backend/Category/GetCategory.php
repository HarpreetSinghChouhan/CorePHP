<?php
include "../../../config/database.php";
if($_SERVER["REQUEST_METHOD"] === "GET"){
//   $name = $_POST['CategoryName'];
 $query = "SELECT * FROM category WHERE is_deleted != '1' ";
 $result = mysqli_query($conn,$query);
 $user = [];
 while($row = mysqli_fetch_assoc($result)){
   $object = [   
        "id" => $row['id'],
        "name" => $row['name'],
        'created'=> $row['created_at'],
   ];
   $user[] = $object;
 };
echo json_encode($user);
 exit;
}
else{
    echo "Somthing Are Wrong";
}
?>