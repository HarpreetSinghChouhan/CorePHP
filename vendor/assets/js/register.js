$(document).ready(function () {

  const URL_STEP1 = "/CorePHP/vendor/backend/register/register_step1.php";
  const URL_STEP2 = "/CorePHP/vendor/backend/register/register_step2.php";
  const REDIRECT_AFTER_DONE = "/CorePHP/login.php";

  // ---- Eye icon: HTML mein nahi, yahan se add hota hai ----
  $('input[type="password"]').each(function () {
    $(this).wrap('<div class="vr-pass"></div>');
    $(this).after(
      '<button type="button" class="js-toggle-pass" aria-label="Show password">' +
        '<i class="fa-regular fa-eye"></i>' +
      '</button>'
    );
  });

  $(document).on("click", ".js-toggle-pass", function () {
    const $btn   = $(this);
    const $input = $btn.siblings("input");
    const show   = $input.attr("type") === "password";

    $input.attr("type", show ? "text" : "password").trigger("focus");
    $btn.attr("aria-label", show ? "Hide password" : "Show password");
    $btn.find("i")
        .toggleClass("fa-eye", !show)
        .toggleClass("fa-eye-slash", show);
  });

  function goToStep(n) {
    $("#panel-1").prop("hidden", n !== 1);
    $("#panel-2").prop("hidden", n !== 2);

    $("#stepper-1").toggleClass("is-active", n === 1).toggleClass("is-done", n === 2);
    $("#stepper-2").toggleClass("is-active", n === 2);
    $("#stepper-bar").toggleClass("is-filled", n === 2);
    $("#stepper-1 .vr-dot").html(n === 2 ? '<i class="fa-solid fa-check"></i>' : "1");

    $("html, body").animate({ scrollTop: 0 }, 250);
  }

  $("#BackToStep1").on("click", function () { goToStep(1); });

  $("#PhoneNumber").on("input", function () {
    this.value = this.value.replace(/\D/g, "").slice(0, 10);
  });

  $("#PanNumber").on("input", function () {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, "").slice(0, 10);
  });

  $("#PanImage").on("change", function () {
    const file   = this.files[0];
    const $thumb = $("#PanThumb");
    const $name  = $("#PanFileName");

    if (!file) {
      $name.text("Choose a file");
      $thumb.css("background-image", "").removeClass("has-img");
      return;
    }
    $name.text(file.name);

    const reader = new FileReader();
    reader.onload = function (e) {
      $thumb.css("background-image", "url(" + e.target.result + ")").addClass("has-img");
    };
    reader.readAsDataURL(file);
  });

  function setError(name, msg) {
    $('[name="' + name + '"]').addClass("is-invalid");
    $('[data-error-for="' + name + '"]').text(msg);
  }

  function clearErrors(form) {
    form.find(".is-invalid").removeClass("is-invalid");
    form.find(".vr-error").text("");
  }

  $(document).on("input change", ".vr-form input, .vr-form textarea", function () {
    $('[name="' + this.name + '"]').removeClass("is-invalid");
    $('[data-error-for="' + this.name + '"]').text("");
  });

  function setLoading(btn, loading, text) {
    if (loading) {
      btn.data("old", btn.html()).prop("disabled", true)
         .html('<i class="fa-solid fa-spinner fa-spin"></i> ' + text);
    } else {
      btn.prop("disabled", false).html(btn.data("old"));
    }
  }

  function showServerErrors(res) {
    if (res && res.errors) {
      $.each(res.errors, function (field, msg) { setError(field, msg); });
    } else {
      Swal.fire({ icon: "error", title: "Something went wrong", text: (res && res.message) || "Please try again." });
    }
  }

  function ajaxFail() {
    Swal.fire({ icon: "error", title: "Server error", text: "Could not reach the server. Check your connection and try again." });
  }

  $("#Register_Submit").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);
    clearErrors($form);

    const phone = $.trim($("#PhoneNumber").val());
    const email = $.trim($("#Email").val());
    const dob   = $("#Age").val();
    const pass  = $("#Password").val();
    const conf  = $("#ConfirmPassword").val();
    let ok = true;

    if (!/^[6-9]\d{9}$/.test(phone)) { setError("PhoneNumber", "Enter a valid 10-digit mobile number."); ok = false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { setError("Email", "Enter a valid email address."); ok = false; }

    if (!dob) {
      setError("Age", "Select your date of birth."); ok = false;
    } else {
      const d = new Date(dob), t = new Date();
      let years = t.getFullYear() - d.getFullYear();
      const m = t.getMonth() - d.getMonth();
      if (m < 0 || (m === 0 && t.getDate() < d.getDate())) years--;
      if (years < 18) { setError("Age", "You must be at least 18 years old."); ok = false; }
    }

    if (!$('input[name="Gender"]:checked').length) { setError("Gender", "Select your gender."); ok = false; }
    if (pass.length < 8) { setError("Password", "Use at least 8 characters."); ok = false; }
    if (conf !== pass || conf === "") { setError("ConfirmPassword", "Passwords do not match."); ok = false; }
    if (!ok) return;

    const $btn = $form.find('[type="submit"]');
    setLoading($btn, true, "Creating account...");

    $.ajax({
      url: URL_STEP1,
      type: "POST",
      data: $form.serialize(),
      dataType: "json"
    })
    .done(function (res) {
      if (res.status === "success") {
        goToStep(2);
      } else {
        showServerErrors(res);
      }
    })
    .fail(ajaxFail)
    .always(function () { setLoading($btn, false); });
  });

  $("#Information_Submit").on("submit", function (e) {
    e.preventDefault();
    const $form = $(this);
    clearErrors($form);

    const pan     = $.trim($("#PanNumber").val()).toUpperCase();
    const file    = $("#PanImage")[0].files[0];
    const full    = $.trim($("#FullName").val());
    const display = $.trim($("#DisplayName").val());
    const address = $.trim($("#StoreDetail").val());
    let ok = true;

    if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)) { setError("PanNumber", "Enter a valid PAN, like ABCDE1234F."); ok = false; }

    if (!file) {
      setError("PanImage", "Upload a photo of your PAN card."); ok = false;
    } else if (["image/jpeg", "image/png"].indexOf(file.type) === -1) {
      setError("PanImage", "Only JPG or PNG files are allowed."); ok = false;
    } else if (file.size > 2 * 1024 * 1024) {
      setError("PanImage", "File is larger than 2 MB."); ok = false;
    }

    if (full.length < 3)     { setError("FullName", "Enter your full name."); ok = false; }
    if (display.length < 2)  { setError("DisplayName", "Enter a store name."); ok = false; }
    if (address.length < 10) { setError("StoreDetail", "Enter the complete pickup address."); ok = false; }
    if (!ok) return;

    const $btn = $form.find('[type="submit"]');
    setLoading($btn, true, "Submitting...");

    $.ajax({
      url: URL_STEP2,
      type: "POST",
      data: new FormData(this),
      processData: false,
      contentType: false,
      dataType: "json"
    })
    .done(function (res) {
      if (res.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Application submitted",
          text: "We will review your details and notify you by email."
        }).then(function () { window.location.href = REDIRECT_AFTER_DONE; });
      } else {
        showServerErrors(res);
      }
    })
    .fail(ajaxFail)
    .always(function () { setLoading($btn, false); });
  });
});