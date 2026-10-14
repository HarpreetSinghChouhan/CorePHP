$(document).ready(function () {
    let table = null;
    let AllCartItem = []; 
    if (window.location.href.indexOf("view.php") > -1) {
        GetWishlist_Items();
    }

    function WishlistTable() {
        table = $("#wishlist_datatable").DataTable({

            ajax: {
                type: "GET",
                url: "/CorePHP/vendor/backend/wishlist/GetWishlist.php",
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
 $(document).on("click", ".delete-cart", function () {

        let row = $(this).closest("tr");
        let id =  row.data("id");
        let name = row.data("name");
       
            swal.fire({
                 'title':'Are you sure?',
                'text':`You Want To Delete ${name}`,
                'icon':'warning',
                'showCancelButton':true,
                'cancelButtonColor':'Green',
                'confirmButtonColor':'Red',
                'confirmButtonText':'Yes, Delete it',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: `/CorePHP/vendor/backend/wishlist/DeleteWishlist.php?id=${id}`,
                        type: "DELETE",
                        success: function (response) {

                            if (response.status.trim() === "success") {
                             swal.fire({
                                'title':'cart are Deleted',
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

    function esc(str) {
        return $("<div>").text(str ?? "").html();
    }

    if ($("#wishlist_datatable").length) {
        WishlistTable();
    }

    function GetWishlist_Items() {
        const params = new URLSearchParams(window.location.search);
        let id = params.get("id");

        $.ajax({
            type: "GET",
            dataType: "json",
            url: `/CorePHP/vendor/backend/wishlist/GetWishlistItem.php?id=${id}`,
            success: function (response) {
                // console.log("Wishlist response:", response); 
                AllCartItem = Array.isArray(response) ? response : (response.data || []);

                $(".wishlist-item").html(AllCartItem.length);
                renderOrderItem();
            },
            error: function (xhr) { 
                console.error("Request failed:", xhr.responseText);
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
                            <button class="delete-btn delete-wishlist btn-icon">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>`;
            });

            $(".wishlist-item").html(html);
        }

        $(document).on("click", ".delete-wishlist", function (e) {
            e.stopPropagation();
            console("JGjhsg fjhlgdhjldgjh sf gjldshflkj ");

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
                    url: "/CorePHP/vendor/backend/wishlist/Updatewishlist.php",
                    data: { id: id },
                    success: function (data) {
                        if (data.error) {
                            Swal.fire({ title: data.error, icon: "warning" });
                            return;
                        }
                        Swal.fire({ title: data.message, icon: "success" });
                        AllCartItem = AllCartItem.filter(i => i.id != id);
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
    }
});