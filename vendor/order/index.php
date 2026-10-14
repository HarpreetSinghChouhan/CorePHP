<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>
    <script src="../assets/js/order.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>
  <section class="vr-card">
    <div class="vr-card-head">
        <h2>Order List :-</h2>
        <!-- <a class="create-link-btn vr-btn">
            <i class="fa-solid fa-plus"></i> Add Category
        </a> -->
    </div>
        <div class="vr-table-wrap">
        <table class="vr-table vr-datatable"  id="order_datatable">
            <thead>
                <tr>
                    
                <th>Serial No</th>
                <th>Order Id</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Total Quantity</th>
                <th>Total Amount</th>
                <th>Order Item</th>
                <th>Perchange At</th>
                <th>Action</th>
               </tr>
            </thead>
            <tbody  class="category-body" >
              
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../common/footer.php'; ?>