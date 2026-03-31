@extends('layouts.layout')
@section('title', '')
@section('content')
    <style>
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
        .table-responsive{-sm|-md|-lg|-xl|-xxl}
        element.style {
            top: 192px;
            left: 758.5px;
            z-index: 10;
            display: block;
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
        .btn-rotate:hover .rotate{
            transform: rotate(180deg);
            transition: 0.5s all;
        }
        .rotate{
            transition: 0.5s all;
        }
        span.dt-column-order {
            display: none;
        }
        .dt-length  {
            color: #818181!important;
        }
        .table td, .table th {
            padding: 0.20rem !important;
        }
        div.dt-container div.dt-length select {
            width: auto;
            display: inline-block;
            margin-right: 0.5em;
            height: 36px !important;
        }
        /* .mt-2, .my-2 {
            margin-top: 0rem !important;
        } */

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
        
        /* สไตล์ปุ่ม (แล้วแต่ของเดิม) */
        .toggle-btn {
            background: #404040;
            color: #fff;
            border-radius: 4px;
            transition: 0.2s;
        }
        .toggle-btn:hover { background: #3b3b3b; }
        .toggle-btn.active { background: #05395D; }

        /* ✅ เงื่อนไข: จอเล็ก (กว้าง < 768px และสูง < 919px) */
        @media (max-width: 767px) and (max-height: 919px) {
            .buttons-panel {
                position: relative !important;  /* จาก absolute → มาอยู่ใน flow ปกติ */
                inset: auto !important;
                width: 100%;
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;

                justify-content: center;
                flex-wrap: wrap;
                gap: 6px;
            }
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 99999;
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
        
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    
    @php
        $accountStatus = [
            1 => 'สินค้าใหม่',
            2 => 'รอดำเนินการ',
            3 => 'ตั้งราคาแล้ว',
        ];
    @endphp

    <div class="justify-center items-center">
        <div class="mt-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-1">
            <div class="flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_account_list')</p>
            </div>
            <div class="grid gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                <div class="lg:col-span-4 xl:grid-cols-4">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        <div class="md:col-span-2">
                            <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand Product</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                                <option value=""> --- กรุณาเลือก ---</option>
                                @foreach ($brands as $key => $brand)
                                    <option value={{ $brand }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">สถานะตั้งราคา</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="statusSearch" name="statusSearch" onchange="brandSearch()">
                                <option value=""> --- กรุณาเลือก ---</option>
                                 @foreach ($accountStatus as $key => $label)
                                    <option value="{{ $key }}">
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2" >
                            <label for="">Search</label>
                            <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า ..." value="" onkeyup="searchTable()"/>
                        </div>
                        <div class="md:col-span-6 text-center">
                            <!-- <div class="inline-flex items-center">
                                <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                    </svg>
                                    Search
                                </a>
                            </div> -->
                            <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
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

        <!-- <ul class="pt-1 mt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul> -->

        <!-- <div class="flex xs:right-12 sm:right-12 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-3">   
            <a
                type="button"
                data-twe-toggle="modal"
                data-twe-target="#exampleModal"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="" id=""
            >
            <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/><path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
            </svg>
                Export Excel
            </a>
        </div> -->

        <!-- <div class="fixed flex bottom-5 right-5 z-10">
            <a href="{{ route('account.create') }}" class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div> -->
        
        <!-- <div class="flex right-48 m-3 z-10 absolute">
            <div class="view-toggle flex items-center space-x-2">
                <button id="btn-grid" class="toggle-btn flex items-center space-x-1 px-3 py-1">
                    <span class="text-sm">รายการทั้งหมด</span>
                </button>

            </div>
        </div>
        <div class="flex right-48 m-3 z-10 absolute">
            <div class="view-toggle flex items-center space-x-2">
                <button id="btn-grid" class="toggle-btn flex items-center space-x-1 px-3 py-1">
                    <span class="text-sm">ตั้งราคาแล้ว</span>
                </button>

            </div>
        </div>
        <div class="flex right-48 m-3 z-10 absolute">
            <div class="view-toggle flex items-center space-x-2">
                <button id="btn-grid" class="toggle-btn flex items-center space-x-1 px-3 py-1">
                    <span class="text-sm">รอดำเนินาร</span>
                </button>

            </div>
        </div>

        <div class="flex right-2 m-3 z-10 absolute">
            <div class="view-toggle flex items-center space-x-2">
                <button id="btn-list" class="toggle-btn active">
                    📋 ตาราง
                </button>
                <button id="btn-grid" class="toggle-btn flex items-center space-x-1 px-3 py-1">
                    <span class="text-sm">☰ รายการแจ้งเตือน</span>
                    <span id="account-badge-top"
                        class="absolute -top-3 -right-1 inline-flex items-center justify-center 
                            rounded-full bg-red-600 text-white text-[10px] 
                            min-w-[18px] h-[18px] px-1 shadow-md">
                    </span>
                </button>
            </div>
        </div> -->

        <ul class="pt-1 mt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>
        
        <div class="buttons-wrapper relative">
            <div class="buttons-panel absolute inset-x-0 top-4 z-20 flex items-center justify-between space-x-2">
                <!-- ซ้าย: 3 ปุ่ม filter -->
                <div class="flex items-center space-x-2">
                    <!-- <button class="toggle-btn px-3 py-1">รายการทั้งหมด</button> -->
                </div>

                <!-- ขวา: ปุ่มสลับ table (ต้องอยู่คู่กัน) -->
                <div class="flex items-center space-x-2">

                    <a
                        onclick="fetchAllProducts()"
                        type="button"
                        data-twe-toggle="modal"
                        data-twe-target="#exampleModalExcel"
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        class="xs:mt-0 sm:mt-0 md:mt-0 lg:mt-0 xl:mt-0 px-1.5 py-1 text-sm font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="" id=""
                    >
                        <svg fill="currentColor" class="-mt-1 bi bi-file-earmark-excel-fill hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-30 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64"/>
                        </svg>
                            Export Excel
                    </a>

                    <button id="btn-list"
                            class="toggle-btn active px-3 py-1 text-sm">
                        📋 ตาราง
                    </button>
                    <!-- <button class="toggle-btn px-3 py-1 text-sm">📌 สินค้าใหม่</button>
                    <button class="toggle-btn px-3 py-1 text-sm">✅ ตั้งราคาแล้ว</button>
                    <button class="toggle-btn px-3 py-1 text-sm">⌛ รอดำเนินการ</button> -->

                    <div class="relative">
                        <button id="btn-grid" class="toggle-btn flex items-center space-x-1 px-3 py-1"> <!-- <span class="text-sm">☰ รายการแจ้งเตือน</span> -->
                            <span class="text-sm">📋 รายการแจ้งเตือน</span>
                            <span id="account-badge-top" class="absolute -top-3 -right-1 inline-flex items-center justify-center
                                        rounded-full bg-red-600 text-white text-[10px]
                                        min-w-[18px] h-[18px] px-1 shadow-md">
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div id="list-view" class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4"> -->

        <div id="account-wrapper" class="relative">
            <div id="list-view" class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 relative">
                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Action</th>
                                <th>Brand Product</th>
                                <th>รหัสสินค้า</th>
                                <!-- <th>ภาษีน้ำหอม</th>
                                <th>ต้นทุน + ภาษีน้ำหอม</th>
                                <th>ต้นทุน+5%</th>
                                <th>ต้นทุน+10%</th>
                                <th>ต้นทุน+อื่นๆ</th> -->
                                <!-- <th>ชื่อสินค้าภาษาไทย</th></th> -->
                                <th>ชื่อย่อภาษาอังกฤษ</th>
                                <th>สถานะตั้งราคา</th>
                                <th>ราคาขายบัญชี TP</th>
                                <th>ประเภทสินค้า</th>
                                <th>ประเภทสินค้า[บัญชี]</th>
                                <!-- <th>ราคาขาย KM + 20%</th>
                                <th>ราคาขาย KM+อื่นๆ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="grid-view" class="view-section bg-white rounded shadow-lg dark:bg-[#232323] duration-500" style="display:none;">
                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                    <table id="tableAccountNoti" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Brand Product</th>
                                <th>รหัสสินค้า</th>
                                <!-- <th>ชื่อย่อภาษาอังกฤษ</th>
                                <th>สถานะตั้งราคา</th>
                                <th>ราคาขายบัญชี TP</th>
                                <th>ประเภทสินค้า</th>
                                <th>ประเภทสินค้า[บัญชี]</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 animate-spin dark:text-white">
                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                </svg>
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

        function brandBadge(brand){
        // map สีตาม brand (แก้ตามต้องการ)
        const map = {
            BB:  'border-black/20 bg-black/15',
            // CPS: 'border-[#ffc107]/30 bg-[#ffc107]/15',
            CPS: 'border-[#6f42c1]/30 bg-[#6f42c1]/15',
            FR:  'border-[#0d6efd]/30 bg-[#0d6efd]/15',
            GNC: 'border-[#dc3545]/30 bg-[#dc3545]/15',
            KM:  'border-[rgba(108,117,125,0.4)] bg-[rgba(108,117,125,0.4)]',
            OP:  'border-[#198754]/30 bg-[#198754]/15',
            KTY: 'border-[#8b5a2b]/30 bg-[#8b5a2b]/15',  // น้ำตาล
            LL:  'border-[#fd7e14]/30 bg-[#fd7e14]/15'   // ส้ม
        };
        const cls = map[brand] || 'border bg-black/15 border-white/20';

        return `
            <span class="inline-flex items-center  min-w-[220px] rounded-2xl border px-2 py-0 text-xs font-semibold text-slate-950 dark:text-white ${cls}">
            ${brand}
            </span>
        `;
        }

        function statusBadge(label, key){
            // key อาจเป็น "1","2","3" หรือ int
            const k = String(key || '').trim();

            const map = {
                "1": "border-[#0d6efd]/30 bg-[#0d6efd]/15",   // สินค้าใหม่
                "2": "border-[#ffc107]/30 bg-[#ffc107]/15",   // รอดำเนินการตั้งราคา
                "3": "border-emerald-400/30 bg-emerald-400/15"// ตั้งราคาแล้ว
            };

            const icon = {
                "1": "📌",
                "2": "⌛",
                "3": `<svg viewBox="0 0 24 24" class="h-4 w-4 text-white/95" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"> 
                        <path d="M20 6L9 17l-5-5" /> 
                    </svg>`
            };

            const cls = map[k] || "border-white/20 bg-black/15";
            const ic  = icon[k] || "•";

            return `
                <span class="inline-flex min-w-[220px] items-center justify-start gap-1 whitespace-nowrap
                            rounded-full border px-2 py-0 text-xs font-semibold text-slate-950 dark:text-white ${cls}">
                ${ic} ${label}
                </span>
            `;
        }

        $(function() {
            $('#btn-list').click(function() {
                $('#grid-view').hide();
                $('#list-view').show();
                $('.toggle-btn').removeClass('active');
                $(this).addClass('active');
            });

            $('#btn-grid').click(function() {
                $('#list-view').hide();
                $('#grid-view').show();
                $('.toggle-btn').removeClass('active');
                $(this).addClass('active');
            });
        });

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            // กำหนด event เมื่อกดปุ่ม "ล้างข้อมูล"
            $('button[type="reset"]').click(function() {
                $('#brand_id').val(null).trigger('change'); // Clear ค่า select2
                $('#statusSearch').val(null).trigger('change'); // Clear ค่า select2
                $('#search').val('').trigger('keyup'); // เคลียร์ค่า input ค้นหา
            });

            $('#brand_id').select2({
            width: '100%',
            templateResult: function (state) {
                if (!state.id) return state.text; // placeholder
                return $(brandBadge(state.text));
            },
            templateSelection: function (state) {
                if (!state.id) return state.text;
                return $(brandBadge(state.text));
            },
            escapeMarkup: function (m) { return m; } // สำคัญ: ให้ render HTML ได้
            });

            $('#statusSearch').select2({
                width: '100%',
                templateResult: function (state) {
                if (!state.id) return state.text; // placeholder
                return $(statusBadge(state.text, state.id));
                },
                templateSelection: function (state) {
                if (!state.id) return state.text;
                return $(statusBadge(state.text, state.id));
                },
                escapeMarkup: function (m) { return m; }
            });

        });

        const mytableDatatable = $('#example').DataTable({
            'searching': false,
            "serverSide": true,
            // processing: true,
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

                "url": "{{ route('account.list_ajax_account') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();
                    data.statusSearch = $('#statusSearch').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                },
                // 🔥 ใช้ custom loader
                beforeSend: function() {
                    $("#loader").removeClass("hidden").fadeIn(100);
                },
                complete: function() {
                    $("#loader").fadeOut(200, function() {
                        $(this).addClass("hidden");
                    });
                }
            },
            orderable: true,
            columnDefs: [
                {
                    targets: 0,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {

                        let showButton = `<a href="{{route('account.show',0)}}"
                            type="button" class="px-1 py-0.5 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white mr-0.5 rounded group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor" class="mb-0.5 hidden h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1">
                                <path d="M110.4 923.2c-56.8 0-102.4-48-102.4-106.4V285.6c0-58.4 45.6-106.4 102.4-106.4h800.8c56.8 0 102.4 48 102.4 106.4V816c0 58.4-45.6 106.4-102.4 106.4H110.4z m0-701.6c-34.4 0-61.6 28.8-61.6 64V816c0 35.2 28 64 61.6 64h800.8c34.4 0 61.6-28.8 61.6-64V285.6c0-35.2-28-64-61.6-64H110.4z" fill=""/>
                                <path d="M541.6 392c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 511.2c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 638.4c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h276.8c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24H541.6zM58.4 886.4c-2.4 0-4.8 0-7.2-0.8-12.8-4-20-18.4-16-32 23.2-78.4 77.6-142.4 148-176l16-8-13.6-12c-40-34.4-63.2-85.6-63.2-139.2 0-100 78.4-180.8 173.6-180.8 96 0 173.6 80.8 173.6 180.8 0 53.6-23.2 104.8-63.2 139.2l-13.6 12 16 8c68 32 132.8 112 157.6 194.4 16 52.8-16.8 36-1.6 16-3.2 4.8-16.8-5.6-32-5.6-12.8 0-19.2 24.8-19.2 22.4-31.2-104-120.8-203.2-217.6-203.2-99.2 0-186.4 67.2-216 166.4-1.6 11.2-11.2 18.4-21.6 18.4z m239.2-498.4c-69.6 0-126.4 58.4-126.4 130.4s56.8 130.4 126.4 130.4c69.6 0 126.4-58.4 126.4-130.4-0.8-72-56.8-130.4-126.4-130.4z" fill=""/>
                            </svg>
                            Show
                        </a>`;

                        let scheduleButton = `
                            <div ${row.price < 2 ? 'title="กรุณาใส่ราคา Brand" class="cursor-not-allowed"' : ''}>
                                <a href="{{route('account.edit',0)}}"
                                    type="button"
                                    ${row.price < 2 
                                        ? 'class="opacity-50 pointer-events-none px-1 py-0.5 font-medium tracking-wide bg-[#303030] text-white rounded group"' 
                                        : 'class="px-1 py-0.5 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"'}>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mb-0.5 hidden h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                    </svg>
                                    Schedule
                                </a>
                            </div>`;

                        return `<div class="inline-flex items-center rounded-md shadow-sm">
                            ${showButton}
                            ${scheduleButton}
                        </div>`.replaceAll('/0', '/' + row.product_id);
                    }
                },{
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BRAND;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.product_id;
                    }
                },
                // {
                //     targets: 2,
                //     orderable: true,
                //     render: function(data, type, row) {
                //         return row.NAME_THAI;
                //     }
                // },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.SHORT_ENG;
                    }
                },
                {
                targets: 4,
                orderable: true,
                render: function (data, type, row) {

                    // sort / filter ใช้ข้อความล้วน
                    if (type === 'sort' || type === 'filter') {
                    if (row.status == 1) return 'สินค้าใหม่';
                    if (row.status == 2) return 'รอดำเนินการตั้งราคา';
                    if (row.status == 3) return 'ตั้งราคาแล้ว';
                    return '';
                    }

                    // display
                    if (row.status == 1) {
                    return `
                                <span class="inline-flex min-w-[150px] items-center justify-start gap-1 whitespace-nowrap
                                        rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15
                                        px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">
                                📌 สินค้าใหม่
                                </span>
                            `;
                    }

                    if (row.status == 2) {
                    return `
                                <span class="inline-flex min-w-[150px] items-center justify-start gap-1 whitespace-nowrap
                                    rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15
                                    px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">
                                ⌛ รอดำเนินการตั้งราคา
                                </span>
                            `;
                    }

                    if (row.status == 3) {
                    return `
                                <span class="inline-flex min-w-[150px] items-center justify-start gap-1 whitespace-nowrap
                                    rounded-full border border-emerald-400/30 bg-emerald-400/15
                                    px-2 py-0.5 text-xs font-semibold text-slate-950 dark:text-white">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 text-white/95"
                                    fill="none" stroke="currentColor" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                                    ตั้งราคาแล้ว
                                </span>
                            `;
                    }

                    return '-';
                }
                },
                // {
                //     targets: 3,
                //     orderable: true,
                //     render: function(data, type, row) {
                    //         return new Intl.NumberFormat('en-US', {
                        //             minimumFractionDigits: 2,
                        //             maximumFractionDigits: 2
                        //         }).format(row.cost);
                        //     }
                        // },
                {
                    targets: 5,
                    orderable: true,
                    render: function(data, type, row) {
                    return new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(row.price);
                    }
                },
                {
                    targets: 6,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.DESCRIPTION;
                    }
                },
                {
                    targets: 7,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.ACC_DESCRIPTION;
                    }
                }
            ]
        });

        // Function สำหรับเรียกใช้ DataTable เมื่อมีการพิมพ์
        function searchTable() {
            console.log("Search: ", $('#search').val());
            $("#loader").removeClass("hidden").fadeIn(100);
            // บังคับให้ DataTables รีโหลดข้อมูลใหม่
            mytableDatatable.ajax.reload(null, false); 
        }

        function brandSearch() {
            $("#loader").removeClass("hidden").fadeIn(100);
            mytableDatatable.draw();
        }

        function showLoader() {
            $("#loader").removeClass("hidden").fadeIn(100);
        }

        function hideLoader() {
            $("#loader").fadeOut(200, function () {
                $(this).addClass("hidden");
            });
        }

        $('#btn-grid').on('click', function () {
            showLoader();
            $('#grid-view').show();
            $('#list-view').hide();

            tableAccountNoti.ajax.reload(null, false);
            // ไม่ต้อง hideLoader ตรงนี้ เพราะ complete ของ ajax จะจัดการให้แล้ว
        });

        // ① helper อ่าน noti products จาก localStorage
        function getNotiProductsFromStorage() {
            try {
                const raw = localStorage.getItem('account_noti_products');
                if (!raw) return [];
                const parsed = JSON.parse(raw);
                return Array.isArray(parsed) ? parsed.map(v => String(v)) : [];
            } catch (e) {
                console.warn('[AccountNoti] getNotiProductsFromStorage error', e);
                return [];
            }
        }

        let accountNotiProducts = getNotiProductsFromStorage();
        console.log('[AccountNoti] init list from storage =', accountNotiProducts);

        let tableAccountNoti = null;

        $(function () {
            if (!$.fn.DataTable.isDataTable('#tableAccountNoti')) {
                tableAccountNoti = $('#tableAccountNoti').DataTable({
                    // processing: true,
                    serverSide: true,
                    searching: false,
                    scrollX: true,
                    deferRender: true,
                    scroller: true,
                    scrollY: "580px",
                    order: [[1, "desc"]],
                    lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                    pageLength: 20,
                    ajax: {
                        url: "{{ route('account.list_ajax_account_noti') }}",
                        type: "POST",
                        data: function (d) {
                            d._token   = "{{ csrf_token() }}";
                            // ✅ อ่านค่าจาก localStorage สด ๆ ทุกครั้ง
                            d.account_badge_count = Number(
                                localStorage.getItem('account_badge_count') || '0'
                            );
                            // ✅ ส่ง list รหัสสินค้าไปให้ controller ด้วย
                            d.account_noti_products = localStorage.getItem('account_noti_products') || '[]';
                            // (ส่งเป็น string json ไป เดี๋ยวไป decode ที่ controller)
                        },
                        beforeSend: function () { 
                            showLoader(); 
                            
                        },
                        complete: function () { 
                            hideLoader(); 
                            
                        }
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: true,
                            className: 'text-center',
                            render: function (data, type, row) {
                                // ดึง list ล่าสุดจาก localStorage ทุกครั้งที่ render
                                const productCode = String(row.PRODUCT || '');
                                const isNew      = productCode && accountNotiProducts.includes(productCode);

                                // console.log('[AccountNoti] row PRODUCT =', productCode, {
                                //     accountNotiProducts,
                                //     isNew,
                                // });

                                const scheduleBadge = isNew
                                    ? `<span class="ml-1 inline-flex items-center justify-center rounded-full 
                                            bg-red-600 text-white text-[9px] min-w-[16px] h-[16px] px-1">
                                        !
                                    </span>`
                                    : '';
                                // ปุ่ม Show เดิม
                                let showButton = `<a href="{{ route('account.show', 0) }}"
                                    type="button"
                                    class="px-1 py-0.5 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white mr-0.5 rounded group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" fill="currentColor"
                                        class="mb-0.5 hidden h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path d="M110.4 923.2c-56.8 0-102.4-48-102.4-106.4V285.6c0-58.4 45.6-106.4 102.4-106.4h800.8c56.8 0 102.4 48 102.4 106.4V816c0 58.4-45.6 106.4-102.4 106.4H110.4z m0-701.6c-34.4 0-61.6 28.8-61.6 64V816c0 35.2 28 64 61.6 64h800.8c34.4 0 61.6-28.8 61.6-64V285.6c0-35.2-28-64-61.6-64H110.4z" />
                                        <path d="M541.6 392c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 511.2c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 638.4c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h276.8c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24H541.6zM58.4 886.4c-2.4 0-4.8 0-7.2-0.8-12.8-4-20-18.4-16-32 23.2-78.4 77.6-142.4 148-176l16-8-13.6-12c-40-34.4-63.2-85.6-63.2-139.2 0-100 78.4-180.8 173.6-180.8 96 0 173.6 80.8 173.6 180.8 0 53.6-23.2 104.8-63.2 139.2l-13.6 12 16 8c68 32 132.8 112 157.6 194.4 16 52.8-16.8 36-1.6 16-3.2 4.8-16.8-5.6-32-5.6-12.8 0-19.2 24.8-19.2 22.4-31.2-104-120.8-203.2-217.6-203.2-99.2 0-186.4 67.2-216 166.4-1.6 11.2-11.2 18.4-21.6 18.4z m239.2-498.4c-69.6 0-126.4 58.4-126.4 130.4s56.8 130.4 126.4 130.4c69.6 0 126.4-58.4 126.4-130.4-0.8-72-56.8-130.4-126.4-130.4z" />
                                    </svg>
                                    Show
                                </a>`;

                                let scheduleButton = `
                                <div ${row.price < 2 ? 'title="กรุณาใส่ราคา Brand" class="cursor-not-allowed"' : ''}>
                                    <a href="{{ route('account.edit', 0) }}"
                                        type="button"
                                        ${row.price < 2
                                            ? 'class="opacity-50 pointer-events-none px-1 py-0.5 font-medium tracking-wide bg-[#303030] text-white rounded group"'
                                            : 'class="px-1 py-0.5 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"'}>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="mb-0.5 hidden h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path fill-rule="evenodd"
                                                d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Schedule
                                        ${scheduleBadge}
                                    </a>
                                </div>`;

                                return `<div class="inline-flex items-center rounded-md shadow-sm">
                                    ${showButton}
                                    ${scheduleButton}
                                </div>`.replaceAll('/0', '/' + productCode);
                            }
                        },
                        { 
                            targets: 1, 
                            className: 'text-center', 
                            render: (data, type, row) => 
                            row.BRAND 
                        },
                        { 
                            targets: 2,
                            className: 'text-center', 
                            render: (data, type, row) => 
                            row.PRODUCT 
                        },
                        // { targets: 3, render: (data, type, row) => row.SHORT_ENG },
                        // {
                        //     targets: 4,
                        //     render: (data, type, row) => {
                        //         if (row.status == 1) return '📌 สินค้าใหม่';
                        //         if (row.status == 2) return '🔁 รอดำเนินการตั้งราคา';
                        //         if (row.status == 3) return '✅ ตั้งราคาแล้ว';
                        //         return '-';
                        //     }
                        // },
                        // {
                        //     targets: 5,
                        //     render: (data, type, row) =>
                        //         new Intl.NumberFormat('en-US', {
                        //             minimumFractionDigits: 2,
                        //             maximumFractionDigits: 2
                        //         }).format(row.price)
                        // },
                        // { targets: 6, render: (data, type, row) => row.DESCRIPTION },
                    ]
                });
            } else {
                tableAccountNoti.columns.adjust().draw(false);
            }
        });

        // ให้ realtime เรียก
        window.refreshAccountTable = function () {
            accountNotiProducts = getNotiProductsFromStorage();
            console.log('[AccountNoti] refreshAccountTable →', accountNotiProducts);

            if (tableAccountNoti) {
                showLoader();
                tableAccountNoti.ajax.reload(null, false);
                // complete ของ ajax จะ hideLoader ให้เอง
            }
        };

        function fetchAllProducts() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                text: 'Coming Soon',
                title: '🚧',
                width: 650,
                icon: 'warning',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonColor: '#e13636',
                cancelButtonText: `
                    Cancel
                `,
                color: "#ffffff",
                background: "#202020",

            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        data: $("#create_NPDRequest").serialize(),
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function(res){
                            return false;
                        },
                        error: function (params) {
                            setTimeout(function() {
                                errorMessage("เพิ่มขู้อมูลไม่สำเร็จ!");
                            },dlayMessage)
                            setTimeout(function() {
                                toastr.error("เพิ่มขู้อมูลไม่สำเร็จ!");
                            },dlayMessage)
                        }
                    });
                }
            });
        }


        // function disableAppointment(url,e,id) {
        //     const mytableDatatable = $('#example').DataTable();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#303030',
        //         cancelButtonColor: '#e13636',
        //         confirmButtonText: `
        //             <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
        //                 <path d="M0 0h24v24H0V0z" fill="none"></path>
        //                 <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
        //                 <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
        //             </svg>
        //             Save
        //         `,
        //         cancelButtonText: `Cancel`,
        //         color: "#ffffff",
        //         background: "#202020",

        //     }).then(result => {
        //         console.log("🚀 ~ disableAppointment ~ result:", result)
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url:"/broadcast_npd",
        //                 method:'POST',
        //                 headers:{
        //                     'X-Socket-Id': pusher.connection.socket_id
        //                 },
        //                 data:{
        //                     _token:  '{{csrf_token()}}',
        //                     message: 'update notify'
        //                 }
        //                 }).done(function (res) {
        //                     console.log("🚀 ~ $ ~ res:", res)
        //             });
        //             $.ajax({
        //                 type: "DELETE",
        //                 url: url,
        //                 beforeSend: function() {
        //                     $(e).parent().parent().addClass('d-none');
        //                 },
        //                 success: function (params) {
        //                     if(params.success){
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลสำเร็จ',
        //                             text:'',
        //                             icon:'success',
        //                             showConfirmButton: false,
        //                             timer: 1500
        //                         });
        //                         mytableDatatable.draw();
        //                     }
        //                     else{
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                             text:'',
        //                             icon:'error',
        //                         });
        //                         $(e).parent().parent().removeClass('d-none');
        //                     }
        //                 },
        //                 error: function(er){
        //                     Swal.fire({
        //                         title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                         text:'',
        //                         icon:'error',
        //                     });
        //                     $(e).parent().parent().removeClass('d-none');
        //                 }
        //             });
        //         }
        //     });
        // }
    </script>

    <!-- <style>
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div id="myform" class="form justify-center items-center bg-white dark:bg-[#232323] duration-500">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3" >
                        <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="BARCODE" name="BARCODE">
                            <option class="" value=""> --- กรุณาเลือก ---</option>
                            @foreach ($productCodeArr as $key => $productCode)
                                <option value={{ $productCode }}>{{ $productCode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3" >
                        <label for="" class="text-gray-900 dark:text-white">ชื่อ-นามสกุล-ลูกค้า</label>
                        <input type="text" name="search" id="search" onkeyup="checkNameBrand()" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" />
                    </div>
                </div>
            <div class="grid grid-cols-5 grid-rows-3 mb-2 gap-2">
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อายุ ..........</label>
                <input id="age" name="age" value="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">เบอร์โทร</label>
                <input id="" name="" value="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">รายได้สุทธิ</label>
                <input id="net_income" name="net_income" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ฐานเงินเดือน</label>
                <input id="base_salary" name="base_salary" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้สินเชื่อ</label>
                <input id="debt_burden" name="debt_burden" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">สัญญา</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รถยนต์(ไม่รี)</label>
                <input id="car_debt_n" name="car_debt_n" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">Dept</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รถยนต์(รี)</label>
                <input id="car_debt_y" name="car_debt_y" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ประมาณการดอกเบี้ยเดิม</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้ที่ไม่ปิด</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด (+/-)</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">เงินต้นของเดิม</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">งวดผ่อนกับทางบริษัท</label>
                <input id="installment_installments_with_company" name="installment_installments_with_company" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-[#df3434] rounded-sm text-sm text-center grid content-center justify-items-stretch">ยอดผ่อนของเดิม</label>
                <input id="original_installment_amount" name="original_installment_amount" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อื่น ๆ ถ้ามี</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">จำนวนห้องที่กู้ได้</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-3 m-0 p-0"></label>
            </div>
            <div class="flex justify-center items-center 2xl:text-2xl xl:text-xl lg:text-lg md:text-md sm:text-sm">
                <h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500 text-gray-900 dark:text-white" style="font-size: 16px;">ประมาณการผ่อนโปรแกรม OPM</h2>
            </div>
            <div class="grid grid-rows-3 grid-flow-col gap-2 pb-3">
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(20-28%)" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="บัตรกดเงินสด(20-28%)" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="บัตรกด(16-20%)" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อ OD (6-10%)" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(4-10%)" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(0-3%)" />
                <input id="" name="" class="row-span-3 col-span-2 m-0 p-0 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500 text-xl" placeholder="ผ่อนเดิมของลูกค้า" />
                <input id="" name="" class="row-span-3 col-span-2 m-0 p-0 dark:text-white rounded-sm bg-[#347BA4] bg-[#347BA4] dark:bg-[#347BA4] text-center focus:border-blue-500 text-xl" placeholder="OPM : 3" />
            </div>
            <div class="grid grid-rows-3 grid-flow-col gap-2 mt-3">
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">% ดอกเบี้ย .................</label>
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้</label>
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">จำนวนเดือน</label>
                <input id="" name="" class="row-span-1 col-span-6 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="20.00%" />
                <input id="cl_total_debt_burden1" name="cl_total_debt_burden1" class="row-span-1 col-span-6 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="11"/>
                <input id="" name="" class="row-span-1 col-span-6 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="18.34%" />
                <input id="cl_total_debt_burden2" name="cl_total_debt_burden2" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="22" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
                <input id="" name="" value="ยอดที่ต้องชำระ" class="row-span-1 col-span-3 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />
                <input id="cl_total_debt_burden3" name="cl_total_debt_burden3" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="33" />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
            </div>
            <div class="grid grid-rows-3 grid-flow-col gap-2 mt-3">
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่างวดผ่อนต่อเดือน</label>
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่างวดผ่อน(ทั้งหมด)</label>
                <label class="row-span-1 col-span-1 m-0 p-0 text-center text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ดอกเบี้ย(ทั้งหมด)</label>
                <input id="monthly_installment_payment" name="monthly_installment_payment" class="row-span-1 col-span-6 m-0 p-0 text-[#df3434] rounded-sm bg-[#FFCC45] dark:bg-[#FFCC45] text-center focus:border-blue-500" placeholder="1" disabled
                />
                <input id="installment_payments_all1" name="installment_payments_all1" class="row-span-1 col-span-6 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="2" disabled />
                <input id="interest_all1" name="interest_all1" class="row-span-1 col-span-6 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="3" disabled />
                <input id="total_original_installment_amount2" name="total_original_installment_amount2" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm dark:bg-[#649cbd] text-center focus:border-blue-500" placeholder="4" disabled />
                <input id="installment_payments_all2" name="installment_payments_all2" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="5" disabled />
                <input id="interest_all2" name="interest_all2" class="row-span-1 col-span-3 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="6" disabled />
                <input id="total_original_installment_amount3" name="total_original_installment_amount3" class="row-span-1 col-span-3 m-0 p-0 text-white rounded-sm bg-[#347BA4] dark:bg-[#347BA4] text-center focus:border-blue-500" placeholder="7" disabled />
                <input id="installment_payments_all3" name="installment_payments_all3" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="8" disabled />
                <input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="9" disabled />
            </div>
            <div class="grid grid-rows-3 grid-flow-col gap-2 mt-3 pb-3">
                <div class="col-span-2 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF]"></div>
                <label class="row-span-3 col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm text-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์</label>
                <input id="" name="" class="row-span-3 m-0 p-0 dark:text-white rounded-sm bg-[#236C6B] dark:bg-[#236C6B] text-center focus:border-blue-500 text-xl" placeholder="" disabled />
                <div class="col-span-2 dark:text-white rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF]"></div>
            </div>
            <ul class="pt-2 space-y-2 border-t border-black dark:border-blue-500">
            <div class="grid grid-cols-5 grid-rows-3 mt-3 mb-3 gap-2">
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ผลตอบแทน</label>
                <input id="Returns" name="Returns" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนเงินต้น 1 แสนละ</label>
                <input id="installment_of_100k_b" name="installment_of_100k_b" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้เดิมคิดเป็น</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้ส่วนเกิน 4 แสน</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด 20 เท่า</label>
                <input id="approval_closed_20_times" name="approval_closed_20_times" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">คิดเป็นต่อหน่วย 1 แสน</label>
                <input id="calculated_per_unit_100k" name="calculated_per_unit_100k" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้เกิน</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนเงินต้นช่วงแรก</label>
                <input id="principle" name="principle" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด (หนี้จริง)</label>
                <input id="approve_closing_actual_debt" name="approve_closing_actual_debt" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500"/>

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าผ่อนจ่าย (4 เดือนแรก)</label>
                <input id="c_pay_in_installments_first_4_m" name="c_pay_in_installments_first_4_m" class="col-span-1 m-0 p-0 text-white rounded-sm bg-[#347BA4] dark:bg-[#347BA4] text-center focus:border-blue-500"
                />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าช่วยปิด</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าผ่อนจ่าย (เดือนที่ 5 เป็นต้นไป)</label>
                <input id="c_pay_in_installments_5_m_onw" name="c_pay_in_installments_5_m_onw" class="col-span-1 m-0 p-0 text-white rounded-sm bg-[#347BA4] dark:bg-[#347BA4] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติคิดเป็น</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ประมาณการประกันชีวิต (บริษัท) *จ่ายแยก*</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ดอกเบี้ยของเดิม</label>
                <input id="original_interest" name="original_interest" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนกับทางบริษัท (ทั้งสิ้น)</label>
                <input id="installments_with_the_company_all" name="installments_with_the_company_all" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รวม</label>
                <input id="total_debt_burden" name="total_debt_burden" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">เงินรีไฟแนนซ์รถยนต์ (70%)</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">พรีวงเงินที่สามารถกู้ได้</label>
                <input id="Pre_borrow_amount_that_can_be_borrowed" name="Pre_borrow_amount_that_can_be_borrowed" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้คงเหลือสุทธิ</label>
                <input id="net_outstanding_debt" name="net_outstanding_debt" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm dark:bg-[#FFCC45] text-center focus:border-blue-500" />

                <label class="col-span-3 m-0 p-0"></label>
            </div>
            <ul class="pt-4 space-y-2 border-t border-black dark:border-blue-500 mt-3 mb-3">

            <table class="table table-bordered text-center mb-3">
                <thread>
                    <tr>
                        <th class="text-gray-900 dark:text-gray-100" scope="col">ห้อง</th>
                        <?php $i = 1 ?>
                        <td scope="col"><?php echo $i++; ?></td>
                    </tr>
                        <tr>
                            <td class="text-gray-900 dark:text-gray-100">ธนาคาร</td>
                        </tr>
                        <tr>
                            <td class="text-gray-900 dark:text-gray-100">LTV</td>
                        </tr>
                        <tr>
                            <td class="text-gray-900 dark:text-gray-100">วงเงินที่กู้ได้</td>
                        </tr>
                        <tr>
                            <td class="text-gray-900 dark:text-gray-100">ค่าพัฒนาทรัพย์</td>
                        </tr>
                </thread>
                <tbody>
                </tbody>
            </table>
            <table class="table table-bordered text-center table-sm mb-3">
                <thread>
                    <tr>
                        <th class="text-gray-900 dark:text-gray-100" scope="col">ประมาณการ MRTA</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">1</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">2</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">3</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">4</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">5</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">6</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">7</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">8</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">9</th>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ค่างวดผ่อน MRTA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thread>
                <tbody>
                </tbody>
            </table>
            <table class="table table-bordered text-center table-sm mb-3">
                <thread>
                    <tr>
                        <th class="text-gray-900 dark:text-gray-100" scope="col">วงเงินตกแต่งบ้าน</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">1</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">2</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">3</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">4</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">5</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">6</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">7</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">8</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">9</th>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ค่างวดผ่อนตกแต่งบ้าน</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thread>
                <tbody>
                </tbody>
            </table>
            <div class="flex justify-center items-center 2xl:text-md xl:text-md lg:text-md md:text-md sm:text-sm">
                <h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500 text-[#df3434]" style="font-size: 16px;">กรณีถือครองสัญญาไม่ครบ 60 เดือน ลูกค้าต้องเสียภาษี และค่าใช้จ่ายที่กรมที่ดินทุกกรณี</h2>
            </div>
            <table class="table table-bordered text-center table-sm mb-3">
                <thread>
                    <tr>
                        <th class="text-gray-900 dark:text-gray-100" scope="col">ภาษีที่ดิน ณ วันโอน</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">1</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">2</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">3</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">4</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">5</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">6</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">7</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">8</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">9</th>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ค่างวดผ่อนภาษีที่ดิน</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </thread>
                <tbody>
                </tbody>
            </table>
            <div class="flex justify-center items-center 2xl:text-md xl:text-md lg:text-md md:text-md sm:text-sm">
                <h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500 text-gray-900 dark:text-gray-100" style="font-size: 16px;">กรณีลูกค้าให้นำค่าพัฒนาทรัพย์มาหักลบหนี้ หรือ MRTA</h2>
            </div>
            <div class="grid grid-cols-5 grid-rows-3 mt-3 mb-3 gap-2">
                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ให้ลูกค้า/ใช้หักอื่น ๆ)</label>
                <input id="Returns" name="Returns" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์สุทธิ</label>
                <input id="net_property_development_cost" name="net_property_development_cost" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#a8ead5] dark:bg-[#a8ead5] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ไปช่วยลูกค้าปิด)</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์คงเหลือ</label>
                <input id="remaining_property_development_costs" name="remaining_property_development_costs" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#136C50] dark:bg-[#136C50] text-center focus:border-blue-500" />

                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ไปลด MRTA)</label>
                <input id="" name="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

                <label class="col-span-2 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้คงเหลือสุทธิ</label>
                <input id="net_outstanding_debt_mrta" name="net_outstanding_debt_mrta" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm bg-[#FFCC45] dark:bg-[#FFCC45] text-center focus:border-blue-500" />
            </div>
            <table class="table table-bordered text-center table-sm mb-3">
                <thread>
                    <tr>
                        <th class="text-gray-900 dark:text-gray-100" scope="col">ห้อง</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">1</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">2</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">3</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">4</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">5</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">6</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">7</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">8</th>
                        <th scope="col" class="bg-[#347BA4] dark:bg-[#347BA4] text-white">9</th>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ห้อง</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ประมาณการ MRTA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ค่างวดผ่อน MRTA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">ลูกค้าผ่อน</td>
                        <td id=""></td>
                        <td id=""></td>
                    </tr>
                    <tr>
                        <td class="text-gray-900 dark:text-gray-100">จำนวนงวดผ่อน</td>
                        <td class="text-gray-900 dark:text-gray-100">60</td>
                        <td class="text-gray-900 dark:text-gray-100">60</td>
                    </tr>
                </thread>
                <tbody>
                </tbody>
            </table>

            <div class="divide-y divide-dashed text-gray-900 dark:text-gray-100">
                <p>หมายเหตุ1 : </p>
                <div></div>
            </div>
            <div class="divide-y text-gray-900 dark:text-gray-100">
                <p>หมายเหตุ2 : </p>
                <div></div>
            </div>

            <div class="text-gray-900 dark:text-gray-100">
                <p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">บริษัท พีจี เอสเตท ดีเวลลอปเม้นท์ จำกัด 47-47/1 หมู่ที่ 7 ตำบลคูคต อำเภอลำลูกกา จังหวัดปทุมธานี 12130 โทร. 02-077-4068</p>
                <p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">PG Estate Development Co., Ltd. 47-47/1 Moo 7 Khukhot, Lamlukka, Pathumthani 12130, Thailand. Tel. 02-077-4068</p>
                <p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">(V.20230909)</p>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

    getParmeterLogin()
            function getParmeterLogin() {
                let dataLogin = sessionStorage.getItem("credetail");
                let dataJson = JSON.parse(dataLogin)
                // console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
            }
    function pagePrint(myform) {
        let printdata = document.getElementById("myform");
        newwin = window.open("");
        newwin.document.write(printdata.outerHTML);
        newwin.print();
        newwin.close();
    }

    // let installment_of_100k_b
    // let calculated_per_unit_100k
    // total_original_installment_amount3

    // let debt_burden = document.getElementById('debt_burden').value || "0";
    // debt_burden = toStringNumber(debt_burden)
    // document.getElementById('approve_closing_actual_debt').value = total_debt_burden.toLocaleString()
    console.log('detail_bank_name_send', detail_bank_name_send);

    function mathCeil(total, ceil) {
        return Math.ceil(total / ceil) * ceil
    }
    function getValue(key){
        let value = document.getElementById(key).value || "0";
        value = toStringNumber(value)
         return value
    }
    function setValue(key,value){
        document.getElementById(key).value = value.toLocaleString()
    }

    function toStringNumber(data){
     return parseFloat(data.replace(/,/g, ''));
    }
    function formatNumber(data){
     return data.replace(/\d(?=(?:\d{3})+$)/g, '$&,');
    }
    function onChangeNumber(value){
        if(isNaN(value)){
            return toStringNumber(value).toLocaleString()
        }else{
            return Number(value).toLocaleString()
        }
    }

    function calTotalOriginalInstallmenAamount(){
        let original_installment_amount = document.getElementById('original_installment_amount').value || "0";
        original_installment_amount = toStringNumber(original_installment_amount)
        let cl_total_debt_burden2 = document.getElementById('cl_total_debt_burden2').value || "0";
        cl_total_debt_burden2 = toStringNumber(cl_total_debt_burden2)
        let installment_payments_all1 = document.getElementById('installment_payments_all1').value || "0";
        installment_payments_all1 = toStringNumber(installment_payments_all1)

        let total_original_installment_amount = Number(original_installment_amount)
        document.getElementById('total_original_installment_amount2').value = total_original_installment_amount.toLocaleString()
        document.getElementById('installment_payments_all2').value = (total_original_installment_amount * 60).toLocaleString()
        document.getElementById('interest_all1').value = (cl_total_debt_burden2 - installment_payments_all1).toLocaleString()
        document.getElementById('interest_all2').value =  (cl_total_debt_burden2 - (total_original_installment_amount * 60)).toLocaleString()
    }

    document.getElementById('original_installment_amount').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        calTotalOriginalInstallmenAamount()
    })

    function calTotalDebt(){
        let debt_burden = getValue('debt_burden')
        let car_debt_n = getValue('car_debt_n')
        let car_debt_y = getValue('car_debt_y')

        let installment_payments_all2 = document.getElementById('installment_payments_all2').value || "0";
        installment_payments_all2 = toStringNumber(installment_payments_all2)

        let total_debt_burden = Number(debt_burden) + Number(car_debt_n) + Number(car_debt_y)
        setValue('total_debt_burden',total_debt_burden)
        setValue('approve_closing_actual_debt',total_debt_burden)
        setValue('net_outstanding_debt',total_debt_burden)

        document.getElementById('cl_total_debt_burden1').value = total_debt_burden.toLocaleString()
        document.getElementById('cl_total_debt_burden2').value = total_debt_burden.toLocaleString()
        // Don't take fraction
        document.getElementById('monthly_installment_payment').value = Math.floor(total_debt_burden * 0.05).toLocaleString()
        // Don't take fraction
        document.getElementById('c_pay_in_installments_5_m_onw').value = Math.floor(total_debt_burden * 0.05).toLocaleString()
        document.getElementById('installment_payments_all1').value = ((total_debt_burden * 0.05) * 60).toLocaleString()
        document.getElementById('interest_all1').value = (total_debt_burden - (total_debt_burden * 0.05) * 60).toLocaleString()
        document.getElementById('interest_all2').value =  (total_debt_burden - installment_payments_all2).toLocaleString()
    }

    function calInstallment(){
        let debt_burden = document.getElementById('debt_burden').value || "0";
        debt_burden = toStringNumber(debt_burden)
        let installment = 900
        if(debt_burden >= 400000 && debt_burden <= 450000){
            installment = 3000
        }else if(debt_burden >= 450001 && debt_burden <= 550000){
            installment = 6000
        }else if(debt_burden >= 550001 ){
            installment = 9000
        }
        document.getElementById('installment_of_100k_b').value = installment.toLocaleString()
    }

    function calInstallmentUnit(){
        let debt_burden = document.getElementById('debt_burden').value || "0";
        debt_burden = toStringNumber(debt_burden)
        // Don't take fraction
        let unit = Math.floor(debt_burden / 100000)
        document.getElementById('calculated_per_unit_100k').value = unit.toLocaleString()
        calInstallmentPerUnit()
    }

    function calInstallmentPerUnit(){
        let installment_of_100k_b = document.getElementById('installment_of_100k_b').value || "0";
        installment_of_100k_b = toStringNumber(installment_of_100k_b)
        let original_interest = document.getElementById('original_interest').value || "0";
        original_interest = toStringNumber(original_interest)
        let calculated_per_unit_100k = document.getElementById('calculated_per_unit_100k').value || "0";
        calculated_per_unit_100k = toStringNumber(calculated_per_unit_100k)

        let perUnit = calculated_per_unit_100k * installment_of_100k_b
        document.getElementById('principle').value = perUnit.toLocaleString()

        let customerPay = original_interest + perUnit
        document.getElementById('c_pay_in_installments_first_4_m').value = customerPay.toLocaleString()
    }
    function calOriginalInterest(){
        let debt_burden = document.getElementById('debt_burden').value || "0";
        debt_burden = toStringNumber(debt_burden)
        let principle = document.getElementById('principle').value || "0";
        principle = toStringNumber(principle)
        let net_outstanding_debt = document.getElementById('net_outstanding_debt').value || "0";
        net_outstanding_debt = toStringNumber(net_outstanding_debt)
        // Don't take fraction
        let  originalInterest = Math.floor((debt_burden * 0.1834) / 12)
        document.getElementById('original_interest').value = originalInterest.toLocaleString()

        // Start ยังแก้ไม่ได้
        let  detail_net_outstanding_debt = (net_outstanding_debt / 60).toLocaleString()
        document.getElementById('total_original_installment_amount3').value = (originalInterest - detail_net_outstanding_debt).toLocaleString()
        // End ยังแก้ไม่ได้

        document.getElementById('installment_payments_all3').value = (originalInterest * 60).toLocaleString()

        let customerPay = originalInterest + principle
        document.getElementById('c_pay_in_installments_first_4_m').value = customerPay.toLocaleString()
    }


    document.getElementById('debt_burden').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        let base_salary = document.getElementById('base_salary').value || "0";
        base_salary = toStringNumber(base_salary)
        let debt_burden = document.getElementById('debt_burden').value || "0";
        debt_burden = toStringNumber(debt_burden)
        let Returns = '4%'
        if(base_salary >= 30000 && debt_burden <= 600000){
            Returns = '5%'
        }
        document.getElementById('Returns').value = Returns
        let return_percent = toStringNumber(Returns.replace('%', ''))

        let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')

        let rooms_ltvs = document.querySelectorAll(".room-ltv");
        rooms_ltvs.forEach(function (rooms_ltvs, index) {

            let rooms_ltv = getValue('room_LTV_' + index)
            // total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
            total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
            console.log('total_can_be_borrowed', total_can_be_borrowed)
            setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
        });

        calTotalDebt()
        calInstallment()
        calInstallmentUnit()
        calOriginalInterest()
    })

    document.getElementById('car_debt_n').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        calTotalDebt()
    })
    document.getElementById('car_debt_y').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        calTotalDebt()
    })
    document.getElementById('base_salary').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        let base_salary = document.getElementById('base_salary').value || "0";
        base_salary = toStringNumber(base_salary)
        let debt_burden = document.getElementById('debt_burden').value || "0";
        debt_burden = toStringNumber(debt_burden)
        let Returns = '4%'
        if(base_salary >= 30000 && debt_burden <= 600000){
            Returns = '5%'
        }
        document.getElementById('Returns').value = Returns
        let return_percent = toStringNumber(Returns.replace('%', ''))

        let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')

        let rooms_ltvs = document.querySelectorAll(".room-ltv");
        rooms_ltvs.forEach(function (rooms_ltvs, index) {

            let rooms_ltv = getValue('room_LTV_' + index)
            // total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
            total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
            console.log('total_can_be_borrowed', total_can_be_borrowed)
            setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
        });
    })

    function calNetIncome(){
        let age = document.getElementById('age').value || "0";
        age = toStringNumber(age)
        let net_income = document.getElementById('net_income').value || "0";
        net_income = toStringNumber(net_income)
        document.getElementById('approval_closed_20_times').value = (net_income * 20).toLocaleString()

        let totalNetPercent = 0.6
        if(net_income >= 30000 && age <= 40){
            totalNetPercent = 0.7
        }

        // Don't take fraction
        const totalNet =  mathCeil(parseInt( net_income * totalNetPercent ) / 7000 * 1000000, 10000)
        document.getElementById('Pre_borrow_amount_that_can_be_borrowed').value = totalNet.toLocaleString()

        let rooms_ltvs = document.querySelectorAll(".room-ltv");
        rooms_ltvs.forEach(function (rooms_ltvs, index) {

            let rooms_ltv = getValue('room_LTV_' + index)
            // total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
            let total_can_be_borrowed = totalNet * (rooms_ltv / 100)
            console.log('total_can_be_borrowed', total_can_be_borrowed)
            setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
        });
    }
    document.getElementById('age').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        calNetIncome()
    })
    document.getElementById('net_income').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)

        calNetIncome()
    })

    function calCustomerPay(){
        let installment_installments_with_company = document.getElementById('installment_installments_with_company').value || "0";
        installment_installments_with_company = toStringNumber(installment_installments_with_company)

        let principle = document.getElementById('principle').value || "0";
        principle = toStringNumber(principle)
        let original_interest = document.getElementById('original_interest').value || "0";
        original_interest = toStringNumber(original_interest)
        let total_debt_burden = document.getElementById('total_debt_burden').value || "0";
        total_debt_burden = toStringNumber(total_debt_burden)
        let c_pay_in_installments_5_m_onw = document.getElementById('c_pay_in_installments_5_m_onw').value || "0";
        c_pay_in_installments_5_m_onw = toStringNumber(c_pay_in_installments_5_m_onw)

        let  installmentsCompany4 = principle * 4
        let  installmentsCompany5 = c_pay_in_installments_5_m_onw - original_interest
        let  installmentsCompany5All = installmentsCompany5 + installmentsCompany4
        let net_outstanding_debt = 0
        if(installment_installments_with_company == 4){
            document.getElementById('installments_with_the_company_all').value = installmentsCompany4.toLocaleString()
            net_outstanding_debt = total_debt_burden - installmentsCompany4
        }else if(installment_installments_with_company == 5){
            document.getElementById('installments_with_the_company_all').value = installmentsCompany5All.toLocaleString()
            net_outstanding_debt = total_debt_burden - installmentsCompany5All
        }
        document.getElementById('net_outstanding_debt').value = net_outstanding_debt.toLocaleString()
        document.getElementById('cl_total_debt_burden3').value = net_outstanding_debt.toLocaleString()
    }

    document.getElementById('installment_installments_with_company').addEventListener("input",(event) => {
        event.target.value = onChangeNumber(event.target.value)
        calCustomerPay()
    })

    function calRoom(){
        let rooms_ltvs = document.querySelectorAll(".room-ltv");
        console.log("🚀 ~ calRoom ~ rooms_ltvs:", rooms_ltvs)
        let rooms_amount_that_can_bes = document.querySelectorAll(".room-amount-that-can-be");
        let rooms_room_property_development_costs = document.querySelectorAll(".room-property-development-costs");

        rooms_ltvs.forEach((el,index) => {
            console.log("🚀 ~ rooms_ltvs.forEach ~ el:", el)
            el.value = '100'
            el.addEventListener("input",(event) => {
                let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')
                event.target.value = onChangeNumber(event.target.value)
                let rooms_ltv = getValue('room_LTV_' + index)
                console.log("🚀 ~ el.addEventListener ~ rooms_ltv:", rooms_ltv)
                let total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
                console.log("🚀 ~ el.addEventListener ~ total_can_be_borrowed:", total_can_be_borrowed)
                setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
                console.log("🚀 ~ el.addEventListener ~ total_can_be_borrowed:", total_can_be_borrowed)
            })
        })
        // for (const rooms_amount_that_can_be of rooms_amount_that_can_bes) {
        // 	rooms_amount_that_can_be.value = '100'
        // }
        // for (const rooms_room_property_development_cost of rooms_room_property_development_costs) {
        // 	rooms_room_property_development_cost.value = '100'
        // }
    }
    calRoom()

    let net_property_development_cost             //  ค่าพัฒนาทรัพย์สุทธิ
    let remaining_property_development_costs    //ค่าพัฒนาทรัพย์คงเหลือ
    let net_outstanding_debt_mrta               // หนี้คงเหลือสุทธิ_mrta

    let room_LTV_1                               // LTV
    let room_LTV_2
    let room_LTV_3
    let room_LTV_4
    let room_LTV_5
    let room_LTV_6
    let room_LTV_7
    let room_LTV_8
    let room_LTV_9

    let room_amount_that_can_be_1                // วงเงินที่กู้ได้
    let room_amount_that_can_be_2
    let room_amount_that_can_be_3
    let room_amount_that_can_be_4
    let room_amount_that_can_be_5
    let room_amount_that_can_be_6
    let room_amount_that_can_be_7
    let room_amount_that_can_be_8
    let room_amount_that_can_be_9

    let room_property_development_costs_1                // ค่าพัฒนาทรัพย์
    let room_property_development_costs_2
    let room_property_development_costs_3
    let room_property_development_costs_4
    let room_property_development_costs_5
    let room_property_development_costs_6
    let room_property_development_costs_7
    let room_property_development_costs_8
    let room_property_development_costs_9

    // cl_total_debt_burden3            // หัวข้อ ยอดที่ต้องชำระ

    // ช่อง1 ภาระหนี้ - ค่างวดผ่อน(ทั้งหมด)
    // cl_total_debt_burden1 - installment_payments_all1 = interest_all1
    // ช่อง2 ภาระหนี้ - ค่างวดผ่อน(ทั้งหมด)
    // cl_total_debt_burden2 - installment_payments_all2 = interest_all2

    let age                                               //อายุ
    let net_income                                        //รายได้สุทธิ
    let Pre_borrow_amount_that_can_be_borrowed            //พรีวงเงินที่สามารถกู้ได้

    let installment_installments_with_company         //งวดผ่อนกับทางบริษัท
    let original_interest                                   //ดอกเบี้ยของเดิม
    let principle                                           //ผ่อนเงินต้นช่วงแรก



    let c_pay_in_installments_first_4_m      //ลูกค้าผ่อนจ่าย (4 เดือนแรก)
    let c_pay_in_installments_5_m_onw     //ลูกค้าผ่อนจ่าย (เดือนที่ 5 เป็นต้นไป)
    let monthly_installment_payment                         //ค่างวดผ่อนต่อเดือน

    let installments_with_the_company_all                 //ผ่อนกับทางบริษัท (ทั้งสิ้น)
    let total_debt_burden                         //ภาระหนี้รวม
    let net_outstanding_debt                         //หนี้คงเหลือสุทธิ
    let approval_closed_20_times                          //อนุมัติปิด 20 เท่า


    </script> -->
@endsection
