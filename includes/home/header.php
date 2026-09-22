<?php
// 1. session_start() must be the very first thing, before any HTML/echo output
session_start();
include __DIR__ . "/../../config/database.php";
?>

<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TokriMart — Everything, One Place</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://cloudflare.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,500;0,600;1,500&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/CorePHP/assets/style/product.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<body>
<header class="site-header">
  <div class="header-inner">
    <a href="home.php" class="logo">Tokri<em>Mart</em></a>

    <div class="header-actions">
      <?php if (!isset($_SESSION["email"])): ?>
        <a href="./login.php" class="icon-link" aria-label="Account">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg> Login
        </a>
      <?php else: ?>
        <a href="./user/index.php" class="icon-link" aria-label="Account">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg> Dashboard
        </a>

        <a href="./cart.php" class="icon-link cart-link" aria-label="Cart">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L22 8H6"/><circle cx="9" cy="21" r="1.2"/><circle cx="18" cy="21" r="1.2"/></svg>
          <span class="cart-count"></span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>
</body>
</html>