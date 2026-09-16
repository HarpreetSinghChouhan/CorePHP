<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>
<script src="./assets/js/login.js" defer ></script>
<body>
    <main class="login-page">
        <div class="FormDiv" >
            <div style="text-align:center" ><h2>Login Page</h2></div>
        <form id="FormLogin" method="POST">
           

            <!-- <label for="Email" class="label-input-feild">Email : </label> -->
            <input type="email" name="Email" id="Email" placeholder="Enter Your Email"  class="input-feild"/> <br>
             <div class="EmailError" style="color:red" >
            </div>
            <!-- <label for="Password" class="label-input-feild">Password : </label> -->
            <input type="password" name="Password" id="Password" placeholder="Enter Your Password"  class="input-feild position-relative" /> <br>
            <span class="eye-icon" ><i id="EyeShowHide"  class="fa-regular fa-eye"></i></span>

            <div class="PasswordError" style="color:red" >
            </div>
           <input type="submit" value="Login" class="submit-button btn-2">

        </form>
         <div class="link-div" >Forget<a href="./forgetpassword.php" class="page-link" > Password?</a></div>
         <div class="link-div" >Don't have an account?<a href="./register.php" class="page-link" >Register Page</a></div>
         

    </main>
    
<?php 
include "./includes/footer.php";
?>
