$(document).ready(function(){
    const email = $("#Email");
    const password = $("#Password"); 
    //   <i class="fa-regular fa-eye"></i>
    //   <i class="fa-solid fa-eye-slash"></i>
    // <i class="fa-regular fa-eye-slash"></i>
    $(".eye-icon").on("click",function(e){
      $("#EyeShowHide").toggleClass("fa-eye fa-eye-slash");
      const type = password.attr('type') === 'password' ? 'text' : 'password';
    password.attr('type',type);
     
    })
     $("#FormLogin").on("submit", function(e){
    e.preventDefault();

      const emailValue  = email.val().trim();
      const passwordValue  = password.val().trim();
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      
     $(".EmailError").html("");
      $(".EmailError").css("margin-top","0px");
     $(".PasswordError").html("");
     $(".PasswordError").css("margin-top","0px");
      if (!emailPattern.test(emailValue) || emailValue === "") {
        $(".EmailError").css("margin-top","-25px");
        $(".EmailError").html("<p>email Are Valid And Fill Correct </p>");
            email.focus();
            return;
        }     
        if (passwordValue.length < 6 || passwordValue === "" ) {
        $(".PasswordError").css({'margin-top':'15px','margin-bottom':'-30px'});
        $(".PasswordError").html("<p>Password must be at least 6 characters</p>");
            password.focus();
            return;
        }
        const data = new FormData($(this)[0]);
        const xhr = new XMLHttpRequest()
        xhr.open("POST", "./auth/UserLogin.php", true);
        xhr.onload = function(){
        if(xhr.status == 200){

            console.log("Response :", xhr.responseText);
            // alert("Working");
            if(xhr.responseText == 'user'){
             window.location = "http://localhost/harpreet_task/user/index.php";
            }
            else if(xhr.responseText == 'admin'){
                window.location = "http://localhost/harpreet_task/admin/index.php";

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
    