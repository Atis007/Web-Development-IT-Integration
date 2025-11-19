$(document).ready(function () {

    function generateFileName() {
        const now = new Date();
        const date = now.toISOString().slice(0, 10); // YYYY-MM-DD
        return 'categories_' + date;
    }

    const table = $('#categories').DataTable({
        ajax: {
            url: "ajax/getCategories.php",
            dataSrc: "data"
        },
        columns: [
            {data: "no"},
            {data: "name"},
            {data: "datetime"},
            {data: "id_category"},

            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary me-1 btn-edit" 
                                data-id="${row.id_category}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" 
                                data-id="${row.id_category}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
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
                title: 'Categories list'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success me-2',
                filename: generateFileName,
                title: 'Categories list',
                exportOptions: {columns: [0, 1, 2, 3]}
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-pdf"></i> PDF',
                className: 'btn btn-danger me-2',
                orientation: 'landscape',
                pageSize: 'A4',
                filename: generateFileName,
                title: 'Categories list',
                exportOptions: {columns: [0, 1, 2, 3]}
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-secondary',
                title: 'Categories list',
                exportOptions: {columns: [0, 1, 2, 3]}
            }
        ]
    });

    //  Bootstrap modal instance
    const editModalEl = document.getElementById('editModal');
    const editModal = new bootstrap.Modal(editModalEl);

    // =========================
    //  EDIT button – open modal
    // =========================
    $('#categories tbody').on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        const rowData = table.row($(this).closest('tr')).data();

        $('#edit_id_category').val(rowData.id_category);
        $('#edit_name').val(rowData.name);
        $('#edit_datetime').val(rowData.datetime);

        editModal.show();
    });

    // =========================
    //  EDIT – send updated data to the server (updateCategory.php)
    // =========================
    $('#editForm').on('submit', function (e) {
        e.preventDefault();

        const id_category = $('#edit_id_category').val();
        const name = $('#edit_name').val();
        const datetime = $('#edit_datetime').val();

        $.post('ajax/updateCategory.php', {
            id_category,
            name,
            datetime
        }, function (response) {
            if (response.success) {
                // Option 1: reload entire DataTable from the database
                // table.ajax.reload(null, false); // false = stay on the current page

                // Option 2 (used here): update only the modified row in DataTables
                table.rows().every(function () {
                    const d = this.data();
                    if (String(d.id_category) === String(id_category)) {
                        d.name = name;
                        d.datetime = datetime;
                        this.data(d);
                    }
                });
                table.draw(false); // redraw without returning to the first page

                editModal.hide();
            } else {
                alert('Update error: ' + (response.message || 'Unknown error'));
            }
        }, 'json').fail(function (xhr) {
            alert('Server error (updateCategory): ' + xhr.status);
        });
    });

    // =========================
    //  DELETE button
    // =========================
    $('#categories tbody').on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const row = table.row($(this).closest('tr'));

        if (!confirm(`Are you sure you want to delete the record with ID = ${id}?`)) {
            return;
        }

        $.post('ajax/deleteCategory.php', {
            id_category: id
        }, function (response) {
            if (response.success) {
                // Option 1: remove the row from DataTables (client-side only)
                row.remove().draw(false);

                // Option 2: reload data from the database
                // table.ajax.reload(null, false);
            } else {
                alert('Delete error: ' + (response.message || 'Unknown error'));
            }
        }, 'json').fail(function (xhr) {
            alert('Server error (deleteCategory): ' + xhr.status);
        });
    });
});