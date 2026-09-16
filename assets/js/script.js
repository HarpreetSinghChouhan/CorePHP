// $(function(){
//     console.log("Jqury Are Working and File Are working");
// })

$(document).ready(function(){
    
    // console.log("jquery Working");
    const username = $("#UserName");
    const email = $("#Email");
    const age = $("#Age");
    const password = $("#Password");
    const phonenumber = $("#PhoneNumber");
    const confirmPassword = $("#ConfirmPassword");  
    // const role = $("#Role");
    const ShowHide = $("#ShowHide");
    const PasswordControl = $("#PasswordControl");
    const phoneError = $(".PhoneNumberError");
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
    // let form = $("#FormSubmit");
  $("#FormSubmit").on("submit", function(e){
    e.preventDefault(); 
    const usernameValue = username.val().trim();
    const emailValue  = email.val().trim();
    const ageValue = age.val().trim();
    const passwordValue = password.val().trim();
    const confirmPasswordValue = confirmPassword.val().trim();
    // const phonenumber  = 
    const phonenumberPattern = /^\+\d{1,3}\s\d{7,15}$/; 
    const phonenumberValue = phonenumber.val().trim();
    const gendervalue = $('input[name="Gender"]:checked') || "";
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     $(".UserNameError").html("");
      $(".UserNameError").css("margin-top","0px");
     $(".EmailError").html("");
     $(".EmailError").css("margin-top","0px");
     phoneError.css("margin-top","0px");
     phoneError.html("");
     $(".GenderError").html("");
     $(".GenderError").css("margin-top","0px")
     $(".AgeError").html("");
     $(".AgeError").css("margin-top","0px")
     $(".PasswordError").html("");
     $(".PasswordError").css("margin-top","0px")
     $(".ConfirmPasswordError").html("");
     $(".ConfirmPasswordError").css("margin-top","0px")
     


    if(usernameValue.length < 3){
        $(".UserNameError").css("margin-top","-25px");
        $(".UserNameError").html("<p>User Name Are Required and Minimum 3 letter </p>");
          username.focus();
          return;
    }
     if (!emailPattern.test(emailValue) && emailValue === "") {
        $(".EmailError").css("margin-top","-25px");
        $(".EmailError").html("<p>email Are Valid And Fill Correct </p>");
            email.focus();
            return;
        } 
        // if(roleValue.length < 3){
        //  $(".RoleError").css("margin-top","-25px");
        // $(".RoleError").html("<p> Role are Required </p>");
        //     email.focus();
        //     return;
        // }
        if (gendervalue.length === 0) {
        $(".GenderError").css("margin-top","-15px");
        $(".GenderError").html("<p> Gender Are Required Select Your Gender </p>");
            return;
        }
        if (age.val() === '') {
            $(".AgeError").text('Please enter a valid date.');
             age.focus();
             return;
        } 
    // phonenumber.prop('required',true);
    if(phonenumberValue === ''){
        phoneError.css("margin-top","-25px");
        phoneError.html("<p>Phone Number Is Required </p>");
            phonenumber.focus();
            return;
        }
        if (!phonenumberPattern.test(phonenumberValue)) {
        phoneError.css("margin-top","-25px");
        phoneError.html("<p>Phone Number Are Not Valid Format  </p>");
            phonenumber.focus();
            return;
        }
    
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
console.log(age);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./auth/UserRegister.php", true);
     xhr.onload = function(){
        if(xhr.status == 200){
          if( xhr.responseText === 'AgeWrong' ){
        //    console.log(xhr.responseText);
           $(".AgeError").html("Age Under 18 year");
           $(".AgeError").css({"margin-bottom":"15px","align-item":"center"});
           age.focus();     
           return; 
        }
             if( xhr.responseText =="User-Exited"){
            // window.location = "http://localhost/harpreet_task/login.php";
           console.log("User are Exited");
           $(".ConfirmPasswordError").html("User Are Exited");
           $(".ConfirmPasswordError").css({"margin-bottom":"15px","align-item":"center"});
                 
        }
             else if(xhr.responseText=="Success"){
               console.log("user login");
            window.location = "http://localhost/harpreet_task/login.php";
             }
            
        }
        else{
            console.log("Not  working");
            alert("not working");
        }
     }
     xhr.onerror = function(){

     }
     xhr.send(data);
    });
  }
);
// document.addEventListener("DOMContentLoaded",function(){
//        console.log("jquery Working ");
// })