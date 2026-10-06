$(document).ready(function () {
    // var perPage = 16;
    var originalList = [];
var productList = [];
var latestList = [];

    loadCartCount();
    loadLatestProducts();
    loadAllProducts();

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

    function makeCard(item, isNew) {
        var heartClass = item.wishlist ? "active" : "";
        var heartIcon = item.wishlist ? "fa-solid" : "fa-regular";

// inside the template:
         
        var stock = Number(item.stock_quantity) > 0
            ? "<h3 style='color:green'>In Stock</h3>"
            : "<h3 style='color:red'>Out Of Stock</h3>";

        var desc = item.description || "";
        if (desc.length > 50) desc = desc.slice(0, 50) + "...";

        var badge = isNew ? "<span class='badge badge-new'>New</span>" : "";

        return `
        <article class="product-card">
            <a href="product.php?id=${item.id}" class="card-media">
                <img src="${item.image}" alt="${item.name}">
                ${badge}
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

    function loadCartCount() {
        $.get("/CorePHP/user/backend/product/CountCart.php", function (count) {
            $(".cart-count").html(count);
        });
    }

   function loadLatestProducts() {
        // console.log("bsamnbd. sgadkj.dkas");

    $.ajax({
        type: "GET",
        url: "/CorePHP/user/backend/product/LatestProduct.php",
        dataType: "json",
        success: function (items) {

    // console.log("latest:", items.length);
            var html = "";
            $.each(items, function (i, item) {
                html += makeCard(item, true);
            });
            $("#latest-grid").html(html || "<p>No products found.</p>");
        },
        error: function () {
            $("#latest-grid").html("<p>Something went wrong.</p>");
        }
    });
}

    function loadAllProducts() {
        // console.log("bsamnbd. sgadkj.dkas");
        $.ajax({
            type: "GET",
            url: "/CorePHP/user/backend/product/GetProduct.php",
            dataType: "json",
            success: function (items) {

    // console.log("all:", items.length);
                originalList = items;
                sortProducts();
            },
            error: function () {
                $("#all-products-grid").html("<p>Something went wrong.</p>");
            }
        });
    }
    function sortProducts() {
    var mode = $(".sort-select").val();
    productList = originalList.slice();

    if (mode === "low") {
        productList.sort(function (a, b) { return a.price - b.price; });
    } else if (mode === "high") {
        productList.sort(function (a, b) { return b.price - a.price; });
    } else if (mode === "newest") {
        productList.sort(function (a, b) { return b.id - a.id; });
    }

    showPage();
}

    function showPage() {
    var items = productList.slice(0, 4);

    var html = "";
    $.each(items, function (i, item) {
        html += makeCard(item, false);
    });
    $("#all-products-grid").html(html || "<p>No products found.</p>");
    }

    function showPagination() {
        var totalPages = Math.ceil(productList.length / perPage);

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

    $(".sort-select").on("change", sortProducts);

    $(document).on("click", "#pagination .page-btn", function (e) {
        e.preventDefault();
        currentPage = Number($(this).data("page"));
        showPage();
        document.getElementById("all-products").scrollIntoView({ behavior: "smooth" });
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
    // update the heart on every card of this product
function setWishlistUI(id, isAdded) {
    $('.wishlist-btn[data-product-id="' + id + '"]').each(function () {
        $(this).toggleClass("active", isAdded);
        $(this).find("i")
            .toggleClass("fa-solid", isAdded)
            .toggleClass("fa-regular", !isAdded);
    });

    $.each(originalList, function (i, item) {
        if (item.id == id) item.wishlist = isAdded;
    });
    $.each(productList, function (i, item) {
        if (item.id == id) item.wishlist = isAdded;
    });
    $.each(latestList, function (i, item) {
        if (item.id == id) item.wishlist = isAdded;
    });
}

$(document).on("click", ".wishlist-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var id = $(this).data("product-id");

    $.ajax({
        type: "POST",
        url: "/CorePHP/user/backend/product/AddToWishlist.php",
        data: { product_id: id },
        dataType: "json",
        success: function (res) {
            showMessage(res.status, res.message);

            if (res.status === "success") {
                setWishlistUI(id, res.action === "added");
            }
        },
        error: function () {
            showMessage("error", "Something went wrong on the server.");
        }
    });
});
});