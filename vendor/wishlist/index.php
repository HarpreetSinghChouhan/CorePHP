<?php
require_once __DIR__ . '/../common/header.php';

require_once __DIR__ . '/../common/sidebar.php';
?>
    <script src="../assets/js/wishlist.js" defer></script>
    <?php require_once __DIR__ . '/../common/navbar.php'; ?>

        <section class="vr-card">
    <div class="vr-card-head">
        <h2>Recent Added Wishlist</h2>
    </div>
        <div class="vr-table-wrap">
        <table class="vr-table vr-datatable" id="wishlist_datatable">   
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Wishlist Item</th>
                    <th style="text-align:center!important">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>  
</section>

<?php require_once __DIR__ . '/../common/footer.php'; ?>