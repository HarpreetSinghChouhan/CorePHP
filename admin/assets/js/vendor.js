$(document).ready(function(){
    // console.log("Hello Every One");
    let table = null;
    const esc = (s) => $("<div>").text(s ?? "").html();
     if ($("#vendor_datatable").length) {
        initVendorTable();
    }
    function initVendorTable(){
      table = $("#vendor_datatable").DataTable({
            ajax: {
                type:'GET',
                url: "/CorePHP/admin/backend/vendor/GetVendor.php",
                dataSrc: function (json) {
                    return Array.isArray(json) ? json : (json.data || []);
                }
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[1, "asc"]],
            columns: [
                { data: null, orderable: false, searchable: false,
                  render: (d, t, r, meta) => meta.row + 1 },
                { data: "name",   className: "user-name",  render: (d) => esc(d) },
                { data: "email",  className: "user-email", render: (d) => esc(d) },
                { data: "role",   render: (d) => esc(d) },
                { data: "age" },
                { data: "gender", render: (d) => esc(d) },
                { data: null, orderable: false, searchable: false, className: "action-cell",
                  render: () => `
                    <button type="button" class="btn-icon edit-link-btn edit-user" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="btn-icon delete-user" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>` }
            ],
            createdRow: function (row, u) {
                $(row).attr({
                    "data-id": u.id,
                    "data-name": u.name,
                    "data-email": u.email,
                    "data-age": u.age,
                    "data-gender": u.gender
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
})