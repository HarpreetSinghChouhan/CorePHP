$(document).ready(function () {
    let table = null;
    let AllCartItem =[];
    const esc = (s) => $("<div>").text(s ?? "").html();
  if (window.location.href.indexOf("view.php") > -1) {
        GetCart_Items();
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
});