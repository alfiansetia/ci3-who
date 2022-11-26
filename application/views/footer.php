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
    var tabel = null;
    $(document).ready(function() {
        // tabel = $('#table').DataTable({
        //     "responsive": true,
        //     "ordering": true,
        //     // "order": [
        //     //     [0, 'asc']
        //     // ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        //     "ajax": "<?= base_url('product/get_data'); ?>",
        //     "deferRender": true,
        //     "aLengthMenu": [
        //         [15, 50, 100, 500, 1000],
        //         [15, 50, 100, 500, 1000]
        //     ],
        //     lengthChange: false,
        //     "columns": [{
        //             "data": 'prod_id',
        //             "sortable": false,
        //             render: function(data, type, row, meta) {
        //                 return meta.row + meta.settings._iDisplayStart + 1;
        //             }
        //         }, {
        //             "data": "prod_code"
        //         },
        //         {
        //             "data": "cat_name"
        //         },
        //         {
        //             "data": "akl_name"
        //         },
        //         {
        //             "data": "akl_end"
        //         },
        //         {
        //             "data": "akl_file"
        //         },
        //         {
        //             "data": "prod_desc"
        //         },
        //         {
        //             "data": "prod_id",
        //             "sortable": false,
        //             "render": function(data, type, row, meta) {
        //                 let text = `<a href="<?= base_url('product/edit/') ?>${data}" class="btn btn-warning btn-sm">Edit</a>
        //                             <a href="<?= base_url('product/destroy/') ?>${data}" class="btn btn-danger btn-sm" onclick="return confirm('Delete Data?');">Delete</a>`
        //                 return text;
        //             }
        //         },
        //     ],
        //     buttons: [, {
        //         text: '<i class="fa fa-plus"></i>Add',
        //         className: 'btn btn-sm btn-primary bs-tooltip',
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Add Data'
        //         },
        //         action: function(e, dt, node, config) {
        //             $('#modalAdd').modal('show');
        //             $('#name').focus();
        //         }
        //     }, {
        //         text: '<i class="fas fa-trash"></i>Del',
        //         className: 'btn btn-sm btn-danger',
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Delete Selected Data'
        //         },
        //         action: function(e, dt, node, config) {
        //             swal({
        //                 title: 'Delete Selected Data?',
        //                 text: "You won't be able to revert this!",
        //                 type: 'warning',
        //                 showCancelButton: true,
        //                 confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
        //                 confirmButtonAriaLabel: 'Thumbs up, Yes!',
        //                 cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
        //                 cancelButtonAriaLabel: 'Thumbs down',
        //                 padding: '2em',
        //                 animation: false,
        //                 customClass: 'animated tada',
        //             }).then(function(result) {
        //                 if (result.value) {
        //                     var id = $('input[name="id[]"]:checked').length;
        //                     if (id <= 0) {
        //                         swal({
        //                             title: 'Failed!',
        //                             text: "No Selected Data!",
        //                             type: 'error',
        //                         })
        //                     } else {
        //                         $("#delete").submit();
        //                     }
        //                 }
        //             })
        //         }
        //     }, {
        //         extend: "colvis",
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Column Visible'
        //         },
        //         className: 'btn btn-sm btn-primary'
        //     }, {
        //         extend: "pageLength",
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Page Length'
        //         },
        //         className: 'btn btn-sm btn-info'
        //     }],
        //     initComplete: function() {
        //         $('#table').DataTable().buttons().container().appendTo('#tableData_wrapper .col-md-6:eq(0)');
        //     }
        // });

        var table = $('#table').DataTable({
            // processing: true,
            // serverSide: true,
            rowId: 'id',
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
            columnDefs: [{
                targets: [0, 7],
                className: "text-center",
            }],
            "columns": [{
                    "data": 'prod_id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    "data": "prod_code"
                },
                {
                    "data": "cat_name"
                },
                {
                    "data": "akl_name"
                },
                {
                    "data": "akl_end"
                },
                {
                    "data": "akl_file"
                },
                {
                    "data": "prod_desc"
                },
                {
                    "data": "prod_id",
                    "sortable": false,
                    "render": function(data, type, row, meta) {
                        let text = `<a href="<?= base_url('product/edit/') ?>${data}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('product/destroy/') ?>${data}" class="btn btn-danger btn-sm" onclick="return confirm('Delete Data?');">Delete</a>`
                        return text;
                    }
                },
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
                    swal({
                        title: 'Delete Selected Data?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
                        confirmButtonAriaLabel: 'Thumbs up, Yes!',
                        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
                        cancelButtonAriaLabel: 'Thumbs down',
                        padding: '2em',
                        animation: false,
                        customClass: 'animated tada',
                    }).then(function(result) {
                        if (result.value) {
                            var id = $('input[name="id[]"]:checked').length;
                            if (id <= 0) {
                                swal({
                                    title: 'Failed!',
                                    text: "No Selected Data!",
                                    type: 'error',
                                })
                            } else {
                                $("#delete").submit();
                            }
                        }
                    })
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
            }]
        });
    });
</script>

</html>