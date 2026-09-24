$(document).ready(function(){
     
if (window.location.href.indexOf("index.php") > -1) {
        runCheckoutLogic();
    }
if (window.location.href.indexOf("view.php") > -1) {
        runOrderItemLogic();
    }
let allProducts = [];
let allOrderItem = [];

let currentPage = 1;
const rowsPerPage = 10;

function runCheckoutLogic(){
    const TableBody = $(".order-tbody");  
    $.ajax({
        type:"GET",
        url:"/CorePHP/admin/backend/order/Order.php",
        dataType:"json",
        success: function(response){
            allProducts = response;
            currentPage = 1;
            renderProductTable();
        },
        error: function(response){
          Swal.fire({"title":response,"icon":"warning"});
        }
    })
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
            console.log(allOrderItem);
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

function renderProductTable(){
    const TableBody = $(".order-tbody");
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    let pageData = allProducts.slice(start, end);

    let html = ""
    $.each(pageData, function(index, item){
        // let description = `${item.description.length > 20 ? item.description.slice(0, 40) + '...' : item.description}`;

        html += `<tr data-id='${item.order_id}'
                      data-name='${item.user_name}'
                      data-email='${item.user_email}'
                      data-total_quantity='${item.total_quantity}'
                      data-total_price='${item.total_price}'
                      data-order_items='${item.order_items}'
                      >
                 <td> ${start + index + 1} </td>
                 <td class='order-id' > ${item.order_id} </td>
                 <td > ${item.user_name}  </td>
                 <td> ${item.user_email} </td>
                  <td> ${item.total_quantity} </td>
                 <td > ${item.total_price}  </td>
                

                 <td> ${item.order_items} </td>
                  <td > ${item.perchange_at}  </td>
                 <td class='action-cell' style='height:80px'>
                     <button type='button' class='btn-icon view-link-btn edit-btn' title='View'>
                        <i class='fa-solid fa-eye'></i>
                     </button>
                      <button type='button' class='btn-icon delete-order delete-btn' title='Delete'>
                        <i class='fa-solid fa-trash'></i>
                    </button>
                </td></tr>`;
    }); 
    TableBody.html(html);
    renderPagination();
}

function renderPagination(){
    let totalPages = Math.ceil(allProducts.length / rowsPerPage);
    let pagHtml = "";

    pagHtml += `<button type="button" class="page-btn prev-page" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

    for (let i = 1; i <= totalPages; i++) {
        pagHtml += `<button type="button" class="page-btn page-number ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
    }

    pagHtml += `<button type="button" class="page-btn next-page" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}>Next</button>`;

    $("#pagination").html(pagHtml);
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