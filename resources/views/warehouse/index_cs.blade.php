@extends('layouts.layout')
@section('title', '')
    <style>
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
            max-height: 258px !important;
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
        .select2-container {
            margin-bottom: 0rem!important;
        }
        .select2-container--default .select2-selection--single {
            height: 2rem!important;
            border-width: 1px;
            padding: 0.1rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            position: absolute;
            margin-top: -5px!important;
        }
        .h-10 {
            height: 2rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: small!important;
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
        /* ************************************************************** */
        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .card img {
            max-width: 100%;
            height: auto;
        }
        .dt-length  {
            color: #818181!important;
        }
        .view-toggle {
            display: flex;
            border: 1px solid #666;
            border-radius: 5px;
            overflow: hidden;
            width: fit-content;
        }
        .toggle-btn {
            padding: 4px 5px;
            border: none;
            background: none;
            cursor: pointer;
            color: white;
            background-color: #2a2a2a;
            transition: background 0.3s;
        }
        .toggle-btn.active {
            background-color: #05395D;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-2 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">List Dimension</p>
        </div>
        <div class="grid gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($brands as $key => $brand)
                                <option value={{ $brand }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <div class="md:col-span-3" >
                            <select name="country"></select>
                        </div>
                    </div> -->

                    <div class="md:col-span-3" >
                        <label for="" class="font-medium">@lang('global.content.search')</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
                    </div>
                    <div class="md:col-span-6 text-center">
                        <div class="inline-flex items-center">
                            <!-- <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                ค้นหา
                            </a> -->
                            <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-2.5 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
                                <svg class="hidden h-5 w-5 md:inline-block rotate"
                                    viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                    <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 93,62 C 83,82 65,96 48,96 32,96 19,89 15,79 L 5,90 5,53 40,53 29,63 c 0,0 5,14 26,14 16,0 38,-15 38,-15 z"/>
                                    <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 5,38 C 11,18 32,4 49,4 65,4 78,11 85,21 L 95,10 95,47 57,47 68,37 C 68,37 63,23 42,23 26,23 5,38 5,38 z"/>
                                </svg>
                                @lang('global.content.clear')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>

        <div id="list-view" class="view-section bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="table_dimension" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสบริษัท</th>
                            <th>รหัสสินค้า</th>
                            <th>Barcode</th>
                            <th>รหัสผู้ขาย</th>
                            <th>ชื่อภาษาไทย</th>
                            <th>รูปภาพ</th>
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
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>

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
            // $('.js-example-basic-single').select2();
            $('.js-example-basic-single').select2({
                width: '100%',
            }).on('select2:open', function () {
                // ดึง element ของ dropdown
                $('.select2-results__options').hide().slideDown(250);
                }).on('select2:close', function () {
                $('.select2-results__options').slideUp(200);
            });

            // กำหนด event เมื่อกดปุ่ม "ล้างข้อมูล"
            $('button[type="reset"]').click(function() {
                $('#brand_id').val(null).trigger('change'); // Clear ค่า select2
                $('#search').val('').trigger('keyup'); // เคลียร์ค่า input ค้นหา
            });

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

        const mytableDatatable = $('#table_dimension').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "580px",
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('warehouse.list_warehouse') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    // data.BARCODE = $('#BARCODE').val();
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
                        // ถ้า img_url เป็นค่าว่าง หรือ null ให้ใช้รูป default
                        let imageUrl = row.img_url && row.img_url.trim() !== "" ? row.img_url : "https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg";
                        
                        return `
                            <div class="flex justify-center items-center">
                                <img src="${imageUrl}" class="w-20 h-16 object-cover rounded-sm shadow-md border border-gray-300 cursor-pointer transition-transform duration-300 ease-in-out hover:scale-125 hover:shadow-md hover:shadow-gray-400 dark:hover:shadow-md dark:hover:shadow-gray-400" alt="Product Image">
                            </div>
                        `;
                    }
                },
                {
                    targets: 6,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let disabledRoute = "{{route('warehouse.update', 0)}}".replace('/0', "/" + row.product_id)
                        let text = "#"
                        return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                    <a href="{{route('warehouse.edit_cs', 0)}}"
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

        // $('#btnSerarch').click(function() {
        //     mytableDatatable.draw();
        //     return false;
        // });

        // Function สำหรับเรียกใช้ DataTable เมื่อมีการพิมพ์
        function searchTable() {
            console.log("Search: ", $('#search').val());
            // บังคับให้ DataTables รีโหลดข้อมูลใหม่
            mytableDatatable.ajax.reload(null, false); 
        }

        function brandSearch() {
            mytableDatatable.draw();
        }

    </script>
@endsection
