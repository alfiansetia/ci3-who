<div class="container-fluid">
    <h1><?= $title ?></h1>

    <div class="responsive">
        <form method="POST" action="" id="delete">
            <table class="table table-sm table-hover" id="table" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center" style="width: 30px;">No</th>
                        <th>Name</th>
                        <th>Cat</th>
                        <th>AKL</th>
                        <th>AKL END</th>
                        <th>AKL FILE</th>
                        <th>Desc</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</div>


<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('product/import') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="product">File :</label>
                        <input type="file" name="product" id="product" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input name="akl" class="form-check-input" type="checkbox" id="akl" value="true">
                            <label class="form-check-label" for="akl">AKL</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="cat" class="form-check-input" type="checkbox" id="cat" value="true">
                            <label class="form-check-label" for="cat">Cat</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button name="submit" value="OK" type="submit" class="btn btn-primary">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var tabel = null;
    $(document).ready(function() {
        var table = $('#table').DataTable({
            // processing: true,
            // serverSide: true,
            rowId: 'prod_id',
            ajax: "<?= base_url('product/get_data/') ?>",
            dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            lengthMenu: [
                [10, 50, 100, 500, 1000],
                ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
            ],
            pageLength: 10,
            lengthChange: false,
            order: [
                [1, "asc"]
            ],
            columns: [{
                    data: 'prod_id',
                    className: "text-center",
                    searchable: false,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return `<input type="checkbox" name="id[]" value="${data}" class="new-control-input child-chk select-customers-info">`
                    }
                }, {
                    data: "prod_code"
                },
                {
                    data: "cat_name"
                },
                {
                    data: "akl_name"
                },
                {
                    data: "akl_end"
                },
                {
                    data: "akl_file"
                },
                {
                    data: "prod_desc"
                }
            ],
            buttons: [, {
                text: '<i class="fa fa-plus"></i>Add',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Add Data'
                },
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
                    $('#name').focus();
                }
            }, {
                text: '<i class="fas fa-trash"></i>Del',
                className: 'btn btn-sm btn-danger',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Delete Selected Data'
                },
                action: function(e, dt, node, config) {
                    var id = $('input[name="id[]"]:checked').length;
                    if (id <= 0) {
                        alert('No Selected Data !');
                    } else {
                        if (confirm('Delete Data?')) {
                            $("#delete").submit();
                        }
                    }
                }
            }, {
                extend: "colvis",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Column Visible'
                },
                className: 'btn btn-sm btn-primary'
            }, {
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                extend: "collection",
                text: '<i class="fas fa-download"></i>Export',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Export Data'
                },
                className: 'btn btn-sm btn-primary',
                buttons: [{
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }],
            }],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = '<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">'
            },
        });

        var id;

        multiCheck(table);

        $('#table tbody').on('click', 'tr td:not(:first-child)', function() {
            id = table.row(this).id()
            $.ajax({
                url: "<?= base_url('product/edit/') ?>" + id,
                method: 'GET',
                success: function(result) {
                    console.log(result)
                    $('#edit_reset').val(result.data.prod_id);
                    $('#edit_id').val(result.data.prod_id);
                    $('#edit_name').val(result.data.name);
                },
                beforeSend: function() {
                    console.log('otw')
                },
                error: function(xhr, status, error) {
                    er = xhr.responseJSON.errors
                    alert('Server Error');
                }
            });
            $('#modalEdit').modal('show');
        });

        $('#delete').submit(function(event) {
            var form = this;
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('product/destroy') ?>",
                data: $(form).serialize(),
                beforeSend: function() {
                    console.log('otw')
                },
                success: function(res) {
                    table.ajax.reload();
                    alert(res.message)

                },
                error: function(xhr, status, error) {
                    er = xhr.responseJSON.errors
                    console.log(er);
                    alert('Server Error');
                }
            });
        });
    });
</script>