<div class="vr-main">
    <header class="vr-topbar">
        <button class="vr-burger" id="vrBurger" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="vr-welcome">
            <h1>Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Vendor') ?> 👋</h1>
            <span><?= date('l, d F Y') ?></span>
        </div>
         
            <?php  if(isset($_SESSION['admin_id'])){
                 ?> <div>
                     <button class="back-to-admin back-admin "  >back to admin</button>
                 </div><?php

            }?> 
           
        <div class="vr-top-actions">
            <button class="vr-icon-btn" aria-label="Notifications"><i class="fa-solid fa-bell"></i></button>
            <!-- <a href="/CorePHP/vendor/cart/cart.php" class="vr-icon-btn" aria-label="Cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="vr-badge">0</span> 
            </a> -->
            <a href="/CorePHP/home.php" class="vr-icon-btn" aria-label="Home"><i class="fa-solid fa-house"></i></a>
        </div>
    </header>

    <div class="vr-content">