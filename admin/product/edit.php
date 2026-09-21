<?php
// admin/user/edit.php
require_once __DIR__ . '../../common/header.php';
require_once __DIR__ . '../../common/sidebar.php';
$product = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query ="SELECT product.id, product.name, product.price, product.sku, product.description, product.stock_quantity, product.image, product.created_at, category.name AS category_name
 FROM product INNER JOIN category ON category.id=product.category_id WHERE product.id='$id' ";
    // $query = "SELECT * FROM product WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
     $row = mysqli_fetch_assoc($result);
       $product['image'] = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        $product['id'] = $row['id'];
        $product['name'] = $row['name'];
        $product['category_name'] = $row['category_name'];
        $product['sku'] = $row['sku'];
        $product['price'] = $row['price'];
        $product['description'] = $row['description'];
        $product['stock_quantity'] = $row['stock_quantity'];
}
if (!$product){
    header("Location: /CorePHP/admin/index.php");

    // header("Location: http://localhost/CorePHP/admin/index.php");
    exit;
}
?>


<div class="admin-main">
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="../assets/js/product.js"; defer ></script>
    <div class="model-content">
        <div class="user-content">

        <div class=" ">
            <div class="card profile-details">
                <div class="profile-details-header">
                    <div>
                        <h3>Edit Product  </h3>
                        <!-- <p></p> -->
                    </div>
                </div>

                <form method="POST" id="EditProductForm" enctype="multipart/form-data" >
                    <div class="form-grid">
                        <div class="field">
                            <label>Product Name</label>
                            <input type="text" name="ProductName" id="ProductName"  value="<?php echo $product['name'] ?>" placeholder="Enter Product Name"  >
                            <input type="text" name="ProductId" id="ProductId" value="<?php echo $product['id'] ?>" placeholder="Product Id"  hidden>
                            <div class="ProductNameError" style="color:red" ></div>
                        </div>
                        
                        <div class="field">
                            <label>Product Sku</label>
                            <input type="text" name="ProductSku" id="ProductSku" value="<?php echo $product['sku'] ?>" placeholder="Enter Product Sku" readonly>
                           <div class="ProductSkuError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>price</label>
                            <input type="number" name="Price" placeholder="Give Product Price" id="Price" value="<?php echo $product['price'] ?>" >
                           <div class="PriceError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Select Category</label>
                            
                            <select name="ProductCategory" id="ProductCategory">
                              <?php 
                               $query = "SELECT * FROM category WHERE is_deleted != 1";
                                      $result = mysqli_query($conn, $query);
                                      $g = $product['category_name'];
                                     $selected_category = $g ?? ''; 
                                    while ($row = mysqli_fetch_assoc($result)) { 
                                      $catg_name = $row['name'];
                                            ?>
                                        <option value="<?= htmlspecialchars($catg_name) ?>" <?= $catg_name === $selected_category ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($catg_name) ?></option>
                                    <?php } ?>
                            </select>
                           <div class="CategoryError" style="color:red" ></div>
                        
                        </div>
                          <div class="field">
                            <label>Product Image</label>
                           <div class="edit-image-page" style="color:red" >
                            <img src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] ?>"  >
                           </div>
                        
                        </div>
                        <div class="field">
                            <label>Product Image</label>
                            <input type="file" name="ProductImage" placeholder="Select Image For Product" id="ProductImage" >
                           <div class="ProductImageError" style="color:red" ></div>
                        
                        </div>
                         <div class="field">
                            <label>Product Quantity</label>
                            <input type="number" name="ProductQuantity" value="<?php echo $product['stock_quantity'] ?>"  placeholder="Product Quantity" id="ProductQuantity" >
                           <div class="ProductQuantityError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Description</label>
                            <textarea name="Description" id="Description"  Plcaeholder="Enter Product Description" ><?php echo htmlspecialchars($product['description']); ?> </textarea>
                           <div class="DescriptionError" style="color:red" ></div>
                        
                        </div>

                    </div> 
                </div>
                </div>

                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>

        </div>
             
    </div>
   
<?php require_once __DIR__ . '../../common/footer.php'; ?>
