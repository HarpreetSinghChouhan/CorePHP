<?php
// user/index.php
require_once  './../common/header.php';
require_once  './../common/sidebar.php';
// require "";
?>
<div class="user-main">
    <?php require_once './../common/navbar.php'; ?>
 <script src="./../assets/js/order.js" defer ></script>

    <div class="user-content">
        <div class="summary-cards">
            <div class="summary-card card-purple">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-clipboard-list"></i></div>
                </div>
               
               <div style="display:flex;justify-content:space-between" > <p>Perchanged Orders </p> <h3 class="total-order dashboard-item-list" >0</h3></div>
            </div>
            <div class="summary-card card-green">
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-cart-shopping"></i></div>
                </div>
               <div style="display:flex;justify-content:space-between" > <p class="cart-link-btn" >Added Card Item </p> <h3 class="cart-link-btn dashboard-item-list" >0</h3></div>
            </div>
            <div class="summary-card card-orange">
                <?php
                $select = "SELECT Count(*) AS total_count FROM `wishlist` WHERE user_id = '$user_id' AND is_active != 1 ";
                $query = mysqli_query($conn,$select);
                $wishlistresult = mysqli_fetch_assoc($query); 
                ?>
                <div class="top">
                    <div class="icon-circle"><i class="fa-solid fa-heart"></i></div>
                </div>
               <div style="display:flex;justify-content:space-between" > <p class="wishlist-link-btn" >Wishlist Item </p> <h3 class="dashboard-item-list wishlist-link-btn" >  <?php echo $wishlistresult['total_count'] ?> </h3></div>
            </div>
            <!-- <div class="summary-card card-orange">
                <div class="top">
                    <div class="icon-circle"><i class="fa-regular fa-message"></i></div>
                </div>
                <h3 > <span class="wishlist-link-btn"  > </span></h3>
                <p ><span class="wishlist-link-btn"  >Wishlist Item </span> </p>
            </div> -->
        </div>

    <div class="table-div">
         <table id="order_datatable" class="display" style="width:100%">
           <thead>
            <tr>
                <th>Serial No</th>
                <th>Order Id</th>
                <th>Total Quantity</th>
                <th>Order Item</th>
                <th>Total Amount</th>
                <th>Perchanged At</th>
                <th>Action</th>
            </tr>
           </thead>
           <tbody class="order-tbody"></tbody>
         </table>
        </div>
    </div>
<?php require_once './../common/footer.php'; ?>
