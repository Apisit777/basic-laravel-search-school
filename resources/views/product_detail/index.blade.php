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
            padding: 0.55rem !important;
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

    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">PRODUCT DETAIL1</p>
        </div>
        <div class="grid mt-2 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
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
                            <svg class="hidden h-5 w-5 md:inline-block rotate"viewBox="0 0 100 100" version="1.1">
                                <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 93,62 C 83,82 65,96 48,96 32,96 19,89 15,79 L 5,90 5,53 40,53 29,63 c 0,0 5,14 26,14 16,0 38,-15 38,-15 z"/>
                                <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 5,38 C 11,18 32,4 49,4 65,4 78,11 85,21 L 95,10 95,47 57,47 68,37 C 68,37 63,23 42,23 26,23 5,38 5,38 z"/>
                            </svg>
                            @lang('global.content.clear')
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ตัวอย่าง: ใช้ Bootstrap icon -->
        <!-- <svg fill="currentColor" class="size-6 bi bi-lightning animate-shake text-yellow-400 dark:text-yellow-200" viewBox="0 0 16 16">
            <path d="M11.3 1L6 8h3l-1 7 5.3-7H10l1.3-7z"/>
        </svg>
        <svg fill="currentColor" class="size-10 bi bi-airplane-engines animate-shake text-black dark:text-white" viewBox="0 0 16 16">
            <path d="M8 0c-.787 0-1.292.592-1.572 1.151A4.35 4.35 0 0 0 6 3v3.691l-2 1V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.191l-1.17.585A1.5 1.5 0 0 0 0 10.618V12a.5.5 0 0 0 .582.493l1.631-.272.313.937a.5.5 0 0 0 .948 0l.405-1.214 2.21-.369.375 2.253-1.318 1.318A.5.5 0 0 0 5.5 16h5a.5.5 0 0 0 .354-.854l-1.318-1.318.375-2.253 2.21.369.405 1.214a.5.5 0 0 0 .948 0l.313-.937 1.63.272A.5.5 0 0 0 16 12v-1.382a1.5 1.5 0 0 0-.83-1.342L14 8.691V7.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v.191l-2-1V3c0-.568-.14-1.271-.428-1.849C9.292.591 8.787 0 8 0M7 3c0-.432.11-.979.322-1.401C7.542 1.159 7.787 1 8 1s.458.158.678.599C8.889 2.02 9 2.569 9 3v4a.5.5 0 0 0 .276.447l5.448 2.724a.5.5 0 0 1 .276.447v.792l-5.418-.903a.5.5 0 0 0-.575.41l-.5 3a.5.5 0 0 0 .14.437l.646.646H6.707l.647-.646a.5.5 0 0 0 .14-.436l-.5-3a.5.5 0 0 0-.576-.411L1 11.41v-.792a.5.5 0 0 1 .276-.447l5.448-2.724A.5.5 0 0 0 7 7z"/>
        </svg> -->

        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>

        <!-- <svg class="w-6 h-6 text-black dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg> -->
        
        <!-- <div class="fixed flex bottom-5 right-5 z-10">
            <a href="{{ route('product_detail.pd_detail_create') }}" class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div> -->

        <!-- Modal -->
        <!-- <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="manageExampleModalExcel"
            tabindex="-1"
            aria-labelledby="exampleModalXlLabel"
            aria-modal="true"
            role="dialog"
        > -->

        <!--Extra large modal-->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="manageExampleModalExcel"
            tabindex="-1"
            aria-labelledby="exampleModalXlLabel"
            aria-modal="true"
            role="dialog"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px] min-[1200px]:max-w-[1140px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <!-- Modal title -->
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalXlLabel">
                            ตั้งค่าผู้ใช้งาน
                        </h5>
                        <!-- Close button -->
                        <button
                            type="button"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form id="manageExportExcel" class="" method="POST">
                        <input type="hidden" name="position_id" id="position_id_hidden" value="">
                        <div class="grid grid-cols-5 gap-10">
                            <div class="form col-span-5">
                                <div class="relative w-full overflow-hidden">
                                    <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                        <h1 class="text-gray-900 dark:text-white text-lg">
                                            ตั้งค่าผู้ใช้งาน
                                        </h1>
                                    </div>
                                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full pd-5">
                                        <div id="" class="text-gray-900 dark:text-gray-100 px-4 py-2 overflow-x-auto min-w-fit">
                                            <table id="account_schedule" class="table nowrap w-full table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th> <!-- สำหรับปุ่ม toggle -->
                                                        <th>ชื่อตำแหน่ง</th>
                                                        <th>Brand</th>
                                                        <th>รหัสพนักงาน</th>
                                                        <th>Total User</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="updateProductDetailManageExportExcel()">
                                <svg fill="currentColor" class="bi bi-floppy-fill size-4 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 16 16">
                                    <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                                    <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                                </svg>
                                Save
                            </a>
                        </div>
                    </form>
                    <div id="loaderManageExportExcel" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
           
        <div class="flex xs:right-1 sm:right-1 md:right-1 lg:right-1 xl:right-1 z-10 absolute mt-3">  
            <a
                type="button"
                data-twe-toggle="modal"
                data-twe-target="#manageExampleModalExcel"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                class="xs:mt-0 sm:mt-0 md:mt-0 lg:mt-0 xl:mt-0 mr-48 px-1.5 py-1 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer btn-rotate" name="" id=""
            >

                <svg fill="currentColor" class="rotate hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-30 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 16 16">
                    <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
                </svg>
                Manage Excel
            </a>
        </div>

        <!-- ================================================================================================================================================================================================================================ -->

        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalExcel"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                            รหัสที่ต้องการ
                        </h5>
                        <button
                            type="button"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <form id="" action="{{ route('product_detail.export_excel_product_detail') }}" method="POST">
                        @csrf
                        <div class="p-8 lg:col-span-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-3" >
                                    <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">รหัสเริ่มต้น</label>
                                    <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="start_product" name="start_product">
                                        <option class="" value=""> --- กรุณาเลือก ---</option>
                                        @foreach ($getSelect2ProDevelops as $product)
                                            <option value="{{ $product }}">{{ $product }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="NUMBER" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">รหัสสิ้นสุด</span></label>
                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="end_product" name="end_product">
                                        <option value=""> --- กรุณาเลือก ---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <button data-twe-modal-dismiss id="submitButtonDownLoadExcel" type="submit" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" disabled>
                                <svg fill="currentColor" class="bi bi-cloud-arrow-down-fill hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 16 16">
                                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                                </svg>
                                Download
                            </button>
                        </div>
                    </form>
                    <div id="loader_create_menu" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                    <!-- <div id="loader_create_menu" class="loading_create_menu absolute bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto"> -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
                    
        <div class="flex xs:right-1 sm:right-1 md:right-1 lg:right-1 xl:right-1 z-10 absolute mt-3">  
            <a
                type="button"
                data-twe-toggle="modal"
                data-twe-target="#exampleModalExcel"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                class="xs:mt-0 sm:mt-0 md:mt-0 lg:mt-0 xl:mt-0 mr-10 px-1.5 py-1 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="" id=""
            >
                <svg fill="currentColor" class="bi bi-file-earmark-excel-fill hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-30 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64"/>
                </svg>
                    Export Excel
            </a>
        </div>

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="table_product_detail" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Product</th>
                            <th>Product Name</th>
                            <th>Barcode (Unit)</th>
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
            case_barcode: 'case_barcode',
            case_weight: 'case_weight',
            case_pack_size: 'case_pack_size',
            inner_width: 'inner_width',
            inner_length: 'inner_length',
            inner_height: 'inner_height',
            inner_pack_size: 'inner_pack_size',
            inner_weight: 'inner_weight',
            unit_barcode: 'unit_barcode',
            unit_weight: 'unit_weight',
            unit_pak_size: 'unit_pak_size',
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

                "url": "{{ route('product_detail.list_product_detail') }}",
                "type": "POST",
                'data': function(data) {
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.corporation_id;
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
                        return row.NAME_THAI;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BARCODE;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if ( currentUserId === 149 || currentUserId === 150 || currentUserId === 151 || currentUserId === 152 || currentUserId === 153 || currentUserId === 154 || currentUserId === 155) {
                            return ``; // ⛔ ❌ ซ่อนปุ่ม
                        } else {
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('product_detail.pd_detail_edit', 0)}}"
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
                }
            ]
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