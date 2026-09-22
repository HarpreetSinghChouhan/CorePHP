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
let allProducts = [];
let currentPage = 1;
const rowsPerPage = 10;
$.ajax({
    type: "GET",
    datatype: "json",  
    url: "/CorePHP/user/backend/product/GetCart.php",
    success: function(response) {
        renderCart(response);
    },
    error: function(xhr, status, error) {
    console.log("Status Code:", xhr.status);
    console.log("Response Text:", xhr.responseText);
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
        container.html("<p class='empty-cart'>Cart Are Empty 🛒</p>");
        $("#price-details").empty();
        return;
    }
    cartItems.forEach(function(item) {
        let mrp = parseFloat(item.mrp || item.price || 0);
        let price = parseFloat(item.price || 0);
        let discountPercent = mrp > 0 ? Math.round(((mrp - price) / mrp) * 100) : 0;
      

        let cardHtml = `
            <div class="cart-card" data-id="${item.id}">
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
                    <div class="qty-control">
                        <button class="qty-btn decrease-btn" ${parseInt(item.quantity) <= 1 ? "disabled" : ""}>−</button>
                        <span class="qty">Qty: ${item.quantity}</span>
                        <button class="qty-btn increase-btn">+</button>
                    </div>
                  
                    <div class="cart-footer">
                        <button class="save-btn">Save for later</button>
                        <button class="buy-btn">Buy this now</button>
                         <button class="remove-btn">Remove</button>
                    </div>
                </div>
            </div>
        `;
        container.append(cardHtml);
    });

    renderPriceDetails(cartItems);
}

function renderPriceDetails(cartItems){
    let itemCount = 0;
    let totalPrice = 0;
    let totalMrp = 0;
    let totalProtectFee = 0;

    cartItems.forEach(function(item){
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

$(document).on("click", ".remove-btn", function(e){
    e.stopPropagation();
    let id = $(this).closest(".cart-card").data("id");
    removeFromCart(id);
});
function removeFromCart(id){
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
                console.log("Removed failed:", data.error);
                return;
            }

            $(`.cart-card[data-id="${id}"]`).remove();
            window.cartItemsData = window.cartItemsData.filter(i => i.id != id);
            renderPriceDetailsFromGlobal();
        },
        error: function(xhr){
            console.log("Removed failed:", xhr.responseText);
        }
    });
}
function updateQuantity(id, change) {
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
            if (typeof data === "string") {
                data = JSON.parse(data);
            }

            if (data.error) {
                console.log("Update failed:", data.error);
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

            renderPriceDetailsFromGlobal();
        },
        error: function(xhr){
            console.log("Update failed:", xhr.responseText);
        }
    });
}
function renderPriceDetailsFromGlobal(){
    let itemCount = 0;
    let totalPrice = 0;
    let totalMrp = 0;
    let totalProtectFee = 0;

    let cartItems = window.cartItemsData || [];

    if (cartItems.length === 0) {
        $("#price-details").empty();
        $("#cart-container").html("<p class='empty-cart'>Cart Are Empty 🛒</p>");
        return;
    }

    cartItems.forEach(function(item){
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
        ${discount > 0 ? `<div class="savings-banner">🎉 You'll save ₹${discount.toFixed(0)} on this order!</div>` : ""}
    `;

    $("#price-details").html(priceHtml);
}
});