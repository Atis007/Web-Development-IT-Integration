$(document).ready(function () {
    function generateFileName() {
        const now = new Date();
        const date = now.toISOString().slice(0, 10); // YYYY-MM-DD format
        return 'categories_' + date;
    }

    $('#categories').DataTable({
        ajax: {
            url: "ajax/getCategories.php",
            dataSrc: "data"
        },
        columns: [
            {data: "no"},
            {data: "name"},
            {data: "datetime"},
            {data: "id_category"}
        ],
        lengthMenu: [
            [5, 10, 25, 50, 75 ,100, -1],
            [5, 10, 25, 50, 75 ,100, "All"]
        ],
        dom: 'Blfrtip', // Buttons, length, filter, table, info, pagination
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="bi bi-clipboard"></i> Copy',
                className: 'btn btn-primary me-2',
                filename: generateFileName,
                title: 'Categories list'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success me-2',
                filename: generateFileName,
                title: 'Categories list',
                exportOptions: {columns: ':visible'}
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-pdf"></i> PDF',
                className: 'btn btn-danger me-2',
                orientation: 'landscape',
                pageSize: 'A4',
                filename: generateFileName,
                title: 'Categories list',
                exportOptions: {columns: ':visible'}
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-secondary',
                title: 'Categories list'
            }
        ],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_–_END_ of _TOTAL_ entries",
            paginate: {previous: "Prev", next: "Next"}
        }
    });
});