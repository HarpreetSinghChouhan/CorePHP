<?php
  session_start();
  if (isset($_SESSION["user_id"])) {
    header("location: /CorePHP/login.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Become a vendor</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="/CorePHP/vendor/assets/style/style.css">
  <link rel="stylesheet" href="/CorePHP/vendor/assets/style/register.css?v=<?= @filemtime($_SERVER['DOCUMENT_ROOT'] . '/CorePHP/vendor/assets/style/register.css') ?>">
  <link href="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/v/dt/dt-3.1.2/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/CorePHP/vendor/assets/js/mainscript.js" defer></script>
  <script src="/CorePHP/vendor/assets/js/register.js?v=<?= @filemtime($_SERVER['DOCUMENT_ROOT'] . '/CorePHP/vendor/assets/js/register.js') ?>" defer></script>
</head>
<body class="vr-body">
  <div class="vr-shell">

    <aside class="vr-aside">
      <div class="vr-brand"><i class="fa-solid fa-store"></i> Your Marketplace</div>

      <div class="vr-pitch">
        <h1>Set up your store in two short steps.</h1>
        <p>Create your account first. Then add your PAN and pickup details so we can verify you and start collecting orders from your address.</p>
      </div>

      <ul class="vr-needs">
        <li>
          <span class="vr-ico"><i class="fa-solid fa-mobile-screen"></i></span>
          <div>
            <strong>Phone number and email</strong>
            <span class="vr-sub">For your login and order alerts.</span>
          </div>
        </li>
        <li>
          <span class="vr-ico"><i class="fa-solid fa-id-card"></i></span>
          <div>
            <strong>PAN number and card photo</strong>
            <span class="vr-sub">Needed to verify your business and pay you out.</span>
          </div>
        </li>
        <li>
          <span class="vr-ico"><i class="fa-solid fa-box-open"></i></span>
          <div>
            <strong>Store name and pickup address</strong>
            <span class="vr-sub">Where our courier collects your parcels.</span>
          </div>
        </li>
      </ul>
    </aside>

    <!-- Right: the form -->
    <main class="vr-main">
      <div class="vr-card">
        <h1 class="vr-title">Create your vendor account</h1>
        <p class="vr-lead">Register Your Account As Vendor</p>

        <section class="vr-panel step-1" id="panel-1">
          <form id="Register_Submit" class="vr-form" method="post" novalidate> 
            <div class="vr-field">
                  <label for="FullName">Full name</label>
                  <input type="text" name="FullName" id="FullName" autocomplete="name" placeholder="Enter Your Name">
                  <small class="vr-error" data-error-for="FullName"></small>
            </div>      
            <div class="vr-field">
              <label for="PhoneNumber">Phone number</label>
              <div class="vr-phone">
                <span>+91</span>
                <input type="tel" name="PhoneNumber" id="PhoneNumber" inputmode="numeric"
                       maxlength="10" autocomplete="tel-national" placeholder="10-digit mobile number">
              </div>
              <small class="vr-error" data-error-for="PhoneNumber"></small>
            </div>

            <div class="vr-field">
              <label for="Email">Email</label>
              <input type="email" name="Email" id="Email" autocomplete="email" placeholder="you@yourbusiness.com">
              <small class="vr-error" data-error-for="Email"></small>
            </div>

            <div class="vr-row">
              <div class="vr-field">
                <label for="Age">Date of birth</label>
                <input type="date" name="Age" id="Age" autocomplete="bday"
                       max="<?= date('Y-m-d', strtotime('-18 years')) ?>">
                <small class="vr-error" data-error-for="Age"></small>
              </div>

              <div class="vr-field">
                <span class="vr-label" id="GenderLabel">Gender</span>
                <div class="vr-seg" role="radiogroup" aria-labelledby="GenderLabel">
                  <label><input type="radio" name="Gender" value="Male"><span>Male</span></label>
                  <label><input type="radio" name="Gender" value="Female"><span>Female</span></label>
                  <label><input type="radio" name="Gender" value="Other"><span>Other</span></label>
                </div>
                <small class="vr-error" data-error-for="Gender"></small>
              </div>
            </div>

            <div class="vr-row">
              <div class="vr-field">
                <label for="Password">Password</label>
                <input type="password" name="Password" id="Password" autocomplete="new-password" placeholder="At least 8 characters">
                <small class="vr-error" data-error-for="Password"></small>
              </div>

              <div class="vr-field">
                <label for="ConfirmPassword">Confirm password</label>
                <input type="password" name="ConfirmPassword" id="ConfirmPassword" autocomplete="new-password" placeholder="Re-enter password">
                <small class="vr-error" data-error-for="ConfirmPassword"></small>
              </div>
            </div>

            <div class="vr-actions">
              <button type="submit" class="vr-btn vr-btn-primary">
                Create account <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </form>
          <p class="vr-foot">Already selling with us? <a href="/CorePHP/login.php">Log in</a></p>
        </section>
      </div>
    </main>
  </div>
</body>
</html>