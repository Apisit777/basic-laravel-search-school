@extends('layouts.layout')
@section('title', 'Inspection & deteils')

    <style>
        .answer { display:none }

        .table-sm td, .table-sm th {
            padding: 1rem!important;
        }
        .dual-listbox__search {
            display: none;
        }
        .dual-listbox .dual-listbox__container {
            display: flex;
            align-items: center;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
        .dual-listbox .dual-listbox__available, .dual-listbox .dual-listbox__selected {
            border: 1px solid #ddd;
            height: 225px!important;
            overflow-y: auto;
            padding: 0;
            width: 450px!important;
            /* width: 250%!important; */
            margin-top: 0;
            -webkit-margin-before: 0;
        }
        .dual-listbox .dual-listbox__title {
            padding: 15px 10px;
            font-size: 120%;
            font-weight: 700;
            border-left: 1px solid #efefef;
            border-right: 1px solid #efefef;
            border-top: 1px solid #efefef;
            margin-top: 1rem;
            -webkit-margin-before: 1rem;
            /* width: 250%; */
        }
        .dual-listbox .dual-listbox__button {
            margin-bottom: 5px;
            border: 0;
            background-color: #ddd;
            padding: 10px;
            color: #000000!important;
            cursor: pointer;
            justify-content: center;
            align-items: center;
        }
        .dual-listbox .dual-listbox__buttons {
            display: flex;
            flex-direction: column;
            margin: 25px 10px 0 10px!important;
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
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
        }
        select.select2:required + .select2-container .select2-selection--single {
            border-color: #FF0000;
        }

        select.select2:required:valid + .select2-container .select2-selection--single {
            border-color: black;
        }
        .select2:required {
            border-color: #FF0000;
        }

        .select2:required:valid {
            border-color: black;
        }
        .select2-container--default .select2-selection--multiple {
            height: 55%!important;
            min-height: 50%!important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 12px!important;
            padding-right: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 2rem!important;
        }
        .select2-container--default .select2-selection--single {
            height: 2rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 19px!important;
        }

        table.dataTable tbody td.select-checkbox:before, table.dataTable tbody td.select-checkbox:after, table.dataTable tbody th.select-checkbox:before, table.dataTable tbody th.select-checkbox:after {
            top: 1.5rem!important;
        }
        table.dataTable tr.selected td.select-checkbox:after, table.dataTable tr.selected th.select-checkbox:after {
            margin-top: -17px!important;
            margin-left: -9px!important;
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
        .btn-group > .btn-group:not(:last-child) > .btn, .btn-group > .btn:not(:last-child):not(.dropdown-toggle) {
            color: #fff !important;
            background: #1F2226 !important;
        }
        .btn-group > .btn-group:not(:first-child) > .btn, .btn-group > .btn:not(:first-child) {
            color: #fff !important;
            background: #1F2226 !important;
        }
        table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before {
            display: none!important;
        }
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none!important;
        }
        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
            left: 10px!important;
            margin-top: -14px!important;
        }
        /* table.dataTable tbody td.select-checkbox:before, table.dataTable tbody th.select-checkbox:before {
            margin-top: -14px!important;
        } */
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/check.min.css') }}" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dual-listbox/dist/dual-listbox.css">
    <!-- <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" /> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

@section('content')
    <div class="p-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">โปรโมชั่น</p>
            </div>
            <form class="" action="" method="POST" id="create_product_master">
                <div class='w-12/12 mt-4 relative'>
                    <div class="">
                        <div class="bg-gray-100 dark:bg-[#404040] mb-3">
                            <!-- <div class="p-2 grid grid-cols-6 mb-2 gap-2">
                                <label class="m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-start">รหัสโปรโมชั่น</label>
                                <input id="age" name="age" value="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />
                                <label class="col-span-0.5 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ช่วงเวลา</label>
                                <input id="" name="" value="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />
                                <label class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-100 rounded-sm text-sm text-center grid content-center justify-items-stretch">ชื่อโปรโมชั่น</label>
                                <input id="" name="" value="" class="col-span-1 m-0 p-0 text-gray-900 dark:text-gray-900 rounded-sm bg-[#E9ECEF] dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />
                            </div>
                            <div class="md:col-span-6">
                                <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">หมายเหตุ</label>
                                <textarea id="note" name="note" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->note ?? '' }}</textarea>
                            </div> -->
                            <div class="p-2 grid gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                <div class="lg:col-span-4">
                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                        <div class="md:col-span-2" style="position: relative;">
                                            <label for="COST">รหัสโปรโมชั่น</label>
                                            <input type="text" name="COST" id="COST" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                        <div class="md:col-span-2" style="position: relative;">
                                            <label for="sale_tp">ช่วงเวลา</label>
                                            <input type="text" name="daterange" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ date('m/d/Y') }} - {{ date('m/d/Y', strtotime('+1 month')) }}" />
                                        </div>
                                        <div class="md:col-span-2" style="position: relative;">
                                            <label for="cost_km">ชื่อโปรโมชั่น</label>
                                            <input type="text" name="cost_km" id="cost_km" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                    </div>
                                    <div class="md:col-span-6 mt-3">
                                        <label for="note" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">หมายเหตุ</label>
                                        <textarea id="note" name="note" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->note ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="pt-2.5 mb-1 space-y-2 border-t-2 border-gray-200 dark:border-gray-700"></ul>
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <li data-twe-stepper-step-ref="" class="relative">
                                <div class="grid grid-cols-5 gap-10">
                                    <div class="form col-span-5">
                                        <div class="relative w-full overflow-hidden peer-checked:hidden">
                                            <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                <h1 class="text-gray-900 dark:text-white text-lg">
                                                    เงื่อนไข
                                                </h1>
                                            </div>
                                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                                <div class="p-2 grid gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                    <div class="lg:col-span-4">
                                                        <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                            <div class="md:col-span-4 mt-3">
                                                                <label for="" class="mr-5">จำนวนซื้อ</label>
                                                                <input type="radio" name="PACKAGE_BOX" value="ชิ้น" />
                                                                <label for="" class="mr-5">ชิ้น</label>
                                                                <input type="radio" name="PACKAGE_BOX" value="บาท" checked />
                                                                <label for="" class="mr-5">บาท</label>
                                                                <input type="radio" name="PACKAGE_BOX" value="%" />
                                                                <label for="">เปอร์เซ็น</label>
                                                            </div>

                                                            <div class="md:col-span-6 mt-2">
                                                                <label for="OEM">เงื่อนไขพิเศษ</label>
                                                                <div class="md:col-span-4 mt-2">
                                                                    <fieldset class="question text-gray-900 dark:text-gray-100">
                                                                        <input id="coupon_question" type="checkbox" name="coupon_question" value="1" />
                                                                        <span class="item-text">สะสมบิล</span>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-600 relative"></ul>
                                                        <div class="answer">
                                                            <div>
                                                                <p>รายละเอียดเงื่อนไข</p>
                                                            </div>
                                                            <table class="table table-sm table-bordered text-gray-900 dark:text-gray-100 mt-2 relative" id="table">
                                                                <tr>
                                                                    <th class="text-sm">ยอดซื้อต้นค่า / จำนวนชิ้นที่ซื้อ</th>
                                                                    <th class="text-sm">ส่วนลด</th>
                                                                    <th class="text-sm">จำนวนของแถม</th>
                                                                    <th class="text-sm text-center">Action</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" name="inputs_submenu[0][inputs_submenu1]" id="inputs_submenu1" class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                        <span class="dynamic-text">บาท</span>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="inputs_submenu[0][inputs_submenu2]" id="inputs_submenu2" class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                        <span class="dynamic-text">บาท</span>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="inputs_submenu[0][inputs_submenu3]" id="inputs_submenu3" class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                        <span class="dynamic-text">บาท</span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="mt-1 px-2 py-1 text-xs tracking-wide bg-[#303030] hover:bg-[#303030] text-white rounded group" name="add" id="add">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                                                            </svg>
                                                                                แถวใหม่
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="pt-2.5 mt-3 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700"></ul>

                        <div class="row mt-1">
                            <div class="col-md-12">
                            <!-- Form Element sizes -->
                                <div class="card bg-gray-100 dark:bg-[#404040] mb-3">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <form>
                                                <div class="form-group row text-gray-900 dark:text-gray-100">
                                                    <div class="col-sm-4">
                                                        <label class="">กลุ่มสินค้า</label>
                                                        <div class="input-group ">
                                                            <input type="text" name="" id="" class="w-10/12 h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" placeholder="กลุ่มสินค้า" value="" />
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary btn-sm bg-gray-50 dark:bg-[#303030]"
                                                                    type="button" id=""
                                                                    data-twe-toggle="modal"
                                                                    data-twe-target="#exampleModalLg_product_group"
                                                                    data-twe-ripple-init
                                                                    data-twe-ripple-color="light"
                                                                >
                                                                    <i class="nav-icon fas fa-search"></i>
                                                                </button>
                                                            </div>

                                                            <section>
                                                                <!-- Modal -->
                                                                <div
                                                                    data-twe-modal-init
                                                                    class="data-twe-backdrop-show fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                                                                    id="exampleModalLg_product_group"
                                                                    data-twe-backdrop="static"
                                                                    data-twe-keyboard="false"
                                                                    tabindex="-1"
                                                                    aria-labelledby="exampleModalLgLabel"
                                                                    aria-hidden="true"
                                                                >
                                                                    <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px]">
                                                                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                                                                            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-200 p-4 dark:border-white/10">
                                                                                <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel">เลือกกลุ่มสินค้า</h5>
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
                                                                            <form id="form_menu" class="" method="POST">
                                                                                <input class="" type="hidden" id="edit_id" name="edit_id" value="">
                                                                                <div class="p-4 text-gray-900 dark:text-gray-100">
                                                                                    <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                                        <div class="md:col-span-2">
                                                                                            <label for="name">ซีรีย์</label>
                                                                                            <select  class="js-example-basic-single js-states w-full rounded-sm text-xs select2" name="" id="">
                                                                                                <option value=""> --- กรุณาเลือก ---</option>
                                                                                                    <option selected="selected">Alabama</option>
                                                                                                    <option> Alaska </option>
                                                                                                    <option> California </option>
                                                                                                    <option>Delaware </option>
                                                                                                    <option> Tennessee </option>
                                                                                                    <option>Texas </option>
                                                                                                    <option> Washington </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="md:col-span-2">
                                                                                            <label for="name">Solution</label>
                                                                                            <select  class="js-example-basic-single w-full rounded-sm text-xs select2" name="" id="">
                                                                                                <option value=""> --- กรุณาเลือก ---</option>
                                                                                                    <option selected="selected">Alabama</option>
                                                                                                    <option> Alaska </option>
                                                                                                    <option> California </option>
                                                                                                    <option>Delaware </option>
                                                                                                    <option> Tennessee </option>
                                                                                                    <option>Texas </option>
                                                                                                    <option> Washington </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="md:col-span-2">
                                                                                            <label for="name">Category</label>
                                                                                            <select  class="js-example-basic-single w-full rounded-sm text-xs select2" name="" id="">
                                                                                                <option value=""> --- กรุณาเลือก ---</option>
                                                                                                    <option selected="selected">Alabama</option>
                                                                                                    <option> Alaska </option>
                                                                                                    <option> California </option>
                                                                                                    <option>Delaware </option>
                                                                                                    <option> Tennessee </option>
                                                                                                    <option>Texas </option>
                                                                                                    <option> Washington </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="md:col-span-2">
                                                                                            <label for="name">Sub Category</label>
                                                                                            <select  class="js-example-basic-single w-full rounded-sm text-xs select2" name="" id="">
                                                                                                <option value=""> --- กรุณาเลือก ---</option>
                                                                                                    <option selected="selected">Alabama</option>
                                                                                                    <option> Alaska </option>
                                                                                                    <option> California </option>
                                                                                                    <option>Delaware </option>
                                                                                                    <option> Tennessee </option>
                                                                                                    <option>Texas </option>
                                                                                                    <option> Washington </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="md:col-span-2" style="position: relative;">
                                                                                            <label for="">Test</label>
                                                                                            <input type="text" name="" id="" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="p-2 mb-2">
                                                                                        <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                    </div>
                                                                                    <!-- <table class="table table-sm table-bordered text-gray-900 dark:text-gray-100 mt-5 relative" id="table">
                                                                                        <tr>
                                                                                            <th class="text-sm">รหัส</th>
                                                                                            <th class="text-sm">ชื่อนค้า</th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                            </td>
                                                                                            <td>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table> -->
                                                                                    <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500 pt-2.5 pb-2.5">
                                                                                        <div class="text-gray-900 dark:text-gray-100">
                                                                                            <div class="table-wrapper">
                                                                                                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                                                                                    <table id="product_group_table" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                                                                        <thead>
                                                                                                            <tr>
                                                                                                            <th>Select</th>
                                                                                                            <th>Street</th>
                                                                                                            <th>City</th>
                                                                                                            <th>Zip</th>
                                                                                                            <th>State</th>
                                                                                                            <th>Beds</th>
                                                                                                            <th>Baths</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>3526 HIGH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95838</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>51 OMAHA CT</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95823</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>3</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>2796 BRANCH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95815</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>2805 JANETTE WAY</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95815</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row mt-3 md:p-4">
                                                                                                <div class="col">
                                                                                                    <textarea rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="output">
                                                                                                    </textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-2 ">
                                                                                    <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                </div>
                                                                                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                                                                                    <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 rounded cursor-pointer group" onclick="selectProductGroup()">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 size-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                                                                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                                                                        </svg>
                                                                                        เลือก
                                                                                    </a>
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
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">รหัสสินค้า</label>
                                                        <div class="input-group ">
                                                            <input type="text" name="" id="" class="w-10/12 h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า" value="" />
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary btn-sm bg-gray-50 dark:bg-[#303030]"
                                                                    type="button" id=""
                                                                    data-twe-toggle="modal"
                                                                    data-twe-target="#exampleModalLg_product_code"
                                                                    data-twe-ripple-init
                                                                    data-twe-ripple-color="light"
                                                                >
                                                                    <i class="nav-icon fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                            <section>
                                                                <!-- Modal -->
                                                                <div
                                                                    data-twe-modal-init
                                                                    class="data-twe-backdrop-show fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                                                                    id="exampleModalLg_product_code"
                                                                    data-twe-backdrop="static"
                                                                    data-twe-keyboard="false"
                                                                    tabindex="-1"
                                                                    aria-labelledby="exampleModalLgLabel"
                                                                    aria-hidden="true"
                                                                >
                                                                    <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px]">
                                                                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                                                                            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-200 p-4 dark:border-white/10">
                                                                                <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel">เลือกกลุ่มสินค้า</h5>
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
                                                                            <form id="form_menu" class="" method="POST">
                                                                                <input class="" type="hidden" id="edit_id" name="edit_id" value="">
                                                                                <div class="p-4 text-gray-900 dark:text-gray-100">
                                                                                    <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                                        <div class="md:col-span-2" style="position: relative;">
                                                                                            <label for="">รหัสสินค้า</label>
                                                                                            <input type="text" name="" id="" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="p-2 mb-2">
                                                                                        <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                    </div>
                                                                                    <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500 pt-2.5 pb-2.5">
                                                                                        <div class="text-gray-900 dark:text-gray-100">
                                                                                            <div class="table-wrapper">
                                                                                                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                                                                                    <table id="product_group_code" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                                                                        <thead>
                                                                                                            <tr>
                                                                                                            <th>Select</th>
                                                                                                            <th>Street</th>
                                                                                                            <th>City</th>
                                                                                                            <th>Zip</th>
                                                                                                            <th>State</th>
                                                                                                            <th>Beds</th>
                                                                                                            <th>Baths</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>3526 HIGH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95838</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>51 OMAHA CT</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95823</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>3</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>2796 BRANCH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95815</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!-- <div class="row mt-3 md:p-4">
                                                                                                <div class="col">
                                                                                                    <textarea rows="10" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="output">
                                                                                                    </textarea>
                                                                                                </div>
                                                                                            </div> -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-2 ">
                                                                                    <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                </div>
                                                                                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                                                                                    <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 rounded cursor-pointer group" onclick="createMenu()">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 size-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                                                                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                                                                        </svg>
                                                                                        เลือก
                                                                                    </a>
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
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="">Optional</label>
                                                        <div class="input-group ">
                                                            <input type="text" name="" id="" class="w-10/12 h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" placeholder="Optional" value="" />
                                                            <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary btn-sm bg-gray-50 dark:bg-[#303030]"
                                                                    type="button" id=""
                                                                    data-twe-toggle="modal"
                                                                    data-twe-target="#exampleModalLg_optional"
                                                                    data-twe-ripple-init
                                                                    data-twe-ripple-color="light"
                                                                >
                                                                    <i class="nav-icon fas fa-search"></i>
                                                                </button>
                                                            </div>
                                                            <section>
                                                                <!-- Modal -->
                                                                <div
                                                                    data-twe-modal-init
                                                                    class="data-twe-backdrop-show fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                                                                    id="exampleModalLg_optional"
                                                                    data-twe-backdrop="static"
                                                                    data-twe-keyboard="false"
                                                                    tabindex="-1"
                                                                    aria-labelledby="exampleModalLgLabel"
                                                                    aria-hidden="true"
                                                                >
                                                                    <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px]">
                                                                        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                                                                            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-200 p-4 dark:border-white/10">
                                                                                <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel">เลือกกลุ่มสินค้า</h5>
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
                                                                            <form id="form_menu" class="" method="POST">
                                                                                <input class="" type="hidden" id="edit_id" name="edit_id" value="">
                                                                                <div class="p-4 text-gray-900 dark:text-gray-100">
                                                                                    <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                                        <div class="md:col-span-2" style="position: relative;">
                                                                                            <label for="">Optional</label>
                                                                                            <input type="text" name="" id="" class="h-8 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="p-2 mb-2">
                                                                                        <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                    </div>
                                                                                    <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500 pt-2.5">
                                                                                        <div class="text-gray-900 dark:text-gray-100">
                                                                                            <div class="table-wrapper">
                                                                                                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                                                                                    <table id="product_group_optinal" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                                                                        <thead>
                                                                                                            <tr>
                                                                                                            <th>Select</th>
                                                                                                            <th>Street</th>
                                                                                                            <th>City</th>
                                                                                                            <th>Zip</th>
                                                                                                            <th>State</th>
                                                                                                            <th>Beds</th>
                                                                                                            <th>Baths</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>3526 HIGH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95838</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>51 OMAHA CT</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95823</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>3</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>2796 BRANCH ST</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95815</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>2805 JANETTE WAY</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95815</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                            <td></td>
                                                                                                            <td>6001 MCMAHON DR</td>
                                                                                                            <td>SACRAMENTO</td>
                                                                                                            <td>95824</td>
                                                                                                            <td>CA</td>
                                                                                                            <td>2</td>
                                                                                                            <td>1</td>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row mt-3 md:p-4">
                                                                                                <div class="col">
                                                                                                    <textarea rows="10" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="output">
                                                                                                    </textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="p-2 ">
                                                                                    <ul class="space-y-2 font-large border-t-2 border-[#E5E5E5] dark:border-[#373737]"></ul>
                                                                                </div>
                                                                                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                                                                                    <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 rounded cursor-pointer group" onclick="createMenu()">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 size-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                                                                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                                                                        </svg>
                                                                                        เลือก
                                                                                    </a>
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
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                        </div>

                        <div class="mb-3 bg-gray-100 dark:bg-[#404040] p-3">
                            <div class="m-3 text-gray-900 dark:text-gray-100">
                                <div>
                                    <p>สินค้าหลัก</p>
                                </div>
                                    <select id="demo" multiple>
                                        {{-- <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">Four</option>
                                        <option value="5">Five</option>
                                        <option value="6">Six</option>
                                        <option value="7">Seven</option>
                                        <option value="8">Eight</option>
                                        <option value="9">Nine</option>
                                        <option value="10">Ten</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-5 bg-gray-100 dark:bg-[#404040] p-3">
                            <div class="m-3 text-gray-900 dark:text-gray-100">
                                <div class="container pt-5">
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-wrapper">
                                                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                            <th>Select</th>
                                                            <th>Street</th>
                                                            <th>City</th>
                                                            <th>Zip</th>
                                                            <th>State</th>
                                                            <th>Beds</th>
                                                            <th>Baths</th>
                                                            <th>Sq Ft</th>
                                                            <th>Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td></td>
                                                            <td>3526 HIGH ST</td>
                                                            <td>SACRAMENTO</td>
                                                            <td>95838</td>
                                                            <td>CA</td>
                                                            <td>2</td>
                                                            <td>1</td>
                                                            <td>836</td>
                                                            <td>Residential</td>
                                                            </tr>
                                                            <tr>
                                                            <td></td>
                                                            <td>51 OMAHA CT</td>
                                                            <td>SACRAMENTO</td>
                                                            <td>95823</td>
                                                            <td>CA</td>
                                                            <td>3</td>
                                                            <td>1</td>
                                                            <td>1167</td>
                                                            <td>Residential</td>
                                                            </tr>
                                                            <tr>
                                                            <td></td>
                                                            <td>2796 BRANCH ST</td>
                                                            <td>SACRAMENTO</td>
                                                            <td>95815</td>
                                                            <td>CA</td>
                                                            <td>2</td>
                                                            <td>1</td>
                                                            <td>796</td>
                                                            <td>Residential</td>
                                                            </tr>
                                                            <tr>
                                                            <td></td>
                                                            <td>2805 JANETTE WAY</td>
                                                            <td>SACRAMENTO</td>
                                                            <td>95815</td>
                                                            <td>CA</td>
                                                            <td>2</td>
                                                            <td>1</td>
                                                            <td>852</td>
                                                            <td>Residential</td>
                                                            </tr>
                                                            <tr>
                                                            <td></td>
                                                            <td>6001 MCMAHON DR</td>
                                                            <td>SACRAMENTO</td>
                                                            <td>95824</td>
                                                            <td>CA</td>
                                                            <td>2</td>
                                                            <td>1</td>
                                                            <td>797</td>
                                                            <td>Residential</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <textarea rows="20" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="output">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-left">
                                    <a href="#" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-chevron-circle-left"></i> ย้อนกลับ
                                    </a>
                                    <a href="./promotion_page3.html" class="btn btn-sm btn-primary">
                                        ถัดไป <i class="fas fa-chevron-circle-right"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-file"></i> เอกสารใหม่
                                    </a>
                                    <a href="#" class="btn btn-sm btn-success">
                                        <i class="fas fa-save"></i> บันทึก
                                    </a>
                                    <a href="#" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-ban"></i> ยกเลิก
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"> </i> ปิด
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="md:col-span-6 text-right mt-4">
                            <div class="inline-flex items-end">
                                <a href="{{ route('product_master.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50" onclick="checkPacksize()" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 w-5 h-5 hidden md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script> --}}


    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/check.min.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/3.10.1-jszip.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dual-listbox/dist/dual-listbox.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>

    // let productGrouptableArray = [];
    let selectedRow = []
    $(document).ready(function () {
        // Initialise DataTable
        const table = $("#product_group_table").DataTable({
            searching: false,
            lengthChange: false,
            pageLength: 25,
            buttons: ["selectAll", "selectNone"],
            select: {
                style: "multi",
                selector: "td:first-child",
            },
            columnDefs: [
                {
                    orderable: false,
                    className: "select-checkbox",
                    targets: 0,
                },
            ],
            order: [[1, "asc"]],
            language: {
                buttons: {
                    selectAll: "Select All",
                    selectNone: "Select None",
                },
            },
        });

        table
            .buttons()
            .container()
            .appendTo("#product_group_table_wrapper .col-md-6:eq(0)");

        // Dynamically fetch headers
        const headers = table
            .columns()
            .header()
            .toArray()
            .map(header => $(header).text().trim()); // Extract and trim header text

        console.log("Headers from DataTable:", headers);

        // Event: On Select or Deselect
        const updateProductGroupTableArray = () => {
            productGrouptableArray = table
                .rows(".selected") // Selected rows
                .data()
                .toArray(); // Convert to array

            // Transform rows into an array of objects using headers
            const objectsArray = productGrouptableArray.map(row => {
                const rowData = row.slice(1); // Exclude the first column (checkbox)
                return headers.reduce((obj, header, index) => {
                    obj[header] = rowData[index]; // Map headers to row values
                    return obj;
                }, {});
            });

            // Display the output (optional)
            $("#output").html(JSON.stringify(objectsArray, null, 2));
            console.log("Array of objects:", objectsArray);
            selectedRow = objectsArray
        };

        // Bind select and deselect events
        table.on("select.dt", updateProductGroupTableArray);
        table.on("deselect.dt", updateProductGroupTableArray);
    });



        // let productGrouptableArray = [];
        // $(document).ready(function() {
        //     // Initialise Tabl
        //     const table = $("#product_group_table").DataTable({
        //         // Length Change
        //         searching: false,
        //         lengthChange: false,
        //         pageLength: 25,
        //         // Table Buttons
        //         buttons: ["selectAll", "selectNone"],
        //         // Multi Select
        //         select: {
        //         style: "multi",
        //         selector: "td:first-child"
        //         },
        //         // Select Column
        //         columnDefs: [
        //         {
        //             orderable: false,
        //             className: "select-checkbox",
        //             targets: 0
        //         }
        //         ],
        //         // Default Ordering
        //         order: [[1, "asc"]],
        //         // Button Text
        //         language: {
        //         buttons: {
        //             selectAll: "Select All",
        //             selectNone: "Select None"
        //         }
        //         }
        //     });
        //     // // Button Append to Div
        //     // table
        //     //     .buttons()
        //     //     .container()
        //     //     .appendTo("#example_wrapper .col-md-6:eq(0)");
        //     // // Select to Array
        //     // // var productGrouptableArray = [];
        //     // table.on("select.dt", function() {
        //     //     productGrouptableArray = table
        //     //     .rows(".selected")
        //     //     .data()
        //     //     .toArray();
        //     //     $("#output").html(productGrouptableArray);
        //     // });
        //     // // Deselect from Array
        //     // table.on("deselect.dt", function() {
        //     //     productGrouptableArray = table
        //     //     .rows(".selected")
        //     //     .data()
        //     //     .toArray();
        //     //     $("#output").html(productGrouptableArray);
        //     // });

        //     // Button Append to Div
        //     table
        //         .buttons()
        //         .container()
        //         .appendTo("#product_group_table_wrapper .col-md-6:eq(0)");
        //     // Event: On Select or Deselect
        //     const updateProductGroupTableArray = () => {
        //         productGrouptableArray = table
        //             .rows(".selected") // Selected rows
        //             .data()
        //             .toArray(); // Convert to array
        //         // Map values, excluding the first column (select-checkbox)
        //         const values = productGrouptableArray.map(row => row.slice(1));
        //         // Display the collected values (optional)
        //         $("#output").html(JSON.stringify(values, null, 2));
        //         console.log("Collected values without leading empty column:", values);
        //     };
        //     // Bind select and deselect events
        //     table.on("select.dt", updateProductGroupTableArray);
        //     table.on("deselect.dt", updateProductGroupTableArray);
        // });


        let tableArray2 = [];
        let tableProductGroupCode = null;
        $(document).ready(function() {
            // Initialise Tabl
            // product_group_code
            // product_group_optinal
            tableProductGroupCode = $("#product_group_code").DataTable({
                // Length Change
                searching: false,
                lengthChange: false,
                pageLength: 25,
                // Table Buttons
                buttons: ["selectAll", "selectNone"],
                // Multi Select
                select: {
                style: "multi",
                selector: "td:first-child"
                },
                // Select Column
                columnDefs: [
                {
                    orderable: false,
                    className: "select-checkbox",
                    targets: 0
                }
                ],
                // Default Ordering
                order: [[1, "asc"]],
                // Button Text
                language: {
                buttons: {
                    selectAll: "Select All",
                    selectNone: "Select None"
                }
                }
            });
            // // Button Append to Div
            // table
            //     .buttons()
            //     .container()
            //     .appendTo("#example_wrapper .col-md-6:eq(0)");
            // // Select to Array
            // // var tableArray = [];
            // table.on("select.dt", function() {
            //     tableArray = table
            //     .rows(".selected")
            //     .data()
            //     .toArray();
            //     $("#output").html(tableArray);
            // });
            // // Deselect from Array
            // table.on("deselect.dt", function() {
            //     tableArray = table
            //     .rows(".selected")
            //     .data()
            //     .toArray();
            //     $("#output").html(tableArray);
            // });

            // Button Append to Div
            tableProductGroupCode
                .buttons()
                .container()
                .appendTo("#product_group_code_wrapper .col-md-6:eq(0)");
            // Event: On Select or Deselect
            const updateTableArray = () => {
                tableArray = tableProductGroupCode
                    .rows(".selected") // Selected rows
                    .data()
                    .toArray(); // Convert to array
                // Map values, excluding the first column (select-checkbox)
                const values = tableArray.map(row => row.slice(1));
                // Display the collected values (optional)
                $("#output").html(JSON.stringify(values, null, 2));
                console.log("Collected values without leading empty column:", values);
            };
            // Bind select and deselect events
            tableProductGroupCode.on("select.dt", updateTableArray);
            tableProductGroupCode.on("deselect.dt", updateTableArray);
        });

        let dualListbox = new DualListbox('#demo', {
            addButtonText: '>',
            removeButtonText: '<',
            addAllButtonText: '>>',
            removeAllButtonText: '<<',
            availableTitle: '',
            selectedTitle: ''
        });

        function selectProductGroup() {
            let table = $('#product_group_table').DataTable();
            table.$('tr').removeClass('selected');
            console.log("🚀 ~ selectProductGroup ~ tableProductGroupCode:", tableProductGroupCode)
            console.log("🚀 ~ selectProductGroup ~ selectedRow:", selectedRow)
            const newOption = selectedRow.map((select)=> {
                return {
                    text:select.Street,
                    value:select.Street,
                }
            })
            dualListbox.addOptions(newOption)
            dualListbox.redraw()
        }

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

        function onOpenhandler(params) {
            document.querySelectorAll('.setpcollep').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    document.querySelectorAll('.setcheckbox').forEach(ee => {
                        ee.checked = false
                    });
                    document.querySelectorAll('.bg_step_color').forEach(ee => {
                        ee.classList.remove('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                        ee.classList.add('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                    });
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    let el_colr = document.querySelectorAll('.bg_step_color')[index]
                    el.checked = !el.checked
                    if( el.checked){
                        el_colr.classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                        el_colr.classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                    }
                })
            });
        }

        $(document).ready(function() {
            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            $('.js-example-basic-single').select2();
        });

        $(function() {
            $("#coupon_question").on("click",function() {
                $(".answer").toggle(this.checked);
            });
        });

        let i = 0;
        $('#add').click(() => {
            ++i;
            // Get the currently selected radio button value
            const selectedValue = $('input[name="PACKAGE_BOX"]:checked').val() || 'บาท'; // Default to "บาท" if none selected
            console.log("Adding row with value:", selectedValue); // Debugging: log selected value
            // Append a new row
            $('#table').append(
                `<tr class="table_submenu">
                    <td class="">
                        <input type="text" name="inputs_submenu[${i}][inputs_submenu1]" id="inputs_submenu1"
                            class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                        <span class="dynamic-text">${selectedValue}</span>
                    </td>
                    <td class="">
                        <input type="text" name="inputs_submenu[${i}][inputs_submenu2]" id="inputs_submenu2"
                            class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                        <span class="dynamic-text">${selectedValue}</span>
                    </td>
                    <td class="">
                        <input type="text" name="inputs_submenu[${i}][inputs_submenu3]" id="inputs_submenu3"
                            class="w-10/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 bg-gray-50 dark:bg-[#303030] text-center" value="" />
                        <span class="dynamic-text">${selectedValue}</span>
                    </td>
                    <td class="text-center">
                        <button
                            type="button"
                            class="mt-1 px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group remove-table-row"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>`
            );
            // Trigger the change event to ensure the new row gets updated if the radio changes later
            $('input[name="PACKAGE_BOX"]:checked').trigger('change');
        });

        $(document).on('click', '.remove-table-row', function() {
            $(this).closest('tr').remove();
        });

        // Listen for changes on the radio buttons
        $('input[name="PACKAGE_BOX"]').change(function() {
            // Get the selected radio button value
            const selectedValue = $(this).val();
            console.log("Radio changed to:", selectedValue); // Debugging: log radio value changes

            // Update all dynamic-text spans with the selected value
            $('.dynamic-text').text(selectedValue);
        });
    </script>
@endsection
