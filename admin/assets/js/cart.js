$(document).ready(function(){
     
if (window.location.href.indexOf("index.php") > -1) {
        runDataGetLogic();
    }
let allProducts = [];
let currentPage = 1;
const rowsPerPage = 10;
  function runDataGetLogic(){

         $.ajax({
        type:"GET",
        url:"/CorePHP/admin/backend/cart/Cart.php",
        dataType:"json",
        success: function(response){
            allProducts = response[0];
            // console.log(response);
            currentPage = 1;
            renderCartTable();
        },
        error: function(response){
          Swal.fire({"title":response,"icon":"warning"});
        }
    })

  }
  function renderCartTable(){
    const TableBody = $(".cart-tbody");
    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    let pageData = allProducts.slice(start, end);

    let html = ""
    $.each(pageData, function(index, item){
        // let description = `${item.description.length > 20 ? item.description.slice(0, 40) + '...' : item.description}`;

        html += `<tr data-id='${item.user_id}'
                      data-name='${item.user_name}'
                      data-email='${item.email}'
                      data-total_quantity='${item.total_items}'
                      data-total_price='${item.total_quantity}'
                      data-order_items='${item.total_price}'
                      >
                 <td> ${start + index + 1} </td>
                 <td > ${item.user_name}  </td>
                 <td> ${item.email} </td>
                  <td> ${item.total_items} </td>
                 <td > ${item.total_quantity}  </td>
                

                 <td> ${item.total_price} </td>
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
})