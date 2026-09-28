<?php 
 include "./includes/home/header.php"
?>
<script src="/CorePHP/user/assets/js/product.js" defer></script>

<main class="products-section" id="products">
 <?php
 if(!isset($_GET["id"])){
   die("Product ID missing");
 }
 $id = intval($_GET["id"]); 
 $query = "SELECT * FROM product WHERE id='$id'";
 $result = mysqli_query($conn,$query);
 $product = mysqli_fetch_assoc($result);

 if(!$product){
   echo "<p>Product not found.</p>";
 } else {
    $image = 'data:image/jpeg;base64,' . base64_encode($product['image']);
 ?>

 <div class="product-detail-container">
   <div class="product-detail-image">
     <img src="<?php echo htmlspecialchars($image); ?>" 
          alt="<?php echo htmlspecialchars($product['name']); ?>">
   </div>

   <div class="product-detail-info">
     <h1><?php echo htmlspecialchars($product['name']); ?></h1>
     <p class="product-sku">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>

     <div class="product-price">
       ₹<?php echo number_format($product['price'], 2); ?>
     </div>

     <?php if($product['stock_quantity'] > 0): ?>
       <p class="in-stock">In Stock </p>
     <?php else: ?>
       <p class="out-of-stock">Out of Stock</p>
     <?php endif; ?>

     <div class="product-description">
       <h3>Description</h3>
       <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
     </div>

     <div class="product-actions">
       <button class="btn-add-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
       <button class="btn-buy-now" data-id="<?php echo $product['id']; ?>">Buy Now</button>
     </div>
   </div>
 </div>

 <?php } ?>

</main>

<?php 
 include "./includes/home/footer.php"
?>