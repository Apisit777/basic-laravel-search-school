

@extends('layouts.layout')
@section('title', '')
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
        .dt-length  {
            color: #818181!important;
        }

        .table td, .table th {
            padding: 0.55rem !important;
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

        .flag-text { margin-left: 10px; }

        /* ************************************************************************* */

        @page {
            size: 210mm 297mm;
            margin: 0;
        }

        @media print {

            /* Print settings */
            body {
                margin-left: 0 !important;
            }

            page {
                width: 210mm;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }
            .print_page_number{
                right: -70 !important;
            }
            .no-overflow {
                overflow: hidden;
            }

            #Header,
            #Footer {
                display: none !important;
            }

            button {
                display: none;
            }

            size: A4 portrait;
            /* ... the rest of the rules ... */
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            #print_page{
                position: relative !important;
                top: -40px !important;
                width: auto !important;
                height: auto !important;
                overflow: visible !important;
                display: block !important;
            }
        }

        .a4-line {
            border-top: 1px dashed black;
            width: 100%;
        }

        /* #coin {
            width: 100px;
            height: 100px;
            animation: flip 2s infinite linear;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        @keyframes flip {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(360deg);
            }
        } */

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
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.11.1/css/flag-icons.min.css" /> -->

    <div id="slide" class="loaderslide"></div>

@section('content')
    <div class="justify-center items-center no-print">
        <div class="mt-9 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-1">
            <div class="flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Update Price</p>
            </div>
            <!-- <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                <div class="lg:col-span-4 xl:grid-cols-4">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        <div class="md:col-span-3">
                            <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                                <option value=""> --- กรุณาเลือก ---</option>
                            </select>
                        </div>
                        <div class="md:col-span-3" >
                            <label for="">ค้นหา</label>
                            <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
                        </div>
                    </div>
                </div>
            </div> -->

            <form method="POST" enctype="multipart/form-data" class="relative" id="importForm">
                @csrf

                <div class="w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 text-sm">
                        <div>
                            <label for="BRAND" class="block text-sm font-medium text-gray-900 dark:text-white mb-1">Brand</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                                <option value=""> --- กรุณาเลือก ---</option>
                            </select>
                        </div>
                        <div>
                            <label for="search" class="block text-sm text-gray-900 dark:text-white font-medium mb-1">ค้นหา</label>
                            <input type="text" name="search" id="search" 
                                class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" 
                                placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." onkeyup="searchTable()" />
                        </div>
                        <div>
                            <label for="file1" class="block text-sm text-gray-900 dark:text-white font-medium mb-1">เลือกไฟล์</label>
                            <input type="file" name="file" id="file1" class="form-control w-full h-8 mt-1">
                        </div>
                        <div>
                            <label for="file1" class="block text-sm text-gray-900 dark:text-white font-medium mb-1.5">กด Import ไฟล์</label>
                            <a id="importBtn"
                                class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-2.5 py-2 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group">

                                <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-7 w-7 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/>
                                    <path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                                    <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                                    <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                                </svg>
                                Import
                            </a>
                        </div>
                    </div>
                </div>

                <!-- <div class="grid gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="lg:col-span-4 xl:grid-cols-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-12">
                            <div class="md:col-span-3">
                                <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND" onchange="brandSearch()">
                                    <option value=""> --- กรุณาเลือก ---</option>
                                </select>
                            </div>
                            <div class="md:col-span-3" >
                                <label for="">ค้นหา</label>
                                <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
                            </div>
                            <div class="md:col-span-3" >
                                <label for="">เลือกไฟล์</label>
                                <input type="file" name="file" class="form-control" style="height: 32px; margin-top: 3px;">
                            </div>
                            <div class="md:col-span-3" >
                                <label for="">เลือกไฟล์</label>
                                <input type="file" name="file" class="form-control" style="height: 32px; margin-top: 3px;">
                            </div>
                            <div class="md:col-span-1" >
                                <a
                                    onclick="confirmUpdate()" type="button"
                                    class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="add" id="add">

                                    <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-7 w-7 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/>
                                        <path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                                        <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                                        <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                                    </svg>
                                    Import
                                </a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- <button class="fa-solid far fa-file-excel btn btn-dark"> Import</button> -->
                <!-- <div>
                    <a
                        onclick="confirmUpdate()" type="button"
                        class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="add" id="add">

                        <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-7 w-7 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/>
                            <path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                            <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                            <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                        </svg>
                        Import
                    </a>
                </div> -->
            </form>
        </div>
            <!-- <div class="fixed flex bottom-4 right-5 z-10">
                <a
                    type="button"
                    class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-3 px-3 mr-2 mt-20 rounded-full group"
                >
                <svg viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="hidden h-7 w-7 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/>
                    <path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                    <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                    <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                </svg>
                </a>
            </div> -->

        <ul class="pt-1 mt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>
        
        <div class="flex xs:right-12 sm:right-12 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-3">
            <a
                onclick="fetchAllProducts()" type="button"
                class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group" name="add" id="add">

                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg> -->

                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                    viewBox="0 0 291.764 291.764" xml:space="preserve">
                    <g>
                        <path style="fill:#F4B459;" d="M145.882,0c80.573,0,145.882,65.319,145.882,145.882s-65.31,145.882-145.882,145.882
                            S0,226.446,0,145.882S65.31,0,145.882,0z"/>
                        <path style="fill:#D07C40;" d="M145.882,27.399c-65.465,0-118.529,53.065-118.529,118.529s53.065,118.529,118.529,118.529 s118.529-53.065,118.529-118.529S211.347,27.399,145.882,27.399z M145.882,246.231c-55.39,0-100.294-44.914-100.294-100.294
                            c0-55.39,44.904-100.294,100.294-100.294s100.294,44.904,100.294,100.294C246.176,201.318,201.272,246.231,145.882,246.231z M174.63,141.187c6.738-3.483,10.969-9.601,9.984-19.804c-1.331-13.941-14.369-18.618-29.395-19.949l-0.009-19.329h-9.355v18.828
                            l-9.3,0.128V82.104h-9.063v19.329c-2.516,0.055-8.698,0.109-11.124,0.109v-0.064l-16.056-0.009v12.573c0,0,12.008-0.164,11.88,0 c4.714,0,6.255,2.772,6.683,5.161l0.009,22.028l1.231,0.082h-1.231v30.863c-0.201,1.504-1.076,3.902-4.367,3.911
                            c0.146,0.137-11.889,0-11.889,0l-2.316,14.05h15.144l12.017,0.073l0.009,19.566h8.78l-0.009-19.357 c3.209,0.073,6.282,0.109,9.309,0.1v19.256h10.212v-19.53c19.566-1.131,33.836-6.118,35.541-24.709
                            C192.701,150.56,185.736,143.886,174.63,141.187z M135.698,114.891c6.574,0,27.216-2.115,27.216,11.762 c0,13.294-20.642,11.753-27.216,11.753V114.891z M135.698,176.162V150.25c7.896,0,32.632-2.289,32.632,12.956
                            C168.33,177.831,143.594,176.162,135.698,176.162z"/>
                    </g>
                </svg>
                อัปเดตราคา
            </a>
        </div>

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="import_price_table" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>brand</th>
                            <th>product</th>
                            <th>cost</th>
                            <th>start_date</th>
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
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>

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

        $('#importBtn').on('click', function (e) {
            e.preventDefault();
            let dlayMessage = 1000; // หรือกำหนดตามที่ใช้
            let form = $('#importForm')[0];
            let formData = new FormData(form);

            $.ajax({
                method: "POST",
                url: "{{ route('manage_price.users.import') }}", // เปลี่ยนตาม route จริง
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (res) {
                    setTimeout(function () {
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
                        toastr.success("อัปโหลดราคาสำเร็จ");
                        $('#import_price_table').DataTable().ajax.reload(); // 👈 reload table
                    }, dlayMessage);

                    setTimeout(function () {
                        $('#file1').val('');
                        $('#brand_id').val('').change();
                    }, dlayMessage);
                },
                error: function (err) {
                    setTimeout(function () {
                        errorMessage("เพิ่มข้อมูลไม่สำเร็จ");
                    }, dlayMessage);

                    setTimeout(function () {
                        toastr.error("❌ Import ไม่สำเร็จ!");
                    }, dlayMessage);
                }
            });
        });

        let selectedProducts = [];

        function fetchAllProducts() {
            console.log("🔔 เรียก fetchAllProducts แล้ว");
            $.ajax({
                url: '{{ route("manage_price.list_price_all") }}', // Route แยกต่างหาก
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    brand_id: $('#brand_id').val(),
                    search: $('#search').val()
                },
                success: function(res) {
                    selectedProducts = res.data;
                    console.log("🚀 ~ fetchAllProducts ~ selectedProducts:", selectedProducts)
                    confirmUpdate(); // เรียก SweetAlert ต่อได้เลย
                },
                error: function(err) {
                    console.error("โหลดข้อมูลทั้งหมดไม่สำเร็จ", err);
                }
            });
        }
        
        const mytableDatatable = $('#import_price_table').DataTable({
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

                "url": "{{ route('manage_price.list_import_excel') }}",
                "type": "POST",
                'data': function(data) {
                    data.search = $('#search').val();
                    console.log("Sending Search: ", data.search); // Debug
                    data._token = $('meta[name="csrf-token"]').attr('content');
                },
                dataSrc: function(json) {
                    selectedProducts = json.data;
                    return json.data;
                },
                "error": function(xhr, error, thrown) {
                    console.log("AJAX Error: ", error, thrown);
                    console.log(xhr.responseText); // Debug error
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.brand;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.product;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.cost;
                    }
                },
                // {
                //     targets: 3,
                //     orderable: true,
                //     render: function(data, type, row) {
                //         return row.price;
                //     }
                // },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.start_date;
                    }
                }
            ]
        });

        const lines = [
            "     คำเตือน",
            "การ Update ราคาสินค้า",
            "จะไม่สามารถกู้คืนราคาสินค้าเก่าได้",
            "✅ จำนวนสินค้าทั้งหมด: " + selectedProducts.length + " รายการ",
            '',
            "🚀 ChatGPT(Product Master) V. 1.04.1",
        ];

        let currentLine = 0;
        let currentChar = 0;
        let message = '';

        function typeNextCharSwal() {
            if (currentLine >= lines.length) {
                Swal.update({
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, อัปเดต!',
                    cancelButtonText: 'ยกเลิก'
                });
                return;
            }

            const line = lines[currentLine];

            if (currentChar < line.length) {
                message += line[currentChar];
                currentChar++;

                Swal.update({
                    html:`
                        <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                            <div class="coin-wrapper">
                                <div id="coin">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 291.764 291.764" width="60" height="60">
                                        <g>
                                        <path style="fill:#F4B459;" d="M145.882,0c80.573,0,145.882,65.319,145.882,145.882s-65.31,145.882-145.882,145.882
                                            S0,226.446,0,145.882S65.31,0,145.882,0z"/>
                                        <path style="fill:#D07C40;" d="M145.882,27.399c-65.465,0-118.529,53.065-118.529,118.529s53.065,118.529,118.529,118.529
                                            s118.529-53.065,118.529-118.529S211.347,27.399,145.882,27.399z M145.882,246.231c-55.39,0-100.294-44.914-100.294-100.294
                                            c0-55.39,44.904-100.294,100.294-100.294s100.294,44.904,100.294,100.294
                                            C246.176,201.318,201.272,246.231,145.882,246.231z M174.63,141.187c6.738-3.483,10.969-9.601,9.984-19.804
                                            c-1.331-13.941-14.369-18.618-29.395-19.949l-0.009-19.329h-9.355v18.828l-9.3,0.128V82.104h-9.063v19.329
                                            c-2.516,0.055-8.698,0.109-11.124,0.109v-0.064l-16.056-0.009v12.573c0,0,12.008-0.164,11.88,0
                                            c4.714,0,6.255,2.772,6.683,5.161l0.009,22.028l1.231,0.082h-1.231v30.863c-0.201,1.504-1.076,3.902-4.367,3.911
                                            c0.146,0.137-11.889,0-11.889,0l-2.316,14.05h15.144l12.017,0.073l0.009,19.566h8.78l-0.009-19.357
                                            c3.209,0.073,6.282,0.109,9.309,0.1v19.256h10.212v-19.53c19.566-1.131,33.836-6.118,35.541-24.709
                                            C192.701,150.56,185.736,143.886,174.63,141.187z M135.698,114.891c6.574,0,27.216-2.115,27.216,11.762
                                            c0,13.294-20.642,11.753-27.216,11.753V114.891z M135.698,176.162V150.25c7.896,0,32.632-2.289,32.632,12.956
                                            C168.33,177.831,143.594,176.162,135.698,176.162z"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <pre style="text-align: left; white-space: pre-line; color:#ffffff;">${message}</pre>
                    `
                });
                setTimeout(typeNextCharSwal, 50);
            } else {
                message += '\n';
                currentLine++;
                currentChar = 0;
                setTimeout(typeNextCharSwal, 300);
            }
        }

        function confirmUpdate() {
            // รีเซ็ต
            message = '';
            currentLine = 0;
            currentChar = 0;

            // update ค่าที่แสดงใน SweetAlert
            lines[3] = "✅ จำนวนสินค้าทั้งหมด: " + selectedProducts.length + " รายการ";

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่จะให้ AI อัปเดตราคาสินค้า?',
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#303030',
                cancelButtonColor: '#e13636',
                color: "#ffffff",
                background: "#202020",
                didOpen: () => {
                    typeNextCharSwal();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    saveUpdate();
                }
            });
        }

        function saveUpdate() {
            // Swal.fire('กำลังอัปเดต...', '', 'info');
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 animate-spin dark:text-black">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                        <pre style="text-align: center; white-space: pre-line; color:#000000;">กำลังอัปเดต...</pre>
                    </div>
                `,
                showConfirmButton: false,
                background: '#e4e4e4e3',  // 🔴 ใช้ตรงนี้สำหรับพื้นหลัง popup
                backdrop: 'rgba(0, 0, 0, 0.2)', // พื้นหลังมืดบาง ๆ
                customClass: {
                    popup: 'p-0 m-0 flex items-center justify-center rounded-none shadow-none w-screen h-screen',
                    container: 'p-0 m-0',
                    htmlContainer: 'w-full flex items-center justify-center',
                },
                didOpen: () => {
                    // 👇 รอ 1.5 วิแล้วค่อยทำงานต่อ
                    setTimeout(() => {
                        Swal.close(); // หรือจะเปลี่ยนเป็นอีก Swal.fire(), redirect หรือ logic อื่นก็ได้
                    }, 2000);
                }
            });
            $.ajax({
                url: '{{ route("manage_price.update") }}', // ✅ ใช้ชื่อ route ที่ประกาศไว้
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    products: selectedProducts
                },
                success: function(response) {
                    setTimeout(function () {
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
                        toastr.success("อัปเดทราคาสำเร็จ");
                        $('#import_price_table').DataTable().ajax.reload(); // 👈 reload table
                    }, 2000);
                },
                error: function() {
                    // Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการอัปเดต', 'error');
                    Swal.fire({
                        title: 'ผิดพลาด!', 
                        html:`
                            <pre style="text-align: center; white-space: pre-line; color:#ffffff;">เกิดข้อผิดพลาดในการอัปเดต</pre>
                        `,
                        icon: 'error',
                        color: "#ffffff",
                        background: "#202020",
                    });
                }
            });
        }

    </script>
@endsection
