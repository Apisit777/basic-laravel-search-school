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
            z-index: 10;
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
        .buttons-collection{
            color: #fff !important;
            background: #1F2226 !important;
        }
        [x-cloak] {
            display: none;
        }
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
        }
        .swal2-select option {
            background-color: #303030;
        }
        .select2-container--open {
            z-index: 99999999999999;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            float: right;
            cursor: pointer;
            --tw-text-opacity: 1;
            color: rgb(200 30 30 / var(--tw-text-opacity));
            margin-right: 24px!important;
            margin-top: -1px!important;
            font-size: 20px!important;
        }
        .loading_create_menu {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading_create_menu_consumables {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        *{margin: 0;padding:0px}

        .header{
            width: 100%;
            /* background-color: #0d77b6 !important; */
            height: 0px;
        }

        .showLeft{
            /* background-color: #0d77b6 !important;
            border:1px solid #0d77b6 !important;
            text-shadow: none !important;
            color:#fff !important; */
            padding:10px;
        }

        .icons li {
            /* background: none repeat scroll 0 0 #fff; */
            height: 7px;
            width: 7px;
            line-height: 0;
            list-style: none outside none;
            margin-right: 15px;
            margin-top: 3px;
            vertical-align: top;
            border-radius:50%;
            pointer-events: none;
        }

        .btn-left {
            left: 0.4em;
        }

        .btn-right {
            right: 0.4em;
        }

        .btn-left, .btn-right {
            position: absolute;
            top: -2.5em;
            right: -105px;
            z-index: 999;
        }

        .dropbtn {
            /* background-color: #4CAF50; */
            position: fixed;
            /* color: white; */
            font-size: 13.5px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            /* background-color: #3e8e41; */
        }

        .dropdown {
            position: absolute;
            display: inline-block;
            left: 500px;
            /* right: -54.5em; */
        }

        .dropdown-content {
            display: none;
            position: relative;
            margin-top: 60px;
            background-color: #f9f9f9;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            /* color: black; */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* .dropdown a:hover {background-color: rgb(229 231 235);} */

        .show {display:block;}

        span.dt-column-order {
            display: none;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">List Dimension</p>
        </div>
        <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($brands as $key => $brand)
                                <option value={{ $brand->COMPANY }}{{ $brand->DESCRIPTION }}>{{ $brand->COMPANY.' - ('.$brand->DESCRIPTION.')' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3" >
                        <label for="">ค้นหา</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" />
                    </div>
                    <div class="md:col-span-6 text-center">
                        <div class="inline-flex items-center">
                            <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
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
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 relative"></ul>
        <!-- <div class="flex right-12 z-10 absolute mt-3">
            <div class="relative" data-twe-dropdown-position="dropstart">
                <button
                    class="flex items-center rounded bg-[#303030] hover:bg-[#404040] px-4 pb-[5px] pt-[6px] text-sm font-bold uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                    type="button"
                    id="dropdownMenuWarehouse"
                    data-twe-dropdown-toggle-ref
                    aria-expanded="false"
                    data-twe-ripple-init
                    data-twe-ripple-color="light">
                    <span class="me-2 [&>svg]:h-5 [&>svg]:w-5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                    </svg>
                    </span>
                        เพิ่มข้อมูลคลังสิ้นค้า
                </button>
                <ul style="z-index: 999999999;" class="absolute divide-y divide-gray-600 rounded-sm w-48 md:w-52 dark:divide-gray-600 float-left m-0 hidden min-w-max list-none overflow-hidden border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                    aria-labelledby="dropdownMenuWarehouse"
                    data-twe-dropdown-menu-ref>
                    <li>
                        <a href="{{ route('warehouse.create') }}" class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                            <svg class="h-5 w-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="currentColor" viewBox="0 0 512 512"  xml:space="preserve">
                                <g>
                                    <path class="st0" d="M504.262,66.75L445.226,7.706c-10.291-10.284-26.938-10.267-37.222,0l-38.278,38.278l96.282,96.266
                                        l38.254-38.295C514.537,93.672,514.554,77.017,504.262,66.75z"/>
                                    <path class="st0" d="M32.815,382.921L0.025,512l129.055-32.83l319.398-319.431l-96.249-96.265L32.815,382.921z M93.179,404.792
                                        l-21.871-21.871l278.289-278.289l21.887,21.887L93.179,404.792z"/>
                                </g>
                            </svg>
                            <span class="ml-2.5">
                                เพิ่มข้อมูล
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> -->

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสบริษัท</th>
                            <th>รหัสสินค้า</th>
                            <th>Barcode</th>
                            <th>รหัสผู้ขาย</th>
                            <th>ชื่อภาษาไทย</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/3.10.1-jszip.min.js') }}"></script>
    <script src="{{ asset('js/2.0.5-dataTables.js') }}"></script>
    <script src="{{ asset('js/3.0.2-dataTables.buttons.js') }}"></script>
    <script src="{{ asset('js/3.0.2-buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('js/buttons-html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons-print.min.js') }}"></script>
    <script src="{{ asset('js/buttons-colVis.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

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

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        function changeLanguage(language) {
            var element = document.getElementById("url");
            element.value = language;
            element.innerHTML = language;
        }

        function showDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        const mytableDatatable = $('#example').DataTable({
            // new DataTable('#example', {

            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
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

                "url": "{{ route('warehouse.list_warehouse') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.BARCODE = $('#BARCODE').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.company_id;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.product_id;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.barcode;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.vendor_id;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.name_thai;
                    }
                },
                {
                    targets: 5,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let disabledRoute = "{{route('warehouse.update', 0)}}".replace('/0', "/" + row.product_id)
                        let text = "#"
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('warehouse.edit', 0)}}"
                                            type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                `.replaceAll('/0', "/" + row.product_id);

                    }
                }
            ]
        });

        var filteredData = mytableDatatable
            .column( 0 )
            .data()
            .filter( function ( value, index ) {
                return false;
                // return value > 20 ? true : false;
        } );

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            return false;
        });
    </script>
@endsection
