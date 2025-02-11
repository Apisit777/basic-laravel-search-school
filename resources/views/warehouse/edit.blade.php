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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

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
                                                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                                                
                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <div class="panel">
                                                                        <button id="switchFrontBtn" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                                                            เปิดกล้อง
                                                                        </button>
                                                                    </div>
                                                                    <div class=" justify-items-center">
                                                                        <video id="cam" autoplay muted playsinline>Not available</video>
                                                                        <canvas id="canvas" style="display:none"></canvas>
                                                                    </div>
                                                                </div>

                                                                <div class="md:col-span-3" style="position: relative;">
                                                                    <div class="panel">
                                                                        <button id="snapBtn" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                                                            ถ่ายรูป
                                                                        </button>
                                                                    </div>
                                                                    <div style="width:100%">
                                                                        <img id="photo" alt="The screen capture will appear in this box.">  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
                                                                <p class="inline-block space-y-2 border-b-2 border-gray-300 dark:border-gray-500 text-xl font-bold text-gray-900 dark:text-gray-100">รายละเอียดสินค้า(Case KM)</p>
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
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">พื้นที่</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลูกบาศก์เซนติเมตร</label>

                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้นต่อลัง</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ชิ้น</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลังต่อพาเลท</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">ลัง</label>
                                                                        <label class="m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">น้ำหนัก</label>
                                                                        <input value="" id="" type="number" class="col-span-1 m-0 p-0 dark:text-white rounded-sm dark:bg-[#303030] text-center focus:border-blue-500" />
                                                                        <label class="col-span-1 m-0 p-0 dark:text-white rounded-sm text-sm text-center grid content-center justify-items-start">กรัม</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="p-2 ">
                                                                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-300 dark:border-gray-500"></ul>
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
                                <button id="submitButton" type="button" class="bg-[#3b5998] text-white font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50" onclick="createProductMaster()" disabled>
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

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>

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
        function takePicture() {  
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photo = document.getElementById('photo');  
            let context = canvas.getContext('2d');
            
            const height = video.videoHeight;
            const width = video.videoWidth;
            
            if (width && height) {    
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);    
                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
            } else {
                clearphoto();
            }
        }
        function clearPhoto() {
            let canvas = document.getElementById('canvas');
            let photo = document.getElementById('photo');
            let context = canvas.getContext('2d');
            
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }
        document.getElementById('switchFrontBtn').onclick = (event) => {
            switchCamera("user");
        }
        document.getElementById('snapBtn').onclick = (event) => {  
            takePicture();
            event.preventDefault();
        }
        clearPhoto();

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

        const dlayMessage = 1000;
        function createProductMaster() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('warehouse.store') }}",
                data: $("#create_warehouse_dimension").serialize(),
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
