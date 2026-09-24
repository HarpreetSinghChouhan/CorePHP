$(document).ready(function () {
  
    $('.create-link-btn').on("click",function(){
        window.location.href = "./create.php";
    });
    $('.view-link-btn').on("click",function(){
        window.location.href = `./view.php?id=${id}`;
    });
    $('.btn-back').on("click",function(){
        window.location.href = "./index.php";
    })
    // $(".edit-link-btn").on("click",function(){
    //     window.location.href = "./edit.php";
    // })
     $(document).on("click",'.edit-link-btn',function(){
                let row = $(this).closest("tr");
        let id = row.data("id");

        window.location = `./edit.php?id=${id}`;

    //   window.location.href = "./edit.php";
 })
   
});