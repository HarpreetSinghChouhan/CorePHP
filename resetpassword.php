<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
if(!isset($_GET["token"])||!isset($_GET["email"])){
    header("Location: http://localhost/CorePHP/user/dashboard.php");
 exit;
}
$email = $_GET["email"];
$token = $_GET["token"];
// echo "$token  == $email";
?>
<script src="assets/js/newpassword.js" defer ></script>
<body>
    <main class="login-page">
        <div class="FormDiv" >
            <div style="text-align:center" ><h2>Create New Password </h2></div>
            <div class="TokenError" style="color:red" >
            </div>
        <form id="CreateNewPassword" method="POST">

            <input type="text" name="Token" id="Token"  value="<?php echo $token ?>" hidden/>
            <input type="text" name="Email" id="Email" value="<?php echo $email ?>"   class="input-feild" readonly>
         <!-- <label for="Password" class="label-input-feild">Password : </label> -->
            <input type="password" name="Password" id="Password" placeholder="Enter Secure Password"  class="input-feild" /> <br>
             <div class="PasswordError" style="color:red" >
            </div>
            <!-- <label for="ConfirmPassword" class="label-input-feild">Confirm Password : </label> -->
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Enter Confirm Password"  class="input-feild" /> <br>
            <div class="ConfirmPasswordError" style="color:red" >
            </div>
             <input type="checkbox" name="ShowHide" id="ShowHide" class="checkbox-input-feild" />
            <label for="ShowHide" id="PasswordControl" >Show Password </label>
           <input type="submit" value="Create Password" class="submit-button">

        </form>
         <div class="link-div" ><a href="./login.php" class="page-link" >Login Page</a></div>
    </main>
    
<?php 
include "./includes/footer.php";
?>
