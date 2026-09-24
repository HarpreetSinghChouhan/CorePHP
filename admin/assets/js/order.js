$(document).ready(function(){
if (window.location.href.indexOf("index.php") > -1) {
        runCheckoutLogic();
    }
let allProducts = [];
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

function renderProductTable(){
    const TableBody = $(".order-tbody");
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    let pageData = allProducts.slice(start, end);

    let html = ""
    $.each(pageData, function(index, item){
        // let description = `${item.description.length > 20 ? item.description.slice(0, 40) + '...' : item.description}`;

        html += `<tr data-id='${item.order_id}'
                      data-name='" ${item.user_name}"'
                      data-email='${item.user_email}'
                      data-total_quantity='${item.total_quantity}'
                      data-total_price='${item.total_price}'
                      data-order_items='${item.order_items}'
                      >
                 <td> ${start + index + 1} </td>
                 <td class='product-name' > ${item.order_id} </td>
                 <td > ${item.user_name}  </td>
                 <td> ${item.user_email} </td>
                  <td> ${item.total_quantity} </td>
                 <td > ${item.total_price}  </td>
                

                 <td> ${item.order_items} </td>
                  <td > ${item.perchange_at}  </td>
                 <td class='action-cell' style='height:80px'>
                     <button type='button' class='btn-icon edit-link-btn edit-user' title='Edit'>
                        <i class='fa-solid fa-eye'></i>
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
})  