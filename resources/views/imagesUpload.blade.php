@extends('layouts.layout')
@section('title', '')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        html * {
        box-sizing: border-box;
    }
    p {
        margin: 0;
    }
    .upload__box {
        padding: 0 40px 0 40px;
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
        margin-bottom: 20px;
    }
    .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
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

    /* ************************************************************************************************* */

    *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* html,body{
        display: grid;
        height: 100%;
        place-items: center;
        background: #efefef;
        } */
        .copyright{
            font-size: 150%;
        }
        .camera-center {
            display: flex;
            justify-content: center;
        }
        .img-center {
            display: flex;
            justify-content: center;
            height: 90%;
            width: 100%;
        }
        .wrapper{
            position: relative;
            height: 50%;
            width: 68%;
            overflow: hidden;
            background: #fff;
            border: 7px solid #fff;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.15);
            /* left: 215px; */
        }
        .wrapper .images{
            height: 100%;
            width: 100%;
            display: flex;
        }
        .wrapper .images .img-1{
            height: 100%;
            width: 100%;
            /* background-image: url(https://render.fineartamerica.com/images/rendered/default/greeting-card/images/artworkimages/medium/3/black-sports-car-on-carbon-fiber-background-gualtiero-boffi.jpg?&targetx=-112&targety=0&imagewidth=924&imageheight=500&modelwidth=700&modelheight=500&backgroundcolor=41454A&orientation=0); */
            background: url(https://www.orientalprincess.com/pub/media/wysiwyg/block-img-m2/beneficial/Getthelook-Website-04.jpg) no-repeat;
            /* background-size: cover; */
        }
        .wrapper .images .img-2{
            position: absolute;
            height: 100%;
            width: 100%;
            /* filter: blur(5px); */
            /* background-image: url(https://media-cdn-v2.laodong.vn/Storage/NewsPortal/2019/6/10/738354/595097.jpg); */
            background: url(https://www.orientalprincess.com/pub/media/wysiwyg/block-img-m2/beneficial/Getthelook-Website-05.jpg) no-repeat;
            /* background-size: cover; */
        }
        .wrapper .slider{
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 99;
        }
        .wrapper .slider input{
            width: 100%;
            outline: none;
            background: none;
            -webkit-appearance: none;
        }
        .slider input::-webkit-slider-thumb{
            height: 486px;
            width: 3px;
            background: none;
            -webkit-appearance: none;
            cursor: col-resize;
        }
        .slider .drag-line{
            width: 3px;
            height: 486px;
            position: absolute;
            left: 49.85%;
            pointer-events: none;
        }
        .slider .drag-line::before,
        .slider .drag-line::after{
            position: absolute;
            content: "";
            width: 100%;
            height: 222px;
            background: #fff;
        }
        .slider .drag-line::before{
            top: 0;
        }
        .slider .drag-line::after{
            bottom: 0;
        }
        .slider .drag-line span{
            height: 42px;
            width: 42px;
            border: 3px solid #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        .slider .drag-line span::before,
        .slider .drag-line span::after{
            position: absolute;
            content: "";
            top: 50%;
            border: 10px solid transparent;
            border-bottom-width: 0px;
            border-right-width: 0px;
            transform: translate(-50%, -50%) rotate(45deg);
        }
        .slider .drag-line span::before{
            left: 40%;
            border-left-color: #fff;
        }
        .slider .drag-line span::after{
            left: 60%;
            border-top-color: #fff;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="mt-5 mb-3 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Upload Images</p>
    </div>
    <div class="justify-center items-center duration-500 p-4" style="position: relative;">
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="upload__box mt-5">
                <div class="upload__btn-box">
                    <label class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded">
                        <input type="file" name="images[]" id="images" multiple class="">
                    </label>
                </div>
                <div id="preview" class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                        <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                        <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex justify-center items-center mt-10 mb-10">
                    <a href="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>
                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">Upload Images</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-5 mb-3 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Preview Images</p>
    </div>

    <div class="p-10">
        <h1 class="mb-8 font-extrabold text-4xl">Register</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <aside class="">
                <div class="bg-gray-100 p-8 rounded">
                    <h2 class="font-bold text-2xl">Instructions</h2>
                    {{-- <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full"> --}}
                        <div class="camera-center mt-5">
                            <div class="panel">
                                <button id="switchFrontBtn" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                    เปิดกล้อง
                                </button>
                            </div>
                            <div class="flex justify-items-center">
                                <video id="cam" autoplay muted playsinline>Not available</video>
                                <canvas id="canvas" style="display:none"></canvas>
                            </div>
                        </div>
                        <div class="p-2 grid mt-5 mb-20 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                            <div class="lg:col-span-4">
                                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6 mb-5">
                                    <div class="md:col-span-3" style="position: relative;">
                                        <div class="panel">
                                            <button id="snapBtnFont" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">Snap หน้า</button>
                                        </div>
                                        <div style="width:100%">
                                            <img id="photoFont" alt="The screen capture will appear in this box.">
                                        </div>
                                    </div>
                                    <div class="md:col-span-3" style="position: relative;">
                                        <div class="panel">
                                            <button id="snapBtnBack" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">Snap หลัง</button>
                                        </div>
                                        <div style="width:100%">
                                            <img id="photoBack" alt="The screen capture will appear in this box.">
                                        </div>
                                    </div>

                                </div>
                                <div class="p-2 mb-5">
                                    <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-500"></ul>
                                </div>

                                {{-- <div id="" class="bg-[#d7d8db] dark:bg-[#303030] p-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> --}}
                                    <div class="img-center mb-56">
                                        <div class="wrapper">
                                            <div class="images">
                                                <div id="img-1" class="img-1"></div>
                                                <div id="img-2" class="img-2"></div>
                                            </div>
                                            <div class="slider">
                                                <div class="drag-line">
                                                    <span></span>
                                                </div>
                                                <input type="range" min="0" max="100" value="50">
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}

                                {{-- <div class="img-center mb-96">
                                    <div class="wrapper">
                                        <div class="images">
                                            <div id="img-1" class="img-1"></div>
                                            <div id="img-2" class="img-2"></div>
                                        </div>
                                        <div class="slider">
                                            <div class="drag-line">
                                                <span></span>
                                            </div>
                                            <input type="range" min="0" max="100" value="50">
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
            </aside>

            <form>
                <div>
                    <label class="block font-semibold" for="name">Name</label>
                    <input class="w-full shadow-inner bg-gray-100 rounded-lg placeholder-black text-2xl p-4 border-none block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus">
                </div>

                <div class="mt-4">
                    <label class="block font-semibold" for="email">Email</label>
                    <input class="w-full shadow-inner bg-gray-100 rounded-lg placeholder-black text-2xl p-4 border-none block mt-1 w-full" id="email" type="email" name="email" required="required">
                </div>

                <div class="mt-4">
                    <label class="block font-semibold" for="password">Password</label>
                    <input class="w-full shadow-inner bg-gray-100 rounded-lg placeholder-black text-2xl p-4 border-none block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="new-password">
                </div>

                <div class="flex items-center justify-between mt-8">
                    <button type="submit" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">Register</button>
                    <a class="font-semibold">
                        Already registered?
                    </a>
                </div>
            </form>
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
                                            รายละเอียด1
                                        </h1>
                                    </div>
                                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-full">
                                        <section x-data="gallery()" x-init="initGallery()"
                                            @keyup.right.window="nextImage()"
                                            @keyup.left.window="prevImage()"
                                            @keydown.escape.window="closeGallery()"
                                            class="select-none">

                                            <div x-ref="gallery" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-[#d7d8db] dark:bg-[#303030] p-4">
                                                @foreach($images as $index => $image)
                                                    <div class="relative group">
                                                        <img
                                                            src="{{ asset($image->path) }}"
                                                            class="h-auto max-w-full cursor-pointer rounded shadow-md"
                                                            @click="openGallery({{ $index }})"
                                                            alt="Uploaded Image"
                                                        >
                                                        <div class="after_upload_upload__img_close delete-uploaded"
                                                            data-id="{{ $image->id }}"
                                                            data-path="{{ asset($image->path) }}">
                                                            ✖
                                                        </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
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

        // Image comparison
        // const slider = document.querySelector(".slider input");
        // const img = document.querySelector(".images .img-2");
        // const dragLine = document.querySelector(".slider .drag-line");
        // slider.oninput = ()=> {
        //     let sliderVal = slider.value;
        //     dragLine.style.left = sliderVal + "%";
        //     img.style.width = sliderVal + "%";
        // }
        // End Image comparison

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
        function takePictureFont() {
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photoFont = document.getElementById('photoFont');
            let context = canvas.getContext('2d');

            const height = video.videoHeight;
            const width = video.videoWidth;

            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                photoFont.setAttribute('src', data);
                document.getElementById("img-1").style.backgroundImage = `url(${data})`;
            } else {
                clearphotoFont();
            }
        }
        function takePictureBack() {
            let canvas = document.getElementById('canvas');
            let video = document.getElementById('cam');
            let photoBack = document.getElementById('photoBack');
            let context = canvas.getContext('2d');

            const height = video.videoHeight;
            const width = video.videoWidth;

            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);
                var data = canvas.toDataURL('image/png');
                photoBack.setAttribute('src', data);
                document.getElementById("img-2").style.backgroundImage = `url(${data})`;
            } else {
                clearphotoBack();
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
            document.querySelectorAll('.setcheckbox').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    let el_colr = document.querySelectorAll('.bg_step_color')[index]
                    console.log("🚀 ~ el.checked:", el.checked)
                    BARCODE = jQuery("#BARCODE").val()
                    console.log("🚀 ~ BARCODE:", BARCODE)
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
        });

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
            preview.innerHTML = ''; // Clear previous preview

            imageFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'relative w-full h-64 object-cover rounded-lg shadow-md';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-lg';

                    const closeButton = document.createElement('button');
                    closeButton.innerHTML = '&times;';
                    closeButton.className = 'absolute top-2 right-2 bg-red-500 text-white rounded-full px-2 py-1 text-sm';
                    closeButton.onclick = function() {
                        removeImage(index); // Call the remove image function when clicked
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(closeButton);
                    preview.appendChild(imgContainer);
                }
                reader.readAsDataURL(file);
            });
        }

        // Remove image from preview and imageFiles array
        function removeImage(index) {
            imageFiles.splice(index, 1); // Remove image from array
            updatePreview(); // Update the preview to reflect the change
        }

        // Handle form submission and upload
        document.getElementById('uploadForm').onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData();
            console.log("🚀 ~ document.getElementById ~ formData:", formData)

            // Append files from imageFiles to the formData
            imageFiles.forEach(file => {
                formData.append('images[]', file);
            });
            $.ajax({
                url: '{{ route('images.store') }}',
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
                            toastr.error("กรุณาเลือกรูปภาพ !");
                        },dlayMessage)
                    }
                },
                error: (params) => {
                console.log("🚀 ~ checkLogin ~ params:", params)

                toastr.error("Please select image!");
                // errorMessage('Check Username Or Password!')
            }
            });
        }
        const dlayMessage = 500;
        jQuery(document).ready(function () {
            ImgUpload();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });

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

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-uploaded").forEach(button => {
                button.addEventListener("click", function() {
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
                            fetch(`/delete-image/${imageId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire("ลบสำเร็จ!", "รูปภาพถูกลบเรียบร้อยแล้ว", "success");
                                    parentDiv.remove(); // ลบออกจากหน้าเว็บ
                                } else {
                                    Swal.fire("เกิดข้อผิดพลาด!", data.message, "error");
                                }
                            })
                            .catch(error => {
                                Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถลบรูปภาพได้", "error");
                            });
                        }
                    });
                });
            });
        });

    </script>
@endsection
