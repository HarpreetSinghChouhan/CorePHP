<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

<div class="admin-main">
    <script src="../assets/js/product.js"; defer ></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <div class="admin-content">
        <div class="panel">
          <div class="table-header" >   
        <h1 class="center"> Product List</h1> <button class="btn create-link-btn"  >Add New Product</button>
            </div>
            <table>
                <thead>
                    <tr><th>Serial No</th><th>Image</th><th>Name</th><th>Sku</th><th>Price</th><th>Category Name</th><th>Product Description</th><th>Stock</th><th>Action</th></tr>
                </thead>
                <tbody class="product-tbody" >
                </tbody>
            </table>
            <div id="pagination" class="pagination-container"></div>
        </div>

       
    </div>
<?php require_once __DIR__ . '/../common/footer.php'; ?>