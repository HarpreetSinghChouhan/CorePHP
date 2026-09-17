$(document).ready(function(){
    const username = $("#UserName");
    const email = $("#Email");
    const age = $("#Age");
    const password = $("#Password");
    const phonenumber = $("#PhoneNumber");
    const confirmPassword = $("#ConfirmPassword");  
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
    const passwordValue = password.val().trim();
    const confirmPasswordValue = confirmPassword.val().trim();
    const phonenumberPattern = /^\+\d{1,3}\s\d{7,15}$/; 
    const phonenumberValue = phonenumber.val().trim();
    const gendervalue = $('input[name="Gender"]:checked') || "";
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     $(".UserNameError, .EmailError, .GenderError, .AgeError, .PasswordError, .ConfirmPasswordError").html("");
     $(".UserNameError, .EmailError, .GenderError, .AgeError, .PasswordError, .ConfirmPasswordError").css("margin-top","0px");
    phoneError.css("margin-top","0px");
    phoneError.html("");  
    console.log("Gender Value = ",$("#Gender").val() );
    console.log("gender = ", $('input[name="Gender"]:checked'));

     const validationRules = [
        {
            input:username,
            value:username.val().trim(),
            errorEl:$(".UserNameError"),
            isValid:function(){return this.value.length >= 4; },
            message:"User Name Required at least 4 Letter"
        },
        {
            input:email,
            value:email.val().trim(),
            errorEl:$(".EmailError"),
            isValid: function() { return this.value !== '' && emailPattern.test(this.value); },
            message: this.value === '' ? "Email is required." : "Email is not in a valid format."
        },
        {
            input:phonenumber,
            value:phonenumber.val().trim(),
            errorEl:$(".PhoneNumberError"),
            isValid: function() { return this.value !== '' && phonenumberPattern.test(this.value); },
            message: this.value === '' ? "Phone Number is required." : "Phone Number is not in a valid format."
        },
        {
        input: age,
        value: age.val().trim(),
        errorEl: $(".AgeError"),
        isValid: function() { return this.value !== ''; },
        message: "Age is required."
    },
    {
        input: $('#Gender'),
        value: gendervalue,
        errorEl: $(".GenderError"),
        isValid: function() { return gendervalue.length !== 0; },
        message: "Gender is required."
    },
    {
        input: password,
        value: password.val().trim(),
        errorEl: $(".PasswordError"),
        isValid: function() { return this.value !== '' && this.value.length >= 6; },
        message: "Password is required and must be at least 6 characters."
    },
    {
        input: confirmPassword,
        value: confirmPassword.val().trim(),
        errorEl: $(".ConfirmPasswordError"),
        isValid: function() { return this.value === password.val().trim(); },
        message: "Confirm Password does not match."
    }
    ];
        let isFormValid = true;
        let firstInvalidInput = null;

     $.each(validationRules, function(index,rule){
         if (!rule.isValid()) {
        rule.errorEl.html(rule.message); 
        isFormValid = false;             

        if (!firstInvalidInput) {
            firstInvalidInput = rule.input;
        }
     }})
     if (!isFormValid) {
     if (firstInvalidInput) firstInvalidInput.focus();
      return;
    }
    // if(usernameValue.length < 3){
    //     $(".UserNameError").css("margin-top","-25px");
    //     $(".UserNameError").html("<p>User Name Are Required and Minimum 3 letter </p>");
    //       username.focus();
    //       return;
    // }
    //  if (!emailPattern.test(emailValue) && emailValue === "") {
    //     $(".EmailError").css("margin-top","-25px");
    //     $(".EmailError").html("<p>email Are Valid And Fill Correct </p>");
    //         email.focus();
    //         return;
    //     } 
    //     if (gendervalue.length === 0) {
    //     $(".GenderError").css("margin-top","-15px");
    //     $(".GenderError").html("<p> Gender Are Required Select Your Gender </p>");
    //         return;
    //     }
    //     if (age.val() === '') {
    //         $(".AgeError").text('Please enter a valid date.');
    //          age.focus();
    //          return;
    //     } 
    // if(phonenumberValue === ''){
    //     phoneError.css("margin-top","-25px");
    //     phoneError.html("<p>Phone Number Is Required </p>");
    //         phonenumber.focus();
    //         return;
    //     }
    //     if (!phonenumberPattern.test(phonenumberValue)) {
    //     phoneError.css("margin-top","-25px");
    //     phoneError.html("<p>Phone Number Are Not Valid Format  </p>");
    //         phonenumber.focus();
    //         return;
    //     }
    //     if (passwordValue.length < 6 || passwordValue === "" ) {
    //     $(".PasswordError").css("margin-top","-25px");
    //     $(".PasswordError").html("<p>Password must be at least 6 characters</p>");
    //         password.focus();
    //         return;
    //     }
    // if (passwordValue !== confirmPasswordValue || confirmPasswordValue === "" ) {
    //     $(".ConfirmPasswordError").css("margin-top","-25px");
    //     $(".ConfirmPasswordError").html("<p>Password and confirm password do not match </p>");
    //         confirmPassword.focus();
    //         return;
    //     }
        const data = new FormData($(this)[0]);
//   console.log(data);
        console.log(age);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./auth/UserRegister.php", true);
        xhr.onload = function(){
        if(xhr.status == 200){
          if( xhr.responseText === 'AgeWrong' ){
           $(".AgeError").html("Age Under 18 year");
           $(".AgeError").css({"margin-bottom":"15px","align-item":"center"});
           age.focus();     
           return; 
        }
             if( xhr.responseText =="User-Exited"){
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