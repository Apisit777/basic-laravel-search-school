@extends('layouts.layout')
@section('title', '')

    <style>
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #7f7f7fe3; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading-2 {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #7f7f7fe3; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
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
        .animate-quarter-spin {
            animation: spin 6s steps(2, end) infinite;
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }


        /* ************************************************************************************************* */

        :root{
    --bs-white: 255, 255, 255;
    --bs-black: 0, 0, 0;
    --bs-primary-rgb: 13, 110, 253;
    --bs-secondary-rgb: 108, 117, 125;
    --bs-success-rgb: 25, 135, 84;
    --bs-info-rgb: 13, 202, 240;
    --bs-warning-rgb: 255, 193, 7;
    --bs-danger-rgb: 220, 53, 69;
    --bs-indigo-rgb: 102, 16, 242;
    --bs-blur-1: 5px;
    --bs-trans: 5px;
    }

    body{
    height:10vh;
    withd:100vw;
    /* background-image: url(https://images.unsplash.com/photo-1635614017406-7c192d832072?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80); */
    /*background-image: url(https://images.unsplash.com/photo-1626553683558-dd8dc97e40a4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80);
    /*background-image: url(https://images.unsplash.com/photo-1669021136691-2b54c967e7b5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=928&q=80);*/
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    }
    .card{
    border-radius:1rem;
    }
    .card-glass{
    border: 2px solid rgba(var(--bs-white),0.2);
    background-color:rgba(var(--bs-white),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-dark{
    border: 2px solid rgba(var(--bs-black),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-black),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-primary{
    border: 2px solid rgba(var(--bs-primary-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-primary-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-secondary{
    border: 2px solid rgba(var(--bs-secondary-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-secondary-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-success{
    border: 2px solid rgba(var(--bs-success-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-success-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-info{
    border: 2px solid rgba(var(--bs-info-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-info-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-warning{
    border: 2px solid rgba(var(--bs-warning-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-warning-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-danger{
    border: 2px solid rgba(var(--bs-danger-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-danger-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }
    .card-glass-indigo{
    border: 2px solid rgba(var(--bs-indigo-rgb),0.2);
    color:rgba(var(--bs-white),1);
    background-color:rgba(var(--bs-indigo-rgb),0.5);
    backdrop-filter:blur(var(--bs-blur-1))!important;
    }


    /* กรอบแดงเวลาผิด */
    #update_product_account .is-invalid{
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 .2rem rgba(220,53,69,.15) !important;
    }

    /* ถ้าใช้ dark mode แล้วโดน border ทับ */
    html.dark #update_product_account .is-invalid{
        border-color: #ff5a5f !important;
    }

    /* (เสริม) ให้ error แสดงสวย */
    #update_product_account .invalid-feedback{
        display:block;
        margin-top: .25rem;
    }

    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
<div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-8">
        <div class="justify-center items-center">
            <div class="flex justify-items-start">
                <p class="-mt-4 inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Account Schedule</p>
            </div>
            <form class="" action="" method="POST" id="update_product_account">
                <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="lg:col-span-4 xl:grid-cols-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                            <div class="md:col-span-3" style="position: relative;">
                                <label for="BRAND">Brand Product</label>
                                <input type="text" name="BRAND" id="BRAND" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->BRAND }}" readonly>
                            </div>
                            <div class="md:col-span-3" style="position: relative;">
                                <label for="Code">รหัส</label>
                                <input type="text" name="Code" id="Code" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-red-600 dark:text-red-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->product }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='w-12/12 relative'>
                    <div class="p-4">
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        1
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        ตั้งราคาบัญชีใหม่
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                                <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        ตั้งราคาบัญชีใหม่
                                                    </h1>
                                                </div>
                                                <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-4">
                                                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                @php
                                                                    $formattedDate = null;
                                                                    if (!empty($docDate)) {
                                                                        try {
                                                                            $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $docDate)->format('Y-m-d');
                                                                        } catch (\Exception $e) {
                                                                            $formattedDate = null; // หากฟอร์แมตผิด ให้ใช้ค่า null
                                                                        }
                                                                    }
                                                                @endphp
                                                                <div class="md:col-span-4" style="position: relative;">
                                                                    <label for="active_date">วันที่เริ่มใช้ราคา</label>
                                                                    <input type="date" name="active_date" id="active_date"
                                                                        class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center"
                                                                        placeholder=""
                                                                        autocomplete="off"
                                                                        value=""
                                                                        min="{{ $docDate }}" />
                                                                </div>
                                                                <!-- <div class="md:col-span-1" style="position: relative;">
                                                                    <label for="test_cost">ต้นทุน</label>
                                                                    <input type="text" name="test_cost" id="test_cost" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="">ต้นทุน(ราคาต้นทุน Brand)</label>
                                                                    <input type="text" name="" id="" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-red-600 dark:text-red-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->COST }}" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <!-- <label for="sale_tp">ราคาขายบัญชี(TP)</label> -->
                                                                    <label for="price">ราคาบัญชีใหม่</label>
                                                                    <input type="text" name="price" id="price" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->price }}" />
                                                                </div>
                                                                <!-- <div class="md:col-span-1" style="position: relative;">
                                                                    <label for="test_cost">ต้นทุน</label>
                                                                    <input type="text" name="test_cost" id="test_cost" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <!-- <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="COST">ต้นทุน Brand</label>
                                                                    <input type="text" name="COST" id="COST" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="cost">ต้นทุน</label>
                                                                    <input type="text" name="cost" id="cost" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <!-- <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="cost_km">ต้นทุนผลิต KM</label>
                                                                    <input type="text" name="cost_km" id="cost_km" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-2" >
                                                                    <label for="cost5percent">ต้นทุนผลิต KM+5%</label>
                                                                    <input type="text" name="cost5percent" id="cost5percent" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="cost10percent">ต้นทุนผลิต KM+10%</label>
                                                                    <input type="text" name="cost10percent" id="cost10percent" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="cost_other">ต้นทุนผลิต KM+อื่นๆ</label>
                                                                    <input type="text" name="cost_other" id="cost_other" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="sale_km">ราคาขาย KM</label>
                                                                    <input type="text" name="sale_km" id="sale_km" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="sale_km20percent">ราคาขาย KM+20%</label>
                                                                    <input type="text" name="sale_km20percent" id="sale_km20percent" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="sale_km_other">ราคาขาย KM+อื่นๆ</label>
                                                                    <input type="text" name="sale_km_other" id="sale_km_other" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <!-- <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="PRICE">ราคาขายปลีก</label>
                                                                    <input type="text" name="PRICE" id="PRICE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="perfume_tax">ภาษีน้ำหอม</label>
                                                                    <input type="text" name="perfume_tax" id="perfume_tax" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <!-- <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="cost_perfume_tax">ต้นทุนผลิต KM+ภาษีน้ำหอม</label>
                                                                    <input type="text" name="cost_perfume_tax" id="cost_perfume_tax" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="md:col-span-6 text-right mt-1">
                            <div class="inline-flex items-end">
                                <a href="{{ route('account.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <!-- <a id="btnSerarch" class=" bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-1.5 px-4 rounded cursor-pointer" onclick="accountSchedule()" disabled>
                                    💾
                                    Save
                                </a> -->
                                <button type="submit" id="btnSave" class="bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-1.5 px-4 rounded cursor-pointer">
                                    💾 Save
                                </button>
                            </div>
                        </div>
                        <ul class="pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </form>

            <!-- <div class="mx-auto max-w-6xl p-6 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="rounded-lg border-2 border-black/20 bg-black/50 backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-white">Card Glass Dark</h5>
                            <p class="mt-2 text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                    </div>

                    <div class="rounded-lg border-2 border-[#0d6efd]/20 bg-[#0d6efd]/50 backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-slate-950 dark:text-white">Card Glass Primary</h5>
                            <p class="mt-2 text-slate-900/90 dark:text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                    </div>

                        <div class="rounded-lg border-2 border-[#6c757d]/20 bg-[rgba(108,117,125,0.4)] backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-slate-950 dark:text-white">Card Glass Secondary</h5>
                            <p class="mt-2 text-slate-900/90 dark:text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                        </div>

                        <div class="rounded-lg border-2 border-[#198754]/20 bg-[#198754]/50 backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-slate-950 dark:text-white">Card Glass Success</h5>
                            <p class="mt-2 text-slate-900/90 dark:text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                        </div>

                        <div class="rounded-lg border-2 border-[#dc3545]/20 bg-[#dc3545]/50 backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-slate-950 dark:text-white">Card Glass Danger</h5>
                            <p class="mt-2 text-slate-900/90 dark:text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                        </div>

                        <div class="rounded-lg border-2 border-[#ffc107]/20 bg-[#ffc107]/50 backdrop-blur-[5px] shadow-lg">
                        <div class="p-6">
                            <h5 class="text-lg font-semibold text-slate-950 dark:text-white">Card Glass Warning</h5>
                            <p class="mt-2 text-slate-900/90 dark:text-white/90">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </p>
                        </div>
                    </div>

                </div>
            </div> -->

            <div class='w-12/12 relative -mt-8'>
                <div class="p-4">
                    <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                        <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                            <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                    2
                                </span>
                                <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                    ตั้งราคาบัญชี
                                </span>
                            </div>
                            <form class="" action="" method="POST" id="updateProductPriceSchedule">
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white">

                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">

                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">

                                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                <h1 class="text-gray-900 dark:text-white text-lg">ตั้งราคาบัญชี</h1>
                                            </div>

                                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                </svg>
                                            </div>

                                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full relative">

                                                <!-- ✅ Loader ของฟอร์มนี้ -->
                                                <!-- <div id="loaderSchedule" class="absolute inset-0 hidden items-center justify-center bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5] z-50">
                                                    Loading...
                                                </div> -->

                                                <div class="mx-auto max-w-6xl p-5 md:p-4">
                                                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[420px_1fr]">

                                                        <!-- LEFT: Topics -->
                                                        <aside class="rounded-lg border border-[#6c757d]/20 bg-[rgba(108,117,125,0.4)] dark:border-black/20 dark:bg-black/50 backdrop-blur-xl shadow-lg">
                                                            <div class="border-b border-white/10 p-5">
                                                                <h2 class="text-slate-950 dark:text-white text-lg font-semibold">หัวข้อเอกสาร</h2>
                                                                <p class="mt-1 inline-flex items-center gap-1 text-sm text-slate-950 dark:text-white">
                                                                การตั้งราคา Schedule(
                                                                <span class="font-bold rounded-full border px-2 py-0 border-black/20 bg-black/15 text-red-600 dark:text-red-600">
                                                                    มีผลวันที่ {{ $data->active_date ?? '- ยังไม่ได้ตั้งราคา' }}
                                                                </span>
                                                                )
                                                                </p>
                                                            </div>

                                                            <div class="p-3 space-y-2">
                                                                <button type="button" class="w-full text-left rounded-xl border border-white/10 bg-white/10 px-4 py-3 hover:bg-white/15 transition">
                                                                <div class="flex items-center justify-between gap-3">
                                                                    @if( $data->BRAND === 'OP')
                                                                    <div class="rounded-lg border px-3 py-0 border-black/20 bg-black/15">
                                                                        <div class="text-slate-950 dark:text-white font-semibold">Brand {{ $data->BRAND }}</div>
                                                                        <div class="text-sm text-slate-950 dark:text-white">รหัสสินค้า {{ $data->product }}</div>
                                                                    </div>
                                                                    @elseif ($data->BRAND === 'CPS')
                                                                    <div class="rounded-full border px-3 py-0 border-[#6f42c1]/30 bg-[#6f42c1]/15">
                                                                        <div class="text-slate-950 dark:text-white font-semibold">Brand {{ $data->BRAND }}</div>
                                                                        <div class="text-sm text-slate-950 dark:text-white">รหัสสินค้า {{ $data->product }}</div>
                                                                    </div>
                                                                    @else
                                                                    <div class="rounded-full border px-3 py-0 border-black/20 bg-black/15">
                                                                        <div class="text-slate-950 dark:text-white font-semibold">Brand {{ $data->BRAND }}</div>
                                                                        <div class="text-sm text-slate-950 dark:text-white">รหัสสินค้า {{ $data->product }}</div>
                                                                    </div>
                                                                    @endif

                                                                    <!-- ✅ เพิ่ม id: topicStatusBadge -->
                                                                    @if( $data->status === 1) 
                                                                        <span id="topicStatusBadge"
                                                                                class="text-xs rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                            Not Started
                                                                        </span>
                                                                    @elseif ($data->status === 2)
                                                                        <span id="topicStatusBadge"
                                                                                class="text-xs rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                            In Progress
                                                                        </span>
                                                                    @else
                                                                        <span id="topicStatusBadge"
                                                                                class="text-xs rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                            Completed
                                                                        </span>
                                                                    @endif

                                                                </div>
                                                            </button>
                                                        </div>
                                                    </aside>

                                                    <!-- RIGHT: Approval Steps -->
                                                    <section class="rounded-lg border border-[#6c757d]/20 bg-[rgba(108,117,125,0.4)] dark:border-black/20 dark:bg-black/50 backdrop-blur-xl shadow-lg">
                                                        <div class="border-b border-white/10 p-5 flex items-start justify-between gap-4">
                                                            <div>
                                                            <h2 class="text-slate-950 dark:text-white text-lg font-semibold">ขั้นตอนการตั้งราคา Schedule</h2>
                                                            </div>

                                                            <div class="hidden sm:flex items-center gap-2">
                                                            <span class="text-xs text-slate-950 dark:text-white">Legend:</span>
                                                            <span class="text-xs rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15 px-2 py-0 text-slate-950 dark:text-white">Not Started</span>
                                                            <span class="text-xs rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15 px-2 py-0 text-slate-950 dark:text-white">In Progress</span>
                                                            <span class="text-xs rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0 text-slate-950 dark:text-white">Completed</span>
                                                            </div>
                                                        </div>

                                                        <div class="p-5">
                                                            <div class="relative">
                                                            <div class="absolute left-4 top-0 bottom-0 w-px bg-white/15"></div>

                                                                <div class="space-y-5">
                                                                    <!-- STEP 1 -->
                                                                    <div class="relative pl-12">
                                                                        {{-- ✅ เพิ่ม id: step1Circle --}}
                                                                        @if( $data->status === 1) 
                                                                        <div id="step1Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#0d6efd]/40 bg-[#0d6efd]/25 shadow-[0_0_20px_rgba(13,110,253,0.35)]">
                                                                            &nbsp;⏳
                                                                        </div>
                                                                        @elseif ($data->status === 2)
                                                                        <div id="step1Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#ffc107]/40 bg-[#ffc107]/25 shadow-[0_0_20px_rgba(255,193,7,0.35)]">
                                                                            <svg viewBox="0 0 24 24" class="h-6 w-6 text-white/95"
                                                                                fill="none" stroke="currentColor" stroke-width="3"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M20 6L9 17l-5-5" />
                                                                            </svg>
                                                                        </div>
                                                                        @else
                                                                        <div id="step1Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-emerald-400/25 bg-[rgb(25_135_84/0.50)] shadow-[0_0_20px_rgba(25,135,84,0.45)]">
                                                                            <svg viewBox="0 0 24 24" class="h-6 w-6 text-white/95"
                                                                                fill="none" stroke="currentColor" stroke-width="3"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M20 6L9 17l-5-5" />
                                                                            </svg>
                                                                        </div>
                                                                        @endif

                                                                        <div class="relative overflow-hidden rounded-lg border-2 border-[#0d6efd]/25 bg-[rgb(13_110_253/0.50)] backdrop-blur-[8px] shadow-lg">
                                                                        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(135deg,rgba(255,255,255,0.20)_0%,rgba(255,255,255,0.05)_30%,transparent_60%)]"></div>
                                                                        <div class="relative p-5">
                                                                            <div class="flex flex-wrap items-center justify-between gap-3">
                                                                            <div class="text-slate-950 dark:text-white font-semibold">Step 1 • ยังไม่ดำเนินการตั้งราคา</div>

                                                                            {{-- ✅ เพิ่ม id: step1Badge (และ class เหมือนของคุณเป๊ะ) --}}
                                                                            @if( $data->status === 1) 
                                                                                <span id="step1Badge" class="text-xs rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Not Started
                                                                                </span>
                                                                            @elseif ($data->status === 2)
                                                                                <span id="step1Badge" class="text-xs rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                In Progress
                                                                                </span>
                                                                            @else
                                                                                <span id="step1Badge" class="text-xs rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Completed
                                                                                </span>
                                                                            @endif
                                                                            </div>

                                                                            {{-- ✅ เพิ่ม id: step1Desc --}}
                                                                            @if( $data->status === 1) 
                                                                            <div id="step1Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ยังไม่ดำเนินการ...</div>
                                                                            @elseif ($data->status === 2)
                                                                            <div id="step1Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ดำเนินการแล้ว...</div>
                                                                            @else
                                                                            <div id="step1Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ดำเนินการเสร็จสมบูรณ์...</div>
                                                                            @endif
                                                                        </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- STEP 2 -->
                                                                    <div class="relative pl-12">
                                                                        {{-- ✅ เพิ่ม id: step2Circle --}}
                                                                        @if( $data->status === 1 ) 
                                                                        <div id="step2Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#0d6efd]/40 bg-[#0d6efd]/25 shadow-[0_0_20px_rgba(13,110,253,0.35)]">
                                                                            &nbsp;⏳
                                                                        </div>
                                                                        @elseif( $data->status === 2) 
                                                                        <div id="step2Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#ffc107]/40 bg-[#ffc107]/25 shadow-[0_0_20px_rgba(255,193,7,0.35)]">
                                                                            &nbsp;⏳
                                                                        </div>
                                                                        @else
                                                                        <div id="step2Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-emerald-400/25 bg-[rgb(25_135_84/0.50)] shadow-[0_0_20px_rgba(25,135,84,0.45)]">
                                                                            <svg viewBox="0 0 24 24" class="h-6 w-6 text-white/95"
                                                                                fill="none" stroke="currentColor" stroke-width="3"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M20 6L9 17l-5-5" />
                                                                            </svg>
                                                                        </div>
                                                                        @endif

                                                                        <div class="relative overflow-hidden rounded-lg border-2 border-[#ffc107]/25 bg-[rgb(255_193_7/0.50)] backdrop-blur-[8px] shadow-lg">
                                                                        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(135deg,rgba(255,255,255,0.20)_0%,rgba(255,255,255,0.05)_30%,transparent_60%)]"></div>
                                                                        <div class="relative p-5">
                                                                            <div class="flex flex-wrap items-center justify-between gap-3">
                                                                            <div class="text-slate-950 dark:text-white font-semibold">Step 2 • กำลังดำเนินการตั้งราคา</div>

                                                                            {{-- ✅ เพิ่ม id: step2Badge (class เหมือนของคุณเป๊ะ) --}}
                                                                            @if( $data->status === 1) 
                                                                                <span id="step2Badge" class="text-xs rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Not Started
                                                                                </span>
                                                                            @elseif ($data->status === 2)
                                                                                <span id="step2Badge" class="text-xs rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                In Progress
                                                                                </span>
                                                                            @else
                                                                                <span id="step2Badge" class="text-xs rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Completed
                                                                                </span>
                                                                            @endif
                                                                            </div>

                                                                            {{-- ✅ เพิ่ม id: step2Desc --}}
                                                                            @if( $data->status === 1) 
                                                                            <div id="step2Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ยังไม่ดำเนินการ...</div>
                                                                            @elseif ($data->status === 2)
                                                                            <div id="step2Desc" class="mt-2 text-sm text-slate-950 dark:text-white">กำลังดำเนินการตั้งราคา...</div>
                                                                            @else
                                                                            <div id="step2Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ดำเนินการเสร็จสมบูรณ์...</div>
                                                                            @endif
                                                                        </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- STEP 3 -->
                                                                    <div class="relative pl-12">
                                                                        {{-- ✅ เพิ่ม id: step3Circle --}}
                                                                        @if( $data->status === 1 ) 
                                                                        <div id="step3Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#0d6efd]/40 bg-[#0d6efd]/25 shadow-[0_0_20px_rgba(13,110,253,0.35)]">
                                                                            &nbsp;⏳
                                                                        </div>
                                                                        @elseif( $data->status === 2) 
                                                                        <div id="step3Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-[#ffc107]/40 bg-[#ffc107]/25 shadow-[0_0_20px_rgba(255,193,7,0.35)]">
                                                                            &nbsp;⏳
                                                                        </div>
                                                                        @else
                                                                        <div id="step3Circle"
                                                                            class="absolute left-0.5 top-2 h-7 w-7 rounded-full border border-emerald-400/25 bg-[rgb(25_135_84/0.50)] shadow-[0_0_20px_rgba(25,135,84,0.45)]">
                                                                            <svg viewBox="0 0 24 24" class="h-6 w-6 text-white/95"
                                                                                fill="none" stroke="currentColor" stroke-width="3"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M20 6L9 17l-5-5" />
                                                                            </svg>
                                                                        </div>
                                                                        @endif

                                                                        <div class="relative overflow-hidden rounded-lg border-2 border-emerald-400/25 bg-[rgb(25_135_84/0.50)] backdrop-blur-[8px] shadow-lg">
                                                                        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(135deg,rgba(255,255,255,0.22)_0%,rgba(255,255,255,0.06)_30%,transparent_60%)]"></div>
                                                                        <div class="relative p-5">
                                                                            <div class="flex flex-wrap items-center justify-between gap-3">
                                                                            <div class="text-slate-950 dark:text-white font-semibold">Step 3 • ดำเนินการเสร็จสมบูรณ์</div>

                                                                            {{-- ✅ เพิ่ม id: step3Badge (class เหมือนของคุณเป๊ะ) --}}
                                                                            @if( $data->status === 1) 
                                                                                <span id="step3Badge" class="text-xs rounded-full border border-[#0d6efd]/30 bg-[#0d6efd]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Not Started
                                                                                </span>
                                                                            @elseif ($data->status === 2)
                                                                                <span id="step3Badge" class="text-xs rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                In Progress
                                                                                </span>
                                                                            @else
                                                                                <span id="step3Badge" class="text-xs rounded-full border border-emerald-400/30 bg-emerald-400/15 px-2 py-0 text-slate-950 dark:text-white">
                                                                                Completed
                                                                                </span>
                                                                            @endif
                                                                            </div>

                                                                            {{-- ✅ เพิ่ม id: step3Desc --}}
                                                                            @if( $data->status === 1) 
                                                                            <div id="step3Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ยังไม่ดำเนินการ...</div>
                                                                            @elseif ($data->status === 2)
                                                                            <div id="step3Desc" class="mt-2 text-sm text-slate-950 dark:text-white">รอการดำเนินการ(Step 2 : กำลังดำเนินการตั้งราคา)...</div>
                                                                            @else
                                                                            <div id="step3Desc" class="mt-2 text-sm text-slate-950 dark:text-white">ดำเนินการเสร็จสมบูรณ์...</div>
                                                                            @endif
                                                                        </div>
                                                                        </div>
                                                                    </div>

                                                                    </div>

                                                        
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="loaderSchedule" class="loading-2 absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <!-- <div id="loader" class="loading-2 absolute bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </li>


                        <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                            <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                    3
                                </span>
                                <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                    ตั้งราคาบัญชี
                                </span>
                            </div>
                            <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
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
                            </div>
                        </li>
                        <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                            <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                    4
                                </span>
                                <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                    ประวัติการปรับราคา
                                </span>
                            </div>
                            <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                <div class="grid grid-cols-5 gap-10">
                                    <div class="form col-span-5">
                                        <div class="relative w-full overflow-hidden">
                                            <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                <h1 class="text-gray-900 dark:text-white text-lg">
                                                    ประวัติการปรับราคา
                                                </h1>
                                            </div>
                                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                                <div id="" class="text-gray-900 dark:text-gray-100">
                                                    <table id="account_schedule_log" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>วันที่เริ่มใช้</th>
                                                                <th>ราคาเดิม</th>
                                                                <!-- <th>ราคาที่ตั้ง</th> -->
                                                                <th>Note</th>
                                                                <th>เคลื่อนไหวเมื่อ</th>
                                                                <th>โดย</th>
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
                            </div>
                        </li>
                    </ul>
                    <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                    <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>

    <script src="{{ asset('js/jquery-validation/jquery.validate.min.js') }}"></script>

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

        // $("#test").on("input", funtion() {
            
        // });

        $("#test_cost").on("input", function(){
            let cost = parseFloat($(this).val()); // รับค่าที่ป้อนใน input
            console.log("🚀 ~ $ ~ cost:", cost)
            if (!isNaN(cost)) { // ตรวจสอบว่าป้อนค่าถูกต้องหรือไม่
                let cost5percent = (cost * 1.05).toFixed(2); // คำนวณ +5% และปัดเป็นทศนิยม 2 ตำแหน่ง
                console.log("🚀 ~ $ ~ cost5percent:", cost5percent)
                let cost10percent = (cost * 1.10).toFixed(2); // คำนวณ +10% และปัดเป็นทศนิยม 2 ตำแหน่ง
                
                $("#cost5percent").val(cost5percent);
                $("#cost10percent").val(cost10percent);
            } else {
                $("#cost5percent").val(""); // ล้างค่าเมื่อป้อนผิด
                $("#cost10percent").val("");
            }
        });

        $("#sale_km").on("input", function(){
            let sale_km = parseFloat($(this).val()); // รับค่าที่ป้อนใน input
            if (!isNaN(sale_km)) { // ตรวจสอบว่าป้อนค่าถูกต้องหรือไม่
                let sale_km20percent = (sale_km * 1.20).toFixed(2); // คำนวณ +10% และปัดเป็นทศนิยม 2 ตำแหน่ง
                
                $("#sale_km20percent").val(sale_km20percent);
            } else {
                $("#sale_km20percent").val(""); // ล้างค่าเมื่อป้อนผิด
            }
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
            document.querySelectorAll('.setcheckbox').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    let el_colr = document.querySelectorAll('.bg_step_color')[index]
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
            onOpenhandler();
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.setcheckbox')[1].checked = true
            document.querySelectorAll('.setcheckbox')[2].checked = true
            document.querySelectorAll('.setcheckbox')[3].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            document.querySelectorAll('.bg_step_color')[1].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[1].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            document.querySelectorAll('.bg_step_color')[2].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[2].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            document.querySelectorAll('.bg_step_color')[3].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[3].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
        });

        let i = 0;
        $('#add').click( () => {
            ++i;
            $('#table').append(
                `<tr>
                    <td>
                        <input class="w-11/12 text-gray-900 text-sm form-control" type="text" name="inputs[`+ i +`][name]" placeholder="Name">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-table-row">Remove</button>
                    </td>
                </tr>`);
        });
        console.log("Index: ", ++i)
        $(document).on('click', '.remove-table-row', function() {
            $(this).parents('tr').remove();
        });

        jQuery('#username_loading').hide();
        jQuery("#username_alert").hide();
        jQuery("#correct_username").hide();

        function checkNameBrand() {
            const edit_id = jQuery('#edit_id').val();
            const name = jQuery('#id_brand').val();

            jQuery.ajax({
                method: "POST",
                url: '{{ route('checknamebrand') }}',
                data: {
                        _token: "{{ csrf_token() }}",
                        edit_id, name
                    },
                dataType: 'json',
                beforeSend: function () {
                    jQuery("#submitButton").attr("disabled", true);
                    jQuery('#username_loading').show();
                    jQuery("#correct_username").hide();
                    jQuery("#username_alert").hide();
                },
                success: function (checknamebrand) {
                    jQuery('#username_loading').hide();
                    jQuery("#correct_username").hide();

                    if (name == '') {
                        jQuery("#submitButton").attr("disabled", false);
                        jQuery("#correct_username").hide();
                        jQuery("#username_alert").hide();
                        jQuery("#id_brand").removeClass("is-invalid");
                    } else if (checknamebrand == true) {
                        jQuery("#submitButton").attr("disabled", false);
                        jQuery("#username_alert").hide();
                        jQuery("#id_brand").removeClass("is-invalid");
                        jQuery("#correct_username").show();
                    } else {
                        jQuery("#username_alert").show();
                        jQuery("#id_brand").addClass("is-invalid");
                        jQuery("#correct_username").hide();
                    }
                },
                error: function (params) {
                }
            });
        }

        function brandIdChange(e, params) {
            console.log("🚀 ~ brandIdChange ~ e:", e.value)
            if(e.value == 'OTHER') {
                jQuery("#add_other").removeClass("invisible");
                document.querySelectorAll('.setcheckbox')[0].checked = false
                document.querySelectorAll('.bg_step_color')[0].classList.add('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                document.querySelectorAll('.bg_step_color')[0].classList.remove('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            } else {
                jQuery("#add_other").addClass("invisible");
                document.querySelectorAll('.setcheckbox')[0].checked = true
                document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            }
            let url = "";
            let select = "";

            if (params === 'BRAND') {
                url = '{{ route('get_brand_list_ajax') }}?BRAND=' + e.value;
                select = jQuery('#NUMBER');
                jQuery('#NUMBER').find("option").remove();
                select.find("option").remove();
                const newop = new Option("--- กรุณาเลือก ---", "");
                jQuery(newop).appendTo(jQuery('#NUMBER'))
            }

            jQuery.ajax({
                method: "GET",
                url,
                dataType: 'json',
                beforeSend: function () {
                    select.find("option").remove();
                    const newoption = new Option("LOADING..", "");
                    jQuery(newoption).appendTo(select)

                },
                success: function (data) {
                    console.log("🚀 ~ brandIdChange ~ data:", data)
                    if (data) {
                        select.find("option").remove();
                        const newop = new Option("--- กรุณาเลือก ---", "");
                        jQuery(newop).appendTo(select)
                        data.map((item, index) => {
                            console.log('item', item)
                            const newoption = new Option(item.Code, item.JOB_REFNO);
                            jQuery(newoption).appendTo(select)
                        });
                    }
                },
                error: function (params) {
                    select.find("option").remove();
                    const newop = new Option("error", "");
                    jQuery(newop).appendTo(select)
                    console.log('ajax error ::', params);
                }
            });
        }

        function onSelect(JOB_REFNO) {
            console.log("🚀 ~ funnctiononSelect ~ r:", JOB_REFNO.value);
            // if (NAME_ENG || JOB_REFNO) {
                $('#NAME_ENG').val(JOB_REFNO.value);
                $('#JOB_REFNO').val(JOB_REFNO.value);
            // } else {
            //     $('#NAME_ENG').val();
            //     $('#JOB_REFNO').val();
            // }
        }


        // ===============================
        // Product Price Schedule (Merged)
        // - AJAX Save
        // - Loading overlay (loaderSchedule)
        // - Clear fields + reset validate (ป้องกันยิงซ้ำ/ค้าง error)
        // - Realtime cross-tab (storage)
        // - Reverb realtime (optional)
        // - Render status realtime (update DOM จริง)
        // - After Save => clearAccountNotiForProduct + badge sync
        // ===============================

        const dlayMessage = 500;

        // ======================
        // Loader helpers
        // ======================
        function showScheduleLoader() { $('#loaderSchedule').removeClass('hidden').addClass('flex'); }
        function hideScheduleLoader() { $('#loaderSchedule').addClass('hidden').removeClass('flex'); }

        // ======================
        // Form helpers
        // ======================
        function getCode() { return String($('#Code').val() || '').trim(); }          // ต้องมี input#Code ในหน้า
        function resetValidateUI() {
            const $form = $('#updateProductPriceSchedule');
            try {
                const validator = $form.data('validator') || $form.validate();
                if (validator && validator.resetForm) validator.resetForm();
            } catch (e) {}
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('label.error, div.invalid-feedback').remove();
        }

        function resetScheduleFields() {
            // ต้องมี input#price และ input#active_date ในหน้า
            $('#price').val('');
            $('#active_date').val('');
        }

        function resetScheduleUI() {
            showScheduleLoader();
            resetScheduleFields();
            resetValidateUI();
            setTimeout(() => hideScheduleLoader(), 500);
            console.log('🟦 resetScheduleUI done');
        }

        // ======================
        // Cross-tab signals
        // ======================
        function broadcastResetToOtherTabs(productCode) {
            try {
                localStorage.setItem('account_schedule_reset', JSON.stringify({
                product: String(productCode || ''),
                ts: Date.now()
                }));
            } catch (e) {}
        }

        function broadcastStatusToOtherTabs(productCode, status) {
            try {
                localStorage.setItem('account_schedule_status', JSON.stringify({
                product: String(productCode || ''),
                status: Number(status) || 1,
                ts: Date.now()
                }));
            } catch (e) {}
        }

        // ✅ รับสัญญาณ reset/status จาก tab อื่น
        window.addEventListener('storage', function (event) {
            // reset
            if (event.key === 'account_schedule_reset') {
                try {
                const payload = JSON.parse(event.newValue || '{}');
                const code = getCode();
                if (payload?.product && code && String(payload.product) === code) {
                    resetScheduleUI();
                }
                } catch (e) {}
            }

            // status update
            if (event.key === 'account_schedule_status') {
                try {
                const payload = JSON.parse(event.newValue || '{}');
                const code = getCode();
                if (payload?.product && code && String(payload.product) === code) {
                    renderStatus(payload.status);
                }
                } catch (e) {}
            }
        });

        // ======================
        // Render status (update DOM จริง) - MERGED ล่าสุด
        // ======================
        function renderStatus(status) {
            const s = Number(status) || 1;
            $('#updateProductPriceSchedule').attr('data-status', String(s));

            const label = (s === 1) ? 'Not Started' : (s === 2) ? 'In Progress' : 'Completed';

            function setBadgeStyle($el, s) {
                if (!$el || !$el.length) return;

                // ใช้ class เดิมของคุณเป๊ะ
                $el.removeClass(
                    'border-[#0d6efd]/30 bg-[#0d6efd]/15 ' +
                    'border-[#ffc107]/30 bg-[#ffc107]/15 ' +
                    'border-emerald-400/30 bg-emerald-400/15'
                );

                if (s === 1) $el.addClass('border-[#0d6efd]/30 bg-[#0d6efd]/15');
                else if (s === 2) $el.addClass('border-[#ffc107]/30 bg-[#ffc107]/15');
                else $el.addClass('border-emerald-400/30 bg-emerald-400/15');
            }

            function setCircleStyle($el, theme) {
                if (!$el || !$el.length) return;

                // theme: primary|warning|success (โทนสีตาม step)
                $el.removeClass(
                    'border-[#0d6efd]/40 bg-[#0d6efd]/25 ' +
                    'border-[#ffc107]/40 bg-[#ffc107]/25 ' +
                    'border-emerald-400/25 bg-[rgb(25_135_84/0.50)]'
                );

                if (theme === 'primary') $el.addClass('border-[#0d6efd]/40 bg-[#0d6efd]/25');
                else if (theme === 'warning') $el.addClass('border-[#ffc107]/40 bg-[#ffc107]/25');
                else $el.addClass('border-emerald-400/25 bg-[rgb(25_135_84/0.50)]');
            }

            function setCircleHtml($el, isDone) {
                if (!$el || !$el.length) return;

                if (isDone) {
                $el.html(`
                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-white/95"
                    fill="none" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5" />
                    </svg>
                `);
                } else {
                    $el.html('&nbsp;⏳');
                }
            }

            // ======================
            // 1) LEFT badge (หัวข้อเอกสาร)
            // ======================
            const $topic = $('#topicStatusBadge');
            if ($topic.length) {
                $topic.text(label);
                setBadgeStyle($topic, s);
            }

            // ======================
            // 2) STEP badges
            // ======================
            const $b1 = $('#step1Badge'), $b2 = $('#step2Badge'), $b3 = $('#step3Badge');
            if ($b1.length) { $b1.text(label); setBadgeStyle($b1, s); }
            if ($b2.length) { $b2.text(label); setBadgeStyle($b2, s); }
            if ($b3.length) { $b3.text(label); setBadgeStyle($b3, s); }

            // ======================
            // 3) STEP descriptions (ตาม Blade เดิมของคุณ)
            // ======================
            const $d1 = $('#step1Desc'), $d2 = $('#step2Desc'), $d3 = $('#step3Desc');

            if ($d1.length) {
                $d1.text(
                s === 1 ? 'ยังไม่ดำเนินการ...' :
                s === 2 ? 'ดำเนินการแล้ว...' :
                        'ดำเนินการเสร็จสมบูรณ์...'
                );
            }

            if ($d2.length) {
                $d2.text(
                s === 1 ? 'ยังไม่ดำเนินการ...' :
                s === 2 ? 'กำลังดำเนินการตั้งราคา...' :
                        'ดำเนินการเสร็จสมบูรณ์...'
                );
            }

            if ($d3.length) {
                $d3.text(
                s === 1 ? 'ยังไม่ดำเนินการ...' :
                s === 2 ? 'รอการดำเนินการ(Step 2 : กำลังดำเนินการตั้งราคา)...' :
                        'ดำเนินการเสร็จสมบูรณ์...'
                );
            }

            // ======================
            // 4) CIRCLES (ให้ตรง Blade ของคุณ)
            // - สีวงกลมทั้ง 3 เปลี่ยนตาม "สถานะรวม" (s)
            //   s=1 => primary(น้ำเงิน), s=2 => warning(เหลือง), s=3 => success(เขียว)
            // - ไอคอน:
            //   Step1 done เมื่อ s>=2
            //   Step2 done เมื่อ s>=3
            //   Step3 done เมื่อ s>=3
            // ======================
            const $c1 = $('#step1Circle'), $c2 = $('#step2Circle'), $c3 = $('#step3Circle');

            // theme เดียวกันทั้ง 3 วง ตาม status รวม
            const themeAll = (s === 1) ? 'primary' : (s === 2) ? 'warning' : 'success';

            // set สีวงกลมทั้ง 3 ให้เหมือนกัน
            setCircleStyle($c1, themeAll);
            setCircleStyle($c2, themeAll);
            setCircleStyle($c3, themeAll);

            // set ไอคอนตาม step จริง
            const step1Done = (s >= 2);
            const step2Done = (s >= 3);
            const step3Done = (s >= 3);

            setCircleHtml($c1, step1Done);
            setCircleHtml($c2, step2Done);
            setCircleHtml($c3, step3Done);

            console.log('🟩 renderStatus circles', { s, themeAll, step1Done, step2Done, step3Done });
        }

        // ======================
        // Validate + Submit (ถ้าคุณใช้ validate กับฟอร์มนี้ด้วย)
        // ======================
        $(function () {
            // ถ้าคุณไม่ได้มี input ในฟอร์มนี้จริง ๆ ให้เอา validate ออก
            $('#update_product_account').validate({
                errorClass: 'text-danger invalid-feedback',
                errorElement: 'div',
                highlight: function(element) { $(element).addClass('is-invalid'); },
                unhighlight: function(element) { $(element).removeClass('is-invalid'); },
                rules: {
                price: { required: true },
                active_date: { required: true }
                },
                messages: {
                price: { required: "กรุณากรอกราคา" },
                active_date: { required: "กรุณาเลือกวันที่จะตั้งราคา" }
                },
                errorPlacement: function(error, element) { error.insertAfter(element); },
                submitHandler: function(form) {
                accountSchedule();
                return false;
                }
            });
        });

        // ======================
        // AJAX Save
        // ======================
        function accountSchedule() {
            jQuery.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') }
            });

            $.ajax({
                method: "POST",
                url: "{{ route('account.update_account_schedule', $data->product) }}",
                data: $("#update_product_account").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                    showScheduleLoader();
                },
                success: function(res) {
                if (res.success == true) {

                    const productCode = getCode();

                    // ✅ ลบแจ้งเตือนของ product ตัวนี้ + badge
                    if (productCode && typeof window.clearAccountNotiForProduct === 'function') {
                    window.clearAccountNotiForProduct(productCode);
                    }

                    // ✅ render status ทันทีจาก server
                    if (typeof res.status !== 'undefined') {
                    renderStatus(res.status);
                    broadcastStatusToOtherTabs(productCode, res.status);
                    }

                    // ✅ reset UI tab นี้ + tab อื่น
                    resetScheduleUI();
                    broadcastResetToOtherTabs(productCode);

                    // ✅ badge_count sync (ถ้ามี)
                    if (typeof res.badge_count !== 'undefined') {
                        const next = Math.max(0, Number(res.badge_count) || 0);
                        localStorage.setItem('account_badge_count', String(next));
                        if (typeof window.renderAccountBadge === 'function') window.renderAccountBadge(next);
                        if (typeof window.renderAccountNotiListBadge === 'function') window.renderAccountNotiListBadge(next);
                    }

                    toastr.success("อัปเดทราคาสำเร็จ!");
                    $('#loader').addClass('hidden');
                    setTimeout(() => hideScheduleLoader(), dlayMessage);

                } else {
                    toastr.error("Can't Set Schedule!");
                    setTimeout(() => hideScheduleLoader(), dlayMessage);
                }
                return false;
                },
                error: function () {
                setTimeout(() => toastr.error("Can't Set Schedule!"), dlayMessage);
                setTimeout(() => hideScheduleLoader(), dlayMessage);
                }
            });
        }

        // ======================
        // ✅ Reverb (optional hook)
        // ======================
        // ถ้าคุณมี Echo อยู่แล้ว ให้เปิด listen นี้ (ปรับชื่อ event ให้ตรงของคุณ)
        if (window.Echo && window.Echo.private) {
        window.Echo.private('account.global')
            .listen('.account.price.schedule.updated', function (e) {
            // e ควรมี product + status
            const code = String(e?.product ?? e?.data?.product ?? '');
            const status = Number(e?.status ?? e?.data?.status ?? 1);

            // ถ้าเปิดอยู่สินค้าตัวเดียวกัน
            if (code && code === getCode()) {
                showScheduleLoader();
                renderStatus(status);
                resetScheduleUI();
                hideScheduleLoader();

                // cross-tab
                broadcastStatusToOtherTabs(code, status);
                broadcastResetToOtherTabs(code);
            }
            });
        }

        function successMessage(text) {
            $('#loader').addClass('hidden');
            $('#name').val('')
        }
        function errorMessage(text) {
            $('#loader').addClass('hidden');
            $('#name').val('')
        }

        const PRODUCT_ID = @json($data->product);

        const mytableDatatable = $('#account_schedule').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            ordering: false,
            orderCellsTop: true,
            // scrollX: true,
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('account.list_account_schedule') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.product_id = PRODUCT_ID;          // ✅ ส่งตัวนี้เพิ่ม
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            rowCallback: function(row, data, index) {
                // ถ้า product_id ไม่ตรงเงื่อนไข ให้ซ่อนแถวนี้
                if (data.product_id != {{ $data->product }}) {
                    $(row).hide(); // หรือ $(row).remove();
                }
            },
            orderable: true,
            columnDefs: [
                {
                    targets: 0,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        let scheduleStatus = '';
                            if(row.status == 0) {
                                scheduleStatus = `
                                            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                            class="animate-quarter-spin iconify iconify--emojione mb-0.5 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" preserveAspectRatio="xMidYMid meet">
                                            <path d="M36.9 33.6c-1.6-.5-2.6-.7-2.6-1.6c0-.8 1-1 2.6-1.6C45.6 28 48.1 21.7 48.1 11H15.9c0 10.7 2.5 17 11.2 19.4c1.6.5 2.6.7 2.6 1.6c0 .9-1 1-2.6 1.6C18.4 36 15.9 42.3 15.9 53h32.2c0-10.7-2.5-17-11.2-19.4" fill="#e5e5e5"></path>
                                            <path d="M35.5 33.6c-1.2-.5-1.9-.7-1.9-1.6c0-.8.7-1 1.9-1.6c6.3-2.5 6.9-8.8 6.9-19.4H21.6c0 10.7.6 17 6.9 19.4c1.2.5 1.9.7 1.9 1.6c0 .9-.7 1-1.9 1.6c-6.3 2.5-6.9 8.8-6.9 19.4h20.9c-.1-10.7-.7-17-7-19.4" fill="#f5f5f5"></path>
                                            <path d="M32.9 53s-.6-17.9-.6-21c0-.8 1.6-2 2.3-2.4c3.1-1.8 7-5.3 7-8.9H22.3c0 3.7 4 7.2 7 8.9c.7.4 2.3 1.6 2.3 2.4c0 3.2-.6 21-.6 21h1.9" fill="#428bc1"></path>
                                            <g fill="#212528">
                                                <path d="M56 62c0 1.1-.8 2-1.9 2H9.9c-1 0-1.9-.9-1.9-2v-3c0-1.1.8-2 1.9-2h44.3c1 0 1.9.9 1.9 2l-.1 3"></path>
                                                <path d="M50 10.2c0 .4-.4.8-.9.8H14.9c-.5 0-.9-.4-.9-.8V7.8c0-.4.4-.8.9-.8h34.2c.5 0 .9.4.9.8v2.4"></path>
                                            </g>
                                            <path d="M45 10.2c0 .4-.3.8-.7.8H19.7c-.4 0-.7-.4-.7-.8V7.8c0-.4.3-.8.7-.8h24.6c.4 0 .7.4.7.8v2.4" fill="#51575b"></path>
                                            <g fill="#212528">
                                                <path d="M50 56.2c0 .4-.4.8-.9.8H14.9c-.5 0-.9-.4-.9-.8v-2.4c0-.4.4-.8.9-.8h34.2c.5 0 .9.4.9.8v2.4"></path>
                                                <path d="M56 5c0 1.1-.8 2-1.9 2H9.9C8.8 7 8 6.1 8 5V2c0-1.1.8-2 1.9-2h44.3c1 0 1.9.9 1.9 2L56 5"></path>
                                            </g>
                                            <g fill="#51575b">
                                                <path d="M50 5c0 1.1-.7 2-1.5 2h-33c-.8 0-1.5-.9-1.5-2V2c0-1.1.7-2 1.5-2h33.1c.7 0 1.4.9 1.4 2v3"></path>
                                                <path d="M50 62c0 1.1-.7 2-1.5 2h-33c-.8 0-1.5-.9-1.5-2v-3c0-1.1.7-2 1.5-2h33.1c.8 0 1.5.9 1.5 2c-.1 0-.1 3-.1 3"></path>
                                            </g>
                                            <path fill="#919191" d="M12 7h1v50h-1z"></path>
                                            <path fill="#cecece" d="M11 7h1v50h-1z"></path>
                                            <path fill="#919191" d="M52 7h1v50h-1z"></path>
                                            <path fill="#cecece" d="M51 7h1v50h-1z"></path>
                                            <path d="M45 56.2c0 .4-.3.8-.7.8H19.7c-.4 0-.7-.4-.7-.8v-2.4c0-.4.3-.8.7-.8h24.6c.4 0 .7.4.7.8v2.4" fill="#51575b"></path>
                                        </svg>
                                        รอดำเนินการตั้งราคา
                                `;
                            } else if (row.status == 1) {
                                scheduleStatus = `
                                ✅ ดำเนินการตั้งราคาแล้ว
                                 `;
                            }
                        return scheduleStatus != "" ? scheduleStatus : "-";
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.active_date;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return `
                                <span class="inline-flex min-w-[200px] items-center justify-start gap-1 whitespace-nowrap
                                    rounded-full border border-[#ffc107]/30 bg-[#ffc107]/15
                                    px-2 py-0 text-base font-semibold text-slate-950 dark:text-white">
                                ⌛ ${row.price}
                                </span>
                            `;

                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.cost_old;
                    }
                }
            ],
        });

        const mytableDatatableLog = $('#account_schedule_log').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            ordering: false,
            orderCellsTop: true,
            // scrollX: true,
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('account.list_account_schedule_log') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            rowCallback: function(row, data, index) {
                // ถ้า product_id ไม่ตรงเงื่อนไข ให้ซ่อนแถวนี้
                if (data.product_id != {{ $data->product }}) {
                    $(row).hide(); // หรือ $(row).remove();
                }
            },
            orderable: true,
            columnDefs: [
                {
                    targets: 0,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.active_date;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {

                        return `
                                <span class="inline-flex min-w-[200px] items-center justify-start gap-1 whitespace-nowrap
                                    rounded-full border border-[#dc3545]/30 bg-[#dc3545]/15
                                    px-2 py-0 text-base font-semibold text-slate-950 dark:text-white"
                                >
                                    <svg viewBox="0 0 24 24" class="h-5 w-5 text-white/95"
                                        fill="none" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6L9 17l-5-5" />
                                    </svg>
                                        ${row.price_log}
                                </span>
                            `;
                    }
                },
                // {
                //     targets: 2,
                //     orderable: true,
                //     defaultContent: "-",
                //     render: function(data, type, row) {
                //         return row.price_log;
                //     }
                // },
                {
                    targets: 2,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.note;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.update_dt;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    defaultContent: "-",
                    render: function(data, type, row) {
                        return row.user_update;
                    }
                }
            ]
        });

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            mytableDatatableLog.draw();
            return false;
        });
        
    </script>
@endsection