
<!DOCTYPE html>
<html lang="en">
<head>

</head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* form {
            max-width: 80.5%;
            border-radius: 7px;
            padding: 20px 20px;
        } */
        /* .form {
            width: 100%;
            border-radius: 7px;
            padding: 20px 20px;
        } */
        .lds-dual-ring:after {
            content: " ";
            position: absolute;
            width: calc(1.5vw + 5vh);
            height: calc(1.5vw + 5vh);
            font-size: 1vw;
            border-radius: 50%;
            border: 6px solid #18978A;
            border-color: #18978A transparent #18978A transparent;
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
            color: #18978A;
            font-size: calc(1vw + 1.5vh);
            position: relative;
        }
        .loading span{
            font-size: calc(1vw + 1.5vh);
        }
        .l {
            position: fixed;
            font-size: 18px;
            top: 38%;
            left: 47.3%;
            color: #18978A;
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
    </style>
<body>
    <!-- <div id="slide" class="loaderslide"></div> -->
    <div class="min-h-screen p-10" style="background-image: url('https://www.pixelstalk.net/wp-content/uploads/2016/07/1080p-Full-HD-Images-For-Desktop.jpg')">
        <div class="g-2 flex flex-wrap items-center justify-center lg:justify-between">
            <div class="mb-12 grow-0 basis-auto md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12 xl:ml-12">
            </div>
            <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-4/12">
                <form class="max-w-7xl rounded-md p-10 bg-white dark:bg-[#202020] text-black dark:text-white shadow-md shadow-[#202020] dark:shadow-blue-500 mt-32">
                    <div class="flex flex-row items-center justify-center lg:justify-start">
                        <div class="flex text-center">
                            <p class="mb-0 me-4 mt-4 text-lg">Sign in with</p>
                            <!-- <button class="flex items-center mr-2 bg-white dark:bg-[#303030] border border-gray-300 rounded-lg shadow-md px-6 py-2 text-sm font-medium text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
                            </button> -->
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

                    <div class="mb-4 flex flex-col gap-6">
                        <div class="relative h-11 w-full min-w-[200px]">
                            <input
                                type="email"
                                class="peer h-full w-full rounded-md border border-blue-gray-200 bg-transparent px-3 py-3 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-blue-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                placeholder=" "
                            >
                            <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.1] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-blue-500 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-blue-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-blue-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                Email
                            </label>
                        </div>
                        <div class="relative h-11 w-full min-w-[200px]">
                            <input
                                type="password"
                                class="peer h-full w-full rounded-md border border-blue-gray-200 bg-transparent px-3 py-3 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-blue-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                                placeholder=" "
                            >
                            <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.1] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-blue-500 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-blue-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-blue-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                                Password
                            </label>
                        </div>
                    </div>

                    <!-- <div class="relative mb-6" data-twe-input-wrapper-init>
                        <input
                        type="text"
                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlInput2"
                        placeholder="Email address" />
                        <label
                        for="exampleFormControlInput2"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[1.15rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary"
                        >Email address
                        </label>
                    </div>

                    <div class="relative mb-6" data-twe-input-wrapper-init>
                        <input
                        type="password"
                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlInput22"
                        placeholder="Password" />
                        <label
                        for="exampleFormControlInput22"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[twe-input-state-active]:-translate-y-[1.15rem] peer-data-[twe-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-400 dark:peer-focus:text-primary"
                        >Password
                        </label>
                    </div> -->

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
                        type="submit"
                        data-ripple-light="true"
                    >
                        Login
                    </button>
                    <p class="mt-4 block text-center font-sans text-base font-normal leading-relaxed antialiased">
                        Already have an account?
                            <Link to="/signup">
                                Create an account
                            </Link>
                    </p>
                    <span class="mt-4 block font-sans text-xs font-bold text-center">
                        SSUP GROUP CO., LTD. (V 1.04.0 © 2023)
                    </span>
                </form>
            </div>
        </div>

        <div class="flex flex-col h-screen">
            <!-- Sidenav -->
            <input type="checkbox" id="toggle" class="hidden peer" />
            <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">
                <label for="toggle" class="flex items-center space-x-2 px-4 py-2 cursor-pointer">
                <span>Home</span>
                <svg id="arrow" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300 peer-checked:rotate-90" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-.293l-7-7a1 1 0 011.414-1.414L10 15.586l6.293-6.293a1 1 0 111.414 1.414l-7 7A1 1 0 0110 18z" clip-rule="evenodd" />
                </svg>
                </label>
            </div>
        </div>

        <div class="imgContainer">
            {{-- <span class="l">LOADING...</span> --}}
            <div id="loader" class="overlay hidden">
                <div class="loading">
                    <!-- LOADING -->
                    <span class="text-[#18978A] text-5xl font-medium">SSUP</span>
                    <!-- <img src="https://www.ssup.co.th/wp-content/uploads/2022/11/site-logo-g.png" width="50%" height="50px"> -->
                    <!-- <div class="mt-20"> -->
                        <span class="loading__dot">.</span>
                        <span class="loading__dot">.</span>
                        <span class="loading__dot">.</span>
                        <div class="lds-dual-ring "></div>
                    <!-- </div> -->
                </div>
                 <!-- <img src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/02b374101705095.5f24d5db1096f.gif" alt="" style="width: 100%;">  -->
            </div>
        </div>

    </div>
</body>
</html>

<!-- <script src="https://cdn.tailwindcss.com"></script> -->
<!-- <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> -->