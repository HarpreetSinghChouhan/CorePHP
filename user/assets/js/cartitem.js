
$(document).ready(function () {
    let table = null;

    if (window.location.href.indexOf("cartitem.php") > -1) {
        GetCart();
    }

    function GetCart() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/CorePHP/user/backend/product/GetCart.php",
            success: function (response) {
                $(".total-order").html(response.length);
                initTable(response);
            }
        });
    }

    function initTable(data) {
        if (table) { table.destroy(); }   
        table = $("#cart_datatable").DataTable({
            data: data,
            pageLength: 5,
            lengthMenu: [5, 10, 20],
            columns: [
                { data: null, orderable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "image", orderable: false,
                  render: (d, t, r) => `<div class="cart-image"><img src="${d}" alt="${r.name}"></div>` },
                { data: "name" },
                { data: "price" },
                { data: "quantity" },
                { data: null,
                  render: (d, t, r) => r.price * r.quantity },
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
                $(row).attr("data-id", rowData.id).attr("data-name", rowData.name);
            }
        });

        table.on("draw.dt", function () {
            table.column(0, { search: "applied", order: "applied", page: "current" })
                 .nodes()
                 .each((cell, i) => {
                     cell.innerHTML = table.page.info().start + i + 1;
                 });
        });
    }

    $(document).on("click", ".edit-cart-btn", function () {
        let id = $(this).closest("tr").data("id");
        window.location.href = `./edit.php?id=${id}`;
    });

    $(document).on("click", ".btn-delete-cart", function (e) {
        e.stopPropagation();
        let $tr = $(this).closest("tr");
        removeFromCart($tr.data("id"), $tr.data("name"), $tr);
    });

    function removeFromCart(id, name, $tr) {
        Swal.fire({
            title: "Are you sure?",
            text: `You Want To Remove ${name}`,
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "green",
            confirmButtonColor: "red",
            confirmButtonText: "Yes, Remove it"
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                type: "POST",
                url: "/CorePHP/user/backend/cart/DeleteCart.php",
                data: { id: id },
                success: function (response) {
                    let data = typeof response === "string" ? JSON.parse(response) : response;

                    if (data.error) {
                        Swal.fire({ title: data.error, icon: "warning" });
                        return;
                    }
                    Swal.fire({ title: data.message, icon: "success" });

                    table.row($tr).remove().draw(false);
                    $(".total-order").html(table.rows().count());
                },
                error: function (xhr) {
                    Swal.fire({ title: xhr.responseText, icon: "warning" });
                }
            });
        });
    }
    $(document).on("click", ".decrease-btn", function(e){
    e.stopPropagation();
    if ($(this).prop("disabled")) return;
    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, -1);
});
$(document).on("click", ".increase-btn", function(e){
    e.stopPropagation();
    let id = $(this).closest(".cart-card").data("id");
    updateQuantity(id, 1);
});
function updateQuantity(id, change) {
    const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    let currentQty = parseInt($("#qtyValue").text());
    let newQty = currentQty + change;

    if (newQty <= 0) {
        removeFromCart(id, $(".cart-item__title").text());
        return;
    }
    $.ajax({
        type: "POST",
        url: "/CorePHP/user/backend/cart/UpdateQuantity.php",
        data: { id: id, quantity: newQty },
        success: function(response){
            let data = response;
            if (typeof data === "string") {
                data = JSON.parse(data);
            }
            if (data.error) {
                Toast.fire({ icon: 'warning', title: data.error });
                return;
            }

$("#qtyValue").text(data.quantity);
$("#qtyMinus").prop("disabled", data.quantity <= 1);
$("#qtyPlus").prop("disabled", data.quantity >= data.available_stock);

let price = parseFloat($(".cart-item").data("price"));
let totalprice = price * data.quantity;
console.log(" Total Price ", totalprice);
$(".total-price").text(totalprice.toLocaleString("en-IN"));
        //  $(".total-price").text(`${price}`);
            $("#stockMsg").hide();
            if (data.limited) {
                $("#stockMsg")
                    .text(`Only ${data.available_stock} left in stock`)
                    .show();
            }
            Toast.fire({ icon: 'success', title: data.message });
        },
        error: function(xhr){
            Toast.fire({ icon: 'warning', title: xhr.responseText });
            console.log("Update failed:", xhr.responseText);
        }
    });
}
});