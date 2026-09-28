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

    if (window.location.href.indexOf("orders.php") > -1) {
        GetOrder();
    }
    if(window.location.href.indexOf("view.php") > -1){
      GetOrder_Items()
    }

    let allOrder = [];
    let currentPage = 1;
    const rowsPerPage = 10;
    let AllOrderItem = [];
    function GetOrder(){
        $.ajax({
            type:"GET",
            dataType:"json",
            url:"/CorePHP/user/backend/order/Order.php",
            success: function(response){
                allOrder = response;
                let totalorder = allOrder.length
                 $(".total-order").html(totalorder);
                currentPage = 1;
                renderOrder();
            }
        })
    }
    
    function renderOrder(){
        const TableBody = $(".order-tbody");
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let pageData = allOrder.slice(start, end);

        let html = ""
        
        $.each(pageData, function(index, item){
            html += `<tr data-id='${item.order_id}'
                          data-total_quantity='${item.total_quantity}'
                          data-total_price='${item.total_price}'
                          data-order_items='${item.order_items}'
                          >
                     <td> ${start + index + 1} </td>
                     <td class='order-id' > ${item.order_id} </td>
                      <td> ${item.total_quantity} </td> 
                     <td> ${item.order_items} </td>
                     <td > ${item.total_price}  </td>
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

        if(pageData.length === 0){
            html = `<tr><td colspan="7" style="text-align:center; padding:20px;">No orders found</td></tr>`;
        }

        TableBody.html(html);
        renderPagination();
    }

    function renderPagination(){
        
        let totalPages = Math.ceil(allOrder.length / rowsPerPage);
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
                // console.log(AllOrderItem);
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




});