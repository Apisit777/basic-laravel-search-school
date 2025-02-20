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
            z-index: 1000;
        }
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
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
                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">แก้ไขรายการสินค้า</p>
            </div>
            <div class='w-12/12 mt-4 relative'>
                <form class="" action="" method="POST" id="update_product_detail2">       
                    <div class="p-2">
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        1
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด1
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        จัดการข้อมูลรายละเอียดสินค้า เพิ่มเติม
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
                                                                    <label for="seq">รหัสสินค้า</label>
                                                                    <input type="text" name="seq" id="seq" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="" readonly>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Product Channel</label>
                                                                    <select class="js-example-basic-multiple w-full rounded-sm text-xs select2" id="multiSelect" name="sele_channel[]" multiple="multiple">
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="AGE">Item Name</label>
                                                                    <input type="text" name="AGE" id="AGE" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                </div>

                                                                <!-- <div class="md:col-span-3">
                                                                    <label for="name">Series</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="SERIES" id="SERIES" onchange="getajaxCategory(this)">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($series as $serie)
                                                                            <option value="{{ $serie->ID }}">{{ $serie->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="md:col-span-3">
                                                                    <label for="name">Category</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="CATEGORY" id="CATEGORY" onchange="getajaxSubCategory(this)">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>

                                                                <div class="md:col-span-3">
                                                                    <label for="name">Sub Category</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="S_CAT" id="S_CAT">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div> -->

                                                                <!-- <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div> -->

                                                                <div class="md:col-span-3">
                                                                    <label for="name">Category Name</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="CATEGORY_DESCRIPTION" id="CATEGORY_ID" onchange="getajaxLine(this)">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($categorys as $category)
                                                                            <option value="{{ $category->ID }}">{{ $category->ID. ' - '.$category->DESCRIPTION }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Usage Area</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Product Line</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="LINE_DESCRIPTION" id="LINE_ID" onchange="getajaxType(this)">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Texture/Formula</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Product Type</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="TYPE_DESCRIPTION" id="TYPE_ID">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Finish</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Skin Type</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Package Type1</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Coverage/Benefit</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Package Type2</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" name="" id="">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                    </select>
                                                                </div>

                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="NAME_THAI">ชื่อสีภาษาไทย</label>
                                                                    <input required type="text" name="NAME_THAI" id="NAME_THAI" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="NAME_ENG">ชื่อสีภาษาอังกฤษ</label>
                                                                    <input required type="text" name="NAME_ENG" id="NAME_ENG" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
                                                                </div>

                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">Suppiler name(ไทย)</label>
                                                                    <input required type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">Suppiler name(อังกฤษ)</label>
                                                                    <input required type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">รหัสสี</label>
                                                                    <input required type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="">อื่นๆ</label>
                                                                    <input required type="text" name="" id="" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center checkinputvalidate select2" value="" />
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
                                        Free Form
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden peer-checked:hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        Free Form
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
                                                                    <label for="name">SL S/SLES - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact1" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact1" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Natural alcohol</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact2" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact2" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Silicone - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact3" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact3" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Certified food grade flavors</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact4" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact4" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Mineral oil free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact5" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact5" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Made with certified organic</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact6" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact6" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Colorant - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact7" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact7" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Hypoallergenic</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact8" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact8" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Phthalate - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact9" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact9" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Irritation tested</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact10" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact10" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Cruelty - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact11" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact11" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Non - comedogenic (ingrsdients)</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact12" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact12" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Talc - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact14" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact14" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">No synthetic colorant</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact15" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact15" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Oil - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact16" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact16" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">No synthetic fragrance</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact17" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact17" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Triethanolamin - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact18" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact18" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">pH balance (5.0-5.5)</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact19" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact19" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Petroleum - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact20" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact20" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Children over 6 year old</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact21" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact21" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Petrolatum - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact22" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact22" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">Fragrance - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact23" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact23" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">alcohol - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact24" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact24" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">paraben - free</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact25" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact25" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">คนท้องใช้ได้ ใช่หรือไม่</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact26" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact26" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">ให้นมบุตรใช้ได้ ใช่หรือไม่</label>
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact27" value="Y" />
                                                                        <label for="" class="mr-5">ใช่</label>
                                                                        <input type="radio" id="" name="contact27" value="N" />
                                                                        <label for="">ไม่ใช่</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact28" value="Y" />
                                                                        <label for="" class="mr-5">อ้างอิงตามคำแนะนำแพทย์</label>
                                                                    </div>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="" name="contact29" value="Y" />
                                                                        <label for="" class="mr-5">อ้างอิงตามคำแนะนำแพทย์</label>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="md:col-span-6">
                                                                    <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
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

                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>

                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="md:col-span-6 text-right mt-4">
                            <div class="inline-flex items-end">
                                <a href="{{ route('product_detail.pd_other_index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded" onclick="updateProductDetail2()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 w-5 h-5 hidden md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </button>
                                <!-- <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50" onclick="updateProductDetail2()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 w-5 h-5 hidden md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </button> -->
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
            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')

            // Convert PHP arrays to JavaScript objects
            let defaultBrands = <?php echo json_encode($defaultAllChannels); ?>;
            let allBrands = <?php echo json_encode($allChannels); ?>;

            $('.js-example-basic-single').select2();
            $('#multiSelect').select2({
                placeholder: "--- กรุณาเลือก ---",
                closeOnSelect: false,
            });

            // Populate the dropdown with allBrands
            if (defaultBrands[0] === 'CPS') {
                // If the default brand is "KM", set allBrands as the selected values
                $('#multiSelect').empty(); // Clear existing options
                allBrands.forEach(function(brand) {
                    let newOption = new Option(brand, brand, false, true);
                    $('#multiSelect').append(newOption);
                });
                $('#multiSelect').trigger("change"); // Update Select2
            } else {
                // Add any missing brands from allBrands to the dropdown
                allBrands.forEach(function(brand) {
                    if (!$('#multiSelect').find(`option[value="${brand}"]`).length) {
                        let newOption = new Option(brand, brand, false, false);
                        $('#multiSelect').append(newOption);
                    }
                });
                $('#multiSelect').trigger("change"); // Update Select2
                    setTimeout(function() {
                    $('#multiSelect').val(defaultBrands).trigger("change");
                }, 600);
            }
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

        // ฟังก์ชันดึง Line ตาม Category ที่เลือก
        function getajaxLine(e) {
            const lineSelect = jQuery('#LINE_ID');
            lineSelect.find("option").remove();
            lineSelect.empty().append(new Option("--- กรุณาเลือก ---", ""));
            const typeSelect = jQuery('#TYPE_ID');
            typeSelect.find("option").remove();
            typeSelect.empty().append(new Option("--- กรุณาเลือก ---", ""));

            jQuery.ajax({
                type: "GET",
                url: '{{ route('product_detail.product_line') }}?category_id=' + e.value,
                beforeSend: function () {
                    lineSelect.find("option").remove();
                    lineSelect.append(new Option("LOADING...", ""));
                },
                success: function(data) {
                    console.log("Line Data:", data);
                    lineSelect.find("option[value='']").remove();
                    lineSelect.append(new Option("--- กรุณาเลือก ---", ""));
                    
                    if (data.length > 0) {
                        data.forEach(item => {
                            let displayText = `${item.ID} - ${item.DESCRIPTION}`;
                            lineSelect.append(new Option(displayText, item.ID));
                        });
                    } else {
                        console.warn("No Line Found");
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching Line:", xhr.responseText);
                }
            });
        }

        // ฟังก์ชันดึง Type ตาม Line ที่เลือก
        function getajaxType(e) {
            const typeSelect = jQuery('#TYPE_ID');
            typeSelect.find("option").remove();
            typeSelect.empty().append(new Option("--- กรุณาเลือก ---", ""));

            jQuery.ajax({
                type: "GET",
                url: '{{ route('product_detail.product_type') }}?line_id=' + e.value,
                beforeSend: function () {
                    typeSelect.find("option").remove();
                    typeSelect.append(new Option("LOADING...", ""));
                },
                success: function(data) {
                    console.log("Sub Categories Data:", data);
                    typeSelect.find("option[value='']").remove();
                    typeSelect.append(new Option("--- กรุณาเลือก ---", ""));
                    
                    if (data.length > 0) {
                        data.forEach(item => {
                            let displayText = `${item.ID} - ${item.DESCRIPTION}`;
                            typeSelect.append(new Option(displayText, item.ID));
                        });
                    } else {
                        console.warn("No Sub Categories Found");
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching subcategories:", xhr.responseText);
                }
            });
        }

        // // ฟังก์ชันดึง Category ตาม Series ที่เลือก
        // function getajaxCategory(e) {
        //     const categorySelect = jQuery('#CATEGORY');
        //     categorySelect.find("option").remove();
        //     categorySelect.empty().append(new Option("--- กรุณาเลือก ---", ""));
        //     const subCategorySelect = jQuery('#S_CAT');
        //     subCategorySelect.find("option").remove();
        //     subCategorySelect.empty().append(new Option("--- กรุณาเลือก ---", ""));

        //     jQuery.ajax({
        //         type: "GET",
        //         url: '{{ route('product_detail.product_Other_category') }}?series_id=' + e.value,
        //         beforeSend: function () {
        //             categorySelect.find("option").remove();
        //             categorySelect.append(new Option("LOADING...", ""));
        //         },
        //         success: function(data) {
        //             console.log("Categories Data:", data);
        //             categorySelect.find("option[value='']").remove();
        //             categorySelect.append(new Option("--- กรุณาเลือก ---", ""));
                    
        //             if (data.length > 0) {
        //                 data.forEach(item => {
        //                     categorySelect.append(new Option(item.DESCRIPTION, item.ID));
        //                 });
        //             } else {
        //                 console.warn("No Categories Found");
        //             }
        //         },
        //         error: function(xhr) {
        //             console.error("Error fetching categories:", xhr.responseText);
        //         }
        //     });
        // }

        // // ฟังก์ชันดึง SubCategory ตาม Category ที่เลือก
        // function getajaxSubCategory(e) {
        //     const subCategorySelect = jQuery('#S_CAT');
        //     subCategorySelect.find("option").remove();
        //     subCategorySelect.empty().append(new Option("--- กรุณาเลือก ---", ""));

        //     jQuery.ajax({
        //         type: "GET",
        //         url: '{{ route('product_detail.product_Other_sub_category') }}?category_id=' + e.value,
        //         beforeSend: function () {
        //             subCategorySelect.find("option").remove();
        //             subCategorySelect.append(new Option("LOADING...", ""));
        //         },
        //         success: function(data) {
        //             console.log("Sub Categories Data:", data);
        //             subCategorySelect.find("option[value='']").remove();
        //             subCategorySelect.append(new Option("--- กรุณาเลือก ---", ""));
                    
        //             if (data.length > 0) {
        //                 data.forEach(item => {
        //                     subCategorySelect.append(new Option(item.DESCRIPTION, item.ID));
        //                 });
        //             } else {
        //                 console.warn("No Sub Categories Found");
        //             }
        //         },
        //         error: function(xhr) {
        //             console.error("Error fetching subcategories:", xhr.responseText);
        //         }
        //     });
        // }

        function updateProductDetail2() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('product_detail.pd_other_update') }}",
                data: $("#update_product_detail2").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        window.location = "/product_detail/pd_other_index";
                    } else {
                        setTimeout(function() {
                            toastr.error("เพิ่มขู้อมูลไม่สำเร็จ!");
                        },dlayMessage)
                        setTimeout(function() {
                            $('#loader').addClass('hidden')
                        },dlayMessage)
                        setTimeout(function() {
                            $('#BRAND').val('')
                            $("#NUMBER").val('').change();
                        },dlayMessage)
                    }
                    return false;
                },
                error: function (params) {
                    setTimeout(function() {
                        errorMessage("เพิ่มขู้อมูลไม่สำเร็จ");
                    },dlayMessage)
                    setTimeout(function() {
                        toastr.error("เพิ่มขู้อมูลไม่สำเร็จ");
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
