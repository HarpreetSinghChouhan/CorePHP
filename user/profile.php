<?php
// user/profile.php
require_once __DIR__ . '/common/header.php';
require_once __DIR__ . '/common/sidebar.php';
$email = $_SESSION['email'];
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
      $user['id'] = $row['id'];
      $user['name'] = $row['name'];
      $user['email'] = $row['email'];
      $user['dob'] = $row['age'];
      $user['gender'] = $row['gender'];
      $user['role'] = $row['role'];
      $user['password'] = "";
      $user['phone'] = $row['phonenumber'] ;

$initial = strtoupper(substr($user['name'], 0, 1));
?>
 <script src="/CorePHP/user/assets/js/script.js" defer ></script>
<div class="user-main">
    <?php require_once __DIR__ . '/common/navbar.php'; ?>

    <div class="user-content">


        <div class="profile-wrap">

            <!-- LEFT: Profile summary -->
            <div class="card profile-side">
                <div class="profile-avatar"><?= htmlspecialchars($initial) ?></div>
                <h2><?= htmlspecialchars($user['name']) ?></h2>
                <span class="role-badge"><?= htmlspecialchars($user['role']) ?></span>

                <div class="meta-row">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><path d="M3 8l9 6 9-6"/><rect x="3" y="4" width="18" height="16" rx="2"/></svg>
                    <span><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="meta-row">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.78.66 2.61a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.47-1.23a2 2 0 0 1 2.11-.45c.83.32 1.71.54 2.61.66A2 2 0 0 1 22 16.92z"/></svg>
                    <span><?= htmlspecialchars($user['phone']) ?></span>
                </div>
            </div>

            <!-- RIGHT: Details / Edit form -->
            <div class="card profile-details">

                
                    <div class="alert-success" style="display:none" >✅  Profile Are Updated</div>
                <div class="profile-details-header">
                    <div>
                        <h3>Profile Details</h3>
                        <p>Apni personal information yahan dekhein ya edit karein</p>
                    </div>
                    <button type="button" class="btn btn-outline" id="editToggleBtn" onclick="toggleEdit()">
                        ✏️ Edit Profile
                    </button>
                </div>

                <form method="POST" id="profileForm">
                    <input type="text" name="id" id="id" value="<?= htmlspecialchars($user['id'])  ?>" hidden>
                    <div class="form-grid">
                        <div class="field">
                            <label>Full Name</label>
                            <input type="text" name="name" id="Name" value="<?= htmlspecialchars($user['name']) ?>" disabled>
                           <div class="UserNameError" style="color:red" ></div>
                        </div>
                        
                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" name="email" id="Email" value="<?= htmlspecialchars($user['email']) ?>" readonly disabled>
                           <div class="EmailError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="+91 98765 43210" Id="Phone" value="<?= htmlspecialchars($user['phone']) ?>" disabled>
                           <div class="PhoneError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Date of Birth</label>
                            <input type="date" name="age" id="Age" value="<?= htmlspecialchars($user['dob']) ?>" disabled>
                           <div class="AgeError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Gender</label>
                            <select name="gender" id="Gender"  disabled>
                                <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                                    <option name="gender" value="<?= $g ?>" <?= $user['gender'] === $g ? 'selected' : '' ?>><?= $g ?></option>
                                <?php endforeach; ?>
                            </select>
                           <div class="GenderError" style="color:red" ></div>
                        
                        </div>
                        
                    </div>
                    <div class="">
                    <input type="checkbox" name="ChangePassword"  id="ChangePassword" disabled>
                    <label for="ChangePassword">Password Change ?</label>
                </div>

                <div class="field" id="passwordGroup" style="display:none;">
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" placeholder="Enter Your Password" disaled>
                    <div id="PasswordError" style="color:red" ></div>
                    <label for="ConfirmPassword">Confirm Password</label>
                    <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Enter Your Confirm Password" >
                    <div id="ConfirmPasswordError" style="color:red" ></div>
                    <input type="checkbox" name="ShowPashword"  id="ShowPassword"> <label for="ShowPassword" id="PasswordControl"  style="display:inline;"> Show Password </label>
                </div>

                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost" onclick="cancelEdit()">Cancel</button>
                        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
        <script>
            const form = $('#profileForm');
            const fields = $('#profileForm input, #profileForm select, #profileForm textarea');
            const actions = $('#formActions');
            const editBtn = $('#editToggleBtn');
            let editing = false;

            function toggleEdit() {
                editing = !editing;
                fields.prop('disabled',!editing);
                actions.toggleClass('show', editing);
               editBtn.html(editing ? '👁️ Cancel Edit' : '✏️ Edit Profile');
            if (editing) fields.eq(0).focus();
            }

            window.cancelEdit = function() {
            editing = false;
            fields.prop('disabled', true);
            actions.removeClass('show');
            editBtn.html('✏️ Edit Profile');
            form.trigger('reset');
        };
        </script>

    </div>

<?php require_once __DIR__ . '/common/footer.php'; ?>