$(document).ready(function () {

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
    let table = null;
    let AllCartItem =[];
    const esc = (s) => $("<div>").text(s ?? "").html();
  if (window.location.href.indexOf("view.php") > -1) {
        GetCart_Items();
    }
      if (window.location.href.indexOf("edit.php") > -1) {
        GetCart_Item();
    }
    if ($("#cart_datatable").length) {
        initCartTable();
    }
    function initCartTable() {
        table = $("#cart_datatable").DataTable({
            ajax: {
                url: "/CorePHP/admin/backend/cart/Cart.php",
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
                { data: "user_name", render: (d) => esc(d) },
                { data: "email", render: (d) => esc(d) },
                { data: "total_items", render: (d) => esc(d) },
                { data: "total_quantity", render: (d) => esc(d) },
                { data: "total_price", render: (d) => esc(d) },
               {data: null,
                orderable: false,searchable: false,className: "action-cell",
                render: () => `<div class="action-wrap">
                <button type="button" class="btn-icon edit-link-btn  edit-btn" title="View">
                        <i class="fa-solid fa-pencil"></i>
                    </button>    
                <button type="button" class="btn-icon view-link-btn view-cart edit-btn" title="View">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button type="button" class="btn-icon delete-cart delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    </div>`
                }
                    
            ],
            createdRow: function (row, c) {
                $(row).attr({
                    "data-id": c.user_id,
                    "data-name": c.user_name,
                    "data-email": c.email,
                    "data-total_items": c.total_items,
                    "data-total_quantity": c.total_quantity,
                    "data-total_price": c.total_price
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
   
    $(document).on("click", ".delete-cart", function () {

        let row = $(this).closest("tr");
        let id =  row.data("id");
        let name = row.data("name");
       
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
                        url: `/CorePHP/admin/backend/cart/CartDelete.php?id=${id}`,
                        type: "DELETE",
                        success: function (response) {

                            if (response.trim() === "success") {
                             swal.fire({
                                'title':'cart are Deleted',
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

    function GetCart_Items(){
        const params = new URLSearchParams(window.location.search);
        let id = params.get("id");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: `/CorePHP/admin/backend/Cart/CartItem.php?id=${id}`,
            success: function (response) {
                AllCartItem = response;
                $(".cart-item").html(AllCartItem.length);
                renderOrderItem();
            }
        });
    }

    function renderOrderItem() {
        let html = "";

        if (!AllCartItem || AllCartItem.length === 0) {
            $(".cart-item").html(`<div class="no-items">No items found for this order.</div>`);
            return;
        }

        AllCartItem.forEach(item => {
            $('.user-name').html(item.user_email)
            html += `
                <div class="cart-item-card">
                    <div class="item-img">
                        <img src="${item.product_image}" alt="${item.product_name}">
                    </div>
                    <div class="item-info">
                        <h4>${item.product_name}</h4>
                        <p class="item"><strong>price:</strong> ${item.product_price}</p>
                        <p class="item-sku">SKU: ${item.product_sku}</p>
                        <p class="item-sku">descripton: ${item.description}</p>
                    </div>
                    <div class="item-qty">
                        <span>Qty</span>
                        <strong>${item.product_quantity}</strong>
                    </div>
                    <div class="item-price">₹${item.product_price * item.product_quantity}</div>
                </div>`;
        });


        $(".cart-item").html(html);
    
    }
    function GetCart_Item(){

     const params = new URLSearchParams(window.location.search);
        let id = params.get("id");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: `/CorePHP/admin/backend/Cart/CartItem.php?id=${id}`,
            success: function (response) {
                AllCartItem = response;
                $(".cart-item").html(AllCartItem.length);
                renderOrderItem2();
            }
        });
    }

    function renderOrderItem2() {
        let html = "";

        if (!AllCartItem || AllCartItem.length === 0) {
            $(".cart-item").html(`<div class="no-items">No items found for this order.</div>`);
            return;
        }

        AllCartItem.forEach(item => {
            $('.user-name').html(item.user_email)
            html += `
                <div class="cart-item-card">
                    <div class="item-img">
                        <img src="${item.product_image}" alt="${item.product_name}">
                    </div>
                    <div class="item-info">
                        <h4>${item.product_name}</h4>
                        <p class="item"><strong>price:</strong> ${item.product_price}</p>
                        <p class="item-sku">SKU: ${item.product_sku}</p>
                        <p class="item-sku">descripton: ${item.description}</p>
                    </div>
                    <div class="item-qt cart-card" data-id="${item.id}"  >
                        <button type="button" class="decrease-btn btn" data-id="${item.id}"> - </button>
                        <strong>${item.product_quantity}</strong>
                        <button type="button" class="increase-btn btn" data-id="${item.id}"> + </button>
                    </div> 
                    <div class="item-price">₹${item.product_price * item.product_quantity}</div>
                    <div  class="cart-id" data-id="${item.id}" data-name="${item.product_name}" > <button class="delete-btn cart-item-delete btn" data-id="${item.cart_id}" > <i class="fa-solid fa-trash" ></i> </button> </div>
                </div>`;
        });


        $(".cart-item").html(html);
    
    }
$(document).on("click",".decrease-btn", function(e){
    e.stopPropagation();
    console.log("Working decrease");
    if ($(this).prop("disabled")) return;
    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, -1);
});
$(document).on("click", ".increase-btn", function(e){
    e.stopPropagation();
    console.log("Working increase");

    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, 1);
});


function updateQuantity(id, change) {
    
    let item = AllCartItem.find(i => i.id == id);
    if (!item) return;

    let newQty = parseInt(item.product_quantity) + change;

    if (newQty <= 0) {
        Toast.fire({
            'icon':'warning',
            'title':'reached Minimum quantity' 
        });
        return;
    }

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

            item.product_quantity = data.quantity;
            renderOrderItem2();

            Toast.fire({
                'icon':'success',
                'title':data.message
            });
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

$(document).on("click",".cart-item-delete", function(){

     let box = $(this).closest('.cart-id');
     let card = $(this).closest('.cart-item-card');
     let id = box.data('id');
     let name = box.data('name');
    //  console.log("id :- " , id  , "name :-", name);

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
                        type: "POST",
                        dataType: "json",
                        url: "/CorePHP/user/backend/cart/DeleteCart.php",
                        data: { id: id },
                        success: function (data) {

                            if (data.error) {
                                Toast.fire({
                                    'title': data.error,
                                    'icon':'warning'
                                });
                                return;
                            }

                            AllCartItem = AllCartItem.filter(i => i.id != id);
                            $(".cart-item").prev().find(".cart-item").html(AllCartItem.length);

                            card.fadeOut(500, function () {
                                $(this).remove();
                                if (AllCartItem.length === 0) {
                                    renderOrderItem2();
                                }
                            });

                            Toast.fire({
                                'title': data.message,
                                'icon':'success'
                            });
                        },

                        error: function (xhr) {
                            console.log("Delete failed:", xhr.responseText);
                            swal.fire({
                                'title':'Something Are Wrong ',
                                'icon':'warning'
                            })
                        }
                    });
                }
            })

    });

});