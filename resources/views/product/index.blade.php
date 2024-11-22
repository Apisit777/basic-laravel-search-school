@extends('layouts.layout')
@section('title', '')
    <style>
        .loaderslide {
            width: 100%;
            height: 100%;
            background-color: #303030;
            position: fixed;
            top: 0;
            z-index: 1000;
            animation: slide_up 1s linear 0.7s forwards;
        }
        .btn {
            z-index: 10;
        }
        @keyframes slide_up{
            0% {
                height: 100%;
            }
            70% {
                height: 10%;
            }
            100% {
                height: 0%;
            }
        }
        .page-item.active .page-link {
            color: #fff !important;
            background: #1F2226 !important;
        }
        .buttons-excel{
            color: #fff !important;
            background: #1F2226 !important;
        }
        .buttons-collection{
            color: #fff !important;
            background: #1F2226 !important;
        }
        [x-cloak] {
            display: none;
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
        .select2-container--default .select2-selection--single .select2-selection__clear {
            float: right;
            cursor: pointer;
            --tw-text-opacity: 1;
            color: rgb(200 30 30 / var(--tw-text-opacity));
            margin-right: 24px!important;
            margin-top: -1px!important;
            font-size: 20px!important;
        }
        .loading_create_menu {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading_create_menu_consumables {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        *{margin: 0;padding:0px}

        .header{
            width: 100%;
            /* background-color: #0d77b6 !important; */
            height: 0px;
        }

        .showLeft{
            /* background-color: #0d77b6 !important;
            border:1px solid #0d77b6 !important;
            text-shadow: none !important;
            color:#fff !important; */
            padding:10px;
        }

        .icons li {
            /* background: none repeat scroll 0 0 #fff; */
            height: 7px;
            width: 7px;
            line-height: 0;
            list-style: none outside none;
            margin-right: 15px;
            margin-top: 3px;
            vertical-align: top;
            border-radius:50%;
            pointer-events: none;
        }

        .btn-left {
            left: 0.4em;
        }

        .btn-right {
            right: 0.4em;
        }

        .btn-left, .btn-right {
            position: absolute;
            top: -2.5em;
            right: -105px;
            z-index: 999;
        }

        .dropbtn {
            /* background-color: #4CAF50; */
            position: fixed;
            /* color: white; */
            font-size: 13.5px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            /* background-color: #3e8e41; */
        }

        .dropdown {
            position: absolute;
            display: inline-block;
            left: 500px;
            /* right: -54.5em; */
        }

        .dropdown-content {
            display: none;
            position: relative;
            margin-top: 60px;
            background-color: #f9f9f9;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            /* color: black; */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* .dropdown a:hover {background-color: rgb(229 231 235);} */

        .show {display:block;}
        span.dt-column-order {
            display: none;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    <div id="slide" class="loaderslide"></div>

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_registration_list')</p>
        </div>
        <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
            <div class="lg:col-span-4 xl:grid-cols-4">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                    <div class="md:col-span-3">
                        <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND">
                            <option value=""> --- กรุณาเลือก ---</option>
                            @foreach ($brands as $key => $brand)
                                <option value={{ $brand }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3" >
                        <label for="">ค้นหา</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" />
                    </div>
                    <div class="md:col-span-6 text-center">
                        <div class="inline-flex items-center">
                            <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                ค้นหา
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="max-w-sm mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg dark:hover:shadow-xl transition-shadow duration-300 ease-in-out">
            <img class="w-20 h-20 rounded-md mx-auto" src="https://via.placeholder.com/150" alt="Avatar">
            <div class="text-center mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Erin Lindford</h2>
                <p class="text-gray-500 dark:text-gray-400">Product Engineer</p>
            </div>
        </div> -->

        <!-- <a href="#" id="fetchDataBtn" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
            </svg>
            Fetch School Balance Data
        </a>
        <div id="responseData" class="mt-5 text-gray-900 dark:text-white"></div>

        <div class="container mx-auto py-8">
            <div id="cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
        </div>

        <div id="pagination-controls" class="mt-8 flex flex-wrap justify-center space-x-2">

            <svg id="prev-btn" fill="currentColor" class="size-8 mt-0.5 ml-0.5 text-black dark:text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="m4.431 12.822 13 9A1 1 0 0 0 19 21V3a1 1 0 0 0-1.569-.823l-13 9a1.003 1.003 0 0 0 0 1.645z"/>
            </svg>

            <button 
                    class="px-4 py-2 bg-[#303030] text-white rounded hover:bg-[#404040] disabled:bg-[#606060] w-full sm:w-auto text-center mb-2 sm:mb-0"
                    disabled>
                Prev
            </button>
            <div id="pagination-numbers" class="flex flex-wrap justify-center space-x-2"></div>

            <button
                    class="px-4 py-2 bg-[#303030] text-white rounded hover:bg-[#404040] disabled:bg-[#505050] w-full sm:w-auto text-center mb-2 sm:mb-0">
                Next
            </button>

            <svg id="next-btn" fill="currentColor" class="size-8 mt-0.5 ml-0.5 text-black dark:text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.536 21.886a1.004 1.004 0 0 0 1.033-.064l13-9a1 1 0 0 0 0-1.644l-13-9A1 1 0 0 0 5 3v18a1 1 0 0 0 .536.886z"/>
            </svg>
        </div> -->

        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 relative"></ul>
        <div class="flex right-12 z-10 absolute mt-3">
            <div class="relative" data-twe-dropdown-position="dropstart">
                <button
                    class="flex items-center rounded bg-[#303030] hover:bg-[#404040] px-4 pb-[5px] pt-[6px] text-sm font-bold uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                    type="button"
                    id="dropdownMenuButton1s"
                    data-twe-dropdown-toggle-ref
                    aria-expanded="false"
                    data-twe-ripple-init
                    data-twe-ripple-color="light">
                    <span class="me-2 [&>svg]:h-5 [&>svg]:w-5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                    </svg>
                    </span>
                        เพิ่มข้อมูลสิ้นค้า
                </button>
                <ul style="z-index: 999999999;" class="absolute divide-y divide-gray-600 rounded-sm w-48 md:w-52 dark:divide-gray-600 float-left m-0 hidden min-w-max list-none overflow-hidden border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                    aria-labelledby="dropdownMenuButton1s"
                    data-twe-dropdown-menu-ref>
                    <li>
                        <a href="{{ route('product_master.create') }}" class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                            <svg class="h-5 w-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="currentColor" viewBox="0 0 512 512"  xml:space="preserve">
                                <g>
                                    <path class="st0" d="M504.262,66.75L445.226,7.706c-10.291-10.284-26.938-10.267-37.222,0l-38.278,38.278l96.282,96.266
                                        l38.254-38.295C514.537,93.672,514.554,77.017,504.262,66.75z"/>
                                    <path class="st0" d="M32.815,382.921L0.025,512l129.055-32.83l319.398-319.431l-96.249-96.265L32.815,382.921z M93.179,404.792
                                        l-21.871-21.871l278.289-278.289l21.887,21.887L93.179,404.792z"/>
                                </g>
                            </svg>
                            <span class="ml-2.5">
                                เพิ่มข้อมูลสิ้นค้า
                            </span>
                        </a>
                    </li>
                    <li>
                        <a
                            type="button"
                            class="cursor-pointer block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group"
                            data-twe-toggle="modal"
                            data-twe-target="#exampleModal"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            onclick="modelCopy()"
                        >
                            <svg class="-ml-1 h-8 w-8 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M589.3 260.9v30H371.4v-30H268.9v513h117.2v-304l109.7-99.1h202.1V260.9z" fill="#E1F0FF" />
                                <path d="M516.1 371.1l-122.9 99.8v346.8h370.4V371.1z" fill="#E1F0FF" />
                                <path d="M752.7 370.8h21.8v435.8h-21.8z" fill="#446EB1" />
                                <path d="M495.8 370.8h277.3v21.8H495.8z" fill="#446EB1" />
                                <path d="M495.8 370.8h21.8v124.3h-21.8z" fill="#446EB1" />
                                <path d="M397.7 488.7l-15.4-15.4 113.5-102.5 15.4 15.4z" fill="#446EB1" />
                                <path d="M382.3 473.3h135.3v21.8H382.3z" fill="#446EB1" />
                                <path d="M382.3 479.7h21.8v348.6h-21.8zM404.1 806.6h370.4v21.8H404.1z" fill="#446EB1" />
                                <path d="M447.7 545.1h261.5v21.8H447.7zM447.7 610.5h261.5v21.8H447.7zM447.7 675.8h261.5v21.8H447.7z" fill="#6D9EE8" />
                                <path d="M251.6 763h130.7v21.8H251.6z" fill="#446EB1" /><path d="M251.6 240.1h21.8v544.7h-21.8zM687.3 240.1h21.8v130.7h-21.8zM273.4 240.1h108.9v21.8H273.4z" fill="#446EB1" />
                                <path d="M578.4 240.1h130.7v21.8H578.4zM360.5 196.5h21.8v108.9h-21.8zM382.3 283.7h196.1v21.8H382.3zM534.8 196.5h65.4v21.8h-65.4z" fill="#446EB1" />
                                <path d="M360.5 196.5h65.4v21.8h-65.4zM404.1 174.7h152.5v21.8H404.1zM578.4 196.5h21.8v108.9h-21.8z" fill="#446EB1" />
                            </svg>
                            <span class="text-black dark:text-white">
                                Copy ข้อมูลสิ้นค้า
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product_master.create_consumables') }}" class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                            <svg class="h-5 w-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="currentColor" viewBox="0 0 512 512"  xml:space="preserve">
                                <g>
                                    <path class="st0" d="M504.262,66.75L445.226,7.706c-10.291-10.284-26.938-10.267-37.222,0l-38.278,38.278l96.282,96.266
                                        l38.254-38.295C514.537,93.672,514.554,77.017,504.262,66.75z"/>
                                    <path class="st0" d="M32.815,382.921L0.025,512l129.055-32.83l319.398-319.431l-96.249-96.265L32.815,382.921z M93.179,404.792
                                        l-21.871-21.871l278.289-278.289l21.887,21.887L93.179,404.792z"/>
                                </g>
                            </svg>
                            <span class="ml-2.5">
                                เพิ่มวัสดุสิ้นเปลือง
                            </span>
                        </a>
                    </li>
                    <li>
                        <a
                            type="button"
                            class="cursor-pointer block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group"
                            data-twe-toggle="modal"
                            data-twe-target="#exampleModalCopy"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            onclick="modelCopyConsumables()"
                        >
                            <svg class="-ml-1 h-8 w-8 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <path d="M589.3 260.9v30H371.4v-30H268.9v513h117.2v-304l109.7-99.1h202.1V260.9z" fill="#E1F0FF" />
                                <path d="M516.1 371.1l-122.9 99.8v346.8h370.4V371.1z" fill="#E1F0FF" />
                                <path d="M752.7 370.8h21.8v435.8h-21.8z" fill="#446EB1" />
                                <path d="M495.8 370.8h277.3v21.8H495.8z" fill="#446EB1" />
                                <path d="M495.8 370.8h21.8v124.3h-21.8z" fill="#446EB1" />
                                <path d="M397.7 488.7l-15.4-15.4 113.5-102.5 15.4 15.4z" fill="#446EB1" />
                                <path d="M382.3 473.3h135.3v21.8H382.3z" fill="#446EB1" />
                                <path d="M382.3 479.7h21.8v348.6h-21.8zM404.1 806.6h370.4v21.8H404.1z" fill="#446EB1" />
                                <path d="M447.7 545.1h261.5v21.8H447.7zM447.7 610.5h261.5v21.8H447.7zM447.7 675.8h261.5v21.8H447.7z" fill="#6D9EE8" />
                                <path d="M251.6 763h130.7v21.8H251.6z" fill="#446EB1" /><path d="M251.6 240.1h21.8v544.7h-21.8zM687.3 240.1h21.8v130.7h-21.8zM273.4 240.1h108.9v21.8H273.4z" fill="#446EB1" />
                                <path d="M578.4 240.1h130.7v21.8H578.4zM360.5 196.5h21.8v108.9h-21.8zM382.3 283.7h196.1v21.8H382.3zM534.8 196.5h65.4v21.8h-65.4z" fill="#446EB1" />
                                <path d="M360.5 196.5h65.4v21.8h-65.4zM404.1 174.7h152.5v21.8H404.1zM578.4 196.5h21.8v108.9h-21.8z" fill="#446EB1" />
                            </svg>
                            <span class="text-black dark:text-white">
                                Copy วัสดุสิ้นเปลือง
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModal"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                            Copy ข้อมูล
                        </h5>
                        <!-- Close button -->
                        <button
                            type="button"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <form id="form_copy" class="" method="POST">
                        <div class="p-8 lg:col-span-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-3" >
                                    <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Copy ข้อมูล<span class="text-danger"> *</span></label>
                                    <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="data_coppy" name="PRODUCT">
                                        <option class="" value=""> --- กรุณาเลือก ---</option>
                                        @foreach ($dataProductMasterArr as $key => $dataProductMaster)
                                            <option value={{ $dataProductMaster }}>{{ $dataProductMaster }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- <div class="md:col-span-3" style="position: relative;">
                                    <label for="PRODUCT">รหัสสินค้า<span class="text-danger"> *</span></label>
                                    <input type="text" name="PRODUCT" id="ID_PRODUCT" onkeyup="checkNameBrand()" class="text-compleace-auto1 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                    <div class="col-auto" style="position: absolute; right: -0.5%; top: 55%; z-index: 10000;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" id="username_loading" style="margin-right: -2.5px;" class="w-6 h-6 animate-spin -mt-1">
                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                        </svg>
                                        <i class="fa fa-check-circle text-success" id="correct_username" style="font-size: 17px;"></i>
                                        <i class="fa fa-times-circle text-danger" id="username_alert" style="font-size: 17px;"></i>
                                    </div>
                                </div> -->

                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="NUMBER" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Code ที่ต้องการ<span class="text-danger"> *</span></label>
                                    <select class="js-example-basic-single w-full rounded-sm text-xs" id="NUMBER" name="NUMBER" onchange="barcodeChange(this, 'BARCODE')">
                                        <option value=""> --- กรุณาเลือก ---</option>
                                        @foreach ($productCodeArr as $key => $productCode)
                                            <option value={{ $productCode }}>{{ $productCode }}</option>
                                        @endforeach
                                    </select>
                                    <div class="col-auto" style="position: absolute; right: -18%; top: 55%; z-index: 10000;">
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
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <label for="barcodeTest">Barcode ที่ต้องการ<span class="text-danger"> *</span></label>
                            <input type="text" id="BARCODE" name="BARCODE" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="" disabled />
                        </div>

                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                        </div>

                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <button data-twe-modal-dismiss id="submitButton" type="button" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" onclick="createCopy()" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>
                    <div id="loader_create_menu" class="loading_create_menu absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Copy-->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalCopy"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                            Copy วัสดุสิ้นเปลือง
                        </h5>
                        <!-- Close button -->
                        <button
                            type="button"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <form id="form_copy_consumables" class="" method="POST">
                        <div class="p-4 lg:col-span-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-6" >
                                    <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Copy ข้อมูล<span class="text-danger"> *</span></label>
                                    <select class="js-example-placeholder-single select2 w-full rounded-sm text-xs text-center" id="data_coppy_consumables" name="PRODUCT" onchange="barcodeConsumablesChange()">
                                        <option></option>
                                        @foreach ($dataProductMasterConsumablesArr as $key => $dataProductMasterConsumables)
                                            <option value={{ $dataProductMasterConsumables }}>{{ $dataProductMasterConsumables }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-6" style="position: relative;">
                                    <label for="">รหัสที่ต้องการ<span class="text-danger"> *</span></label>
                                    <input type="text" id="PRODUCT_Consumables" name="BARCODE" onkeyup="barcodeConsumablesChange()" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="" />
                                    <div class="col-auto" style="position: absolute; right: 0%; top: 60%;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" id="username_loading_consumables" style="margin-right: -2.5px;" class="w-6 h-6 animate-spin -mt-1">
                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                        </svg>
                                        <svg id="correct_username_consumables" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                                        <svg id="username_alert_consumables" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                        <!-- <div class="p-4 text-gray-900 dark:text-gray-100">
                            <label for="">Barcode ที่ต้องการ<span class="text-danger"> *</span></label>
                            <input type="text" id="" name="" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-900 text-blue-600 dark:text-blue-600 text-sm font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#101010] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="" disabled />
                        </div> -->

                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                        </div>

                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <button data-twe-modal-dismiss id="submitButtonConsumables" type="button" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-1.5 px-4 rounded cursor-not-allowed opacity-50 group" onclick="createCopyConsumables()" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                </svg>
                                Save
                            </button>
                        </div>
                    </form>
                    <div id="loader_create_menu_consumables" class="loading_create_menu_consumables absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="flex right-32 z-10 top-80 absolute">
            <button id="dropdownAvatar" data-dropdown-toggle="dropdown" class="" type="button">
                <ul class="dropbtn color-[#303030] dark:color-white icons btn-right showLeft absolute" data-twe-toggle="tooltip" title="เพิ่มข้อมูล" onclick="showDropdown()">
                    <li class="bg-[#303030] dark:bg-white"></li>
                    <li class="bg-[#303030] dark:bg-white"></li>
                    <li class="bg-[#303030] dark:bg-white"></li>
                </ul>
            </button>
            <div id="dropdown" class="p-2 z-10 hidden text-center bg-white divide-y divide-gray-600 rounded-sm shadow w-48 border-none dark:bg-[#303030] dark:divide-gray-600">
                <div class="flex items-center justify-start text-black dark:text-white text-sm hover:bg-gray-100 dark:hover:bg-[#404040] cursor-pointer">
                    <a href="{{ route('product_master.create') }}" class="text-black dark:text-white py-2 px-2 rounded-sm group">
                        <svg class="h-6 w-6 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 451.39 451.39" xml:space="preserve">
                            <g>
                                <g id="XMLID_28_">
                                    <g>
                                        <path style="fill:#FFFFFF;" d="M437.029,439.43c0,0.79-0.31,1.54-0.87,2.1c-1.12,1.11-3.08,1.12-4.2,0l-11.91-11.92l4.2-4.19
                                            l11.91,11.91C436.719,437.89,437.029,438.64,437.029,439.43z"/>
                                        <path d="M18.269,68.58l9.13,9.13l44.94-44.94l-9.13-9.13c-2.51-2.51-5.86-3.9-9.41-3.9c-3.56,0-6.9,1.39-9.41,3.9l-26.12,26.12
                                            c-2.51,2.51-3.9,5.85-3.9,9.41C14.369,62.72,15.759,66.06,18.269,68.58z M280.849,353.05c11.07,11.07,23.02,21.04,35.74,29.88
                                            l60.97-60.97c-8.85-12.72-18.82-24.66-29.89-35.73L105.479,44.04l-66.82,66.82L280.849,353.05z M324.209,388.04
                                            c11.5,7.4,23.59,13.92,36.23,19.49l47.86,21.11l14.96-14.97l-21.1-47.85c-5.57-12.64-12.09-24.74-19.5-36.23L324.209,388.04z
                                            M431.959,441.53c1.12,1.12,3.08,1.11,4.2,0c0.56-0.56,0.87-1.31,0.87-2.1c0-0.79-0.31-1.54-0.87-2.1l-11.91-11.91l-4.2,4.19
                                            L431.959,441.53z M442.519,430.97c4.67,4.66,4.67,12.25,0,16.92c-2.33,2.33-5.4,3.5-8.46,3.5s-6.13-1.17-8.46-3.5l-11.91-11.91
                                            l-3.38,3.38l-53.5-23.59c-30.81-13.59-58.51-32.55-82.32-56.36l-255.81-255.8c-2.29-2.3-3.55-5.35-3.55-8.6
                                            c0-3.24,1.26-6.29,3.55-8.59l2.36-2.35l-9.13-9.13c-4.22-4.21-6.54-9.81-6.54-15.77s2.32-11.56,6.54-15.78l26.12-26.11
                                            c4.21-4.22,9.81-6.54,15.77-6.54s11.56,2.32,15.77,6.54l9.13,9.12l2.35-2.34c4.73-4.74,12.44-4.74,17.18,0l26.87,26.87
                                            l10.78-10.78l-33.79-33.79l6.37-6.36l173.59,173.6c10.05,10.04,24.41,14.56,38.4,12.07l1.57,8.86c-3.05,0.54-6.13,0.81-9.18,0.81
                                            c-13.81,0-27.22-5.45-37.15-15.38L142.239,46.51l-10.78,10.78l222.58,222.57c23.81,23.82,42.77,51.51,56.36,82.32l23.58,53.5
                                            l-3.37,3.37L442.519,430.97z M32.299,104.49l66.82-66.82l-7.25-7.25c-0.62-0.61-1.42-0.92-2.23-0.92c-0.81,0-1.61,0.31-2.23,0.92
                                            l-62.36,62.37c-0.6,0.59-0.92,1.38-0.92,2.22c0,0.85,0.32,1.64,0.92,2.23L32.299,104.49z"/>
                                        <path style="fill:#A7B6C4;" d="M382.659,329.59c7.41,11.49,13.93,23.59,19.5,36.23l21.1,47.85l-14.96,14.97l-47.86-21.11
                                            c-12.64-5.57-24.73-12.09-36.23-19.49L382.659,329.59z"/>
                                        <path style="fill:#4489D3;" d="M347.669,286.23c11.07,11.07,21.04,23.01,29.89,35.73l-60.97,60.97
                                            c-12.72-8.84-24.67-18.81-35.74-29.88L38.659,110.86l66.82-66.82L347.669,286.23z"/>
                                        <path style="fill:#A7B6C4;" d="M89.639,29.5c0.81,0,1.61,0.31,2.23,0.92l7.25,7.25l-66.82,66.82l-7.25-7.25
                                            c-0.6-0.59-0.92-1.38-0.92-2.23c0-0.84,0.32-1.63,0.92-2.22l62.36-62.37C88.029,29.81,88.829,29.5,89.639,29.5z"/>
                                        <path style="fill:#4489D3;" d="M44.389,23.64c2.51-2.51,5.85-3.9,9.41-3.9c3.55,0,6.9,1.39,9.41,3.9l9.13,9.13l-44.94,44.94
                                            l-9.13-9.13c-2.51-2.52-3.9-5.86-3.9-9.41c0-3.56,1.39-6.9,3.9-9.41L44.389,23.64z"/>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        เพิ่มข้อมูลสิ้นค้า
                    </a>
                </div>
                <div class="flex items-center justify-start text-black dark:text-white text-sm hover:bg-gray-100 dark:hover:bg-[#404040] cursor-pointer">
                    <a
                        type="button"
                        class="font-bold text-black dark:text-white py-2 px-2 rounded-sm group"
                        data-twe-toggle="modal"
                        data-twe-target="#exampleModal"
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        onclick="modelCopy()"
                    >
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                            viewBox="0 0 512 512" xml:space="preserve">
                            <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
                                C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
                                c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
                                V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
                                V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
                            <g>
                                <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
                                <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
                            </g>
                            <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
                                c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
                            <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
                                />
                        </svg>
                        Copy ข้อมูลสิ้นค้า
                    </a>
                </div>
                <div class="flex items-center justify-start text-black dark:text-white text-sm hover:bg-gray-100 dark:hover:bg-[#404040] cursor-pointer">
                    <a href="{{ route('product_master.create_consumables') }}" class="text-black dark:text-white py-2 px-2 rounded-sm group">
                        <svg class="h-6 w-6 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 451.39 451.39" xml:space="preserve">
                            <g>
                                <g id="XMLID_28_">
                                    <g>
                                        <path style="fill:#FFFFFF;" d="M437.029,439.43c0,0.79-0.31,1.54-0.87,2.1c-1.12,1.11-3.08,1.12-4.2,0l-11.91-11.92l4.2-4.19
                                            l11.91,11.91C436.719,437.89,437.029,438.64,437.029,439.43z"/>
                                        <path d="M18.269,68.58l9.13,9.13l44.94-44.94l-9.13-9.13c-2.51-2.51-5.86-3.9-9.41-3.9c-3.56,0-6.9,1.39-9.41,3.9l-26.12,26.12
                                            c-2.51,2.51-3.9,5.85-3.9,9.41C14.369,62.72,15.759,66.06,18.269,68.58z M280.849,353.05c11.07,11.07,23.02,21.04,35.74,29.88
                                            l60.97-60.97c-8.85-12.72-18.82-24.66-29.89-35.73L105.479,44.04l-66.82,66.82L280.849,353.05z M324.209,388.04
                                            c11.5,7.4,23.59,13.92,36.23,19.49l47.86,21.11l14.96-14.97l-21.1-47.85c-5.57-12.64-12.09-24.74-19.5-36.23L324.209,388.04z
                                            M431.959,441.53c1.12,1.12,3.08,1.11,4.2,0c0.56-0.56,0.87-1.31,0.87-2.1c0-0.79-0.31-1.54-0.87-2.1l-11.91-11.91l-4.2,4.19
                                            L431.959,441.53z M442.519,430.97c4.67,4.66,4.67,12.25,0,16.92c-2.33,2.33-5.4,3.5-8.46,3.5s-6.13-1.17-8.46-3.5l-11.91-11.91
                                            l-3.38,3.38l-53.5-23.59c-30.81-13.59-58.51-32.55-82.32-56.36l-255.81-255.8c-2.29-2.3-3.55-5.35-3.55-8.6
                                            c0-3.24,1.26-6.29,3.55-8.59l2.36-2.35l-9.13-9.13c-4.22-4.21-6.54-9.81-6.54-15.77s2.32-11.56,6.54-15.78l26.12-26.11
                                            c4.21-4.22,9.81-6.54,15.77-6.54s11.56,2.32,15.77,6.54l9.13,9.12l2.35-2.34c4.73-4.74,12.44-4.74,17.18,0l26.87,26.87
                                            l10.78-10.78l-33.79-33.79l6.37-6.36l173.59,173.6c10.05,10.04,24.41,14.56,38.4,12.07l1.57,8.86c-3.05,0.54-6.13,0.81-9.18,0.81
                                            c-13.81,0-27.22-5.45-37.15-15.38L142.239,46.51l-10.78,10.78l222.58,222.57c23.81,23.82,42.77,51.51,56.36,82.32l23.58,53.5
                                            l-3.37,3.37L442.519,430.97z M32.299,104.49l66.82-66.82l-7.25-7.25c-0.62-0.61-1.42-0.92-2.23-0.92c-0.81,0-1.61,0.31-2.23,0.92
                                            l-62.36,62.37c-0.6,0.59-0.92,1.38-0.92,2.22c0,0.85,0.32,1.64,0.92,2.23L32.299,104.49z"/>
                                        <path style="fill:#A7B6C4;" d="M382.659,329.59c7.41,11.49,13.93,23.59,19.5,36.23l21.1,47.85l-14.96,14.97l-47.86-21.11
                                            c-12.64-5.57-24.73-12.09-36.23-19.49L382.659,329.59z"/>
                                        <path style="fill:#4489D3;" d="M347.669,286.23c11.07,11.07,21.04,23.01,29.89,35.73l-60.97,60.97
                                            c-12.72-8.84-24.67-18.81-35.74-29.88L38.659,110.86l66.82-66.82L347.669,286.23z"/>
                                        <path style="fill:#A7B6C4;" d="M89.639,29.5c0.81,0,1.61,0.31,2.23,0.92l7.25,7.25l-66.82,66.82l-7.25-7.25
                                            c-0.6-0.59-0.92-1.38-0.92-2.23c0-0.84,0.32-1.63,0.92-2.22l62.36-62.37C88.029,29.81,88.829,29.5,89.639,29.5z"/>
                                        <path style="fill:#4489D3;" d="M44.389,23.64c2.51-2.51,5.85-3.9,9.41-3.9c3.55,0,6.9,1.39,9.41,3.9l9.13,9.13l-44.94,44.94
                                            l-9.13-9.13c-2.51-2.52-3.9-5.86-3.9-9.41c0-3.56,1.39-6.9,3.9-9.41L44.389,23.64z"/>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        เพิ่มวัสดุสิ้นเปลือง
                    </a>
                </div>
                <div class="flex items-center justify-start text-black dark:text-white text-sm hover:bg-gray-100 dark:hover:bg-[#404040] cursor-pointer">
                    <a
                        type="button"
                        class="font-bold text-black dark:text-white py-2 px-2 rounded-sm group"
                        data-twe-toggle="modal"
                        data-twe-target="#exampleModalCopy"
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        onclick="modelCopyConsumables()"
                    >
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                            viewBox="0 0 512 512" xml:space="preserve">
                            <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
                                C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
                                c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
                                V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
                                V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
                            <g>
                                <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
                                <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
                            </g>
                            <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
                                c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
                            <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
                                />
                        </svg>
                        Copy วัสดุสิ้นเปลือง
                    </a>
                </div>
            </div>
        </div> -->

        <!-- <div class="flex right-12 z-10 absolute">
            <a href="{{ route('product_master.create') }}" type="button" class="mt-1 mr-1 px-3 py-2 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group" name="add" id="add">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
            </a>
            <a
                type="button"
                class="mt-1 mr-1 px-3 py-2 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group cursor-pointer"
                data-twe-toggle="modal"
                data-twe-target="#exampleModal"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                onclick="modelCopy()"
            >
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                        viewBox="0 0 512 512" xml:space="preserve">
                    <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
                        C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
                        c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
                        V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
                        V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
                    <g>
                        <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
                        <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
                    </g>
                    <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
                        c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
                    <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
                        />
                </svg>
                Copy
            </a>
        </div> -->
        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>แบรนด์</th>
                            <th>สินค้าของบริษัท</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื้อสินค้า</th>
                            <th>Barcode</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tw-elements/1.0.0-alpha.6/tw-elements.min.js"></script> -->

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
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
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    @if (session('status'))
        <script>
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
            jQuery().ready(function () {
                toastr.success('{{ session('status') }}');
            });
        </script>
    @endif
    <script>

        // $(document).ready(function () {
        //     $('#fetchDataBtn').click(function () {
        //         fetch('https://ins.schicher.com/api/users', {
        //             method: 'GET',  // Or 'POST' if the API requires it
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //         })
        //         .then(response => response.json()) // Assuming the API returns JSON
        //         .then(data => {
        //             $('#responseData').html(`<p>Response from API:</p><pre>${JSON.stringify(data, null, 2)}</pre>`);
        //         })
        //         .catch(error => console.error('Error:', error));
        //     });
        // });

        // data: {
        //     start_year: '1970',
        //     end_year: '2020',
        //     min_imdb: '6',
        //     max_imdb: '7.8',
        //     genre: 'action',
        //     language: 'english',
        //     type: 'movie',
        //     sort: 'latest',
        //     page: page
        // },

        //         pageData.forEach(item => {
        //             const card = `
        //                 <div class="bg-[#eaeaea] p-4 cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">

        //                     <h2 class="text-xl font-bold mb-2">${item.name || 'Unknown School'}</h2>
        //                     <p>Balance: ${item.role || 'N/A'}</p>
        //                     <p>Updated: ${item.status || 'N/A'}</p>

        //                 </div>`;
        //             $('#cards-container').append(card);
        //         });

        // $(document).ready(function () {
        //     let currentPage = 1;
        //     const cardsPerPage = 9;
        //     let allData = [];

        //     function fetchData() {
        //         fetch('https://ott-details.p.rapidapi.com/advancedsearch', {
        //             method: "GET",
        //             headers: {
        //                 'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
        //                 'X-RapidAPI-Host': 'ott-details.p.rapidapi.com'
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             allData = data.results;
        //             renderCards(currentPage);
        //             renderPagination();
        //         })
        //         .catch(error => console.error('Error:', error));
        //     }
            
        //     function renderCards(page) {
        //         console.log("🚀 ~ fetchData ~ allData:", allData)
        //         $('#cards-container').empty();
        //         const start = (page - 1) * cardsPerPage;
        //         const end = start + cardsPerPage;
        //         const pageData = allData.slice(start, end);

        //         pageData.forEach(item => {
        //             const card = `
        //                 <div class="bg-[#eaeaea] p-4 cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">
        //                     <img class="w-20 h-20 rounded-md mx-auto" src="${item.imageurl}" alt="${item.title || 'Unknown'}">
        //                     <div class="text-center mt-4">
        //                         <h2 class="text-xl font-bold mb-2">${item.title || 'Unknown School'}</h2>
        //                     </div>

        //                 </div>`;
        //             $('#cards-container').append(card);
        //         });

        //         updatePaginationControls();
        //     }

        //     function renderPagination() {
        //         $('#pagination-numbers').empty();
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         const maxVisiblePages = 5; // You can adjust this value

        //         function addPageButton(page, isActive = false) {
        //             const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
        //             $('#pagination-numbers').append(pageButton);
        //         }

        //         if (totalPages <= maxVisiblePages) {
        //             // If total pages are less than max visible pages, show all
        //             for (let i = 1; i <= totalPages; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }
        //         } else {
        //             // Show first page
        //             addPageButton(1, currentPage === 1);

        //             // Show an ellipsis if currentPage is far from the first page
        //             if (currentPage > 3) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show pages around the current page
        //             let startPage = Math.max(2, currentPage - 1);
        //             let endPage = Math.min(currentPage + 1, totalPages - 1);

        //             for (let i = startPage; i <= endPage; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }

        //             // Show an ellipsis if currentPage is far from the last page
        //             if (currentPage < totalPages - 2) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show last page
        //             addPageButton(totalPages, currentPage === totalPages);
        //         }

        //         // Add event listeners to page buttons
        //         $('#pagination-numbers button').click(function () {
        //             const page = $(this).data('page');
        //             currentPage = page;
        //             renderCards(currentPage);
        //             renderPagination();
        //         });
        //     }

        //     function updatePaginationControls() {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         $('#prev-btn').prop('disabled', currentPage === 1);
        //         $('#next-btn').prop('disabled', currentPage === totalPages);
        //     }

        //     $('#prev-btn').click(function () {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     $('#next-btn').click(function () {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         if (currentPage < totalPages) {
        //             currentPage++;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     fetchData();
        // });

        // getParmeterLogin()
        // function getParmeterLogin() {
        //     let dataLogin = sessionStorage.getItem("credetail");
        //     let dataJson = JSON.parse(dataLogin)
        //     console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        //     if ( dataJson.data.roles == "Superadmin") {
        //         $('#create_product').append(
        //             `<div class="fixed flex bottom-5 right-5 z-10">
        //                 <a href="{{ route('product_master.create') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-2 mr-2 mt-20 rounded-full group">
        //                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
        //                         <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        //                     </svg>
        //                 </a>
        //             </div>
        //             `
        //         );
        //     } else {
        //         $('#create_product').append(``)
        //     }
        // }

        function changeLanguage(language) {
            var element = document.getElementById("url");
            element.value = language;
            element.innerHTML = language;
        }

        function showDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            // console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
        const channel = pusher.subscribe('public');

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

        const mytableDatatable = $('#example').DataTable({
            // new DataTable('#example', {
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 20, 30, 50],
            "layout": {
                "topStart": {
                    "buttons": ['excel', 'colvis']
                    // buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('product_master.list_products') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.BARCODE = $('#BARCODE').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BRAND;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.GRP_P;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.PRODUCT;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_THAI;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BARCODE;
                    }
                },
                {
                    targets: 5,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let disabledRoute = "{{route('product_master.update', 0)}}".replace('/0', "/" + row.PRODUCT)
                        let text = "#"
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('product_master.edit', 0)}}"
                                            type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                `.replaceAll('/0', "/" + row.PRODUCT);

                    }
                }
            ]
        });

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            return false;
        });

        function modelCopy(id, name_position) {
            jQuery("#data_coppy").val('').change();
            jQuery("#NUMBER").val('').change();
            jQuery("#BARCODE").val('');
        }

        jQuery('#username_loading').hide();
        jQuery("#username_alert").hide();
        jQuery("#correct_username").hide();

        function barcodeChange(e, params) {
            // console.log("🚀 ~ barcodeChange ~ e:", e.value)
            let PRODUCT = e.value;
            // console.log("🚀 ~ barcodeChange ~ product:", PRODUCT)

            if (params === 'BARCODE') {
                url = '{{ route('product_master.get_barcode') }}?BARCODE=' + e.value;
            }
            jQuery.ajax({
                method: "GET",
                url,
                dataType: 'json',
                success: function (data) {
                    if (e.value) {
                        jQuery("#BARCODE").val(data.productCodes.BARCODE);
                    } else {
                        jQuery("#BARCODE").val('');
                    }
                },
                error: function (params) {
                    console.log('ajax error ::', params);
                }
            });
            jQuery.ajax({
                method: "GET",
                url: '{{ route('product_master.checkproduct') }}',
                data: { PRODUCT },
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

                    if (PRODUCT == '') {
                        jQuery("#submitButton").attr("disabled", true);
                        jQuery("#submitButton").addClass('cursor-not-allowed opacity-50');
                        jQuery("#correct_username").hide();
                        jQuery("#username_alert").hide();
                        jQuery("#NUMBER").removeClass("is-invalid");
                    } else if (checknamebrand == true) {
                        jQuery("#submitButton").attr("disabled", false);
                        jQuery("#submitButton").removeClass('cursor-not-allowed opacity-50');
                        jQuery("#username_alert").hide();
                        jQuery("#NUMBER").removeClass("is-invalid");
                        jQuery("#correct_username").show();
                    } else {
                        jQuery("#submitButton").addClass('cursor-not-allowed opacity-50');
                        jQuery("#username_alert").show();
                        jQuery("#NUMBER").addClass("is-invalid");
                        jQuery("#correct_username").hide();
                    }
                },
                error: function (params) {
                }
            });
        }

        const dlayMessage = 100;
        function createCopy() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
                jQuery.ajax({
                    method: "POST",
                    url: "{{ route('product_master.create_copy') }}",
                    data: $("#form_copy").serialize(),
                    beforeSend: function () {
                        $('#loader_create_menu').removeClass('hidden')
                    },
                    success: function(res){
                        if(res.success == true) {
                            setTimeout(function() {
                                successMessage("Success!");
                            },dlayMessage)
                            setTimeout(function() {
                                toastr.success("Create menu successfully!");
                            },dlayMessage)
                            mytableDatatable.draw();
                        }
                        else if (res.status == 'fail') {
                            setTimeout(function() {
                                errorMessage("Error!");
                            },dlayMessage)
                            setTimeout(function() {
                                toastr.error("Can't create menu!");
                            },dlayMessage)
                        }
                    },
                    error: function(error) {
                    }
                });
        }

        function successMessage(text) {
            $('#loader_create_menu').addClass('hidden');
            $('#exampleModal').hide('');
            $('.w-screen').hide('');
            $('#data_coppy').val('').change();
            $("#NUMBER").val('').change();
            $("#BARCODE").val('')
        }
        function errorMessage(text) {
            $('#loader_create_menu').addClass('hidden');
            $('#data_coppy').val('').change();
            $("#NUMBER").val('').change();
            $("#BARCODE").val('')
        }

        let menusAuthPosition = <?php echo json_encode($productCodeArr); ?>;
        let codeOptionList = {}
        menusAuthPosition.forEach( function(f) {
            codeOptionList[f] = f
        })

        let barcodeConsumables = {}
        // console.log("🚀 ~ barcodeConsumables:", barcodeConsumables)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-placeholder-single').select2({
                placeholder: "--- กรุณาเลือก ---",
                allowClear: true
            }).on('change', function(e) {
                barcodeConsumables = $(".select2 option:selected").text();
                // console.log("🚀 ~ $ ~ barcodeConsumables:", barcodeConsumables)
                $("#PRODUCT_Consumables").val(barcodeConsumables);
            });
        });

        function modelCopyConsumables(id, name_position) {
            jQuery("#data_coppy_consumables").val('').change();
            jQuery("#PRODUCT_Consumables").val('');
        }

        jQuery('#username_loading_consumables').hide();
        jQuery("#correct_username_consumables").hide();
        jQuery("#username_alert_consumables").hide();

        function barcodeConsumablesChange() {
            let PRODUCT_Consumables = $("#PRODUCT_Consumables").val()
            if (PRODUCT_Consumables.length > 6) {
                jQuery.ajax({
                    method: "GET",
                    url: '{{ route('product_master.checkproduct_consumables') }}',
                    data: { PRODUCT_Consumables },
                    dataType: 'json',
                    beforeSend: function () {
                        jQuery("#submitButtonConsumables").attr("disabled", true);
                        jQuery('#username_loading_consumables').show();
                        jQuery("#correct_username_consumables").hide();
                        jQuery("#username_alert_consumables").hide();
                    },
                    success: function (checkProductConsumables) {
                        jQuery('#username_loading_consumables').hide();
                        jQuery("#correct_username_consumables").hide();

                        if (PRODUCT_Consumables == '') {
                            jQuery("#submitButtonConsumables").attr("disabled", true);
                            jQuery("#submitButtonConsumables").addClass('cursor-not-allowed opacity-50');
                            jQuery("#correct_username_consumables").hide();
                            jQuery("#username_alert_consumables").hide();
                            jQuery("#PRODUCT_Consumables").removeClass("is-invalid");
                        } else if (checkProductConsumables == true) {
                            jQuery("#submitButtonConsumables").attr("disabled", false);
                            jQuery("#submitButtonConsumables").removeClass('cursor-not-allowed opacity-50');
                            jQuery("#username_alert_consumables").hide();
                            jQuery("#PRODUCT_Consumables").removeClass("is-invalid");
                            jQuery("#correct_username_consumables").show();
                        } else {
                            jQuery("#submitButtonConsumables").addClass('cursor-not-allowed opacity-50');
                            jQuery("#username_alert_consumables").show();
                            jQuery("#PRODUCT_Consumables").addClass("is-invalid");
                            jQuery("#correct_username_consumables").hide();
                        }
                    },
                    error: function (params) {
                    }
                });
            } else {
                jQuery("#submitButtonConsumables").attr("disabled", true);
                jQuery("#submitButtonConsumables").addClass('cursor-not-allowed opacity-50');
                jQuery("#PRODUCT_Consumables").addClass("is-invalid");
                jQuery("#username_alert_consumables").hide();
                jQuery("#correct_username_consumables").hide();
            }
        }

        function createCopyConsumables() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
                jQuery.ajax({
                    method: "POST",
                    url: "{{ route('product_master.create_copy_consumables') }}",
                    data: $("#form_copy_consumables").serialize(),
                    beforeSend: function () {
                        $('#loader_create_menu_consumables').removeClass('hidden')
                    },
                    success: function(res){
                        // $('#exampleModalLg').hide('');
                        // $('.w-screen').remove('');
                        // console.log("🚀 ~ createCopyConsumables ~ res:", res)
                        if(res.success == true) {
                            setTimeout(function() {
                                successMessageConsumables("Success!");
                            },dlayMessage)
                            setTimeout(function() {
                                toastr.success("Copy data successfully!");
                            },dlayMessage)
                            mytableDatatable.draw();
                        }
                        else if (res.status == 'fail') {
                            setTimeout(function() {
                                errorMessageConsumables("Error!");
                            },dlayMessage)
                            setTimeout(function() {
                                toastr.error("Can't Copy data!");
                            },dlayMessage)
                        }
                        $('#loader_create_menu_consumables').addClass('hidden');
                    },
                    error: function(error) {
                        $('#loader_create_menu_consumables').addClass('hidden');
                    }
                });

        }

        function successMessageConsumables(text) {
            $('#loader_create_menu_consumables').addClass('hidden');
            // $('#exampleModalCopy').remove('');
            // $('#exampleModalCopy').hide('');
            // $('.w-screen').remove('');
            $("#data_coppy_consumables").val('').change();
            $("#PRODUCT_Consumables").val('')

        }
        function errorMessageConsumables(text) {
            $('#loader_create_menu_consumables').addClass('hidden');
            $("#data_coppy_consumables").val('').change();
            $('#data_coppy').val('').change();
            $("#PRODUCT_Consumables").val('')
        }

        function disableAppointment(url, e, id, PRODUCT) {
            const mytableDatatable = $('#example').DataTable();
            (async () => {
                const { value: fruit } = await Swal.fire({
                    title: "<h5 style='color:red'>" + PRODUCT + "</h5>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#303030',
                    cancelButtonColor: '#e13636',
                    confirmButtonText: `
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                        </svg>
                        Save
                    `,
                    cancelButtonText: `Cancel`,
                    color: "#ffffff",
                    input: 'select',
                    // didOpen: function () {
                    //     $(".js-example-basic-single").select2({
                    //         minimumResultsForSearch: 15,
                    //         width: '100%',
                    //         placeholder: "Seleziona",
                    //         language: "it"
                    //     });
                    // },
                    background: "#202020",
                    inputOptions: codeOptionList,
                    inputPlaceholder: '--- กรุณาเลือก ---',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value === 'oranges') {
                                resolve()
                            } else {
                                resolve('You need to select oranges :)')
                            }
                        })
                    },
                })
                if (fruit) {
                    Swal.fire('You selected: ' + fruit)
                }
            })().then(result => {
                // console.log("🚀 ~ disableAppointment ~ result:", result)
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        beforeSend: function() {
                            $(e).parent().parent().addClass('d-none');
                        },
                        success: function (params) {
                            if(params.success){
                                Swal.fire({
                                    title:'เพิ่มข้อมูลเรียบร้อย',
                                    text:'',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                mytableDatatable.draw();
                            }
                            else{
                                Swal.fire({
                                    title:'บันทึกข้อมูลไม่สำเร็จ',
                                    text:'',
                                    icon:'error',
                                });
                                $(e).parent().parent().removeClass('d-none');
                            }
                        },
                        error: function(er){
                            Swal.fire({
                                title:'บันทึกข้อมูลไม่สำเร็จ',
                                text:'',
                                icon:'error',
                            });
                            $(e).parent().parent().removeClass('d-none');
                        }
                    });
                }
            });
        }

        // <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}', '${row.PRODUCT}')"
        //     type="button" class="px-1 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group cursor-pointer">
        //     <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
        //             viewBox="0 0 512 512" xml:space="preserve">
        //         <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
        //             C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
        //             c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
        //             V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
        //             V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
        //         <g>
        //             <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
        //             <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
        //         </g>
        //         <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
        //             c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
        //         <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
        //             />
        //     </svg>
        //     Copy
        // </a>

        // function disableAppointment(url, e, id) {
        //     const mytableDatatable = $('#example').DataTable();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#303030',
        //         cancelButtonColor: '#e13636',
        //         confirmButtonText: `
        //             <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
        //                 <path d="M0 0h24v24H0V0z" fill="none"></path>
        //                 <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
        //                 <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
        //             </svg>
        //             Save
        //         `,
        //         cancelButtonText: `Cancel`,
        //         color: "#ffffff",
        //         background: "#202020",

        //     }).then(result => {
        //         console.log("🚀 ~ disableAppointment ~ result:", result)
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url:"/broadcast",
        //                 method:'POST',
        //                 headers:{
        //                     'X-Socket-Id': pusher.connection.socket_id
        //                 },
        //                 data:{
        //                     _token:  '{{csrf_token()}}',
        //                     message: 'update notify'
        //                 }
        //                 }).done(function (res) {
        //                     console.log("🚀 ~ $ ~ res:", res)
        //             });
        //             $.ajax({
        //                 type: "DELETE",
        //                 url: url,
        //                 beforeSend: function() {
        //                     $(e).parent().parent().addClass('d-none');
        //                 },
        //                 success: function (params) {
        //                     if(params.success){
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลเรียบร้อย',
        //                             text:'',
        //                             icon:'success',
        //                             showConfirmButton: false,
        //                             timer: 1500
        //                         });
        //                         mytableDatatable.draw();
        //                     }
        //                     else{
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                             text:'',
        //                             icon:'error',
        //                         });
        //                         $(e).parent().parent().removeClass('d-none');
        //                     }
        //                 },
        //                 error: function(er){
        //                     Swal.fire({
        //                         title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                         text:'',
        //                         icon:'error',
        //                     });
        //                     $(e).parent().parent().removeClass('d-none');
        //                 }
        //             });
        //         }
        //     });
        // }
    </script>
@endsection