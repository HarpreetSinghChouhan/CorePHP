<?php 

// admin/navbar.php ?>
<header class="admin-navbar">
    <div class="search-box">
        <input type="text" placeholder="Search anything...">
    </div>
    <div class="navbar-right">
        <span class="pointer-curser" ><i class="fa-solid fa-bell"></i>
                        <!-- <span class="badge"></span> -->
        </span>
        <span class="pointer-curser" ><i class="fa-regular fa-envelope"></i>
            <!-- <span class="badge"></span> -->
        </span>
        <div class="admin-profile" class="pointer-curser" >
            <div class="avatar pointer-curser"><?php  echo strtoupper(substr($_SESSION['email'], 0, 1)); ?></div>
            <div class="pointer-curser" >
                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                <!-- <span class="role-tag">Admin</span> -->
            </div>
        </div>
    </div>
</header>
