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


        /* .dock-icon {
            width: 64px;
            cursor: pointer;
        }

        .window {
            position: fixed;
            top: 90%;
            left: 50%;
            width: 300px;
            height: 200px;
            background: #fff;
            border-radius: 20px;
            transform: translate(-50%, -50%) scale(0.1);
            clip-path: ellipse(50% 50% at 50% 50%);
            opacity: 0;
            transition: all 0.5s ease-in-out;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
            z-index: 999;
        }

        .window.show {
            top: 50%;
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            clip-path: ellipse(100% 100% at 50% 50%);
        } */



        .dock-icon {
            width: 64px;
            cursor: pointer;
        }

        .zoom-preview {
            position: fixed;
            top: 90%;
            left: 90%;
            width: 420px;
            height: 320px;
            background: #fff;
            border-radius: 20px;
            transform: translate(0%, 0%) scale(0.1);
            clip-path: ellipse(50% 50% at 50% 50%);
            opacity: 0;
            transition: 
                transform 0.8s cubic-bezier(0.25, 1, 0.5, 1),
                opacity 0.6s ease,
                top 0.8s ease,
                left 0.8s ease,
                clip-path 0.8s ease;
            transition-delay: 0.05s; /* เพิ่มดีเลย์ตอนเริ่ม */
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
            z-index: 999;
            pointer-events: none;
        }

        .zoom-preview.show {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            clip-path: ellipse(100% 100% at 50% 50%);
            transition-delay: 0s; /* ไม่มีดีเลย์ตอนโชว์ */
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

        /* กล่องโหลด */
        .loader{
            position: relative;
            margin: auto;
            width: 350px;          /* 7 ช่อง ช่องละ 50 */
            height: 100px;
            color: #fff;
            /* font-family: "Lucida Console", "Courier New", monospace; */
            font-size: 250%;
            background: linear-gradient(180deg, #222 0, #444 100%);
            box-shadow: inset 0 5px 20px #000;
            text-shadow: 5px 5px 5px rgba(0,0,0,.3);
            display: flex;         /* ใช้ flex จัดกึ่งกลาง */
        }

        /* ช่องตัวอักษร 7 ช่อง */
        .loader > i{
            flex: 0 0 calc(350px / 7);  /* = 50px */
            height: 100%;
            display: flex;
            align-items: center;        /* แนวตั้งกึ่งกลาง */
            justify-content: center;    /* แนวนอนกึ่งกลาง */
            font-style: normal;         /* ปิด italic */
            border-left: 1px solid #444;
            border-right: 1px solid #222;
            padding-top: 10%;
        }

        /* แผ่นปิดที่เลื่อนขึ้น */
        .loader .covers{
            position: absolute;
            inset: 0;                   /* top/right/bottom/left: 0 */
            display: flex;
        }

        .loader .covers > i{
            flex: 0 0 calc(350px / 7);
            height: 100%;
            background: linear-gradient(180deg, #fff 0, #ddd 100%);
            animation: up 2s infinite;
        }

        /* timing แต่ละแผ่น */
        .loader .covers > i:nth-child(2){ animation-delay:.142857s; }
        .loader .covers > i:nth-child(3){ animation-delay:.285714s; }
        .loader .covers > i:nth-child(4){ animation-delay:.428571s; }
        .loader .covers > i:nth-child(5){ animation-delay:.571428s; }
        .loader .covers > i:nth-child(6){ animation-delay:.714285s; }
        .loader .covers > i:nth-child(7){ animation-delay:.857142s; }

        @keyframes up{
            0%   { margin-bottom:0; }
            16%  { margin-bottom:100%; height:20px; }
            50%  { margin-bottom:0; }
            100% { margin-bottom:0; }
        }

    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-2 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-base font-bold text-gray-900 dark:text-gray-100">List Dimension</p>
        </div>
        <div class="grid gap-4 gap-y-2 text-xs text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-xs grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="BRAND" class="text-xs font-medium text-gray-900 dark:text-white">Brand</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($brands as $key => $brand)
                                <option value={{ $brand }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-xs font-medium text-gray-900 dark:text-white">Brand</label>
                        <div class="md:col-span-3" >
                            <select name="country"></select>
                        </div>
                    </div> -->

                    <div class="md:col-span-3" >
                        <label for="" class="font-medium">@lang('global.content.search')</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
                    </div>
                    <div class="md:col-span-6 text-center text-xs">
                        <div class="inline-flex items-center">
                            <!-- <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                ค้นหา
                            </a> -->
                            <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-2.5 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
                                <svg class="hidden h-4 w-4 md:inline-block rotate"
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

        <!-- <img class="dock-icon" src="https://via.placeholder.com/64" onclick="showWindow()" />

        <div class="window" id="popup">
        <h2 style="text-align:center;margin-top:30px;">เปิดแล้ว!</h2>
        </div> -->

        <div id="zoomPreview" class="zoom-preview">
            <img src="" id="zoomImage" style="width:100%; height:100%; object-fit:cover; border-radius:20px;" />
        </div>

        <ul class="pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>
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

        {{-- <a href="#" id="fetchDataBtn" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
            </svg>
            Fetch School Balance Data
        </a>

        <div id="responseData" class="mt-5 text-gray-900 dark:text-white"></div> --}}

        <!-- <div class="justify-center items-center">
            <form class="max-w-sm mx-auto">
                <label for="countries" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Select Position</label>
                <select class="js-example-basic-single w-full rounded-sm text-xs" id="filter-select" name="">
                    <option value="" class="text-sm"> --- กรุณาเลือก ---</option>
                    @foreach ($roles as $key => $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </form>
        </div> -->

        <!-- <div class="flex right-10 z-10 absolute">
            <div class="view-toggle">
                <button id="btn-list" class="toggle-btn active">
                    📋 ตาราง
                </button>
                <button id="btn-grid" class="toggle-btn">
                    ☰ รายการ
                </button>
                
            </div>
        </div>

        <div id="grid-view" class="view-section" style="display:none;">
            <div class="container mx-auto py-8">
                <div id="cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
            </div>
    
            <div id="pagination-controls" class="mt-8 flex flex-wrap justify-center space-x-2">
                <svg id="prev-btn" fill="currentColor" class="size-9 mt-0.5 ml-0.5 text-[#303030] dark:text-[#EAEAEA] cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m4.431 12.822 13 9A1 1 0 0 0 19 21V3a1 1 0 0 0-1.569-.823l-13 9a1.003 1.003 0 0 0 0 1.645z"/>
                </svg>
                <div id="pagination-numbers" class="flex flex-wrap justify-center space-x-2"></div>
                <svg id="next-btn" fill="currentColor" class="size-10 mb-1 ml-0.5 text-[#303030] dark:text-[#EAEAEA] cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.536 21.886a1.004 1.004 0 0 0 1.033-.064l13-9a1 1 0 0 0 0-1.644l-13-9A1 1 0 0 0 5 3v18a1 1 0 0 0 .536.886z"/>
                </svg>
            </div>
        </div> -->

        <!-- <div class="loader">
  <i>L</i>
  <i>O</i>
  <i>A</i>
  <i>D</i>
  <i>I</i>
  <i>N</i>
  <i>G</i>
  
  <div class="covers">
    <i></i>
    <i></i>
    <i></i>
    <i></i>
    <i></i>
    <i></i>
    <i></i>
  </div>
</div> -->

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

    function showZoomPreview(url) {
    const zoomBox = document.getElementById('zoomPreview');
    const zoomImage = document.getElementById('zoomImage');
    zoomImage.src = url;
    zoomBox.classList.add('show');
}

function hideZoomPreview() {
    const zoomBox = document.getElementById('zoomPreview');
    zoomBox.classList.remove('show');
}

        // $(document).ready(function () {
        //     $('#fetchDataBtn').click(function () {
        //         fetch('https://ins.schicher.com/api/users', {
        //             method: 'GET',  // Or 'POST' if the API requires it
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //         })
        //         .then(response => response.json()) // Assuming the API returns JSON
        //         .then(data => {
        //             $('#responseData').html(`<p>Response from API:</p><pre>${JSON.stringify(data, null, 2)}</pre>`);
        //         })
        //         .catch(error => console.error('Error:', error));
        //     });
        // });

        // $(document).ready(function () {
        //     let currentPage = 1;
        //     const cardsPerPage = 8;
        //     let allData = [];

        //     function fetchData() {
        //         fetch('https://ins.schicher.com/api/users', {
        //             method: "GET",
        //             headers: {
        //                 'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
        //                 'X-RapidAPI-Host': 'ott-details.p.rapidapi.com'
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             allData = data;
        //             renderCards(currentPage);
        //             renderPagination();
                    
        //         })
        //         .catch(error => console.error('Error:', error));
        //     }

        //     function renderCards(page) {
        //         console.log("🚀 ~ fetchData ~ allData:", allData)
        //         $('#cards-container').empty();
        //         const start = (page - 1) * cardsPerPage;
        //         const end = start + cardsPerPage;
        //         const pageData = allData.slice(start, end);

        //         pageData.forEach(item => {
        //             const card = `
        //                 <div class="max-w-sm p-1 bg-[#eaeaea] dark:bg-[#292929] cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">
        //                     <img src="${item.imageurl}/300x150" alt="${item.title || 'Unknown'}" class="w-full h-32 object-cover">
        //                     <div class="p-4">
        //                         <h2 class="text-lg font-semibold mb-1 text-gray-900 dark:text-gray-100">${item.name || 'Unknown School'}</h2>
        //                         <p class="text-sm text-gray-400 dark:text-gray-400 uppercase">${item.role || 'N/A'}</p>
        //                     </div>
        //                     <div class="px-4 pb-4 flex items-center space-x-4 text-gray-500 dark:text-gray-300 base:text-xl sm:text-sm">
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>CORS</span>
        //                         </div>
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>HTTPS</span>
        //                         </div>
        //                     </div>
        //                 </div>
        //             `;
        //             $('#cards-container').append(card);
        //         });

        //         updatePaginationControls();
        //     }

        //     function renderPagination() {
        //         $('#pagination-numbers').empty();
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         const maxVisiblePages = 5; // You can adjust this value

        //         function addPageButton(page, isActive = false) {
        //             const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
        //             $('#pagination-numbers').append(pageButton);
        //         }

        //         if (totalPages <= maxVisiblePages) {
        //             // If total pages are less than max visible pages, show all
        //             for (let i = 1; i <= totalPages; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }
        //         } else {
        //             // Show first page
        //             addPageButton(1, currentPage === 1);

        //             // Show an ellipsis if currentPage is far from the first page
        //             if (currentPage > 3) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show pages around the current page
        //             let startPage = Math.max(2, currentPage - 1);
        //             let endPage = Math.min(currentPage + 1, totalPages - 1);

        //             for (let i = startPage; i <= endPage; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }

        //             // Show an ellipsis if currentPage is far from the last page
        //             if (currentPage < totalPages - 2) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show last page
        //             addPageButton(totalPages, currentPage === totalPages);
        //         }

        //         // Add event listeners to page buttons
        //         $('#pagination-numbers button').click(function () {
        //             const page = $(this).data('page');
        //             currentPage = page;
        //             renderCards(currentPage);
        //             renderPagination();
        //         });
        //     }

        //     function updatePaginationControls() {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         $('#prev-btn').prop('disabled', currentPage === 1);
        //         $('#next-btn').prop('disabled', currentPage === totalPages);
        //     }

        //     $('#prev-btn').click(function () {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     $('#next-btn').click(function () {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         if (currentPage < totalPages) {
        //             currentPage++;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     fetchData();
        // });

        // Start ตัวที่ใช้งาน API Test filter-cards(Code อยู่ที่ public/conn.php(Route ต้องเปิด comment(Route::get('/filter-cards')))
        // $(document).ready(function () {
        //     let currentPage = 1;
        //     const cardsPerPage = 8;
        //     let allData = [];
        //     const cardContainer = $('#cards-container');

        //     // Fetch data and initialize cards
        //     function fetchData(type = '') {
        //         const apiUrl = type
        //             ? '{{ route('warehouse.filter.cards') }}' // Backend API with filter
        //             : 'https://ins.schicher.com/api/users'; // Default API

        //         const requestOptions = type
        //             ? {
        //                 method: 'GET',
        //                 data: { type },
        //             }
        //             : {
        //                 method: 'GET',
        //                 headers: {
        //                     'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
        //                     'X-RapidAPI-Host': 'ott-details.p.rapidapi.com',
        //                 },
        //             };

        //         $.ajax(apiUrl, requestOptions)
        //             .done((data) => {
        //                 // console.log("🚀 ~ fetchData ~ requestOptions:", requestOptions)
        //                 allData = data;
        //                 renderCards(currentPage);
        //                 renderPagination();
        //             })
        //             .fail(() => alert('Error fetching data'));
        //     }

        //     // Render cards for the current page
        //     function renderCards(page) {
        //         // console.log("🚀 Rendering cards with data:", allData);
        //         // cardContainer.empty();
        //         $('#cards-container').empty();
        //         const start = (page - 1) * cardsPerPage;
        //         const end = start + cardsPerPage;
        //         const pageData = allData.slice(start, end);

        //         pageData.forEach((item) => {
        //             // console.log("Item:", item); // Debugging to see item structure
        //             const name = item.name || 'Unknown Name';
        //             const role = item.role || 'Unknown Role';
        //             const imageUrl = item.imageurl || item.image || 'default-image-url.jpg'; // Replace with a fallback image if needed
        //             // ตัดชื่อไม่ให้เกิน 30 ตัวอักษร + ...
        //             const truncatedName = name.length > 30 ? name.substring(0, 29) + '…' : name;
        //             const card = `
        //                 <div class="max-w-sm p-1 bg-[#eaeaea] dark:bg-[#292929] object-cover rounded-sm shadow-md border-gray-300 cursor-pointer transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-md hover:shadow-gray-400 dark:hover:shadow-md dark:hover:shadow-gray-400">
        //                     <img src="${imageUrl}" alt="${name}" class="w-full h-32 object-cover">
        //                     <div class="p-4">
        //                         <h2 class="text-lg font-semibold mb-1 text-gray-900 dark:text-gray-100">${truncatedName}</h2>
        //                         <p class="text-sm text-gray-400 dark:text-gray-400 uppercase">${role}</p>
        //                     </div>
        //                     <div class="px-4 pb-4 flex items-center space-x-4 text-gray-500 dark:text-gray-300 base:text-xl sm:text-sm">
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>CORS</span>
        //                         </div>
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>HTTPS</span>
        //                         </div>
        //                     </div>
        //                 </div>
        //             `;
        //             cardContainer.append(card);
        //         });

        //         updatePaginationControls();
        //     }

        //     // Render pagination
        //     function renderPagination() {
        //         $('#pagination-numbers').empty();
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         const maxVisiblePages = 5; // You can adjust this value

        //         function addPageButton(page, isActive = false) {
        //             const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
        //             $('#pagination-numbers').append(pageButton);
        //         }

        //         if (totalPages <= maxVisiblePages) {
        //             // If total pages are less than max visible pages, show all
        //             for (let i = 1; i <= totalPages; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }
        //         } else {
        //             // Show first page
        //             addPageButton(1, currentPage === 1);

        //             // Show an ellipsis if currentPage is far from the first page
        //             if (currentPage > 3) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show pages around the current page
        //             let startPage = Math.max(2, currentPage - 1);
        //             let endPage = Math.min(currentPage + 1, totalPages - 1);

        //             for (let i = startPage; i <= endPage; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }

        //             // Show an ellipsis if currentPage is far from the last page
        //             if (currentPage < totalPages - 2) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show last page
        //             addPageButton(totalPages, currentPage === totalPages);
        //         }

        //         // Add event listeners to page buttons
        //         $('#pagination-numbers button').click(function () {
        //             const page = $(this).data('page');
        //             currentPage = page;
        //             renderCards(currentPage);
        //             renderPagination();
        //         });
        //     }

        //     // Update pagination controls
        //     function updatePaginationControls() {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         $('#prev-btn').prop('disabled', currentPage === 1);
        //         $('#next-btn').prop('disabled', currentPage === totalPages);
        //     }

        //     // Pagination navigation buttons
        //     $('#prev-btn').click(function () {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     $('#next-btn').click(function () {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         if (currentPage < totalPages) {
        //             currentPage++;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     // Filter cards by type
        //     $('#filter-select').on('change', function () {
        //         const type = $(this).val();
        //         fetchData(type);
        //     });

        //     // Initial fetch
        //     fetchData();
        // });
        // // End ตัวที่ใช้งาน

        // $(function() {
        //     $('#btn-list').click(function() {
        //         $('#grid-view').hide();
        //         $('#list-view').show();
        //         $('.toggle-btn').removeClass('active');
        //         $(this).addClass('active');
        //     });

        //     $('#btn-grid').click(function() {
        //         $('#list-view').hide();
        //         $('#grid-view').show();
        //         $('.toggle-btn').removeClass('active');
        //         $(this).addClass('active');
        //     });
        // });

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

        function showCustomLoading() {
            const $tbody = $('#table_dimension tbody');

            // ความสูงของโซนตารางที่เลื่อน (ให้โหลดอยู่กึ่งกลางแนวตั้งพอดี)
            const h = $('#table_dimension')
                .closest('.dataTables_wrapper')
                .find('.dataTables_scrollBody')
                .height() || 560; // fallback เผื่อยังไม่ถูกสร้าง

            $tbody.html(`
                <tr>
                    <td colspan="7" class="p-0">
                        <div class="flex items-center justify-center w-full" style="height:${h}px;">
                            <div class="loader font-serif font-semibold">
                                <i>L</i>
                                <i>O</i>
                                <i>A</i>
                                <i>D</i>
                                <i>I</i>
                                <i>N</i>
                                <i>G</i>
                                <div class="covers">
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                    <i></i>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            `);
        }

        const mytableDatatable = $('#table_dimension').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "580px",
            order: [[1, "desc"]],
            lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            pageLength: 20,

            ajax: function (dtParams, callback) {
                // 👉 เรียก custom loading row
                showCustomLoading();
                $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('warehouse.list_warehouse') }}",
                type: "POST",
                // ⬇️ รวมพารามิเตอร์ของ DataTables (draw/start/length/search…)
                data: $.extend({}, dtParams, {
                    brand_id: $('#brand_id').val(),
                    search:   $('#search').val()
                }),
                success: function (json) {
                    // หน่วง 2 วินาที (เอาออกได้ถ้าไม่อยากดีเลย์)
                    setTimeout(() => callback(json), 1000);
                },
                error: function () {
                    // ป้องกันค้าง
                    callback({ draw: dtParams.draw || 0, recordsTotal: 0, recordsFiltered: 0, data: [] });
                }
                });
            },

            columnDefs: [
                {
                    targets: 0,
                    render: (_, __, row) => row.company_id ?? ''
                },
                {
                    targets: 1,
                    render: (_, __, row) => row.product_id ?? ''
                },
                {
                    targets: 2,
                    render: (_, __, row) => row.barcode ?? ''
                },
                {
                    targets: 3,
                    render: (_, __, row) => row.vendor_id ?? ''
                },
                {
                    targets: 4,
                    render: (_, __, row) => row.name_thai ?? ''
                },
                {
                targets: 5,
                    className: 'text-center',
                    render: (_, __, row) => {
                        const img = (row.img_url && row.img_url.trim() !== '')
                        ? row.img_url
                        : "https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg";
                        return `
                        <div class="flex justify-center items-center">
                            <img src="${img}"
                                class="w-20 h-16 object-cover rounded-sm shadow-md border border-gray-300 cursor-pointer"
                                alt="Product Image"
                                onmouseenter="showZoomPreview('${img}')"
                                onmouseleave="hideZoomPreview()" />
                        </div>
                        `;
                    }
                },
                {
                targets: 6,
                    className: 'text-center',
                    render: (_, __, row) => {
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

        // Loading ============================================================================= Custom =================================================================

        // function showCustomLoading() {
        //     const $tbody = $('#table_dimension tbody');

        //     const h = $('#table_dimension')
        //         .closest('.dataTables_wrapper')
        //         .find('.dataTables_scrollBody')
        //         .height() || 560;

        //     $tbody.html(`
        //         <tr>
        //         <td colspan="7" class="p-0">
        //             <div class="flex items-center justify-center w-full gap-3" style="height:${h}px;">
        //                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
        //                     <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
        //                     <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
        //                 </svg>
        //                 <span class="text-gray-700 dark:text-gray-200">กำลังโหลดข้อมูล...</span>
        //             </div>
        //         </td>
        //         </tr>
        //     `);
        // }


        // function showCustomLoading() {
        //     const $tbody = $('#table_dimension tbody');

        //     const h = $('#table_dimension')
        //         .closest('.dataTables_wrapper')
        //         .find('.dataTables_scrollBody')
        //         .height() || 560;

        //     $tbody.html(`
        //         <tr>
        //             <td colspan="7" class="p-0">
        //                 <div class="flex items-center justify-center w-full" style="height:${h}px;">
        //                     <div class="loader">
        //                         <i>L</i>
        //                         <i>O</i>
        //                         <i>A</i>
        //                         <i>D</i>
        //                         <i>I</i>
        //                         <i>N</i>
        //                         <i>G</i>
        //                         <div class="covers">
        //                             <i></i>
        //                             <i></i>
        //                             <i></i>
        //                             <i></i>
        //                             <i></i>
        //                             <i></i>
        //                             <i></i>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </td>
        //         </tr>
        //     `);
        // }
    </script>
@endsection
