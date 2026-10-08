<?php 
 include "./includes/home/header.php"
?>
<script src="/CorePHP/user/assets/js/product.js" defer></script>
<main class="products-section pay-cancel" id="products">
  <section class="pay-cancel__card" role="alert" aria-live="polite">
    <div class="pay-cancel__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24">
        <path class="cross" d="M7 7l10 10" />
        <path class="cross" d="M17 7L7 17" />
      </svg>
    </div>

    <h1 class="pay-cancel__title">Payment cancelled</h1>
    <p class="pay-cancel__text">
      Your order was not placed. The items are still in your cart, so you can try again whenever you're ready.
    </p>

    <div class="pay-cancel__actions">
      <a class="pay-cancel__btn pay-cancel__btn--primary" href="./cart.php">Back to cart</a>
      <a class="pay-cancel__btn pay-cancel__btn--ghost" href="./home.php">Continue shopping</a>
    </div>

    <p class="pay-cancel__note">
      If money was deducted from your account, it is usually refunded within 5–7 working days.
    </p>
  </section>
</main>

<?php 
 include "./includes/home/footer.php"
?>