$(document).ready(function(){
    const email = $("#Email");
    const token = $("#Token");
    const password = $("#Password");
    const confirmPassword = $("#ConfirmPassword"); 
        const ShowHide = $("#ShowHide");
    const PasswordControl = $("#PasswordControl");
    ShowHide.on("click",function(e){
    //   console.log("Show Hide Value ");
      if($(this).is(":checked") === true){
       password.attr("type","text"); 
       confirmPassword.attr("type","text"); 
       PasswordControl.html("Hide Password")
      }
      else{
        password.attr("type","password"); 
       confirmPassword.attr("type","password"); 
       PasswordControl.html("Show Password")
      }
    //   console.log($(this).is(":checked"));
    })
    $("#CreateNewPassword").on("submit",function(e){
     e.preventDefault();
        $(".PasswordError").html("<p></p>");
        
        $(".ConfirmPasswordError").html("<p></p>");

     const tokenValue = token.val().trim();
      const emailValue = email.val().trim(); 
      console.log(tokenValue  , emailValue);
      const passwordValue = password.val().trim();
      const confirmPasswordValue = confirmPassword.val().trim();
         if (passwordValue.length < 6 || passwordValue === "" ) {
        $(".PasswordError").css("margin-top","-25px");
        $(".PasswordError").html("<p>Password must be at least 6 characters</p>");
            password.focus();
            return;
        }
    
    if (passwordValue !== confirmPasswordValue || confirmPasswordValue === "" ) {
        $(".ConfirmPasswordError").css("margin-top","-25px");
        $(".ConfirmPasswordError").html("<p>Password and confirm password do not match </p>");
            confirmPassword.focus();
            return;
        }

    // console.log(username); 
    const data = new FormData($(this)[0]);
    // const data = new FormData(form);
//   console.log(data);
    const xhr = new XMLHttpRequest();
    xhr.open("POST","./auth/NewPassword.php", true);
    xhr.onload = function(){
        if(xhr.status == 200){
            if(xhr.responseText == "changed"){
            alert("You password are changed", xhr.responseText);
              window.location="http://localhost/CorePHP/login.php"
            }
            else if(xhr.responseText == "failed"){
                $(".TokenError").html("<p>Something are wrong try Again with resend Link <a class='page-link' href='./forgetpassword.php' >Forget Password<a/></p>")
            }
            console.log("response", xhr.responseText);
        }
        else{
            console.log("Not Working ")
        }
    }
    xhr.send(data);
    //  console.log("working");
    })
});