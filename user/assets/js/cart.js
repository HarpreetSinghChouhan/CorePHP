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
    if (window.location.href.indexOf("cart.php") > -1) {
    GetProduct();
} 
function GetProduct(){
    const cart = $(".cart-grid");
    const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
let allProducts = [];
let currentPage = 1;
let cardHtml ='';
const rowsPerPage = 10;
$.ajax({
    type: "GET",
    datatype: "json",  
    url: "/CorePHP/user/backend/product/GetCart.php",
    success: function(response) {
        renderCart(response);
    },
    error: function(xhr, status, error) {
        Toast.fire({
            'icon':'warning',
            'title':xhr.responseText
        })
    // console.log("Status Code:", xhr.status);
    // console.log("Response Text:", xhr.responseText);
}
});


function renderCart(cartItems) {
    if (typeof cartItems === "string") {
        cartItems = JSON.parse(cartItems);
    }
    window.cartItemsData = cartItems;

    let container = $("#cart-container");
    container.empty();
if (!Array.isArray(cartItems) || cartItems.length === 0) {
    $(".cart-grid").addClass("cart-empty");  
    $("#price-details").empty().hide(); 

    container.html(`
        <div class="empty-cart-state">
            <div class="empty-cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h3 class="empty-cart-title">Your cart is empty</h3>
            <p class="empty-cart-text">Looks like you haven't added anything yet. Start exploring and fill it up!</p>
            <a href="/CorePHP/home.php" class="empty-cart-btn">Continue Shopping</a>
        </div>
    `);
    return;
}
$(".cart-grid").removeClass("cart-empty");
$("#price-details").show();
let stock = 1  ;

    cartItems.forEach(function(item) {
        let mrp = parseFloat(item.mrp || item.price || 0);
        let price = parseFloat(item.price || 0);
        let discountPercent = mrp > 0 ? Math.round(((mrp - price) / mrp) * 100) : 0;
        if(item.stock == 0){
            stock = item.stock;
            cardHtml += `
             <div class="header-out-stock" > OUT OF STOCK</div>
            <div class="cart-card out-stock-card" data-id="${item.id}" data-name="${item.name}" data-user_id="${item.user_id}"  >
                <img src="${item.image}" alt="${item.name}" class="cart-img">
                <div class="cart-details">
                    <h3 class="cart-name">${item.name}</h3>
                    <p class="category">${item.category_name}</p>
                    <p class="seller"><b> description: </b> ${item.description || "N/A"}</p>
                    <div class="price-row">
                        ${discountPercent > 0 ? `<span class="discount-percent">↓${discountPercent}%</span>` : ""}
                        ${discountPercent > 0 ? `<span class="mrp">₹${mrp}</span>` : ""}
                        <span class="final-price">₹${price}</span>
                    </div>
                   <div style="display:flex" >
                    <div class="qty-control qty-control-${item.id}">
                        <button class="qty-btn decrease-btn" ${parseInt(item.quantity) <= 1 ? "disabled" : ""}>−</button>
                        <span class="qty">Qty: ${item.quantity}</span>
                        <button class="qty-btn increase-btn">+</button>   
                    </div>
                    <div class="stock stock-${item.id}"><p class="stock-msg">Out Of Stock </p>  </div>
                    <i class="fa-solid fa-trash remove-btn"></i>
                   </div>
                </div>
            </div>
        `; 
        }
       
        // if(item.quantity ==0){

        // }
    })
    
       if(stock == 0){
         cardHtml += "<hr class='price-divider' >";
       }
    cartItems.forEach(function(item) {
        let mrp = parseFloat(item.mrp || item.price || 0);
        let price = parseFloat(item.price || 0);
        let discountPercent = mrp > 0 ? Math.round(((mrp - price) / mrp) * 100) : 0;
        if(item.stock !=0){
             cardHtml += `
            <div class="cart-card" data-id="${item.id}" data-name="${item.name}" data-user_id="${item.user_id}"  >
                <img src="${item.image}" alt="${item.name}" class="cart-img">
                <div class="cart-details">
                    <h3 class="cart-name">${item.name}</h3>
                    <p class="category">${item.category_name}</p>
                    <p class="seller"><b> description: </b> ${item.description || "N/A"}</p>
                    <div class="price-row">
                        ${discountPercent > 0 ? `<span class="discount-percent">↓${discountPercent}%</span>` : ""}
                        ${discountPercent > 0 ? `<span class="mrp">₹${mrp}</span>` : ""}
                        <span class="final-price">₹${price}</span>
                    </div>
                   <div style="display:flex" >
                    <div class="qty-control   qty-control-${item.id}">
                        <button class="qty-btn decrease-btn" ${parseInt(item.quantity) <= 1 ? "disabled" : ""}>−</button>
                        <span class="qty">Qty: ${item.quantity}</span>
                        <button class="qty-btn increase-btn">+</button>   
                    </div>
                    <div class="stock stock-${item.id}"><p class="stock-msg">Out Of Stock </p>  </div>
                    <i class="fa-solid fa-trash remove-btn"></i>
                   </div>
                  
                </div>
            </div>
        `;
        }
        container.html(cardHtml);
        // console.log("Working ??")
        //   if(item.quantity == 0){
        //     container.find(`.qty-control-${item.id}`).hide();
        //     // $(`.qty-control-${item.id}`).hide();
        //      container.find(`.stock-${item.id}`).show();
        //   }
        //   else {
        //      container.find(`.stock-${item.id}`).hide();
        //      container.find(`.qty-control-${item.id}`).show();
        //   }
        requestAnimationFrame(() => {
    if (item.stock == 0) {
        $(`.qty-control-${item.id}`).hide();
        $(`.stock-${item.id}`).show();
    } else {
        $(`.stock-${item.id}`).hide();
        $(`.qty-control-${item.id}`).show();
    }
});
    });
    

    renderPriceDetails(cartItems);
}
function renderPriceDetails(cartItems){
    let itemCount = 0;
    let totalPrice = 0;
    let totalMrp = 0;
    let totalProtectFee = 0;
    let user_id = null;
    cartItems.forEach(function(item){
        user_id = parseInt(item.user_id || "null");
        let qty = parseInt(item.quantity || 0);
        let mrp = parseFloat(item.mrp || item.price || 0);
        let price = parseFloat(item.price || 0);
        let protectFee = parseFloat(item.protect_fee || 0);

        itemCount += qty;
        totalPrice += price * qty;
        totalMrp += mrp * qty;
        totalProtectFee += protectFee * qty;
    });

    let discount = totalMrp - totalPrice;
    let totalAmount = totalPrice + totalProtectFee;

    let priceHtml = `
        <h3>Price Details</h3>
        <div class="price-line">
            <span>Price (${itemCount} item${itemCount > 1 ? "s" : ""})</span>
            <span>₹${totalMrp.toFixed(0)}</span>
        </div>
        <div class="price-line discount">
            <span>Discount</span>
            <span>− ₹${discount.toFixed(0)}</span>
        </div>
        <hr class="price-divider">
        <div class="total-line">
            <span>Total Amount</span>
            <span>₹${totalAmount.toFixed(0)}</span>
        </div>
        <div class="payment-btn-div" data-user_id="${user_id}" data-price="${totalAmount}" data-item="${itemCount}" > <button class="payment-btn"  > Buy All Product </button>  </div>
        ${discount > 0 ? `<div class="savings-banner">🎉 You'll save ₹${discount.toFixed(0)} on this order!</div>` : ""}
    `;

    $("#price-details").html(priceHtml);
}

}
$(document).on("click", ".decrease-btn", function(e){
    e.stopPropagation();
    if ($(this).prop("disabled")) return;
    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, -1);
});
$(document).on("click", ".increase-btn", function(e){
    e.stopPropagation();
    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, 1);
});
$(document).on("click", ".payment-btn", function(e){
  e.preventDefault();
  const div = $(".payment-btn");
    let price = div.closest('.payment-btn-div').data('price');
    let totalItem = div.closest('.payment-btn-div').data('item');
    let user_id = div.closest('.payment-btn-div').data('user_id');
//   console.log(price , totalItem);
//   return;
   let data =  {'price':price,'item':totalItem, 'user_id':user_id};
  $.ajax({
    type: "POST",
    url: "/CorePHP/user/backend/payment/StripeSessionCurl.php",
    dataType: "json",
    data:data,
    success: function(response){
      if (response.success) {
        window.location.href = response.url; 
      } else {
        Swal.fire({
          icon: "error",
          title: "",
          text: JSON.stringify(response.error)
        });
      }
    },
    error: function(xhr){
      Swal.fire({
        icon: "error",
        title: "Request Failed",
        text: xhr.responseText
      });
    }
  });
});
$(document).on("click", ".remove-btn", function(e){
    e.stopPropagation();
    let id = $(this).closest(".cart-card").data("id");
    // let user_id = $(this).closest(".cart-card").data("user_id");
    let name = $(this).closest(".cart-card").data("name");

    removeFromCart(id,name);
});
   function removeFromCart(id,name){
      const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
     swal.fire({
                 'title':'Are you sure?',
                'text':`You Want To Remove ${name}`,
                'icon':'warning',
                'showCancelButton':true,
                'cancelButtonColor':'Green',
                'confirmButtonColor':'Red',
                'confirmButtonText':'Yes, Remove it',
            }).then((result)=>{
                if(result.isConfirmed){
         $.ajax({
        type: "POST",
        url: "/CorePHP/user/backend/cart/DeleteCart.php",
        data: { id: id },
        success: function(response){
            let data = response;
            if (typeof data === "string") {
                data = JSON.parse(data);
            }

            if (data.error) {
                swal.fire({
                    'title':`${data.error}`,
                    'icon':'warning'
                    });
                return;
            }
            swal.fire({
                'title':`${data.message}`,
                'icon':'success'
                });
             $.ajax({
                    type: "GET",
                    url: "/CorePHP/user/backend/product/CountCart.php",
                    success: function(countResponse){
                        $(".cart-count").html(`${countResponse}`);
                    }
                });
            $(`.cart-card[data-id="${id}"]`).remove();
            window.cartItemsData = window.cartItemsData.filter(i => i.id != id);
            renderPriceDetailsFromGlobal();
        },
        error: function(xhr){
            swal.fire({
                    'title':`${xhr.responseText}`,
                    'icon':'warning'
                    });
        }
    });
}
else{

}
})}
function updateQuantity(id, change) {
      const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
    let item = window.cartItemsData.find(i => i.id == id);
    if (!item) return;

    let newQty = parseInt(item.quantity) + change;

    if (newQty <= 0) {
        removeFromCart(id);
        return;
    }

    let card = $(`.cart-card[data-id="${id}"]`);

    $.ajax({
        type: "POST",
        url: "/CorePHP/user/backend/cart/UpdateQuantity.php",
        data: { id: id, quantity: newQty },
        success: function(response){
            let data = response;
            // console.log(data);
            if (typeof data === "string") {
                data = JSON.parse(data);
            }

            if (data.error) {
                Toast.fire({
                    'icon':'warning',
                    'title':data.error
                })
                return;
            }

            item.quantity = data.quantity;
            card.find(".qty").text(`Qty: ${item.quantity}`);
            card.find(".decrease-btn").prop("disabled", item.quantity <= 1);
            card.find(".increase-btn").prop("disabled", item.quantity >= data.available_stock);
            
            
            if (data.limited) {
                card.find(".stock-msg").remove();
                card.find(".qty-control").after(`<p class="stock-msg">Only ${data.available_stock} left in stock</p>`);
                           
            } else {
                card.find(".stock-msg").remove();
            }
            Toast.fire({
                'icon':'success',
                'title':data.message
            });
            renderPriceDetailsFromGlobal();
        },
        error: function(xhr){
            
                Toast.fire({
                    'icon':'warning',
                    'title':xhr.responseText
                })
            console.log("Update failed:", xhr.responseText);
        }
    });
}
function renderPriceDetailsFromGlobal(){
    let itemCount = 0;
    let totalPrice = 0;
    let totalMrp = 0;
    let totalProtectFee = 0;
  let user_id = null
    let cartItems = window.cartItemsData || [];

    if (cartItems.length === 0) {
        $("#price-details").empty();
        // $("#cart-container").html("<p class='empty-cart'>Cart Are Empty 🛒</p>");
           $(".cart-grid").addClass("cart-empty");  
    $("#price-details").empty().hide(); 

    $("#cart-container").html(`
        <div class="empty-cart-state">
            <div class="empty-cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h3 class="empty-cart-title">Your cart is empty</h3>
            <p class="empty-cart-text">Looks like you haven't added anything yet. Start exploring and fill it up!</p>
            <a href="/CorePHP/home.php" class="empty-cart-btn">Continue Shopping</a>
        </div>
    `);
    return;
    }

    cartItems.forEach(function(item){
        user_id = parseInt(item.user_id);
        let qty = parseInt(item.quantity || 0);
        let mrp = parseFloat(item.mrp || item.price || 0);
        let price = parseFloat(item.price || 0);
        let protectFee = parseFloat(item.protect_fee || 19);
        
        itemCount += qty;
        totalPrice += price * qty;
        totalMrp += mrp * qty;
        totalProtectFee += protectFee * qty;
    });

    let discount = totalMrp - totalPrice;
    let totalAmount = totalPrice + totalProtectFee;
     
     $(".cart-count").html(`${itemCount}`);
    let priceHtml = `
        <h3>Price Details</h3>
        <div class="price-line">
            <span>Price (${itemCount} item${itemCount > 1 ? "s" : ""})</span>
            <span>₹${totalMrp.toFixed(0)}</span>
        </div>
        <div class="price-line discount">
            <span>Discount</span>
            <span>− ₹${discount.toFixed(0)}</span>
        </div>
        <hr class="price-divider">
        <div class="total-line">
            <span>Total Amount</span>
            <span>₹${totalAmount.toFixed(0)}</span>
        </div>
         <div class="payment-btn-div" data-user_id="${user_id}" data-price="${totalAmount}" data-item="${itemCount}" > <button class="payment-btn"  > Buy All Product </button>  </div>
        ${discount > 0 ? `<div class="savings-banner">🎉 You'll save ₹${discount.toFixed(0)} on this order!</div>` : ""}
    
         
        `;

    $("#price-details").html(priceHtml);
}
});