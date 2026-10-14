<?php
session_start();
header("Content-Type: application/json");
include "../config/database.php";
include "../config/config.php";

// $GOOGLE_CLIENT_ID = "203220989350-r3ikpbkq7p3oqluaj2o25l4dqfqq37km.apps.googleusercontent.com";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}
$input = json_decode(file_get_contents("php://input"), true);
$credential = $input["credential"] ?? "";

if ($credential == "") {
    echo json_encode(["success" => false, "message" => "Credential missing"]);
    exit;
}

$url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($credential);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($resp === false || $code !== 200) {
    echo json_encode(["success" => false, "message" => "Invalid Google token"]);
    exit;
}

$g = json_decode($resp, true);

if (($g["aud"] ?? "") !== $GOOGLE_CLIENT_ID || ($g["email_verified"] ?? "") !== "true") {
    echo json_encode(["success" => false, "message" => "Google verification failed"]);
    exit;
}

$email = mysqli_real_escape_string($conn, $g["email"]);
$name  = mysqli_real_escape_string($conn, $g["name"] ?? "User");

$query  = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Database error"]);
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {    
    $password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
    $query = "INSERT INTO user (name, email, role, password) VALUES ('$name', '$email', 'user', '$password')";

    if (!mysqli_query($conn, $query)) {
        echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($conn)]);
        exit;
    }

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' LIMIT 1");
    $user = mysqli_fetch_assoc($result);
}

$_SESSION["user_id"] = $user["id"];
$_SESSION["email"]   = $user["email"];
$_SESSION["user_name"]    = $user["name"];
echo json_encode(["success" => true, "redirect" => "/CorePHP/home.php"]);
?>