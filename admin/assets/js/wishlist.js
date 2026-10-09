
$(document).ready(function () {
    let table = null;
if (window.location.href.indexOf("view.php") > -1) {
        GetWishlist_Items();
    }
    function WishlistTable() {
        table = $("#wishlist_datatable").DataTable({
            ajax: {
                type: "GET",
                url: "http://localhost/CorePHP/admin/backend/wishlist/GetWishlist.php",
                dataSrc: function (json) {
                    return Array.isArray(json) ? json : (json.data || []);
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 20, 50],
            order: [[1, "asc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "username",   render: (d) => esc(d) },
                { data: "useremail",  render: (d) => esc(d) },
                { data: "total_item", render: (d) => esc(d) },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <div class="action-wrap">
                        <button type="button" class="btn-icon view-link-btn view-cart edit-btn" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-icon delete-cart delete-btn" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>`
                }
            ],
            createdRow: function (row, data) {
                $(row).attr({
                    "data-id": data.user_id,
                    "data-name": data.username,
                    "data-email": data.useremail,
                    "data-wishlist-item": data.total_item
                });
            }
        });
    }

    function esc(str) {
        return $("<div>").text(str ?? "").html();
    }

    if ($("#wishlist_datatable").length) {
        WishlistTable();
    }
    function GetWishlist_Items(){
       const params = new URLSearchParams(window.location.search);
        let id = params.get("id");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: `/CorePHP/admin/backend/wishlist/GetWishlistItem.php?id=${id}`,
            success: function (response) {
                AllCartItem = response;
                $(".wishlist-item").html(AllCartItem.length);
                renderOrderItem();
            }
        });
   function renderOrderItem() {
    let html = "";

    if (!AllCartItem || AllCartItem.length === 0) {
        $(".wishlist-item").html(`<div class="no-items">No items found for any User.</div>`);
        return;
    }
    AllCartItem.forEach(item => {
        $('.user-name').html(item.useremail);
        html += `
            <div class="cart-item-card wishlist-card" data-id="${item.id}" data-name="${item.product_name}">
                <div class="item-img">
                    <img src="${item.product_image}" alt="${item.product_name}">
                </div>
                <div class="item-info">
                    <h4>${item.product_name}</h4>
                    <p class="item"><strong>price:</strong> ${item.product_price}</p>
                    <p class="item-sku">SKU: ${item.product_sku}</p>
                    <p class="item-sku">description: ${item.description}</p>
                </div>
                <div class="cart-id">
                    <button class="delete-btn delete-wishlist btn">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>`;
    });

    $(".wishlist-item").html(html);
}

$(document).on("click", ".delete-wishlist", function (e) {
    e.stopPropagation();
    let card = $(this).closest(".wishlist-card");

    deleteWishlist(card.data("id"), card.data("name"), card);
});

function deleteWishlist(id, name, card) {
    Swal.fire({
        title: "Are you sure?",
        text: `You want to remove wishlist of ${name}`,
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
            url: "/CorePHP/admin/backend/wishlist/Updatewishlist.php",
            data: { id: id },
            success: function (data) {
                if (data.error) {
                    Swal.fire({ title: data.error, icon: "warning" });
                    return;
                }
                Swal.fire({ title: data.message, icon: "success" });

                // Array se hatao taaki re-render par wapas na aaye
                AllCartItem = AllCartItem.filter(i => i.id != id);

                // Card ko UI se hatao
                card.fadeOut(300, function () {
                    $(this).remove();
                    if ($(".wishlist-card").length === 0) {
                        $(".wishlist-item").html(`<div class="no-items">No items found for any User.</div>`);
                    }
                });
            },
            error: function () {
                Swal.fire({ title: "Could not remove wishlist", icon: "error" });
            }
        });
});
}
    };
});