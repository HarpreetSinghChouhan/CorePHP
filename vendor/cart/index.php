<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>

    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

    <!-- <div class="admin-content"> -->
        <section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent Products</h2>
        <a href="/CorePHP/vendor/product/create.php" class="vr-btn">
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
                <!-- PHP loop yahan lagana: while($row = ...) -->
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

<?php require_once __DIR__ . '/../common/footer.php'; ?>