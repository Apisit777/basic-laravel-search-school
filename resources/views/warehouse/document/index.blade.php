
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

    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.11.1/css/flag-icons.min.css" />

    <div id="slide" class="loaderslide"></div>

@section('content')
    <div class="justify-center items-center no-print">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_master_list')</p>
        </div>
        <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND">
                            <option value=""> --- กรุณาเลือก ---</option>
                        </select>
                    </div>
                    <div class="md:col-span-3" >
                        <label for="">ค้นหา</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
                    </div>
                    <div class="md:col-span-3" >
                        <select name="country"></select>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>
        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="product_master_table" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>แบรนด์</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื้อสินค้า</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="bg-white rounded shadow-lg duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div id="print_page">
                <div class="md:col-span-6 text-right mt-4 no-print">
                    <div class="inline-flex items-end">
                        <a href="{{ route('new_product_develop.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg> -->

                            <svg fill="#fff" class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 26.676 26.676" xml:space="preserve">
                                <g>
                                    <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59
                                        c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815
                                        C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029
                                        c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562
                                        C26.18,21.891,26.141,21.891,26.105,21.891z"/>
                                    <g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                </g>
                            </svg>
                            Back
                        </a>
                        <a type="button" onclick="myFunction()" class="cursor-pointer text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve"
                                class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <rect x="153.361" y="65.14" style="fill:#FFFFFF;" width="205.278" height="95.191"/>
                                <path style="fill:#1E0478;" d="M512,144.296v172.838c0,19.889-16.176,36.066-36.066,36.066h-95.582v104.517
                                    c0,5.993-4.864,10.857-10.857,10.857H142.504c-5.993,0-10.857-4.864-10.857-10.857V353.2H36.066C16.176,353.2,0,337.023,0,317.134
                                    V144.296c0-19.889,16.176-36.066,36.066-36.066h95.582V54.283c0-5.993,4.864-10.857,10.857-10.857h226.991
                                    c5.993,0,10.857,4.864,10.857,10.857v53.947h95.582C495.824,108.23,512,124.406,512,144.296z M490.287,317.134V144.296
                                    c0-7.915-6.438-14.353-14.353-14.353h-47.976v41.244c0,5.993-4.864,10.857-10.857,10.857H94.898
                                    c-5.993,0-10.857-4.864-10.857-10.857v-41.244H36.066c-7.915,0-14.353,6.438-14.353,14.353v172.838
                                    c0,7.915,6.438,14.353,14.353,14.353h95.582v-27.608h-19.803c-5.993,0-10.857-4.864-10.857-10.857s4.864-10.857,10.857-10.857
                                    h30.659h226.991h30.659c5.993,0,10.857,4.864,10.857,10.857s-4.864,10.857-10.857,10.857h-19.803v27.608h95.582
                                    C483.849,331.486,490.287,325.048,490.287,317.134z M406.245,160.331v-30.388h-25.893v30.388H406.245z M358.639,446.86V303.878
                                    H153.361V446.86L358.639,446.86L358.639,446.86z M358.639,160.331V65.14H153.361v95.191H358.639z M131.648,160.331v-30.388h-25.893
                                    v30.388H131.648z"/>
                                <path style="fill:#9B8CCC;" d="M490.287,144.296v172.838c0,7.915-6.438,14.353-14.353,14.353h-95.582v-27.608h19.803
                                    c5.993,0,10.857-4.864,10.857-10.857s-4.864-10.857-10.857-10.857h-30.659H142.504h-30.659c-5.993,0-10.857,4.864-10.857,10.857
                                    s4.864,10.857,10.857,10.857h19.803v27.608H36.066c-7.915,0-14.353-6.438-14.353-14.353V144.296c0-7.915,6.438-14.353,14.353-14.353
                                    h47.976v41.244c0,5.993,4.864,10.857,10.857,10.857h322.204c5.993,0,10.857-4.864,10.857-10.857v-41.244h47.976
                                    C483.849,129.943,490.287,136.381,490.287,144.296z M82.391,219.261c0-7.513-6.08-13.603-13.593-13.603s-13.603,6.091-13.603,13.603
                                    s6.091,13.603,13.603,13.603C76.311,232.864,82.391,226.774,82.391,219.261z"/>
                                <rect x="380.352" y="129.943" style="fill:#6F7CCD;" width="25.893" height="30.388"/>
                                <path style="fill:#94E7EF;" d="M358.639,303.878V446.86H153.361V303.878H358.639z M320.684,342.343
                                    c0-6.004-4.853-10.857-10.857-10.857H202.173c-6.004,0-10.857,4.853-10.857,10.857c0,5.993,4.853,10.857,10.857,10.857h107.655
                                    C315.831,353.2,320.684,348.336,320.684,342.343z M263.708,397.31c0-5.993-4.864-10.857-10.857-10.857h-50.679
                                    c-6.004,0-10.857,4.864-10.857,10.857s4.853,10.857,10.857,10.857h50.679C258.844,408.167,263.708,403.303,263.708,397.31z"/>
                                <g>
                                    <path style="fill:#1E0478;" d="M309.827,331.486c6.004,0,10.857,4.853,10.857,10.857c0,5.993-4.853,10.857-10.857,10.857H202.173
                                        c-6.004,0-10.857-4.864-10.857-10.857c0-6.004,4.853-10.857,10.857-10.857H309.827z"/>
                                    <path style="fill:#1E0478;" d="M252.852,386.454c5.993,0,10.857,4.864,10.857,10.857s-4.864,10.857-10.857,10.857h-50.679
                                        c-6.004,0-10.857-4.864-10.857-10.857s4.853-10.857,10.857-10.857H252.852z"/>
                                </g>
                                <rect x="105.755" y="129.943" style="fill:#6F7CCD;" width="25.893" height="30.388"/>
                                <path style="fill:#1E0478;" d="M68.799,205.658c7.513,0,13.593,6.091,13.593,13.603s-6.08,13.603-13.593,13.603
                                    s-13.603-6.091-13.603-13.603S61.286,205.658,68.799,205.658z"/>
                            </svg>
                            Print
                        </a>
                    </div>
                </div>
                <ul class="m-1 font-medium border-t border-2 border-black"></ul>

                <div class="flex justify-between ...">
                    <span class="m-1 text-xl font-semibold text-black" style="font-size: 20px;">New Product Development Project Brief</span>
                    {{-- <div style="margin-top: 2px; margin-right: 85px; margin-left: 50px;">
                        <img src="{{URL::asset('media/ibhs_img.png')}}">
                    </div> --}}
                </div>
                <div class="row m-1 text-black" style="">
                    <div class="col d-flex flex-row-reverse 2" style="margin-right: -80px;">
                        <div>
                            <div class="row font-semibold" style="width: 380px; margin-top: -10px;">
                                <div style="width: 100px">
                                    <span style="font-size: 14px;">
                                        Document No. :
                                    </span>
                                </div>
                                <div class="col" style="">
                                    <span style="font-size: 14px;">
                                        DOC_NO
                                    </span>
                                </div>
                            </div>
                            <div class="row font-semibold" style="margin-top: 21px;">
                                <div style="width: 250px;">
                                    <span style="font-size: 14px;">
                                        Customer & Product Requirements
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex flex-row-reverse 2" style="width: 89px; margin-right: -50px;">
                        <div>
                            <div class="row" style="width: 264px; margin-top: 3px;">
                                <div style="width: 95px;">
                                    <span style="font-size: 14px;">
                                        Declared Date :
                                    </span>
                                </div>
                                <div class="col" style="width: 80px;">
                                    <span style="font-size: 14px;">
                                        Declared
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" style="width: 64px; margin-right: 170px;">
                        <div>
                            <div class="row text-start" style="width: 300px; margin-top: 3px;">
                                <div style="width: 250px;">
                                    <span style="font-size: 12px;">
                                        Institute of Beauty and Health Sciences Co.,Ltd.
                                    </span>
                                </div>
                                <div class="" style="width: 250px; margin-top: 12px;">
                                    <span style="font-size: 13px;">
                                        Tel : 02-3151074 Ext : 301 Fax : 02-7051573
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="m-1 font-medium border-t border-black border-dashed" style="border-top-width: 1px; width: 100%;"></ul>
                <ul class="m-1 font-medium a4-line"></ul>
            </div>
        </div>
    </div>

    {{-- <div class="mt-16 md:col-span-3" >
        <label for="">ค้นหา</label>
        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" onkeyup="searchTable()" />
    </div> --}}

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
    <script>

(function ($) {
  $(function () {
    var isoCountries = [
      {
        text: "Afghanistan",
        dial_code: "+93",
        id: "AF",
      },
      {
        text: "Aland Islands",
        dial_code: "+358",
        id: "AX",
      },
      {
        text: "Albania",
        dial_code: "+355",
        id: "AL",
      },
      {
        text: "Algeria",
        dial_code: "+213",
        id: "DZ",
      },
      {
        text: "AmericanSamoa",
        dial_code: "+1684",
        id: "AS",
      },
      {
        text: "Andorra",
        dial_code: "+376",
        id: "AD",
      },
      {
        text: "Angola",
        dial_code: "+244",
        id: "AO",
      },
      {
        text: "Anguilla",
        dial_code: "+1264",
        id: "AI",
      },
      {
        text: "Antarctica",
        dial_code: "+672",
        id: "AQ",
      },
      {
        text: "Antigua and Barbuda",
        dial_code: "+1268",
        id: "AG",
      },
      {
        text: "Argentina",
        dial_code: "+54",
        id: "AR",
      },
      {
        text: "Armenia",
        dial_code: "+374",
        id: "AM",
      },
      {
        text: "Aruba",
        dial_code: "+297",
        id: "AW",
      },
      {
        text: "Australia",
        dial_code: "+61",
        id: "AU",
      },
      {
        text: "Austria",
        dial_code: "+43",
        id: "AT",
      },
      {
        text: "Azerbaijan",
        dial_code: "+994",
        id: "AZ",
      },
      {
        text: "Bahamas",
        dial_code: "+1242",
        id: "BS",
      },
      {
        text: "Bahrain",
        dial_code: "+973",
        id: "BH",
      },
      {
        text: "Bangladesh",
        dial_code: "+880",
        id: "BD",
      },
      {
        text: "Barbados",
        dial_code: "+1246",
        id: "BB",
      },
      {
        text: "Belarus",
        dial_code: "+375",
        id: "BY",
      },
      {
        text: "Belgium",
        dial_code: "+32",
        id: "BE",
      },
      {
        text: "Belize",
        dial_code: "+501",
        id: "BZ",
      },
      {
        text: "Benin",
        dial_code: "+229",
        id: "BJ",
      },
      {
        text: "Bermuda",
        dial_code: "+1441",
        id: "BM",
      },
      {
        text: "Bhutan",
        dial_code: "+975",
        id: "BT",
      },
      {
        text: "Bolivia, Plurinational State of",
        dial_code: "+591",
        id: "BO",
      },
      {
        text: "Bosnia and Herzegovina",
        dial_code: "+387",
        id: "BA",
      },
      {
        text: "Botswana",
        dial_code: "+267",
        id: "BW",
      },
      {
        text: "Brazil",
        dial_code: "+55",
        id: "BR",
      },
      {
        text: "British Indian Ocean Territory",
        dial_code: "+246",
        id: "IO",
      },
      {
        text: "Brunei Darussalam",
        dial_code: "+673",
        id: "BN",
      },
      {
        text: "Bulgaria",
        dial_code: "+359",
        id: "BG",
      },
      {
        text: "Burkina Faso",
        dial_code: "+226",
        id: "BF",
      },
      {
        text: "Burundi",
        dial_code: "+257",
        id: "BI",
      },
      {
        text: "Cambodia",
        dial_code: "+855",
        id: "KH",
      },
      {
        text: "Cameroon",
        dial_code: "+237",
        id: "CM",
      },
      {
        text: "Canada",
        dial_code: "+1",
        id: "CA",
      },
      {
        text: "Cape Verde",
        dial_code: "+238",
        id: "CV",
      },
      {
        text: "Cayman Islands",
        dial_code: "+ 345",
        id: "KY",
      },
      {
        text: "Central African Republic",
        dial_code: "+236",
        id: "CF",
      },
      {
        text: "Chad",
        dial_code: "+235",
        id: "TD",
      },
      {
        text: "Chile",
        dial_code: "+56",
        id: "CL",
      },
      {
        text: "China",
        dial_code: "+86",
        id: "CN",
      },
      {
        text: "Christmas Island",
        dial_code: "+61",
        id: "CX",
      },
      {
        text: "Cocos (Keeling) Islands",
        dial_code: "+61",
        id: "CC",
      },
      {
        text: "Colombia",
        dial_code: "+57",
        id: "CO",
      },
      {
        text: "Comoros",
        dial_code: "+269",
        id: "KM",
      },
      {
        text: "Congo",
        dial_code: "+242",
        id: "CG",
      },
      {
        text: "Congo, The Democratic Republic of the Congo",
        dial_code: "+243",
        id: "CD",
      },
      {
        text: "Cook Islands",
        dial_code: "+682",
        id: "CK",
      },
      {
        text: "Costa Rica",
        dial_code: "+506",
        id: "CR",
      },
      {
        text: "Cote d'Ivoire",
        dial_code: "+225",
        id: "CI",
      },
      {
        text: "Croatia",
        dial_code: "+385",
        id: "HR",
      },
      {
        text: "Cuba",
        dial_code: "+53",
        id: "CU",
      },
      {
        text: "Cyprus",
        dial_code: "+357",
        id: "CY",
      },
      {
        text: "Czech Republic",
        dial_code: "+420",
        id: "CZ",
      },
      {
        text: "Denmark",
        dial_code: "+45",
        id: "DK",
      },
      {
        text: "Djibouti",
        dial_code: "+253",
        id: "DJ",
      },
      {
        text: "Dominica",
        dial_code: "+1767",
        id: "DM",
      },
      {
        text: "Dominican Republic",
        dial_code: "+1849",
        id: "DO",
      },
      {
        text: "Ecuador",
        dial_code: "+593",
        id: "EC",
      },
      {
        text: "Egypt",
        dial_code: "+20",
        id: "EG",
      },
      {
        text: "El Salvador",
        dial_code: "+503",
        id: "SV",
      },
      {
        text: "Equatorial Guinea",
        dial_code: "+240",
        id: "GQ",
      },
      {
        text: "Eritrea",
        dial_code: "+291",
        id: "ER",
      },
      {
        text: "Estonia",
        dial_code: "+372",
        id: "EE",
      },
      {
        text: "Ethiopia",
        dial_code: "+251",
        id: "ET",
      },
      {
        text: "Falkland Islands (Malvinas)",
        dial_code: "+500",
        id: "FK",
      },
      {
        text: "Faroe Islands",
        dial_code: "+298",
        id: "FO",
      },
      {
        text: "Fiji",
        dial_code: "+679",
        id: "FJ",
      },
      {
        text: "Finland",
        dial_code: "+358",
        id: "FI",
      },
      {
        text: "France",
        dial_code: "+33",
        id: "FR",
      },
      {
        text: "French Guiana",
        dial_code: "+594",
        id: "GF",
      },
      {
        text: "French Polynesia",
        dial_code: "+689",
        id: "PF",
      },
      {
        text: "Gabon",
        dial_code: "+241",
        id: "GA",
      },
      {
        text: "Gambia",
        dial_code: "+220",
        id: "GM",
      },
      {
        text: "Georgia",
        dial_code: "+995",
        id: "GE",
      },
      {
        text: "Germany",
        dial_code: "+49",
        id: "DE",
      },
      {
        text: "Ghana",
        dial_code: "+233",
        id: "GH",
      },
      {
        text: "Gibraltar",
        dial_code: "+350",
        id: "GI",
      },
      {
        text: "Greece",
        dial_code: "+30",
        id: "GR",
      },
      {
        text: "Greenland",
        dial_code: "+299",
        id: "GL",
      },
      {
        text: "Grenada",
        dial_code: "+1473",
        id: "GD",
      },
      {
        text: "Guadeloupe",
        dial_code: "+590",
        id: "GP",
      },
      {
        text: "Guam",
        dial_code: "+1671",
        id: "GU",
      },
      {
        text: "Guatemala",
        dial_code: "+502",
        id: "GT",
      },
      {
        text: "Guernsey",
        dial_code: "+44",
        id: "GG",
      },
      {
        text: "Guinea",
        dial_code: "+224",
        id: "GN",
      },
      {
        text: "Guinea-Bissau",
        dial_code: "+245",
        id: "GW",
      },
      {
        text: "Guyana",
        dial_code: "+595",
        id: "GY",
      },
      {
        text: "Haiti",
        dial_code: "+509",
        id: "HT",
      },
      {
        text: "Holy See (Vatican City State)",
        dial_code: "+379",
        id: "VA",
      },
      {
        text: "Honduras",
        dial_code: "+504",
        id: "HN",
      },
      {
        text: "Hong Kong",
        dial_code: "+852",
        id: "HK",
      },
      {
        text: "Hungary",
        dial_code: "+36",
        id: "HU",
      },
      {
        text: "Iceland",
        dial_code: "+354",
        id: "IS",
      },
      {
        text: "India",
        dial_code: "+91",
        id: "IN",
      },
      {
        text: "Indonesia",
        dial_code: "+62",
        id: "ID",
      },
      {
        text: "Iran, Islamic Republic of Persian Gulf",
        dial_code: "+98",
        id: "IR",
      },
      {
        text: "Iraq",
        dial_code: "+964",
        id: "IQ",
      },
      {
        text: "Ireland",
        dial_code: "+353",
        id: "IE",
      },
      {
        text: "Isle of Man",
        dial_code: "+44",
        id: "IM",
      },
      {
        text: "Israel",
        dial_code: "+972",
        id: "IL",
      },
      {
        text: "Italy",
        dial_code: "+39",
        id: "IT",
      },
      {
        text: "Jamaica",
        dial_code: "+1876",
        id: "JM",
      },
      {
        text: "Japan",
        dial_code: "+81",
        id: "JP",
      },
      {
        text: "Jersey",
        dial_code: "+44",
        id: "JE",
      },
      {
        text: "Jordan",
        dial_code: "+962",
        id: "JO",
      },
      {
        text: "Kazakhstan",
        dial_code: "+77",
        id: "KZ",
      },
      {
        text: "Kenya",
        dial_code: "+254",
        id: "KE",
      },
      {
        text: "Kiribati",
        dial_code: "+686",
        id: "KI",
      },
      {
        text: "Korea, Democratic People's Republic of Korea",
        dial_code: "+850",
        id: "KP",
      },
      {
        text: "Korea, Republic of South Korea",
        dial_code: "+82",
        id: "KR",
      },
      {
        text: "Kuwait",
        dial_code: "+965",
        id: "KW",
      },
      {
        text: "Kyrgyzstan",
        dial_code: "+996",
        id: "KG",
      },
      {
        text: "Laos",
        dial_code: "+856",
        id: "LA",
      },
      {
        text: "Latvia",
        dial_code: "+371",
        id: "LV",
      },
      {
        text: "Lebanon",
        dial_code: "+961",
        id: "LB",
      },
      {
        text: "Lesotho",
        dial_code: "+266",
        id: "LS",
      },
      {
        text: "Liberia",
        dial_code: "+231",
        id: "LR",
      },
      {
        text: "Libyan Arab Jamahiriya",
        dial_code: "+218",
        id: "LY",
      },
      {
        text: "Liechtenstein",
        dial_code: "+423",
        id: "LI",
      },
      {
        text: "Lithuania",
        dial_code: "+370",
        id: "LT",
      },
      {
        text: "Luxembourg",
        dial_code: "+352",
        id: "LU",
      },
      {
        text: "Macao",
        dial_code: "+853",
        id: "MO",
      },
      {
        text: "Macedonia",
        dial_code: "+389",
        id: "MK",
      },
      {
        text: "Madagascar",
        dial_code: "+261",
        id: "MG",
      },
      {
        text: "Malawi",
        dial_code: "+265",
        id: "MW",
      },
      {
        text: "Malaysia",
        dial_code: "+60",
        id: "MY",
      },
      {
        text: "Maldives",
        dial_code: "+960",
        id: "MV",
      },
      {
        text: "Mali",
        dial_code: "+223",
        id: "ML",
      },
      {
        text: "Malta",
        dial_code: "+356",
        id: "MT",
      },
      {
        text: "Marshall Islands",
        dial_code: "+692",
        id: "MH",
      },
      {
        text: "Martinique",
        dial_code: "+596",
        id: "MQ",
      },
      {
        text: "Mauritania",
        dial_code: "+222",
        id: "MR",
      },
      {
        text: "Mauritius",
        dial_code: "+230",
        id: "MU",
      },
      {
        text: "Mayotte",
        dial_code: "+262",
        id: "YT",
      },
      {
        text: "Mexico",
        dial_code: "+52",
        id: "MX",
      },
      {
        text: "Micronesia, Federated States of Micronesia",
        dial_code: "+691",
        id: "FM",
      },
      {
        text: "Moldova",
        dial_code: "+373",
        id: "MD",
      },
      {
        text: "Monaco",
        dial_code: "+377",
        id: "MC",
      },
      {
        text: "Mongolia",
        dial_code: "+976",
        id: "MN",
      },
      {
        text: "Montenegro",
        dial_code: "+382",
        id: "ME",
      },
      {
        text: "Montserrat",
        dial_code: "+1664",
        id: "MS",
      },
      {
        text: "Morocco",
        dial_code: "+212",
        id: "MA",
      },
      {
        text: "Mozambique",
        dial_code: "+258",
        id: "MZ",
      },
      {
        text: "Myanmar",
        dial_code: "+95",
        id: "MM",
      },
      {
        text: "Namibia",
        dial_code: "+264",
        id: "NA",
      },
      {
        text: "Nauru",
        dial_code: "+674",
        id: "NR",
      },
      {
        text: "Nepal",
        dial_code: "+977",
        id: "NP",
      },
      {
        text: "Netherlands",
        dial_code: "+31",
        id: "NL",
      },
      {
        text: "Netherlands Antilles",
        dial_code: "+599",
        id: "AN",
      },
      {
        text: "New Caledonia",
        dial_code: "+687",
        id: "NC",
      },
      {
        text: "New Zealand",
        dial_code: "+64",
        id: "NZ",
      },
      {
        text: "Nicaragua",
        dial_code: "+505",
        id: "NI",
      },
      {
        text: "Niger",
        dial_code: "+227",
        id: "NE",
      },
      {
        text: "Nigeria",
        dial_code: "+234",
        id: "NG",
      },
      {
        text: "Niue",
        dial_code: "+683",
        id: "NU",
      },
      {
        text: "Norfolk Island",
        dial_code: "+672",
        id: "NF",
      },
      {
        text: "Northern Mariana Islands",
        dial_code: "+1670",
        id: "MP",
      },
      {
        text: "Norway",
        dial_code: "+47",
        id: "NO",
      },
      {
        text: "Oman",
        dial_code: "+968",
        id: "OM",
      },
      {
        text: "Pakistan",
        dial_code: "+92",
        id: "PK",
      },
      {
        text: "Palau",
        dial_code: "+680",
        id: "PW",
      },
      {
        text: "Palestinian Territory, Occupied",
        dial_code: "+970",
        id: "PS",
      },
      {
        text: "Panama",
        dial_code: "+507",
        id: "PA",
      },
      {
        text: "Papua New Guinea",
        dial_code: "+675",
        id: "PG",
      },
      {
        text: "Paraguay",
        dial_code: "+595",
        id: "PY",
      },
      {
        text: "Peru",
        dial_code: "+51",
        id: "PE",
      },
      {
        text: "Philippines",
        dial_code: "+63",
        id: "PH",
      },
      {
        text: "Pitcairn",
        dial_code: "+872",
        id: "PN",
      },
      {
        text: "Poland",
        dial_code: "+48",
        id: "PL",
      },
      {
        text: "Portugal",
        dial_code: "+351",
        id: "PT",
      },
      {
        text: "Puerto Rico",
        dial_code: "+1939",
        id: "PR",
      },
      {
        text: "Qatar",
        dial_code: "+974",
        id: "QA",
      },
      {
        text: "Romania",
        dial_code: "+40",
        id: "RO",
      },
      {
        text: "Russia",
        dial_code: "+7",
        id: "RU",
      },
      {
        text: "Rwanda",
        dial_code: "+250",
        id: "RW",
      },
      {
        text: "Reunion",
        dial_code: "+262",
        id: "RE",
      },
      {
        text: "Saint Barthelemy",
        dial_code: "+590",
        id: "BL",
      },
      {
        text: "Saint Helena, Ascension and Tristan Da Cunha",
        dial_code: "+290",
        id: "SH",
      },
      {
        text: "Saint Kitts and Nevis",
        dial_code: "+1869",
        id: "KN",
      },
      {
        text: "Saint Lucia",
        dial_code: "+1758",
        id: "LC",
      },
      {
        text: "Saint Martin",
        dial_code: "+590",
        id: "MF",
      },
      {
        text: "Saint Pierre and Miquelon",
        dial_code: "+508",
        id: "PM",
      },
      {
        text: "Saint Vincent and the Grenadines",
        dial_code: "+1784",
        id: "VC",
      },
      {
        text: "Samoa",
        dial_code: "+685",
        id: "WS",
      },
      {
        text: "San Marino",
        dial_code: "+378",
        id: "SM",
      },
      {
        text: "Sao Tome and Principe",
        dial_code: "+239",
        id: "ST",
      },
      {
        text: "Saudi Arabia",
        dial_code: "+966",
        id: "SA",
      },
      {
        text: "Senegal",
        dial_code: "+221",
        id: "SN",
      },
      {
        text: "Serbia",
        dial_code: "+381",
        id: "RS",
      },
      {
        text: "Seychelles",
        dial_code: "+248",
        id: "SC",
      },
      {
        text: "Sierra Leone",
        dial_code: "+232",
        id: "SL",
      },
      {
        text: "Singapore",
        dial_code: "+65",
        id: "SG",
      },
      {
        text: "Slovakia",
        dial_code: "+421",
        id: "SK",
      },
      {
        text: "Slovenia",
        dial_code: "+386",
        id: "SI",
      },
      {
        text: "Solomon Islands",
        dial_code: "+677",
        id: "SB",
      },
      {
        text: "Somalia",
        dial_code: "+252",
        id: "SO",
      },
      {
        text: "South Africa",
        dial_code: "+27",
        id: "ZA",
      },
      {
        text: "South Sudan",
        dial_code: "+211",
        id: "SS",
      },
      {
        text: "South Georgia and the South Sandwich Islands",
        dial_code: "+500",
        id: "GS",
      },
      {
        text: "Spain",
        dial_code: "+34",
        id: "ES",
      },
      {
        text: "Sri Lanka",
        dial_code: "+94",
        id: "LK",
      },
      {
        text: "Sudan",
        dial_code: "+249",
        id: "SD",
      },
      {
        text: "Suriname",
        dial_code: "+597",
        id: "SR",
      },
      {
        text: "Svalbard and Jan Mayen",
        dial_code: "+47",
        id: "SJ",
      },
      {
        text: "Swaziland",
        dial_code: "+268",
        id: "SZ",
      },
      {
        text: "Sweden",
        dial_code: "+46",
        id: "SE",
      },
      {
        text: "Switzerland",
        dial_code: "+41",
        id: "CH",
      },
      {
        text: "Syrian Arab Republic",
        dial_code: "+963",
        id: "SY",
      },
      {
        text: "Taiwan",
        dial_code: "+886",
        id: "TW",
      },
      {
        text: "Tajikistan",
        dial_code: "+992",
        id: "TJ",
      },
      {
        text: "Tanzania, United Republic of Tanzania",
        dial_code: "+255",
        id: "TZ",
      },
      {
        text: "Thailand",
        dial_code: "+66",
        id: "TH",
      },
      {
        text: "Timor-Leste",
        dial_code: "+670",
        id: "TL",
      },
      {
        text: "Togo",
        dial_code: "+228",
        id: "TG",
      },
      {
        text: "Tokelau",
        dial_code: "+690",
        id: "TK",
      },
      {
        text: "Tonga",
        dial_code: "+676",
        id: "TO",
      },
      {
        text: "Trinidad and Tobago",
        dial_code: "+1868",
        id: "TT",
      },
      {
        text: "Tunisia",
        dial_code: "+216",
        id: "TN",
      },
      {
        text: "Turkey",
        dial_code: "+90",
        id: "TR",
      },
      {
        text: "Turkmenistan",
        dial_code: "+993",
        id: "TM",
      },
      {
        text: "Turks and Caicos Islands",
        dial_code: "+1649",
        id: "TC",
      },
      {
        text: "Tuvalu",
        dial_code: "+688",
        id: "TV",
      },
      {
        text: "Uganda",
        dial_code: "+256",
        id: "UG",
      },
      {
        text: "Ukraine",
        dial_code: "+380",
        id: "UA",
      },
      {
        text: "United Arab Emirates",
        dial_code: "+971",
        id: "AE",
      },
      {
        text: "United Kingdom",
        dial_code: "+44",
        id: "GB",
      },
      {
        text: "United States",
        dial_code: "+1",
        id: "US",
      },
      {
        text: "Uruguay",
        dial_code: "+598",
        id: "UY",
      },
      {
        text: "Uzbekistan",
        dial_code: "+998",
        id: "UZ",
      },
      {
        text: "Vanuatu",
        dial_code: "+678",
        id: "VU",
      },
      {
        text: "Venezuela, Bolivarian Republic of Venezuela",
        dial_code: "+58",
        id: "VE",
      },
      {
        text: "Vietnam",
        dial_code: "+84",
        id: "VN",
      },
      {
        text: "Virgin Islands, British",
        dial_code: "+1284",
        id: "VG",
      },
      {
        text: "Virgin Islands, U.S.",
        dial_code: "+1340",
        id: "VI",
      },
      {
        text: "Wallis and Futuna",
        dial_code: "+681",
        id: "WF",
      },
      {
        text: "Yemen",
        dial_code: "+967",
        id: "YE",
      },
      {
        text: "Zambia",
        dial_code: "+260",
        id: "ZM",
      },
      {
        text: "Zimbabwe",
        dial_code: "+263",
        id: "ZW",
      },
    ];

    function formatCountry(country) {
      if (!country.id) { return country.text; }
      var $country = $(
        '<span class="fi fi-' + country.id.toLowerCase() + '"></span>' +
        '<span class="flag-text">' + country.dial_code + "</span>"
      );
      return $country;
    };

    function formatTemplate(country) {
      if (!country.id) { return country.text; }
      var $country = $(
        '<span class="fi fi-' + country.id.toLowerCase() + '"></span>' +
        '<span class="flag-text">' + country.text + "</span>"
      );
      return $country;
    };

    $("[name='country']").select2({
        width: '100%',
        placeholder: "Select a country",
        templateResult: formatTemplate,
        templateSelection: formatCountry,
        data: isoCountries
    }).on('select2:open', function () {
        // ดึง element ของ dropdown
        $('.select2-results__options').hide().slideDown(250);
        }).on('select2:close', function () {
        $('.select2-results__options').slideUp(200);
    });


  });
})(jQuery);

function myFunction() {
window.print();
}

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        const mytableDatatable = $('#product_master_table').DataTable({
            searching: false,
            ordering: false,
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "All"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('product_master.list_products') }}",
                "type": "POST",
                'data': function(data) {
                    data.search = $('#search').val();
                    console.log("Sending Search: ", data.search); // Debug
                    data._token = $('meta[name="csrf-token"]').attr('content');
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
                        return row.NAME_THAI;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BARCODE;
                    }
                }
            ]
        });

        // Function สำหรับเรียกใช้ DataTable เมื่อมีการพิมพ์
        function searchTable() {
            console.log("Search: ", $('#search').val());
            // บังคับให้ DataTables รีโหลดข้อมูลใหม่
            mytableDatatable.ajax.reload(null, false);
        }

    </script>
@endsection
