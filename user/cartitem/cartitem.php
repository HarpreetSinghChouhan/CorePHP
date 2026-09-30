<?php
// user/index.php
require_once  './../common/header.php';
require_once  './../common/sidebar.php';
// require "";
?>
<div class="user-main">
    <?php require_once './../common/navbar.php'; ?>
 <script src="./../assets/js/cartitem.js" defer ></script>

    <div class="user-content">
      <!--   <div class="summary-cards">
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
               <div style="display:flex;justify-content:space-between" > <p>Added Card Item </p> <h3 class="cart-count dashboard-item-list" >0</h3></div>
            </div>
            <div class="summary-card card-orange">
                <div class="top">
                    <div class="icon-circle"><i class="fa-regular fa-message"></i></div>
                </div>
               <div style="display:flex;justify-content:space-between" > <p>Added Card Item </p> <h3 class="cart-count dashboard-item-list" >0</h3></div>
            </div>
        </div> -->

      <!-- <div class="table-div" >
         <div class="row-per-page  " >
            <h4> Per Page Cart</h4>
            <select name="Row" id="Row" class="select-row-number" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>

        </div>
        <table>
            <thead>
                <tr>
                <th>Serial No</th>
                <th>product Image</th>
                <th>product Name</th>
                <th>product Quanity</th>
                <th>product price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="cartitem-tbody" ></tbody>
           
        </table>
         <div class="pagination" > </div>

      </div> -->
      <div class="table-div">

    <div class="row-per-page">
        <h4>Per Page Cart</h4>
        <select name="Row" id="Row" class="select-row-number">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
        </select>
    </div>

    <div class="table-wrapper">
        <table class="cartitem-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="cartitem-tbody"></tbody>
        </table>
    </div>

    <div class="pagination"></div>

</div>
    </div>
<?php require_once './../common/footer.php'; ?>
