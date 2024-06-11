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
        <div class="fixed flex bottom-5 right-5 z-10">
            <a href="{{ route('product_create') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-2 mr-2 mt-20 rounded-full group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        <!-- <div class="row relative flex justify-center items-center mb-3 text-gray-900 dark:text-gray-100">
            <div class="form-group row col-md-10" style="justify-content: center;">
                <div class="form-group col-md-4">
                    <label for="countries" class="block mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                    <select id="countries" class="bg-gray-50 dark:bg-[#303030] border border-[#6b6b6b] text-gray-900 dark:text-gray-900 text-xs rounded-sm block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                    <input type="text" style="height: 38px;" class="form-control form-control-sm form-border bg-gray-50 dark:bg-[#303030]" name="doc_no" id="doc_no" value="">
                </div>
            </div>
        </div> -->

        <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3" >
                        <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                        <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5 ">
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
                    <div class="md:col-span-3" >
                        <label for="">ชื่อพนักงาน<span class="text-danger"> *</span></label>
                        <input type="text" name="name" id="id_brand" onkeyup="checkNameBrand()" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                    </div>
                    <div class="md:col-span-6 text-center">
                        <div class="inline-flex items-center">
                            <!-- <label></label>
                            <button id="btnSerarch" type="button" class="btn btn-warning btn-sm form-control form-border title-search"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button> -->
                            <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-4 mr-2 rounded group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                ค้นหา
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="absolute right-24 top-76">
            <a href="{{ route('product_create') }}">
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm text-gray-100 font-medium text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-sm hover:bg-blue-900 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                    Add
                </button>
            </a>
        </div> -->
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

        {{-- @if (session('status'))
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
                toastr.success('{{Session::get("status")}}');
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
    @if (session('status'))
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
                toastr.success('{{ session('status') }}');
            });
        </script>
    @endif 
    <script>
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

                        return `<div class="inline-flex items-center rounded-md shadow-sm">
                                    <button onclick="disableAppointment('${disabledRoute}',this,'${row.id}')" class="bclose btn btn-sm btn-success refersh_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <a href="#" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 mr-2 rounded group">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                        </svg>
                                        Edit
                                     </a>
                                </div>
                               `;
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
                    // $.ajax({
                    //     url:"/broadcast",
                    //     method:'POST',
                    //     headers:{
                    //         'X-Socket-Id': pusher.connection.socket_id
                    //     },
                    //     data:{
                    //         _token:  '{{csrf_token()}}',
                    //         message: 'update notify'
                    //     }
                    // }).done(function (res) {
                    //     console.log("🚀 ~ $ ~ res:", res)
                    // });
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
