<?php
// vendor/product/create.php
require __DIR__ . '../../common/header.php';
require __DIR__ . '../../common/sidebar.php';

$categories = [];
$selected_category = $selected_category ?? '';
 
if (isset($conn) && $conn) {
    $query  = "SELECT * FROM category WHERE is_deleted != 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['name'];
        }
    } else {
        // Debug ke liye (kaam hone ke baad hata dena)
        error_log('Category query failed: ' . mysqli_error($conn));
    }
}
?>

<!-- <div class="admin-main"> -->
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="../assets/js/product.js" defer></script>

    <div class="model-content">
        <div class="user-content">

            <div class="card profile-details">

                <div class="alert-success" style="display:none">Product Created</div>

                <div class="profile-details-header">
                    <div>
                        <h3>Create New Product</h3>
                    </div>
                </div>

                <form method="POST" id="AddProductForm" enctype="multipart/form-data">
                    <div class="form-grid">

                        <div class="field">
                            <label for="ProductName">Product Name</label>
                            <input type="text" name="ProductName" id="ProductName" placeholder="Enter Product Name">
                            <div class="ProductNameError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="ProductSku">Product Sku</label>
                            <input type="text" name="ProductSku" id="ProductSku" placeholder="Enter Product Sku">
                            <div class="ProductSkuError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="Price">Price</label>
                            <input type="number" name="Price" id="Price" placeholder="Give Product Price">
                            <div class="PriceError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="ProductCategory">Select Category</label>
                            <select name="ProductCategory" id="ProductCategory">
                                <option value="">select</option>
                                <?php foreach ($categories as $catg_name) { ?>
                                    <option value="<?= htmlspecialchars($catg_name) ?>"
                                        <?= $catg_name === $selected_category ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($catg_name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="ProductCategoryError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="ProductImage">Product Image</label>
                            <input type="file" name="ProductImage" id="ProductImage">
                            <div class="ProductImageError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="ProductQuantity">Product Quantity</label>
                            <input type="number" name="ProductQuantity" id="ProductQuantity" placeholder="Product Quantity">
                            <div class="ProductQuantityError" style="color:red"></div>
                        </div>

                        <div class="field">
                            <label for="Description">Description</label>
                            <textarea name="Description" id="Description" placeholder="Enter Product Description"></textarea>
                            <div class="DescriptionError" style="color:red"></div>
                        </div>

                    </div><!-- /.form-grid -->

                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Create Product</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
<!-- </div> -->

<?php require __DIR__ . '   ../../common/footer.php'; ?>
