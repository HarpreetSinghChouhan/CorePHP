<?php // user/sidebar.php 
function isActivePage($page) {
    $currentPage = basename($_SERVER['PHP_SELF']);
    return ($currentPage === $page) ? 'active' : '';
}
?>
<aside class="user-sidebar">
    <div class="brand">MyApp</div>

    <div class="user-mini-profile">
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></div>
        <div>
            <div class="name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
            <div class="role">Member</div>
        </div>
    </div>

    <ul>
        <li><a href="<?php echo $site ?>user/index.php"  class="<?php  echo isActivePage('index.php') ?>" ><span class="icon"><i class="fa-solid fa-house"></i></span> Dashboard</a></li>      
         <li><a href="<?php echo $site ?>user/profile.php" class="<?php  echo isActivePage('profile.php'); ?>"><span class="icon"><i class="fa-solid fa-user"></i></span> My Profile</a></li>
        <li><a href="<?php echo $site ?>user/order/orders.php" class="<?php  echo isActivePage('orders.php'); ?>"><span class="icon"><i class="fa-solid fa-list"></i></span> My Orders</a></li>
        <!-- <li><a href="messages.php" class="<?php // echo isActivePage('messages.php'); ?>"><span class="icon">&#128172;</span> Messages</a></li> -->
        <!-- <li><a href="settings.php" class="<?php // echo isActivePage('settings.php'); ?>"><span class="icon">&#9881;</span> Settings</a></li> -->
        <li><a href="/CorePHP/auth/logout.php"><span class="icon"></span><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
</aside>
