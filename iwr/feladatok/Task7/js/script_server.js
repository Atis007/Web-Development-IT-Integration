$(document).ready(function () {
    function generateFileName() {
        const now = new Date();
        const date = now.toISOString().slice(0, 10); // YYYY-MM-DD
        return 'worker_table_data_' + date;
    }


    $('#categories').DataTable({
        data: categoriesData,
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "name" },
            { data: "company" },
            { data: "position" },
            { data: "email" },
            { data: "phone" },
            {
                data: "qr_filename",
                render: function (data) {
                    return `<img src="codes/${data}" width="80">`;
                }
            }
        ],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="bi bi-clipboard"></i> Copy',
                className: 'btn btn-primary me-2',
                filename: generateFileName,
                title: 'Danger device list'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success me-2',
                filename: generateFileName,
                title: 'Danger device list',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-pdf"></i> PDF',
                className: 'btn btn-danger me-2',
                orientation: 'landscape',
                pageSize: 'A4',
                filename: generateFileName,
                title: 'Danger device list',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-secondary',
                title: 'Danger device list'
            }
        ],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_–_END_ of _TOTAL_ entries",
            paginate: { previous: "Prev", next: "Next" }
        }
    });
});