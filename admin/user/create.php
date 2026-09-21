<?php
// admin/user/edit.php
require_once __DIR__ . '../../common/header.php';
require_once __DIR__ . '../../common/sidebar.php';

?>


<div class="admin-main">
    <?php require_once __DIR__ . '../../common/navbar.php'; ?>
    <script src="/CorePHP/admin/assets/js/user.js" defer></script>
    <div class="model-content">
        <div class="user-content">


        <div class=" ">

            <div class="card profile-details">

                
                    <div class="alert-success" style="display:none" >Profile Are Updated</div>
                <div class="profile-details-header">
                    <div>
                        <h3>Create New User </h3>
                        <!-- <p></p> -->
                    </div>
                </div>

                <form method="POST" id="AddUserForm">
                    <div class="form-grid">
                        <div class="field">
                            <label>Full Name</label>
                            <input type="text" name="UserName" id="Name" placeholder="Enter User Name"  >
                           <div class="UserNameError" style="color:red" ></div>
                        </div>
                        
                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" name="Email" id="Email" placeholder="Enter Email" >
                           <div class="EmailError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Phone Number</label>
                            <input type="text" name="PhoneNumber" placeholder="+91 98765 43210" id="Phone" >
                           <div class="PhoneError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Date of Birth</label>
                            <input type="date" name="Age" id="Age" >
                           <div class="AgeError" style="color:red" ></div>
                        
                        </div>
                        <div class="field">
                            <label>Gender</label>
                            <select name="Gender" id="Gender" >
                                <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                                    <option name="gender" value="<?= $g ?>" <?= $user['gender'] === $g ? 'selected' : '' ?>><?= $g ?></option>
                                <?php endforeach; ?>
                            </select>
                           <div class="GenderError" style="color:red" ></div>
                        
                        </div>
                    </div> 
                    <div class="field" id="passwordGroup"  >
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" placeholder="Enter Your Password" >
                    <div class="PasswordError" style="color:red" ></div>
                    <label for="ConfirmPassword">Confirm Password</label>
                    <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Enter Your Confirm Password" >
                    <div class="ConfirmPasswordError" style="color:red" ></div>    
                    <input type="checkbox" name="ShowPashword"  id="ShowPassword"> <label for="ShowPassword" id="PasswordControl"  style="display:inline;"> Show Password </label>
                </div>
                </div>

               

                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-ghost btn-back">Back</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>

        </div>
             
    </div>
   
<?php require_once __DIR__ . '../../common/footer.php'; ?>
