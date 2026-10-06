<?php 

if (!function_exists('isActivePage')) {
    function isActivePage($match) {
        $script = $_SERVER['SCRIPT_NAME'];
        $pos = strpos($script, '/user/');
        if ($pos === false) {
            return '';
        }
        $relative = substr($script, $pos + strlen('/user/'));
        if (substr($match, -1) === '/') {
            return (strpos($relative, $match) === 0) ? 'active' : '';
        }
        return ($relative === $match) ? 'active' : '';
    }
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
        <li>
            <a href="<?php echo $site; ?>user/index.php" class="<?php echo isActivePage('index.php'); ?>">
                <span class="icon"><i class="fa-solid fa-house"></i></span> Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo $site; ?>user/profile.php" class="<?php echo isActivePage('profile.php'); ?>">
                <span class="icon"><i class="fa-solid fa-user"></i></span> My Profile
            </a>
        </li>
        <li>
            <a href="<?php echo $site; ?>user/order/orders.php" class="<?php echo isActivePage('order/'); ?>">
                <span class="icon"><i class="fa-solid fa-list"></i></span> My Orders
            </a>
        </li>
         <li>
            <a href="<?php echo $site; ?>user/cartitem/cartitem.php" class="<?php echo isActivePage('cartitem/'); ?>">
                <span class="icon"><i class="fa-solid fa-list"></i></span> Cart Item
            </a>
        </li>
        <li>
            <a href="<?php echo $site; ?>user/wishlist/wishlist.php" class="<?php echo isActivePage('wishlist/'); ?>">
                <span class="icon"><i class="fa-solid fa-heart"></i></span> Wishlist Item
            </a>
        </li>
        <li>
            <a href="/CorePHP/auth/logout.php">
                <span class="icon"><i class="fa fa-sign-out"></i></span> Logout
            </a>
        </li>
    </ul>
</aside>