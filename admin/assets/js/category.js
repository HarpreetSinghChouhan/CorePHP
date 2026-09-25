$(document).ready(function(){
// console.log("Category PAge Are Working");
if (window.location.href.indexOf("index.php") > -1) {
        runCheckoutLogic();
    }
function runCheckoutLogic(){
    // console.log("Category Index Page");
    let data = null 
    const TableBody = $(".category-tbody");  
    $.ajax({
        type:"GET",
        url:"/CorePHP/admin/backend/Category/GetCategory.php",
        dataType:"json",
        success: function(response){
            data = response;
            let html = ""
            $.each((response), function(index, item){
                html += `<tr data-id='${item.id}'
                              data-name='" ${item.name}"'>
                         <td> ${item.id} </td>
                         <td class='user-name' > ${item.name}  </td>
                         <td> ${item.created} </td>
                         <td class='action-cell'>
                            <button type='button' class='btn-icon edit-link-btn edit-user' title='Edit'>
                                <i class='fa-solid fa-pen'></i>
                            </button>
                            <button type='button' class='btn-icon delete-user' title='Delete'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </td></tr>`;
            });
            TableBody.html(html); 
    // console.log(data);
        },
        error: function(response){
          Swal.fire({"title":response,"icon":"warning"});
        }
    })
    // console.log(data);
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

});
$(document).on("click", ".delete-user", function () {

        let row = $(this).closest("tr");
        // let name = row.data("name");
        let name = row.find(".user-name").text().trim();
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
                                'title':'User are Deleted',
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