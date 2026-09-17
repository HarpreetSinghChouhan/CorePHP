$(document).ready(function(){
    const email = $("#Email");
    const password = $("#Password"); 
    $(".eye-icon").on("click",function(e){
      $("#EyeShowHide").toggleClass("fa-eye fa-eye-slash");
      const type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type',type);
     
    })
     $("#FormLogin").on("submit", function(e){
    e.preventDefault();
            const emailValue = email.val().trim(); 
            const passwordValue = password.val().trim(); 
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

            $(".EmailError, .PasswordError").html("").css({"margin-top": "0px", "margin-bottom": "0px"}); 

            let isValid = true;

              if (emailValue === "" || !emailPattern.test(emailValue)) { 
             $(".EmailError").css("margin-top", "-25px").html("<p>Please enter a valid email address.</p>"); 
             email.focus(); 
              isValid = false; 
         } 

                if (passwordValue === "" || passwordValue.length < 6) { 
             $(".PasswordError").css({'margin-top': '15px', 'margin-bottom': '-30px'}).html("<p>Password must be at least 6 characters.</p>"); 
             if (isValid) {
                 password.focus();
                 }
                isValid = false; 
                }

        if (!isValid) {
             return false; 
            }

        const data = new FormData($(this)[0]);
        const xhr = new XMLHttpRequest()
        xhr.open("POST", "./auth/UserLogin.php", true);
        xhr.onload = function(){
        if(xhr.status == 200){
            console.log("Response :", xhr.responseText);
            if(xhr.responseText == 'user'){
             window.location = "/harpreet_task/user/index.php";
            }
            else if(xhr.responseText == 'admin'){
                window.location = "/harpreet_task/admin/index.php";
            }
            else{
                $(".PasswordError").css({'margin-top':'20px','margin-bottom':'-20px'});
                $(".PasswordError").html(`${xhr.responseText}`);
                password.focus();
                return;
        
            }
        }
        else{
            console.log("Not  working");
            alert("something Are wrong");
        }
     }
     xhr.onerror = function(){

     }
     xhr.send(data);
})
});
    