<?php
include "../../../config/database.php";
//  print_r($conn);
if($_SERVER["REQUEST_METHOD"] === "POST"){
  $name = $_POST['CategoryName'];
 $query = "SELECT * FROM category WHERE name='$name'";
 $result = mysqli_query($conn,$query);
 if(mysqli_num_rows($result) > 0){
    echo "Exited";
 }
 else{
    $query = "INSERT INTO category (name) VALUE ('$name')";
    $result = mysqli_query($conn,$query);
    if($result){
        echo "Success";
    }
    else{
        echo mysqli_error($result);
    }
    // echo "Hello Working NOt HAve Data ";
 }

}
else{
    echo "Somthing Are Wrong";
}
?>