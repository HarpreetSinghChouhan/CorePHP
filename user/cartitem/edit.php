<?php
// user/index.php
require_once  './../common/header.php';
require_once  './../common/sidebar.php';
include '../../config/database.php';
if(isset($_GET['id'])) {
        $user_id = $_SESSION['user_id'];
        $cart_id = $_GET['id'];
        $SelectCart = "SELECT c.id, c.quantity, c.user_id, c.product_id,
        p.name AS product_name, p.price, p.category_id,p.description, 
        p.stock_quantity, p.sku, p.image, p.is_deleted,
        cat.name AS category_name, cat.id AS cat_id
    FROM `cart` AS c
    INNER JOIN `product` AS p ON p.id = c.product_id
    INNER JOIN `category` AS cat ON p.category_id = cat.id
    WHERE c.id = '$cart_id' AND c.user_id = '$user_id'";
        $result = mysqli_query($conn, $SelectCart);
        $product = mysqli_fetch_assoc($result);
        if(!$product){
            echo json_encode(["error" => "Product Are Not Found"]);
            die();
        } 
        $image = 'data:image/jpeg;base64,' . base64_encode($product['image']);
}
else{
        echo json_encode(["error" => "Something Are Wrong "]);
    }  

?>

<div class="user-main">
    <?php require_once './../common/navbar.php'; ?>
 <script src="./../assets/js/cartitem.js" defer ></script>

   <div class="user-content">
  <div class="cart-item" data-cart-id="<?= (int)$product['id'] ?>"
       data-price="<?= htmlspecialchars($product['price']) ?>"
       data-stock="<?= (int)$product['stock_quantity'] ?>">

    <div class="cart-item__img">
      <img src="<?= htmlspecialchars($image) ?>"
           alt="<?= htmlspecialchars($product['product_name']) ?>">
    </div>

    <div class="cart-item__info">
      <h2 class="cart-item__title"><?= htmlspecialchars($product['product_name']) ?></h2>
      <p class="cart-item__category"><?= htmlspecialchars($product['category_name']) ?></p>
      <p class="cart-item__desc">
        <strong>description:</strong>
        <?= htmlspecialchars($product['description']) ?>
      </p>

      <div class="cart-item__price">₹<?= number_format($product['price']) ?>  </div> 
      <div class="cart-item__actions">
       <div class="qty-box cart-card" data-id="<?= (int)$product['id'] ?>">
            <button type="button" class="qty-btn decrease-btn" id="qtyMinus">−</button>
            <span class="qty-text">Qty: <span id="qtyValue"><?= (int)$product['quantity'] ?></span></span>
            <button type="button" class="qty-btn increase-btn" id="qtyPlus">+</button>
         </div>
         <br>
        
    <p class="stock-msg" id="stockMsg" style="display:none;"></p>

        <!-- <button type="button" class="delete-btn" id="deleteItem" title="Remove">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
          </svg>
        </button> -->
      </div>
      <div class="cart-item__price">
  Total Price ₹
  <span class="total-price">
    <?= number_format($product['price'] * (int)$product['quantity']) ?>
  </span>
</div>
       <!-- <div class="cart-item__price  "> Total Price ₹ <span class="total-price" >  <?php echo number_format($product['price']) * (int) $product['quantity'];  ?> </span></div> -->
    </div>
  </div>
</div>
<?php require_once './../common/footer.php'; ?>
