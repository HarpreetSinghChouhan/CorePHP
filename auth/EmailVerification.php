<?php
include "../config/database.php";
include "../model/randomcode.php";

require '../PHPMailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// print_r($conn);
if($_SERVER["REQUEST_METHOD"]=="POST"){
    // print_r($_POST["Email"]);
    $email = $_POST["Email"];
    $query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
if (!$result) {
        echo "Database error: " . mysqli_error($conn);
        exit;
    }
    // 

    if (mysqli_num_rows($result) > 0) {

        $user = mysqli_fetch_assoc($result);
        // print_r($user["password"]);
        $token = generateToken(18);
         $query = "UPDATE user SET token='$token' WHERE email='$email' LIMIT 1"; 
         $update = mysqli_query($conn,$query);
        echo  "check Your Email Send PasswordForget Link On Mail";
            
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'harpreeteligocs@gmail.com';
            $mail->Password   = 'pxzl oorn lslb fwwj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->setFrom('youremail@gmail.com', 'Harpreet Task');
            $mail->addAddress($email);
            $resetLink = "http://localhost/harpreet_task/resetpassword.php?email=". $email ."&token=" . $token;
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Hi,<br><br>Click the link below to reset your password:<br>
                              <a href='$resetLink'>$resetLink</a><br><br>
                              If you didn't request this, ignore this email.";

            $mail->send();
            echo "Check your email — password reset link has been sent.";

        } catch (Exception $e) {
            echo "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email Are Not Correct";
    }
}
// echo "working";
?>