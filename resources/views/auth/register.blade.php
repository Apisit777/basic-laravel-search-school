
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgb(55 53 53 / 80%);
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading_z {
            z-index: 1000000;
        }
        .select2-container .select2-dropdown .select2-results__options {
            max-height: 360px !important;
        }
    </style>
</head>

<body>
    <div class="min-h-screen p-10" style="background-image: url('https://www.ssup.co.th/wp-content/uploads/2022/11/shutterstock_2079577573.png')">
        <div class="g-2 flex flex-wrap items-center justify-center lg:justify-between">
            <div class="mb-12 grow-0 basis-auto md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12 xl:ml-12">
            </div>
            <div class="mt-24 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12 relative">
                <!-- <form class="max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500" action="{{ route('register')}}" method="POST">
                    @csrf -->
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
                    <div class="flex flex-col gap-6">
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
                                    <option value={{ $list_positions->id_position }}>{{ $list_positions->name_position }}</option>
                                @endforeach
                            </select>
                            <!-- <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Password
                            </label> -->
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

                    {{-- <button
                        class="mt-6 block w-full select-none rounded-lg bg-[#3061AF] py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type=""
                        data-ripple-light="true"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                    </svg>
                    Register
                    </button> --}}

                    <div id="loader" class="loading absolute hidden">
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
            </div>
        </div>
    </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<!-- <script type="text/javascript"  src="./node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    // $(document).ready(function onDocumentReady() {
    //     setInterval(function doThisEveryTwoSeconds() {
    //         toastr.success("Hello World!");
    //     }, 2000);
    // });

    const dlayMessage = 1000;

    function register() {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        let url = "{{ route('register') }}";
        $.ajax({
            method : 'POST',
            url,
            data: $("#register").serialize(),
            beforeSend: function () {
                $('#loader').removeClass('hidden')
            },
            success: function(res){
                setTimeout(function() {
                    successMessage("Create User Successfully!");
                },dlayMessage)
                setTimeout(function() {
                    toastr.success("Create User Successfully!");
                },dlayMessage)
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
        $('#email').val('')
        $('#password').val('')
    }
    function errorMessage(text) {
        $('#loader').addClass('hidden');
        $('#name').val('')
        $('#email').val('')
        $('#password').val('')
    }

</script>
