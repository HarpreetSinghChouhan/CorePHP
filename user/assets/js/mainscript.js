$(document).ready(function(){
     $(document).on("click",".cart-link",function(){
          window.location.href = "/CorePHP/cart.php"
     }) 
     // console.log("Wosking on every Page");   
     $(document).on("click",".cart-link-btn",function(){
          window.location.href = "/CorePHP/user/cartitem/cartitem.php";
     })
     $(document).on("click",".order-link-btn",function(){
          window.location.href = "/CorePHP/user/order/orders.php";
     })
     $(document).on("click",".wishlist-link-btn",function(){
          window.location.href = "/CorePHP/user/wishlist/wishlist.php";
     })
     
})