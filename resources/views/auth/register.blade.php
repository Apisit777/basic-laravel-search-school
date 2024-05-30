
<!DOCTYPE html>
<html lang="en">
<head>

</head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    </style>

    
<body>
    <div class="min-h-screen p-10" style="background-image: url('https://www.ssup.co.th/wp-content/uploads/2022/11/shutterstock_2079577573.png')">
        <div class="g-2 flex flex-wrap items-center justify-center lg:justify-between">
            <div class="mb-12 grow-0 basis-auto md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12 xl:ml-12">
            </div>
            <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                <form class="max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-32" action="" method="POST">
                    @csrf
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

                    <!-- <div>
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                    </div> -->
                    <div class="flex flex-col gap-6">
                        <div class="relative float-label-input mt-0">
                            <input type="text" id="name" name="name" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Name
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <input type="email" id="name" name="email" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
                                Email
                            </label>
                        </div>
                        <div class="relative float-label-input -mt-8">
                            <input type="password" id="name" name="password" placeholder=" " class="block w-full bg-white dark:bg-[#2020] rounded-sm text-xs focus:outline-none focus:shadow-outline border border-black dark:border-gray-100 appearance-none leading-normal focus:border-blue-400">
                            <label for="name" class="absolute block top-1 left-0 text-md text-black dark:text-white pointer-events-none transition duration-200 ease-in-outbg-white px-2 text-grey-darker">
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

                    <button
                        class="mt-6 block w-full select-none rounded-lg bg-[#3061AF] py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                        type=""
                        data-ripple-light="true"
                    >
                        Register
                    </button>
                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                            <a to="/signup" class="cursor-pointer">
                                Sigh In
                            </Link>
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

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<!-- <script type="text/javascript"  src="./node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> -->