$(document).ready(function () {
    var perPage = 4;
    var allProducts = [];
    var currentPage = 1;

    loadCartCount();

    if (window.location.href.indexOf("allproduct.php") > -1) {
        loadProducts();
    }

    function showMessage(type, text) {
        Swal.fire({
            toast: true,
            position: "bottom-end",
            icon: type,
            title: text,
            showConfirmButton: false,
            timer: 3000
        });
    }

    function loadCartCount() {
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
    }

    function loadProducts() {
        $.ajax({
            type: "GET",
            url: "/CorePHP/user/backend/product/GetProduct.php",
            dataType: "json",
            success: function (items) {
                allProducts = items;
                currentPage = 1;
                showPage();
            },
            error: function () {
                $(".product-grid").html("<p>Something went wrong.</p>");
            }
        });
    }

    function makeCard(item) {

          var heartClass = item.wishlist ? "active" : "";
        var heartIcon = item.wishlist ? "fa-solid" : "fa-regular";

        var stock = Number(item.stock_quantity) > 0
            ? `<h3 style='color:green'>In Stock (${item.stock_quantity})</h3>`
            : `<h3 style='color:red'>Out Of Stock</h3>`;

        var desc = item.description || "";
        if (desc.length > 50) desc = desc.slice(0, 50) + "...";

        return `
        <article class="product-card">
            <a href="product.php?id=${item.id}" class="card-media">
                <img src="${item.image}" alt="${item.name}">
                <span class="badge badge-new">New</span>
                <button class="wishlist-btn ${heartClass}" type="button" data-product-id="${item.id}">
           <i class="${heartIcon} fa-heart"></i>
        </button> 
            </a>
            <div class="card-body">
                <p class="card-category">${item.category_name}</p>
                <h3 class="card-title"><a href="product.php?id=${item.id}">${item.name}</a></h3>
                <div class="card-price">₹${item.price}</div>
                <div class="card-rating">${desc}</div>
                ${stock}
                <button class="btn btn-add-cart" type="button" data-product-id="${item.id}">Add to Cart</button>
            </div>
        </article>`;
    }

    function showPage() {
        var start = (currentPage - 1) * perPage;
        var items = allProducts.slice(start, start + perPage);

        var html = "";
        $.each(items, function (i, item) {
            html += makeCard(item);
        });
        $(".product-grid").html(html || "<p>No products found.</p>");

        showPagination();
    }

    function showPagination() {
        var totalPages = Math.ceil(allProducts.length / perPage);

        if (totalPages <= 1) {
            $("#pagination").empty();
            return;
        }

        var html = "";

        if (currentPage > 1) {
            html += `<a href="#" class="page-btn" data-page="${currentPage - 1}">Prev</a>`;
        }

        for (var i = 1; i <= totalPages; i++) {
            var active = i === currentPage ? "is-active" : "";
            html += `<a href="#" class="page-btn ${active}" data-page="${i}">${i}</a>`;
        }

        if (currentPage < totalPages) {
            html += `<a href="#" class="page-btn" data-page="${currentPage + 1}">Next</a>`;
        }

        $("#pagination").html(html);
    }

    $(document).on("click", "#pagination .page-btn", function (e) {
        e.preventDefault();
        currentPage = Number($(this).data("page"));
        showPage();
        document.getElementById("products").scrollIntoView({ behavior: "smooth" });
    });

    $(document).on("click", ".btn-add-cart", function () {
        var id = $(this).data("product-id");

        $.ajax({
            type: "POST",
            url: "/CorePHP/user/backend/product/AddToCart.php",
            data: { product_id: id },
            dataType: "json",
            success: function (res) {
                showMessage(res.status, res.message);
                if (res.status === "success") loadCartCount();
            },
            error: function () {
                showMessage("error", "Something went wrong on the server.");
            }
        });
    });

    $(document).on("click", ".btn-buy-now", function () {
        var id = $(this).data("product_id");

        $.ajax({
            type: "POST",
            url: "/CorePHP/user/backend/payment/Singleproductparchange.php",
            data: { id: id },
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    window.location.href = res.url;
                } else {
                    Swal.fire({
                        icon: "error",
                        text: JSON.stringify(res.error)
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Request Failed",
                    text: xhr.responseText
                });
            }
        });
    });
   $(document).on("click", ".wishlist-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var btn = $(this);
    var id = btn.data("product-id");

    $.ajax({
        type: "POST",
        url: "/CorePHP/user/backend/product/AddToWishlist.php",
        data: { product_id: id },
        dataType: "json",
        success: function (res) {
            showMessage(res.status, res.message);

            if (res.status === "success") {
                var isAdded = res.action === "added";        
                btn.toggleClass("active", isAdded);
                btn.find("i")
                    .toggleClass("fa-solid", isAdded)
                    .toggleClass("fa-regular", !isAdded);

                $.each(allProducts, function (i, item) {
                    if (item.id == id) {
                        item.wishlist = isAdded;
                    }
                });
            }
        },
        error: function () {
            showMessage("error", "Something went wrong on the server.");
        }
    });
});
});