<?php
include "../config/database.php";
// print_r($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id     = $_POST["id"]     ?? '';
    $name   = $_POST["name"]   ?? '';
    $email  = $_POST["email"]  ?? '';
    $phone = $_POST["phone"] ?? '';
    $age    = $_POST["age"]    ?? ''; 
    $gender = $_POST["gender"] ?? '';

    if ($id === '' || $phone == '' || $name === '' || $email === '' || $age === '' || $gender === '') {
        echo "All fields are required";
        exit;
    } 
     
    $dob =  new DateTime($age,$timezone);
      $newdate = $date->format('Y-m-d');
    $diff = date_diff($date,$dob);
    $year = $diff->y;
    if($year <= 18){
    echo "AgeWrong";
    exit;
    }
    $query = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query($conn,$query);
    $data = mysqli_fetch_assoc($result);
    if($data['email'] !== $email ){
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn,$query);
        // $data = mysqli_fetch_assoc($result);
         $row = mysqli_num_rows($result); 
         print_r($row); 
         if($row < 0){
            echo "Email-Exited";
            exit;
         }
         else{
        echo "Same Email Address new $email  old " . $data["email"];
        exit;
    }
    };
    
    $changePassword = isset($_POST["ChangePassword"]);
    $password = $_POST["Password"] ?? '';

    if ($changePassword && trim($password) !== '') {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          
        $query = "UPDATE user
                  SET name='$name', email='$email', phonenumber='$phone',  age='$age', gender='$gender', password='$hashedPassword'
                  WHERE id='$id'";

    } else {

        $query = "UPDATE user
                  SET name='$name', email='$email', age='$age', phonenumber='$phone', gender='$gender'
                  WHERE id='$id'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success ";
    } else {
        echo "Something went wrong: " . mysqli_error($conn);
    }

} else {
    echo "this is not correct";
}
?>