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
        .dt-length  {
            color: #818181!important;
        }
        .table td, .table th {
            padding: 0.20rem !important;
        }



         #account_schedule {
            table-layout: auto;
        }
        #account_schedule th,
        #account_schedule td {
            white-space: nowrap;
        }

        /* จัดกลางแนวนอน + แนวตั้ง */
        table.dataTable td.dt-control {
            text-align: center !important;
            vertical-align: middle !important;
            width: 30px;
            padding: 0 !important;
            background-color: transparent !important;
        }

        /* ✅ เปลี่ยนสีลูกศรใน dark mode */
        table.dataTable td.dt-control::before {
            color: #ffffff !important; /* สีขาว */
            font-size: 16px;
            margin-top: 1px; /* ปรับเล็กน้อยให้ตรงกลาง */
        }

        .btn-rotate:hover .rotate{
            transform: rotate(180deg);
            /* transform: rotate(60deg); */
            transition: 0.5s all;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        div.dt-container div.dt-length select {
            width: auto;
            display: inline-block;
            margin-right: 0.5em;
            height: 36px !important;
        }


        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(8deg); }
            75% { transform: rotate(-8deg); }
        }
        .animate-shake {
            animation: shake 0.4s ease-in-out infinite;
        }



        /* ===== Theme tokens (fallback) ===== */
        :root{
        --dt-ink: #0f172a;
        --dt-muted:#64748b;
        --dt-bg: #ffffff;
        --dt-card:#ffffff;
        --dt-line: rgba(15,23,42,.12);
        --dt-pill: rgba(2,132,199,.10);
        --dt-accent:#2563eb;
        --dt-accent-ink:#ffffff;
        }

        /* ===== Dark mode (รองรับ 2 แบบ: data-theme หรือ prefers-color-scheme) ===== */
        html[data-theme="dark"], 
        @media (prefers-color-scheme: dark){
        :root{
            --dt-ink:#e5e7eb;
            --dt-muted:#94a3b8;
            --dt-bg:#0b1220;
            --dt-card:#0f172a;
            --dt-line: rgba(148,163,184,.18);
            --dt-pill: rgba(59,130,246,.16);
            --dt-accent:#60a5fa;
            --dt-accent-ink:#0b1220;
        }
        }

        /* ===== Toggle button ===== */
        .dt-toggle.btn-toggle{
        /* width: 34px;
        height: 28px;
        border-radius: 8px;
        border: 1px solid var(--dt-line); */
        margin-top: 5px;
        background: var(--dt-card);
        color: var(--dt-ink);
        font-weight: 700;
        line-height: 1;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        transition: transform .12s ease, background .12s ease, border-color .12s ease;
        }
        .dt-toggle.btn-toggle:hover{
        background: var(--dt-pill);
        border-color: color-mix(in srgb, var(--dt-accent) 35%, var(--dt-line));
        }
        tr.shown .dt-toggle.btn-toggle{
        transform: rotate(0deg);
        }

        /* ===== Child row container ===== */
        .pdf-child{
        background: var(--dt-card);
        color: var(--dt-ink);
        border: 1px solid var(--dt-line);
        border-radius: 6px;
        padding: 12px;
        }
        .pdf-title{
        margin-bottom: 10px;
        color: var(--dt-ink);
        }
        .pdf-wrap{
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--dt-line);
        }

        /* ===== Child row table ===== */
        .pdf-table{
        width: 100%;
        border-collapse: collapse;
        background: var(--dt-bg);
        color: var(--dt-ink);
        }
        .pdf-table thead th{
        text-align: left;
        font-weight: 700;
        padding: 10px 12px;
        background: color-mix(in srgb, var(--dt-card) 70%, var(--dt-bg));
        border-bottom: 1px solid var(--dt-line);
        }
        .pdf-table td{
        padding: 10px 12px;
        border-bottom: 1px solid var(--dt-line);
        vertical-align: top;
        }
        .pdf-code code{
        color: #eb0c21;
        font-weight: 700;
        }
        .pdf-action{
        text-align: right;
        width: 90px;
        white-space: nowrap;
        }

        /* ===== PDF button ===== */
        .pdf-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        height: 30px;
        padding: 0 12px;
        border-radius: 10px;
        background: var(--dt-accent);
        color: var(--dt-accent-ink);
        text-decoration: none;
        font-weight: 700;
        border: 1px solid color-mix(in srgb, var(--dt-accent) 65%, #0000);
        }
        .pdf-btn:hover{
        filter: brightness(1.05);
        }

        /* จอเล็ก: ปุ่มลงมาอยู่ใน flow ปกติ */
        @media (max-width: 767px) and (max-height: 919px) {
            .buttons-panel {
                position: relative !important;
                inset: auto !important;
                width: 100%;
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
                justify-content: center;
                flex-wrap: wrap;
                gap: 6px;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-1">
            <div class="flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Product Description</p>
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

                        <div class="md:col-span-3" >
                            <label for="">ค้นหา</label>
                            <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()"/>
                        </div>
                        <div class="md:col-span-6 text-center">
                            <!-- <div class="inline-flex items-center">
                                <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                    </svg>
                                    ค้นหา
                                </a>
                            </div> -->
                            <button id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-2.5 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
                                <svg class="hidden h-4 w-4 md:inline-block rotate"viewBox="0 0 100 100" version="1.1">
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
               
        <ul class="pt-1 mt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>

        <div class="buttons-wrapper relative">
            <div class="buttons-panel absolute inset-x-0 top-4 z-20 flex items-center justify-end space-x-2">
                <button
                    class="flex items-center rounded bg-[#303030] hover:bg-[#404040] px-4 pb-[5px] pt-[6px] text-sm font-bold uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                    type="button"
                    id="dropdownMenuButton1s"
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
                        เพิ่มข้อมูลสินค้า
                </button>
                <ul style="z-index: 999999999;" class="absolute divide-y divide-gray-600 rounded-sm w-36 md:w-48 dark:divide-gray-600 float-left m-0 hidden min-w-max list-none overflow-hidden border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                    aria-labelledby="dropdownMenuButton1s"
                    data-twe-dropdown-menu-ref>
                    <li>
                        <a href="{{ route('ibhs.ibhs_create') }}" class="block w-full whitespace-nowrap bg-white px-2 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                            <svg class="mb-1 h-3 w-3 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="currentColor" viewBox="0 0 512 512"  xml:space="preserve">
                                <g>
                                    <path class="st0" d="M504.262,66.75L445.226,7.706c-10.291-10.284-26.938-10.267-37.222,0l-38.278,38.278l96.282,96.266
                                        l38.254-38.295C514.537,93.672,514.554,77.017,504.262,66.75z"/>
                                    <path class="st0" d="M32.815,382.921L0.025,512l129.055-32.83l319.398-319.431l-96.249-96.265L32.815,382.921z M93.179,404.792
                                        l-21.871-21.871l278.289-278.289l21.887,21.887L93.179,404.792z"/>
                                </g>
                            </svg>
                            <span class="ml-1">
                                เพิ่มข้อมูล
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4"> -->
            <div id="account-wrapper" class="relative">
                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                    <table id="table_product_detail" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th> <!-- สำหรับปุ่ม toggle -->
                                <!-- <th>Brand</th> -->
                                <th>Bulk code</th>
                                <!-- <th>Product</th> -->
                                <!-- <th>BOM FG</th> -->
                                <th>Product Name</th>
                                <!-- <th>Barcode (Unit)</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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

        function onOpenhandler(params) {
            document.querySelectorAll('.setpcollep').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    document.querySelectorAll('.setcheckbox').forEach(ee => {
                        ee.checked = false
                    });
                    // document.querySelectorAll('.bg_step_color').forEach(ee => {
                    //     ee.classList.remove('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                    //     ee.classList.add('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                    // });
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    // let el_colr = document.querySelectorAll('.bg_step_color')[index]
                    el.checked = !el.checked
                    if( el.checked){
                        el_colr.classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                        el_colr.classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                    }
                })
            });
            document.querySelectorAll('.setcheckbox').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    // let el_colr = document.querySelectorAll('.bg_step_color')[index]
                    console.log("🚀 ~ el.checked:", el.checked)
                    if( el.checked){
                        el_colr.classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                        el_colr.classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                    } else {
                        el_colr.classList.remove('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                        el_colr.classList.add('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                    }
                })
            });
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            // document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            // document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
        });

        if (sessionStorage.getItem("first_login") === 'Y') {
            sessionStorage.setItem("first_login", "yes")
            $("#slide").addClass("loaderslide");
        } else {
            $("#slide").remove();
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // กำหนด event เมื่อกดปุ่ม "ล้างข้อมูล"
            $('button[type="reset"]').click(function() {
                $('#brand_id').val(null).trigger('change'); // Clear ค่า select2
                $('#search').val('').trigger('keyup'); // เคลียร์ค่า input ค้นหา
            });
        });

        $('#start_product').on('change', function () {
            const selectedId = $(this).val();
            if (!selectedId) {
                $('#end_product').html('<option value="">--- กรุณาเลือก ---</option>');
                jQuery("#submitButtonDownLoadExcel").addClass('cursor-not-allowed opacity-50');
                return;
            }
            $.ajax({
                url: "{{ route('product_master.product_master_get_select2') }}",
                type: "GET",
                data: {
                    id: selectedId, 
                },
                success: function (response) {
                    $('#end_product').html('<option value="">--- กรุณาเลือก ---</option>');
                    jQuery("#submitButtonDownLoadExcel").removeClass('cursor-not-allowed opacity-50');
                    jQuery("#submitButtonDownLoadExcel").attr("disabled", false);
                    response.forEach(function (item) {
                        $('#end_product').append(`<option value="${item}">${item}</option>`);
                    });
                },
                error: function (error) {
                    console.log(error);
                    alert('เกิดข้อผิดพลาด ไม่สามารถโหลดข้อมูลได้');
                },
            });
        });

        // let fields = Array.isArray(rowFields) ? [].concat(...rowFields) : [];

        // fields.forEach(field => {}


        // ===== 0) นิยามกลุ่มฟิลด์ (แปลงจาก PHP array → JS Object) ===================
        const group_1 = {
            product: 'Product ID',
            barcode: 'Barcode',
            ref_barcode_real: 'Barcode สินค้าจริง',
            status: 'Status',
            unit_q: 'ปริมาณการบรรจุ',
            width: 'กว้าง',
            wide: 'ยาว',
            height: 'สูง',
            age: 'อายุสินค้า',
            name_thai: 'ชื่อภาษาไทย',
            name_eng: 'ชื่อภาษาอังกฤษ',
            short_thai: 'ชื่อย่อไทย',
            short_eng: 'ชื่อย่ออังกฤษ',
            item_name: 'item_name',
            price: 'Retail Price',
            cost: 'Cost',
            series: 'Series',
            category: 'Category',
            cat_name: 'cat_name',
        };

        const group_2 = {
            color_code_th: 'color_code_th',
            color_code_en: 'color_code_en',
            color_name_th: 'color_name_th',
            color_name_en: 'color_name_en',
            color_code: 'รหัสสี',
            product_line: 'product_line',
            product_type: 'product_type',
            skin_type: 'skin_type',
            finish: 'finish',
            package: 'package',
            package2: 'package2',
            usage_area: 'usage_area',
            texture: 'texture',
            coverage: 'coverage',
            after_open_m: 'ระยะเก็บรักษา(หลังเปิด)',
            launch: 'Launch',
            channel: 'channel',
            ingredients: 'ingredients',
            description_th: 'description_th',
            description_en: 'description_en',
            usage_direction_th: 'usage_direction_th',
            usage_direction_en: 'usage_direction_en',
        };

        const group_3 = {
            grp_p: 'สินค้าของบริษัท',
            supplier: 'ผู้ขาย/ผู้ผลิต',
            country: 'ผลิตประเทศ',
            suppiler_th: 'suppiler_th',
            suppiler_en: 'suppiler_en',
            fad: 'FDA',
        };

        const group_4 = {
            case_width: 'case_width',
            case_length: 'case_length',
            case_height: 'case_height',
            case_weight: 'case_weight',
            case_pack_size: 'case_pack_size',
            case_barcode: 'case_barcode',
            inner_width: 'inner_width',
            inner_length: 'inner_length',
            inner_height: 'inner_height',
            inner_pack_size: 'inner_pack_size',
            inner_weight: 'inner_weight',
            inner_barcode: 'inner_barcode',

            unit_width: 'unit_width',
            unit_length: 'unit_length',
            unit_height:  'unit_height',

            unit_weight: 'unit_weight',
            unit_pak_size: 'unit_pak_size',
            unit_barcode: 'unit_barcode',
        };

        const group_5 = {
            other_detail: 'อื่นๆ',
            sls_free: 'sls_free',
            silicone_free: 'silicone_free',
            mineral_free: 'mineral_free',
            colorant_free: 'colorant_free',
            phthalate_free: 'phthalate_free',
            cruelty_free: 'cruelty_free',
            talc_free: 'talc_free',
            oil_free: 'oil_free',
            triethanolamin_free: 'triethanolamin_free',
            petroleum_free: 'petroleum_free',
            petrolatum_free: 'petrolatum_free',
            natural_alcohol: 'natural_alcohol',
            certified_food: 'certified_food',
            certified_organic: 'certified_organic',
            hypoallergenic: 'hypoallergenic',
            tested: 'tested',
            non_comedogenic: 'non_comedogenic',
            synthetic_colorant: 'synthetic_colorant',
            synthetic_fragrance: 'synthetic_fragrance',
            ph_balance: 'ph_balance',
            chil_over_6year: 'chil_over_6year',
            fragrance_free: 'fragrance_free',
            paraben_free: 'paraben_free',
            alcohol_free: 'alcohol_free',
            pregnancy: 'pregnancy',
            breastfeed: 'breastfeed',
        };

        const group_6 = {
            solution: 'Solution',
            reg_date: 'REG_DATE',
            user_edit: 'USER_EDIT',
            edit_dt: 'EDIT_DT',
        };

        // รวมเป็นอาร์เรย์ 6 กลุ่ม (ลำดับ = subgroup 1..6)
        const allFieldGroups = [group_1, group_2, group_3, group_4, group_5, group_6];

        // title ของแต่ละกลุ่ม
        const groupTitles = {
            1: 'Group 1: Product Identification',
            2: 'Group 2: Usage & Application',
            3: 'Group 3: Manufacturer Information',
            4: 'Group 4: Physical Attributes',
            5: 'Group 5: Composition & Ingredients',
            6: 'Group 6: Update',
        };

        /* ===== helper แปลง fields → [{key,label,allowed}] ===== */
        function toFieldArray(fieldsObjOrArr) {
            if (!Array.isArray(fieldsObjOrArr) && typeof fieldsObjOrArr === 'object') {
                return Object.entries(fieldsObjOrArr).map(([key, label]) => {
                    const allowed = key !== 'cost'; // ฟิลด์ `cost` จะถูกตั้งค่าเป็น false
                    console.log(`Field: ${key}, Allowed: ${allowed}`); // เพิ่ม log สำหรับ allowed
                    return { key, label: String(label ?? key), allowed };
                });
            }

            const arr = Array.isArray(fieldsObjOrArr) ? fieldsObjOrArr : [];
            if (arr.length && typeof arr[0] === 'string') {
                return arr.map(k => ({ key: k, label: k, allowed: true }));
            }

            return arr.map(f => {
                const allowed = f?.allowed !== false;
                console.log(`Field: ${f?.key}, Allowed: ${allowed}`); // เพิ่ม log สำหรับ allowed
                return {
                    key: f?.key ?? '',
                    label: f?.label ?? (f?.key ?? ''),
                    allowed
                };
            });
        }

        const userId = @json(Auth::user()->id);

        function renderFieldCheckbox(rowId, subgroup, field, label, allowed=true, idx=0, selectedSet=null){ 
            const id = `fld_${rowId}_${subgroup}_${idx}_${field}`;
            const isSelected = selectedSet?.has(String(field)) ?? false;

            // ตรวจสอบข้อมูลก่อนแสดงฟิลด์
            console.log('Field:', field, 'Allowed:', allowed, 'Selected:', selectedSet, 'IsSelected:', isSelected);

            // กำหนดกลุ่มที่สามารถเห็น 'cost'
            const canCostUsers = [
                32, 95, 86, 87, 26, 85, 100, 99,
                102, 103, 104, 105, 136, 106, 138,
                120, 179, 125, 139, 140, 141, 142,
                143, 144, 145, 148, 121
            ];

            // ตรวจสอบว่า 'cost' อยู่ใน selected และผู้ใช้มีสิทธิ์แสดง
            if (field === 'cost') {
                // ถ้าผู้ใช้ไม่มีสิทธิ์ (ไม่อยู่ใน $canCostUsers) ไม่แสดง 'cost' เลย
                if (!canCostUsers.includes(userId)) {
                    console.log(`Cost field: ${field} - Not allowed for user ${userId}, not displaying.`);
                    return ''; // ไม่แสดง checkbox หรือข้อความใด ๆ
                }

                // ถ้าผู้ใช้มีสิทธิ์ให้แสดง checkbox สำหรับ 'cost'
                console.log(`Cost field: ${field} - Allowed for user ${userId}, displaying checkbox.`);
                return `
                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                            class="form-check-input export-field h-4 w-4"
                            id="${id}" name="export_fields[]"
                            value="${field}"
                            data-group="${rowId}" data-subgroup="${subgroup}"
                            ${isSelected ? 'checked':''}
                        >
                        <label class="form-check-label" for="${id}">
                            ${label}
                        </label>
                    </div>
                `;
            }

            // สำหรับฟิลด์อื่น ๆ ถ้ามีสิทธิ์ ก็แสดง checkbox
            if (allowed) {
                console.log(`Field: ${field} - Allowed, displaying checkbox.`);
                return `
                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                            class="form-check-input export-field h-4 w-4"
                            id="${id}" name="export_fields[]"
                            value="${field}"
                            data-group="${rowId}" data-subgroup="${subgroup}"
                            ${isSelected ? 'checked':''}
                        >
                        <label class="form-check-label" for="${id}">
                            ${label}
                        </label>
                    </div>
                `;
            }

            // ถ้าผู้ใช้ไม่มีสิทธิ์ให้แสดงข้อความ '(ไม่มีสิทธิ์)' และไม่แสดง checkbox
            console.log(`Field: ${field} - Not allowed, showing as (ไม่มีสิทธิ์).`);
            return `
                <div class="flex items-center gap-2 text-gray-400">
                    <label class="form-check-label" for="${id}">
                        ${label} (ไม่มีสิทธิ์)
                    </label>
                </div>
            `;
        }

        /* ===== render child row (ตั้งค่า position_id + HTML) ===== */
        function formatCheckboxRow(row){
            // เซ็ต hidden position_id แบบเดิม
            const posId = String(row?.position_id ?? row?.id ?? '');
            if (!posId) return `<div class="px-4 py-2 text-sm text-red-400">ไม่พบ position_id/id</div>`;
            let hid = document.getElementById('position_id_hidden');
            if (!hid) {
                const form = document.getElementById('exportForm') || document.body;
                hid = document.createElement('input');
                hid.type = 'hidden'; hid.id = 'position_id_hidden'; hid.name = 'position_id';
                form.appendChild(hid);
            }
            hid.value = posId;

            // <<<< ค่าที่เลือกมาจากหลังบ้าน (สองรูปแบบ รองรับทั้งคู่)
            const selectedByGroup = row.selectedByGroup || {};                 // {1:['PRODUCT',...], 2:[...]}
            const selectedFlat    = new Set((row.selected || []).map(String)); // ['PRODUCT','barcode',...]

            let html = '';
            // Header: All + Groups (ตามที่คุณใช้เดิม)
            html += `
                <div class="w-100 mb-2 border-bottom pb-2">
                <div class="grid grid-cols-4">
                    <div class="form-check m-0 ml-1">
                    <input type="checkbox" class="form-check-input export-field-toggle-all"
                            id="chk_toggle_all_${posId}" data-group="${posId}">
                    <label class="form-check-label m-0" for="chk_toggle_all_${posId}">All</label>
                    </div>
                    ${[1,2,3,4,5,6].map(n => `
                    <div class="grid grid-cols-4 ml-4">
                        <input type="checkbox" class="form-check-input export-field-toggle-group"
                            id="chk_toggle_group_${n}_${posId}" data-group="${posId}" data-subgroup="${n}">
                        <label class="form-check-label m-0" for="chk_toggle_group_${n}_${posId}">${groupTitles[n]}</label>
                    </div>
                    `).join('')}
                </div>
                </div>
            `;

            // Fields per group (grid 4 คอลัมน์) — ที่สำคัญ: **ส่ง selectedSet เข้าไป**
            allFieldGroups.forEach((fields, groupIndex) => {
                const subgroup   = groupIndex + 1;
                const fieldArray = toFieldArray(fields);
                if (!fieldArray.length) return;

                // เลือกชุด selected ของกลุ่มนี้
                const selectedSet = selectedByGroup[subgroup]
                ? new Set(selectedByGroup[subgroup].map(String))
                : selectedFlat; // ถ้าไม่ได้ส่งแบบแยกกลุ่มมา จะใช้ flat แทน

                html += `<div class="mb-1 fw-bold">${groupTitles[subgroup] || ''}</div>`;
                html += `<div class="grid grid-cols-4 ml-4">`;
                fieldArray.forEach((f, i) => {
                const key = f.key || '';
                const label = f.label || key;
                const allowed = f.allowed !== false;
                html += renderFieldCheckbox(posId, subgroup, key, label, allowed, i, selectedSet); // <<<< ส่ง selectedSet
                });
                html += `</div>`;
            });

            // sync ให้หัวข้อ Group/All ตรงกับช่องย่อยหลัง DOM แปะแล้ว
            setTimeout(() => syncHeader(posId), 0);

            return html;
        }

        /* ===== เปิด/ปิด child row ===== */
        $('#account_schedule tbody').on('click', 'td.dt-control', function () {
            const tr = $(this).closest('tr');
            const row = manageMytableDatatable.row(tr);
            if (row.child.isShown()) {
                row.child.hide(); tr.removeClass('shown');
            } else {
                const html = formatCheckboxRow(row.data());
                row.child(html).show(); tr.addClass('shown');
            }
        });

        /* ===== Events: All/Group/Field + sync header ===== */
        $(document).on('change', '.export-field-toggle-all', function(){
            const group = $(this).data('group');
            const checked = this.checked;
            $(`input.export-field[data-group="${group}"]:not(:disabled)`).prop('checked', checked);
            $(`.export-field-toggle-group[data-group="${group}"]`).prop('checked', checked);
        });

        $(document).on('change', '.export-field-toggle-group', function(){
            const group = $(this).data('group');
            const subgroup = $(this).data('subgroup');
            const checked = this.checked;
            $(`input.export-field[data-group="${group}"][data-subgroup="${subgroup}"]:not(:disabled)`).prop('checked', checked);
            updateAllState(group);
        });

        $(document).on('change', 'input.export-field', function(){
            const group = $(this).data('group');
            const subgroup = $(this).data('subgroup');
            const t = $(`input.export-field[data-group="${group}"][data-subgroup="${subgroup}"]:not(:disabled)`).length;
            const c = $(`input.export-field[data-group="${group}"][data-subgroup="${subgroup}"]:checked:not(:disabled)`).length;
            $(`#chk_toggle_group_${subgroup}_${group}`).prop('checked', t>0 && c===t);
            updateAllState(group);
        });

        function updateAllState(group){
            const t = $(`input.export-field[data-group="${group}"]:not(:disabled)`).length;
            const c = $(`input.export-field[data-group="${group}"]:checked:not(:disabled)`).length;
            $(`#chk_toggle_all_${group}`).prop('checked', t>0 && c===t);
        }

        function syncHeader(rowId){
            [1,2,3,4,5,6].forEach(sg => {
                const t = $(`input.export-field[data-group="${rowId}"][data-subgroup="${sg}"]:not(:disabled)`).length;
                const c = $(`input.export-field[data-group="${rowId}"][data-subgroup="${sg}"]:checked:not(:disabled)`).length;
                $(`#chk_toggle_group_${sg}_${rowId}`).prop('checked', t>0 && c===t);
            });
            updateAllState(rowId);
        }

        // function getPositionId(row){
        //     // ลองหลายแหล่ง + log ว่าติดคีย์ไหน
        //     const sources = [
        //         {key:'position_id',   val: row?.position_id},
        //         {key:'id',            val: row?.id},
        //         {key:'PositionID',    val: row?.PositionID},
        //         {key:'positionId',    val: row?.positionId},
        //         // กรณีข้อมูลซ่อนใน nested object (ที่บาง lib ชอบทำ)
        //         {key:'meta.position_id', val: row?.meta?.position_id},
        //         {key:'data.position_id', val: row?.data?.position_id},
        //         {key:'original.position_id', val: row?.original?.position_id},
        //     ];

        //     console.log('🔎 [getPositionId] row data =', row);
        //     console.table(sources.map(s => ({ key: s.key, value: s.val })));

        //     const found = sources.find(s => s.val != null && s.val !== '');
        //     if (found) {
        //         console.log(`✅ [getPositionId] use "${found.key}" =`, found.val);
        //         return found.val;
        //     }

        //     console.warn('⚠️ [getPositionId] NOT FOUND in known keys. row =', row);
        //     return null;
        // }

        const dlayMessage = 500;

        function updateProductDetailManageExportExcel() {
            const position_id = document.getElementById('position_id_hidden').value;

            if (!position_id) {
                console.error("ไม่พบ position_id");
                return;
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                method: "POST",
                url: "{{ route('product_detail.pd_detail_manage_export_excel_update', '') }}/" + position_id,
                data: $("#manageExportExcel").serialize(),
                beforeSend: function () {
                    $('#loaderManageExportExcel').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success("อัปเดทราคาสำเร็จ!");
                        // ✅ รีโหลด DataTable
                        manageMytableDatatable.ajax.reload(null, false); // false = stay on current page
                        setTimeout(function() {
                            $('#loaderManageExportExcel').addClass('hidden');
                        },dlayMessage)
                    } else {
                        setTimeout(function() {
                            $('#loaderManageExportExcel').addClass('hidden');
                        },dlayMessage)
                        toastr.error("Can't Set Permission!");
                    }
                    return false;
                },
                error: function (params) {
                    setTimeout(function() {
                        errorMessage("Can't Set Permission!");
                    },dlayMessage)
                    setTimeout(function() {
                        toastr.error("Can't Set Permission!");
                    },dlayMessage)
                }
            });
        }

        const manageMytableDatatable = $('#account_schedule').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            // scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            // scroller: true,
            // scrollY: "515px",
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('product_detail.list_product_detail_manage_export_excel') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [
                {
                    targets: 0,
                    // className: 'dt-control bg-[#E9ECEF] dark:bg-[#ffffff]',
                    className: 'dt-control text-center align-middle',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        let text = row.name_position || '';
                        return text.length > 50 ? text.substring(0, 50) + '...' : text;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.brand;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return (row.username || '').replace(/,/g, ', ');
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.total_users;
                    }
                },
            ]
        });

        const currentUserId = {{ Auth::user()->id }};

        // ====== 1) Cache สำหรับผล pdf-codes (กันยิงซ้ำ) ======
        const pdfCache = {}; // { productId: {ok, count, codes[]} }

        async function fetchPdfCodes(productId) {
            productId = (productId ?? '').toString().trim();
            if (!productId) return { ok: false, count: 0, codes: [] };

            if (pdfCache[productId]) return pdfCache[productId];

            // ✅ route ต้องมี {product_id} => ใส่ placeholder แล้ว replace ทีหลัง
            const url = `{{ route('product_detail.pd_detail_pdf_codes', ['product_id' => '__PID__']) }}`
            .replace('__PID__', encodeURIComponent(productId));

            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();

            pdfCache[productId] = json;
            return json;
        }

        // ====== 2) Child row renderer (รับเฉพาะ variants ที่กรองมาแล้ว) ======
        const PD_SHOW_BASE = @json(route('product_detail.pd_detail_show', ['product_id' => '__PID__']));
        function renderPdfChild(codes, productId) {
            const base = PD_SHOW_BASE.replace('__PID__', encodeURIComponent(productId));
            const rows = (codes || []).map(c => {
                const url = `${base}?code=${encodeURIComponent(c.code)}`;
                return `
                    <tr>
                        <td class="pdf-code inline-flex min-w-[150px] items-center justify-start gap-1 whitespace-nowrap rounded-full border border-[#dc3545]/30 bg-black/15 px-1 py-0 font-semibold"><code>${(c.c_code ?? '-')}(${c.code})</code></td>
                        <td class="pdf-name">${c.name ?? ''}</td>
                        <td class="pdf-action">
                            <a href="${url}"  type="button" class="bclose">
                                <svg class="size-7 cursor-pointer" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 309.267 309.267" xml:space="preserve">
                                    <g>
                                        <path style="fill:#E2574C;" d="M38.658,0h164.23l87.049,86.711v203.227c0,10.679-8.659,19.329-19.329,19.329H38.658
                                            c-10.67,0-19.329-8.65-19.329-19.329V19.329C19.329,8.65,27.989,0,38.658,0z"/>
                                        <path style="fill:#B53629;" d="M289.658,86.981h-67.372c-10.67,0-19.329-8.659-19.329-19.329V0.193L289.658,86.981z"/>
                                        <path style="fill:#FFFFFF;" d="M217.434,146.544c3.238,0,4.823-2.822,4.823-5.557c0-2.832-1.653-5.567-4.823-5.567h-18.44
                                            c-3.605,0-5.615,2.986-5.615,6.282v45.317c0,4.04,2.3,6.282,5.412,6.282c3.093,0,5.403-2.242,5.403-6.282v-12.438h11.153
                                            c3.46,0,5.19-2.832,5.19-5.644c0-2.754-1.73-5.49-5.19-5.49h-11.153v-16.903C204.194,146.544,217.434,146.544,217.434,146.544z
                                            M155.107,135.42h-13.492c-3.663,0-6.263,2.513-6.263,6.243v45.395c0,4.629,3.74,6.079,6.417,6.079h14.159
                                            c16.758,0,27.824-11.027,27.824-28.047C183.743,147.095,173.325,135.42,155.107,135.42z M155.755,181.946h-8.225v-35.334h7.413
                                            c11.221,0,16.101,7.529,16.101,17.918C171.044,174.253,166.25,181.946,155.755,181.946z M106.33,135.42H92.964
                                            c-3.779,0-5.886,2.493-5.886,6.282v45.317c0,4.04,2.416,6.282,5.663,6.282s5.663-2.242,5.663-6.282v-13.231h8.379
                                            c10.341,0,18.875-7.326,18.875-19.107C125.659,143.152,117.425,135.42,106.33,135.42z M106.108,163.158h-7.703v-17.097h7.703
                                            c4.755,0,7.78,3.711,7.78,8.553C113.878,159.447,110.863,163.158,106.108,163.158z"/>
                                    </g>
                                </svg>
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');

            return `
                <div class="pdf-child">
                <div class="pdf-title"><b>PDF มากกว่า 1 ชุด</b></div>
                <div class="pdf-wrap">
                    <table class="pdf-table">
                    <thead><tr><th>Code</th><th>Name</th><th></th></tr></thead>
                    <tbody>${rows}</tbody>
                    </table>
                </div>
                </div>
            `;
        }


        const mytableDatatable = $('#table_product_detail').DataTable({
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

                "url": "{{ route('ibhs.list_ibsh') }}",
                "type": "POST",
                'data': function(data) {
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            // JOB_REFNO
            orderable: true,
            columnDefs: [
                // (0) Toggle column
                {
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    className: 'pdf-control text-center',
                    render: function() {
                        return `<span class="toggle-holder"></span>`; // ว่างไว้ก่อน
                    }
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function(data, type, row) {
                        const val = row.bulk_id ?? '-';
                        return `<span class="inline-flex min-w-[150px] items-center justify-start gap-1 whitespace-nowrap rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">${val}</span>`;
                    }
                },
                // {
                //     targets: 3,
                //     orderable: true,
                //     render: function (data, type, row) {
                //         const pid = (row.product_id ?? '').toString();        // กัน null/number
                //         const job = (row.JOB_REFNO == null) ? '-' : row.JOB_REFNO; // null/undefined => '-'

                //         if (pid.length === 5) {
                //             return `
                //                 <span class="inline-flex min-w-[120px] items-center justify-start gap-1 whitespace-nowrap
                //                 rounded-full border border-[#dc3545]/30 bg-black/15
                //                 px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">
                //                     ${pid}
                //                 </span>
                //             `;
                //         }
                //         if (pid.length > 5) {
                //             return `
                //                 <span class="inline-flex min-w-[120px] items-center justify-start gap-1 whitespace-nowrap
                //                 rounded-full border border-[#dc3545]/30 bg-black/15
                //                 px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">
                //                     ${pid}
                //                 </span>
                //             `;
                //         }
                //         return `${pid}`;
                //     }
                // },
                // {
                //     targets: 4,
                //     orderable: false,
                //     data: null,
                //     defaultContent: '',
                //     className: 'bom-fg-cell',
                //     render: function() { return '<span class="text-gray-400 text-xs">...</span>'; }
                // },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.product_name;
                    }
                },
                // {
                //     targets: 4,
                //     orderable: true,
                //     render: function(data, type, row) {
                //         return row.BARCODE;
                //     }
                // },
                {
                    targets: 3,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if ( currentUserId === 149 || currentUserId === 150 || currentUserId === 151 || currentUserId === 152 || currentUserId === 153 || currentUserId === 154 || currentUserId === 155) {
                            return ``; // ⛔ ❌ ซ่อนปุ่ม
                        } else {
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('ibhs.ibhs_edit', 0)}}"
                                            type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                            </svg>
                                            Edit
                                        </a>

                                        <a href="{{route('ibhs.ibhs_show',0)}}" type="button" class="bclose">
                                            <svg class="size-7 cursor-pointer" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 309.267 309.267" xml:space="preserve">
                                                <g>
                                                    <path style="fill:#E2574C;" d="M38.658,0h164.23l87.049,86.711v203.227c0,10.679-8.659,19.329-19.329,19.329H38.658
                                                        c-10.67,0-19.329-8.65-19.329-19.329V19.329C19.329,8.65,27.989,0,38.658,0z"/>
                                                    <path style="fill:#B53629;" d="M289.658,86.981h-67.372c-10.67,0-19.329-8.659-19.329-19.329V0.193L289.658,86.981z"/>
                                                    <path style="fill:#FFFFFF;" d="M217.434,146.544c3.238,0,4.823-2.822,4.823-5.557c0-2.832-1.653-5.567-4.823-5.567h-18.44
                                                        c-3.605,0-5.615,2.986-5.615,6.282v45.317c0,4.04,2.3,6.282,5.412,6.282c3.093,0,5.403-2.242,5.403-6.282v-12.438h11.153
                                                        c3.46,0,5.19-2.832,5.19-5.644c0-2.754-1.73-5.49-5.19-5.49h-11.153v-16.903C204.194,146.544,217.434,146.544,217.434,146.544z
                                                        M155.107,135.42h-13.492c-3.663,0-6.263,2.513-6.263,6.243v45.395c0,4.629,3.74,6.079,6.417,6.079h14.159
                                                        c16.758,0,27.824-11.027,27.824-28.047C183.743,147.095,173.325,135.42,155.107,135.42z M155.755,181.946h-8.225v-35.334h7.413
                                                        c11.221,0,16.101,7.529,16.101,17.918C171.044,174.253,166.25,181.946,155.755,181.946z M106.33,135.42H92.964
                                                        c-3.779,0-5.886,2.493-5.886,6.282v45.317c0,4.04,2.416,6.282,5.663,6.282s5.663-2.242,5.663-6.282v-13.231h8.379
                                                        c10.341,0,18.875-7.326,18.875-19.107C125.659,143.152,117.425,135.42,106.33,135.42z M106.108,163.158h-7.703v-17.097h7.703
                                                        c4.755,0,7.78,3.711,7.78,8.553C113.878,159.447,110.863,163.158,106.108,163.158z"/>
                                                </g>
                                            </svg>
                                        </a>
                                `.replaceAll('/0', "/" + row.id);
                        }

                    }
                }
            ]
        });


        // ====== 4) หลัง draw: ตรวจว่ามี variants (-1,-2,...) ไหม แล้วค่อยโชว์ปุ่ม ======
        // mytableDatatable.on('draw', async function () {
        //     const nodes = mytableDatatable.rows({ page: 'current' }).nodes().toArray();

        //     for (const tr of nodes) {
        //     const row = mytableDatatable.row(tr);
        //     const productId = (row.data().product_id ?? '').toString().trim();
        //     if (!productId) continue;

        //     const holder = $(tr).find('td.dt-control .toggle-holder');
        //     if (!holder.length) continue;

        //     // กันเช็คซ้ำ
        //     if (holder.data('checked') === true) continue;
        //     holder.data('checked', true);

        //     try {
        //         const json = await fetchPdfCodes(productId);
        //         if (!json || json.ok !== true) { holder.html(''); continue; }

        //         // ✅ เอาเฉพาะ code ที่มี -ตัวเลขท้าย เช่น 9-CP75422-1
        //         const variants = (json.codes || []).filter(x => /-\d+$/.test(x.code));

        //         // ✅ ถ้ามี variant อย่างน้อย 1 => มี PDF มากกว่า 1 ชุด
        //         if (variants.length > 0) {
        //         holder.html(`<button type="button" class="btn btn-sm btn-outline-light btn-toggle">▶</button>`);
        //         } else {
        //         holder.html('');
        //         }
        //     } catch (e) {
        //         holder.html('');
        //     }
        //     }
        // });

        mytableDatatable.on('draw', function () {
            const promises = [];
            const badge = (val) => `<span class="inline-flex min-w-[120px] items-center justify-start gap-1 whitespace-nowrap rounded-full border border-[#dc3545]/30 bg-[#dc3545]/15 px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">${val}</span>`;
            const badgeDash = badge('-');

            mytableDatatable.rows({ page: 'current' }).every(function () {
                const tr = this.node();
                const rowData = this.data();

                if (!rowData) return;

                const productId = (rowData.product_id ?? '').toString().trim();
                if (!productId) return;

                const holder = $(tr).find('td.pdf-control .toggle-holder');
                if (!holder.length) return;

                if (holder.data('checked') === true) return;
                holder.data('checked', true);

                const p = fetchPdfCodes(productId)
                .then(json => {
                    if (!json || json.ok !== true) {
                        holder.html('');
                        $(tr).find('td.bulk-code-cell').html(badgeDash);
                        $(tr).find('td.bom-fg-cell').html(badgeDash);
                        return;
                    }

                    const variants = (json.codes || []).filter(x => /-\d+$/.test(x.code));
                    holder.html(variants.length > 0
                    ? `<button type="button" class="dt-toggle btn-toggle">▶</button>`
                    : ''
                    );

                    const base = (json.codes || []).find(x => !/-\d+$/.test(x.code));
                    $(tr).find('td.bulk-code-cell').html(badge(base ? (base.c_code ?? '-') : '-'));
                    $(tr).find('td.bom-fg-cell').html(badge(base ? (base.code ?? '-') : '-'));
                })
                .catch(() => {
                    holder.html('');
                    $(tr).find('td.bulk-code-cell').html(badgeDash);
                    $(tr).find('td.bom-fg-cell').html(badgeDash);
                });
                promises.push(p);
            });

            // หลังโหลดข้อมูลครบทุกแถว ปรับ header ให้ตรงกับ body
            Promise.all(promises).then(() => {
                mytableDatatable.columns.adjust();
            });
        });

        // ====== 5) Click toggle: โหลดแล้วแสดงเฉพาะ variants ======
        $('#table_product_detail tbody').on('click', 'td.pdf-control button.btn-toggle', async function () {
            const tr = $(this).closest('tr');

            // ✅ กันกรณี click ใน child row / แถวที่ไม่ใช่แถวหลัก
            if (tr.hasClass('child')) return;

            const row = mytableDatatable.row(tr);
            const rowData = row.data();

            // ✅ กัน rowData undefined
            if (!rowData) return;

            const productId = (rowData.product_id ?? '').toString().trim();
            if (!productId) return;

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).text('▶');
                return;
            }

            $(this).text('▼');
            row.child(`<div class="p-2">Loading PDF list...</div>`).show();
            tr.addClass('shown');

            try {
                const json = await fetchPdfCodes(productId);
                if (!json || json.ok !== true) throw new Error(json?.message || 'โหลดไม่สำเร็จ');

                const variants = (json.codes || []).filter(x => /-\d+$/.test(x.code));

                if (variants.length === 0) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).text('▶');
                return;
                }

                row.child(renderPdfChild(variants, productId)).show();
            } catch (e) {
                row.child(`<div class="p-2 text-danger">โหลดรายการ PDF ไม่ได้: ${e.message}</div>`).show();
            }
        });


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