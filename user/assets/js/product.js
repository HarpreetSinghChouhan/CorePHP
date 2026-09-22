$(document).ready(function(){
    $.ajax({
        type:"GET",
        url:"/CorePHP/user/backend/product/CountCart.php",
        success:function(response){
                        $(".cart-count").html(`${response}`)
          },
        error: function(response){
            console.log(response);
        }
    })
    // if (window.location.href.indexOf("home.php") > -1) {
    GetProduct();
// }
function GetProduct(){
    const product = $(".product-grid");
    let allProducts = [];
    let currentPage = 1;
    const rowsPerPage = 10;
    $.ajax({
        type:'GET',
        url:"/CorePHP/user/backend/product/GetProduct.php",
        dataType:"json",
        success:function(response){
            // console.log(response);
            let html = ''
             $.each(response, function(index, item){
        let description = `${item.description.length > 40 ? item.description.slice(0, 50) + '...' : item.description}`;
             html += `<article class="product-card" data-id='${item.id}' data-category='${item.category_name}' data-name='${item.name}' data-sku='${item.sku}' data-price='${item.price}' >
                    <a href="product.php?id=${item.id}" class="card-media">
                    <img src="${item.image}" alt="${item.name}">
                    <span class="badge badge-new">New</span>
                    <button class="wishlist-btn" aria-label="Add to wishlist" type="button">
                       <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s-7.5-4.6-10-9.3C.4 8 2 4 6 4c2 0 3.5 1.2 6 4 2.5-2.8 4-4 6-4 4 0 5.6 4 4 7.7C19.5 16.4 12 21 12 21z"/></svg>
                    </button>
                   </a>
                   <div class="card-body">
                     <p class="card-category">${item.category_name}</p>
                     <h3 class="card-title"><a href="product.php?id=${item.id}">${item.name}</a></h3>
                     <div class="card-price">
                     <span class="price-now">₹${item.price}</span>
                     </div>
                     <div class="card-rating"><span>${description}</span></div>
                     <button class="btn btn-add-cart" type="button" data-product-id="${item.id}">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L22 8H6"/></svg>
                             Add to Cart
                     </button>
                 </div>
               </article> `;     
             });
          product.html(html);
      
        },
        error:function(response){
            console.log("Error")
        }
    });
    $.ajax({
        type:"GET",
        url:"/CorePHP/user/backend/product/CountCart.php",
        success:function(response){
                        $(".cart-count").html(`${response}`)
          }
    })
}
  $(document).on("click",".btn-add-cart",function(){
    console.log("Working Add to Card");
    let id = $(this).data("product-id");
    let data = {'product_id':id}
    $.ajax({
        type:"POST",
        url: "/CorePHP/user/backend/product/AddToCart.php",
        data:data,
        success:function(response){
            if(response === "Quantity Increase"){
                $.ajax({
                    type:"GET",
                    url:"/CorePHP/user/backend/product/CountCart.php",
                    success:function(response){
                        $(".cart-count").html(`${response}`)
                    }
                })
            }
            else{
                $.ajax({
                    type:"GET",
                    url:"/CorePHP/user/backend/product/CountCart.php",
                    success:function(response){
                        $(".cart-count").html(`${response}`)
                    }
                })
           } 
            }
    })
  })
})