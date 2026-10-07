<?php
header("Content-Type: application/json; charset=utf-8");
session_start();
date_default_timezone_set("Asia/Kolkata");
include "./../../../config/database.php";  
mysqli_report(MYSQLI_REPORT_OFF);          

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
    exit;
}

$phone    = trim($_POST["PhoneNumber"] ?? "");
$email    = strtolower(trim($_POST["Email"] ?? ""));
$dob      = trim($_POST["Age"] ?? "");        
$gender   = trim($_POST["Gender"] ?? "");
$password = $_POST["Password"] ?? "";
$confirm  = $_POST["ConfirmPassword"] ?? "";
$errors = [];

if (!preg_match('/^[6-9][0-9]{9}$/', $phone)) {
    $errors["PhoneNumber"] = "Enter a valid 10-digit mobile number.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["Email"] = "Enter a valid email address.";
}

$birth = DateTime::createFromFormat("Y-m-d", $dob);
if (!$birth) {
    $errors["Age"] = "Select your date of birth.";
} else {
    $age = $birth->diff(new DateTime())->y;
    if ($age < 18) {
        $errors["Age"] = "You must be at least 18 years old.";
    }
}

if ($gender != "Male" && $gender != "Female" && $gender != "Other") {
    $errors["Gender"] = "Select your gender.";
}

if (strlen($password) < 8) {
    $errors["Password"] = "Use at least 8 characters.";
}

if ($password !== $confirm) {
    $errors["ConfirmPassword"] = "Passwords do not match.";
}

if (!empty($errors)) {
    echo json_encode(["status" => "error", "errors" => $errors]);
    exit;
}
$email_safe  = mysqli_real_escape_string($conn, $email);
$phone_safe  = mysqli_real_escape_string($conn, $phone);
$dob_safe    = mysqli_real_escape_string($conn, $dob);
$gender_safe = mysqli_real_escape_string($conn, $gender);
$hash        = password_hash($password, PASSWORD_DEFAULT);

$result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email_safe' LIMIT 1");
if (!$result) {
    echo json_encode(["status" => "error", "message" => "Database error."]);
    exit;
}
if (mysqli_num_rows($result) > 0) {
    $errors["Email"] = "This email is already registered.";
}

$result = mysqli_query($conn, "SELECT phonenumber FROM user WHERE phonenumber = '$phone_safe' LIMIT 1");
if (!$result) {
    echo json_encode(["status" => "error", "message" => "Database error."]);
    exit;
}
if (mysqli_num_rows($result) > 0) {
    $errors["PhoneNumber"] = "This phone number is already registered.";
}

if (!empty($errors)) {
    echo json_encode(["status" => "error", "errors" => $errors]);
    exit;
}

$query = "INSERT INTO user (name, email, phonenumber, age, gender, role, password)
          VALUES ('', '$email_safe', '$phone_safe', '$dob_safe', '$gender_safe', 'vendor', '$hash')";

if (mysqli_query($conn, $query)) {
    $_SESSION["register_user_id"] = mysqli_insert_id($conn);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Could not create your account. Please try again."]);
}