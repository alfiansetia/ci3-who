<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->

<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('product/import') ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="product" id="product" class="form-control">
                    <button name="submit" value="OK" type="submit" class="btn btn-primary">SAVE</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.colVis.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.js"></script>
</body>

<?php if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
} ?>
<script>
    function multiCheck(tb_var) {
        tb_var.on("change", ".chk-parent", function() {
                var e = $(this).closest("table").find("td:first-child .child-chk"),
                    a = $(this).is(":checked");
                $(e).each(function() {
                    a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
                })
            }),
            tb_var.on("change", "tbody tr .new-control", function() {
                $(this).parents("tr").toggleClass("active")
            })
    }
</script>
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

</html>