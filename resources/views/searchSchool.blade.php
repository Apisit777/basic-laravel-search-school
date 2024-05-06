
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.6/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .page-item.active .page-link {
        color: #fff !important;
        background: #1F2226 !important;
    }
    .buttons-excel{
        color: #fff !important;
        background: #1F2226 !important;
    }
    .table-responsive{-sm|-md|-lg|-xl|-xxl}
    element.style {
        top: 192px;
        left: 758.5px;
        z-index: 10;
        display: block;
    }
    .datepicker {
        padding: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        direction: ltr;
    }
</style>
{{-- <div class="App w-full bg-[#E7EDEF] dark:bg-[#202020] flex justify-center items-center relative"> --}}
<!-- <div class="App w-full flex justify-center items-center"> -->
<div class="justify-center items-center">
    <div class="mt-5 mb-5 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b border-blue-500 text-xl font-bold">รายการเลือกให้โรงเรียน</p>
    </div>
    <div class="row flex justify-center items-center mb-3">
        <div class="form-group row col-md-10" style="justify-content: center;">
            <div class="form-group col-md-3">
                <label>Sarch Column</label>
                <select id="contact_status" class="form-select" aria-label="Default select example">
                    <option value=""selected>ALL</option>
                    <option value="0">doc_no</option>
                    <option value="1">member_id</option>
                    <option value="2">refer_member</option>
                    <option value="3">refer_mobile</option>
                    <option value="4">refer_idcard</option>
                    <option value="5">refer_brand</option>
                    <option value="6">branch_id</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Value</label>
                <input type="text" style="height: 35px;" class="form-control form-control-sm form-border" name="doc_no" id="doc_no" value="">
            </div>
            <div class="form-group col-md-3" style="position:relative">
                <label for="">ช่วงวันที่</label>
                <input type="date" class="form-control" data-date-format="dd/mm/yyyy" name="date_start" id="date_start" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                <!-- <span class="bi bi-calendar" style="font-size: 20px; position: absolute; cursor: pointer; top: 32px; right: 7%;"> -->
                </span>
            </div>
            <div class="form-group col-md-3" style="position:relative">
                <label for="">ถึงวันที่</label>
                <input type="date" class="form-control" data-date-format="dd/mm/yyyy" name="date_end" id="date_end" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                <!-- <span class="bi bi-calendar" style="font-size: 20px; position: absolute; cursor: pointer; top: 32px; right: 7%;"> -->
                </span>
            </div>
        </div>
        <div class="form-group col-md-3 my-2 mt-4">
            <label></label>
            <button id="btnSerarch" type="button" class="btn btn-warning btn-sm form-control form-border title-search"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
        </div>
    </div>
    <!-- <ul class="pt-5 space-y-2 border-t border-blue-500"> -->
    <div class="col-md-12 flex justify-center items-center">
        <div class="row">
            <table id="example" class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>doc_datetime</th>
                        <th>doc_no</th>
                        <th>event</th>
                        <th>doc_refer</th>
                        <th>flag</th>
                        <!-- <th>cancel_date</th> -->
                        <!-- <th>cancel_user</th> -->
                        <th>member_id</th>
                        <!-- <th>do_befor</th> -->
                        <th>do_reedem</th>
                        <!-- <th>do_balance</th> -->
                        <th>donation_use</th>
                        <!-- <th>tb_id</th> -->
                        <th>school_id</th>
                        <th>remark</th>
                        <!-- <th>type_member</th> -->
                        <!-- <th>reg_user</th> -->
                        <!-- <th>reg_time</th> -->
                        <th>upd_user</th>
                        <th>upd_time</th>
                        <!-- <th>time_up</th> -->
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                    <th>ID</th>
                        <th>doc_datetime</th>
                        <th>doc_no</th>
                        <th>event</th>
                        <th>doc_refer</th>
                        <th>flag</th>
                        <!-- <th>cancel_date</th> -->
                        <!-- <th>cancel_user</th> -->
                        <th>member_id</th>
                        <!-- <th>do_befor</th> -->
                        <th>do_reedem</th>
                        <!-- <th>do_balance</th> -->
                        <th>donation_use</th>
                        <!-- <th>tb_id</th> -->
                        <th>school_id</th>
                        <th>remark</th>
                        <!-- <th>type_member</th> -->
                        <!-- <th>reg_user</th> -->
                        <!-- <th>reg_time</th> -->
                        <th>upd_user</th>
                        <th>upd_time</th>
                        <!-- <th>time_up</th> -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    const mytableDatatable = $('#example').DataTable({
    // new DataTable('#example', {
        'searching': false,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [20, 30, 50],
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
            'data': function(data){
                // Read values
                const doc_no = $('#doc_no').val();
                const date_start = $('#date_start').val();
                const date_end = $('#date_end').val();

                // Append to data
                data.doc_no = doc_no;
                data.date_start = date_start;
                data.date_end = date_end;

                data._token = $('meta[name="csrf-token"]').attr('content');
            }
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
                    return row.doc_datetime;
                }
            },
            {
                targets: 2,
                orderable: true,
                render: function(data, type, row) {
                    return row.doc_no;
                }
            },
            {
                targets: 3,
                orderable: true,
                render: function(data, type, row) {
                    return row.event;
                }
            },
            {
                targets: 4,
                orderable: true,
                render: function(data, type, row) {
                    return row.doc_refer;
                }
            },
            {
                targets: 5,
                orderable: true,
                render: function(data, type, row) {
                    return row.flag;
                }
            },
            // {
            //     targets: 6,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.cancel_date;
            //     }
            // },
            // {
            //     targets: 7,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.cancel_user;
            //     }
            // },
            {
                targets: 6,
                orderable: true,
                render: function(data, type, row) {
                    return row.member_id;
                }
            },
            // {
            //     targets: 9,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.do_befor;
            //     }
            // },
            {
                targets: 7,
                orderable: true,
                render: function(data, type, row) {
                    return row.do_reedem;
                }
            },
            // {
            //     targets: 11,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.do_balance;
            //     }
            // },
            {
                targets: 8,
                orderable: true,
                render: function(data, type, row) {
                    return row.donation_use;
                }
            },
            // {
            //     targets: 13,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.tb_id;
            //     }
            // },
            {
                targets: 9,
                orderable: true,
                render: function(data, type, row) {
                    return row.school_id;
                }
            },
            {
                targets: 10,
                orderable: true,
                render: function(data, type, row) {
                    return row.remark;
                }
            },
            // {
            //     targets: 16,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.type_member;
            //     }
            // },
            // {
            //     targets: 17,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.reg_user;
            //     }
            // },
            // {
            //     targets: 18,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.reg_time;
            //     }
            // },
            {
                targets: 11,
                orderable: true,
                render: function(data, type, row) {
                    return row.upd_user;
                }
            },
            {
                targets: 12,
                orderable: true,
                render: function(data, type, row) {
                    return row.upd_time;
                }
            },
            // {
            //     targets: 21,
            //     orderable: true,
            //     render: function(data, type, row) {
            //         return row.time_up;
            //     }
            // },
        ]
    });

    $('#btnSerarch').click(function() {
        mytableDatatable.draw();
    });

    // $('#date_start').flatpickr({
    //     'locale': 'th',
    //     'plugins': [new rangePlugin({input: '#date_end'})]
    // });

    // $(document).ready(function(){
    //     $(function () {
    //         $('#date_start').datepicker({
    //             format: 'yyyy/mm/dd' 
    //         });
    //         $('#date_end').datepicker({
    //             format: 'yyyy/mm/dd' 
    //         });
    //     });	
    // });
</script>
