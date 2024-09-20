
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .lds-dual-ring:after {
            content: " ";
            position: absolute;
            width: calc(1.5vw + 5vh);
            height: calc(1.5vw + 5vh);
            font-size: 1vw;
            border-radius: 50%;
            border: 6px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }
        .overlay.hidden {
            visibility: hidden;
            opacity: 0;
            transition: all 0.5s ease-in;
        }
        .lds-dual-ring {
            visibility: visible;
            opacity: 1;
            align-items: center;
            background-color: black;
            transition: all 0.1s ease-in;
            margin: 0 auto;
            position: absolute;
            left: 30%;
            top: 1.5rem;
        }
        @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }
        .overlay {
            position: fixed;
            display: flex;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: #303030;
            z-index: 999;
            opacity: 1;
            transition: all 0.5s;
        }
        .imgContainer {
            position: relative;
        }
        .loading {
            margin: auto;
            padding-top: calc((1.5vw + 5vh) + 3rem);
            color: #fff;
            font-size: calc(1vw + 1.5vh);
            position: relative;
        }
        .loading span{
            /* font-size: calc(1vw + 1.5vh); */
            font-family: "Times New Roman", Times, serif;
        }
        .l {
            position: fixed;
            font-size: 18px;
            top: 38%;
            left: 47.3%;
            color: #fff;
        }
        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        @keyframes blink {50% { color: transparent }}
        .loading__dot { animation: 2s blink infinite }
        .loading__dot:nth-child(2) { animation-delay: 250ms }
        .loading__dot:nth-child(3) { animation-delay: 500ms }

        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
        .select2 {
            width: 100%!important; /* force fluid responsive */
        }
        .loading_load {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: rgb(55 53 53 / 80%); */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <div id="slide" class="loaderslide"></div>
    <!-- <div class="min-h-screen p-10" style="background-image: url('https://www.pixelstalk.net/wp-content/uploads/2016/07/1080p-Full-HD-Images-For-Desktop.jpg')"> -->
    <!-- <div class="min-h-screen p-10" style="background-image: url('https://www.ssup.co.th/wp-content/uploads/2024/04/new-member-april.jpg')"> -->
        <!-- <div class="min-h-screen p-10" style="background-image: url('https://www.orientalprincess.com/pub/media/wysiwyg/block-img-m2/beneficial/Getthelook-Website-04.jpg')"> -->
            <!-- <div class="min-h-screen p-10" style="background-image: url('https://www.orientalprincess.com/pub/media/wysiwyg/block-img-m2/beneficial/colors-hero-banner.jpg')"> -->
        <div class="min-h-screen p-10" style="background-image: url('https://www.ssup.co.th/wp-content/uploads/2022/11/shutterstock_2079577573.png')">
        <div class="g-2 flex flex-wrap items-center justify-center lg:justify-between">
            <div class="mb-12 grow-0 basis-auto md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12 xl:ml-12">
                <!-- <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                    <form class="group js-validation-signin max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-32" action="javascript:void(0)" method="POST" novalidate>
                        <div class="flex flex-row items-center justify-center lg:justify-start">
                            <div class="flex text-center">
                                <p class="mb-0 me-4 mt-4 text-lg">Sign in with</p>
                            </div>
                        </div>

                        <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-black dark:before:border-blue-500 after:mt-0.5 after:flex-1 after:border-t after:border-black dark:after:border-blue-500">
                            <p class="mx-4 mb-0 text-center font-semibold dark:text-white">
                            Or
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-start space-y-4">
                            <h1 class="text-xl font-medium text-gray-800">Log in to your account</h1>

                            <div class="flex w-full flex-col items-start ">
                                <label for="email" class="block text-sm font-normal text-black dark:text-white">Username</label>
                                <input type="text" id="username" name="username" class="peer block w-full rounded-sm border-black dark:border-gray-100 p-2.5 text-sm text-gray-900 placeholder:text-xs placeholder:font-light placeholder:text-gray-400 focus:border-none focus:outline-none focus:ring-1 focus:ring-sky-500 invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500" placeholder="Username" required pattern="^([A-Z][A-Za-z ,.'`-]{3,30})$" />
                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Please enter a valid username </span>
                            </div>

                            <div class="flex w-full flex-col items-start ">
                                <label for="password" class="block text-sm font-normal text-black dark:text-white">Password</label>
                                <input type="password" id="password" name="password" class="peer block w-full rounded-sm border-black dark:border-gray-100 p-2.5 text-sm text-gray-900 placeholder:text-xs placeholder:font-light placeholder:text-gray-400 focus:border-none focus:outline-none focus:ring-1 focus:ring-sky-500 invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500" placeholder="*********" required pattern=".{7,}" />
                                <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Please enter a valid password</span>
                            </div>

                            <div class="flex w-full">
                                <button 
                                    onClick="checkLogin()"
                                    type="submit"
                                    class="w-full cursor-pointer rounded bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-blue-300 group-invalid:pointer-events-none group-invalid:opacity-60">
                                    Submit
                                </button>
                            </div>
                            <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased text-black dark:text-white">
                                Already have an account?
                                    <a href="{{ route('register') }}" class="cursor-pointer inline-block space-y-2 border-b border-black dark:border-blue-500">
                                        Create an account
                                    </a>
                            </p>
                            <span class="mt-4 block font-sans text-xs font-bold text-center text-black dark:text-white">
                                PRODUCT MASTER (V 1.04.0 © 2024)
                            </span>
                        </div>
                    </form>
                </div> -->
                
            </div>

            <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                <form id="from_user" class="group js-validation-signin max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-24" action="javascript:void(0)" method="POST">
                    <div class="relative flex flex-row items-center justify-center lg:justify-start">
                        <div class="flex text-center">
                            <p class="mb-0 me-4 text-lg -mt-2 font-semibold">Sign in with</p>
                        </div>
                        <!-- Github -->
                        <button
                            type="button"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            class="justify-items-center mr-2 mb-2 inline-block rounded bg-[#333] px-6 py-2 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
                            <span class="[&>svg]:h-5 [&>svg]:w-5 grid justify-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 496 512">
                                    <path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z" />
                                </svg>
                            </span>
                            <p>Github</p>
                        </button>
                        <!-- Google -->
                        <button
                            type="button"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            class="mb-2 inline-block rounded bg-[#333] px-6 py-2 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
                            <span class="[&>svg]:h-5 [&>svg]:w-5 grid justify-items-center">
                                <svg  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 488 512">
                                    <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                                </svg>
                            </span>
                            <p>Google</p>
                        </button>
                    </div>

                    <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-black dark:before:border-blue-500 after:mt-0.5 after:flex-1 after:border-t after:border-black dark:after:border-blue-500">
                        <p class="mx-4 mb-0 text-center font-semibold dark:text-white">
                        Or
                        </p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex w-full flex-col items-start ">
                            <label for="" class="block text-sm font-normal text-black dark:text-white">Username</label>
                            <input type="text" id="username" name="username" class="peer block w-full rounded-sm border-black dark:border-gray-100 p-2.5 text-xs text-gray-900  placeholder:text-xs placeholder:font-light placeholder:text-gray-400 focus:border-none focus:outline-none focus:ring-1 focus:ring-sky-500 invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500" placeholder="Username" required pattern="^([A-Z][A-Za-z ,.'`-]{3,30})$" />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Please enter a valid username </span>
                        </div>
                        
                        <div class="flex w-full flex-col items-start ">
                            <label for="password" class="block text-sm font-normal text-black dark:text-white">Password</label>
                            <!-- <input type="password" id="password" name="password" class="peer block w-full rounded-sm border-black dark:border-gray-100 p-2.5 text-xs text-gray-900 placeholder:text-xs placeholder:font-light placeholder:text-gray-400 focus:border-none focus:outline-none focus:ring-1 focus:ring-sky-500 invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500" placeholder="*********" required pattern=".{4,}" /> -->
                            <input type="password" id="password" name="password" class="peer block w-full rounded-sm border-black dark:border-gray-100 p-2.5 text-xs text-gray-900 placeholder:text-xs placeholder:font-light placeholder:text-gray-400 focus:border-none focus:outline-none focus:ring-1 focus:ring-sky-500 invalid:[&:not(:placeholder-shown):not(:focus)]:border-red-500" placeholder="*********" pattern=".{4,}" />
                            <span class="mt-2 hidden text-sm text-red-500 peer-[&:not(:placeholder-shown):not(:focus):invalid]:block">Please enter a valid password</span>
                        </div>
                    </div>

                    <div class="inline-flex items-center">
                        <label
                            class="relative -ml-2.5 flex cursor-pointer items-center rounded-full p-3"
                            htmlFor="checkbox"
                            data-ripple-dark="true"
                        >
                        </label>
                        <label class="mt-px cursor-pointer select-none font-light" htmlFor="checkbox">
                            <p class="flex items-center font-sans text-sm font-normal leading-normal antialiased">
                                <!-- I agree the -->
                                <Link class="font-medium transition-colors hover:text-blue-500" href="#" >
                                    <!-- &nbsp;Terms and Conditions -->
                                </Link>
                            </p>
                        </label>
                    </div>
                    
                    <!-- <div id="loader" class="loading_load absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div> -->

                    <div class="flex w-full">
                        <button 
                            onClick="checkLogin()"
                            type="submit"
                            class="w-full cursor-pointer rounded bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-blue-300 group-invalid:pointer-events-none group-invalid:opacity-60">
                            Login
                        </button>
                        <!-- class="w-full cursor-pointer rounded bg-primary-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-blue-300 group-invalid:pointer-events-none group-invalid:opacity-60"> -->
                    </div>
                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                            <a href="{{ route('register') }}" class="cursor-pointer inline-block space-y-2 border-b border-black dark:border-blue-500">
                                Create an account
                            </a>
                    </p>
                    <span class="mt-4 block font-sans text-xs font-bold text-center">
                        PRODUCT MASTER (V 1.04.0 © 2024)
                    </span>
                    
                </form>
            </div>

            <!-- <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                <form id="from_user" class="js-validation-signin max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-32" action="javascript:void(0)" method="POST">
                    <div class="flex flex-row items-center justify-center lg:justify-start">
                        <div class="flex text-center">
                            <p class="mb-0 me-4 mt-4 text-lg">Sign in with</p>
                             <button class="flex items-center bg-white dark:bg-[#303030] border border-gray-300 rounded-lg shadow-md px-6 py-5 text-sm font-medium text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <img src="https://www.ssup.co.th/wp-content/uploads/2022/11/site-logo-g.png" width="65px" height="65px">
                            </button>
                            <button class="flex items-center mr-2 bg-white dark:bg-[#303030] border border-gray-300 rounded-lg shadow-md px-6 py-2 text-sm font-medium text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <img src="https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png" alt="social icon" width="35px" height="35px">
                                <span>
                                    Github
                                </span>
                            </button>
                            <button class="flex items-center mr-2 bg-white dark:bg-[#303030] border border-gray-300 rounded-lg shadow-md px-6 py-2 text-sm font-medium text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg class="h-12 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="-0.5 0 48 48" version="1.1"> <title>Google-color</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Color-" transform="translate(-401.000000, -860.000000)"> <g id="Google" transform="translate(401.000000, 860.000000)"> <path d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24" id="Fill-1" fill="#FBBC05"> </path> <path d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333" id="Fill-2" fill="#EB4335"> </path> <path d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667" id="Fill-3" fill="#34A853"> </path> <path d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24" id="Fill-4" fill="#4285F4"> </path> </g> </g> </g> </svg>
                                <span>
                                    Google
                                </span>
                            </button> 
                        </div>
                    </div>

                    <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-black dark:before:border-blue-500 after:mt-0.5 after:flex-1 after:border-t after:border-black dark:after:border-blue-500">
                        <p class="mx-4 mb-0 text-center font-semibold dark:text-white">
                        Or
                        </p>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="relative float-label-input mt-0">
                            <input type="text" id="username" name="username" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Username
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <input type="password" id="password" name="password" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Password
                            </label>
                        </div>
                    </div>

                    <div class="inline-flex items-center">
                        <label
                            class="relative -ml-2.5 flex cursor-pointer items-center rounded-full p-3"
                            htmlFor="checkbox"
                            data-ripple-dark="true"
                        >
                        </label>
                        <label class="mt-px cursor-pointer select-none font-light" htmlFor="checkbox">
                            <p class="flex items-center font-sans text-sm font-normal leading-normal antialiased">
                                I agree the
                                <Link class="font-medium transition-colors hover:text-blue-500" href="#" >
                                    &nbsp;Terms and Conditions
                                </Link>
                            </p>
                        </label>
                    </div>

                    <a class="mb-3 flex w-full items-center justify-center rounded bg-primary px-7 pb-2.5 pt-3 text-center text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong group"
                        style="background-color: #3b5998"
                        onClick="checkLogin()"
                        type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                            </span>
                            Login
                    </a>

                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                            <a href="{{ route('register') }}" class="cursor-pointer inline-block space-y-2 border-b border-black dark:border-blue-500">
                                Create an account
                            </a>
                    </p>
                    <span class="mt-4 block font-sans text-xs font-bold text-center">
                        PRODUCT MASTER (V 1.04.0 © 2024)
                    </span>
                </form>
            </div> -->
        </div>
        <!-- <div class="relative w-[350px] overflow-hidden">
            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
            <div class="bg-gray-600 text-white h-12 w-full pl-5 flex items-center">
                <h1 class="text-white text-lg">
                    What is tailwindcss
                </h1>
            </div>
            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="bg-white overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40">
                <div class="p-4">
                    For example
                    You enter the room you will see three row of the table,
                    I shit recentre under the air conditionner just like you.
                </div>
            </div>
        </div>   -->
        <div class="imgContainer">
            <div id="loader" class="overlay hidden">
                <div class="loading">
                    LOADING
                    <span class="loading__dot">.</span>
                    <span class="loading__dot">.</span>
                    <span class="loading__dot">.</span>
                    <div class="lds-dual-ring "></div>
                </div>
                 <!-- <img src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/02b374101705095.5f24d5db1096f.gif" alt="" style="width: 100%;">  -->
            </div>
        </div>

    </div>
</body>


<!-- <script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

<script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

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

    function checkLogin() {
        let dataForm = $(".js-validation-signin").serialize();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            // type: "GET",
            type: "POST",
            // url: "/api/api_apps_login",
            // url: "/api_bypass_login",
            url: "/api_bypass_login_user",
            // url: "/checkLogin",
            data: dataForm,
            beforeSend: function () {
                $('#loader').removeClass('hidden')
            },
            success: (res) => {
                sessionStorage.setItem("first_login", "Y")
                sessionStorage.setItem("credetail", JSON.stringify(res.response))
                if(res.status == 'success') {
                    // window.location.replace('/product')
                    window.location = res.route
                } else if (res.status == 'fail') {
                    errorMessage('Check Username Or Password!')
                }
            },
            error: (params) => {
                console.log("🚀 ~ checkLogin ~ params:", params)

                errorMessage('Check Username Or Password!')
            }
        });
    }
    function errorMessage(text) {
        console.log("🚀 ~ errorMessage ~ text:", text)
        $('#loader').addClass('hidden');
        $('#username').val('')
        $('#password').val('')
        toastr.error("Check Username Or Password!");
    }

    $(document).ready(function() {
        $("#from_user").validate({
            rules: {
                username: "required"
            },
            messages: {
                username: "กรุณากรอกชื่อผู้ใช้งาน"
            },
        });
    });
</script>
</html>