@extends('layouts.layout')
@section('title', 'Menumanage')

    <style>
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #c9c9c9ed; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .loading_create_menu {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #c9c9c9ed; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        .highlight {
            background-color: #014a77;
        }
        #positionTable tbody tr:hover{
            cursor: pointer;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.list_manage_menu')</p>
        </div>

        @php
            $svgname_arr = [
                "NPD Request" => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6'>
                            <path d='M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z' />
                        </svg>",
                "ทะเบียนสินค้า" => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6'>
                            <path d='M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z' />
                        </svg>",
                "Marketing" => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6'>
                            <path d='M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z' />
                        </svg>",
                "Managemenu" => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-7 mt-1 ml-0.5 text-black dark:text-white'>
                            <path d='M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z' />
                            <path fill-rule='evenodd' d='M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z' clip-rule='evenodd' />
                        </svg>",
                "อื่นๆ" => "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' class='size-6'>
                            <path d='M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z' />
                        </svg>"
            ];
        @endphp

        <div id="logo-sidebar" class="w-[256px] border-r border-gray-200 md:translate-x-0 dark:border-gray-700 transition-all duration-500">
            <div class="px-3 pb-4 overflow-y-auto bg-white dark:bg-[#202020] duration-500">
                @foreach($menu_permissions as $menu)
                    <ul class="space-y-2 font-medium">
                        @if (!empty($menu['submenu_array'][0]))
                            <li class="relative w-[232px] overflow-hidden group mt-2">
                                <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer ">
                                <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">
                                    @if ( $menu['menu_name'] == 'NPD Request' || $menu['menu_name'] == 'ทะเบียนสินค้า' || $menu['menu_name'] == 'Marketing' || $menu['menu_name'] == 'Managemenu')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-1.5 ml-2 text-black dark:text-white">
                                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 mt-1.5 ml-2 text-black dark:text-white">
                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    <div class="bg-white dark:bg-[#202020] text-white h-10 w-full pl-2.5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                                        <h1 class="text-black dark:text-white text-md">
                                            {{ $menu['menu_name'] }}
                                        </h1>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @foreach($menu['submenu_array'] as $submenu)
                                    <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 h-fit after:absolute after:left-[1.20rem] after:top-[2.5rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-gray-700">
                                        <li>
                                            <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                                                {{ $submenu}}
                                            </a>
                                        </li>
                                    </ul>
                                @endforeach
                            </li>
                        @else
                            <li class="mt-2">
                                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group" href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-black dark:text-white">
                                        <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                    </svg>
                                    <span class="flex-1 ms-3 whitespace-nowrap dark:text-white">{{ $menu['menu_name'] }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </div>

        <!-- <div id="logo-sidebar" class="w-[256px] border-r border-gray-200 md:translate-x-0 dark:border-gray-700 transition-all duration-500">
            <div class="px-3 pb-4 overflow-y-auto bg-white dark:bg-[#202020] duration-500">
                @foreach($menus as $menu)
                    <ul class="space-y-2 font-medium">
                        @if (!empty($menu['getSubMenuLeft'][0]))
                            <li class="relative w-[232px] overflow-hidden group mt-2">
                                <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer ">
                                <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">
                                    @if ( $menu['menu_name'] == 'NPD Request' || $menu['menu_name'] == 'ทะเบียนสินค้า' || $menu['menu_name'] == 'Marketing' || $menu['menu_name'] == 'Managemenu')
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-1.5 ml-2 text-black dark:text-white">
                                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 mt-1.5 ml-2 text-black dark:text-white">
                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    <div class="bg-white dark:bg-[#202020] text-white h-10 w-full pl-2.5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                                        <h1 class="text-black dark:text-white text-md">
                                            {{ $menu['menu_name'] }}
                                        </h1>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @foreach($menu['getSubMenuLeft'] as $submenu)
                                    <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 h-fit after:absolute after:left-[1.20rem] after:top-[2.5rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-gray-700">
                                        <li>
                                            <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                                                {{ $submenu['name']}}
                                            </a>
                                        </li>
                                    </ul>
                                @endforeach
                            </li>
                        @else
                            <li class="mt-2">
                                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group" href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-black dark:text-white">
                                        <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                    </svg>
                                    <span class="flex-1 ms-3 whitespace-nowrap dark:text-white">{{ $menu['menu_name'] }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </div> -->

        <div class="fixed flex bottom-5 right-5 z-10">
            <a
                type="button"
                class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-2 mr-2 mt-20 rounded-full group"
                data-twe-toggle="modal"
                data-twe-target="#exampleModalLg"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                onclick="modelManageMenu()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="exampleModalLg"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="exampleModalLgLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-200 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLgLabel"></h5>
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
                                    d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <form id="form_menu" class="" method="POST">
                        <input class="" type="hidden" id="edit_id" name="edit_id" value="">
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="">ชื่อเมนู<span class="text-danger"> *</span></label>
                                    <input type="text" name="menu_name" id="menu_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                </div>
                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="">เมนู URL<span class="text-danger"> *</span></label>
                                    <input type="text" name="url" id="url_id" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" placeholder="EX. manage_menu" />
                                </div>
                            </div>
                            <table class="table table-sm table-bordered text-gray-900 dark:text-gray-100 mt-5 relative" id="table">
                                <tr>
                                    <th class="text-sm">ชื่อเมนูย่อย</th>
                                    <th class="text-sm">เมนูย่อย URL</th>
                                    <th class="text-sm text-center">Action</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="inputs_submenu[0][submenu_name]" id="inputs_submenu" class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                    </td>
                                    <td>
                                        <input type="text" name="inputs_submenu[0][submenu_url]" id="submenu_url_id" class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" placeholder="EX. manage_menu" />
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="mt-1 px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#303030] text-white rounded group" name="add" id="add">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <a class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createMenu()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                </svg>
                                Save
                            </a>
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
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="exampleModalLabel">
                            เพิ่มสิทธิ์
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
                    <div class=" p-4 text-gray-900 dark:text-gray-100">
                        <label for="name">ชื่อสิทธิ์</label>
                        <input type="text" id="menu_id" name="menu_name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />

                    </div>
                    <div class="p-2 ">
                        <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                    </div>
                    <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                        <a class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createRole()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            Save
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-10 mt-10">
            <div class="form col-span-2">
                <div class="relative w-full overflow-hidden">
                    <div class="fixed flex bottom-2 right-0 z-10 absolute">
                        <a
                            type="button"
                            class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-2 mr-2 mt-20 rounded-full group"
                            data-twe-toggle="modal"
                            data-twe-target="#staticBackdrop"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            onclick="modelManageRole()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            สิทธิ์เข้าถึงการใช้งาน
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0">
                        <div class="mt-8 flex justify-center items-center">
                            <form id="posForm" method="post">
                                <div class="table-responsive">
                                    <table id="positionTable" class="table table-bordered text-gray-900 dark:text-white cursor-pointer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">ID</th>
                                                <th>ชื่อสิทธิ์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($position as $pos_data)
                                                <tr id="pos_{{ $pos_data->id }}" onclick="setAccess({{  $pos_data->id  }})">
                                                    <td>{{ $pos_data->id }}</td>
                                                    <td>{{ $pos_data->name_position }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form col-span-3">
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            รายการเมนู
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="container table-responsive bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0 scrollme">
                        <form id="menuForm" method="post">
                            <div class="table-responsive">
                                <div class="table-responsive text-gray-900 dark:text-white">
                                    <table id="menuTable" class="mt-5 table table-bordered table-hover text-gray-900 dark:text-white cursor-pointer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>view</th>
                                                <th>create</th>
                                                <th>edit</th>
                                                <th>delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($menu_permissions as $menu)
                                                <tr class="main-menu">
                                                    <td class="flex relative">
                                                        <button
                                                            type="button"
                                                            class="px-2 py-1 left-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"
                                                            data-twe-toggle="modal"
                                                            data-twe-target="#exampleModalLg"
                                                            data-twe-ripple-init
                                                            data-twe-ripple-color="light"
                                                            onclick="modelManageMenu('{{ $menu->id }}', '{{ $menu->menu_name }}', {{ $menu }})"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                                            </svg>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">{{ $menu['id'] }}</td>
                                                    <td>{{ $menu['menu_name'] }}</td>
                                                    <td class="text-center"><input type="checkbox" id="action_view_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_create_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_edit_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_delete_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                </tr>
                                                @if (!empty($menu['submenu_array']))
                                                    @foreach($menu['submenu_array'] as $submenu)
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>&nbsp;&nbsp;&nbsp;{{ $submenu }}</td>
                                                            <td class="text-center"><input type="checkbox" id="action_view_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_create_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_edit_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_delete_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form col-span-3">
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            รายการเมนู
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="container table-responsive bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0 scrollme">
                        <form id="menuForm" method="post">
                            <div class="table-responsive">
                                <div class="table-responsive text-gray-900 dark:text-white">
                                    <table id="menuTable" class="mt-5 table table-bordered table-hover text-gray-900 dark:text-white cursor-pointer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>view</th>
                                                <th>create</th>
                                                <th>edit</th>
                                                <th>delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($menus as $menu)
                                                <tr class="main-menu">
                                                    <td class="flex relative">
                                                        <button
                                                            type="button"
                                                            class="px-2 py-1 left-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"
                                                            data-twe-toggle="modal"
                                                            data-twe-target="#exampleModalLg"
                                                            data-twe-ripple-init
                                                            data-twe-ripple-color="light"
                                                            onclick="modelManageMenu('{{ $menu->id }}', '{{ $menu->menu_name }}', {{ $menus3 }})"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                                            </svg>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">{{ $menu['id'] }}</td>
                                                    <td>{{ $menu['menu_name'] }}</td>
                                                    <td class="text-center"><input type="checkbox" id="action_view_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_create_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_edit_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" id="action_delete_{{ $menu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>

                                                </tr>
                                                @if (!empty( $menu['getMenuRelation'][0]['getSubMenu']))
                                                    @foreach($menu['getMenuRelation'][0]['getSubMenu'] as $submenu)
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>&nbsp;&nbsp;&nbsp;{{ $submenu['name'] }}</td>
                                                            <td class="text-center"><input type="checkbox" id="action_submenu_view_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $submenu['menu_relation_id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_submenu_create_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $submenu['menu_relation_id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_submenu_edit_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $submenu['menu_relation_id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" id="action_submenu_delete_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $submenu['menu_relation_id'] }}" onclick="setMenu(this)"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="form col-span-3 relative">
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            รายการเมนู
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div class="container table-responsive bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0 scrollme">
                        <form id="menuForm" method="post">
                            <div class="table-responsive">
                                <table id="" class="mt-4 table table-bordered table-hover text-gray-900 dark:text-white cursor-pointer" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 30px;">Action</th>
                                            <th class="text-center" style="width: 30px">ID</th>
                                            <th class="text-center">ชื่อเมนู</th>
                                            <th class="text-center" style="width: 70px;">
                                                view
                                            </th>
                                            <th class="text-center" style="width: 70px;">
                                                create
                                            </th>
                                            <th class="text-center" style="width: 70px;">
                                                edit
                                            </th>
                                            <th class="text-center" style="width: 70px;">
                                                delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menus as $menu_data)
                                            <tr>
                                                <td class="flex relative">
                                                    <button
                                                        type="button"
                                                        class="px-2 py-1 left-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"
                                                        data-twe-toggle="modal"
                                                        data-twe-target="#exampleModalLg"
                                                        data-twe-ripple-init
                                                        data-twe-ripple-color="light"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                            <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                            <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group"
                                                        onclick="disableAppointment('${disabledRoute}',this,'${row.id}')"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li class="relative w-[120px] overflow-hidden group">
                                                            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-8 opacity-0 z-10 cursor-pointer ">
                                                            <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">

                                                                <div class="text-white h-8 w-full pl-5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                                                                    <h1 class="text-black dark:text-white text-sm">
                                                                        อื่นๆ
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                            <div class="absolute top-4 left-1 transition-tranform duration-500 rotate-0 peer-checked:rotate-90">
                                                                <svg class="w-3 h-3 text-gray-800 dark:text-white -mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 10 16">
                                                                    <path d="M3.414 1A2 2 0 0 0 0 2.414v11.172A2 2 0 0 0 3.414 15L9 9.414a2 2 0 0 0 0-2.828L3.414 1Z"/>
                                                                </svg>
                                                            </div>
                                                            <ul class="overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40">
                                                                <li>
                                                                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">

                                                                        <a href="#" class="">Products</a>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">

                                                                        <a href="#" class="">Billing</a>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">

                                                                        <a href="#" class="">Invoice</a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>{{ $menu_data->menu_name }}</td>
                                                <td class="text-center"><input type="checkbox" id="action_view_{{ $menu_data->id }}" name="checkboxes[]" value="{{ $menu_data->id }}" onclick="setMenu(this)"></td>
                                                <td class="text-center"><input type="checkbox" id="action_create_{{ $menu_data->id }}" name="checkboxes[]" value="{{ $menu_data->id }}" onclick="setMenu(this)"></td>
                                                <td class="text-center"><input type="checkbox" id="action_edit_{{ $menu_data->id }}" name="checkboxes[]" value="{{ $menu_data->id }}" onclick="setMenu(this)"></td>
                                                <td class="text-center"><input type="checkbox" id="action_delete_{{ $menu_data->id }}" name="checkboxes[]" value="{{ $menu_data->id }}" onclick="setMenu(this)"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        const dlayMessage = 500;
        function modelManageMenu(id, menu_name, menus3) {
            console.log("🚀 ~ modelManageMenu ~ menus3:", menus3)
            jQuery(".table_submenu").remove('')
            let url = ""
            if(id){
                jQuery("#edit_id").val(id)
                jQuery("#menu_id").val(menu_name)
                jQuery("#exampleModalLgLabel").text('แก้ไขรายการเมนู')
                menus3.submenu_array.forEach((element, index) => {
                    console.log("🚀 ~ menus3.submenu_array.forEach ~ element:", element)
                    let seq = Number(index) + 1
                    if (index == 0) {
                        jQuery("#inputs_submenu").val(element)
                    } else {
                        $('#table').append(
                        `<tr class="table_submenu">
                            <td>
                                <input class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" type="text" name="inputs_submenu[`+ seq +`][submenu_name]" id="inputs_submenu[`+ seq +`][submenu_name]" value="`+ element +`" />
                            </td>
                            <td>
                                <input class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" type="text" name="inputs_submenu[`+ seq +`][submenu_url]" id="inputs_submenu[`+ seq +`][submenu_url]" value="" placeholder="EX. manage_menu" />
                            </td>
                            <td class="text-center">
                                <button
                                    type="button"
                                    class="mt-1 px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group remove-table-row"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>`);
                    }
                });

            } else {
                jQuery("#edit_id").val('')
                jQuery("#menu_id").val('')
                jQuery("#url_id").val('')
                jQuery("#submenu_id").val('')
                jQuery("#submenu_url_id").val('')
                jQuery("#exampleModalLgLabel").text('เพิ่มรายการเมนู')
            }
        }

        function createMenu() {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                method: "POST",
                url: "/create_menu",
                data: $("#form_menu").serialize(),
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
                        setTimeout(function() {
                            window.location.reload();
                        },dlayMessage)
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
            $('#menu_id').val('')
            $("#url_id").val('')
            $("#submenu_id").val('')
            $("#submenu_url_id").val('')
            $('#exampleModalLg').addClass('hidden')
        }
        function errorMessage(text) {
            $('#loader_create_menu').addClass('hidden');
            $('#menu_id').val('')
            $("#url_id").val('')
            $("#submenu_id").val('')
            $("#submenu_url_id").val('')
        }
        let select_pos;
        function setMenu(data){
            if(select_pos){
                if($(data).prop("checked")){
                    console.log("🚀 ~ setMenu ~ data:", data)
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    let arrs = [];
                    let menu = <?php echo json_encode($menu_data->id); ?>;
                    console.log("🚀 ~ setMenu ~ arrs:", arrs)
                    // $('[name="checkboxes[]"]').each(function() {
                    //     // if (this.getAttribute('id') == 'action_view_1') {
                    //     //     if ($(this).is(':checked')) {
                    //     //         arrs.push("1");
                    //     //     } else {
                    //     //         arrs.push("0");
                    //     //     }
                    //     // }
                    // });
                    const payload = data.id.split('_')
                    //action_view_{{ $menu['id'] }}_{{ $submenu['id'] }}
                    // let action, menuId, type
                    // if (payload[1] === 'submenu') {
                    //     type = 'submenu'
                    //     action =  payload[2]
                    //     menuId =  payload[3]
                    // } else {
                    //     type = 'mainmenu'
                    //     action =  payload[1]
                    //     menuId =  payload[2]
                    // }
                    let action = payload[1]
                    let menuId = payload[2]
                    let submenuId = payload[3] || NULL

                    $.ajax({
                        type: "POST",
                        url: "{{url('create_access')}}",
                        data: {
                            pos_id: select_pos,
                            menu_id: menuId,
                            action: action,
                            state: data.checked ? 1 : 0,
                            submenuId: submenuId
                        },
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function(res){
                            if(res){
                                console.log('checked : '+$(data).val());
                                setTimeout(function() {
                                    successMessage("Create User Successfully!");
                                },dlayMessage)
                                setTimeout(function() {
                                    toastr.success("Create Menu successfully!");
                                },dlayMessage)
                            }else{
                                console.log('Can not create access.');
                            }
                        }
                    });
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{url('delete_access')}}",
                        data: {
                            pos_id:select_pos,
                            menu_id:$(data).val(),
                            action_name: jQuery(data).attr('name')
                        },
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function(res){
                            if(res){
                                console.log('checked : '+$(data).val());
                                setTimeout(function() {
                                    successMessage("Create User Successfully!");
                                },dlayMessage)
                                setTimeout(function() {
                                    toastr.success("Delete Menu Successfully!");
                                },dlayMessage)
                            }else{
                                console.log('Can not create access.');
                            }
                        }
                    });
                }
            }
        }

        $("#positionTable tbody tr").click(function() {
            let selected = $(this).hasClass("highlight");

            $("#positionTable tr").removeClass("highlight");
            if(!selected){
                $(this).addClass("highlight");
            }
        });

        function setAccess(pos_id){
            removeMenu();
            ajaxGetMenuAccess(pos_id);
            select_pos = pos_id;
        }

        let i = 0;
        $('#add').click( () => {
            ++i;
            $('#table').append(
                `<tr class="table_submenu">
                    <td>
                        <input class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" type="text" name="inputs_submenu[`+ i +`][submenu_name]" id="submenu_id" value="" />
                    </td>
                    <td>
                        <input class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" type="text" name="inputs_submenu[`+ i +`][submenu_url]" id="submenu_url_id" value="" placeholder="EX. manage_menu" />
                    </td>
                    <td class="text-center">
                        <button
                            type="button"
                            class="mt-1 px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group remove-table-row"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>`);
        });
        $(document).on('click', '.remove-table-row', function() {
            $(this).parents('tr').remove();
        });

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        function ajaxGetMenuAccess(pos_id) {
            console.log("🚀 ~ ajaxGetMenuAccess ~ pos_id:", pos_id)
            $.ajax({
                url: "{{ route('menu_access') }}?pos_id=" + pos_id,
                type: "GET",
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                    setTimeout(function() {
                        $('#loader').addClass('hidden');
                    },dlayMessage)
                },
                success:function(res){
                    console.log("🚀 ~ ajaxGetMenuAccess ~ res:", res)
                    let menuAll = <?php echo json_encode($menus); ?>;
                    console.log("🚀 ~ ajaxGetMenuAccess ~ menuAll:", menuAll)
                    const menupermission = res.menus.length ? res.menus[0].get_menu_relation : []
                    console.log("🚀 ~ ajaxGetMenuAccess ~ menupermission:", menupermission)
                    if(true){
                        menuAll.forEach(menu => {
                            const currentMenu = menupermission.find(f => f.menu_id === menu.id)
                            console.log("🚀 ~ ajaxGetMenuAccess ~ currentMenu:", currentMenu)
                            if(currentMenu){
                                $(`#action_view_${menu.id}`).prop("checked",!!currentMenu.view);
                                $(`#action_create_${menu.id}`).prop("checked",!!currentMenu.create);
                                $(`#action_edit_${menu.id}`).prop("checked",!!currentMenu.edit);
                                $(`#action_delete_${menu.id }`).prop("checked",!!currentMenu.delete);
                            } else {
                                $(`#action_view_${menu.id}`).prop("checked",false);
                                $(`#action_create_${menu.id}`).prop("checked",false);
                                $(`#action_edit_${menu.id}`).prop("checked",false);
                                $(`#action_delete_${menu.id }`).prop("checked",false);
                            }

                        });
                    }else{
                        console.log('no data');
                    }
                }
            });
        }

        function removeMenu() {
            let menu_count = $("#menuTable").find("input[type='checkbox']").length;
            for(let i = 1; i <= menu_count; i++){
                $("#action_all_" + i).prop("checked",false);
            }
        }

        function successMessage(text) {
            $('#loader').addClass('hidden');
        }

        function disableAppointment(url,e,id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want be delete!",
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
                cancelButtonText: `Cancle`,
                color: "#ffffff",
                background: "#202020",

            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"/broadcast",
                        method:'POST',
                        headers:{
                            'X-Socket-Id': pusher.connection.socket_id
                        },
                        data:{
                            _token:  '{{csrf_token()}}',
                            message: 'update notify'
                        }
                        }).done(function (res) {
                    });
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        beforeSend: function() {
                            $(e).parent().parent().addClass('d-none');
                        },
                        success: function (params) {
                            if(params.success){
                                Swal.fire({
                                    title:'อัปเดตข้อมูลเรียบร้อย',
                                    text:'',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                mytableDatatable.draw();
                            }
                            else{
                                Swal.fire({
                                    title:'อัปเดตข้อมูลไม่สำเร็จ',
                                    text:'',
                                    icon:'error',
                                });
                                $(e).parent().parent().removeClass('d-none');
                            }
                        },
                        error: function(er){
                            Swal.fire({
                                title:'อัปเดตข้อมูลไม่สำเร็จ',
                                text:'',
                                icon:'error',
                            });
                            $(e).parent().parent().removeClass('d-none');
                        }
                    });
                }
            });
        }
    </script>
@endsection
