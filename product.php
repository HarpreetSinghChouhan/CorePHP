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
 $cat_id = $product["category_id"];
 $product_id = $product["id"];
$categoryquery = "SELECT id, name FROM `category` WHERE id = '$cat_id'";
 $catresult1 = mysqli_query($conn,$categoryquery);
 $catresult =mysqli_fetch_assoc($catresult1);
 if(!$catresult){
  echo "category are not found";
 }
   $wishlist = false;
   $categoryname = $catresult["name"];
   $categoryid = $catresult["id"];
   if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];
    $querywishlist = "SELECT * FROM `wishlist` WHERE user_id = '$user_id' AND product_id='$product_id'";
    $queryrun = mysqli_query($conn,$querywishlist);
    if(mysqli_num_rows($queryrun) > 0){
      // echo "Working this";
       $wishlist = true;
    }
    else{
      $wishlist = false;
    }
    }
 ?>

 <div class="product-detail-container">
   <div class="product-detail-image">
     <img src="<?php echo htmlspecialchars($image); ?>" 
          alt="<?php echo htmlspecialchars($product['name']); ?>">
      <div><?php if($wishlist == true){
        echo "<button class='wishlist-btn active' type='button' ><i class='fa-solid fa-heart' ></i></button>"; }
      else{
        echo "<button class='wishlist-btn' type='button' ><i class='fa-regular fa-heart' ></i></button>"; }
         ?></div>
   </div>

   <div class="product-detail-info">
     <h1><?php echo htmlspecialchars($product["name"]); ?></h1>
     <p class="product-sku">category :<?php echo htmlspecialchars($categoryname); ?></p>
    <p class="product-sku">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
     <div class="product-price">
       ₹<?php echo number_format($product['price'], 2); ?>
     </div>

     <?php if($product['stock_quantity'] > 0): ?>
       <p class="in-stock">In Stock </p>
     <?php else: ?>
       <p class="out-of-stock"  >Out of Stock</p>
     <?php endif; ?>

     <div class="product-description">
       <h3>Description</h3>
       <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
     </div>
     <div class="product-actions">
       <button class="btn-add-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
       <button class="btn-buy-now <?php if($product['stock_quantity'] == 0): echo 'disable-btn';endif;?>" data-product_id="<?php echo $product['id']; ?>"  <?php if($product['stock_quantity'] == 0): echo 'disabled';endif; ?>>Buy Now</button>
     </div>
   </div>
 </div>



<div>

      <div> 
<section class="related-products">
  <h2 class="related-title">More from <?php echo htmlspecialchars($categoryname); ?></h2>

  <div class="related-grid">
    <?php
    $getproductsquery = "SELECT * FROM product WHERE category_id = '$categoryid' AND id != '$product_id'";
    $queryresult = mysqli_query($conn, $getproductsquery);

    if (mysqli_num_rows($queryresult) > 0):
      while ($row = mysqli_fetch_assoc($queryresult)):
        $relImage = 'data:image/jpeg;base64,' . base64_encode($row['image']);
    ?>
      <div class="related-card">
        <a href="product.php?id=<?php echo $row['id']; ?>" class="related-img">
          <img src="<?php echo $relImage; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        </a>

        <div class="related-body">
          <h3 class="related-name">
            <a href="product.php?id=<?php echo $row['id']; ?>">
              <?php echo htmlspecialchars($row['name']); ?>
            </a>
          </h3>

          <p class="related-price">₹<?php echo number_format($row['price'], 2); ?></p>

          <?php if ($row['stock_quantity'] > 0): ?>
            <span class="in-stock">In Stock</span>
          <?php else: ?>
            <span class="out-of-stock">Out of Stock</span>
          <?php endif; ?>

          <button class="btn-add-cart related-btn" data-product-id="<?php echo $row['id']; ?>">
            Add to Cart
          </button>
        </div>
      </div>
    <?php
      endwhile;
    else:
    ?>
      <p class="no-related">Product Not Found</p>
    <?php endif; ?>
  </div>
</section>

<?php } ?> 

</main>

<?php 
 include "./includes/home/footer.php"
?>
