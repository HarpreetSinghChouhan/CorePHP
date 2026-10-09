<?php
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';

include __DIR__ . '/common/header.php';
include __DIR__ . '/common/sidebar.php';
include __DIR__ . '/common/navbar.php';
?>

<section class="vr-stats">
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-box"></i></div>
        <div><b>24</b><span>Total Products</span></div>
    </div>
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-layer-group"></i></div>
        <div><b>6</b><span>Categories Used</span></div>
    </div>
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <div><b>9</b><span>Items in Carts</span></div>
    </div>
    <div class="vr-stat">
        <div class="vr-stat-icon"><i class="fa-solid fa-heart"></i></div>
        <div><b>15</b><span>Wishlisted</span></div>
    </div>
</section>

<!-- Recent products -->
<section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent Products</h2>
        <a href="/CorePHP/vendor/product/add-product.php" class="vr-btn">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>

    <div class="vr-table-wrap">
        <table class="vr-table vr-datatable">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>SKU</th>
                    <th>Status</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><img class="thumb" src="/CorePHP/uploads/sample.jpg" alt=""></td>
                    <td>Sanemi Shinazugawa Wooden Katana</td>
                    <td>katana</td>
                    <td>1499</td>
                    <td>368HJDS</td>
                    <td><span class="vr-tag ok">Active</span></td>
                    <td style="text-align:center">
                        <a href="#" class="vr-act edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <button class="vr-act del" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img class="thumb" src="/CorePHP/uploads/sample2.jpg" alt=""></td>
                    <td>Charging Data Cable</td>
                    <td>electronic</td>
                    <td>159</td>
                    <td>654HDJS</td>
                    <td><span class="vr-tag off">Inactive</span></td>
                    <td style="text-align:center">
                        <a href="#" class="vr-act edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <button class="vr-act del" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/common/footer.php'; ?>