<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
// echo $email;
if(!isset($_GET["id"])){
  die("somthing are wrong");
}
$user_id = $_SESSION["user_id"];
$Select = "SELECT * FROM `user` WHERE id='$user_id' AND email='$email' AND role='admin' ";
$queryrun = mysqli_query($conn, $Select);
// print_r(mysqli_fetch_assoc($queryrun));
if(mysqli_num_rows($queryrun) == 0){
  die("Please Login as Admin");
}

?>

<div class="admin-main">
    <script src="../assets/js/cart.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
          <div class="table-header" >       
             <h1 class="center"> Cart List :- <span class="user-name" ></span></h1>
          </div>    
          <div class="cart-item" ></div>
        </div>

       
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>