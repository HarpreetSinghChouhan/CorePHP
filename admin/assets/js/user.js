$(document).ready(function () {
    let table = null;

    const esc = (s) => $("<div>").text(s ?? "").html();

    if ($("#user_datatable").length) {
        initUserTable();
    }

    function initUserTable() {
        table = $("#user_datatable").DataTable({
            ajax: {
                type:'GET',
                url: "/CorePHP/admin/backend/user/GetUsers.php",
                dataSrc: function (json) {
                    return Array.isArray(json) ? json : (json.data || []);
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[1, "asc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "name",   className: "user-name",  render: (d) => esc(d) },
                { data: "email",  className: "user-email", render: (d) => esc(d) },
                { data: "role",   render: (d) => esc(d) },
                { data: "age" },
                { data: "gender", render: (d) => esc(d) },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <button type="button" class="btn-icon edit-link-btn edit-user" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                     <button type="button" class="btn-icon access-link-btn edit-vendor" title="Edit">
                        login   
                    </button>
                    <button type="button" class="btn-icon delete-user" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>` }
            ],
            createdRow: function (row, u) {
                $(row).attr({
                    "data-id": u.id,
                    "data-name": u.name,
                    "data-email": u.email,
                    "data-age": u.age,
                    "data-gender": u.gender
                });
            }
        });

        table.on("draw.dt", function () {
            let start = table.page.info().start;
            table.column(0, { search: "applied", order: "applied", page: "current" })
                 .nodes()
                 .each((cell, i) => { cell.innerHTML = start + i + 1; });
        });
    }
    
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
            url:"/CorePHP/auth/UserRegister.php",
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

        window.location = `/CorePHP/admin/user/edit.php?id=${id}`;


        // window.location = `http://localhost/CorePHP/admin/user/edit.php?email=${email}`;
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
            url: "/CorePHP/auth/EditUser.php",
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
                        url: "/CorePHP/auth/DeleteUser.php",
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
    $(document).on("click", ".access-link-btn", function () {
    let row = $(this).closest("tr");
    let id = row.data("id");
    let name = row.data("name");

    Swal.fire({
        title: "Are you sure?",
        text: `You want to login As ${name}`,
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "gray",
        confirmButtonColor: "green",
        confirmButtonText: "Yes, Login it"
    }).then(function (result) {
        if (!result.isConfirmed) return;

        $.ajax({
            type: "POST",
            url: "/CorePHP/admin/backend/user/userlogin.php",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    window.location.href = "/CorePHP/user/index.php";
                } else {
                    Swal.fire("Error", response.error || "Something went wrong", "error");
                }
            },
            error: function (xhr) {
                console.log("AJAX error:", xhr.responseText);
                Swal.fire("Error", "Server error", "error");
            }
        });
    });
});

    const IMPORT_URL = '/CorePHP/admin/backend/user/importuser.php';

    const $dialog = $(`
        <dialog id="importDialog">
            <form id="importForm" enctype="multipart/form-data">
                <div class="import-dialog-box">
                    <h3>Import Products</h3>
                    <p>Select CSV file And Select Zip File For Image uplaod</p>
                    <input type="file" name="csv_file" id="csvFile" title="select csv file" accept=".csv" required>
                    <div class="import-progress" id="importProgress">
                        <div class="import-progress-bar" id="importProgressBar"></div>
                    </div>
                    <div id="importStatus" class="import-status"></div>
                    <div id="importMessage" class="import-message"></div>
                    <div class="import-dialog-actions">
                        <button type="button" class="btn" id="importCloseBtn">Close</button>
                        <button type="submit" class="btn" id="importSubmitBtn">Upload</button>
                    </div>
                </div>
            </form>
        </dialog>
    `);
    $('body').append($dialog);

    const dialogEl = $dialog[0];
    const $form = $('#importForm');
    const $msg = $('#importMessage');
    const $status = $('#importStatus');
    const $progress = $('#importProgress');
    const $bar = $('#importProgressBar');
    const $submitBtn = $('#importSubmitBtn');
    const $closeBtn = $('#importCloseBtn');

    function resetDialog() {
        $form[0].reset();
        $msg.text('').removeClass('success error');
        $status.text('');
        $progress.hide().removeClass('processing');
        $bar.css('width', '0%');
        $submitBtn.prop('disabled', false).text('Upload');
        $closeBtn.prop('disabled', false);
    }

    $(document).on('click', '.import-csv-btn', function () {
        resetDialog();
        dialogEl.showModal();
    });

    $(document).on('click', '#importCloseBtn', function () {
        dialogEl.close();
    });

    $dialog.on('click', function (e) {
        if (e.target === dialogEl && !$closeBtn.prop('disabled')) dialogEl.close();
    });

    $dialog.on('cancel', function (e) {
        if ($closeBtn.prop('disabled')) e.preventDefault();
    });

    $form.on('submit', function (e) {
        e.preventDefault();
       
        const file = $('#csvFile')[0].files[0];

        if (!file) {
            $msg.text('Please Select Image').removeClass('success').addClass('error');
            return;
        }

        if (!file.name.toLowerCase().endsWith('.csv')) {
            $msg.text('Only .csv file allowed hai.').removeClass('success').addClass('error');
            return;
        }
        const formData = new FormData(this);

        $.ajax({
            url: IMPORT_URL,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            xhr: function () {
                const xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        $bar.css('width', percent + '%');
                        $status.text('Uploading... ' + percent + '%');
                        if (percent === 100) {
                            $progress.addClass('processing');
                            $status.text('Processing... products import');
                        }
                    }
                });
                return xhr;
            },
            beforeSend: function () {
                $submitBtn.prop('disabled', true).text('Please wait...');
                $closeBtn.prop('disabled', true);
                $msg.text('').removeClass('success error');
                $bar.css('width', '0%');
                $progress.show().removeClass('processing');
                $status.text('Uploading... 0%');
            },
            success: function (res) {
                $progress.removeClass('processing');
                $bar.css('width', '100%');
                $closeBtn.prop('disabled', false);

                if (res.success) {
                    $status.text('Done');
                    $msg.text(res.message).removeClass('error').addClass('success');

                    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#product_datatable')) {
                        $('#product_datatable').DataTable().ajax.reload(null, false);
                    }

                    setTimeout(function () { dialogEl.close(); }, 9000);
                } else {
                    $status.text('');
                    $progress.hide();
                    $msg.text(res.message || 'Import failed').removeClass('success').addClass('error');
                    $submitBtn.prop('disabled', false).text('Upload');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                $status.text('');
                $progress.hide().removeClass('processing');
                $closeBtn.prop('disabled', false);
                $msg.text('Server error, try again.').removeClass('success').addClass('error');
                $submitBtn.prop('disabled', false).text('Upload');
            }
        });
    });

});