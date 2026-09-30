
$(document).ready(function () {
    let table = null;
    let AllOrderItem = [];
    $.ajax({
        type: "GET",
        url: "/CorePHP/user/backend/product/CountCart.php",
        success: function (response) { $(".cart-count").html(`${response}`); },
        error: function (response) { console.log(response); }
    });

   
    if (window.location.href.indexOf("view.php") > -1) {
        GetOrder_Items();
    }
    if ($("#order_datatable").length) {
        initOrderTable();
    }
    function initOrderTable() {
        table = $("#order_datatable").DataTable({
            ajax: {
                url: "/CorePHP/user/backend/order/Order.php",
                dataSrc: function (json) {
                    $(".total-order").html(json.length);  
                    return json;
                }
            },
            pageLength: 25,
            lengthMenu: [25, 50, 100],
            order: [[1, "desc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "order_id", className: "order-id" },
                { data: "total_quantity" },
                { data: "order_items" },
                { data: "total_price" },
                { data: "perchange_at" },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                     render: () => `
                      <button type="button" class="btn-icon edit-cart-btn edit-btn" title="Edit">
                             <i class="fa-solid fa-pencil"></i>
                      </button>
                       <button type="button" class="btn-icon btn-delete-cart delete-btn" title="Delete">
                     <i class="fa-solid fa-trash"></i>
                     </button>` }
                ],
            createdRow: function (row, rowData) {
                $(row).attr("data-id", rowData.order_id);
            }
        });
        table.on("draw.dt", function () {
            let start = table.page.info().start;
            table.column(0, { search: "applied", order: "applied", page: "current" })
                 .nodes()
                 .each((cell, i) => { cell.innerHTML = start + i + 1; });
        });

    }

    $(document).on("click", ".view-link-btn", function () {
        let order_id = $(this).closest("tr").data("id");
        window.location.href = `./view.php?id=${order_id}`;
    });

    $(document).on("click", ".delete-order", function () {
        let $tr = $(this).closest("tr");
        let id = $tr.data("id");

        Swal.fire({
            title: "Are you sure?",
            text: `You Want To Delete ${id}`,
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "green",
            confirmButtonColor: "red",
            confirmButtonText: "Yes, Delete it"
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: `/CorePHP/admin/backend/order/OrderDelete.php?id=${id}`,
                type: "DELETE",
                success: function (response) {
                    if (String(response).trim() === "success") {
                        Swal.fire({ title: "Order are Deleted", icon: "success" });
                        // remove through the DataTables API, not $tr.remove()
                        table.row($tr).remove().draw(false);
                        $(".total-order").html(table.rows().count());
                    } else {
                        Swal.fire({ title: `${response}`, icon: "warning" });
                    }
                },
                error: function () {
                    Swal.fire({ title: "Something Are Wrong", icon: "warning" });
                }
            });
        });
    });
    function GetOrder_Items() {
        const params = new URLSearchParams(window.location.search);
        let id = params.get("id");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: `/CorePHP/user/backend/order/OrderItem.php?id=${id}`,
            success: function (response) {
                AllOrderItem = response;
                $(".total-order").html(AllOrderItem.length);
                renderOrderItem();
            }
        });
    }

    function renderOrderItem() {
        let html = "";

        if (!AllOrderItem || AllOrderItem.length === 0) {
            $("#order-items-container").html(`<div class="no-items">No items found for this order.</div>`);
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
                    <div class="item-price">₹${item.price}</div>
                </div>`;
        });

        $("#order-items-container").html(html);
    }
});