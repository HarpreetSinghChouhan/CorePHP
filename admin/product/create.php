<?php
// admin/user/edit.php
require_once __DIR__ . '../../common/header.php';
require_once __DIR__ . '../../common/sidebar.php';

?>


<div class="admin-main">
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="../assets/js/product.js"; defer ></script>
    <div class="model-content">
        <div class="user-content">


        <div class=" ">

            <div class="card profile-details">

                
                    <div class="alert-success" style="display:none" >Profile Are Updated</div>
                <div class="profile-details-header">
                    <div>
                        <h3>Create New Product </h3>
                        <!-- <p></p> -->
                    </div>
                </div>

                <form method="POST" id="AddProductForm" enctype="multipart/form-data" >
                    <div class="form-grid">
                        <div class="field">
                            <label>Product Name</label>
                            <input type="text" name="ProductName" id="ProductName" placeholder="Enter Product Name"  >
                           <div class="ProductNameError" style="color:red" ></div>
                        </div>
                        
                        <div class="field">
                            <label>Product Sku</label>
                            <input type="text" name="ProductSku" id="ProductSku" placeholder="Enter Product Sku" >
                           <div class="ProductSkuError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>price</label>
                            <input type="number" name="Price" placeholder="Give Product Price" id="Price" >
                           <div class="PriceError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Select Category</label>
                            
                            <select name="ProductCategory" id="ProductCategory">
                              <?php 
                               $query = "SELECT * FROM category WHERE is_deleted != 1";
                                      $result = mysqli_query($conn, $query);
                                     $selected_category = $g ?? ''; 
                                    while ($row = mysqli_fetch_assoc($result)) { 
                                      $catg_name = $row['name'];
                                            ?>
                                        <option value="<?= htmlspecialchars($catg_name) ?>" <?= $catg_name === $selected_category ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($catg_name) ?></option>
                                    <?php } ?>
                            </select>
                           <div class="GenderError" style="color:red" ></div>
                        
                        </div>
                        
                        <div class="field">
                            <label>Product Image</label>
                            <input type="file" name="ProductImage" placeholder="Select Image For Product" id="ProductImage" >
                           <div class="ProductImageError" style="color:red" ></div>
                        
                        </div>
                         <div class="field">
                            <label>Product Quantity</label>
                            <input type="number" name="ProductQuantity" placeholder="Product Quantity" id="ProductQuantity" >
                           <div class="ProductQuantityError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <textarea name="Description" id="Description" Plcaeholder="Enter Product Description" ></textarea>
                            <!-- <input type="date" name="Age" id="Age" > -->
                           <div class="DescriptionError" style="color:red" ></div>
                        
                        </div>

                    </div> 
                </div>
                </div>

                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Create Product</button>
                    </div>
                </form>

        </div>
             
    </div>
   
<?php require_once __DIR__ . '../../common/footer.php'; ?>
