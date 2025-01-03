
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

        .loading_ {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: rgb(55 53 53 / 80%); */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading_z {
            /* z-index: 1000000; */
        }
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
    </style>
</head>

<body>
    <div id="slide" class="loaderslide"></div>
    
    <div class="min-h-screen p-10" style="background-image: url('https://www.ssup.co.th/wp-content/uploads/2022/11/shutterstock_2079577573.png')">
        <div class="g-2 flex flex-wrap items-center justify-center lg:justify-between">
            <div class="mb-12 grow-0 basis-auto md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12 xl:ml-12">
            </div>
            <!-- <div class="mt-24 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12 relative">
                <form class="max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500" action="{{ route('register')}}" method="POST" id="register">
                    <div class="flex flex-row items-center justify-center lg:justify-start">
                        <div class="flex text-center">
                            <p class="mb-0 me-4 mt-4 text-lg">Sign in with</p>
                            <button class="flex items-center bg-white dark:bg-[#303030] border border-gray-300 rounded-lg shadow-md px-6 py-5 text-sm font-medium text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <img src="https://www.ssup.co.th/wp-content/uploads/2022/11/site-logo-g.png" width="65px" height="65px">
                            </button>
                        </div>
                    </div>

                    <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-black dark:before:border-blue-500 after:mt-0.5 after:flex-1 after:border-t after:border-black dark:after:border-blue-500">
                        <p class="mx-4 mb-0 text-center font-semibold dark:text-white">
                        Or
                        </p>
                    </div>
                    <div class="flex flex-col gap-0">
                        <div class="relative float-label-input mt-0">
                            <input type="text" id="name" name="name" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Name
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <input type="email" id="email" name="email" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Email
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <input type="password" id="password" name="password" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Password
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <select class="js-example-basic-single w-full bg-white dark:bg-[#2020] rounded-sm text-xs" name="state">
                                <option value=""> --- กรุณาเลือก ---</option>
                                @foreach ($list_position as $key => $list_positions)
                                    <option value={{ $list_positions->id }}>{{ $list_positions->name_position }}</option>
                                @endforeach
                            </select>
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

                    <div id="loader" class="loading absolute !hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin loading_z">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <a class="mb-3 flex w-full items-center justify-center rounded bg-primary px-7 pb-2.5 pt-3 text-center text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        style="background-color: #3b5998"
                        href="#!" role="button"
                        data-twe-ripple-init=""
                        data-twe-ripple-color="light"
                        onclick="register()">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                        </svg>
                        </span>
                        Register
                    </a>
                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                            <a href="{{ route('login') }}" class="cursor-pointer inline-block space-y-2 border-b border-black dark:border-blue-500">
                                Sigh In
                            </a>
                    </p>
                    <span class="mt-4 block font-sans text-xs font-bold text-center">
                    PRODUCT MASTER (V 1.04.0 © 2024)
                    </span>
                </form>
            </div> -->

            <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                <div class="relative max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-24">
                    <form id="from_user" class="group js-validation-signin" action="javascript:void(0)" method="POST">
                        <div class="flex flex-row items-center justify-center lg:justify-start">
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
    
                        <div class="flex w-full">
                            <button 
                                onClick="checkLogin()"
                                type="submit"
                                class="w-full cursor-pointer rounded bg-primary-600 px-5 py-1 text-center text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-blue-300 group-invalid:pointer-events-none group-invalid:opacity-60">
                                <svg fill="currentColor" class="mr-1 mt-1 hidden h-6 w-6 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    viewBox="0 0 187.338 187.338"
                                    xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M125.393,95.594c-1.629-1.183-4.344,0.387-4.153,2.383c0.652,6.86,1.787,13.168,1.565,20.185
                                                c-0.251,7.964-1.063,15.911-1.226,23.877c-14.855,0.447-29.671-0.884-44.524-0.893c0.548-32.136,0.552-64.361,0.547-96.382
                                                c0-2.468-2.462-3.305-4.204-2.567c-0.007-0.009-0.009-0.019-0.016-0.028c-6.534-8.158-20.93-12.415-30.032-17.155
                                                C33.066,19.658,23.02,13.634,14.366,5.905c15.627,1.086,31.122,3.332,46.744,4.475c20.147,1.476,40.181-2.192,60.287,0.449
                                                c0.518,6.438,0.365,12.828-0.014,19.278c-0.349,5.936-1.441,12.691,0.889,18.304c1.24,2.988,5.073,2.447,5.488-0.743
                                                c0.849-6.529,0.191-13.542,0.533-20.172c0.301-5.837,0.205-11.53-1.437-17.124c1.855-1.582,2.002-4.969-1.022-5.523
                                                c-17.917-3.283-36.129-1.422-54.217-1.02C50.938,4.288,30.471-1.66,9.832,0.759C9.667,0.778,9.545,0.849,9.398,0.89
                                                C8.471-0.162,6.583-0.124,5.871,1.638c-9.284,23.017-5.076,49.963-3.882,74.09c1.189,24.004-2.432,48.698,3.473,72.267
                                                c0.334,1.331,1.294,1.836,2.277,1.791c16.22,17.971,41.909,25.269,62.465,36.951c1.38,0.784,2.673,0.392,3.536-0.462
                                                c1.089,0.029,2.159-0.679,2.215-2.184c0.469-12.607,0.787-25.254,1.027-37.913c15.939,2.026,31.894,3.255,47.981,2.666
                                                c1.931-0.071,3.39-1.52,3.453-3.454c0.336-9.966,1.327-19.894,1.514-29.866C130.046,109.53,130.9,99.59,125.393,95.594z
                                                M34.15,26.722c11.063,6.375,24.699,15.941,36.992,19.295c0.197,0.054,0.373,0.051,0.553,0.061
                                                c-0.014,1.85-0.069,3.715-0.113,5.575c-7.436-7.919-18.397-13.08-27.733-18.077C31.759,27.104,19.698,21.24,8.643,13.029
                                                c0.195-1.863,0.379-3.724,0.635-5.595C15.703,15.826,24.955,21.424,34.15,26.722z M7.324,51.238
                                                c21.446,9.495,42.479,19.029,61.443,33.057c0.655,0.485,1.36,0.408,1.942,0.066c-0.11,3.016-0.222,6.032-0.333,9.051
                                                C49.454,81.06,27.935,69.847,7.444,56.701C7.397,54.876,7.358,53.057,7.324,51.238z M7.514,59.39
                                                c19.922,13.94,40.71,27.935,62.701,38.383c-0.044,1.224-0.091,2.446-0.135,3.671C50.492,87.807,29.879,75.583,8.315,65.333
                                                c-0.225-0.107-0.439-0.098-0.629-0.038C7.626,63.321,7.569,61.354,7.514,59.39z M8,75.724c-0.082-2.952-0.173-5.887-0.264-8.812
                                                c21.234,11.539,41.176,24.927,61.032,38.668c0.404,0.279,0.792,0.345,1.161,0.326c-0.067,1.998-0.145,3.994-0.205,5.992
                                                C49.528,99.635,28.578,88.526,8.016,76.89C8.006,76.5,8.009,76.113,8,75.724z M8.046,78.971
                                                c20.365,12.666,40.318,26.282,61.537,37.479c-0.025,0.942-0.065,1.885-0.087,2.827c-20.348-11.091-41.51-20.35-61.335-32.464
                                                C8.147,84.203,8.096,81.586,8.046,78.971z M8.176,94.673c0.003-1.933-0.006-3.868-0.012-5.802
                                                C27,102.615,48.156,114.129,69.379,123.634c-0.016,0.787-0.05,1.576-0.063,2.363C50.406,113.002,27.132,107.816,8.176,94.673z
                                                M69.266,130.413c-0.02,1.792-0.055,3.586-0.061,5.377c-18.427-13.134-40.962-21.228-60.778-31.947
                                                c-0.09-0.049-0.176-0.06-0.263-0.082c0.002-2.277,0.004-4.56,0.009-6.838C26.42,111.314,49.709,117.929,69.266,130.413z
                                                M8.161,106.113c19.908,11.609,40.451,23.03,61.07,33.3c0.007,3.096,0.01,6.191,0.069,9.281
                                                c-17.275-15.029-41.408-20.417-61.05-31.812C8.185,113.294,8.166,109.704,8.161,106.113z M8.532,126.822
                                                c-0.129-2.669-0.165-5.338-0.226-8.008c19.454,13.142,42.913,19.459,61.147,34.445c0.088,3.045,0.151,6.094,0.303,9.13
                                                c-7.177-6.963-19.645-11.459-27.82-15.807c-6.886-3.662-13.787-7.301-20.613-11.072c-2.491-1.377-12.221-5.467-12.788-8.685
                                                C8.534,126.824,8.532,126.824,8.532,126.822z M8.778,131.046c4.503,5.154,16.964,10.73,19.459,12.164
                                                c13.767,7.913,27.702,16.472,41.762,23.762c0.146,2.371,0.307,4.738,0.499,7.103c-13.046-7.478-26.073-15.375-38.38-23.961
                                                c-6.087-4.246-14.773-13.3-22.979-13.956C8.99,134.452,8.888,132.749,8.778,131.046z M10.315,147.036
                                                c-0.001-0.132,0.036-0.248,0.016-0.387c-0.368-2.51-0.649-5.021-0.908-7.529c19.462,14.265,40.189,27.678,61.438,39.104
                                                c0.06,0.642,0.104,1.287,0.169,1.929C50.956,168.578,29.429,160.404,10.315,147.036z M70.843,80.656
                                                C52.738,65.248,29.286,57.289,7.292,49.086c-0.057-3.758-0.066-7.508-0.028-11.257C24.981,54,49.067,63.198,71.114,72.063
                                                C71.023,74.929,70.945,77.787,70.843,80.656z M71.26,67.478C49.593,57.517,26.313,50.845,7.708,35.277
                                                c-0.122-0.102-0.251-0.166-0.381-0.211c0.055-3.044,0.169-6.091,0.316-9.14c11.434,8.338,23.643,15.322,36.084,22.069
                                                c3.103,1.683,22.356,13.161,27.657,13.339C71.333,63.386,71.32,65.424,71.26,67.478z M58.576,51.28
                                                C41.028,44.145,23.378,34.262,7.773,23.465c0.154-2.663,0.347-5.331,0.593-8.004c9.424,7.264,19.688,13.28,29.918,19.337
                                                c11.443,6.774,21.946,14.825,33.198,21.744c-0.001,0.025-0.001,0.05-0.002,0.075C67.538,54.14,62.145,52.73,58.576,51.28z"/>
                                            <path d="M186.672,67.146c0.001-0.265-0.047-0.542-0.156-0.827c-2.648-6.908-11.393-11.621-17.345-15.427
                                                c-7.979-5.102-16.516-9.296-25.331-12.745c-1.145-0.448-1.922,0.29-2.141,1.224c-1.102,0.211-2.082,0.907-2.326,2.146
                                                c-0.893,4.533-0.5,9.896,0.111,14.831c-3.729-0.728-8.163-0.393-10.825-0.419c-9.845-0.096-20.042,0.211-29.815,1.468
                                                c-1.29,0.166-2.022,1.404-1.794,2.425c-0.041,0.14-0.103,0.261-0.12,0.422c-0.484,4.515-0.821,9.043-0.843,13.586
                                                c-0.013,2.87-0.267,6.711,1.239,9.323c-0.312,0.253-0.656,0.461-0.933,0.764c-0.272,0.3-0.281,0.731,0,1.029
                                                c4.491,4.77,13.291,2.335,19.231,1.977c8.359-0.505,17.362-0.525,25.682-2.127c-0.439,2.177-0.244,4.681-0.393,6.783
                                                c-0.227,3.216-0.579,6.422-0.763,9.644c-0.204,3.562,4.549,4.038,6.004,1.469c0.036-0.001,0.062,0.017,0.098,0.015
                                                c17.658-1.079,31.463-18.599,40.526-32.122C187.646,69.289,187.419,68.036,186.672,67.146z M163.861,55.155
                                                c5.979,3.706,11.047,9.07,16.828,12.889c-0.536,0.775-1.136,1.575-1.696,2.362c-11.289-7.171-21.724-15.591-33.163-22.517
                                                c0.002-1.423-0.04-2.831-0.189-4.186C151.597,47.699,157.767,51.378,163.861,55.155z M102.568,80.902
                                                c0.103-1.621-0.149-3.333-0.358-4.983c1.374,1.139,2.717,2.315,4.123,3.414c0.486,0.38,0.991,0.783,1.492,1.181
                                                C106.036,80.532,104.244,80.601,102.568,80.902z M115.625,80.454c-0.892,0.062-1.86,0.072-2.859,0.07
                                                c-1.279-0.798-2.581-1.571-3.791-2.421c-2.426-1.706-4.756-3.543-7.068-5.401c-0.212-3.068-0.521-6.133-0.835-9.195
                                                c5.711,6.068,12.39,11.976,19.356,16.516C118.814,80.188,117.208,80.344,115.625,80.454z M124.926,79.54
                                                c-0.066-0.074-0.113-0.156-0.2-0.221c-7.742-5.911-15.636-11.344-23.14-17.55c2.024,0.357,4.109,0.528,6.209,0.633
                                                c3.713,3.412,7.458,6.784,11.317,10.032c2.376,2,5.375,5.018,8.517,6.822C126.728,79.351,125.825,79.441,124.926,79.54z
                                                M132.57,78.816c-0.01-0.012-0.006-0.024-0.017-0.035c-2.799-3.077-7.259-5.215-10.62-7.671c-3.801-2.777-7.5-5.695-11.193-8.616
                                                c1.811,0.024,3.621-0.002,5.412-0.036c0.047,0.172,0.129,0.342,0.297,0.499c5.914,5.538,12.161,10.686,18.482,15.748
                                                C134.145,78.747,133.361,78.757,132.57,78.816z M146.878,96.914c0.149-2.632,0.227-5.931-0.099-8.766
                                                c2.528,2.018,5.042,4.055,7.533,6.117C151.943,95.431,149.471,96.346,146.878,96.914z M157.651,92.413
                                                c-3.705-3.569-7.665-6.812-11.733-9.917c0.469-1.554-0.58-3.564-2.569-3.744c-0.846-0.077-1.712-0.06-2.566-0.091
                                                c-7.275-5.302-14.697-10.42-21.571-16.259c0.988-0.021,1.993-0.046,2.956-0.058c1.717-0.022,3.433-0.012,5.148,0.007
                                                c9.618,10.466,21.054,19.909,32.095,28.856C158.825,91.611,158.253,92.041,157.651,92.413z M161.996,89.319
                                                c-8.965-10.214-21.072-17.636-31.14-26.888c1.225,0.035,2.449,0.057,3.676,0.116c2.118,0.101,4.368,0.81,6.542,1.057
                                                c4.943,3.155,9.655,6.604,14.208,10.363c2.534,2.093,4.987,4.29,7.414,6.507c1.485,1.357,2.919,3.208,4.856,3.861
                                                C165.782,86.111,163.934,87.792,161.996,89.319z M169.357,82.453c-1.457-4.3-8.836-8.642-12.058-11.102
                                                c-3.845-2.936-7.915-6.063-12.307-8.417c0.669-0.567,1.057-1.41,0.708-2.371c-0.191-0.526-0.475-0.976-0.795-1.391
                                                c0.069-0.505,0.13-1.041,0.197-1.558c3.904,3.839,7.914,7.588,11.91,11.32c3.805,3.553,8.819,9.593,14.105,10.738
                                                c0.338,0.073,0.657-0.054,0.919-0.248C171.164,80.448,170.278,81.466,169.357,82.453z M172.344,78.08
                                                c-2.979-4.526-9.089-7.718-13.218-11.257c-4.603-3.944-8.995-8.174-13.688-12.014c0.143-1.361,0.244-2.741,0.317-4.119
                                                c10.475,7.418,20.229,15.841,30.978,22.863c-1.391,1.852-2.85,3.705-4.38,5.515C172.516,78.775,172.573,78.428,172.344,78.08z"/>
                                        </g>
                                    </g>
                                </svg>
                                Login
                            </button>
                        </div>
                        <div id="loading_form" class="loading_ absolute !hidden bg-[#e4e4e4e3] dark:bg-[#2e2d2dd5]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                                <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </form>
                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                        <a href="{{ route('login') }}" class="cursor-pointer inline-block space-y-2 border-b border-black dark:border-blue-500">
                                Sigh In
                            </a>
                    </p>
                    <span class="mt-4 block font-sans text-xs font-bold text-center">
                        PRODUCT MASTER (V 1.04.0 © 2024)
                    </span> 
                </div>
            </div>
        </div>
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
</html>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

<script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
<script>

    const dlayMessage = 500;
    function checkLogin() {
        let dataForm = $(".js-validation-signin").serialize();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: "GET",
            url: "/api_bypass_login",
            data: dataForm,
            beforeSend: function () {
                $('#loader').removeClass('hidden')
            },
            success: (res) => {
                console.log("🚀 ~ checkLogin ~ res:", res)
                sessionStorage.setItem("first_login", "Y")
                sessionStorage.setItem("credetail", JSON.stringify(res.response))
                sessionStorage.setItem("role", res.response.data.roles[0])
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

    // $(document).ready(function() {
    //     $('.js-example-basic-single').select2();
    // });

    // toastr.options = {
    //     "closeButton": true,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": true,
    //     "positionClass": "toast-top-right",
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "300",
    //     "hideDuration": "1000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "hideMethod": "fadeOut"
    // }
    // // $(document).ready(function onDocumentReady() {
    // //     setInterval(function doThisEveryTwoSeconds() {
    // //         toastr.success("Hello World!");
    // //     }, 2000);
    // // });

    // const dlayMessage = 1000;

    // function register() {
    //     jQuery.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     let url = "{{ route('register') }}";
    //     $.ajax({
    //         method : 'POST',
    //         url,
    //         data: $("#register").serialize(),
    //         beforeSend: function () {
    //             $('#loader').removeClass('hidden')
    //         },
    //         success: function(res){
    //             setTimeout(function() {
    //                 successMessage("Create User Successfully!");
    //             },dlayMessage)
    //             setTimeout(function() {
    //                 toastr.success("Create User Successfully!");
    //             },dlayMessage)
    //         },
    //         error: function (params) {
    //             setTimeout(function() {
    //                 errorMessage("Can't Create Username!");
    //             },dlayMessage)
    //             setTimeout(function() {
    //                 toastr.error("Can't Create Username!");
    //             },dlayMessage)
    //         }
    //     });
    // }

    // function successMessage(text) {
    //     $('#loader').addClass('hidden');
    //     $('#name').val('')
    //     $('#email').val('')
    //     $('#password').val('')
    // }
    // function errorMessage(text) {
    //     $('#loader').addClass('hidden');
    //     $('#name').val('')
    //     $('#email').val('')
    //     $('#password').val('')
    // }

</script>