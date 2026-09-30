$(document).ready(function(){
    let allCartItem = [];
    let currentPage = 1;
    let rowsPerPage = $('.select-row-number').val();
    if (window.location.href.indexOf("cartitem.php") > -1) {
        GetCart();
    }
    if(window.location.href.indexOf("view.php") > -1){
      GetOrder_Item()
    }
    function GetCart(){
         $.ajax({
            type:"GET",
            dataType:"json",
            url:"/CorePHP/user/backend/product/GetCart.php",
            success: function(response){
                allCartItem = response;
                let totalorder = allCartItem.length
                 $(".total-order").html(totalorder);
                currentPage = 1;
                renderOrder();
            }
        })
    }
      function renderOrder(){
        const TableBody = $(".cartitem-tbody");
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let pageData = allCartItem.slice(start, end);

        let html = ""
        
        $.each(pageData, function(index, item){
            let totalprice = item.price * item.quantity;
           html += `<tr data-id="${item.id}" data-name="${item.name}" >
    <td>${start + index + 1}</td>
    <td class='cart-image'><img src="${item.image}" alt="${item.name}" /></td>
    <td>${item.name}</td>
    <td>${item.price}</td>
    <td>${item.quantity}</td>
    <td>${totalprice}</td>
    <td class='action-cell'>
        <button type='button' class='btn-icon edit-cart-btn edit-btn' title='Edit'>
            <i class='fa-solid fa-pencil'></i>
        </button>
        <button type='button' class='btn-icon btn-delete-cart delete-btn' title='Delete'>
            <i class='fa-solid fa-trash'></i>
        </button>
    </td></tr>`;
        }); 

        if(pageData.length === 0){
            html = `<tr><td colspan="7" style="text-align:center; padding:20px;">No orders found</td></tr>`;
        }

        TableBody.html(html);
        renderPagination();
    }
      function renderPagination(){
        
        let totalPages = Math.ceil(allCartItem.length / rowsPerPage);
        let pagHtml = "";

        pagHtml += `<button type="button" class="page-btn prev-page" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

        for (let i = 1; i <= totalPages; i++) {
            pagHtml += `<button type="button" class="page-btn page-number ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }

        pagHtml += `<button type="button" class="page-btn next-page" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}>Next</button>`;

        $(".pagination").html(pagHtml);
    }

    // Event delegation zaroori hai kyunki yeh buttons dynamically bante hain
    $(document).on("click", ".prev-page", function(){
        if(currentPage > 1){
            currentPage--;
            renderOrder();
        }
    });

    $(document).on("click", ".next-page", function(){
        let totalPages = Math.ceil(allOrder.length / rowsPerPage);
        if(currentPage < totalPages){
            currentPage++;
            renderOrder();
        }
    });
  $(document).on("click",".view-link-btn",function(){
    let order_id = $(this).closest("tr").data('id');
    window.location.href = `./view.php?id=${order_id}`
  })
    $(document).on("click", ".page-number", function(){
        currentPage = parseInt($(this).data("page"));
        renderOrder();
    });
   function GetOrder_Items(){
        const params = new URLSearchParams(window.location.search);
         let id = params.get("id"); 
        
        $.ajax({
            type:"GET",
            dataType:"json",
            url:`/CorePHP/user/backend/order/OrderItem.php?id=${id}`,
            success: function(response){
                AllOrderItem = response;
                let totalorder = allOrder.length
                 $(".total-order").html(totalorder);
                currentPage = 1;
                renderOrderItem();
            }
        })
   }
   function renderOrderItem(){
    let html = "";

    if(!AllOrderItem || AllOrderItem.length === 0){
        html = `<div class="no-items">No items found for this order.</div>`;
        $("#order-items-container").html(html);
        return;
    }

    AllOrderItem.forEach(item => {
        html += `
            <div class="order-item-card">
                <div class="item-img">
                    <img src="${item.image}" alt="${item.product_name}">
                </div>
                <div class="item-info">
                    <h4>${item.product_name}</h4>
                    <p class="item-cat">${item.category_name}</p>
                    <p class="item-sku">SKU: ${item.sku}</p>
                </div>
                <div class="item-qty">
                    <span>Qty</span>
                    <strong>${item.quantity}</strong>
                </div>
                <div class="item-price">
                    ₹${item.price}
                </div>
            </div>
        `;
    });
     html += `<div></div>`

    $("#order-items-container").html(html);
}

$(document).on("click",".edit-cart-btn",function(){
    let id = $(this).closest("tr").data('id');
    window.location.href = `./edit.php?id=${id}`
})
$(document).on("click", ".btn-delete-cart", function(e){
    e.stopPropagation();
    let id = $(this).closest("tr").data("id");
    let name = $(this).closest("tr").data("name");

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
            $(`tr[data-id="${id}"]`).remove();
                if ($('.cartitem-tbody tr').length === 0) {
                    GetCart();         
        }},
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
function updateQuantity(id, change) {
    const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    let currentQty = parseInt($("#qtyValue").text());
    let newQty = currentQty + change;

    if (newQty <= 0) {
        removeFromCart(id, $(".cart-item__title").text());
        return;
    }
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
                Toast.fire({ icon: 'warning', title: data.error });
                return;
            }
           // UI update
$("#qtyValue").text(data.quantity);
$("#qtyMinus").prop("disabled", data.quantity <= 1);
$("#qtyPlus").prop("disabled", data.quantity >= data.available_stock);

// Total price update
let price = parseFloat($(".cart-item").data("price"));
let totalprice = price * data.quantity;
console.log(" Total Price ", totalprice);
$(".total-price").text(totalprice.toLocaleString("en-IN"));
        //  $(".total-price").text(`${price}`);
            $("#stockMsg").hide();
            if (data.limited) {
                $("#stockMsg")
                    .text(`Only ${data.available_stock} left in stock`)
                    .show();
            }
            Toast.fire({ icon: 'success', title: data.message });
        },
        error: function(xhr){
            Toast.fire({ icon: 'warning', title: xhr.responseText });
            console.log("Update failed:", xhr.responseText);
        }
    });
}
});