<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="/CorePHP/assets/style/user-style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="user-wrapper">
<aside class="user-sidebar">
    <div class="brand">MyApp</div>

    <div class="user-mini-profile">
        <div class="avatar">1</div>
        <div>
            <div class="name">123456</div>
            <div class="role">Member</div>
        </div>
    </div>

    <ul>
         <li><a href="index.php" ><span class="icon"><i class="fa-solid fa-house"></i></span> Dashboard</a></li>      
         <li><a href="profile.php" class=""><span class="icon"><i class="fa-solid fa-user"></i></span> My Profile</a></li>
         <li><a href="/CorePHP/auth/logout.php"><span class="icon"></span><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
</aside>
 <script src="/CorePHP/user/assets/js/script.js" defer ></script>
<div class="user-main">
    <header class="user-navbar">
    <div class="welcome-text">
        <h2>Welcome back, 123456 👋</h2>
        <span>Monday, 21 September 2026</span>
    </div>
    <div class="navbar-right">
        <div class="icon-btn"><i class="fa-solid fa-bell"></i></div>
        <div class="icon-btn"><i class="fa-solid fa-search"></i></div>
        <a href="./../home.php" style="text-decoration:none" >
        <div class="icon-btn"><i class="fa-solid fa-home"></i></div>
    </a>
    </div>
</header>
    <div class="user-content">
        <div class="profile-wrap">

            <div class="card profile-side">
                <div class="profile-avatar">1</div>
                <h2>123456</h2>
                <span class="role-badge">user</span>

                <div class="meta-row">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><path d="M3 8l9 6 9-6"/><rect x="3" y="4" width="18" height="16" rx="2"/></svg>
                    <span>newuser@gmail.com</span>
                </div>
                <div class="meta-row">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.78.66 2.61a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.47-1.23a2 2 0 0 1 2.11-.45c.83.32 1.71.54 2.61.66A2 2 0 0 1 22 16.92z"/></svg>
                    <span>+21 2121212121</span>
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
                    <input type="text" name="id" id="id" value="14" hidden>
                    <div class="form-grid">
                        <div class="field">
                            <label>Full Name</label>
                            <input type="text" name="name" id="Name" value="123456" disabled>
                           <div class="UserNameError" style="color:red" ></div>
                        </div>
                        
                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" name="email" id="Email" value="newuser@gmail.com" readonly disabled>
                           <div class="EmailError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="+91 98765 43210" Id="Phone" value="+21 2121212121" disabled>
                           <div class="PhoneError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Date of Birth</label>
                            <input type="date" name="age" id="Age" value="2008-09-14" disabled>
                           <div class="AgeError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Gender</label>
                            <select name="gender" id="Gender"  disabled>
                                                                    <option name="gender" value="Male" >Male</option>
                                                                    <option name="gender" value="Female" >Female</option>
                                                                    <option name="gender" value="Other" >Other</option>
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
            const form = $('$profileForm');
            const fields = $('input, select, textarea');
            const actions = $('#formActions');
            const editBtn = $('#editToggleBtn');
            let editing = false;

            function toggleEdit() {
                editing = !editing; // yhaa error show ho rhaa hai 
                fields.forEach(f => f.disabled = !editing);
                actions.classList.toggle('show', editing);
                editBtn.innerHTML = editing ? '👁️ Cancel Edit' : '✏️ Edit Profile';
                if (editing) fields[0].focus();
            }

            function cancelEdit() {
                editing = false;
                fields.forEach(f => f.disabled = true);
                actions.classList.remove('show');
                editBtn.innerHTML = '✏️ Edit Profile';
                form.reset();
            }
        </script>

    </div>

        <footer class="user-footer">
            &copy; 2026 . All rights reserved.
        </footer>
    </div>
</div>
</body>
</html>
