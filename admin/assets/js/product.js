
$(document).ready(function () {
    let table = null;

    const esc = (s) => $("<div>").text(s ?? "").html();

    if ($("#product_datatable").length) {
        initProductTable();
    }

    function initProductTable() {
        table = $("#product_datatable").DataTable({
            ajax: {
                url: "/CorePHP/admin/backend/Product/GetProduct.php",
                dataSrc: function (json) {
                    return Array.isArray(json) ? json : (json.data || []);
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[2, "asc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "image", orderable: false, searchable: false,
                  render: (d, t, r) =>
                    `<img src="${esc(d)}" alt="${esc(r.name)}" class="img-feild-table">` },
                { data: "name", className: "product-name", render: (d) => esc(d) },
                { data: "sku", render: (d) => esc(d) },
                { data: "price", render: (d) => esc(d) },
                { data: "category_name", render: (d) => esc(d) },
                { data: "description",
                  render: (d) => {
                      d = d ?? "";
                      return esc(d.length > 40 ? d.slice(0, 40) + "..." : d);
                  } },
                { data: "stock_quantity" },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <button type="button" class="btn-icon edit-link-btn edit-user" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="btn-icon delete-user" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>` }
            ],
            createdRow: function (row, p) {
                $(row).attr({
                    "data-id": p.id,
                    "data-name": p.name,
                    "data-price": p.price,
                    "data-sku": p.sku,
                    "data-category-name": p.category_name,
                    "data-description": p.description,
                    "data-image": p.image,
                    "data-stock_quantity": p.stock_quantity
                });
            }
        });

        table.on("draw.dt", function () {
            let start = table.page.info().start;
            table.column(0, { search: "applied", order: "applied", page: "current" })
                 .nodes()
                 .each((cell, i) => { cell.innerHTML = start + i + 1; });
        });
    }

 $("#EditProductForm").on("submit", function (e) {
        e.preventDefault();
        const ProductSkuPattern = /^\d{3}[a-zA-Z]{3,4}$/;
        $(".ProductNameError, .DescriptionError, .ProductSkuError, .PriceError, .ProductQuantityError, .ProductCategoryError, .ProductImageError").html("");
        const validationRules = [
            {
                input: $("#ProductName"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductNameError"),
                isValid: function () {
                    return this.value.length >= 3;
                },
                get message() {
                    return this.value === ""
                        ? "Product Name is required."
                        : "Product Name must be at least 3 characters.";
                }
            },
            {
                input: $("#Description"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".DescriptionError"),
                isValid: function () {
                    return this.value.length >= 3;
                },
                get message() {
                    return this.value === ""
                        ? "Product Description is required."
                        : "Product Description must be at least 3 characters.";
                }
            },
            {
                input: $("#ProductSku"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductSkuError"),
                isValid: function () {
                    return this.value !== "" && ProductSkuPattern.test(this.value);
                },
                get message() {
                    return this.value === ""
                        ? "Product SKU is required."
                        : "Product SKU must be 3 numbers followed by 7 to 10 letters.";
                }
            },
            {
                input: $("#Price"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".PriceError"),
                isValid: function () {
                    return this.value !== "" &&
                        !isNaN(this.value) &&
                        Number(this.value) >= 10 &&
                        Number(this.value) <= 100000;
                },
                get message() {
                    if (this.value === "") {
                        return "Price is required.";
                    }
                    return "Price must be minimum 10 and maximum 100000.";
                }
            },
            {
                input: $("#ProductQuantity"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductQuantityError"),
                isValid: function () {
                    return this.value !== "" &&
                        !isNaN(this.value) &&
                        Number(this.value) >= 1 &&
                        Number.isInteger(Number(this.value));
                },
                get message() {
                    return this.value === ""
                        ? "Product Quantity is required."
                        : "Product Quantity must be a minimum of 1.";
                }
            },
            {
                input: $("#ProductCategory"),
                get value() {
                    return this.input.val() || "";
                },
                errorEl: $(".ProductCategoryError"),
                isValid: function () {
                    return this.value !== "";
                },
                message: "Product Category is required."
            },
            {
                input: $("#ProductImage"),
                get value() {
                    const files = this.input.prop("files");
                    return files && files.length > 0 ? files[0] : '';
                },
                errorEl: $(".ProductImageError"),
                isValid: function () {
                    const file = this.value;
                    if (file) {
                         const validTypes = ["image/png","image/jpeg","image/jpg","image/webp"];
                         return validTypes.includes(file.type) && file.size <= 2 * 1024 * 1024;
                        // return false;
                    }
                    else{
                        return true;
                    }
                },
                get message() {
                    if (this.value) {
                        return "Product Image must be PNG, JPG, JPEG or WEBP and maximum 2 MB.";
                    }   
                }
            }
        ];

        let isFormValid = true;
        let firstInvalidInput = null;

        $.each(validationRules, function (index, rule) {

            if (!rule.isValid()) {

                rule.errorEl.html(rule.message);

                isFormValid = false;

                if (!firstInvalidInput) {
                    firstInvalidInput = rule.input;
                }
            }
        });

        if (!isFormValid) {

            if (firstInvalidInput && firstInvalidInput.length) {
                firstInvalidInput.focus();
            }

            return false;
        }
       
        $.ajax({
        type: "POST",
                    url: "/CorePHP/admin/backend/Product/UpdateProduct.php",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,

    success: function (response) {
        response = response.trim();

        if (response === "Exited") {
            Swal.fire({
                title: "Product Already Exists",
                icon: "warning"
            });
        } else if (response === "Success") {
            Swal.fire({
                title: "Product Created Successfully",
                icon: "success"
            }).then(() => {
                window.location = "./index.php";
            });
        } else {
            Swal.fire({
                title: response,
                icon: "error"
            });
        }
       } 
      });
    });
 $("#AddProductForm").on("submit", function (e) {
        e.preventDefault();
        const ProductSkuPattern = /^\d{3}[a-zA-Z]{3,4}$/;
        $(".ProductNameError, .DescriptionError, .ProductSkuError, .PriceError, .ProductQuantityError, .ProductCategoryError, .ProductImageError").html("");
        const validationRules = [
            {
                input: $("#ProductName"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductNameError"),
                isValid: function () {
                    return this.value.length >= 3;
                },
                get message() {
                    return this.value === ""
                        ? "Product Name is required."
                        : "Product Name must be at least 3 characters.";
                }
            },
            {
                input: $("#Description"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".DescriptionError"),
                isValid: function () {
                    return this.value.length >= 3;
                },
                get message() {
                    return this.value === ""
                        ? "Product Description is required."
                        : "Product Description must be at least 3 characters.";
                }
            },
            {
                input: $("#ProductSku"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductSkuError"),
                isValid: function () {
                    return this.value !== "" && ProductSkuPattern.test(this.value);
                },
                get message() {
                    return this.value === ""
                        ? "Product SKU is required."
                        : "Product SKU must be 3 numbers followed by 7 to 10 letters.";
                }
            },
            {
                input: $("#Price"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".PriceError"),
                isValid: function () {
                    return this.value !== "" &&
                        !isNaN(this.value) &&
                        Number(this.value) >= 10 &&
                        Number(this.value) <= 100000;
                },
                get message() {
                    if (this.value === "") {
                        return "Price is required.";
                    }
                    return "Price must be minimum 10 and maximum 100000.";
                }
            },
            {
                input: $("#ProductQuantity"),
                get value() {
                    return this.input.val() ? this.input.val().trim() : "";
                },
                errorEl: $(".ProductQuantityError"),
                isValid: function () {
                    return this.value !== "" &&
                        !isNaN(this.value) &&
                        Number(this.value) >= 1 &&
                        Number.isInteger(Number(this.value));
                },
                get message() {
                    return this.value === ""
                        ? "Product Quantity is required."
                        : "Product Quantity must be a minimum of 1.";
                }
            },
            {
                input: $("#ProductCategory"),
                get value() {
                    return this.input.val() || "";
                },
                errorEl: $(".ProductCategoryError"),
                isValid: function () {
                    return this.value !== "";
                },
                message: "Product Category is required."
            },
            {
                input: $("#ProductImage"),
                get value() {
                    const files = this.input.prop("files");
                    return files && files.length > 0 ? files[0] : null;
                },
                errorEl: $(".ProductImageError"),
                isValid: function () {
                    const file = this.value;

                    if (!file) {
                        return false;
                    }
                    const validTypes = ["image/png","image/jpeg","image/jpg","image/webp"];

                    return validTypes.includes(file.type) &&
                        file.size <= 2 * 1024 * 1024;
                },
                get message() {
                    if (!this.value) {
                        return "Product Image is required.";
                    }

                    return "Product Image must be PNG, JPG, JPEG or WEBP and maximum 2 MB.";
                }
            }
        ];

        let isFormValid = true;
        let firstInvalidInput = null;

        $.each(validationRules, function (index, rule) {

            if (!rule.isValid()) {

                rule.errorEl.html(rule.message);

                isFormValid = false;

                if (!firstInvalidInput) {
                    firstInvalidInput = rule.input;
                }
            }
        });

        if (!isFormValid) {

            if (firstInvalidInput && firstInvalidInput.length) {
                firstInvalidInput.focus();
            }

            return false;
        }
       
        $.ajax({
        type: "POST",
                    url: "/CorePHP/admin/backend/Product/CreateProduct.php",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,

    success: function (response) {
        response = response.trim();

        if (response === "Exited") {
            Swal.fire({
                title: "Product Already Exists",
                icon: "warning"
            });
        } else if (response === "Success") {
            Swal.fire({
                title: "Product Created Successfully",
                icon: "success"
            }).then(() => {
                window.location = "./index.php";
            });
        } else {
            Swal.fire({
                title: response,
                icon: "error"
            });
        }
    }
});
    });
    $(document).on("click", ".delete-user", function () {

        let row = $(this).closest("tr");
        let id = row.data("id");
        let name = row.find(".product-name").text().trim();
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
                        url: "/CorePHP/admin/backend/Product/DeleteProduct.php",
                        type: "POST",
                            data: {
                            id: id
                             },
                        success: function (response) {

                            if (response.trim() === "success") {
                             swal.fire({
                                'title':'Product are Deleted',
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
});