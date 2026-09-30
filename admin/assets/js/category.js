$(document).ready(function () {
    let table = null;

    const esc = (s) => $("<div>").text(s ?? "").html();

    if ($("#category_datatable").length) {
        initCategoryTable();
    }

    function initCategoryTable() {
        table = $("#category_datatable").DataTable({
            ajax: {
                url: "/CorePHP/admin/backend/Category/GetCategory.php",
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
                { data: "name", className: "category-name", render: (d) => esc(d) },
                { data: "created", render: (d) => esc(d) },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <button type="button" class="btn-icon edit-link-btn  edit-user" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="btn-icon delete-user" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>` }
            ],
            createdRow: function (row, c) {
                $(row).attr({
                    "data-id": c.id,
                    "data-name": c.name
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

$("#AddCategoryForm").on("submit",function(e){
    e.preventDefault();
    // console.log("Working Name");
     const CategoryName = $("#CategoryName");
     
     const CategoryNameValue = CategoryName.val().trim();
     if(CategoryNameValue.length == ''){
       $(".CategoryNameError").html("Category Feild Are Required ");
        CategoryName.focus();
        return; 
    }
     if(CategoryNameValue.length < 2){
        $(".CategoryNameError").html("Category Minimum 3 Letter");
        CategoryName.focus();
        return;
       }else{
        $.ajax({
            type:"POST",
            url:"/CorePHP/admin/backend/Category/CreateCategory.php",
            data:$(this).serialize(),
            success: function(response){
                if(response == "Exited"){
                    $(".CategoryNameError").html("This Category Name Are Allready Exited");
                    CategoryName.focus();
                }
                else if(response == "Success"){
                    Swal.fire({
                   'title':'Category Added SuccessFull',
                   'icon':'success'
                 }).then(()=>{
                     window.location = "./index.php"
                 })
                
                 
                 }
                 else{
                    Swal.fire({
                        'title':response
                    })
                 }

            }
        })
     }

})
$("#EditCategoryForm").on("submit",function(e){
    e.preventDefault();
    // console.log("Working Name");
     const CategoryName = $("#CategoryName");
     const CategoryNameValue = CategoryName.val().trim();
     if(CategoryNameValue.length == ''){
       $(".CategoryNameError").html("Category Feild Are Required ");
        CategoryName.focus();
        return; 
    }
     if(CategoryNameValue.length < 2){
        $(".CategoryNameError").html("Category Minimum 3 Letter");
        CategoryName.focus();
        return;
       }else{
        $.ajax({
            type:"POST",
            url:"/CorePHP/admin/backend/Category/UpdateCategory.php",
            data:$(this).serialize(),
            success: function(response){
                if(response == "Exited"){
                    $(".CategoryNameError").html("This Category Name Are Allready Exited");
                    CategoryName.focus();
                }
                else if(response == "Success"){
                    Swal.fire({
                   'title':'Category Updated SuccessFull',
                   'icon':'success'
                 }).then(()=>{
                     window.location = "./index.php"
                 })
                
                 
                 }
                 else{
                    Swal.fire({
                        'title':response
                    })
                 }

            }
        })
     }

});
$(document).on("click", ".delete-user", function () {

        let row = $(this).closest("tr");
        // let name = row.data("name");
        let name = row.find(".category-name").text().trim();
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
                        url: "/CorePHP/admin/backend/Category/DeleteCategory.php",
                        type: "POST",
                            data: {
                            name: name
                             },
                        success: function (response) {

                            if (response.trim() === "success") {
                             swal.fire({
                                'title':'Category are Deleted',
                                'icon':'success'
                             });

                             row.fadeOut(500, function () {
                             $(this).remove();
                           });
                            } else {
                            swal.fire({
                                'title':`${response}`,
                                 'icon':'warning'
                            });
                            }
                        },

                    error: function () {
                      swal.fire({
                        'title':'Something Are Wrong ',
                        'icon':'warning'
                      })
                }
                    });
                }
            })

    });
})