<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>

<script src="./assets/js/script.js" defer ></script>
<body>
    <main class="login-page" >
        <div class="FormDiv" >
            <div style="text-align:center" ><h2>Register Page</h2></div>
        <form id="FormSubmit" method="POST">
<!--             
            <label for="UserName">UserName :-</label>
            <input type="text" name="UserName" id="UserName" placeholder="Enter Your UserName"  class="input-feild" /> <br>
            <div class="UserNameError" style="color:red" >
            </div> -->
            
            <!-- <label for="UserName" class="label-input-feild" >UserName :</label> -->
            <input type="text" name="UserName" id="UserName" class="input-feild"  placeholder="Enter Your UserName"/> <br>
            <div class="UserNameError" style="color:red" >
            </div>
            <!-- <label for="Email" class="label-input-feild">Email : </label> -->
            <input type="email" name="Email" id="Email" placeholder="Enter Your Email"  class="input-feild"/> <br>
             <div class="EmailError" style="color:red" >
            </div>
             <!-- <label for="Email" class="label-input-feild">Role :</label> -->
            <!-- <select name="Role" id="Role" class="select-field" >
                <option value="" class="role-option" >Select Role</option>
                <option value="user" class="role-option" >User</option>
                <option value="admin" class="role-option" >Admin</option>
            </select><div class="RoleError" style="color:red" >
            </div> -->
            <label class="label-input-feild radio-input-label ">Gender :</label> <br>
                        <input type="radio" name="Gender" id="male" value="male" class="input-radio-feild" /> <label for="male" class="radio-label" >Male</label>
                        <input type="radio" name="Gender" id="female" value="female" class="input-radio-feild"/><label for="female" class="radio-label" >FeMale</label> 
                        <input type="radio" name="Gender" id="other" value="other" class="input-radio-feild"/><label for="other" class="radio-label" >Other</label> <br>
            <div class="GenderError" style="color:red" >
            </div>
            <!-- <label for="Age" class="label-input-feild"> Age : </label> -->
            <input type="date" name="Age" id="Age" placeholder="Enter Your Age"  class="input-feild" /> <br>
              <div class="AgeError" style="color:red" >
            </div>
             <input type="tel" name="PhoneNumber"   title="Enter phone number in format: +<country code> <number> e.g. +91 9876543210" id="PhoneNumber" placeholder="+91 9876554526"  class="input-feild" /> <br>
             <div class="PhoneNumberError" style="color:red" >
            </div>
            <!-- <label for="Password" class="label-input-feild">Password : </label> -->
            <input type="password" name="Password" id="Password" placeholder="Enter Your Password"  class="input-feild" /> <br>
             <div class="PasswordError" style="color:red" >
            </div>
            <!-- <label for="ConfirmPassword" class="label-input-feild">Confirm Password : </label> -->
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Enter Confirm Password"  class="input-feild" /> <br>
            <!-- <i class="fa-solid fa-eye" id="togglePassword"></i> -->
            <div class="ConfirmPasswordError" style="color:red" >
            </div>
            <input type="checkbox" name="ShowHide" id="ShowHide" class="checkbox-input-feild" />
            <label for="ShowHide" id="PasswordControl" >Show Password </label>
            <!-- <label for="UserName">UserName </label>
            <input type="t*ext" name="UserName" id="UserName" placeholder="Enter UserName"  class="input-feild"  /> <br> -->
            <input type="submit" value="Register" class="submit-button">

        </form>
           <div class="link-div" >have an account?<a href="./login.php" class="page-link" >Login Page</a></div>

    </div>
    </main>
    <?php 
include "./includes/footer.php";
?>
