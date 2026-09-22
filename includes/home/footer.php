<footer class="site-footer">
  <p>© <span id="year"></span> TokriMart. All rights reserved.</p>
</footer>

<script>
  document.getElementById('year').textContent = new Date().getFullYear();
  // (e.g. fetch('cart.php', {method:'POST', body: ...productId}))
  document.querySelectorAll('.btn-add-cart').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-product-id');
      btn.classList.add('is-added');
      btn.textContent = 'In Cart ✓';
      setTimeout(function () {
        btn.classList.remove('is-added');
        btn.innerHTML = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L22 8H6"/></svg> Add to Cart';
      }, 1400);
    });
  });
</script>
<script src="https://jquery.com"></script>
<script src="https://cloudflare.com"></script>
</body>
</html>