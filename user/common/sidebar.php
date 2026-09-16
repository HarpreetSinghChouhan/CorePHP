<?php // user/sidebar.php ?>
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
        <li><a href="index.php" ><span class="icon"><i class="fa-solid fa-house"></i></span> Dashboard</a></li>      
         <li><a href="profile.php" class="<?php // echo isActivePage('profile.php'); ?>"><span class="icon"><i class="fa-solid fa-user"></i></span> My Profile</a></li>
        <!-- <li><a href="orders.php" class="<?php // echo isActivePage('orders.php'); ?>"><span class="icon">&#128179;</span> My Orders</a></li> -->
        <!-- <li><a href="messages.php" class="<?php // echo isActivePage('messages.php'); ?>"><span class="icon">&#128172;</span> Messages</a></li> -->
        <!-- <li><a href="settings.php" class="<?php // echo isActivePage('settings.php'); ?>"><span class="icon">&#9881;</span> Settings</a></li> -->
        <li><a href="/harpreet_task/auth/logout.php"><span class="icon"></span><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
</aside>
