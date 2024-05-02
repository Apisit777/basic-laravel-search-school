
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">

<style>
    .page-item.active .page-link {
        color: #fff !important;
        background: #1F2226 !important;
    }
</style>

{{-- <div class="App w-full bg-[#E7EDEF] dark:bg-[#202020] flex justify-center items-center relative"> --}}
<div class="App w-full  flex justify-center items-center relative">
    <table id="example" class="table table-dark table-hover" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
            </tr>
        </tfoot>
    </table>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
<script>
    // const mytableDatatable = $('#example').DataTable({
    new DataTable('#example', {
        'searching': true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [10, 25, 50],
        "layout": {
            "topStart": {
                "buttons": ['excel', 'colvis']
                // buttons: ['copy', 'excel', 'pdf', 'colvis']
            }
        },
        "ajax": {
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            "url": "{{ route('search_school') }}",
            "type": "POST",
        },
        orderable: true,
        columnDefs: [{
                targets: 0,
                orderable: true,
                render: function(data, type, row) {
                    return row.id;
                }
            },
            {
                targets: 1,
                orderable: true,
                render: function(data, type, row) {
                    return row.name;
                }
            },
            {
                targets: 2,
                orderable: true,
                render: function(data, type, row) {
                    return row.price;
                }
            }
        ]
    });
</script>
