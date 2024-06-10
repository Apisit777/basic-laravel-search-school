@extends('layouts.layout')
@section('title', '')

    <style>
        .loaderslide {
            width: 100%;
            height: 100%;
            background-color: #303030;
            position: fixed;
            top: 0;
            z-index: 1000;
            animation: slide_up 1s linear 0.7s forwards;
        }
        .btn {
            z-index: 1001;
            margin: auto;
        }
        @keyframes slide_up{
            0% {
                height: 100%;
            }
            70% {
                height: 10%;
            }
            100% {
                height: 0%;
            }
        }
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

        .arrow {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #000;
            transition: transform ease-in-out 0.3s;
        }

        [x-cloak] {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div id="slide" class="loaderslide"></div>

@section('content')
    <div class="justify-center items-center">
        <div class="mt-5 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการทะเบียนสินค้า</p>
        </div>
        <div class="row relative flex justify-center items-center mb-3 text-gray-900 dark:text-gray-100">
            <div class="form-group row col-md-10" style="justify-content: center;">
                <div class="form-group col-md-4">
                    <label for="countries" class="block mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                    <select id="countries" class="border border-[#6b6b6b] text-gray-900 dark:text-gray-900 text-xs rounded-sm block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected>ALL</option>
                        <option value="0">doc_no</option>
                        <option value="1">member_id</option>
                        <option value="2">refer_member</option>
                        <option value="3">refer_mobile</option>
                        <option value="4">refer_idcard</option>
                        <option value="5">refer_brand</option>
                        <option value="6">branch_id</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Value</label>
                    <input type="text" style="height: 38px;" class="form-control form-control-sm form-border" name="doc_no" id="doc_no" value="">
                </div>
                <!-- <div class="form-group col-md-3" style="position:relative">
                    <label for="">ช่วงวันที่</label>
                    <input type="date" style="height: 38px;" class="form-control" data-date-format="dd/mm/yyyy" name="date_start" id="date_start" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                    </span>
                </div>
                <div class="form-group col-md-3" style="position:relative">
                    <label for="">ถึงวันที่</label>
                    <input type="date" style="height: 38px;" class="form-control" data-date-format="dd/mm/yyyy" name="date_end" id="date_end" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                    </span>
                </div> -->
            </div>
            <div class="form-group col-md-3 my-2 mt-4">
                <label></label>
                <button id="btnSerarch" type="button" class="btn btn-warning btn-sm form-control form-border title-search"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
            </div>
        </div>

        <div class="absolute right-24 top-76">
            <a href="{{ route('product_create') }}">
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm text-gray-100 font-medium text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-sm hover:bg-blue-900 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    Add
                </button>
            </a>
        </div>
        <div class="relative mt-5 col-md-12 flex justify-center items-center text-gray-900 dark:text-gray-100">
            <div class="row">
                <table id="example" class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื้อสินค้า</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- @if(Session::get('success'))
        <script>
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            jQuery().ready(function () {
                toastr.success( {{ session() }});
            });
        </script>
    @endif --}}

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        const dlayMessage = 1000;
        const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
        const channel = pusher.subscribe('public');


        const add_element = () => {
            const template = document.createElement('div');
            template.classList.add("loaderslide");
            template.setAttribute("id","slide");
            document.body.appendChild(template);
        }

        if (sessionStorage.getItem("first_login") === 'Y') {
            sessionStorage.setItem("first_login", "yes")
            $("#slide").addClass("loaderslide");
        } else {
            $("#slide").remove();
        }

        const mytableDatatable = $('#example').DataTable({
            // new DataTable('#example', {
            'searching': false,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 20, 30, 50],
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

                "url": "/list_products",
                "type": "POST",
                'data': function(data) {
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
                        return row.seq;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.name;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        let text = "#"
                        let disabledRoute = "{{route('upate_product_status', 0)}}".replace('/0', "/" + row.id)

                        return `<button onclick="disableAppointment('${disabledRoute}',this,'${row.id}')" class="bclose btn btn-sm btn-success refersh_btn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                        </svg>
                            </button>`;

                    }
                }
            ]
        });


        function disableAppointment(url,e,id) {
            const mytableDatatable = $('#example').DataTable();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#303030',
                cancelButtonColor: '#e13636',
                confirmButtonText: `
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                    </svg>
                    Save
                `,
                cancelButtonText: `Cancle`,
                color: "#ffffff",
                background: "#202020",

                }).then(result => {
                    $.ajax({
                        url:"/broadcast",
                        method:'POST',
                        headers:{
                            'X-Socket-Id': pusher.connection.socket_id
                        },
                        data:{
                            _token:  '{{csrf_token()}}',
                            message: 'update notify'
                        }
                    }).done(function (res) {
                        console.log("🚀 ~ $ ~ res:", res)
                    });
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            beforeSend: function() {
                                $(e).parent().parent().addClass('d-none');
                            },
                            success: function (params) {
                                if(params.success){
                                    Swal.fire({
                                        title:'อัปเดตข้อมูลเรียบร้อย',
                                        text:'',
                                        icon:'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    mytableDatatable.draw();
                                }
                                else{
                                    Swal.fire({
                                        title:'อัปเดตข้อมูลไม่สำเร็จ',
                                        text:'',
                                        icon:'error',
                                    });
                                    $(e).parent().parent().removeClass('d-none');
                                }
                            },
                            error: function(er){
                                Swal.fire({
                                    title:'อัปเดตข้อมูลไม่สำเร็จ',
                                    text:'',
                                    icon:'error',
                                });
                                $(e).parent().parent().removeClass('d-none');
                            }
                        });
                    }
                });
        }

    </script>
@endsection
