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

        $labels = [
            'รูป Show',
            'รูป Unit',
            'รูป Inner',
            'รูป Case',
            'รูป การเรียงสินค้าใน case',
        ];
    @endphp

@section('content')
    <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">แก้ไขรายการสินค้า</p>
            </div>
            <div class='w-12/12 mt-4 relative'>
                <form class="" action="" method="POST" id="update_product_detail">    
                    <input type="text" name="corporation_id" id="corporation_id" class="" hidden value="{{ $data->corporation_id }}">
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
                                                        ข้อมูลสินค้า
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
                                                                    <label for="product_id">รหัสสินค้า</label>
                                                                    <input type="text" name="product_id" id="product_id" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->product_id }}" readonly>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="name">การมองเห็นข้อมูล<span class="text-danger"> *</span></label>
                                                                    <div class="md:col-span-4 mt-5" style="position: relative;">
                                                                        <input type="radio" id="permission_y" name="permission" value="Y"
                                                                            {{ $data->permission == 'Y' ? 'checked' : '' }}>
                                                                        <label for="" class="mr-5">สาธารณะ</label>
                                                                        <input type="radio" id="permission_n" name="permission" value="N"
                                                                            {{ $data->permission == 'N' ? 'checked' : '' }}>
                                                                        <label for="">ปิดกั้น</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <ul class="width-full pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                            <div class="p-2 ">
                                                                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Launch</p>
                                                            </div>
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                <!-- <div class="md:col-span-3">
                                                                    <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">เดือน<span class="text-danger"> *</span></label>
                                                                    <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5 ">
                                                                        <option value="" selected> --- กรุณาเลือก ---</option>
                                                                        @for ($i = 1; $i <= 12; $i++)
                                                                            <option value="{{ $i }}" class="text-md">{{ $i }} เดือน</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="countries" class="mt-1 text-sm font-medium text-gray-900 dark:text-white">ปี<span class="text-danger"> *</span></label>
                                                                    <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5">
                                                                        <option value="" selected> --- กรุณาเลือก ---</option>
                                                                        @for ($i = 2010; $i <= date("Y"); $i++)
                                                                            <option value="{{ $i }}" class="text-md">{{ $i }} ปี</option>
                                                                        @endfor
                                                                    </select>
                                                                </div> -->

                                                                <!-- <div class="md:col-span-2" style="position: relative;">
                                                                    <label for="name">ชื๋อสินค้า<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="name" id="name" onkeyup="checkNameBrand()" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                                                    <div class="col-auto" style="position: absolute; right: -0.5%; top: 59.5%; z-index: 10000;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" id="username_loading" class="w-5 h-5 animate-spin">
                                                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        <i class="fa fa-check-circle text-success" id="correct_username" style="font-size: 15px;"></i>
                                                                        <i class="fa fa-times-circle text-danger" id="username_alert" style="font-size: 15px;"></i>
                                                                    </div>
                                                                </div> -->

                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="launch">วันที่สร้างทะเบียน</label>
                                                                    <input type="month" name="launch" id="launch" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="" autocomplete="off" value="{{ $data->launch }}" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                </div>

                                                                <div class="md:col-span-3">
                                                                    <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">ผลิตประเทศ</label>
                                                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="country">
                                                                        <option value=""> --- กรุณาเลือก ---</option>
                                                                        @foreach ($countriesDatas as $key => $countriesData)
                                                                        <option value="{{ $countriesData['name_country'] }}" {{ $countriesData['name_country'] == $data->country ? 'selected' : '' }}>
                                                                                {{ $countriesData['name_country'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="fad">เลข อย.<span class="text-danger"> *</span></label>
                                                                    <input type="text" name="fad" id="fad" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->fad }}" readonly />
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
                                        2
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด2
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                                <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        ส่วนผสมและการเก็บรักษา
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
                                                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ส่วนประกอบหลังกล่อง</label>
                                                                    <textarea id="ingredients" name="ingredients" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->ingredients ?? '' }}</textarea>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="after_open_m">ระยะเวลาหลังเปิดใช้<span class="text-danger"> *</span></label>
                                                                    <!-- <input type="text" name="after_open_m" id="after_open_m" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->after_open_m }}" เดือน/> -->
                                                                    <input type="text" name="after_open_m" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ isset($data->after_open_m) ? $data->after_open_m . ' เดือน' : '' }}">
                                                                    <!-- <input type="hidden" name="after_open_m" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->after_open_m }}"> -->
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
                                        3
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด3
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        วิธีใช้และคุณสมบัติอื่นๆ
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
                                                                    <label for="description_th" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดหลังกล่อง(ภาษาไทย)</label>
                                                                    <textarea id="description_th" name="description_th" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->description_th ?? '' }}</textarea>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="description_en" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดหลังกล่อง(ภาษาอังกฤษ)</label>
                                                                    <textarea id="description_en" name="description_en" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->description_en ?? '' }}</textarea>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="usage_direction_th" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วิธีใช้(ภาษาไทย)</label>
                                                                    <textarea id="usage_direction_th" name="usage_direction_th" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->usage_direction_th ?? '' }}</textarea>
                                                                </div>
                                                                <div class="md:col-span-3">
                                                                    <label for="usage_direction_en" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วิธีใช้(ภาษาอังกฤษ)</label>
                                                                    <textarea id="usage_direction_en" name="usage_direction_en" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->usage_direction_en ?? '' }}</textarea>
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="color_code_th">สี(ภาษาอังกฤษ)</label>
                                                                    <input type="text" name="color_code_th" id="color_code_th" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->color_code_th }}" />
                                                                </div>
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <label for="color_code_en">สี(ภาษาอังกฤษ)</label>
                                                                    <input type="text" name="color_code_en" id="color_code_en" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="{{ $data->color_code_en }}" />
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
                            <li data-twe-stepper-step-ref="" data-twe-stepper-step-completed="">
                                <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                    <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                        4
                                    </span>
                                    <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                        รายละเอียด4
                                    </span>
                                </div>
                                <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                    <div class="grid grid-cols-5 gap-10">
                                        <div class="form col-span-5">
                                            <div class="relative w-full overflow-hidden">
                                                <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                                                <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                    <h1 class="text-gray-900 dark:text-white text-lg">
                                                        Dimension
                                                    </h1>
                                                </div>
                                                <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                                    <div class="p-2 ">
                                                        <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Unit(สินค้า + กล่อง)</p>
                                                    </div>
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-4 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-4">
                                                            <div class="relative">
                                                                <div class="grid gap-0 gap-y-2 text-sm grid-cols-1 md:grid-cols-8">
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                    <input value="{{ $dataComProduct->width }}" id="" name="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Net Weight, น้ำหนักสินค้า)</label>
                                                                    <input value="{{ $dataComProduct->unit_net_weight }}" id="unit_net_weight" name="unit_net_weight" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                    <input value="{{ $dataComProduct->long }}" id="" name="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Gross Weight, สินค้า+กล่อง)</label>
                                                                    <input value="{{ $dataComProduct->weight }}" id="" name="weight" type="text" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                    <input value="{{ $dataComProduct->height }}" id="" name="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">Barcode สินค้าจริง</label>
                                                                    <input value="{{ $dataComProduct->ref_barcode_real }}" id="ref_barcode_real" name="ref_barcode_real" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <input value="{{ $dataComProduct->inner_weight }}" id="inner_weight" name="inner_weight" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500 invisible " />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">pack size</label>
                                                                    <input value="{{ $dataComProduct->unit_pak_size }}" id="unit_pak_size" name="unit_pak_size" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                </div>

                                                                {{-- Unit = seq 2 --}}
                                                                <img src="{{ $unitSrc }}" 
                                                                    class="hidden md:block absolute right-20 top-2 w-44 rounded shadow cursor-zoom-in"
                                                                    onmouseenter="showZoomById('zoomPreview-2','zoomImage-2', this.src)"
                                                                    onmouseleave="hideZoomById('zoomPreview-2')">

                                                                <div id="zoomPreview-2" class="zoom-preview">
                                                                    <img id="zoomImage-2">
                                                                </div>

                                                                {{-- มือถือ: แสดงรูปแบบปกติด้านล่าง (ไม่ absolute) --}}
                                                                <div class="md:hidden p-2">
                                                                    <div class="p-4 rounded shadow-sm">
                                                                        <img src="{{ $unitSrc }}" alt="Unit image (seq 2)" class="w-full h-auto object-contain rounded">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 ">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                        <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Inner(หลายๆ Unit ต่อ 1 กล่อง)</p>
                                                    </div>
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-6">
                                                            <div class="relative">
                                                                <div class="grid gap-0 gap-y-2 text-sm grid-cols-1 md:grid-cols-8">
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                    <input value="{{ $dataComProduct->km_inner_width }}" id="km_inner_width" name="km_inner_width" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Net Weight, น้ำหนักสินค้า)</label>
                                                                    <input value="{{ $dataComProduct->inner_net_weight }}" id="inner_net_weight" name="inner_net_weight" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>
    
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                    <input value="{{ $dataComProduct->km_inner_long }}" id="km_inner_long" name="km_inner_long" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Gross Weight, สินค้า+กล่อง)</label>
                                                                    <input value="{{ $dataComProduct->inner_gross_weight }}" id="inner_gross_weight" name="inner_gross_weight" type="text" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>
    
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                    <input value="{{ $dataComProduct->km_inner_height }}" id="km_inner_height" name="km_inner_height" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">barcode</label>
    
                                                                    <!-- BAR_PACK1 -->
                                                                    @if ($dataComProduct->product_id > 29999)
                                                                        <input value="{{ $dataComProduct->inner_barcode }}" id="inner_barcode" name="inner_barcode" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    @else
                                                                        <input value="{{ $dataComProduct->BAR_PACK1 }}" id="inner_barcode" name="inner_barcode" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    @endif
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
    
                                                                    <!-- Invisible(ล่องหน) -->
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <input value="" id="" name="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500 invisible " />
    
                                                                    <!-- PACK_SIZE1 -->
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">pack size (pack size1)</label>
                                                                    @if ($dataComProduct->product_id > 29999)
                                                                        <input value="{{ $dataComProduct->inner_pack_size }}" id="inner_pack_size" name="inner_pack_size" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    @else
                                                                        <input value="{{ $dataComProduct->PACK_SIZE1 }}" id="PACK_SIZE1" name="PACK_SIZE1" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    @endif
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                </div>
    
                                                                {{-- Inner = seq 3 --}}
                                                                <img src="{{ $innerSrc }}" 
                                                                    class="hidden md:block absolute right-20 -top-10 w-44 rounded shadow cursor-zoom-in"
                                                                    onmouseenter="showZoomById('zoomPreview-3','zoomImage-3', this.src)"
                                                                    onmouseleave="hideZoomById('zoomPreview-3')">
    
                                                                <div id="zoomPreview-3" class="zoom-preview">
                                                                    <img id="zoomImage-3">
                                                                </div>
    
                                                                {{-- มือถือ: แสดงรูปแบบปกติด้านล่าง (ไม่ absolute) --}}
                                                                <div class="md:hidden p-2">
                                                                    <div class="p-4 rounded shadow-sm">
                                                                    <img src="{{ $innerSrc }}" alt="Unit image (seq 3)"
                                                                        class="w-full h-auto object-contain rounded">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 ">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                        <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Case(หลายๆ Inner ต่อ 1 ลัง)</p>
                                                    </div>
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-6">
                                                            <div class="relative">
                                                                <div class="grid gap-0 gap-y-2 text-sm grid-cols-1 md:grid-cols-8">
                                                                    <!-- case_width -->
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                    <input value="{{ $dataComProduct->km_case_width }}" id="km_case_width" name="km_case_width" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Net Weight, น้ำหนักสินค้า)</label>
                                                                    <input value="{{ $dataComProduct->case_net_weight }}" id="case_net_weight" name="case_net_weight" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                    <input value="{{ $dataComProduct->km_case_long }}" id="km_case_long" name="km_case_long" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(Gross Weight, สินค้า+กล่อง)</label>
                                                                    <input value="{{ $dataComProduct->case_gross_weight }}" id="case_gross_weight" name="case_gross_weight" type="text" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; g</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                    <input value="{{ $dataComProduct->km_case_height }}" id="km_case_height" name="km_case_height" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">&nbsp; ซม.</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">barcode</label>
                                                                    <input value="{{ $dataComProduct->case_barcode }}" id="" name="case_barcode" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                    <!-- Invisible(ล่องหน) -->
                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <input value="" id="" name="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500 invisible " />
                                                                    <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>

                                                                    <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start invisible">ล่องหน</label>
                                                                    <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">pack size (pack size2)</label>
                                                                    <input value="{{ $dataComProduct->case_pack_size }}" id="case_pack_size" name="case_pack_size" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                </div>
                                                                {{-- Case = seq 4 --}}
                                                                <img src="{{ $caseSrc }}" 
                                                                    class="hidden md:block absolute right-20 -top-10 w-44 rounded shadow cursor-zoom-in"
                                                                    onmouseenter="showZoomById('zoomPreview-4','zoomImage-4', this.src)"
                                                                    onmouseleave="hideZoomById('zoomPreview-4')">

                                                                <div id="zoomPreview-4" class="zoom-preview">
                                                                    <img id="zoomImage-4">
                                                                </div>

                                                                {{-- มือถือ: แสดงรูปแบบปกติด้านล่าง (ไม่ absolute) --}}
                                                                <div class="md:hidden p-2">
                                                                    <div class="p-4 rounded shadow-sm">
                                                                    <img src="{{ $caseSrc }}" alt="Unit image (seq 3)"
                                                                        class="w-full h-auto object-contain rounded">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 ">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                    </div>
                                                    
                                                    <!-- <div class="p-2 ">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                        <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">รายละเอียดสินค้า(Case KM)</p>
                                                    </div>
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-6">
                                                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ความกว้าง</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ความยาว</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ความสูง</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">พื้นที่</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้น/ลัง</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลัง/พาเลท</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก</label>
                                                                <input value="" id="" type="number" class="col-span-1 m-0 p-0 text-center bg-[#e7e7e7] border border-gray-900 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly />
                                                                <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"> g</label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    
                                                    <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                        <div class="lg:col-span-6">
                                                            <div class="md:col-span-3">
                                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">หมายเหตุแก้ไข</label>
                                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here...">{{ $data->remark_update ?? '' }}</textarea>
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
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("gross_weight_inner").value = grossWeightPerInner.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            document.getElementById("gross_weight_case").value = grossWeightPerCase.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
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

        function editProductDetail() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('product_detail.pd_detail_update', $data->product_id) }}",
                data: $("#update_product_detail").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        window.location = "/product_detail/pd_detail";
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
