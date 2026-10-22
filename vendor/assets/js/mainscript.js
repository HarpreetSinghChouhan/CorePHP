$(document).ready(function(){
    let table = null;
    $(document).on("click",".edit-link-btn",function(){
        let row = $(this).closest("tr");
        let id = row.data("id");
        window.location = `./edit.php?id=${id}`; 
    })
    $(document).on("click",".create-link-btn",function(){
        window.location = "./create.php";
    })
    $(document).on("click",".view-link-btn",function(){
         let row = $(this).closest("tr");
        let id = row.data("id");
        window.location = `./view.php?id=${id}`;
    })
    $(document).on("click",".back-to-admin",function(){
        window.location = "/CorePHP/admin/backend/vendor/loginadmin.php";
    });
    $(document).on("click",".order-page",function(){
        window.location = "/CorePHP/vendor/order/index.php";
    })
    $(document).on("click",".product-page",function(){
        window.location = "/CorePHP/vendor/product/index.php";
    })
    // $(document).on("click",".product-page",function(){
    //     window.location = "/CorePHP/vendor/product/index.php";
    // })
    
     
})