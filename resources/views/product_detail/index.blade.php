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
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
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
                    <!-- <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                        <button data-twe-modal-dismiss id="submitButtonDownLoadExcel" type="submit" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" disabled>
                            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cloud-arrow-down-fill hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                            </svg>
                            Download
                        </button>
                    </div> -->
                </div>
            </div>
        </div>


            <!-- <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalXlLabel">
                            จัดการผู้ใช้งาน
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
                        <div class="grid grid-cols-5 gap-10">
                            <div class="form col-span-5">
                                <div class="relative w-full overflow-hidden">
                                    <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                        <h1 class="text-gray-900 dark:text-white text-lg">
                                            ตั้งราคาบัญชี
                                        </h1>
                                    </div>
                                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                        <div id="" class="text-gray-900 dark:text-gray-100">
                                            <table id="account_schedule" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่เริ่มใช้</th>
                                                        <th>สถานะดำเนินการ</th>
                                                        <th>ราคาบัญชีใหม่</th>
                                                        <th>ต้นทุน</th>
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
                            <button data-twe-modal-dismiss id="submitButtonDownLoadExcel" type="submit" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" disabled>
                                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cloud-arrow-down-fill hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                                </svg>
                                Download
                            </button>
                        </div>
                    </form>
                    <div id="loader_create_menu" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div> -->
           
        @if (Auth::user()->id === 32 || Auth::user()->id === 95 || Auth::user()->id === 87 || Auth::user()->id === 26)
            <div class="flex xs:right-1 sm:right-1 md:right-1 lg:right-1 xl:right-1 z-10 absolute mt-3">  
                <a
                    type="button"
                    data-twe-toggle="modal"
                    data-twe-target="#manageExampleModalExcel"
                    data-twe-ripple-init
                    data-twe-ripple-color="light"
                    class="xs:mt-0 sm:mt-0 md:mt-0 lg:mt-0 xl:mt-0 mr-48 px-1.5 py-1 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer btn-rotate" name="" id=""
                >
            
                <!-- <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/><path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                    <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                    <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                </svg> -->

                <svg class="rotate hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 502 502" xml:space="preserve">
                        <g>
                            <g>
                                <path style="fill:#50A5DC;" d="M492,276.648v-51.295c0-13.06-10.587-23.648-23.648-23.648h-43.924
                                    c-3.841-13.538-9.234-26.421-15.958-38.46l31.079-31.079c9.235-9.235,9.235-24.208,0-33.443l-36.271-36.271
                                    c-9.235-9.235-24.208-9.235-33.443,0l-31.08,31.078c-12.039-6.724-24.922-12.117-38.46-15.958V33.648
                                    c0-13.06-10.587-23.648-23.648-23.648h-51.295c-13.06,0-23.648,10.587-23.648,23.648v43.924
                                    c-13.538,3.841-26.421,9.234-38.46,15.958l-31.079-31.079c-9.235-9.235-24.208-9.235-33.443,0l-36.27,36.272
                                    c-9.235,9.235-9.235,24.208,0,33.443l31.079,31.079c-6.724,12.039-12.117,24.922-15.958,38.46H33.649
                                    c-13.06,0-23.648,10.587-23.648,23.648v51.295c0,13.06,10.587,23.648,23.648,23.648h43.924
                                    c3.841,13.538,9.234,26.421,15.958,38.46l-31.079,31.079c-9.235,9.235-9.235,24.208,0,33.443l36.271,36.271
                                    c9.235,9.235,24.208,9.235,33.443,0l31.079-31.079c12.039,6.724,24.922,12.117,38.46,15.958v43.924
                                    c0,13.06,10.587,23.648,23.648,23.648h51.295c13.06,0,23.648-10.587,23.648-23.648v-43.924
                                    c13.538-3.841,26.421-9.234,38.46-15.958l31.079,31.079c9.235,9.235,24.208,9.235,33.443,0l36.271-36.271
                                    c9.235-9.235,9.235-24.208,0-33.443l-31.079-31.079c6.724-12.039,12.117-24.922,15.958-38.46h43.924
                                    C481.414,300.295,492,289.708,492,276.648z M251.001,344.612c-51.7,0-93.612-41.911-93.612-93.612s41.912-93.612,93.612-93.612
                                    S344.612,199.3,344.612,251S302.701,344.612,251.001,344.612z"/>
                                <path d="M276.648,502h-51.295c-18.554,0-33.648-15.094-33.648-33.648v-36.527c-9.116-2.992-18.026-6.689-26.623-11.049
                                    l-25.844,25.844c-13.119,13.119-34.467,13.119-47.586,0l-36.271-36.272c-13.118-13.119-13.118-34.465,0-47.585l25.845-25.845
                                    c-4.359-8.596-8.058-17.506-11.049-26.623H33.648c-18.553,0-33.647-15.094-33.647-33.647v-51.296
                                    c0-18.553,15.094-33.647,33.647-33.647h36.528c2.991-9.117,6.689-18.027,11.049-26.623l-25.844-25.845
                                    c-13.118-13.12-13.118-34.466,0-47.585L91.652,55.38c13.119-13.118,34.467-13.118,47.586,0l25.844,25.844
                                    c8.597-4.36,17.507-8.058,26.623-11.049V33.648C191.704,15.094,206.799,0,225.354,0h51.295c18.554,0,33.648,15.094,33.648,33.648
                                    v36.527c9.116,2.992,18.026,6.689,26.623,11.049l25.844-25.844c13.119-13.119,34.467-13.119,47.586,0l36.271,36.271
                                    c13.118,13.119,13.118,34.465,0,47.585l-25.845,25.845c4.359,8.596,8.058,17.506,11.049,26.623h36.528
                                    c18.554,0,33.647,15.094,33.647,33.647v51.296c0,18.553-15.094,33.647-33.647,33.647h-36.528
                                    c-2.991,9.117-6.689,18.027-11.049,26.623l25.845,25.844c13.118,13.12,13.118,34.466,0,47.585l-36.271,36.272
                                    c-13.119,13.118-34.467,13.118-47.586,0l-25.844-25.844c-8.597,4.36-17.507,8.058-26.623,11.049v36.527
                                    C310.297,486.906,295.201,502,276.648,502z M163.247,398.469c1.666,0,3.344,0.416,4.873,1.27
                                    c11.511,6.429,23.729,11.499,36.313,15.068c4.303,1.221,7.271,5.149,7.271,9.621v43.924c0,7.525,6.123,13.648,13.648,13.648
                                    h51.295c7.525,0,13.648-6.123,13.648-13.648v-43.924c0-4.472,2.969-8.4,7.271-9.621c12.584-3.57,24.802-8.639,36.313-15.068
                                    c3.904-2.18,8.784-1.504,11.947,1.66l31.078,31.079c5.32,5.32,13.98,5.322,19.301,0l36.271-36.271
                                    c5.321-5.321,5.321-13.979,0-19.301l-31.079-31.078c-3.163-3.163-3.841-8.042-1.659-11.947
                                    c6.428-11.51,11.498-23.728,15.068-36.313c1.221-4.302,5.148-7.271,9.62-7.271h43.925c7.525,0,13.647-6.122,13.647-13.647v-51.296
                                    c0-7.525-6.122-13.647-13.647-13.647h-43.925c-4.472,0-8.399-2.969-9.62-7.271c-3.57-12.585-8.641-24.803-15.068-36.313
                                    c-2.182-3.905-1.504-8.784,1.659-11.947l31.079-31.079c5.321-5.321,5.321-13.979,0-19.301l-36.271-36.271
                                    c-5.32-5.32-13.98-5.322-19.301,0l-31.078,31.078c-3.162,3.164-8.04,3.84-11.947,1.66c-11.511-6.429-23.729-11.499-36.313-15.068
                                    c-4.303-1.221-7.271-5.149-7.271-9.621V33.648c0-7.525-6.123-13.648-13.648-13.648h-51.295c-7.525,0-13.648,6.123-13.648,13.648
                                    v43.924c0,4.472-2.969,8.4-7.271,9.621c-12.584,3.57-24.802,8.639-36.313,15.068c-3.904,2.181-8.784,1.503-11.947-1.66
                                    l-31.078-31.079c-5.32-5.32-13.98-5.322-19.301,0l-36.271,36.271c-5.321,5.321-5.321,13.979,0,19.301l31.079,31.078
                                    c3.163,3.163,3.841,8.042,1.659,11.947c-6.428,11.51-11.498,23.728-15.068,36.313c-1.221,4.302-5.148,7.271-9.62,7.271H33.648
                                    c-7.525,0-13.647,6.122-13.647,13.647v51.296c0,7.525,6.122,13.647,13.647,13.647h43.925c4.472,0,8.399,2.969,9.62,7.271
                                    c3.57,12.585,8.641,24.803,15.068,36.313c2.182,3.905,1.504,8.784-1.659,11.947l-31.079,31.079
                                    c-5.321,5.321-5.321,13.979,0,19.301l36.271,36.271c5.32,5.32,13.98,5.322,19.301,0l31.078-31.078
                                    C158.099,399.474,160.659,398.469,163.247,398.469z M251.001,354.611c-57.132,0-103.611-46.48-103.611-103.611
                                    s46.479-103.611,103.611-103.611S354.612,193.869,354.612,251S308.133,354.611,251.001,354.611z M251.001,167.389
                                    c-46.104,0-83.611,37.508-83.611,83.611s37.508,83.611,83.611,83.611s83.611-37.508,83.611-83.611
                                    S297.104,167.389,251.001,167.389z"/>
                            </g>
                            <g>
                                <path d="M121.001,261c-5.522,0-10-4.477-10-10c0-27.143,7.779-53.472,22.498-76.142c14.331-22.074,34.479-39.62,58.267-50.743
                                    c5.002-2.341,10.954-0.18,13.294,4.823c2.34,5.003,0.18,10.955-4.823,13.294c-42.059,19.667-69.236,62.361-69.236,108.768
                                    C131.001,256.523,126.523,261,121.001,261z"/>
                            </g>
                            <g>
                                <path d="M302.995,141.819c-1.337,0-2.695-0.27-3.999-0.839c-15.157-6.622-31.306-9.98-47.995-9.98c-5.522,0-10-4.477-10-10
                                    s4.478-10,10-10c19.463,0,38.305,3.92,56.003,11.653c5.061,2.211,7.371,8.106,5.16,13.167
                                    C310.521,139.578,306.849,141.819,302.995,141.819z"/>
                            </g>
                        </g>
                    </svg>
                    Manage Excel
                </a>
            </div>
        @endif

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
                                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cloud-arrow-down-fill hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                                </svg>
                                Download
                            </button>
                        </div>
                    </form>
                    <div id="loader_create_menu" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
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
            <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/><path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
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

        // ประกาศแบบนี้เพื่อให้แน่ใจว่าอยู่ใน global scope
        function formatCheckboxRow(row) {
            // ✅ เซ็ต position_id ตรงนี้
            document.getElementById('position_id_hidden').value = row.id;
            const positionIdInput = document.getElementById('position_id_hidden');
            const allFieldGroups = row.exportableFields ?? [];

            if (!Array.isArray(allFieldGroups) || allFieldGroups.length === 0) {
                return `<div class="px-4 py-2 text-sm text-gray-400">ไม่มีฟิลด์ให้แสดง</div>`;
            }

            let html = `<div class="px-4 py-2">`;

            // ✅ แทรก checkbox All ด้านบน
            html += `
                <div class="mb-2 flex items-center space-x-2">
                    <input type="checkbox" class="form-check-input export-field-toggle-all ml-0" id="chk_toggle_all_${row.id}">&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="form-check-label font-semibold text-sm ml-3 mt-1" for="chk_toggle_all_${row.id}">All(สามารถเห็น Colum อะไรได้บ้าง)</label>
                </div>
            `;

            allFieldGroups.forEach((fields, groupIndex) => {
                const fieldArray = Array.isArray(fields) ? fields : Object.values(fields);
                if (fieldArray.length === 0) return;

                html += `<div class="grid grid-cols-4 gap-4 mb-2">`;

                fieldArray.forEach((field, i) => {
                    const key = field?.key ?? '';
                    const label = field?.label ?? key;
                    const allowed = field?.allowed === true;
                    const disabled = allowed ? '' : 'disabled';
                    const labelClass = allowed ? '' : 'text-gray-400';
                    const title = allowed ? '' : '(ไม่มีสิทธิ์)';

                    html += `
                        <div class="form-check flex items-center space-x-2">

                            <input type="checkbox" class="form-check-input export-field"
                                name="export_fields[]"
                                value="${key}"
                                data-group="${row.id}"
                                id="chk_${row.id}_${groupIndex}_${i}"
                                ${allowed ? 'checked' : ''}
                                ${!allowed ? `data-has-permission="false" title='ไม่มีสิทธิ์'` : ''}
                            >

                            <label class="form-check-label ${labelClass}" for="chk_${row.id}_${groupIndex}_${i}">
                                ${label} ${title}
                            </label>
                        </div>
                    `;
                });

                html += `</div>`;
            });

            html += `</div>`;
            return html;
        }

        // let fields = Array.isArray(rowFields) ? [].concat(...rowFields) : [];

        // fields.forEach(field => {}

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
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "515px",
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

        // ✅ คลิก toggle child row
        $('#account_schedule tbody').on('click', 'td.dt-control', function () {
            const tr = $(this).closest('tr');
            const row = manageMytableDatatable.row(tr);

            // ✅ LOG ดูว่า row มีข้อมูลอะไรบ้าง
            console.log('== 🔍 CLICKED ROW DATA ==');
            console.log(row.data());

            // ✅ ตรวจว่ามี child เปิดอยู่แล้วหรือไม่
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // ✅ ใช้ฟังก์ชันคุณ formatCheckboxRow()
                const html = formatCheckboxRow(row.data());
                // console.log('== ✅ HTML From formatCheckboxRow ==');
                // console.log(html);

                row.child(html).show();
                tr.addClass('shown');
            }
        });

        $(document).on('change', '.export-field-toggle-all', function () {
            const checked = $(this).is(':checked');
            const rowId = this.id.replace('chk_toggle_all_', '');
            $(`input.export-field[data-group="${rowId}"]:not(:disabled)`).prop('checked', checked);
        });

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