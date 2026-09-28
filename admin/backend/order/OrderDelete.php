<?php
include "../../../config/database.php";
include "../verify.php";

if($_SERVER["REQUEST_METHOD"] != "DELETE" || $_GET['id'] == ''){
    echo json_encode(["error"=> "something Are Wrong"]);
}
else{
    $id = (int) $_GET['id'];

    $query = "UPDATE `order` SET is_deleted = '1' WHERE order_id = '$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "success";
    } else {
        echo "error while deleting";
    }
}