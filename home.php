<?php
include "./includes/home/header.php";
?>
<script src="/CorePHP/user/assets/js/home.js" defer></script>

<section class="hero">
  <div class="hero-text">
    <p class="hero-kicker">New stock has arrived</p>
    <h1>One destination<br><em>for every need.</em></h1>
    <p class="hero-sub">From fashion to groceries — thousands of products, delivered straight to your home.</p>
    <a href="#products" class="btn btn-primary">Start Shopping Now</a>
  </div>
</section>

<main class="products-section" id="products">
  
  <!-- Latest products (top 8) -->
  <div class="section-head">
    <h2>Latest Products</h2>
  </div>
 <div class="product-grid" id="latest-grid"></div>
 <hr class="m-50 divider" >
  <!-- All products (sort + pagination) -->
  <section class="all-products m-50" id="all-products">
    <div class="section-head">
      <h2>All Products</h2>
       <a href="./allproduct.php" class="link-url" >view all</a>
    </div>
    <div class="product-grid" id="all-products-grid"></div>
    <nav class="pagination" id="pagination" aria-label="Page navigation"></nav>
  </section>

</main>

<?php
include "./includes/home/footer.php";
?>