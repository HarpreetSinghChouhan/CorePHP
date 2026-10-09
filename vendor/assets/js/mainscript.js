$(document).ready(function(){
    // console.log("MainScript Working");
    $(document).on("click",".edit-link-btn",function(){
        let row = $(this).closest("tr");
        let id = row.data("id");
        window.location = `./edit.php?id=${id}`; 
    })
})