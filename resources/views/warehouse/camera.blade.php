





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

        #photoFont {
            width: 100%;
        }
        #photoBack {
            width: 100%;
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

@section('content')
    <div class="p-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Test Camera</p>
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
                                            <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
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
                                                    <div class="img-center mb-96">
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
                                                    {{-- <div class="p-2 mt-5">
                                                        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-500"></ul>
                                                    </div>
                                                    <div>
                                                        <button id="" type="button" class="text-gray-100 bg-[#202020] hover:bg-[#303030] font-bold py-1.5 px-4 mr-2 rounded group">
                                                            เปิดกล้อง
                                                        </button>
                                                    </div> --}}
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
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script>

        // Image comparison
        const slider = document.querySelector(".slider input");
        const img = document.querySelector(".images .img-2");
        const dragLine = document.querySelector(".slider .drag-line");
        slider.oninput = ()=> {
            let sliderVal = slider.value;
            dragLine.style.left = sliderVal + "%";
            img.style.width = sliderVal + "%";
        }

        const add_element = () => {
            const template = document.createElement('div');
            template.classList.add("loaderslide");
            template.setAttribute("id","slide");
            document.body.appendChild(template);
        }

        if (sessionStorage.getItem("first_login") === 'Y') {
            sessionStorage.setItem("first_login", "yes")
            $("#slide").addClass("loaderslide");
        } else {
            $("#slide").remove();
        }
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

    </script>
@endsection