@extends('layouts.layout')
@section('title', '')

    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="p-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">ทะเบียนคลังสินค้า</p>
            </div>
            <form class="" action="" method="POST" id="create_warehouse_dimension">
                <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="lg:col-span-4 xl:grid-cols-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                            <div class="md:col-span-3">
                                <label for="barcode">Baocode</label>
                                <input type="text" name="barcode" id="barcode" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->barcode }}" readonly>
                            </div>
                            <div class="md:col-span-3" >
                                <label for="NUMBER">รหัส</label>
                                <input type="text" name="product_id" id="product_id" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $data->product_id }}" readonly>
                            </div>
                            <div class="col-auto" style="position: absolute; right: 5.5%; top: 23.2%;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" id="username_loading" style="margin-right: -2.5px;" class="w-6 h-6 animate-spin -mt-1">
                                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                </svg>
                                <svg id="correct_username" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 507.2 507.2" xml:space="preserve">
                                    <circle style="fill:#32BA7C;" cx="253.6" cy="253.6" r="253.6"/>
                                    <path style="fill:#0AA06E;" d="M188.8,368l130.4,130.4c108-28.8,188-127.2,188-244.8c0-2.4,0-4.8,0-7.2L404.8,152L188.8,368z"/>
                                    <g>
                                        <path style="fill:#FFFFFF;" d="M260,310.4c11.2,11.2,11.2,30.4,0,41.6l-23.2,23.2c-11.2,11.2-30.4,11.2-41.6,0L93.6,272.8
                                            c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L260,310.4z"/>
                                        <path style="fill:#FFFFFF;" d="M348.8,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6l-176,175.2
                                            c-11.2,11.2-30.4,11.2-41.6,0l-23.2-23.2c-11.2-11.2-11.2-30.4,0-41.6L348.8,133.6z"/>
                                    </g>
                                </svg>
                                <svg id="username_alert" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 507.2 507.2" xml:space="preserve">
                                    <circle style="fill:#F15249;" cx="253.6" cy="253.6" r="253.6"/>
                                    <path style="fill:#AD0E0E;" d="M147.2,368L284,504.8c115.2-13.6,206.4-104,220.8-219.2L367.2,148L147.2,368z"/>
                                    <path style="fill:#FFFFFF;" d="M373.6,309.6c11.2,11.2,11.2,30.4,0,41.6l-22.4,22.4c-11.2,11.2-30.4,11.2-41.6,0l-176-176
                                        c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L373.6,309.6z"/>
                                    <path style="fill:#D6D6D6;" d="M280.8,216L216,280.8l93.6,92.8c11.2,11.2,30.4,11.2,41.6,0l23.2-23.2c11.2-11.2,11.2-30.4,0-41.6
                                        L280.8,216z"/>
                                    <path style="fill:#FFFFFF;" d="M309.6,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6L197.6,373.6
                                        c-11.2,11.2-30.4,11.2-41.6,0l-22.4-22.4c-11.2-11.2-11.2-30.4,0-41.6L309.6,133.6z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
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
                                                        Dimension
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
                                                            <div class="p-2 ">
                                                                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Unit(สินค้า + กล่อง)</p>
                                                            </div>
                                                            <div class="p-2 grid mt-5 gap-2 gap-y-4 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                                <div class="lg:col-span-4">
                                                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-2 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-stretch">pack size</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Inner(หลายๆ Unit ต่อ 1 กล่อง)</p>
                                                            </div>
                                                            <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                                <div class="lg:col-span-6">
                                                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">barcode</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กรัม</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">pack size</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">Case(หลายๆ Inner ต่อ 1 ลัง)</p>
                                                            </div>
                                                            <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                                <div class="lg:col-span-6">
                                                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">barcode</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กรัม</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">pack size</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                <!-- <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">รายละเอียดสินค้า(Case KM)</p> -->
                                                            </div>
                                                            <!-- <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                                <div class="lg:col-span-6">
                                                                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">พื้นที่(ก * ย * ส)</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลูกบาศก์เซนติเมตร</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้นต่อลัง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้น</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลังต่อพาเลท</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลัง</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(สินค้า + กล่อง)</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กรัม</label>
                                                                    </div>
                                                                </div>
                                                            </div> -->

                                                            <div class="p-8">
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                                                    <aside class="">
                                                                            <div class="camera-center">
                                                                                <div class="panel">
                                                                                    <button id="switchFrontBtn" type="button" class="text-sm text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                                                                        <svg class="-mt-1 size-6 hidden h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 -2 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                                                            <g id="Page-1" stroke="none" stroke-width="1" fill-rule="evenodd" sketch:type="MSPage">
                                                                                                <g id="Icon-Set-Filled" sketch:type="MSLayerGroup" transform="translate(-258.000000, -467.000000)" fill="currentColor">
                                                                                                    <path d="M286,471 L283,471 L282,469 C281.411,467.837 281.104,467 280,467 L268,467 C266.896,467 266.53,467.954 266,469 L265,471 L262,471 C259.791,471 258,472.791 258,475 L258,491 C258,493.209 259.791,495 262,495 L286,495 C288.209,495 290,493.209 290,491 L290,475 C290,472.791 288.209,471 286,471 Z M274,491 C269.582,491 266,487.418 266,483 C266,478.582 269.582,475 274,475 C278.418,475 282,478.582 282,483 C282,487.418 278.418,491 274,491 Z M274,477 C270.687,477 268,479.687 268,483 C268,486.313 270.687,489 274,489 C277.313,489 280,486.313 280,483 C280,479.687 277.313,477 274,477 L274,477 Z" id="camera" sketch:type="MSShapeGroup"></path>
                                                                                                </g>
                                                                                            </g>
                                                                                        </svg>
                                                                                        เปิดกล้อง
                                                                                    </button>
                                                                                </div>
                                                                                <div class="flex justify-items-center">
                                                                                    <video id="cam" autoplay muted playsinline>Not available</video>
                                                                                    <canvas id="canvas" style="display:none"></canvas>
                                                                                </div>
                                                                            </div>
                                                                            <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                                                                <div class="lg:col-span-4">
                                                                                    <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                                        <div class="md:col-span-3" style="position: relative;">
                                                                                            <div class="panel">
                                                                                                <button id="snapBtnFont" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">ถ่ายด้านหน้า</button>
                                                                                            </div>
                                                                                            <div style="width:100%">
                                                                                                <img id="photoFont" alt="The screen capture will appear in this box.">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="md:col-span-3" style="position: relative;">
                                                                                            <div class="panel">
                                                                                                <button id="snapBtnBack" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">ถ่ายด้านหลัง</button>
                                                                                            </div>
                                                                                            <div style="width:100%">
                                                                                                <img id="photoBack" alt="The screen capture will appear in this box.">
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="">
                                                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-500"></ul>
                                                                                    </div>

                                                                                    <div class="p-1" style="position: relative;">
                                                                                        <div class="mt-2 justify-center items-center duration-500">
                                                                                            <form>
                                                                                                <div class="upload__box">
                                                                                                    <div class="upload__btn-box w-full">
                                                                                                        <label class="w-full h-10 text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-2 px-2 rounded cursor-pointer flex justify-center items-center relative">
                                                                                                            <input type="file" name="images[]" id="images" multiple class="w-full">
                                                                                                            <!-- <input type="file" name="images[]" id="images" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                                                                                            <span>📸 เลือกไฟล์</span> -->
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="p-3">
                                                                                                        <div id="preview" class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                                                                                                    </div>
                                                                                                    
                                                                                                    <div class="flex justify-center items-center mt-10">
                                                                                                        <a href="" type="button" id="upload-button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                                                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                                                                                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                                                                                            </svg>
                                                                                                            Upload
                                                                                                        </a>
                                                                                                        <!-- <button type="button" id="upload-button" class="bg-blue-800 text-white px-4 py-1.5 rounded hover:bg-blue-900">
                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                                                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                                                                                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                                                                                            </svg>
                                                                                                            Upload
                                                                                                        </button> -->
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                            <div class="images">
                                                                                                <div id="img-1" class="img-1"></div>
                                                                                                <div id="img-2" class="img-2"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                                                                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                                                                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                    </aside>

                                                                    <form>
                                                                        <div class="mb-5">
                                                                            <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">รายละเอียดสินค้า(Case KM)</p>
                                                                        </div>
                                                                        <div class="grid gap-4 gap-y-10 text-sm grid-cols-1 md:grid-cols-3">
                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กว้าง</label>
                                                                            <input value="{{ $data->width }}" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ยาว</label>
                                                                            <input value="{{ $data->long }}" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>

                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">สูง</label>
                                                                            <input value="{{ $data->height }}" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ซม.</label>
                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">พื้นที่(ก * ย * ส)</label>
                                                                            <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลูกบาศก์เซนติเมตร</label>

                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้นต่อลัง</label>
                                                                            <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้น</label>
                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลังต่อพาเลท</label>
                                                                            <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลัง</label>
                                                                            <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก(สินค้า + กล่อง)</label>
                                                                            <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                            <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กรัม</label>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
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
                        <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="md:col-span-6 text-right mt-4">
                            <div class="inline-flex items-end">
                                <a href="{{ route('warehouse.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 mr-2 rounded group">
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
                                <!-- <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50" onclick="createProductMaster()" disabled> -->
                                <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50" disabled>
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
                </div>
            </form>
        </div>
    </div>

    <div class="p-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Preview Images</p>
            </div>
            <div class='w-12/12 mt-4 relative'>
                <div class="p-4">
                    <ul class="relative m-0 w-full list-none overflow-hidden p-0 transition-[height] duration-200 ease-in-out" data-twe-stepper-init="" data-twe-stepper-type="vertical">
                        <li data-twe-stepper-step-ref="" class="relative h-fit after:absolute after:left-[1.20rem] after:top-[2.2rem] after:mt-px after:h-[calc(100%-2.2rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-white/10" data-twe-stepper-step-completed="">
                            <div data-twe-stepper-head-ref="" class="setpcollep flex cursor-pointer items-center p-1 leading-[1.3rem] no-underline after:bg-neutral-200 after:content-[''] hover:bg-stone-50 dark:after:bg-white/10 dark:hover:bg-white/[.025]" tabindex="0">
                                <span data-twe-stepper-head-icon-ref="" class="bg_step_color me-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm  !bg-primary-100 !text-primary-700 dark:!bg-slate-900 dark:!text-primary-500">
                                    2
                                </span>
                                <span data-twe-stepper-head-text-ref="" class="after:absolute after:flex after:text-[0.8rem] text-black/50 dark:text-white/50 font-medium !text-black/50 dark:!text-white/50">
                                    รายละเอียด 2
                                </span>
                            </div>
                            <div data-twe-stepper-content-ref="" class="transition-[height, margin-bottom, padding-top, padding-bottom] left-0 overflow-hidden  ps-[1.75rem] duration-100 ease-in-out text-gray-900 dark:text-white" >
                                <div class="grid grid-cols-5 gap-10">
                                    <div class="form col-span-5">
                                        <div class="relative w-full overflow-hidden peer-checked:hidden">
                                            <input type="checkbox" class="setcheckbox peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
                                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                                <h1 class="text-gray-900 dark:text-white text-lg">
                                                    รายละเอียด 2
                                                </h1>
                                            </div>
                                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full relative">
                                                <section x-data="gallery()" x-init="initGallery()"
                                                    @keyup.right.window="nextImage()"
                                                    @keyup.left.window="prevImage()"
                                                    @keydown.escape.window="closeGallery()"
                                                    class="select-none">

                                                    <!-- <div x-ref="gallery" class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4 bg-[#d7d8db] dark:bg-[#404040] p-4 imgSortable" id="img-drop">
                                                        @foreach($images as $index => $image)
                                                            <div class="relative group mb-4 break-inside-avoid img-item" data-id="{{ $image->id }}">
                                                                <img
                                                                    src="{{ asset($image->path) }}"
                                                                    class="w-full h-auto cursor-pointer rounded shadow-sm hover:shadow-md hover:shadow-gray-400 
                                                                        dark:hover:shadow-md dark:hover:shadow-gray-400 
                                                                        transition-transform duration-300 ease-in-out hover:scale-105"
                                                                    @click="openGallery({{ $index }})"
                                                                    alt="Uploaded Image"
                                                                />
                                                                <div class="after_upload_upload__img_close delete-uploaded"
                                                                    data-id="{{ $image->id }}"
                                                                    data-path="{{ asset($image->path) }}">
                                                                    ✖
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div> -->

                                                    <div x-ref="gallery" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-gray-100 dark:bg-[#404040] p-4 imgSortable" id="img-drop">
                                                        @foreach($images as $index => $image)
                                                            <div class="relative group img-item" data-id="{{ $image->id }}">
                                                                <img
                                                                    src="{{ $image->path ? asset($image->path) : 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg' }}"
                                                                    class="h-auto max-w-full cursor-pointer rounded shadow-sm hover:shadow-md hover:shadow-gray-400 
                                                                    dark:hover:shadow-md dark:hover:shadow-gray-400 transition-transform duration-300 ease-in-out hover:scale-105" 
                                                                    @if($image->path) @click="openGallery({{ $index }})" @endif
                                                                    alt="Uploaded Image"
                                                                >
                                                                @if($image->path)
                                                                    <div class="after_upload_upload__img_close delete-uploaded"
                                                                        data-id="{{ $image->id }}"
                                                                        data-path="{{ asset($image->path) }}">
                                                                        ✖
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Modal Popup for Large Image View -->
                                                    <div x-show="modalVisible" x-cloak
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 transition-opacity duration-300"
                                                        @click.away="closeGallery()" :class="{ 'modal-enter': galleryOpen, 'modal-leave': !galleryOpen }">

                                                        <div class="relative w-full h-full flex items-center justify-center">
                                                            <!-- รูปภาพ -->
                                                            <img :src="activeImageUrl" class="max-w-[90%] max-h-[90%] object-contain rounded-lg shadow-lg" :class="slideDirection">

                                                            <!-- ปุ่มปิด -->
                                                            <button @click="closeGallery()" class="absolute top-4 right-4 p-2 rounded-full z-50 bg-gray-300 hover:bg-gray-400">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>

                                                            <!-- ปุ่ม Prev -->
                                                            <button @click="prevImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-gray-300 hover:bg-gray-400 p-2 rounded-full z-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                                                </svg>
                                                            </button>

                                                            <!-- ปุ่ม Next -->
                                                            <button @click="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-300 hover:bg-gray-400 p-2 rounded-full z-50">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="image_sequence_loader" class="image_sequence_loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    @if (session('message'))
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
                toastr.success('{{ session('message') }}');
            });
        </script>
    @endif

    <script>
        // reference to the current media stream
        var mediaStream = null;
        // Prefer camera resolution nearest to 1280x720.
        var constraints = {
        audio: false,
        video: {
            width: {ideal: 640},
            height: {ideal: 480},
            facingMode: "environment"
        }
        };
        async function getMediaStream(constraints) {
            try {
                mediaStream =  await navigator.mediaDevices.getUserMedia(constraints);
                let video = document.getElementById('cam');
                video.srcObject = mediaStream;
                video.onloadedmetadata = (event) => {
                video.play();
                };
            } catch (err)  {
                console.error(err.message);
            }
        };
        async function switchCamera(cameraMode) {
            try {
                // stop the current video stream
                if (mediaStream != null && mediaStream.active) {
                    var tracks = mediaStream.getVideoTracks();
                    tracks.forEach(track => {
                        track.stop();
                    })
                }
                // set the video source to null
                document.getElementById('cam').srcObject = null;
                // change "facingMode"
                constraints.video.facingMode = cameraMode;
                // get new media stream
                await getMediaStream(constraints);
            } catch (err)  {
                console.error(err.message);
                alert(err.message);
            }
        }

        function updatePreviewFromSnap(imageData, isFront, file) {
            const preview = document.getElementById('preview');
            // **เก็บค่า isFront ลงในไฟล์เพื่อให้ removeImageFile() ใช้งานได้**
            file.isFront = isFront;
            // สร้าง container ของรูป
            const imgContainer = document.createElement('div');
            imgContainer.className = 'relative w-full h-32 object-cover rounded-lg shadow-md overflow-hidden';
            // ใช้ Base64 แสดงรูปใน preview
            const img = document.createElement('img');
            img.src = imageData;
            img.className = 'w-full h-full object-cover rounded-lg';
            // ปุ่ม ❌ เพื่อลบรูป
            const closeButton = document.createElement('button');
            closeButton.innerHTML = '&times;';
            closeButton.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-sm';
            closeButton.onclick = function () {
                preview.removeChild(imgContainer);
                console.log(`❌ กำลังลบรูป Snap ${isFront ? "หน้า" : "หลัง"} - ส่งค่าไป removeImageFile()`);
                removeImageFile(file, isFront);
            };
            // เพิ่มองค์ประกอบเข้าไปใน preview
            imgContainer.appendChild(img);
            imgContainer.appendChild(closeButton);
            preview.appendChild(imgContainer);
        }

        function removeImageFile(index) {
            console.log(`❌ กำลังลบรูปที่ index ${index} ออกจาก imageFiles`);
            // ลบรูปจาก imageFiles
            imageFiles.splice(index, 1);
            // อัปเดต input#images
            updateFileInput();
            // อัปเดต preview
            updatePreview();
        }

        function base64ToUUIDFile(base64Data) {
            if (!base64Data.startsWith('data:image/')) {
                console.error("❌ base64ToUUIDFile: ค่า Base64 ไม่ถูกต้อง", base64Data);
                return null; // ป้องกันการคืนค่าผิดพลาด
            }
            // สร้างชื่อไฟล์แบบ UUID
            let filename = 'img_' + crypto.randomUUID() + '.jpg';
            // แปลง Base64 เป็นไฟล์
            let arr = base64Data.split(',');
            let mime = arr[0].match(/:(.*?);/)[1];
            let bstr = atob(arr[1]);
            let n = bstr.length;
            let u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            let file = new File([u8arr], filename, { type: mime });

            console.log("✅ base64ToUUIDFile: ได้ไฟล์", file);
            return file;
        }

        function takePictureFont() {
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photoFont = document.getElementById('photoFont');
            let context = canvas.getContext('2d');

            const width = video.videoWidth;
            const height = video.videoHeight;

            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                let dataUrl = canvas.toDataURL('image/png');

                // แสดงรูปที่ photoFont และ img-1
                photoFont.src = dataUrl;
                document.getElementById("img-1").style.backgroundImage = `url(${dataUrl})`;

                // แปลง Base64 เป็นไฟล์ UUID และ Push เข้า `#images`
                let file = base64ToUUIDFile(dataUrl);
                if (file) {
                    file.isFront = true; // **เก็บค่า isFront**
                    imageFiles.push(file);
                    updateFileInput();
                    console.log("📸 Snap หน้า - ส่งค่าไป updatePreviewFromSnap()");
                    updatePreviewFromSnap(dataUrl, true, file);
                }
            }
        }

        function takePictureBack() {
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photoBack = document.getElementById('photoBack');
            let context = canvas.getContext('2d');

            const width = video.videoWidth;
            const height = video.videoHeight;

            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                let dataUrl = canvas.toDataURL('image/png');

                // แสดงรูปที่ photoBack และ img-2
                photoBack.src = dataUrl;
                document.getElementById("img-2").style.backgroundImage = `url(${dataUrl})`;

                // แปลง Base64 เป็นไฟล์ UUID และ Push เข้า `#images`
                let file = base64ToUUIDFile(dataUrl);
                if (file) {
                    file.isFront = false; // **เก็บค่า isFront**
                    imageFiles.push(file);
                    updateFileInput();
                    console.log("📸 Snap หลัง - ส่งค่าไป updatePreviewFromSnap()");
                    updatePreviewFromSnap(dataUrl, false, file);
                }
            }
        }

        function clearPhotoFont() {
            let canvas = document.getElementById('canvas');
            let photoFont = document.getElementById('photoFont');
            let context = canvas.getContext('2d');

            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            photoFont.setAttribute('src', data);
        }
        function clearPhotoBack() {
            let canvas = document.getElementById('canvas');
            let photoBack = document.getElementById('photoBack');
            let context = canvas.getContext('2d');

            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            photoBack.setAttribute('src', data);
        }
        document.getElementById('switchFrontBtn').onclick = (event) => {
            switchCamera("user");
        }
        document.getElementById('snapBtnFont').onclick = (event) => {
            takePictureFont();
            event.preventDefault();
        }
        document.getElementById('snapBtnBack').onclick = (event) => {
            takePictureBack();
            event.preventDefault();
        }
        clearPhotoFont();
        clearPhotoBack();

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
            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
            document.querySelectorAll('.setcheckbox')[1].checked = true
            document.querySelectorAll('.bg_step_color')[1].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[1].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')

            $(document).ready(function() {
                $('.text-compleace-auto1').on('change', function() {
                    $('.text-compleace-auto2').val($(this).val());
                });
            });
        });

        function onchangeValueSelect2() {

            let checkvalue = checkValueSelect2();
            if (checkvalue) {
                jQuery("#submitButton").attr("disabled", false);
                jQuery("#submitButton").removeClass('cursor-not-allowed opacity-50');
            }else {
                jQuery("#submitButton").attr("disabled", true);
                jQuery("#submitButton").addClass('cursor-not-allowed opacity-50');
            }
        }


        let datass = {}
        function brandIdChange(e, params) {
            let url = "";
            let select = "";
            // $('#BARCODE').val('');

            if (params === 'BRAND') {
                url = '{{ route('product_master.product_master_get_brand_list_ajax') }}?BRAND=' + e.value;
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
                    if (data.productCodes) {
                        datass = data.productCodes
                        select.find("option").remove();
                        const newop = new Option("--- กรุณาเลือก ---", "");
                        jQuery(newop).appendTo(select)
                        data.productCodes.map((item, index) => {
                            console.log('item', item)
                            const newoption = new Option(item.Code, item.BARCODE);
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

        jQuery('#username_loading').hide();
        jQuery("#username_alert").hide();
        jQuery("#correct_username").hide();

        function onSelect(BARCODE, params) {
            let curData = datass.find(f => f.BARCODE === BARCODE.value) || {}
            console.log("🚀 ~ onSelect ~ curData:", curData)
            if (curData.BARCODE) {
                console.log('1')
                $('#NAME_THAI').val(curData.NAME_THAI);
            } else {
                $('#NAME_THAI').val('');
            }
        }

        const dlayMessage = 300;

        document.getElementById("submitButton").addEventListener("click", function() {
        // function createProductMaster() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('warehouse.store') }}",
                data: $("#mainForm").serialize(),
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(res){
                    if(res.success == true) {
                        // window.location = "/product";
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
        });

        function successMessage(text) {
            $('#loader').addClass('hidden');
            $('#name').val('')
        }
        function errorMessage(text) {
            $('#loader').addClass('hidden');
            $('#name').val('')
        }

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
                openGallery(index) {
                    console.log('📸 เปิดรูป Index:', index);
                    this.currentIndex = index;
                    this.modalVisible = true;
                    this.galleryOpen = false;
                    this.activeImageUrl = '';
                    // setTimeout(() => {
                        this.activeImageUrl = this.images[this.currentIndex];
                        this.galleryOpen = true;
                    // }, 50);
                },
                closeGallery() {
                    console.log('❌ ปิด Gallery');
                    this.galleryOpen = false;

                    setTimeout(() => {
                        this.modalVisible = false;
                        this.activeImageUrl = '';
                        this.currentIndex = null;
                    }, this.transitionDelay);
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

        function updateFileInput() {
            console.log(`📂 อัปเดต input#images: imageFiles.length = ${imageFiles.length}`);
            let dataTransfer = new DataTransfer();
            // เพิ่มเฉพาะไฟล์ที่ยังเหลืออยู่
            imageFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            // อัปเดต input#images
            document.getElementById('images').files = dataTransfer.files;
        }

        let imageFiles = []; // Store selected files here
        console.log("🚀 ~ imageFiles:", imageFiles)

        // Handle image selection and preview
        document.getElementById('images').onchange = function(event) {
            const preview = document.getElementById('preview');
            const files = Array.from(event.target.files);

            // Append selected files to imageFiles array
            files.forEach(file => {
                imageFiles.push(file);
            });
            updatePreview(); // Call function to update the preview display
        }

        // Function to update the preview display
        function updatePreview() {
            const preview = document.getElementById('preview');
            preview.innerHTML = ''; // เคลียร์ preview
            imageFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'relative w-full h-32 object-cover rounded-lg shadow-md';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-lg';

                    const closeButton = document.createElement('button');
                    closeButton.innerHTML = '&times;';
                    closeButton.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-sm';
                    
                    closeButton.onclick = function () {
                        console.log(`❌ ลบรูปที่ index ${index}`);
                        removeImageFile(index);
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(closeButton);
                    preview.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }

        // Remove image from preview and imageFiles array
        function removeImage(index) {
            imageFiles.splice(index, 1); // Remove image from array
            updateFileInput();
            updatePreview();
        }

        // Handle form submission and upload
        // document.getElementById('uploadForm').onsubmit = function(event) {
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("upload-button").addEventListener("click", function(event) {
                event.preventDefault(); // ป้องกันการรีเฟรชหน้า
                const formData = new FormData();
                console.log("🚀 ~ document.getElementById ~ formData:", formData)

                // Append files from imageFiles to the formData
                imageFiles.forEach(file => {
                    formData.append('images[]', file);
                });
                $.ajax({
                    url: '{{ route('warehouse.update_image', $data->product_id) }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loader').removeClass('hidden')
                    },
                    success: function(response) {
                        if (response.success == true) {
                            window.location.reload();
                            $('#imagePreview').html(''); // Clear after success
                            response.images.forEach(function(image) {
                                $('#imagePreview').append(`
                                    <div class="relative">
                                        <img src="${image}" class="w-full h-64 object-cover rounded-lg shadow-md" alt="Image">
                                    </div>
                                `);
                            });
                            // Clear preview after upload
                            $('#preview').html('');
                            document.getElementById('images').value = ''; // Reset the input
                            imageFiles = []; // Clear imageFiles after upload
                        } else if (response.status === 'failed') {
                            setTimeout(function() {
                                errorMessage("Can't Create Username!");
                            },dlayMessage)
                            setTimeout(function() {
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
                                toastr.error("เกิดข้อผิดพลาดในการอัปโหลด!");
                            },dlayMessage)
                        }
                    },
                    error: (params) => {
                        console.log("🚀 ~ checkLogin ~ params:", params)
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
                            toastr.error("กรุณาเลือกรูปภาพ!");
                        setTimeout(function() {
                            $('#loader').addClass('hidden');
                        },dlayMessage)
                        // errorMessage('Check Username Or Password!')
                    }
                });
            });

            // ✅ ฟังก์ชันลบรูป
            function bindDeleteButtons() {
                document.querySelectorAll(".delete-uploaded").forEach(button => {
                    button.addEventListener("click", function () {
                        let imageId = this.getAttribute("data-id");
                        let imagePath = this.getAttribute("data-path");
                        let parentDiv = this.parentElement;

                        Swal.fire({
                            title: 'Are you sure?',
                            width: 350,
                            text: "การลบรูปภาพนี้จะไม่สามารถกู้คืนได้!",
                            icon: "warning",
                            showCancelButton: true,
                            cancelButtonColor: '#e13636',
                            confirmButtonColor: '#303030',
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
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Call API ลบรูปภาพ
                                fetch("{{ route('warehouse.delete_img', ':id') }}".replace(':id', imageId), {
                                    method: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                        "Content-Type": "application/json"
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        window.location.reload();
                                        // Swal.fire("ลบสำเร็จ!", "รูปภาพถูกลบเรียบร้อยแล้ว", "success");
                                        // parentDiv.remove(); // ลบออกจากหน้าเว็บ
                                    } else {
                                        Swal.fire("เกิดข้อผิดพลาด!", data.message, "error");
                                    }
                                })
                                .catch(error => {
                                    // Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถลบรูปภาพได้", "error");
                                    Swal.fire({
                                    title: 'เกิดข้อผิดพลาด?',
                                    width: 350,
                                    text: "ไม่สามารถลบรูปภาพได้!",
                                    icon: "error",
                                    color: "#ffffff",
                                    background: "#202020",
                                })
                                    console.error("Delete Error:", error);
                                });
                            }
                        });
                    });
                });
            }
            // ✅ เรียกใช้งาน bindDeleteButtons() ทันทีเมื่อโหลดหน้าเว็บ
            bindDeleteButtons();
        });

        document.addEventListener("DOMContentLoaded", function () {
            let sortable = new Sortable(document.getElementById("img-drop"), {
                animation: 150,
                onEnd: function (evt) {
                    let img = [];
                    document.querySelectorAll("#img-drop .img-item").forEach((item, index) => {
                        img[index] = item.getAttribute('data-id');
                    });

                    $('.image_sequence_loading').removeClass('hidden');

                    fetch('{{ route('warehouse.update_image_sequence') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ img })
                    }).then(response => response.json())
                    .then(data => {
                        console.log("Updated:", data);
                        $('.image_sequence_loading').addClass('hidden');
                        $('#messageSuccess').removeClass('active');
                        setTimeout(function() {
                            $('#messageSuccess').addClass('active');
                        }, 3000);
                    });
                }
            });
        });
        
        // const dlayMessage = 500;
        jQuery(document).ready(function () {
            ImgUpload();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });

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
