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
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">New Product Development Request</p>
            </div>
            <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                <div class="lg:col-span-4 xl:grid-cols-4">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        <!-- <div class="md:col-span-2" >
                            <label for="name">Customer</label>
                            <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                        </div>
                        <div class="md:col-span-2" >
                            <label for="name">รหัสสินค้า</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="product_id" name="product_id" onchange="onSelect(this)">
                                <option value=""> --- กรุณาเลือก ---</option>
                            </select>
                        </div> -->
                        <!-- @if (Auth::user()->getUserPermission->name_position == "Superadmin" || Auth::user()->getUserPermission->name_position == "Superadmin")

                        @endif -->
                        <div class="md:col-span-3">
                            <label for="NUMBER">Brand</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="brand_id" onchange="brandIdChange(this, 'BRAND')">
                                <option value=""> --- กรุณาเลือก ---</option>
                                @foreach ($brands as $key => $brand)
                                    <option value={{ $brand }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-3" >
                            <label for="NUMBER">รหัส</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="NUMBER" name="NUMBER" onchange="onSelect(this)">
                                <option value=""> --- กรุณาเลือก ---</option>
                            </select>
                        </div>
                        <!-- <div class="fixed flex bottom-5 right-5 z-10 invisible" id="add_other">
                            <a href="#" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-2 mr-2 mt-20 rounded-full group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div> -->
                        <!-- <div class="md:col-span-3">
                            <label for="NUMBER">รหัสสินค้า</label>
                            <input type="text" name="NUMBER" id="NUMBER" class="h-10 rounded-sm px-4 text-center bg-[#e7e7e7] border border-gray-900 text-red-600 dark:text-red-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="{{ $productCode }}" disabled>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class='w-12/12 mt-4 relative'>
                <form class="" action="" method="POST" id="create_NPDRequest">
                    <input type="hidden" id="DOC_TP" name="DOC_TP" value="OP">
                    <input type="hidden" id="BRAND" name="BRAND" value="OP">
                    <div class="p-4">
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <!-- <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[2.45rem] after:top-[3.6rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-6 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        1
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        step1
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[3.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        Primary Form Tab1
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
                                                                <div class="md:col-span-2">
                                                                    <label for="seq">Item No.</label>
                                                                    <input type="text" name="seq" id="seq" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-[#101010] dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="{{ $productCode }}" disabled>
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">สิ้นค้าของบริษัท<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="company_products" id="company_products" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">Bar Code<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">ชื่อภาษาไทย<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">ชื่อย่อภาษาไทย<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">ชื่อภาษาอังกฤษ<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">ชื่อย่อภาษาอังกฤษ<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 ">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-500"></ul>
                                                    </div>
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-4">
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-3">
                                                                    <label for="name">เจ้าของสินค้า<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">วันที่สรา้งทะเบียน<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">สินค้าของบริษัท<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">อายุการใช้งาน<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">กลุ่มสินค้า<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">ราคาใบสั่งซื้อ<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ผู้ขาย/ผู้ผลิต<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">เลขที่ อย.<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ประเภทสินค้า<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">รหัสสินค้าอ้างอิง<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">สถานะสินค้า<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">PDM GROUP<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="state">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($list_position as $key => $list_positions)
                                                                            <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="name">รหัสสินค้าเก่า<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li> -->
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        1
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียดผลิตภัณฑ์
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                                <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        รายละเอียดผลิตภัณฑ์
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
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="DOC_NO">หมายเลขเอกสาร</label>
                                                                    <input type="text" name="DOC_NO" id="DOC_NO" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="BARCODE">Barcode<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="BARCODE" id="BARCODE" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="{{ $digits_barcode }}" disabled>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="JOB_REFNO">Job Ref. No.</label>
                                                                    <input type="text" name="JOB_REFNO" id="JOB_REFNO" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" >
                                                                    <label for="DOC_DT">วันที่</label>
                                                                    <input type="date" name="DOC_DT" id="DOC_DT" style="height: 38px;" class="form-control border-[#303030] bg-white dark:bg-[#303030] text-gray-900 dark:text-gray-100 rounded-sm cursor-pointer" data-date-format="dd/mm/yyyy" name="" id="" placeholder="" autocomplete="off" value="<?php echo date('Y-m-d'); ?>">
                                                                </div>
                                                                <div class="md:col-span-6" style="position: relative;">
                                                                    <label for="CUST_OEM">Customer (OEM)</label>
                                                                    <input type="text" name="CUST_OEM" id="CUST_OEM" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" >
                                                                    <label for="NPD">Product Co-ordinator<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="NPD" name="NPD">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($product_co_ordimators as $key => $product_co_ordimator)
                                                                            <option value={{ $product_co_ordimator->ID }}>{{ $product_co_ordimator->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" >
                                                                    <label for="PDM">Marketing Mamager<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="PDM" name="PDM">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($marketing_managers as $key => $marketing_manager)
                                                                            <option value={{ $marketing_manager->ID }}>{{ $marketing_manager->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-6" style="position: relative;">
                                                                    <label for="NAME_ENG">ชื่อผลิตภัณฑ์</label>
                                                                    <input type="text" name="NAME_ENG" id="NAME_ENG" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" >
                                                                    <label for="CATEGORY">ประเภทผลิตภัณฑ์<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="CATEGORY" name="CATEGORY">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($type_categorys as $key => $type_category)
                                                                            <option value={{ $type_category->ID }}>{{ $type_category->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="CAPACITY">ปริมาณสุทธิ</label>
                                                                    <input type="text" name="CAPACITY" id="CAPACITY" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="Q_SMELL">จำนวนกลิ่น</label>
                                                                    <input type="text" name="Q_SMELL" id="Q_SMELL" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="Q_COLOR">จำนวนสี</label>
                                                                    <input type="text" name="Q_COLOR" id="Q_COLOR" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="TARGET_GRP">Target Group</label>
                                                                    <input type="text" name="TARGET_GRP" id="TARGET_GRP" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" >
                                                                    <label for="TARGET_STK">Target Launch Date</label>
                                                                    <input type="date" name="TARGET_STK" id="TARGET_STK" style="height: 38px;" class="form-control border-[#303030] bg-white dark:bg-[#303030] text-gray-900 dark:text-gray-100 rounded-sm cursor-pointer" data-date-format="dd/mm/yyyy" name="" id="" placeholder="" autocomplete="off" value="<?php echo date('Y-m-d'); ?>">
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="PRICE_FG">Target Price F/G</label>
                                                                    <input type="text" name="PRICE_FG" id="PRICE_FG" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="PRICE_COST">Draft Cost Excluded PKG</label>
                                                                    <input type="text" name="PRICE_COST" id="PRICE_COST" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="PRICE_BULK">Bulk</label>
                                                                    <input type="text" name="PRICE_BULK" id="PRICE_BULK" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="FIRST_ORD">First Order</label>
                                                                    <input type="text" name="FIRST_ORD" id="FIRST_ORD" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
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
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        2
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        ข้อมูลผลิตภัณฑ์
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        ข้อมูลผลิตภัณฑ์
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
                                                                <div class="md:col-span-6">
                                                                    <label for="P_CONCEPT" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Concept</label>
                                                                    <textarea id="P_CONCEPT" name="P_CONCEPT" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <label for="P_BENEFIT" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Benefix</label>
                                                                    <textarea id="P_BENEFIT" name="P_BENEFIT" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                                <div class="md:col-span-2" >
                                                                    <label for="TEXTURE">texture<span class="text-danger"> *</span></label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="TEXTURE" name="TEXTURE">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($textures as $key => $texture)
                                                                            <option value={{ $texture->ID }}>{{ $texture->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="TEXTURE_OT">ระบุ</label>
                                                                    <input type="text" name="TEXTURE_OT" id="TEXTURE_OT" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="COLOR1">Color</label>
                                                                    <input type="text" name="COLOR1" id="COLOR1" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-6" style="position: relative;">
                                                                    <label for="FRANGRANCE">Fragrance Type</label>
                                                                    <input type="text" name="FRANGRANCE" id="FRANGRANCE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <label for="INGREDIENT" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Active Ingrement</label>
                                                                    <textarea name="INGREDIENT" id="INGREDIENT" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                                <div class="md:col-span-6" style="position: relative;">
                                                                    <label for="STD">สินค้าต้นแบบที่ใช้วิจัย (STD)</label>
                                                                    <input type="text" name="STD" id="STD" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>
                                                                <div class="md:col-span-6" style="position: relative;">
                                                                    <label for="PK">P/K ที่ใช้</label>
                                                                    <input type="text" name="PK" id="PK" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
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
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep  flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        3
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        ความต้องการเพิ่มเติม
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                                <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        ความต้องการเพิ่มเติม
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
                                                                <div class="md:col-span-3">
                                                                    <label for="OTHER">Other</label>
                                                                    <input type="text" name="OTHER" id="OTHER" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="DOCUMENT">เอกสารเพิ่มเติม</label>
                                                                    <input type="text" name="DOCUMENT" id="DOCUMENT" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                </div>
                                                                <div class="md:col-span-6 mt-2">
                                                                    <label for="OEM">Candidate with OEM</label>
                                                                    <div class="md:col-span-4 mt-3">
                                                                        <input type="radio" id="OEM_TYPE1" name="OEM" value="Y" />
                                                                        <label for="" class="mr-5">yes</label>
                                                                        <input type="radio" id="OEM_TYPE2" name="OEM" value="N" checked/>
                                                                        <label for="">no</label>
                                                                    </div>
                                                                    <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                </div>
                                                                <div class="md:col-span-6 mt-2">
                                                                    <label for="name">Reason of use</label>
                                                                    <div class="md:col-span-4 mt-5">
                                                                        <input class="-mt-1" type="checkbox" id="REASON1" name="REASON1">
                                                                        <label for="REASON1" class="mr-5">Claim in advertising media</label>
                                                                    </div>
                                                                    <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <div class="md:col-span-4 mt-5">
                                                                        <input class="-mt-1" type="checkbox" id="REASON2" name="REASON2">
                                                                        <label for="REASON2" class="mr-5">Compare with benchmark/OEM</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="REASON2_DES"></label>
                                                                    <input type="text" name="REASON2_DES" id="REASON2_DES" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <div class="md:col-span-4 mt-5">
                                                                        <input class="-mt-1" type="checkbox" id="REASON3" name="REASON3">
                                                                        <label for="REASON3" class="mr-5">Others</label>
                                                                        <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="REASON3_DES"></label>
                                                                    <input type="text" name="REASON3_DES" id="REASON3_DES" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                    <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-800"></ul>
                                                                </div>
                                                                <div class="md:col-span-3 mt-2">
                                                                    <div class="md:col-span-4 mt-3">
                                                                        <input type="radio" id="PACKAGE_BOX_TYPE1" name="PACKAGE_BOX" value="1" />
                                                                        <label for="" class="mr-5">With an outer box</label>
                                                                        <input type="radio" id="PACKAGE_BOX_TYPE2" name="PACKAGE_BOX" value="0" />
                                                                        <label for="">Without an outer box</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="REF_COLOR">Ref. of Color</label>
                                                                    <input type="text" name="REF_COLOR" id="REF_COLOR" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="REF_FRAGRANCE">Ref. of Fragrance</label>
                                                                    <input type="text" name="REF_FRAGRANCE" id="REF_FRAGRANCE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="OEM_STD">Comparing with OEM</label>
                                                                    <input type="text" name="OEM_STD" id="OEM_STD" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" />
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
                                <a href="{{ route('new_product_develop.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                    </svg>
                                    Back
                                </a>
                                <a class="bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-2 px-4 rounded cursor-pointer" onclick="createNPDRequest()">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>

        let barcodes = <?php echo json_encode($testBarcode); ?>;
        // console.log("🚀 ~ barcodes:", barcodes)

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            // console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

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
            onOpenhandler();
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
        // console.log("Index: ", ++i)
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

        let datass = {}
        function brandIdChange(e, params) {
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

            $('#NAME_ENG').val('');
            $('#JOB_REFNO').val('');
            
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
                        datass = data
                        select.find("option").remove();
                        const newop = new Option("--- กรุณาเลือก ---", "");
                        jQuery(newop).appendTo(select)
                        console.log('data', data)
                        data.map((item, index) => {
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
            console.log("🚀 ~ onSelect ~ JOB_REFNO:", JOB_REFNO)
            let curData = datass.find(f => f.JOB_REFNO === JOB_REFNO.value) || {}
            console.log("🚀 ~ onSelect ~ curData:", curData)
            if (curData.JOB_REFNO) {
                console.log('1')
                $('#NAME_ENG').val(curData.NAME_ENG);
                $('#JOB_REFNO').val(curData.JOB_REFNO);
            } else {
                console.log('2')
                $('#NAME_ENG').val();
                $('#JOB_REFNO').val();
            }
        }

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

        const dlayMessage = 1000;

        function createNPDRequest() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('new_product_develop.store') }}",
                data: $("#create_NPDRequest").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        window.location = "/new_product_develop";
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
