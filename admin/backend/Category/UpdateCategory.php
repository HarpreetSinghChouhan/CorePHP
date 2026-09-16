<?php
include "../../../config/database.php";
if($_SERVER["REQUEST_METHOD"] === "POST"){
  $name = $_POST['CategoryName'];
 $query = "SELECT * FROM category WHERE name='$name' LIMIT 1";
 $result = mysqli_query($conn,$query);
 if (!$result) {
    die(mysqli_error($conn));
}

 if(mysqli_num_rows($result) > 0){
    echo "Exited";
 }
 else{
    $query = "UPDATE  category SET name='$name' WHERE  id='$id'";
    $result = mysqli_query($conn,$query);
    if($result){
        echo "Success";
    }
    else{
        echo mysqli_error($result);
    }
 }

}
else{
    echo "Somthing Are Wrong";
}
?>