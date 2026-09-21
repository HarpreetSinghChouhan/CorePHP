$(document).ready(function(){
    $("#MailForm").on("submit",function(e){
        e.preventDefault();
         const Emailbtn = $("#EmailButton");
         Emailbtn.prop('disabled',true)
         Emailbtn.val("Sending..")
        const email = $("#Email");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const emailValue = email.val().trim();

        if(emailValue == "" || !emailPattern.test(emailValue) ){
            $(".EmailError").css("margin-top","-20px");
            $(".EmailError").html("<p> Email are invalid or Wrong </p>")
            email.focus();
            return;
        }
        else {
           const data = new FormData(e.target);
        //    console.log(e.target);
           const xhr = new XMLHttpRequest();
           xhr.open("POST", "./auth/EmailVerification.php", true);
           xhr.onload = function(){
            if(xhr.status == 200){
                console.log("response :- ", xhr.responseText);
                Emailbtn.prop("disabled",'false');
                window.location="http://localhost/CorePHP/login.php";
                return;
            }
            else{
                Emailbtn.prop("disabled",'false');
                console.log("repsonse", "Email Are Wrong" )
            }
           };
           xhr.onerror = function(){
                Emailbtn.prop("disabled",'false');
            console.log("sOMETHING ARE WRONG");
           }
           xhr.send(data); 

        }
        // console.log("working" ,e.target);
    })
})