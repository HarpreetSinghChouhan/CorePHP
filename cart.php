<?php 
 include "./includes/home/header.php"
?>
<script src="/CorePHP/user/assets/js/cart.js" defer></script>

<!-- <section class="hero">
  <div class="hero-text">
    <p class="hero-kicker">New stock has arrived</p>
    <h1>One destination<br><em>for every need.</em></h1>
    <p class="hero-sub">From fashion to groceries — thousands of products, delivered straight to your home.</p>
    <a href="#products" class="btn btn-primary">Start Shopping Now</a>
  </div>
</section> -->
<main class="products-section" id="products">
  <!-- <div class="section-head">
    <h2>All Products</h2>
    <select class="sort-select" name="sort">
      <option>Best Match</option>
      <option>Price: Low to High</option>
      <option>Price: High to Low</option>
      <option>Newest</option>
    </select>
  </div> -->

<!--   
 
    <div class="product-grid">
      <?php// foreach ($products as $product): ?>
        <article class="product-card">
           <?php // echo $product['name']; ?> etc ...
        </article>
      <?php //endforeach; ?>
    </div>

 
  -->
  <!-- <div class="cart-grid"> -->
<div class="cart-page">
    <div class="cart-left" id="cart-container"></div>
    <div class="cart-right">
        <div class="price-box" id="price-details"></div>
    </div>
</div>

  <!-- </div> -->
  <!-- <nav class="pagination" aria-label="Page navigation">
    <a href="?page=1" class="page-btn page-prev" aria-label="Previous page">
      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    </a>
    <a href="?page=1" class="page-btn is-active">1</a>
    <a href="?page=2" class="page-btn">2</a>
    <a href="?page=3" class="page-btn">3</a>
    <a href="?page=4" class="page-btn">4</a>
    <span class="page-ellipsis">…</span>
    <a href="?page=12" class="page-btn">12</a>
    <a href="?page=2" class="page-btn page-next" aria-label="Next page">
      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
    </a>
  </nav> -->
</main>

<?php 
 include "./includes/home/footer.php"
?>