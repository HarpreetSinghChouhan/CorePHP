<?php 
include "./includes/header.php";
include_once "./auth/verify.php";
?>
<script src="./assets/js/mail.js" defer ></script>
<body>
    <main class="login-page">
        <div  class="container" >
            <div class="FormDiv" >
            <div style="text-align:center" ><h2>Email Verification</h2></div>
        <form id="MailForm" method="POST">
            <!-- <label for="Email" class="label-input-feild">Email : </label> -->
            <input type="email" name="Email" id="Email" placeholder="Enter Your Email"  class="input-feild"/> <br>
             <div class="EmailError" style="color:red" >
            </div>
           <input type="submit" value="Mail Verification" id="EmailButton" class="submit-button">

        </form>
         <div class="link-div" ><a href="./login.php" class="page-link" >Login Page</a></div>
        </div>
    </main>
    
<?php 
include "./includes/footer.html";
?>
