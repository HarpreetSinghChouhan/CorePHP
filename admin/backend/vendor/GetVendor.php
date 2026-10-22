<?php
if($_SERVER["REQUEST_METHOD"] != "GET"){
    echo json_encode(["error"=>"Something are Wrong"]);
    exit;
}
require_once __DIR__ . '/../../../config/database.php';
require './../verify.php';

header('Content-Type: application/json');

$query  = "SELECT id, name, email, role, age, gender FROM user WHERE role='vendor' AND Is_deleted='0'";
$result = mysqli_query($conn, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
exit;
