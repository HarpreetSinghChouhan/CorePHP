$(document).ready(function () {

    $(document).on("change", "#ChangePassword", function () {
        //    console.log("Work ing ")
        if ($(this).is(":checked")) {
            $("#passwordGroup").slideDown();
            // $("#Password").prop("required", true);
        } else {
            $("#passwordGroup").slideUp();
            $("#Password").val("");
            // $("#Password").prop("required", false);
        }
    });
    
    $(document).on("click", ".edit-user", function () {

        let row = $(this).closest("tr");
        let email = row.data("email");
        //  let id = row.data("id");

        // window.location = `http://localhost/harpreet_task/admin/user/edit.php?id=${id}`;

        window.location = `/CorePHP/admin/user/edit.php?email=${email}`;
    });
    const ShowHide = $("#ShowPassword")
     ShowHide.on("click",function(e){
          const password = $("#Password");
          const PasswordControl = $("#PasswordControl")
    //   console.log("Show Hide Value ");
      if($(this).is(":checked") === true){
         password.attr("type","text");  
       PasswordControl.html("Hide Password")
      }
      else{
        password.attr("type","password"); 
       PasswordControl.html("Show Password")
      }
    });
    $("#profileForm").on("submit", function (e) {

        e.preventDefault();
         const username = $("#Name");
         const email = $("#Email");
         const age = $("#Age");
         const password = $("#Password");
         const phoneError = $(".PhoneError")
         const phonenumber = $("#Phone");   
    // const PasswordControl = $("#PasswordControl");
            // console.log("Hello  working hello");
         if ($("#ChangePassword").is(":checked")) {
            // console.log("working hello");
            $("#passwordGroup").slideDown();
            // $("#Password").prop("required", true);
             const password = $("#Password");
             const ConfirmPassword = $("#ConfirmPassword");
             const ConfirmPasswordValue = ConfirmPassword.trim().val();
             
             const PasswordValue = password.val().trim();
          if(PasswordValue.length < 6 || PasswordValue === "" ){
           $("#PasswordError").html("Password Are required and minimum 6 letter");
           password.focus();
           return
          } 
          if(ConfirmPasswordValue !== PasswordValue){
            $("#ConfirmPasswordError").html("Password Are Not Matched");
            ConfirmPassword.focus();
            return;
          }

        } else {
            $("#passwordGroup").slideUp();
            $("#Password").val("");
            $("#ConfirmPassword").val("");
            // $("#Password").prop("required", false);
        }
    const usernameValue = username.val().trim();
    const emailValue  = email.val().trim();
    const ageValue = age.val().trim();
    const passwordValue = password.val().trim();
    const phonenumberValue = phonenumber.val().trim();
    const phonenumberPattern = /^\+\d{1,3}\s\d{7,15}$/; 
    const gendervalue = $('#Gender').val() || "";
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     $(".UserNameError").html("");
     $(".EmailError").html("");
     $(".GenderError").html("");
     $(".AgeError").html("");
     $(".PasswordError").html("");
     $(".ConfirmPasswordError").html("");
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
         if(phonenumberValue === ''){
        phoneError.html("<p>Phone Number Is Required </p>");
            phonenumber.focus();
            return;
        }
        if (!phonenumberPattern.test(phonenumberValue)) {
        phoneError.html("<p>Phone Number Are Not Valid Format  </p>");
            phonenumber.focus();
            return;
        }

if (gendervalue === "") {
    $(".GenderError").html("<p>Gender is required. Please select your gender.</p>");
    return; 
} else {
    $(".GenderError").html("");
}
    
        $.ajax({
            url: "/CorePHP/auth/EditUser.php",
            type: "POST",
            data: $(this).serialize(),

            success: function (response) {
                if(response.trim()  === "AgeWrong"){
                $(".AgeError").html("Age Under 18 year");
                // $(".AgeError").css({"margin-bottom":"15px","align-item":"center"});
                   age.focus();     
                    return; 
                }
                if (response.trim() === "success") {
                   swal.fire({
                    'title':'User Updated Successfull',
                    'icon':'success'
                   })
                    window.location = "./profile.php";
                } else {
                    // alert(response);
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

    

});