$(document).ready(function () {
  
    
    $("#AddUserForm").on("submit",function(e){
     e.preventDefault();
   $(".UserNameError, .EmailError, .GenderError, .PasswordError, .ConfirmPasswordError, .AgeError, .PhoneError").html("");
     const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
       const phonenumberPattern = /^\+\d{1,3}\s\d{7,15}$/;
    const validationRules = [
        {
            input:$("#Name"),
            value:$("#Name").val().trim(),
            errorEl:$(".UserNameError"),
            isValid:function(){return this.value.length >= 4; },
            message:"User Name Required at least 4 Letter"
        },
        {
            input:$("#Email"),
            value:$("#Email").val().trim(),
            errorEl:$(".EmailError"),
            isValid: function() { return this.value !== '' && emailPattern.test(this.value); },
            message: this.value === '' ? "Email is required." : "Email is not in a valid format."
        },
        {
            input:$("#Phone"),
            value:$("#Phone").val().trim(),
            errorEl:$(".PhoneError"),
            isValid: function() { return this.value !== '' && phonenumberPattern.test(this.value); },
            message: this.value === '' ? "Phone Number is required." : "Phone Number is not in a valid format."
        },
        {
        input: $("#Age"),
        value: $("#Age").val().trim(),
        errorEl: $(".AgeError"),
        isValid: function() { return this.value !== ''; },
        message: "Age is required."
    },
    {
        input: $('#Gender'),
        value: $('#Gender').val() || '',
        errorEl: $(".GenderError"),
        isValid: function() { return this.value !== ''; },
        message: "Gender is required."
    },
    {
        input: $("#Password"),
        value: $("#Password").val().trim(),
        errorEl: $(".PasswordError"),
        isValid: function() { return this.value !== '' && this.value.length >= 6; },
        message: "Password is required and must be at least 6 characters."
    },
    {
        input: $("#ConfirmPassword"),
        value: $("#ConfirmPassword").val().trim(),
        errorEl: $(".ConfirmPasswordError"),
        isValid: function() { return this.value === $("#Password").val().trim(); },
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
        $.ajax({
            url:"/harpreet_task/auth/UserRegister.php",
            type:"POST",
            data:$(this).serialize(),
            success:function(response){
                if(response == 'AgeWrong'){
                $(".AgeError").html("Age Are Minimum 18  Year ");
                age.focus();
                return; 
                }
                else if(response == 'User-Exited'){
                $(".EmailError").html("Email Allready Used Please Use Other");
                email.focus();
                return; 
                }
                 else if(response == 'Success'){
                    swal.fire({
                        'title':"User Are Created",
                        'icon':"success"
                    });
                    location.href = "./index.php"
                }
                else{ 
                    swal.fire({
                        'title':response,
                    })

                }
            },
            error: function () {
                swal.fire("Something went wrong!");
            }
            
        })
          
    })
    
    $(document).on("change", "#ChangePassword", function () {

        if ($(this).is(":checked")) {
            $("#passwordGroup").slideDown();
        } else {
            $("#passwordGroup").slideUp();
            $("#Password").val("");
        }
    });
      const ShowHide = $("#ShowPassword");
     ShowHide.on("click",function(e){
          const password = $("#Password");
          const PasswordControl = $("#PasswordControl");
          const ConfirmPassword = $("#ConfirmPassword");
      if($(this).is(":checked") === true){
         password.attr("type","text");  
       PasswordControl.html("Hide Password");
       ConfirmPassword.attr("type","text");  
    }
      else{
        password.attr("type","password"); 
       PasswordControl.html("Show Password");
       ConfirmPassword.attr("type","password");
      }
    });
    $(document).on("click", ".edit-user", function () {

        let row = $(this).closest("tr");
        let id = row.data("id");

        window.location = `http://localhost/harpreet_task/admin/user/edit.php?id=${id}`;


        // window.location = `http://localhost/harpreet_task/admin/user/edit.php?email=${email}`;
    });


    $("#editUserForm").on("submit", function (e) {
          
        e.preventDefault();
          const username = $("#Name");
          const email = $("#Email");
          const age = $("#Age");
          const phone = $("#Phone");
          const phonenumberPattern = /^\+\d{1,3}\s\d{7,15}$/;
          const PhoneValue = phone.val().trim() || '';
          const gendervalue = $('#Gender').val() || '';
         
          const password = $("#Password");
          const ConfirmPassword = $("#ConfirmPassword");
          const usernameValue = username.val().trim();
          const emailValue  = email.val().trim();
          const ageValue = age.val().trim();
          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          $(".NameError").html("");
          $(".EmailError").html("");
          $(".GenderError").html("");
          $(".AgeError").html("");
          $(".PhoneError").html("");
     
        if(usernameValue.length < 3){
           $(".UserNameError").html("<p>User Name Are Required and Minimum 3 letter </p>");
             username.focus();
            return;
        }
         if (!emailPattern.test(emailValue) && emailValue === "") {
           $(".EmailError").html("<p>email Are Valid And Fill Correct </p>");
            email.focus();
            return;
           } 
          if(!phonenumberPattern.test(PhoneValue)  || PhoneValue === ""){
             $(".PhoneError").html("<p>Phone Number Fill Correct Format</p>");
             phone.focus();
             return;
            }
      if ($("#ChangePassword").is(":checked")) {
            $("#passwordGroup").slideDown();
          const PasswordValue = password.val().trim();
         const ConfirmPasswordValue = ConfirmPassword.val().trim();
          if(PasswordValue.length < 6 || PasswordValue === "" ){
           $("#PasswordError").html("Password Are required and minimum 6 letter");
           password.focus();
           return;
          } 
          if(ConfirmPasswordValue !== PasswordValue){
           $("#ConfirmPasswordError").html("Password Are Not Match");
           ConfirmPassword.focus();
           return;
          }
        } else {
            $("#passwordGroup").slideUp();
            $("#Password").val("");
            $("#ConfirmPassword").val("");
        }
if (gendervalue === "") {
    $(".GenderError").html("<p>Gender is required. Please select your gender.</p>");
    return; 
} else {
    $(".GenderError").html(""); 
}
        $.ajax({
            url: "/harpreet_task/auth/EditUser.php",
            type: "POST",
            data: $(this).serialize(),

            success: function (response) {
            if( response.trim() === 'AgeWrong' ){
           $(".AgeError").html("Age Under 18 year");
           age.focus();     
           return; 
           } 
           if( response.trim() === 'Email-Exited' ){
           $(".EmailError").html("Use Other Email This Is Allready Exited");
           email.focus();     
           return; 
            }
                if (response.trim() === "success") {
                    swal.fire({
                       'title':'User Updated SuccessFully',
                        'icon':'success',
                    })
                window.location = "./index.php";
                } else {
                    swal.fire({
                        'title':response
                    })
                }
            },

            error: function () {
                alert("Something went wrong!");
            }
        });
    });
    
    $(document).on("click", ".delete-user", function () {

        let row = $(this).closest("tr");
        let name = row.find(".user-name").text().trim();
        let email = row.find(".user-email").text().trim();
            swal.fire({
                 'title':'Are you sure?',
                'text':`You Want To Delete ${name}`,
                'icon':'warning',
                'showCancelButton':true,
                'cancelButtonColor':'Green',
                'confirmButtonColor':'Red',
                'confirmButtonText':'Yes, Delete it',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: "/harpreet_task/auth/DeleteUser.php",
                        type: "POST",

                            data: {
                            email: email
                             },
                        success: function (response) {

                            if (response.trim() === "success") {
                                // alert("User deleted successfully!");
                             swal.fire({
                                'title':'User are Deleted',
                                'icon':'success'
                             });

                             row.fadeOut(500, function () {
                             $(this).remove();
                           });
                            } else {
                                //  alert(response);
                            swal.fire({
                                'title':`${response}`,
                                 'icon':'warning'
                            });
                            }
                        },

                    error: function () {
                    //   alert("Something went wrong!");
                      swal.fire({
                        'title':'Something Are Wrong ',
                        'icon':'warning'
                      })
                }
                    });
                }
            })

    });

});