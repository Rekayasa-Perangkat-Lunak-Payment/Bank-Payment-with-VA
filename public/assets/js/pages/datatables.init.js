$(document).ready(function () {
    // Basic DataTable Initialization
    $("#datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        buttons: [
            "copy",
            "excel",
            "pdf",
            {
                extend: "colvis",
                text: "Pilih Kolom" // Mengubah teks tombol "Column visibility"
            }
        ]
    });

    // DataTable with Buttons
    var datatableWithButtons = $("#datatable-buttons").DataTable({
        lengthChange: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        buttons: [
            "copy",
            "excel",
            "pdf",
            {
                extend: "colvis",
                text: "Pilih Kolom" // Mengubah teks tombol "Column visibility"
            }
        ]
    });
    datatableWithButtons
        .buttons()
        .container()
        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

    // Tambahkan event listener untuk deteksi perubahan visibilitas kolom
    datatableWithButtons.on('column-visibility.dt', function (e, settings, column, state) {
        var columnIndex = datatableWithButtons.column(column).index();

        // Jika kolom disembunyikan
        if (!state) {
            $("#datatable-buttons tbody tr").each(function () {
                $(this)
                    .find("td:eq(" + columnIndex + ")")
                    .addClass("hidden-column"); // Tambahkan kelas untuk kolom tersembunyi
            });
        } else {
            // Jika kolom ditampilkan kembali
            $("#datatable-buttons tbody tr").each(function () {
                $(this)
                    .find("td:eq(" + columnIndex + ")")
                    .removeClass("hidden-column"); // Hapus kelas untuk kolom yang terlihat
            });
        }
    });

    // Styling the dropdown
    $(".dataTables_length select").addClass("form-select form-select-sm");

    // Selection DataTable
    $("#selection-datatable").DataTable({
        select: { style: "multi" },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Key Table DataTable
    $("#key-datatable").DataTable({
        keys: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Alternative Pagination DataTable
    $("#alternative-page-datatable").DataTable({
        pagingType: "full_numbers",
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            $(".dataTables_length select").addClass("form-select form-select-sm");
        }
    });

    // Scroll Vertical DataTable
    $("#scroll-vertical-datatable").DataTable({
        scrollY: "350px",
        scrollCollapse: true,
        paging: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Complex Header DataTable
    $("#complex-header-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            $(".dataTables_length select").addClass("form-select form-select-sm");
        },
        columnDefs: [{ visible: false, targets: -1 }]
    });

    // State Saving DataTable
    $("#state-saving-datatable").DataTable({
        stateSave: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'></i>",
                next: "<i class='mdi mdi-chevron-right'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            $(".dataTables_length select").addClass("form-select form-select-sm");
        }
    });
});
