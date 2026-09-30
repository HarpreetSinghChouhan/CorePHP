<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
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