<?php 
 include "./includes/home/header.php"
?>
<script src="/CorePHP/user/assets/js/product.js" defer></script>
<section class="hero">
  <div class="hero-text">
    <p class="hero-kicker">New stock has arrived</p>
    <h1>One destination<br><em>for every need.</em></h1>
    <p class="hero-sub">From fashion to groceries — thousands of products, delivered straight to your home.</p>
    <a href="#products" class="btn btn-primary">Start Shopping Now</a>
  </div>
</section>
<main class="products-section" id="products">
  <div class="section-head">
    <h2>All Products</h2> <div class="search-div"  > <input type="search" placeholder="Search product, Category, Price " name="SearchProduct" id="SearchProduct" class="SearchProduct" ><input type="button" value="Search" id="SearchProduct_Button" > </div>
    
  </div>

  
  <div class="product-grid">

    <!-- PRODUCT CARD START -->

  </div>
    <nav class="pagination" id="pagination" aria-label="Page navigation"></nav>
</main>

<?php 
 include "./includes/home/footer.php"
?>