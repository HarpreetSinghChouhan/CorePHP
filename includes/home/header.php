<?php
// 1. session_start() must be the very first thing, before any HTML/echo output
session_start();
include __DIR__ . "/../../config/database.php";
// $user_id = null;

?>

<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TokriMart — Everything, One Place</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<!-- <link rel="stylesheet" href="https://cloudflare.com"> -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,500;0,600;1,500&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/CorePHP/assets/style/product.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.js" ></script>
<body>
<header class="site-header">
  <div class="header-inner">
    <a href="home.php" class="logo">Tokri<em>Mart</em></a>

    <div class="header-actions">
<?php if (!isset($_SESSION["email"])): ?>
  <a href="./login.php" class="nav-btn nav-login" aria-label="Sign In">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/>
    </svg>
    <span>Sign In</span>
  </a>

  <a href="./vendor/register.php" class="nav-btn nav-vendor" aria-label="Sell on TokriMart">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M3 9l1.5-5h15L21 9"/><path d="M5 9v11h14V9"/><path d="M10 20v-6h4v6"/>
    </svg>
    <span>Sell on TokriMart</span>
    <svg class="arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M5 12h14M13 6l6 6-6 6"/>
    </svg>
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
<body>
