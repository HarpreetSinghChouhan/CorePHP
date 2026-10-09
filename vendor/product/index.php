<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

    <?php require_once __DIR__ . '/../common/navbar.php'; ?>
    <script src="../assets/js/product.js" defer></script>

    <!-- <div class="admin-content"> -->
        <section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent Products</h2>
        <a href="/CorePHP/vendor/product/create.php" class="vr-btn">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>
        <div class="vr-table-wrap">
        <table class="vr-table vr-datatable"  id="product_datatable">
            <thead>
                <tr>
                  <th>Serial No</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Category</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Status</th>
                  <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody  class="product-body" >
              
            </tbody>
        </table>
    </div>
</section>

<?php require_once __DIR__ . '/../common/footer.php'; ?>