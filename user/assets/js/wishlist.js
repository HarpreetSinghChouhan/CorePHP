$(document).ready(function () {
    let table = null;

    if (window.location.href.indexOf("wishlist.php") > -1) {
        getWishlist();
    }

    function getWishlist() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/CorePHP/user/backend/wishlist/Wishlist.php",
            success: function (response) {
                if (response.error) {
                    Swal.fire({ title: response.error, icon: "warning" });
                    return;
                }
                $(".total-order").html(response.length);
                initTable(response);
            },
            error: function (xhr) {
                Swal.fire({ title: "Something went wrong", icon: "error" });
            }
        });
    }

    function initTable(data) {
        if (table) {
            table.destroy();
        }

        table = $("#wishlist_datatable").DataTable({
            data: data,
            pageLength: 5,
            lengthMenu: [5, 10, 20],
            columns: [
                { data: null, orderable: false, searchable: false, defaultContent: "", render: (d,t,r,meta) => meta.row + 1 },
                {
                    data: "product_image",
                    orderable: false,
                    render: function (d, t, r) {
                        if (!d) return "";
                        return `<div class="cart-image"><img src="${d}" alt="${r.product_name}"></div>`;
                    }
                },
                { data: "product_name" },
               
                { data: "description" }, 
                { data: "product_price" },
                { data: "product_sku" },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "action-cell",
                    render: function () {
                        return `<button type="button" class="btn-icon btn-delete-cart delete-btn" title="Remove Favorite">
                                    <i class="fa-solid fa-trash"></i>
                                </button>`;
                    }
                }
            ],
            createdRow: function (row, rowData) {
                $(row).attr("data-id", rowData.id).attr("data-name", rowData.product_name);
            }
        });

        table.on("draw.dt", function () {
            let start = table.page.info().start;
            table.column(0, { search: "applied", order: "applied", page: "current" })
                .nodes()
                .each(function (cell, i) {
                    cell.innerHTML = start + i + 1;
                });
        });
    }

    $(document).on("click", ".btn-delete-cart", function (e) {
        e.stopPropagation();
        let tr = $(this).closest("tr");
        removeFromWishlist(tr.data("id"), tr.data("name"), tr);
    });

    function removeFromWishlist(id, name, tr) {
        Swal.fire({
            title: "Are you sure?",
            text: `You want to remove ${name}`,
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "green",
            confirmButtonColor: "red",
            confirmButtonText: "Yes, remove it"
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/CorePHP/user/backend/wishlist/DeleteWishlist.php",
                data: { id: id },
                success: function (data) {
                    if (data.error) {
                        Swal.fire({ title: data.error, icon: "warning" });
                        return;
                    }
                    Swal.fire({ title: data.message, icon: "success" });
                    table.row(tr).remove().draw(false);
                    $(".total-order").html(table.rows().count());
                },
                error: function (xhr) {
                    Swal.fire({ title: "Could not remove item", icon: "error" });
                }
            });
        });
    }
});