<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>
<link rel="stylesheet" href="/CorePHP/vendor/assets/style/register.css">
<script src="./assets/js/login.js" defer></script>

<body class="vr-body">
  <div class="vr-shell">

    <!-- Left panel -->
    <aside class="vr-aside">
      <div class="vr-brand"><i class="fa-solid fa-store"></i> MyApp</div>

      <div class="vr-pitch">
        <h1>Welcome back. Your orders are waiting.</h1>
        <p>Log in to track orders, manage your cart and wishlist, and pick up right where you left off.</p>
      </div>

      <ul class="vr-needs">
        <li>
          <span class="vr-ico"><i class="fa-solid fa-box"></i></span>
          <div>
            <strong>Track every order</strong>
            <span class="vr-sub">See shipping updates in one place.</span>
          </div>
        </li>
        <li>
          <span class="vr-ico"><i class="fa-solid fa-heart"></i></span>
          <div>
            <strong>Wishlist and cart saved</strong>
            <span class="vr-sub">Your picks stay with your account.</span>
          </div>
        </li>
      </ul>
    </aside>

    <!-- Right: form -->
    <main class="vr-main">
      <div class="vr-card">
        <h1 class="vr-title">Log in to your account</h1>
        <p class="vr-lead">Enter your email and password to continue</p>

        <section class="vr-panel">
          <form id="FormLogin" class="vr-form" method="POST" novalidate>

            <div class="vr-field">
              <label for="Email">Email</label>
              <input type="email" name="Email" id="Email" autocomplete="email" placeholder="you@example.com">
              <small class="EmailError vr-error"></small>
            </div>

            <div class="vr-field">
              <label for="Password">Password</label>
              <div class="vr-pass">
                <input type="password" name="Password" id="Password" autocomplete="current-password" placeholder="Enter your password">
                <button type="button" class="eye-icon" aria-label="Show or hide password">
                  <i id="EyeShowHide" class="fa-regular fa-eye"></i>
                </button>
              </div>
              <small class="PasswordError vr-error"></small>
              <a href="./forgetpassword.php" class="vr-link vr-forgot">Forgot password?</a>
            </div>

            <div class="vr-actions">
              <button type="submit" class="vr-btn vr-btn-primary">
                Log in <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </form>

          <p class="vr-foot">Don't have an account? <a href="./register.php">Register</a></p>
          <p class="vr-foot"><a href="./home.php"><i class="fa-solid fa-house"></i> Back to home</a></p>
        </section>

      </div>
    </main>
  </div>

<?php 
include "./includes/footer.php";
?>