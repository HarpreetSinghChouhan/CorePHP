<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
if(!isset($_GET["token"])||!isset($_GET["email"])){
    header("Location: http://localhost/CorePHP/user/dashboard.php");
    exit;
}
$email = htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8');
$token = htmlspecialchars($_GET["token"], ENT_QUOTES, 'UTF-8');
?>
<link rel="stylesheet" href="/CorePHP/assets/style/auth.css">
<script src="assets/js/newpassword.js" defer></script>

<body class="vr-body">
  <div class="vr-shell">

    <!-- Left panel -->
    <aside class="vr-aside">
      <div class="vr-brand"><i class="fa-solid fa-store"></i> MyApp</div>

      <div class="vr-pitch">
        <h1>Choose a new password.</h1>
        <p>Pick a strong password that you don't use anywhere else. You can log in with it right after.</p>
      </div>

      <ul class="vr-needs">
        <li>
          <span class="vr-ico"><i class="fa-solid fa-lock"></i></span>
          <div>
            <strong>At least 8 characters</strong>
            <span class="vr-sub">Mix letters, numbers and symbols.</span>
          </div>
        </li>
        <li>
          <span class="vr-ico"><i class="fa-solid fa-shield-halved"></i></span>
          <div>
            <strong>Keep it private</strong>
            <span class="vr-sub">Never share your password or reset link.</span>
          </div>
        </li>
      </ul>
    </aside>

    <!-- Right: form -->
    <main class="vr-main">
      <div class="vr-card">
        <h1 class="vr-title">Create new password</h1>
        <p class="vr-lead">Set a new password for your account</p>

        <section class="vr-panel">
          <form id="CreateNewPassword" class="vr-form" method="POST" novalidate>

            <small class="TokenError vr-error"></small>

            <input type="hidden" name="Token" id="Token" value="<?php echo $token; ?>">

            <div class="vr-field">
              <label for="Email">Email</label>
              <input type="text" name="Email" id="Email" value="<?php echo $email; ?>" readonly>
            </div>

            <div class="vr-row">
              <div class="vr-field">
                <label for="Password">New password</label>
                <input type="password" name="Password" id="Password" autocomplete="new-password" placeholder="Enter secure password">
                <small class="PasswordError vr-error"></small>
              </div>

              <div class="vr-field">
                <label for="ConfirmPassword">Confirm password</label>
                <input type="password" name="ConfirmPassword" id="ConfirmPassword" autocomplete="new-password" placeholder="Re-enter password">
                <small class="ConfirmPasswordError vr-error"></small>
              </div>
            </div>

            <div class="vr-check">
              <input type="checkbox" name="ShowHide" id="ShowHide">
              <label for="ShowHide" id="PasswordControl">Show password</label>
            </div>

            <div class="vr-actions">
              <button type="submit" class="vr-btn vr-btn-primary">
                Create password <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </form>

          <p class="vr-foot"><a href="./login.php"><i class="fa-solid fa-arrow-left"></i> Back to login</a></p>
        </section>

      </div>
    </main>
  </div>

<?php 
include "./includes/footer.php";
?>