@extends('layouts.layout')
@section('title', 'Inspection & deteils')

    <style>
        .loading_create_menu_consumables {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
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
        span.dt-column-order {
            display: none;
        }
        .dt-length  {
            /* color: #FFFFFF!important; */
            color: #818181!important;
        }
        .table td, .table th {
            padding: 0.55rem !important;
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
        .select2-container {
            margin-bottom: 0rem!important;
        }
        .select2-container--default .select2-selection--single {
            height: 2rem!important;
            border-width: 1px;
            padding: 0.1rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            position: absolute;
            margin-top: -5px!important;
        }
        .h-10 {
            height: 2rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: small!important;
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
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-5 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">SUB CATEGORY</p>
        </div>

        <div class="flex xs:right-12 sm:right-12 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-3">
            <a
                type="button"
                class="xs:mt-0 sm:mt-0 md:mt-2 lg:mt-2 xl:mt-2 -mr-4 px-1.5 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer group"
                data-twe-toggle="modal"
                data-twe-target="#staticBackdrop"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                onclick="modelProductGroup()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
             </a>

            <!-- <a href="{{ route('new_product_develop.create') }}" type="button" class="mt-2 px-3 py-1.5 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group" name="add" id="add">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
            </a> -->
        </div>

        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="staticBackdrop"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="staticBackdropLabel"></h5>
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
                    <form id="form_product_group" class="" method="POST">
                        <input class="" type="hidden" id="Edit_SubCategory_ID" name="ID" value="">
                        <div class="p-4 lg:col-span-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-6">
                                    <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">รหัส Category - Name Category</label>
                                    <select class="js-example-basic-single w-full rounded-sm text-xs text-center CATEGORY_ID" id="CATEGORY_ID" name="CATEGORY_ID">
                                        <option class="" value=""> --- กรุณาเลือก ---</option>
                                        @foreach ($dataCategories as $dataCategorie)
                                            <option value="{{ $dataCategorie['ID'] }}">{{ $dataCategorie['DESCRIPTION'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 text-gray-900 dark:text-gray-100" style="position: relative;">
                            <label for="ID">ID</label>
                            <input type="text" id="ID" name="SubCategory_ID" onkeyup="checkSubCategoryId()" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                            <div class="col-auto" style="position: absolute; right: 2.5%; top: 30%;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" id="username_loading_id" style="margin-right: -2.5px;" class="w-6 h-6 animate-spin -mt-1">
                                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                </svg>
                                <svg id="correct_username_id" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                                <svg id="username_aler_id" style="margin-right: 2.5px;" class="w-4 h-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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

                            <label for="DESCRIPTION" class="mt-7">Description</label>
                            <input type="text" id="DESCRIPTION" name="DESCRIPTION" onkeyup="subCategoryCheckName(this)" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                            <div class="col-auto" style="position: absolute; right: 2.5%; top: 78.2%;">
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

                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <button data-twe-modal-dismiss id="submitButton" type="button" class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded group cursor-not-allowed opacity-50" onclick="updateOrCreateSubCategory()" disabled>
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

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="table_sub_category" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>CATEGORY_ID </th>
                            <th>SUBCATEGORY_ID</th>
                            <th>Drescription</th>
                            <th>Brand</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <th>
                            </th>
                            <th>
                                <select class="js-example-basic-single w-full rounded-sm text-xs" id="searchSubCategoryId" name="" onchange="subCategorySearch()">
                                    <option value="" class="text-xs"> --- กรุณาเลือก ---</option>
                                    @foreach ($SubCategories as $key => $SubCategorie)
                                        <option value="{{ $SubCategorie }}">{{ $SubCategorie }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <input type="text" name="" id="searchSubCategoryName" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="ชื่อสินค้า . . ." value="" onkeyup="searchTable()" />
                            </th>
                            <th>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

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

        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });

        jQuery('#username_loading_id, #username_loading').hide();
        jQuery("#username_aler_id, #username_alert").hide();
        jQuery("#correct_username_id, #correct_username").hide();

        let isValidCategory = false; // ✅ เพิ่มตัวแปรตรวจสอบ CATEGORY_ID
        let isValidID = false;
        let isValidDescription = false;

        function updateSaveButtonState() {
            if (isValidID && isValidDescription && isValidCategory) {
                jQuery("#submitButton").attr("disabled", false).removeClass('cursor-not-allowed opacity-50');
            } else {
                jQuery("#submitButton").attr("disabled", true).addClass('cursor-not-allowed opacity-50');
            }
        }

        function checkSubCategoryId() {
            const Edit_SubCategory_ID = jQuery('#Edit_SubCategory_ID').val();
            const ID = jQuery('#ID').val();

            jQuery.ajax({
                method: "POST",
                url: "{{ route('product_master.sub_category_check_id') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    Edit_SubCategory_ID, ID
                },
                dataType: 'json',
                beforeSend: function () {
                    isValidID = false;
                    updateSaveButtonState();
                    jQuery('#username_loading_id').show();
                    jQuery("#correct_username_id, #username_aler_id").hide();
                },
                success: function (response) {
                    jQuery('#username_loading_id').hide();

                    if (ID === '') {
                        isValidID = false;
                        jQuery("#correct_username_id, #username_aler_id").hide();
                    } else if (response === true) {
                        isValidID = true;
                        jQuery("#correct_username_id").show();
                        jQuery("#username_aler_id").hide();
                    } else {
                        isValidID = false;
                        jQuery("#username_aler_id").show();
                        jQuery("#correct_username_id").hide();
                    }
                    updateSaveButtonState();
                }
            });
        }

        function subCategoryCheckName() {
            const Edit_SubCategory_ID = jQuery('#Edit_SubCategory_ID').val();
            const DESCRIPTION = jQuery('#DESCRIPTION').val();

            jQuery.ajax({
                method: "POST",
                url: "{{ route('product_master.sub_category_checkname') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    Edit_SubCategory_ID, DESCRIPTION
                },
                dataType: 'json',
                beforeSend: function () {
                    isValidDescription = false;
                    updateSaveButtonState();
                    jQuery('#username_loading').show();
                    jQuery("#correct_username, #username_alert").hide();
                },
                success: function (response) {
                    jQuery('#username_loading').hide();

                    if (DESCRIPTION === '') {
                        isValidDescription = false;
                        jQuery("#correct_username, #username_alert").hide();
                    } else if (response === true) {
                        isValidDescription = true;
                        jQuery("#correct_username").show();
                        jQuery("#username_alert").hide();
                    } else {
                        isValidDescription = false;
                        jQuery("#username_alert").show();
                        jQuery("#correct_username").hide();
                    }
                    updateSaveButtonState();
                }
            });
        }

        // ✅ ฟังก์ชันตรวจสอบ CATEGORY_ID
        function checkCategorySelection() {
            const CATEGORY_ID = jQuery("#CATEGORY_ID").val();
            if (CATEGORY_ID !== "") {
                isValidCategory = true;
            } else {
                isValidCategory = false;
            }
            updateSaveButtonState();
        }

        // ✅ ผูก event ตรวจสอบ CATEGORY_ID เมื่อมีการเปลี่ยนค่า
        jQuery("#CATEGORY_ID").on("change", checkCategorySelection);
        // ✅ ผูก event กับ input fields
        jQuery("#ID").on("keyup", checkSubCategoryId);
        jQuery("#DESCRIPTION").on("keyup", subCategoryCheckName);

        jQuery("#CATEGORY_ID option").each(function() {
            // console.log("option value:", '"' + jQuery(this).val() + '"', "text:", '"' + jQuery(this).text() + '"');
        });
        // setTimeout(function() {
        //     console.log("🔎 ค่าใน <option> ทั้งหมด (หลังหน่วงเวลา):");
        //     jQuery("#CATEGORY_ID option").each(function() {
        //         // console.log("option value:", '"' + jQuery(this).val() + '"');
        //     });
        // }, 1000); // รอ 1 วินาที

        jQuery("#CATEGORY_ID").on("change", function() {
            let oldValue = jQuery(this).data("previous");
            let newValue = jQuery(this).val();
            // console.log(`🔁 ค่าเปลี่ยนจาก "${oldValue}" เป็น "${newValue}"`);
            // อัปเดตค่าเก่า
            jQuery(this).data("previous", newValue);
        });

        function modelProductGroup(ID, CATEGORY_ID, DESCRIPTION) {
            console.log("🚀 เปิด Modal Edit ~ ID:", ID, CATEGORY_ID, DESCRIPTION);

            if (ID) {
                jQuery("#Edit_SubCategory_ID").val(ID);
                // ✅ รีเซ็ตตัวแปรสถานะของปุ่ม Save
                isValidID = true;  
                isValidDescription = true;
                isValidCategory = CATEGORY_ID !== ""; // ถ้า CATEGORY_ID มีค่า ถือว่าถูกต้อง
                // ✅ หน่วงเวลาให้ Select2 โหลดค่าก่อน
                setTimeout(function () {
                    if (CATEGORY_ID) {
                        jQuery(".CATEGORY_ID").val(CATEGORY_ID).trigger("change");
                        console.log("✅ ตั้งค่า CATEGORY_ID:", $('.CATEGORY_ID').val());
                        // ✅ อัปเดตสถานะปุ่ม Save หลังจากตั้งค่า CATEGORY_ID
                        checkCategorySelection();
                    } else {
                        console.warn("⚠️ ไม่พบค่า CATEGORY_ID ใน <option>!");
                    }
                }, 300);
                jQuery("#ID").val(ID).attr("readonly", true).addClass('h-10 rounded-sm px-4 w-full text-center bg-[#E7E7E7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 cursor-not-allowed dark:bg-[#000000] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500');
                jQuery("#DESCRIPTION").val(DESCRIPTION);
                jQuery("#staticBackdropLabel").text('แก้ไข Sub Category');
                // ✅ อัปเดตปุ่ม Save ให้เช็คเงื่อนไขใหม่
                updateSaveButtonState();
                jQuery('#username_loading').hide();
                jQuery("#username_alert").hide();
                jQuery("#correct_username").hide();
                jQuery('#username_loading_id').hide();
                jQuery("#username_aler_id").hide();
                jQuery("#correct_username_id").hide();
            } else {
                jQuery("#Edit_SubCategory_ID").val('');
                // ✅ รีเซ็ตค่าของ Select2 (CATEGORY_ID)
                jQuery(".CATEGORY_ID").val("").trigger("change.select2");
                jQuery("#ID").val('').removeAttr("readonly").removeClass('bg-[#E7E7E7] border border-gray-900 text-blue-600 dark:text-blue-600 text-base font-semibold focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#000000] dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed opacity-50');
                jQuery("#DESCRIPTION").val('');
                jQuery("#staticBackdropLabel").text('เพิ่ม Sub Category');
                // ✅ รีเซ็ตตัวแปรสถานะของปุ่ม Save ให้เป็น false (เนื่องจากเป็น Create Modal)
                isValidID = false;
                isValidDescription = false;
                isValidCategory = false;
                updateSaveButtonState(); // ✅ อัปเดตปุ่ม Save ให้เป็น disabled

                jQuery("#submitButton").attr("disabled", true);
                jQuery("#submitButton").addClass('cursor-not-allowed opacity-50');

                jQuery('#username_loading').hide();
                jQuery("#username_alert").hide();
                jQuery("#correct_username").hide();
                jQuery('#username_loading_id').hide();
                jQuery("#username_aler_id").hide();
                jQuery("#correct_username_id").hide();
            }
        }

        const mytableDatatable = $('#table_sub_category').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "800px",
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('product_master.list_sub_category') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.searchSubCategoryId = $('#searchSubCategoryId').val();
                    data.searchSubCategoryName = $('#searchSubCategoryName').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.CATEGORY_ID || ''; // ถ้าเป็น undefined ให้เป็นค่าว่าง
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.ID;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.DESCRIPTION;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BRAND;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let text = "#"
                        return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                    <button
                                        data-twe-toggle="modal"
                                        data-twe-target="#staticBackdrop"
                                        data-twe-ripple-init
                                        data-twe-ripple-color="light"
                                        onclick="modelProductGroup('${row.ID || ''}', '${row.CATEGORY_ID || ''}', '${row.DESCRIPTION || ''}')"
                                        type="button"
                                        class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                            <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                            <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                </div>
                        `.replaceAll('/0', "/" + row.ID);

                    }
                }
            ]
        });

        // Function สำหรับเรียกใช้ DataTable เมื่อมีการพิมพ์
        function searchTable() {
            console.log("Search: ", $('#search').val());
            // บังคับให้ DataTables รีโหลดข้อมูลใหม่
            mytableDatatable.ajax.reload(null, false); 
        }

        function subCategorySearch() {
            mytableDatatable.draw();
        }

        const dlayMessage = 100;
        function updateOrCreateSubCategory() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            let url = ''
            const Edit_SubCategory_ID = jQuery('#Edit_SubCategory_ID').val();

            if(Edit_SubCategory_ID) {
                url = "{{ route('product_master.sub_category_update', 0) }}".replaceAll('/0', '/' + Edit_SubCategory_ID);
            } else {
                url = "{{ route('product_master.sub_category_create') }}"
            }

            jQuery.ajax({
                method: "POST",
                url,
                data: $("#form_product_group").serialize(),
                beforeSend: function () {
                    $('#loader_create_menu_consumables').removeClass('hidden')
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
                    $('#loader_create_menu_consumables').addClass('hidden');
                },
                error: function(error) {
                    $('#loader_create_menu_consumables').addClass('hidden');                   
                }
            });
        }

    </script>
@endsection
