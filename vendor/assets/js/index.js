$(document).ready(function(){
    
    const esc = (s) => $("<div>").text(s ?? "").html();
   
    if($("#index_datatable").length){
            GetData();
        };
        function GetData(){
             table = $("#index_datatable").DataTable({
             scrollX: true,
            ajax: {
                url: "/CorePHP/vendor/backend/order/GetOrder.php",
                dataSrc: function (json) { 
                    // console.log(json.length);
                    $('.total-order-Item').html(json.length);
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
                    <button type="button" class="btn-icon view-link-btn  edit-user" title="View">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button type="button" class="btn-icon delete-order delete-user" title="Delete">
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
            //    console.log("Hello Every One That Are main page script ");
        }
let stockChart = null;
let stockPage = 1;
let stockPages = 1;

if ($("#TopChartItem").length) {
    loadStockChart();

    $("#stockFilter, #stockPerPage").on("change", function () {
        stockPage = 1;
        loadStockChart();
    });
    $("#stockPrev").on("click", function () {
        if (stockPage > 1) { stockPage--; loadStockChart(); }
    });
    $("#stockNext").on("click", function () {
        if (stockPage < stockPages) { stockPage++; loadStockChart(); }
    });
}

function loadStockChart() {
    const range = new URLSearchParams(window.location.search).get("range") || "7days";

    $.ajax({
        url: "/CorePHP/vendor/backend/product/GetProductStock.php",
        method: "GET",
        dataType: "json",
        data: {
            range: range,
            status: $("#stockFilter").val(),
            page: stockPage,
            per_page: $("#stockPerPage").val()
        },
        success: function (res) {
            stockPages = res.pages;
            $("#stockPageInfo").text("Page " + res.page + " / " + res.pages);
            $("#stockPrev").prop("disabled", res.page <= 1);
            $("#stockNext").prop("disabled", res.page >= res.pages);

            const labels = res.data.map(p => p.name);
            const SaledProduct = res.data.map(p => p.sold);
            const Totalproductquantity = res.data.map(p => p.stock);

            const data3 = {
                labels: labels,
                datasets: [
                    {
                        label: "Product Saled",
                        data: SaledProduct,
                        backgroundColor: ['rgb(53, 212, 240)','rgb(129, 23, 250)'],
                        // borderColor: "rgb(53, 212, 240)"
                    },
                    // {
                    //     label: "Product Stock",
                    //     data: Totalproductquantity,
                    //     backgroundColor: "rgb(245, 65, 65)",
                    //     borderColor: "rgb(245, 65, 65)"
                    // }
                ]
            };

            if (stockChart) {
                stockChart.data = data3;
                stockChart.update();
            } else {
                stockChart = new Chart(document.getElementById("TopChartItem"), {
                    type: "pie",
                    data: data3,
                });
            }
        },
        error: function (xhr) {
            console.error("Stock chart error:", xhr.responseText);
        }
    });
}
})