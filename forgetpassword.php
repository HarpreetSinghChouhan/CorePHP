<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>
<!-- Paths apne project ke hisaab se adjust karein -->
<link rel="stylesheet" href="/CorePHP/vendor/assets/style/register.css">
<script src="./assets/js/mail.js" defer></script>

<body class="vr-body">
  <div class="vr-shell">

    <!-- Left panel -->
    <aside class="vr-aside">
      <div class="vr-brand"><i class="fa-solid fa-store"></i> MyApp</div>

      <div class="vr-pitch">
        <h1>Verify your email to get back in.</h1>
        <p>Enter the email you registered with and we will send you a verification mail.</p>
      </div>

      <ul class="vr-needs">
        <li>
          <span class="vr-ico"><i class="fa-solid fa-envelope"></i></span>
          <div>
            <strong>Use your registered email</strong>
            <span class="vr-sub">The mail goes to the address on your account.</span>
          </div>
        </li>
        <li>
          <span class="vr-ico"><i class="fa-solid fa-inbox"></i></span>
          <div>
            <strong>Check your inbox and spam</strong>
            <span class="vr-sub">It can take a minute to arrive.</span>
          </div>
        </li>
      </ul>
    </aside>

    <!-- Right: form -->
    <main class="vr-main">
      <div class="vr-card">
        <h1 class="vr-title">Email verification</h1>
        <p class="vr-lead">We will send a verification mail to this address</p>

        <section class="vr-panel">
          <form id="MailForm" class="vr-form" method="POST" novalidate>

            <div class="vr-field">
              <label for="Email">Email</label>
              <input type="email" name="Email" id="Email" autocomplete="email" placeholder="you@example.com">
              <small class="EmailError vr-error"></small>
            </div>

            <div class="vr-actions">
              <button type="submit" id="EmailButton" class="vr-btn vr-btn-primary">
                Send verification mail <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
          </form>

          <p class="vr-foot"><a href="./login.php"><i class="fa-solid fa-arrow-left"></i> Back to login</a></p>
        </section>

      </div>
    </main>
  </div>

<?php 
include "./includes/footer.html";
?>