$(document).ready(function(){
    // console.log("Hello ");
    // if(("#TopChartItem").length){
    //     // console.log();
    //     CallAjax();  
    // }
    // function CallAjax(){
    //     $.ajax({
    //         type:'GET',
    //         url:'/CorePHP/admin/backend/product/GetProductStock.php',
    //         success:function(res){
    //             console.log(res);
    //         }
    //     })
    // }
    let stockChart = null;
let stockPage = 1;
let stockPages = 1;

if ($("#ChartItem").length) {
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
        url: "/CorePHP/admin/backend/product/GetProductStock.php",
        method: "GET",
        dataType: "json",
        data: {
            range: range,
            status: $("#stockFilter").val(),
            page: stockPage,
            per_page: $("#stockPerPage").val()
        },
        success: function (res) {
            console.log(res);
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
                stockChart = new Chart(document.getElementById("ChartItem"), {
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