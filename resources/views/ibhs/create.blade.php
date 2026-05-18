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
        .image_sequence_loading {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #7f7f7fe3; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 10;
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

        .panel {
            padding-bottom: 10px;
        }

        #cam {
            border: 1px;
            border-color: black;
            border-style: solid;
        }

        #photo {
            border: 1px;
            border-color: black;
            border-style: dashed;
        }

        html * {
            box-sizing: border-box;
        }
        p {
            margin: 0;
        }
        .upload__box {
            padding: 0 0px 0 0px;
        }
        .upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .upload__btn {
            display: inline-block;
            font-weight: 600;
            color: #fff;
            text-align: center;
            min-width: 116px;
            padding: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid;
            background-color: #4045ba;
            border-color: #4045ba;
            border-radius: 10px;
            line-height: 26px;
            font-size: 14px;
        }
        .upload__btn:hover {
            background-color: unset;
            color: #4045ba;
            transition: all 0.3s ease;
        }
        .upload__btn-box {
            margin-bottom: 15px;
        }
        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        /* .upload__img-wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 8px;
        } */

        .upload__img-wrap .img-container {
            position: relative;
            width: 100%;
            height: 150px; /* ให้เท่ากับ `max-height` ของ img */
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .upload__img-wrap .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            cursor: pointer;
        }
        .upload__img-box {
            width: 200px;
            gap: 5px
            /* padding: 0 10px; */
            /* margin-bottom: 12px; */
            /* margin-top: 12px; */
        }
        .upload__img-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 24px;
            z-index: 1;
            cursor: pointer;
        }
        .upload__img-close:after {
            content: '\2716';
            font-size: 14px;
            color: white;
        }
        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }

        /* ************************************************* */
        .list-group{
            position: relative;
            display: block;
            padding: .75rem 1.25rem;
            margin-bottom: -1px;
            background-color: #fff;
        }

        .img-wrap {
            position: relative;
        }
        .img-wrap .close {
            position: absolute;
            right: 0px;
            z-index: 100;
        }
        .close {
            opacity: 0.8;
        }
        .img-thumbnail{
            border: 0px;
            padding: 2px;
            height: 150px;
        }
        .container {
            max-width: 700px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .imgPreview img {
            border-radius: .25rem;
            padding: 2px;
            max-height: 150px;
        }
        .color_reload{
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background-color: #f5f5f5e0;
            z-index: 999;
        }
        .hide-success .active{
            transition: all 5s;
            visibility: visible;
            opacity: 1;
        }
        .hide-success .active{
            transform: translateY(-130%);
            transition-timing-function: ease-in;
            transition: 1s;
            visibility: hidden;
            opacity: 0;
        }
        .closebtn {
            position: absolute;
            top: 7px;
            right: 10px;
            color: rgb(92, 92, 92);
            float: right;
            font-size: 15px;
            line-height: 20px;
            cursor: pointer;
        }
        .upload__img-close {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            /* background-color: rgba(255, 0, 0, 0.734); */
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 21px;
            z-index: 1;
            cursor: pointer;
        }
        .upload__img-close:after {
            content: "✖";
            font-size: 14px;
            color: white;
        }
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #7f7f7fe3; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
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

        /* Tailwind CSS Animations */

        .after_upload_upload__img_close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 24px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            z-index: 1;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s ease-in-out;
        }

        .after_upload_upload__img_close:hover {
            opacity: 1;
        }

        /* ✅ เปิด Modal แบบ Smooth (Zoom In) */
        @keyframes zoomIn {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* ✅ ปิด Modal แบบ Smooth (Zoom Out) */
        @keyframes zoomOut {
            from { transform: scale(1); opacity: 1; }
            to { transform: scale(0.5); opacity: 0; }
        }

        /* ✅ ใช้ตอนเปิด Modal */
        .modal-enter { animation: zoomIn 0.3s ease-out forwards; }

        /* ✅ ใช้ตอนปิด Modal */
        .modal-leave { animation: zoomOut 0.3s ease-in forwards; }

        /* ✅ ป้องกันรูปค้าง */
        .active-image {
            transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        }

        .image-slide-prev {
            transform: translateX(-100%);
            opacity: 0;
            transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        }

        .image-slide-next {
            transform: translateX(100%);
            opacity: 0;
            transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        }

        .image-slide-active {
            transform: translateX(0);
            opacity: 1;
            transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        }

        video {
            max-width: 85%!important;
            height: auto!important;
        }

        .zoom-preview {
            position: fixed;
            top: 90%; left: 90%;
            width: 420px; height: 320px;
            background: #fff;
            border-radius: 20px;
            transform: translate(0,0) scale(.1);
            clip-path: ellipse(50% 50% at 50% 50%);
            opacity: 0;
            transition: transform .8s cubic-bezier(.25,1,.5,1),
                        opacity .6s ease, top .8s ease, left .8s ease, clip-path .8s ease;
            transition-delay: .05s;
            box-shadow: 0 10px 50px rgba(0,0,0,.3);
            z-index: 9999;      /* เพิ่มให้สูงจากทุกอย่าง */
            pointer-events: none;
        }
        .zoom-preview.show {
            top: 50%; left: 50%;
            transform: translate(-50%,-50%) scale(1);
            opacity: 1;
            clip-path: ellipse(100% 100% at 50% 50%);
            transition-delay: 0s;
        }
        .dark .zoom-preview { background:#2f2f2f; }


        /* ************************************************************************************************ */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 12px !important; 
            padding-right: 5px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />

    @php
        $placeholder = 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';

        // เลือกรูปแรกของแต่ละ seq
        $unit  = collect($images ?? [])->firstWhere('seq', 2);
        $inner = collect($images ?? [])->firstWhere('seq', 3);
        $case  = collect($images ?? [])->firstWhere('seq', 4);

        $unitSrc  = $unit?->path ? asset($unit->path) : $placeholder;
        $innerSrc = $inner?->path ? asset($inner->path) : $placeholder;
        $caseSrc  = $case?->path ? asset($case->path) : $placeholder;

    @endphp

@section('content')
    <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">สร้าง</p>
            </div>
            <div class='w-12/12 mt-4 relative'>
                <form class="" action="" method="POST" id="update_product_detail">
                    <div class="p-2">
                        <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                            <li data-twe-stepper-step-ref="" class="mb-12 relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
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
                                                        Product Description
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
                                                                <input type="hidden" name="corporation_id" value="">
                                                                <input type="hidden" name="permission" value="N">
                                                                <div class="md:col-span-2">
                                                                    <label for="bulk_id">BULK CODE</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="bulk_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="job_ref_no">JOB REFFERENCE NO</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="job_ref_no" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="product_name">PRODUCT NAME</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="product_name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="appearance">APPEARANCE</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="appearance" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="category">CATEGORY</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="category" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="shelf_life">SHELF-LIFE (Months)</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="shelf_life" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="fda_noti">FDA notification is required</label>
                                                                </div>

                                                                <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                        <input type="radio" id="fda_noti_y" name="fda_noti" value="Y">
                                                                        <label for="" class="mr-5">Yes</label>
                                                                        <input type="radio" id="fda_noti_n" name="fda_noti" value="N">
                                                                        <label for="">No</label>
                                                                    </div>
                                                            </div>
                                                            <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>

                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    
                                                                    <label for="product_id">ต้องแสดงคำเตือนบนฉลาก</label>
                                                                </div>

                                                                <div class="md:col-span-4 mt-2" style="position: relative;">
                                                                    <input type="radio" id="permission_y" name="warning_display" value="Y">
                                                                    <label for="" class="mr-5">Yes</label>
                                                                    <input type="radio" id="permission_n" name="warning_display" value="N">
                                                                    <label for="">No</label>
                                                                </div>
                                                            </div>

                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="list_substances_warning" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">รายการสารที่ต้องแสดงคำเตือน</label>
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="list_substances_warning_1">ชื่อสาร</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="list_substances_warning_1" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="list_substances_warning_2">ชื่อสาร</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="list_substances_warning_2" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                                <div class="md:col-span-2">
                                                                    <label for="list_substances_warning_3">ชื่อสาร</label>
                                                                </div>
                                                                <div class="md:col-span-4 relative">
                                                                    <input type="text" name="list_substances_warning_3" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                </div>
                                                            </div>

                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="ingredients" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Special Ingredients</label>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <textarea id="ingredients" name="ingredients" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="characteristic" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Characteristic</label>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <textarea id="characteristic" name="characteristic" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="fragrance" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Fragrance</label>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <textarea id="fragrance" name="fragrance" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <div class="md:col-span-2">
                                                                    <label for="how_to_use" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">How To Use</label>
                                                                </div>
                                                                <div class="md:col-span-6">
                                                                    <textarea id="how_to_use" name="how_to_use" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6 mt-5">
                                                                <div class="md:col-span-2">
                                                                    <label for="qualification_claimed" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Qualification claimed</label>
                                                                </div>
                                                            </div>

                                                            <div class="duplicate_free_form grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm mt-2">
                                                                {{-- ===== Left column ===== --}}
                                                                <div class="space-y-2">
                                                                    @php
                                                                        $leftItems = [
                                                                            ['name' => 'alcohol_free',        'label' => 'Alcohol-free (หมายถึง ปราศจากสาร Ethyl Alcohol)'],
                                                                            ['name' => 'colorant_free',       'label' => 'Colorant-Free'],
                                                                            ['name' => 'fragrance_free',      'label' => 'Fragrance Free'],
                                                                            ['name' => 'mineral_free',        'label' => 'Mineral Oil Free'],
                                                                            ['name' => 'oil_free',            'label' => 'Oil-Free'],
                                                                            ['name' => 'paraben_free',        'label' => 'Paraben-Free'],
                                                                            ['name' => 'petrolatum_free',     'label' => 'Petrolatum-Free'],
                                                                            ['name' => 'petroleum_free',      'label' => 'Petroleum-Free'],
                                                                            ['name' => 'phthalate_free',      'label' => 'Phthalate-Free'],
                                                                            ['name' => 'silicone_free',       'label' => 'Silicone-Free'],
                                                                            ['name' => 'triethanolamin_free', 'label' => 'Triethanolamine Free (TEA)'],
                                                                            ['name' => 'chil_over_6year',     'label' => 'Safe for Children Over 6 Years Old.'],
                                                                            ['name' => 'pregnancy',           'label' => 'Safe for Pregnant'],
                                                                            ['name' => 'no_need_to_review_before_making_full_ingredients',           'label' => 'No Need to Review Before Mading Full Ingredients'],
                                                                        ];
                                                                    @endphp
                                                                    @foreach($leftItems as $item)
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="hidden" name="{{ $item['name'] }}" value="N">
                                                                            <input type="checkbox" name="{{ $item['name'] }}" value="Y"
                                                                                {{ ($dataFreeForm->{$item['name']} ?? '') == 'Y' ? 'checked' : '' }}
                                                                                class="h-4 w-4 rounded border-gray-400 dark:border-gray-500 accent-green-600 cursor-pointer">
                                                                            <span>{{ $item['label'] }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                {{-- ===== Right column ===== --}}
                                                                <div class="space-y-2">
                                                                    @php
                                                                        $rightItems = [
                                                                            ['name' => 'non_comedogenic',     'label' => 'Non-Comedogenic (Ingredients)'],
                                                                            ['name' => 'synthetic_fragrance', 'label' => 'No Synthetic Fragrance'],
                                                                            ['name' => 'synthetic_colorant',  'label' => 'No Synthetic Colorant'],
                                                                            ['name' => 'certified_organic',   'label' => 'Certified Organic Ingredients'],
                                                                            ['name' => 'certified_food',      'label' => 'Certified Food Grade Flavors'],
                                                                            ['name' => 'natural_alcohol',     'label' => 'Natural Alcohol'],
                                                                            ['name' => 'cruelty_free',        'label' => 'Cruelty-Free **(Product Only)'],
                                                                            ['name' => 'hypoallergenic',      'label' => 'Hypoallergenic'],
                                                                            ['name' => 'tested',              'label' => 'Irritation Tested'],
                                                                            ['name' => 'ph_balance',          'label' => 'pH Balanced (5.0-5.5)'],
                                                                            ['name' => 'sls_free',            'label' => 'SLS/SLES-Free'],
                                                                            ['name' => 'talc_free',           'label' => 'Talc-Free'],
                                                                            ['name' => 'breastfeed',          'label' => 'Safe for Breastfeeding'],
                                                                            ['name' => 'formula_free_from',   'label' => 'Formula Free From (Not Listed Above and Suitable)'],
                                                                            ['name' => 'need_to_review_before_making_full_ingredients',          'label' => 'Need to Review Before Making Full Ingredients'],
                                                                        ];
                                                                    @endphp
                                                                    @foreach($rightItems as $item)
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="hidden" name="{{ $item['name'] }}" value="N">
                                                                            <input type="checkbox" name="{{ $item['name'] }}" value="Y"
                                                                                {{ ($dataFreeForm->{$item['name']} ?? '') == 'Y' ? 'checked' : '' }}
                                                                                class="h-4 w-4 rounded border-gray-400 dark:border-gray-500 accent-green-600 cursor-pointer">
                                                                            <span>{{ $item['label'] }}</span>
                                                                        </div>
                                                                    @endforeach

                                                                </div>
                                                                <!-- Not Recommend For Pregnant -->
                                                                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-3">
                                                                    <div class="md:col-span-2">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="hidden" name="not_recommend_pregnant_checkbox" value="N">
                                                                            <input type="checkbox" name="not_recommend_pregnant_checkbox" value="Y"
                                                                                class="h-4 w-4 rounded border-gray-400 dark:border-gray-500 accent-green-600 cursor-pointer">
                                                                            <label for="not_recommend_pregnant" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Not Recommend For Pregnant</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="md:col-span-6">
                                                                        <textarea id="not_recommend_pregnant" name="not_recommend_pregnant_text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                                <!-- Product Efficacy Test -->
                                                                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-3">
                                                                    <div class="md:col-span-2">
                                                                        <div class="flex items-center gap-2">
                                                                            <input type="hidden" name="product_efficacy_test_checkbox" value="N">
                                                                            <input type="checkbox" name="product_efficacy_test_checkbox" value="Y"
                                                                                class="h-4 w-4 rounded border-gray-400 dark:border-gray-500 accent-green-600 cursor-pointer">
                                                                            <label for="product_efficacy_test" class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 font-bold text-gray-900 dark:text-gray-100">Product Efficacy Test</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="md:col-span-6">
                                                                        <textarea id="product_efficacy_test" name="product_efficacy_test_text" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>

                                                            <!-- ─── Custom Free Form (JSON array) ─── -->
                                                            <div class="md:col-span-9 mt-5">
                                                                <div class="flex items-center justify-between mb-2">
                                                                    <span class="text-sm font-medium">Custom Free Form</span>
                                                                    <button type="button" id="btnAddFreeForm"
                                                                        class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded transition">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                        Free Form
                                                                    </button>
                                                                </div>
                                                                <input type="hidden" name="custom_free_forms" id="customFreeFormsJson" value="{{ $dataFreeForm->custom_free_forms ?? '[]' }}">
                                                                <div id="customFreeFormList" class="space-y-2"></div>
                                                            </div>

                                                            <div class="md:col-span-9">
                                                                <ul class="width-full pt-2.5 mt-2 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                            </div>

                                                            <div class="lg:col-span-4">

                                                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-9 mb-2">
                                                                    <div class="md:col-span-3">
                                                                        <label for="natural_claimed_1">%Natural claimed<span class="text-danger"> *</span></label>
                                                                        <input type="text" name="natural_claimed_1" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                    </div>
                                                                    <div class="md:col-span-3">
                                                                        <label for="natural_claimed_2"><span class="text-danger"> *</span></label>
                                                                        <input type="text" name="natural_claimed_2" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                    </div>
                                                                    <div class="md:col-span-3">
                                                                        <label for="natural_claimed_3"><span class="text-danger"> *</span></label>
                                                                        <input type="text" name="natural_claimed_3" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                    <div class="md:col-span-6">
                                                                        <label for="ingredient_list" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingredient List</label>
                                                                        <textarea id="ingredient_list" name="ingredient_list" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here."></textarea>
                                                                    </div>
                                                                    <!-- <div class="md:col-span-3" style="position: relative;">
                                                                        <label for="after_open_m">ระยะเวลาหลังเปิดใช้<span class="text-danger"> *</span></label>
                                                                        <input type="text" name="after_open_m" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ isset($data->after_open_m) ? $data->after_open_m . ' เดือน' : '' }}">
                                                                        
                                                                        <div class="absolute inset-0 z-10 rounded-md cursor-not-allowed
                                                                            bg-white/50 border border-gray-300/50
                                                                            dark:bg-white/10 dark:border-white/30">
                                                                        </div>
                                                                    </div> -->
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

                        <!-- ─── Dropzone Upload ─── -->
                <div class="mt-6 px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Left: Dropzone Panel -->
                        <div class="bg-white dark:bg-[#2a2a2a] border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                </svg>
                                <span class="font-bold text-gray-800 dark:text-white">Dropzone</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Drag files in, validate, queue, and export metadata - all frontend.</p>

                            <!-- Controls Row -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">File Type</label>
                                    <select id="dz-mode" class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-[#404040] text-gray-900 dark:text-white">
                                        <option value="images">Images</option>
                                        <option value="documents">Documents</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Max files</label>
                                    <input id="dz-maxfiles" type="number" value="5" min="1" max="5"
                                        class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-[#404040] text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Max size per file (MB)</label>
                                    <input id="dz-maxsize" type="number" value="10" min="0.1" max="10" step="0.1"
                                        class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-[#404040] text-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Allowed extensions</label>
                                    <input id="dz-exts" type="text" value=".png, .jpg, .jpeg, .webp" readonly
                                        class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-gray-100 dark:bg-[#333] text-gray-700 dark:text-gray-300">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Form Type</label>
                                    <select id="dz-form-type" name="dz_form_type" class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-[#404040] text-gray-900 dark:text-white">
                                        <option value="special_ingredients">Special Ingredients</option>
                                        <option value="characteristic">Characteristic</option>
                                    </select>
                                </div>
                                <!-- <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">File Type</label>
                                    <select id="dz-file-type" name="dz_file_type" class="w-full text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-[#404040] text-gray-900 dark:text-white">
                                        <option value="image">Image</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div> -->
                            </div>

                            <!-- Drop Area -->
                            <div id="dz-drop-area"
                                class="border-2 border-dashed border-gray-400 dark:border-gray-500 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 dark:hover:border-blue-500 transition-colors"
                                onclick="document.getElementById('dz-file-input').click()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4h2l-4 4-4-4h2V5z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Drop files here</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">or click to browse. Paste also works.</p>
                                <input id="dz-file-input" type="file" multiple class="hidden">
                            </div>

                            <!-- Mode Badge -->
                            <div class="flex gap-2 mt-2 flex-wrap">
                                <span id="dz-badge-mode" class="text-xs bg-gray-800 text-white px-2 py-0.5 rounded">Mode: Images</span>
                                <span id="dz-badge-limits" class="text-xs bg-blue-600 text-white px-2 py-0.5 rounded">Limits: 5 files, 10 MB each</span>
                                <span id="dz-badge-types" class="text-xs bg-gray-600 text-white px-2 py-0.5 rounded">Types: .png, .jpg, .jpeg, .webp</span>
                            </div>

                            <!-- Rejected -->
                            <p id="dz-rejected-msg" class="text-xs text-red-500 mt-2 hidden"></p>
                        </div>

                        <!-- Right: Queue Panel -->
                        <div class="bg-white dark:bg-[#2a2a2a] border border-gray-300 dark:border-gray-600 rounded-lg p-4 flex flex-col">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-bold text-gray-800 dark:text-white mb-1">รายละเอียดไฟล์</span>
                                    <span id="dz-queue-count" class="text-xs text-gray-400">0 file(s)</span>
                                </div>
                                <button type="button" id="dz-clear-queue"
                                    class="text-xs px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-400 hover:text-red-500 transition-colors">
                                    Clear queue
                                </button>
                            </div>
                            <div id="dz-queue-list" class="space-y-2 flex-1 overflow-y-auto max-h-64">
                                <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-4">Nothing uploads anywhere. This is a UI component demo.</p>
                            </div>
                            <input type="hidden" name="dz_files_json" id="dz-files-json">
                        </div>

                    </div>
                </div>
                <!-- ─── End Dropzone ─── -->

                <!-- ─── Preview IBSH Files (hidden on create) ─── -->
                <div class="mt-6 px-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Special Ingredients -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Special Ingredients
                                    <span class="text-xs font-normal text-gray-400">({{ $ibshSpecial->count() }})</span>
                                </h4>
                                @if($ibshSpecial->count() > 0)
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 cursor-pointer select-none mt-2">
                                        <input type="checkbox" class="ibsh-select-all rounded border-gray-300 dark:border-gray-600 text-green-500 focus:ring-green-400" data-group="special">
                                        Select All
                                    </label>
                                    <button type="button" class="ibsh-download-btn inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded border border-green-500 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors disabled:opacity-40 disabled:cursor-not-allowed" data-group="special" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Download
                                    </button>
                                </div>
                                @endif
                            </div>
                            @if($ibshSpecial->count() > 0)
                            <div class="columns-2 sm:columns-3 gap-2 space-y-2">
                                @foreach($ibshSpecial as $ibsh)
                                    @php
                                        $ext = strtolower(pathinfo($ibsh->path, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['png','jpg','jpeg','webp','gif']);
                                    @endphp
                                    <div class="break-inside-avoid rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-white dark:bg-[#2a2a2a] relative group">
                                        <label class="absolute top-1.5 left-1.5 z-10 cursor-pointer">
                                            <input type="checkbox" class="ibsh-file-cb rounded border-gray-300 dark:border-gray-600 text-green-500 focus:ring-green-400" data-group="special" data-url="{{ asset($ibsh->path) }}" data-name="{{ basename($ibsh->path) }}">
                                        </label>
                                        @if($isImage)
                                            <img src="{{ asset($ibsh->path) }}" alt="special_ingredients" class="w-full h-auto object-cover" loading="lazy">
                                        @else
                                            <a href="{{ asset($ibsh->path) }}" target="_blank" class="flex flex-col items-center justify-center p-4 gap-2 hover:bg-gray-50 dark:hover:bg-[#333] transition-colors">
                                                @if($ext === 'pdf')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zm-2.5 9.5a1.5 1.5 0 010 3H9v1.5H7.5v-6H10.5a1.5 1.5 0 010 0zm0 1.5H9v1h1.5a.5.5 0 000-1zm5-1.5h-2v6h2a2.5 2.5 0 000-5zm0 1.5a1 1 0 010 2h-.5v-2h.5zm4-1.5h-2.5v6H18v-2h1.5v-1.5H18v-1h1.5V13.5z"/>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm1 9h-2v4.5a1.5 1.5 0 01-3 0V11H8V9h7v2zm-2-4V4l5 5h-5z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-full">{{ basename($ibsh->path) }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500 italic">No files</p>
                            @endif
                        </div>

                        <!-- Characteristic -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Characteristic
                                    <span class="text-xs font-normal text-gray-400">({{ $ibshCharacteristic->count() }})</span>
                                </h4>
                                @if($ibshCharacteristic->count() > 0)
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 cursor-pointer select-none mt-2">
                                        <input type="checkbox" class="ibsh-select-all rounded border-gray-300 dark:border-gray-600 text-blue-500 focus:ring-blue-400" data-group="characteristic">
                                        Select All
                                    </label>
                                    <button type="button" class="ibsh-download-btn inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded border border-blue-500 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors disabled:opacity-40 disabled:cursor-not-allowed" data-group="characteristic" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Download
                                    </button>
                                </div>
                                @endif
                            </div>
                            @if($ibshCharacteristic->count() > 0)
                            <div class="columns-2 sm:columns-3 gap-2 space-y-2">
                                @foreach($ibshCharacteristic as $ibsh)
                                    @php
                                        $ext = strtolower(pathinfo($ibsh->path, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['png','jpg','jpeg','webp','gif']);
                                    @endphp
                                    <div class="break-inside-avoid rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 bg-white dark:bg-[#2a2a2a] relative group">
                                        <label class="absolute top-1.5 left-1.5 z-10 cursor-pointer">
                                            <input type="checkbox" class="ibsh-file-cb rounded border-gray-300 dark:border-gray-600 text-blue-500 focus:ring-blue-400" data-group="characteristic" data-url="{{ asset($ibsh->path) }}" data-name="{{ basename($ibsh->path) }}">
                                        </label>
                                        @if($isImage)
                                            <img src="{{ asset($ibsh->path) }}" alt="characteristic" class="w-full h-auto object-cover" loading="lazy">
                                        @else
                                            <a href="{{ asset($ibsh->path) }}" target="_blank" class="flex flex-col items-center justify-center p-4 gap-2 hover:bg-gray-50 dark:hover:bg-[#333] transition-colors">
                                                @if($ext === 'pdf')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zm-2.5 9.5a1.5 1.5 0 010 3H9v1.5H7.5v-6H10.5a1.5 1.5 0 010 0zm0 1.5H9v1h1.5a.5.5 0 000-1zm5-1.5h-2v6h2a2.5 2.5 0 000-5zm0 1.5a1 1 0 010 2h-.5v-2h.5zm4-1.5h-2.5v6H18v-2h1.5v-1.5H18v-1h1.5V13.5z"/>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm1 9h-2v4.5a1.5 1.5 0 01-3 0V11H8V9h7v2zm-2-4V4l5 5h-5z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-full">{{ basename($ibsh->path) }}</span>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-xs text-gray-400 dark:text-gray-500 italic">No files</p>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- ─── End Preview IBSH Files ─── -->

                        <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="md:col-span-6 text-right mt-4">
                            <div class="inline-flex items-end">
                                <a href="{{ route('product_detail.pd_detail_index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded" onclick="editProductDetail()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 w-5 h-5 hidden md:inline-block">
                                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script>

        function showZoomById(boxId, imgId, url){
            const box = document.getElementById(boxId);
            const img = document.getElementById(imgId);
            img.src = url;
            box.classList.add('show');
        }
        function hideZoomById(boxId){
            document.getElementById(boxId).classList.remove('show');
        }

        const productData = {
            netWeight: @json($dataComProduct->inner_weight ?? 0),
            grossWeight: @json($dataComProduct->weight ?? 0),
            innerPackSize: @json($dataComProduct->inner_pack_size ?? 1)
        };

        // กรณีมีหลาย inner ต่อ 1 case (ดึงจาก database ถ้ามี)
        const innersPerCase = @json($dataComProduct->case_pack_size ?? 1) // ถ้ามีข้อมูลจริง เช่น $dataComProduct->case_pack_size

        // น้ำหนักรวมต่อ 1 Inner (สินค้า+กล่อง)
        const grossWeightPerInner = productData.grossWeight * productData.innerPackSize;

        // น้ำหนักรวมต่อ 1 Case
        const grossWeightPerCase = grossWeightPerInner * innersPerCase;

        // แสดงผล
        console.log("Net Weight (สินค้าล้วน):", productData.netWeight, "kg");
        console.log("Gross Weight ต่อ Unit:", productData.grossWeight, "kg");
        console.log("จำนวน Unit ต่อ 1 Inner:", productData.innerPackSize);
        console.log("จำนวน Inner ต่อ 1 Case:", innersPerCase);
        console.log("➡️ Gross Weight ต่อ Inner:", grossWeightPerInner.toFixed(2), "kg");
        console.log("➡️ Gross Weight ต่อ Case:", grossWeightPerCase.toFixed(2), "kg");

        // 👇 ใส่ค่าที่คำนวณแล้วลงใน input
        // document.addEventListener("DOMContentLoaded", function () {
        //     document.getElementById("gross_weight_inner").value = grossWeightPerInner.toLocaleString('en-US', {
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     });

        //     document.getElementById("gross_weight_case").value = grossWeightPerCase.toLocaleString('en-US', {
        //         minimumFractionDigits: 2,
        //         maximumFractionDigits: 2
        //     });
        // });

        $(document).ready(function() {
            // onOpenhandler()
            // document.querySelectorAll('.setcheckbox')[0].checked = true
            // document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            // document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            // document.querySelectorAll('.setcheckbox')[4].checked = true
            // document.querySelectorAll('.bg_step_color')[4].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            // document.querySelectorAll('.bg_step_color')[4].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')

            // เปิดทุก tab
            document.querySelectorAll('.setcheckbox').forEach(function(el) { el.checked = true; });

        });

        const dlayMessage = 1000;

        // ========== Custom Free Form (dynamic rows → JSON) ==========
        (function() {
            var list = $('#customFreeFormList');
            var hiddenInput = $('#customFreeFormsJson');
            var items = [];

            // โหลดข้อมูลเดิมจาก hidden input
            try {
                items = JSON.parse(hiddenInput.val() || '[]');
            } catch(e) {
                items = [];
            }

            function render() {
                list.empty();
                items.forEach(function(item, i) {
                    var hasNote = item.note && item.note.trim() !== '';
                    var row = $(
                        '<div class="cff-row" data-idx="' + i + '">' +
                            '<div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-[#333] rounded">' +
                                '<button type="button" class="cff-toggle-note flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-white font-bold text-sm leading-none ' + (hasNote ? 'bg-green-500 hover:bg-green-600' : 'bg-red-400 hover:bg-red-500') + '" data-idx="' + i + '" title="เพิ่มหมายเหตุ">+</button>' +
                                '<input type="text" class="flex-1 px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-[#404040] text-gray-900 dark:text-white" ' +
                                    'value="' + escHtml(item.name) + '" data-idx="' + i + '" placeholder="ชื่อ Free Form">' +
                                '<label class="flex items-center gap-1 text-sm">' +
                                    '<input type="radio" name="cff_' + i + '" value="Y" ' + (item.value === 'Y' ? 'checked' : '') + ' data-idx="' + i + '" class="cff-radio"> ใช่' +
                                '</label>' +
                                '<label class="flex items-center gap-1 text-sm">' +
                                    '<input type="radio" name="cff_' + i + '" value="N" ' + (item.value === 'N' ? 'checked' : '') + ' data-idx="' + i + '" class="cff-radio"> ไม่ใช่' +
                                '</label>' +
                                '<button type="button" class="cff-remove text-red-500 hover:text-red-700 font-bold text-lg px-1" data-idx="' + i + '">&times;</button>' +
                            '</div>' +
                            '<div class="cff-note-area mt-1 ml-9 ' + (hasNote ? '' : 'hidden') + '">' +
                                '<textarea class="cff-note w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-[#404040] text-gray-900 dark:text-white" ' +
                                    'data-idx="' + i + '" rows="2" placeholder="หมายเหตุ...">' + escHtml(item.note || '') + '</textarea>' +
                            '</div>' +
                        '</div>'
                    );
                    list.append(row);
                });
                syncJson();
            }

            function syncJson() {
                hiddenInput.val(JSON.stringify(items));
            }

            function escHtml(str) {
                return $('<div>').text(str || '').html();
            }

            // เพิ่ม row ใหม่
            $('#btnAddFreeForm').on('click', function() {
                items.push({ name: '', value: 'N', note: '' });
                render();
                // focus input ตัวสุดท้าย
                list.find('input[type="text"]').last().focus();
            });

            // ลบ row
            list.on('click', '.cff-remove', function() {
                var idx = $(this).data('idx');
                items.splice(idx, 1);
                render();
            });

            // toggle หมายเหตุ
            list.on('click', '.cff-toggle-note', function() {
                var row = $(this).closest('.cff-row');
                var noteArea = row.find('.cff-note-area');
                noteArea.toggleClass('hidden');
                if (!noteArea.hasClass('hidden')) {
                    noteArea.find('textarea').focus();
                }
            });

            // อัพเดตหมายเหตุ
            list.on('input', '.cff-note', function() {
                var idx = $(this).data('idx');
                items[idx].note = $(this).val();
                syncJson();
                // เปลี่ยนสีปุ่ม + ตามว่ามีหมายเหตุหรือไม่
                var btn = $(this).closest('.cff-row').find('.cff-toggle-note');
                if ($(this).val().trim()) {
                    btn.removeClass('bg-red-400 hover:bg-red-500').addClass('bg-green-500 hover:bg-green-600');
                } else {
                    btn.removeClass('bg-green-500 hover:bg-green-600').addClass('bg-red-400 hover:bg-red-500');
                }
            });

            // อัพเดตชื่อ
            list.on('input', 'input[type="text"]', function() {
                var idx = $(this).data('idx');
                items[idx].name = $(this).val();
                syncJson();
            });

            // อัพเดต radio
            list.on('change', '.cff-radio', function() {
                var idx = $(this).data('idx');
                items[idx].value = $(this).val();
                syncJson();
            });

            // render ครั้งแรก
            render();
        })();

        // ========== Dropzone Logic ==========
        (function() {
            var modeConfigs = {
                images:    { exts: ['.png','.jpg','.jpeg','.webp'], label: 'Images' },
                documents: { exts: ['.pdf','.xls','.xlsx','.csv'],  label: 'Documents' }
            };
            var queue = [];

            function getMode()     { return $('#dz-mode').val(); }
            function getMaxFiles() { return Math.min(parseInt($('#dz-maxfiles').val()) || 5, 5); }
            function getMaxSize()  { return Math.min(parseFloat($('#dz-maxsize').val()) || 10, 10); }
            function getAllowedExts() { return modeConfigs[getMode()].exts; }

            function updateBadges() {
                var mode = getMode();
                var exts = modeConfigs[mode].exts.join(', ');
                $('#dz-badge-mode').text('Mode: ' + modeConfigs[mode].label);
                $('#dz-badge-limits').text('Limits: ' + getMaxFiles() + ' files, ' + getMaxSize() + ' MB each');
                $('#dz-badge-types').text('Types: ' + exts);
                $('#dz-exts').val(exts);
            }

            function formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024*1024) return (bytes/1024).toFixed(1) + ' KB';
                return (bytes/(1024*1024)).toFixed(1) + ' MB';
            }

            function getFileIcon(ext) {
                if (['.pdf'].includes(ext)) return '📄';
                if (['.xls','.xlsx','.csv'].includes(ext)) return '📊';
                return '🖼️';
            }

            function renderQueue() {
                var list = $('#dz-queue-list');
                list.empty();
                if (queue.length === 0) {
                    list.html('<p class="text-xs text-gray-400 dark:text-gray-500 text-center py-4">Nothing uploads anywhere. This is a UI component demo.</p>');
                    $('#dz-queue-count').text('0 file(s)');
                    return;
                }
                var totalSize = queue.reduce(function(s,f){ return s + f.size; }, 0);
                $('#dz-queue-count').text(queue.length + ' file(s) - ' + formatSize(totalSize));
                queue.forEach(function(f, i) {
                    var ext = f.name.substring(f.name.lastIndexOf('.')).toLowerCase();
                    var row = $(
                        '<div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-[#333] rounded text-sm">' +
                            '<span class="text-lg">' + getFileIcon(ext) + '</span>' +
                            '<div class="flex-1 min-w-0">' +
                                '<p class="truncate text-gray-800 dark:text-white font-medium">' + $('<div>').text(f.name).html() + '</p>' +
                                '<div class="flex gap-2 text-xs text-gray-400 mt-0.5">' +
                                    '<span>📦 ' + formatSize(f.size) + '</span>' +
                                    '<span>📎 ' + ext + '</span>' +
                                '</div>' +
                            '</div>' +
                            '<button type="button" class="dz-remove-item text-gray-400 hover:text-red-500 text-lg px-1" data-idx="' + i + '">×</button>' +
                        '</div>'
                    );
                    list.append(row);
                });
                $('#dz-files-json').val(JSON.stringify(queue.map(function(f){ return {name:f.name, size:f.size, type:f.type}; })));
            }

            function processFiles(files) {
                var exts = getAllowedExts();
                var maxFiles = getMaxFiles();
                var maxSizeMB = getMaxSize();
                var rejected = 0;
                $.each(files, function(_, file) {
                    var ext = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                    if (!exts.includes(ext)) { rejected++; return; }
                    if (file.size > maxSizeMB * 1024 * 1024) { rejected++; return; }
                    if (queue.length >= maxFiles) { rejected++; return; }
                    // prevent duplicate
                    var dup = queue.some(function(f){ return f.name === file.name && f.size === file.size; });
                    if (!dup) queue.push(file);
                });
                if (rejected > 0) {
                    $('#dz-rejected-msg').text('Rejected ' + rejected + ' file(s). Check limits and types.').removeClass('hidden');
                } else {
                    $('#dz-rejected-msg').addClass('hidden');
                }
                renderQueue();
            }

            // Mode change
            $('#dz-mode, #dz-maxfiles, #dz-maxsize').on('change input', function() {
                updateBadges();
                queue = [];
                renderQueue();
            });

            // File input
            $('#dz-file-input').on('change', function() {
                processFiles(this.files);
                this.value = '';
            });

            // Drag & Drop
            var dropArea = document.getElementById('dz-drop-area');
            ['dragenter','dragover'].forEach(function(e) {
                dropArea.addEventListener(e, function(ev) {
                    ev.preventDefault();
                    dropArea.classList.add('border-blue-400','bg-blue-50','dark:bg-blue-900/10');
                });
            });
            ['dragleave','drop'].forEach(function(e) {
                dropArea.addEventListener(e, function(ev) {
                    ev.preventDefault();
                    dropArea.classList.remove('border-blue-400','bg-blue-50','dark:bg-blue-900/10');
                    if (e === 'drop') processFiles(ev.dataTransfer.files);
                });
            });

            // Paste
            document.addEventListener('paste', function(ev) {
                if (ev.clipboardData && ev.clipboardData.files.length) {
                    processFiles(ev.clipboardData.files);
                }
            });

            // Remove item
            $('#dz-queue-list').on('click', '.dz-remove-item', function() {
                var idx = parseInt($(this).data('idx'));
                queue.splice(idx, 1);
                renderQueue();
            });

            // Clear queue
            $('#dz-clear-queue').on('click', function() {
                queue = [];
                $('#dz-rejected-msg').addClass('hidden');
                renderQueue();
            });

            // Init
            updateBadges();
            renderQueue();

            // Expose files for form submission
            window.getDzFiles    = function() { return queue; };
            window.getDzFormType = function() { return $('#dz-form-type').val(); };
            window.getDzFileType = function() { return $('#dz-file-type').val(); };
        })();
        // ========== End Dropzone ==========

        // ========== IBSH Preview: Select & Download ==========
        (function() {
            function updateDownloadBtn(group) {
                var checked = $('.ibsh-file-cb[data-group="' + group + '"]:checked').length;
                var btn = $('.ibsh-download-btn[data-group="' + group + '"]');
                btn.prop('disabled', checked === 0);
                btn.find('.ibsh-dl-count').remove();
                if (checked > 0) {
                    btn.append('<span class="ibsh-dl-count">(' + checked + ')</span>');
                }
            }

            // Select All
            $('.ibsh-select-all').on('change', function() {
                var group = $(this).data('group');
                var isChecked = $(this).is(':checked');
                $('.ibsh-file-cb[data-group="' + group + '"]').prop('checked', isChecked);
                updateDownloadBtn(group);
            });

            // Individual checkbox
            $(document).on('change', '.ibsh-file-cb', function() {
                var group = $(this).data('group');
                var total = $('.ibsh-file-cb[data-group="' + group + '"]').length;
                var checked = $('.ibsh-file-cb[data-group="' + group + '"]:checked').length;
                $('.ibsh-select-all[data-group="' + group + '"]').prop('checked', total === checked);
                updateDownloadBtn(group);
            });

            // Download selected
            $('.ibsh-download-btn').on('click', function() {
                var group = $(this).data('group');
                var items = $('.ibsh-file-cb[data-group="' + group + '"]:checked');
                if (items.length === 0) return;

                items.each(function(i) {
                    var url = $(this).data('url');
                    var name = $(this).data('name');
                    setTimeout(function() {
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = name;
                        a.style.display = 'none';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }, i * 300);
                });
            });
        })();
        // ========== End IBSH Preview ==========

        function gallery() {
            return {
                galleryOpen: false,
                modalVisible: false,
                activeImageUrl: '',
                currentIndex: 0,
                images: [],
                isAnimating: false,
                transitionDelay: 400,
                slideDirection: 'image-slide-active',
                zoomLevel: 1,
                openGallery(index) {
                    console.log('📸 เปิดรูป Index:', index);
                    this.currentIndex = index;
                    this.zoomLevel = 1;
                    this.modalVisible = true;
                    this.galleryOpen = false;
                    this.activeImageUrl = '';
                    this.activeImageUrl = this.images[this.currentIndex];
                    this.galleryOpen = true;
                },
                closeGallery() {
                    console.log('❌ ปิด Gallery');
                    this.galleryOpen = false;
                    this.zoomLevel = 1;

                    setTimeout(() => {
                        this.modalVisible = false;
                        this.activeImageUrl = '';
                        this.currentIndex = null;
                    }, this.transitionDelay);
                },
                zoomIn() {
                    if (this.zoomLevel < 3) this.zoomLevel = Math.round((this.zoomLevel + 0.25) * 100) / 100;
                },
                zoomOut() {
                    if (this.zoomLevel > 0.5) this.zoomLevel = Math.round((this.zoomLevel - 0.25) * 100) / 100;
                },
                resetZoom() {
                    this.zoomLevel = 1;
                },
                prevImage() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;

                    let newIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    this.changeImage(newIndex, 'prev');
                },
                nextImage() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;

                    let newIndex = (this.currentIndex + 1) % this.images.length;
                    this.changeImage(newIndex, 'next');
                },
                changeImage(newIndex, direction) {
                    console.log('🔄 Slide:', this.currentIndex, '->', newIndex, 'ทิศทาง:', direction);
                    this.zoomLevel = 1;
                    this.slideDirection = direction === 'next' ? 'image-slide-next' : 'image-slide-prev';

                    setTimeout(() => {
                        this.currentIndex = newIndex;
                        this.activeImageUrl = this.images[newIndex];

                        this.$nextTick(() => {
                            this.slideDirection = 'image-slide-active';
                        });

                        this.isAnimating = false;
                    }, 400);
                },
                initGallery() {
                    this.$nextTick(() => {
                        this.images = [...this.$refs.gallery.querySelectorAll('img')].map(img => img.src);
                        // console.log('📂 โหลดรูป:', this.images);
                    });
                }
            };
        }



        // const dlayMessage = 500;
        jQuery(document).ready(function () {
            ImgUpload();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function editProductDetail() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData(document.getElementById('update_product_detail'));
            formData.append('_method', 'POST');

            // Append Dropzone files
            if (window.getDzFiles) {
                window.getDzFiles().forEach(function(file) {
                    formData.append('dz_files[]', file);
                });
                formData.append('dz_form_type', window.getDzFormType ? window.getDzFormType() : '');
                formData.append('dz_file_type', window.getDzFileType ? window.getDzFileType() : '');
            }

            $.ajax({
                method: "POST",
                url: "{{ route('ibhs.ibhs_store') }}",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        window.location = "/ibhs/product_description";
                    } else {
                        toastr.error("Can't Create Product!");
                    }
                    return false;
                },
                error: function (params) {
                    setTimeout(function() {
                        errorMessage("Can't Create!");
                    },dlayMessage)
                    setTimeout(function() {
                        toastr.error("Can't Create!");
                    },dlayMessage)
                }
            });
        }

        function successMessage(text) {
            $('#loader').addClass('hidden');
        }
        function errorMessage(text) {
            $('#loader').addClass('hidden');
        }

        function ImgUpload() {
            let imgWrap = "";
            let imgArray = [];

            $('.upload__inputfile').each(function () {
                $(this).on('change', function (e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    let maxLength = $(this).attr('data-max_length');

                    let files = e.target.files;
                    let filesArr = Array.prototype.slice.call(files);
                    let iterator = 0;
                    filesArr.forEach(function (f, index) {
                        if (!f.type.match('image.*')) {
                            return;
                        }
                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            let len = 0;
                            for (let i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                let reader = new FileReader();
                                reader.onload = function (e) {
                                    let html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function (e) {
                let file = $(this).parent().data("file");
                for (let i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
@endsection
