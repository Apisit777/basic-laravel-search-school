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
        .table td, .table th {
            padding: 0.20rem !important;
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    @php
        $packSizes = [3, 4, 6, 8, 9, 12, 24, 30, 36, 48, 72, 144, 180];
    @endphp

    <div class="justify-center items-center">
        <div class="mt-9 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-2">
            <div class="flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">NPD REQUEST</p>
            </div>
            <form action="#">
                <div class="grid gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="lg:col-span-4 xl:grid-cols-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                            <div class="md:col-span-3">
                                <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND">
                                    <option value=""> --- กรุณาเลือก ---</option>
                                    @foreach ($brands as $key => $brand)
                                        <option value={{ $brand }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="md:col-span-2" >
                                <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="BARCODE" name="BARCODE">
                                    <option class="" value=""> --- กรุณาเลือก ---</option>
                                    @foreach ($productCodeArr as $key => $productCode)
                                        <option value={{ $productCode }}>{{ $productCode }}</option>
                                    @endforeach
                                </select>
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
                                    <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
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
            </form>
        </div>
        <ul class="pt-1 mt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>

        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal"
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
                    <form id="form_copy" action="{{ route('new_product_develop.export_excel_new_product_develop') }}" method="POST">
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
                            <button data-twe-modal-dismiss id="submitButton" type="submit" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" disabled>
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

        <div class="flex xs:right-12 sm:right-12 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-3">  
        <a
            type="button"
            data-twe-toggle="modal"
            data-twe-target="#exampleModal"
            data-twe-ripple-init
            data-twe-ripple-color="light"
            class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 mr-16 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="" id=""
        >
            <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/><path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
            </svg>

            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg> -->
                Export Excel
            </a>
        </div>
        <div class="flex xs:right-12 sm:right-12 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-3">  
            <a 
                href="{{ route('new_product_develop.create') }}" type="button" 
                class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="add" id="add">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
            </a>
        </div>

        <button
            type="button"
            class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
            data-twe-toggle="modal"
            data-twe-target="#exampleModalXl"
            data-twe-ripple-init
            data-twe-ripple-color="light"
        >
            สร้าง Barcode EAN 14
        </button>

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>Barcode</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="fixed flex bottom-4 right-5 z-10">
            <a
                type="button"
                class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group btn-rotate"
                data-twe-toggle="modal"
                data-twe-target="#exampleModalLg"
                data-twe-ripple-init
                data-twe-ripple-color="light"
            >
                <svg class="size-7 rotate" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg> -->
            </a>
        </div>

        <div
            data-twe-modal-init
            class="data-twe-backdrop-show fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalLg"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="exampleModalLgLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-200 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel"></h5>
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
                                stroke-width="1.5"
                                stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    

                    <div id="loader_create_menu" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!--Extra large modal-->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalXl"
            tabindex="-1"
            aria-labelledby="exampleModalXlLabel"
            aria-modal="true"
            role="dialog"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px] min-[1200px]:max-w-[1140px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                    <!-- Modal title -->
                    <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalXlLabel">
                        Barcode 14 หลัก
                    </h5>
                    <!-- Close button -->
                    <button
                        type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                        data-twe-modal-dismiss
                        aria-label="Close">
                        <span class="[&>svg]:h-6 [&>svg]:w-6">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="form_menu" class="" method="POST">
                    <input class="" type="hidden" id="edit_id" name="edit_id" value="">
                    <div class="p-4 text-gray-900 dark:text-gray-100">
                        <div class="grid gap-6 gap-y-1 text-sm grid-cols-1 md:grid-cols-12 barcode-row" id="formBarcode">
                            <div class="md:col-span-2" style="position: relative;">
                                <label for="BRAND" class="text-sm font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" id="products" name="products">
                                    <option value=""> -- กรุณาเลือก --</option>
                                    @foreach ($products as $key => $product)
                                        <option value={{ $product }}>{{ $product }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2" style="position: relative;">
                                <label for="PACK_SIZE1">รหัส Packsize1</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE1" id="PACK_SIZE1" onchange="packSize1Change(this, 'PACK_SIZE1')">
                                    <option value=""> --- กรุณาเลือก ---</option>
                                    @foreach ($packSizes as $size)
                                        <option value="{{ $size }}">
                                            {{ $size }} ชิ้น
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2" style="position: relative;">
                                <label for="">Barpack 1 (Inner)</label>
                                <input type="text" name="menu_url" id="url_id" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" readonly>
                            </div>

                            <div class="md:col-span-2" style="position: relative;">
                                <label for="PACK_SIZE2">รหัส Packsize2</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE2" id="PACK_SIZE2" onchange="packSize2Change(this, 'PACK_SIZE2')">
                                    <option value=""> --- กรุณาเลือก ---</option>
                                    @foreach ($packSizes as $size)
                                        <option value="{{ $size }}">
                                            {{ $size }} ชิ้น
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2" style="position: relative;">
                                <label for="">Barpack 2 (Case)</label>
                                <input type="text" name="menu_url" id="url_id" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" readonly>
                            </div>
                            <div class="md:col-span-1 mt-5 mr-10" style="position: relative;">
                                <!-- Barcode Icon (ใช้ currentColor) -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 256 512"
                                    aria-hidden="true"
                                    transform="scale(1.5,1)"
                                    class="h-12 w-32 text-gray-900 dark:text-gray-100"
                                >
                                    <g fill="currentColor">
                                        <rect y="94.103" width="48.569" height="323.795"/>
                                        <rect x="72.854" y="94.103" width="24.284" height="323.795"/>
                                        <polygon points="121.423,94.103 121.423,417.897 145.708,417.897 169.992,417.897 169.992,94.103 145.708,94.103"/>
                                        <polygon points="194.277,94.103 194.277,417.897 218.561,417.897 242.846,417.897 242.846,94.103 218.561,94.103"/>
                                        <rect x="267.13" y="94.103" width="24.285" height="323.795"/>
                                        <polygon points="339.984,94.103 315.7,94.103 315.7,417.897 339.984,417.897 364.269,417.897 388.554,417.897 388.554,94.103 364.269,94.103"/>
                                        <polygon points="412.838,94.103 412.838,417.897 437.122,417.897 462.083,417.897 462.083,94.103 437.122,94.103"/>
                                        <rect x="487.044" y="94.103" width="24.956" height="323.795"/>
                                    </g>
                                </svg>
                                <!-- <label class="-mt-4 ml-10">88500000000</label> -->
                                <!-- Barcode number -->
                                <span class="absolute -mt-2.5 ml-9 text-xs">
                                    88500000000000
                                </span>
                            </div>
                            <div class="md:col-span-1" style="position: relative;">
                                <button type="button" class="mt-7 px-2 py-1 ml-10 font-medium tracking-wide bg-[#303030] hover:bg-[#303030] text-white rounded group" name="addBarcode" id="addBarcode">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="p-2 ">
                        <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                    </div>
                    <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                        <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createMenu()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            Save
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
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


        let i = 0;
        $('#addBarcode').on('click', () => {
            ++i;
            $('#formBarcode').append(`
                <div class="barcode-item contents">  <!-- ตัวห่อของหนึ่งแถว -->
                    <div class="md:col-span-2" style="position: relative;">
                        <label for="BRAND" class="text-sm font-medium text-gray-900 dark:text-white">Products</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="products_${i}" name="products[]">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($products as $key => $product)
                                <option value={{ $product }}>{{ $product }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2" style="position: relative;">
                        <label for="PACK_SIZE1">รหัส Packsize1</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="PACK_SIZE_1_${i}" name="PACK_SIZE_1_[]">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($packSizes as $size)
                                <option value="{{ $size }}">
                                    {{ $size }} ชิ้น
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2" style="position: relative;">
                        <label>Barpack 1 (Inner)</label>
                        <input type="text" name="barpack1[]" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" readonly>
                    </div>
                    <div class="md:col-span-2" style="position: relative;">
                        <label for="PACK_SIZE2">รหัส Packsize2</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="PACK_SIZE_2_${i}" name="PACK_SIZE_1_[]">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($packSizes as $size)
                                <option value="{{ $size }}">
                                    {{ $size }} ชิ้น
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2" style="position: relative;">
                        <label>Barpack 2 (Case)</label>
                        <input type="text" name="barpack2[]" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" readonly>
                    </div>
                    <div class="md:col-span-1" style="position: relative;">
                        <button type="button" class="remove-table-row mt-8 px-2 py-1 ml-10 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            `);

             // log id ที่สร้างขึ้น
            console.log("สร้าง products id:", `products_${i}`);
            console.log("สร้าง PACK_SIZE id:", `PACK_SIZE_1_${i}`);
            console.log("สร้าง PACK_SIZE id:", `PACK_SIZE_2_${i}`);

            // init select2 ให้ตัวใหม่ด้วย
            $(`#products_${i}`).select2({
                width: '100%'
            });
            $(`#PACK_SIZE_1_${i}`).select2({
                width: '100%'
            });
            $(`#PACK_SIZE_2_${i}`).select2({
                width: '100%'
            });
        });

        // ใช้ event delegation และลบทั้งชุดที่ห่อด้วย .barcode-item
        $(document).on('click', '.remove-table-row', function () {
            $(this).closest('.barcode-item').remove();
        });

        function packSize1Change(e) {
            let BARCODE = jQuery("#BARCODE").val();
            let packSize = e.value;
            console.log("🚀 ~ packSize1Change ~ packSize:", packSize)

            if (packSize.length > 1) {
                packSize = packSize.substring(0, 1);
            }
            console.log("🚀 ~ packSize1Change ~ substring:", packSize)
            
            if (!BARCODE || packSize === "") {
                jQuery("#BAR_PACK1").val('');
                return;
            }

            let ean13 = packSize + BARCODE.substring(0, BARCODE.length - 1);
            console.log("🚀 ~ packSize1Change ~ ean13:", ean13)

            if (ean13) {
                if (ean13.length == 13) {
                    url = '{{ route('product_master.calculate_ean14_check_digit', ':ean13') }}'.replace(':ean13', ean13);
                } else {
                    url = '';
                }
            }

            jQuery.ajax({
                method: "GET",
                url: url,
                dataType: 'json',
                success: function (response) {
                    console.log("✅ Response:", response);
                    if (response.checkDigit) {
                        jQuery("#BAR_PACK1").val(response.checkDigit);
                    } else {
                        jQuery("#BAR_PACK1").val('');
                    }
                },
                error: function (xhr) {
                    console.error("❌ AJAX Error:", xhr);
                    alert("เกิดข้อผิดพลาด: " + xhr.responseText);
                }
            });
        }
        
        $(document).ready(function () {
            // Initialize Select2 on page load
            $('.js-example-basic-single').select2();
            $('#start_product').select2();
            $('#end_product').select2();
            jQuery("#start_product").val('').change();

            // กำหนด event เมื่อกดปุ่ม "ล้างข้อมูล"
            $('button[type="reset"]').click(function() {
                $('#brand_id').val(null).trigger('change'); // Clear ค่า select2
                $('#search').val(''); // เคลียร์ค่า input ค้นหา
            });

        });

        $('#start_product').on('change', function () {
            const selectedId = $(this).val();
            if (!selectedId) {
                $('#end_product').html('<option value="">--- กรุณาเลือก ---</option>');
                jQuery("#submitButton").addClass('cursor-not-allowed opacity-50');
                return;
            }
            $.ajax({
                url: "{{ route('new_product_develop.pro_develops_get_select2') }}",
                type: "GET",
                data: {
                    id: selectedId, 
                },
                success: function (response) {
                    // console.log("🚀 ~ response:", response)
                    $('#end_product').html('<option value="">--- กรุณาเลือก ---</option>');
                    jQuery("#submitButton").removeClass('cursor-not-allowed opacity-50');
                    jQuery("#submitButton").attr("disabled", false);
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

        $(function(){
            $('form').on('reset', function() {
                localStorage.removeItem('get_refun_url');
                $('#brand_id').val('');
                setTimeout(function() {
                    mytableDatatable.draw();
                }, 500)
            });
        });

        getParameterSearce()
        function getParameterSearce() {
            let dataSearch = localStorage.getItem("get_refun_url");
            let dataJson = JSON.parse(dataSearch)
            // console.log("🚀 ~ getParameterSearce ~ dataJson:", dataJson)
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        // const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
        // const channel = pusher.subscribe('public');

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
            'searching': false,
            "serverSide": true,
            searching: false,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "600px",
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('new_product_develop.list_npd') }}",
                "type": "POST",
                'data': function(data) {
                    data.brand_id = $('#brand_id').val();
                    data.BARCODE = $('#BARCODE').val();
                    data.search = $('#search').val();
                    data._token = $('meta[name="csrf-token"]').attr('content');

                    // SetParameterSearce
                    localStorage.setItem("get_refun_url", JSON.stringify(data));
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BRAND;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.PRODUCT;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_ENG;
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
                        let text = "#"
                        let disabledRoute = "{{route('new_product_develop.show_barcode', 0)}}".replace('/0', "/" + row.BARCODE)
                        return `<div class="inline-flex items-center rounded-md shadow-sm">
                                    <a href="{{route('new_product_develop.edit',0)}}"
                                        type="button" class="px-1 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 mr-0.5 rounded group">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                            <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                            <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}', '${row.Code}')"
                                        type="button" class="px-1 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group cursor-pointer">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                                                viewBox="0 0 512 512" xml:space="preserve">
                                            <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
                                                C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
                                                c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
                                                V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
                                                V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
                                            <g>
                                                <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
                                                <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
                                            </g>
                                            <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
                                                c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
                                            <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
                                                />
                                        </svg>
                                        Copy
                                    </a>
                                    <a href="{{route('new_product_develop.show',0)}}" type="button" class="bclose">
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
                                </div>
                               `.replaceAll('/0', '/' + row.BARCODE);
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

        // <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}')" type="button"
        //     class="bclose btn btn-sm btn-success refersh_btn"
        // >
        //     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
        //     <path fill-rule="evenodd" d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z" clip-rule="evenodd" />
        //     </svg>
        // </a>
        function disableAppointment(url, e, id, code) {
            const mytableDatatable = $('#example').DataTable();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Copy ข้อมูลรหัสสินค้า ' + code + ' ไปรหัสใหม่',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#303030',
                cancelButtonColor: '#e13636',
                confirmButtonText: `
                <a href="#"
                    type="button" class="px-1 py-1 font-medium tracking-wide text-white py-0.5 px-1 rounded group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                    </svg>
                    Save
                `,
                cancelButtonText: `Cancel`,
                color: "#ffffff",
                background: "#202020",

            }).then(result => {
                console.log("🚀 ~ disableAppointment ~ result:", result)
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        beforeSend: function() {
                            $(e).parent().parent().addClass('d-none');
                        },
                        success: function (params) {
                            if(params.success){
                                Swal.fire({
                                    title:'เพิ่มข้อมูล ' + ++code + ' เรียบร้อย',
                                    text:'',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                mytableDatatable.draw();
                            }
                            else{
                                Swal.fire({
                                    title:'บันทึกข้อมูลไม่สำเร็จ',
                                    text:'',
                                    icon:'error',
                                });
                                $(e).parent().parent().removeClass('d-none');
                            }
                        },
                        error: function(er){
                            Swal.fire({
                                title:'บันทึกข้อมูลไม่สำเร็จ',
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
