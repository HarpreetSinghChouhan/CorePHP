<?php
// user/index.php
require_once __DIR__ . '/common/header.php';
require_once __DIR__ . '/common/sidebar.php';
$query = "SELECT "
?>
<div class="user-main">
    <?php require_once __DIR__ . '/common/navbar.php'; ?>
    <div class="user-content">
        <div class="summary-cards">
            <div class="summary-card card-purple">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-credit-card"></i></div>
                </div>
                <?php
                 $select = "SELECT Count(*) AS total_count FROM `order` WHERE user_id = '$user_id' AND is_deleted != 1 ";
                $query = mysqli_query($conn,$select);
                $orderresult = mysqli_fetch_assoc($query); 
                ?>
               <div style="display:flex;justify-content:space-between" > <p class="order-link-btn" >Perchanged Orders </p> <h3 class="order-link-btn dashboard-item-list" ><?php echo  $orderresult['total_count'] ?></h3></div>

                <!-- <h3 ><span class="order-link-btn"  ><?php// echo  $orderresult['total_count'] ?></span></h3>
                <p  ><span class="order-link-btn" >Active Orders</span></p> -->
            </div>
            <div class="summary-card card-green">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-cart-shopping"></i></div>
                </div><?php
                $select = "SELECT Count(*) AS total_count FROM `cart` WHERE user_id = '$user_id' AND is_deleted != 1 ";
                $query = mysqli_query($conn,$select);
                $cartresult = mysqli_fetch_assoc($query); 
                ?>
               <div style="display:flex;justify-content:space-between" > <p class="cart-link-btn" >Cart Item  </p> <h3 class="cart-link-btn dashboard-item-list" ><?php echo  $cartresult['total_count'] ?></h3></div>
<!-- 
                <h3  ><span class="cart-link-btn" ><?php // echo  $cartresult['total_count'] ?></span></h3>
                <p  > <span class="cart-link-btn" >  Cart Item </span></p> -->
            </div>
            <div class="summary-card card-orange">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-heart"></i></div>
                </div><?php
                $select = "SELECT Count(*) AS total_count FROM `wishlist` WHERE user_id = '$user_id' AND is_active != 1 ";
                $query = mysqli_query($conn,$select);
                $wishlistresult = mysqli_fetch_assoc($query); 
                ?>
               <div style="display:flex;justify-content:space-between" > <p class="wishlist-link-btn" >Wishlist Item </p> <h3 class="dashboard-item-list wishlist-link-btn" >  <?php echo $wishlistresult['total_count'] ?> </h3></div>

                <!-- <h3 > <span class="wishlist-link-btn"  >   <?php // echo $wishlistresult['total_count'] ?> </span></h3>
                <p ><span class="wishlist-link-btn"  >Wishlist Item </span> </p> -->
            </div>  
        </div>

        <div class="card">
            <h2>Recent Activity</h2>
            <div class="activity-item">
                <span>Your order #1042 was shipped</span>
                <span class="tag success">Shipped</span>
            </div>
            <div class="activity-item">
                <span>Profile information updated</span>
                <span class="time">2 hours ago</span>
            </div>
            <div class="activity-item">
                <span>Payment for invoice #88 is due</span>
                <span class="tag warning">Pending</span>
            </div>
            <div class="activity-item">
                <span>New message from support team</span>
                <span class="time">Yesterday</span>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/common/footer.php'; ?>
