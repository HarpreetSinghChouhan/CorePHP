<?php
include "../includes/header.php";
include "../config/database.php";
session_start();
$email = $_SESSION['email'];
// echo $email;
if(!isset($email)){
    header("Location:  http://localhost/harpreet_task/login.php");
    exit;
}
  $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn,$query);
     if(!$result){
    header("Location:  http://localhost/harpreet_task/login.php");   
    exit;
     }
     else if(mysqli_num_rows($result) > 0){
             $user = mysqli_fetch_assoc($result);
            $username = $user["name"];
     }
// echo "Admin Dashboard";
?>
<body>
    

<main>
    <div  class="container" >
    <div>
        <a href="../auth/logout.php" class="logout-link" > Log Out</a>
    </div>
 <div>
    <h1>Welcome <?php echo "$username" ?></h1>
 </div>
</div>
</main>
</body>
<?php 
include "../includes/footer.php";
?>