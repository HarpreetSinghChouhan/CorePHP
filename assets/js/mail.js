$(document).ready(function () {
    const originalBtnHtml = $("#EmailButton").html();

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    function resetButton(btn) {
        btn.prop("disabled", false);
        btn.css("cursor", "pointer");
        btn.html(originalBtnHtml);
    }

    $("#MailForm").on("submit", function (e) {
        e.preventDefault();

        const btn = $("#EmailButton");
        const email = $("#Email");
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const emailValue = email.val().trim();

        if (emailValue === "" || !emailPattern.test(emailValue)) {
            $(".EmailError").text("Email is invalid or wrong");
            email.focus();
            return;
        }
        $(".EmailError").text("");

        btn.prop("disabled", true);
        btn.css("cursor", "not-allowed");
        btn.html("Sending...");

        const data = new FormData(e.target);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./auth/EmailVerification.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("response :- ", xhr.responseText);

                Toast.fire({
                 icon: "success",
                 title: "Verification mail sent",
                 text: "Please check your inbox (and spam folder)."
                }).then(() => {
                    window.location = "http://localhost/CorePHP/login.php";
                });
            } else {
                resetButton(btn);
                Toast.fire({ icon: "error", title: "Could not send mail. Try again." });
            }
        };

        xhr.onerror = function () {
            resetButton(btn);
            Toast.fire({ icon: "error", title: "Something went wrong. Try again." });
        };

        xhr.send(data);
    });
});