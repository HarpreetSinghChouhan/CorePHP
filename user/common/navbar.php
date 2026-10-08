<?php // user/navbar.php ?>
<header class="user-navbar">
    <div class="welcome-text">
        <h2>Welcome back, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?> 👋</h2>
        <span><?php echo date('l, d F Y'); ?></span>
    </div>
    <div class="navbar-right">
        <div class="icon-btn"><i class="fa-solid fa-bell"></i></div>
         <?php 
            $user_id = $_SESSION["user_id"];

            $query2 = "SELECT quantity FROM cart WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $query2);
            $quantity = 0;
            while($row = mysqli_fetch_assoc($cart_result)){
                $quantity += $row["quantity"];
            }
         ?>
        <!-- <div class="header-card-button cart-link " > <div class="icon-btn"><i class="fa-solid fa-cart-shopping"></i> </div><span class="count-ui  cart-count" > <?php echo $quantity ?></span> </div> -->
      <div class="header-card-button cart-link">
    <div class="icon-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <?php  //if ($quantity > 0): ?>
            <span class="cart-count"><?php echo $quantity > 99 ? '99+' : $quantity; ?></span>
        <?php // endif; ?>
    </div>
</div>

        <div class="icon-btn"><i class="fa-solid fa-search"></i></div>
        <a href="<?php echo $site ?>home.php" style="text-decoration:none" >
        <div class="icon-btn"><i class="fa-solid fa-home"></i></div>
    </a>
    </div>
</header>
