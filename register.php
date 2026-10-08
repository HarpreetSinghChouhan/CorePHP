<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>
<script src="./assets/js/script.js" defer></script>

<body class="auth-body">
<div class="auth-shell">

    <!-- Left brand panel -->
    <aside class="auth-aside">
        <div class="auth-brand">
            <i class="fa-solid fa-store"></i> MyApp
        </div>

        <div class="auth-pitch">
            <h1>Create your account in a minute.</h1>
            <p>Sign up to place orders, save items to your wishlist and keep track of everything in one dashboard.</p>
        </div>

        <div class="auth-points">
            <div class="auth-point">
                <div class="auth-point-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <strong>Email and phone number</strong>
                    <span>For your login and order updates.</span>
                </div>
            </div>
            <div class="auth-point">
                <div class="auth-point-icon"><i class="fa-solid fa-lock"></i></div>
                <div>
                    <strong>Secure password</strong>
                    <span>Use at least 8 characters.</span>
                </div>
            </div>
        </div>

        <div class="auth-stripes" aria-hidden="true"></div>
    </aside>

    <!-- Right form area -->
    <main class="auth-main">
        <div class="auth-wrap wide">

            <div class="auth-mobile-brand">
                <i class="fa-solid fa-store"></i> MyApp
            </div>

            <h2 class="auth-title">Create your account</h2>
            <p class="auth-sub">Fill in your details to get started</p>

            <div class="auth-card">
                <form id="FormSubmit" method="POST" novalidate>

                    <div class="vr-field">
                        <label for="UserName" class="vr-label">Username</label>
                        <input type="text" name="UserName" id="UserName" class="vr-input"
                               placeholder="Enter your username" autocomplete="username">
                        <div class="UserNameError"></div>
                    </div>

                    <div class="vr-field">
                        <label for="Email" class="vr-label">Email</label>
                        <input type="email" name="Email" id="Email" class="vr-input"
                               placeholder="you@example.com" autocomplete="email">
                        <div class="EmailError"></div>
                    </div>

                    <div class="vr-grid">
                        <div class="vr-field">
                            <label for="Age" class="vr-label">Date of birth</label>
                            <input type="date" name="Age" id="Age" class="vr-input">
                            <div class="AgeError"></div>
                        </div>

                        <div class="vr-field">
                            <span class="vr-label" id="GenderLabel">Gender</span>
                            <div class="vr-seg" role="radiogroup" aria-labelledby="GenderLabel">
                                <input type="radio" name="Gender" id="male" value="male">
                                <label for="male">Male</label>

                                <input type="radio" name="Gender" id="female" value="female">
                                <label for="female">Female</label>

                                <input type="radio" name="Gender" id="other" value="other">
                                <label for="other">Other</label>
                            </div>
                            <div class="GenderError"></div>
                        </div>
                    </div>

                    <div class="vr-field">
                        <label for="PhoneNumber" class="vr-label">Phone number</label>
                        <input type="tel" name="PhoneNumber" id="PhoneNumber" class="vr-input"
                               placeholder="+91 9876543210"
                               title="Enter phone number in format: +<country code> <number> e.g. +91 9876543210"
                               autocomplete="tel">
                        <div class="PhoneNumberError"></div>
                    </div>

                    <div class="vr-grid">
                        <div class="vr-field">
                            <label for="Password" class="vr-label">Password</label>
                            <input type="password" name="Password" id="Password" class="vr-input"
                                   placeholder="Enter password" autocomplete="new-password">
                            <div class="PasswordError"></div>
                        </div>

                        <div class="vr-field">
                            <label for="ConfirmPassword" class="vr-label">Confirm password</label>
                            <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="vr-input"
                                   placeholder="Re-enter password" autocomplete="new-password">
                            <div class="ConfirmPasswordError"></div>
                        </div>
                    </div>

                    <div class="vr-check">
                        <input type="checkbox" name="ShowHide" id="ShowHide">
                        <label for="ShowHide" id="PasswordControl">Show password</label>
                    </div>

                    <button type="submit" class="vr-btn">
                        Create account <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <div class="auth-foot">
                <div>Already have an account? <a href="./login.php" class="auth-link">Log in</a></div>
            </div>

        </div>
    </main>

</div>

<?php 
include "./includes/footer.php";
?>