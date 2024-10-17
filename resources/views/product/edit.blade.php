@extends('layouts.layout')
@section('title', '')

    <style>
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
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
        .select2-container--default .select2-selection--multiple {
            height: 55%!important;
            min-height: 50%!important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 12px!important;
            padding-right: 5px;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">ทะเบียนสินค้า</p>
            </div>
            <form class="" action="" method="POST" id="update_product_master">
                <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="lg:col-span-4 xl:grid-cols-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                            <div class="md:col-span-3" style="position: relative;">
                                <label for="BRAND">Brand</label>
                                <input type="text" name="BRAND" id="BRAND" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->BRAND }}" readonly>
                            </div>
                            <div class="md:col-span-3" style="position: relative;">
                                <label for="Code">รหัส</label>
                                <input type="text" name="Code" id="Code" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-red-600 dark:text-red-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->PRODUCT }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="fixed flex bottom-5 right-5 z-10 invisible" id="add_other">
                    <a
                        type="button"
                        class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group"
                        data-twe-toggle="modal"
                        data-twe-target="#exampleModalLg"
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        onclick=""
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 font-bold">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div
                    data-twe-modal-init
                    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
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
                                <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel">
                                    Other
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
                                        <div class="md:col-span-3" style="position: relative;">
                                            <label for="">ชื่อผลิตภัณฑ์</label>
                                            <input type="text" name="menu_name" id="menu_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                        <div class="md:col-span-3" style="position: relative;">
                                            <label for="">ปริมาณสุทธิ</label>
                                            <input type="text" name="url" id="url_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                        <div class="md:col-span-3" style="position: relative;">
                                            <label for="">จำนวนกลิ่น</label>
                                            <input type="text" name="url" id="url_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                        <div class="md:col-span-3" style="position: relative;">
                                            <label for="">จำนวนสี</label>
                                            <input type="text" name="url" id="url_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                        </div>
                                        <div class="md:col-span-6">
                                            <label for="P_CONCEPT" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">หมายเหตุ</label>
                                            <textarea id="P_CONCEPT" name="P_CONCEPT" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 ">
                                    <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                                </div>
                                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                                    <a class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createMenu()">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                        </svg>
                                        Save
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
                </div> -->

                <div class='w-12/12 mt-4 relative'>
                    <div class="p-4">
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        1
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด1
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        รายละเอียด1
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
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="BARCODE">รหัส Barcode</label>
                                                                    <input type="text" name="BARCODE" id="BARCODE" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->BARCODE }}" readonly/>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Sele Channel</label>
                                                                    <select class="js-example-basic-multiple w-full rounded-sm text-xs select2" id="multiSelect" name="sele_channel[]" multiple="multiple">
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" >
                                                                    <label for="NUMBER">Sele Channel</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="katanyu" name="katanyu" onchange="onSelect(this, 'BARCODE')">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div> -->
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="NAME_THAI">ชื่อภาษาไทย</label>
                                                                    <input type="text" name="NAME_THAI" id="NAME_THAI" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->NAME_THAI }}" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="SHORT_THAI">ชื่อย่อภาษาไทย</label>
                                                                    <input type="text" name="SHORT_THAI" id="SHORT_THAI" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->SHORT_THAI }}" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="NAME_ENG">ชื่อภาษาอังกฤษ</label>
                                                                    <input type="text" name="NAME_ENG" id="NAME_ENG" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->NAME_ENG }}" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="SHORT_ENG">ชื่อย่อภาษาอังกฤษ</label>
                                                                    <input type="text" name="SHORT_ENG" id="SHORT_ENG" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->SHORT_ENG }}" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">เจ้าของสินค้า</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="VENDOR" id="VENDOR">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($owners as $key => $owner)
                                                                            <option value={{ $owner->VENDOR }} {{ $owner->VENDOR == $data->VENDOR ? 'selected' : '' }}>{{ $owner->VENDOR.' - ('.$owner->REMARK.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">วันที่สรา้งทะเบียน</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" data-date-format="dd/mm/yyyy" placeholder="" autocomplete="off" value="{{ $data->REG_DATE }}" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">สินค้าของบริษัท</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="GRP_P" id="GRP_P">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($grp_ps as $key => $grp_p)
                                                                            <option value={{ $grp_p->GRP_P }} {{ $grp_p->GRP_P == $data->GRP_P ? 'selected' : '' }}>{{ $grp_p->GRP_P.' - ('.$grp_p->REMARK.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="AGE">อายุการใช้งาน</label>
                                                                    <input type="text" name="AGE" id="AGE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->AGE }}" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">กลุ่มสินค้า</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="BRAND_P" id="BRAND_P">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($brand_ps as $key => $brand_p)
                                                                            <option value={{ $brand_p->BRAND_P }} {{ $brand_p->BRAND_P == $data->BRAND_P ? 'selected' : '' }}>{{ $brand_p->BRAND_P.' - ('.$brand_p->REMARK.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="WHOLE_SALE">ราคาใบสั่งซื้อ</label>
                                                                    <input type="text" name="WHOLE_SALE" id="WHOLE_SALE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->WHOLE_SALE }}" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ผู้ขาย/ผู้ผลิต</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="SUPPLIER" id="SUPPLIER">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($venders as $key => $vender)
                                                                            <option value={{ $vender->SUPPLIER }} {{ $vender->SUPPLIER == $data->SUPPLIER ? 'selected' : '' }}>{{ $vender->SUPPLIER.' - ('.$vender->VEN_NTHAI.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="REGISTER">เลขที่ อย.</label>
                                                                    <input type="text" name="REGISTER" id="REGISTER" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->REGISTER }}" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ประเภทสินค้า</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="TYPE_G" id="TYPE_G">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($type_gs as $key => $type_g)
                                                                            <option value={{ $type_g->TYPE_G }} {{ $type_g->TYPE_G == $data->TYPE_G ? 'selected' : '' }}>{{ $type_g->TYPE_G.' - ('.$type_g->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">รหัสสินค้าอ้างอิง</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Solution</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="SOLUTION" id="SOLUTION">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($solutions as $key => $solution)
                                                                            <option value={{ $solution->SOLUTION }} {{ $solution->SOLUTION == $data->SOLUTION ? 'selected' : '' }}>{{ $solution->SOLUTION.' - ('.$solution->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <!-- <div class="md:col-span-3">
                                                                    <label for="name">Series</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="SERIES" id="SERIES">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($series as $key => $serie)
                                                                            <option value={{ $serie->SERIES }} {{ $serie->SERIES == $data->SERIES ? 'selected' : '' }}>{{ $serie->SERIES.' - ('.$serie->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> -->
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Category</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="CATEGORY" id="CATEGORY">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($categorys as $key => $category)
                                                                            <option value={{ $category->CATEGORY }} {{ $category->CATEGORY == $data->CATEGORY ? 'selected' : '' }}>{{ $category->CATEGORY.' - ('.$category->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Sub Category</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="S_CAT" id="S_CAT">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($sub_categorys as $key => $sub_category)
                                                                            <option value={{ $sub_category->S_CAT }} {{ $sub_category->S_CAT == $data->S_CAT ? 'selected' : '' }}>{{ $sub_category->S_CAT.' - ('.$sub_category->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-3">
                                                                    <label for="name">PDM GROUP</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="PDM_GROUP" id="PDM_GROUP">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($pdms as $key => $pdm)
                                                                            <option value={{ $pdm->PDM_GROUP }} {{ $pdm->PDM_GROUP == $data->PDM_GROUP ? 'selected' : '' }}>{{ $pdm->PDM_GROUP.' - ('.$pdm->REMARK.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div> -->
                                                                <div class="md:col-span-3">
                                                                    <label for="name">สถานะสินค้า</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="STATUS" id="STATUS">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($p_statuss as $key => $p_status)
                                                                            <option value={{ $p_status->STATUS }} {{ $p_status->STATUS == $data->STATUS ? 'selected' : '' }}>{{ $p_status->STATUS.' - ('.$p_status->DESCRIPTION.')'}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
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
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        2
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด2
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        รายละเอียด2
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
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-3">
                                                                    <label for="name">รหัส Packsize1</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE1" id="PACK_SIZE1">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                
                                                                <div class="md:col-span-3">
                                                                    <label for="name">รหัส Packsize2</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE2" id="PACK_SIZE2">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                    
                                                                <div class="md:col-span-3">
                                                                    <label for="name">รหัส Packsize3</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE3" id="PACK_SIZE3">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                
                                                                <div class="md:col-span-3">
                                                                    <label for="name">รหัส Packsize4</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="PACK_SIZE4" id="PACK_SIZE4">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="WIDTH">ความกว้าง</label>
                                                                    <input type="text" name="WIDTH" id="WIDTH" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="WIDE">ความยาว</label>
                                                                    <input type="text" name="WIDE" id="WIDE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="HEIGHT">ความสูง</label>
                                                                    <input type="text" name="HEIGHT" id="HEIGHT" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="PRICE">ราคาขาย</label>
                                                                    <input type="text" name="PRICE" id="PRICE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="COST">ราคาต้นทุน</label>
                                                                    <input type="text" name="COST" id="COST" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="UNIT_Q">ปริมาณการบรรจุ</label>
                                                                    <input type="text" name="UNIT_Q" id="UNIT_Q" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="GP">ส่วนลด GP</label>
                                                                    <input type="text" name="GP" id="GP" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">หน่วยสินค้า</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="UNIT" id="UNIT">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">หน่วยปริมาณ</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="UNIT_TYPE" id="UNIT_TYPE">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ประเภทสินค้า [บัญชี]</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="ACC_TYPE" id="ACC_TYPE">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-1">
                                                                    <label for="name">เงื่อนไขชำระเงิน</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="CONDITION_SALE" id="CONDITION_SALE">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>

                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">&nbsp;</label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">DL</label>
                                                                    <input type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">CPS</label>
                                                                    <input type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">EXP</label>
                                                                    <input type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3 mt-2">
                                                                    <div class="md:col-span-4 mt-7">
                                                                        <input type="radio" id="PACKAGE_BOX_TYPE1" name="PACKAGE_BOX" value="1" />
                                                                        <label for="" class="mr-5">ไม่ Share</label>
                                                                        <input type="radio" id="PACKAGE_BOX_TYPE2" name="PACKAGE_BOX" value="0" />
                                                                        <label for="">Share</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-3 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                    <div class="md:col-span-1 mt-2">
                                                                        <input type="checkbox" id="RETURN" name="RETURN" value="1" @if ($data->RETURN == 'Y') checked @endif>
                                                                        <label for="RETURN">คืนซาก</label>
                                                                    </div>
                                                                    <div class="md:col-span-1 mt-5">
                                                                        <input type="checkbox" id="NON_VAT" name="NON_VAT" value="1" @if ($data->NON_VAT == 'Y') checked @endif>
                                                                        <label for="NON_VAT">ไม่มี Vat</label>
                                                                    </div>
                                                                    <div class="md:col-span-1 mt-5">
                                                                        <input type="checkbox" id="STORAGE_TEMP" name="STORAGE_TEMP" value="1" @if ($data->STORAGE_TEMP == 'Y') checked @endif>
                                                                        <label for="STORAGE_TEMP">จัดเก็บในห้องรักษาอุณหภูมิ</label>
                                                                    </div>
                                                                    <div class="md:col-span-1 mt-5">
                                                                        <input type="checkbox" id="CONTROL_STK" name="CONTROL_STK" value="1" @if ($data->CONTROL_STK == 'Y') checked @endif>
                                                                        <label for="CONTROL_STK">ไม่คุม Stock สาขา</label>
                                                                    </div>
                                                                    <div class="md:col-span-1 mt-5">
                                                                        <input type="checkbox" id="TESTER" name="TESTER" value="1" @if ($data->TESTER == 'Y') checked @endif>
                                                                        <label for="TESTER">มี Tester</label>
                                                                    </div>
                                                                    <ul class="width-full pt-2.5 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                </div>
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
                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="md:col-span-6 text-right mt-4">
                            <div class="inline-flex items-end">
                                <a href="{{ route('product.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <a class=" bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-1.5 px-4 rounded cursor-pointer" onclick="editProductMaster()" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 w-5 h-5 hidden md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    
    <script>

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
            $('.js-example-basic-single').select2();
            let placeholder = "--- กรุณาเลือก ---";
            $('#multiSelect').select2({
                closeOnSelect: false,
            });

            let obj = <?php echo json_encode($multiChannels); ?>;
            console.log("🚀 ~ $ ~ obj:", obj)
            let allObj = <?php echo json_encode($allBrands); ?>;
            allObj.forEach(function(e){
                if(!$('#multiSelect').find('option:contains(' + e + ')').length) {
                    var newOption = new Option(e, e, false, false);
                    $('#multiSelect').append(newOption).trigger('change');
                }
            });

            setTimeout(function() {
                $('#multiSelect').val(obj).trigger("change");
            }, 600);

            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
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

        const dlayMessage = 1000;
        function editProductMaster() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('product.update', $data->PRODUCT) }}",
                data: $("#update_product_master").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        window.location = "/product";
                    } else {
                        toastr.error("Can't Create Product!");
                    }
                    return false;
                },
                error: function (params) {
                    setTimeout(function() {
                        errorMessage("Can't Create Username!");
                    },dlayMessage)
                    setTimeout(function() {
                        toastr.error("Can't Create Username!");
                    },dlayMessage)
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
    </script>
@endsection
