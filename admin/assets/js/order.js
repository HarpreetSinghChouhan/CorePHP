$(document).ready(function(){
     if (window.location.href.indexOf("view.php") > -1) {
        runOrderItemLogic();
    }
    let table = null;

    const esc = (s) => $("<div>").text(s ?? "").html();

    if ($("#order_datatable").length) {
        initOrderTable();
    }

    function initOrderTable() {
        table = $("#order_datatable").DataTable({
            ajax: {
                url: "/CorePHP/admin/backend/order/Order.php",
                dataSrc: function (json) {
                    return Array.isArray(json) ? json : (json.data || []);
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[1, "desc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "order_id", className: "order-id", render: (d) => esc(d) },
                { data: "user_name", render: (d) => esc(d) },
                { data: "user_email", render: (d) => esc(d) },
                { data: "total_quantity", render: (d) => esc(d) },
                { data: "total_price", render: (d) => esc(d) },
                { data: "order_items", render: (d) => esc(d) },
                { data: "perchange_at", render: (d) => esc(d) },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <button type="button" class="btn-icon view-link-btn edit-btn" title="View">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button type="button" class="btn-icon delete-order delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>` }
            ],
            createdRow: function (row, o) {
                $(row).attr({
                    "data-id": o.order_id,
                    "data-name": o.user_name,
                    "data-email": o.user_email,
                    "data-total_quantity": o.total_quantity,
                    "data-total_price": o.total_price,
                    "data-order_items": o.order_items
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
function runOrderItemLogic(){
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    const Toast = swal.mixin({
      toast: true,
      position: "top-end",  
      showConfirmButton: false,
      timer: 3000, 
      timerProgressBar: true,
      didOpen: (toast) =>{
        toast.onmouseenter  = swal.stopTimer;
        toast.onmouseleave = swal.resumeTimer;
      }
    }) 
    $.ajax({
        type:"GET",
        url:"/Corephp/admin/backend/order/GetOrderItem.php",
        dataType:'json',
        data:{'id':id},
        success: function(response){
            allOrderItem = response;
            currentPage = 1;
            // console.log(allOrderItem);
           PrintItem();
        },
        error: function(xhr, status, error){
           Toast.fire({
            'icon':'warning',
            'title':xhr.responseText
           })
        }
    })
    console.log("THis is ID THat Are Show in URL ", id);
}
function PrintItem(){
    // let start = (currentPage - 1) * rowsPerPage;
    // let end = start + rowsPerPage;
    // let pageData = allOrderItem.slice(start, end);
        const OrderItem = $(".order-list"); 
        let html = ''
        let total_item = 0;
        let total_price = 0;
        $.each(allOrderItem, function(index, item){
            total_price += parseInt(item.total_product_amount);
            total_item += parseInt(item.product_quantity);
            html +=`
        <div class="order-item">
            <div class="order-item-img">
                <img src="${item.product_image}" alt="${item.product_name}">
            </div>
            <div class="order-item-details">
                <h4 class="order-item-name">${item.product_name}</h4>
                <span class="order-item-category">${item.category_name}</span>
                <p class="order-item-sku">SKU: ${item.product_sku}</p>

                <div class="order-item-meta">
                    <span class="order-item-qty">Qty: ${item.product_quantity}</span>
                    <span class="order-item-price">₹${item.product_price}</span>
                </div>
            </div>
            <div class="order-item-total">
                <h4 class="order-item-name">Email:- ${item.user_email}</h4>
                <p class="order-id">Order #${item.order_id}</p>
                <p class="total-amount"> Total Price: ₹${item.total_product_amount}</p>
            </div>
        </div>
    `;
    
});
//  html += `<div class="order-item-footer-detail" >
//   <p class="total-amount"> Total quantity: ${total_item}</p>
//   <p class="total-amount"> Total Price: ₹${total_price}</p>
//  </div>`;
html += `<div class="order-item-footer-detail">
  <div class="footer-block">
    <span class="footer-label">Total Items :</span>
    <p class="total-amount">${total_item}</p>
  </div>
  <div class="footer-block">
    <span class="footer-label">Total Price :</span>
    <p class="total-amount">₹${total_price}</p>
  </div>
</div>`;
OrderItem.html(html);
}


    $(document).on("click", ".delete-order", function () {

        let row = $(this).closest("tr");
        let id = row.data("id");
       
            swal.fire({
                 'title':'Are you sure?',
                'text':`You Want To Delete ${id}`,
                'icon':'warning',
                'showCancelButton':true,
                'cancelButtonColor':'Green',
                'confirmButtonColor':'Red',
                'confirmButtonText':'Yes, Delete it',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: `/CorePHP/admin/backend/order/OrderDelete.php?id=${id}`,
                        type: "DELETE",
                        success: function (response) {

                            if (response.trim() === "success") {
                             swal.fire({
                                'title':'order are Deleted',
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
})  