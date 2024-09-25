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
        .btn-rotate:hover .rotate{
            transform: rotate(180deg);
            transition: 0.5s all;
        }
        .rotate{
            transition: 0.5s all;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.list_manage_menu')</p>
        </div>
        {{-- @foreach($menusAuthPosition as $submenu)
            <p>{{!empty($submenu['getSubMenu'][0]['name'])}}</p>
        @endforeach --}}
        <!-- @foreach($menusAuthPosition as $menu)
            @if (!empty($menu['getPermissionSubmenus'][0]))
                @foreach($menu['getPermissionSubmenus'] as $submenu)
                    <p class="text-black dark:text-white text-md">
                        {{ $submenu->name }}
                    </p>
                @endforeach
            @endif
        @endforeach
        <div id="logo-sidebar" class="w-[256px] border-r border-gray-200 md:translate-x-0 dark:border-gray-700 transition-all duration-500">
            <div class="px-3 pb-4 overflow-y-auto bg-white dark:bg-[#202020] duration-500">
                @foreach($menusAuthPosition as $menu)
                    <ul class="space-y-2 font-medium">
                        @if (!empty($menu['getPermissionSubmenus'][0]))
                            {{-- @if ( Request::is($menu->url) == $menu->url) --}}
                                <li class="relative w-[232px] overflow-hidden group mt-2">
                                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer ">
                                    <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 mt-1.5 ml-2 text-black dark:text-white">
                                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="bg-white dark:bg-[#202020] text-white h-10 w-full pl-2.5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                                            <h1 class="text-black dark:text-white text-md">
                                                {{$menu['menu_name']}}
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="absolute top-2 right-2 transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @foreach($menu['getPermissionSubmenus'] as $submenu)
                                        <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 h-fit after:absolute after:left-[1.20rem] after:top-[2.5rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-gray-700">
                                            <li>
                                                <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                                                    {{ $submenu->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                </li>
                            {{-- @endif --}}
                        @else
                            <li class="mt-2">
                                {{-- @if ( Request::is($menu->url) == $menu->url) --}}
                                    <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (Request::is($menu->url) || Request::is($menu->url)) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500': '' }}" href="{{ $menu->url }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-black dark:text-white">
                                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                        </svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap dark:text-white">{{$menu['menu_name']}}</span>
                                    </a>
                                {{-- @endif --}}
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </div> -->

        {{-- <div id="logo-sidebar" class="w-[256px] border-r border-gray-200 md:translate-x-0 dark:border-gray-700 transition-all duration-500">
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
        </div> --}}

        <div class="fixed flex bottom-4 right-5 z-10">
            <a
                type="button"
                class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group btn-rotate"
                data-twe-toggle="modal"
                data-twe-target="#exampleModalLg"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                onclick="modelManageMenu()"
            >
                <svg class="size-7 rotate" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 502 502" xml:space="preserve">
                    <g>
                        <g>
                            <path style="fill:#50A5DC;" d="M492,276.648v-51.295c0-13.06-10.587-23.648-23.648-23.648h-43.924
                                c-3.841-13.538-9.234-26.421-15.958-38.46l31.079-31.079c9.235-9.235,9.235-24.208,0-33.443l-36.271-36.271
                                c-9.235-9.235-24.208-9.235-33.443,0l-31.08,31.078c-12.039-6.724-24.922-12.117-38.46-15.958V33.648
                                c0-13.06-10.587-23.648-23.648-23.648h-51.295c-13.06,0-23.648,10.587-23.648,23.648v43.924
                                c-13.538,3.841-26.421,9.234-38.46,15.958l-31.079-31.079c-9.235-9.235-24.208-9.235-33.443,0l-36.27,36.272
                                c-9.235,9.235-9.235,24.208,0,33.443l31.079,31.079c-6.724,12.039-12.117,24.922-15.958,38.46H33.649
                                c-13.06,0-23.648,10.587-23.648,23.648v51.295c0,13.06,10.587,23.648,23.648,23.648h43.924
                                c3.841,13.538,9.234,26.421,15.958,38.46l-31.079,31.079c-9.235,9.235-9.235,24.208,0,33.443l36.271,36.271
                                c9.235,9.235,24.208,9.235,33.443,0l31.079-31.079c12.039,6.724,24.922,12.117,38.46,15.958v43.924
                                c0,13.06,10.587,23.648,23.648,23.648h51.295c13.06,0,23.648-10.587,23.648-23.648v-43.924
                                c13.538-3.841,26.421-9.234,38.46-15.958l31.079,31.079c9.235,9.235,24.208,9.235,33.443,0l36.271-36.271
                                c9.235-9.235,9.235-24.208,0-33.443l-31.079-31.079c6.724-12.039,12.117-24.922,15.958-38.46h43.924
                                C481.414,300.295,492,289.708,492,276.648z M251.001,344.612c-51.7,0-93.612-41.911-93.612-93.612s41.912-93.612,93.612-93.612
                                S344.612,199.3,344.612,251S302.701,344.612,251.001,344.612z"/>
                            <path d="M276.648,502h-51.295c-18.554,0-33.648-15.094-33.648-33.648v-36.527c-9.116-2.992-18.026-6.689-26.623-11.049
                                l-25.844,25.844c-13.119,13.119-34.467,13.119-47.586,0l-36.271-36.272c-13.118-13.119-13.118-34.465,0-47.585l25.845-25.845
                                c-4.359-8.596-8.058-17.506-11.049-26.623H33.648c-18.553,0-33.647-15.094-33.647-33.647v-51.296
                                c0-18.553,15.094-33.647,33.647-33.647h36.528c2.991-9.117,6.689-18.027,11.049-26.623l-25.844-25.845
                                c-13.118-13.12-13.118-34.466,0-47.585L91.652,55.38c13.119-13.118,34.467-13.118,47.586,0l25.844,25.844
                                c8.597-4.36,17.507-8.058,26.623-11.049V33.648C191.704,15.094,206.799,0,225.354,0h51.295c18.554,0,33.648,15.094,33.648,33.648
                                v36.527c9.116,2.992,18.026,6.689,26.623,11.049l25.844-25.844c13.119-13.119,34.467-13.119,47.586,0l36.271,36.271
                                c13.118,13.119,13.118,34.465,0,47.585l-25.845,25.845c4.359,8.596,8.058,17.506,11.049,26.623h36.528
                                c18.554,0,33.647,15.094,33.647,33.647v51.296c0,18.553-15.094,33.647-33.647,33.647h-36.528
                                c-2.991,9.117-6.689,18.027-11.049,26.623l25.845,25.844c13.118,13.12,13.118,34.466,0,47.585l-36.271,36.272
                                c-13.119,13.118-34.467,13.118-47.586,0l-25.844-25.844c-8.597,4.36-17.507,8.058-26.623,11.049v36.527
                                C310.297,486.906,295.201,502,276.648,502z M163.247,398.469c1.666,0,3.344,0.416,4.873,1.27
                                c11.511,6.429,23.729,11.499,36.313,15.068c4.303,1.221,7.271,5.149,7.271,9.621v43.924c0,7.525,6.123,13.648,13.648,13.648
                                h51.295c7.525,0,13.648-6.123,13.648-13.648v-43.924c0-4.472,2.969-8.4,7.271-9.621c12.584-3.57,24.802-8.639,36.313-15.068
                                c3.904-2.18,8.784-1.504,11.947,1.66l31.078,31.079c5.32,5.32,13.98,5.322,19.301,0l36.271-36.271
                                c5.321-5.321,5.321-13.979,0-19.301l-31.079-31.078c-3.163-3.163-3.841-8.042-1.659-11.947
                                c6.428-11.51,11.498-23.728,15.068-36.313c1.221-4.302,5.148-7.271,9.62-7.271h43.925c7.525,0,13.647-6.122,13.647-13.647v-51.296
                                c0-7.525-6.122-13.647-13.647-13.647h-43.925c-4.472,0-8.399-2.969-9.62-7.271c-3.57-12.585-8.641-24.803-15.068-36.313
                                c-2.182-3.905-1.504-8.784,1.659-11.947l31.079-31.079c5.321-5.321,5.321-13.979,0-19.301l-36.271-36.271
                                c-5.32-5.32-13.98-5.322-19.301,0l-31.078,31.078c-3.162,3.164-8.04,3.84-11.947,1.66c-11.511-6.429-23.729-11.499-36.313-15.068
                                c-4.303-1.221-7.271-5.149-7.271-9.621V33.648c0-7.525-6.123-13.648-13.648-13.648h-51.295c-7.525,0-13.648,6.123-13.648,13.648
                                v43.924c0,4.472-2.969,8.4-7.271,9.621c-12.584,3.57-24.802,8.639-36.313,15.068c-3.904,2.181-8.784,1.503-11.947-1.66
                                l-31.078-31.079c-5.32-5.32-13.98-5.322-19.301,0l-36.271,36.271c-5.321,5.321-5.321,13.979,0,19.301l31.079,31.078
                                c3.163,3.163,3.841,8.042,1.659,11.947c-6.428,11.51-11.498,23.728-15.068,36.313c-1.221,4.302-5.148,7.271-9.62,7.271H33.648
                                c-7.525,0-13.647,6.122-13.647,13.647v51.296c0,7.525,6.122,13.647,13.647,13.647h43.925c4.472,0,8.399,2.969,9.62,7.271
                                c3.57,12.585,8.641,24.803,15.068,36.313c2.182,3.905,1.504,8.784-1.659,11.947l-31.079,31.079
                                c-5.321,5.321-5.321,13.979,0,19.301l36.271,36.271c5.32,5.32,13.98,5.322,19.301,0l31.078-31.078
                                C158.099,399.474,160.659,398.469,163.247,398.469z M251.001,354.611c-57.132,0-103.611-46.48-103.611-103.611
                                s46.479-103.611,103.611-103.611S354.612,193.869,354.612,251S308.133,354.611,251.001,354.611z M251.001,167.389
                                c-46.104,0-83.611,37.508-83.611,83.611s37.508,83.611,83.611,83.611s83.611-37.508,83.611-83.611
                                S297.104,167.389,251.001,167.389z"/>
                        </g>
                        <g>
                            <path d="M121.001,261c-5.522,0-10-4.477-10-10c0-27.143,7.779-53.472,22.498-76.142c14.331-22.074,34.479-39.62,58.267-50.743
                                c5.002-2.341,10.954-0.18,13.294,4.823c2.34,5.003,0.18,10.955-4.823,13.294c-42.059,19.667-69.236,62.361-69.236,108.768
                                C131.001,256.523,126.523,261,121.001,261z"/>
                        </g>
                        <g>
                            <path d="M302.995,141.819c-1.337,0-2.695-0.27-3.999-0.839c-15.157-6.622-31.306-9.98-47.995-9.98c-5.522,0-10-4.477-10-10
                                s4.478-10,10-10c19.463,0,38.305,3.92,56.003,11.653c5.061,2.211,7.371,8.106,5.16,13.167
                                C310.521,139.578,306.849,141.819,302.995,141.819z"/>
                        </g>
                    </g>
                </svg>
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg> -->
            </a>
        </div>
        <div
            data-twe-modal-init
            class="data-twe-backdrop-show fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
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
                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg> -->
                                            <svg fill="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 473.599 473.6"
                                                    xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path d="M124.499,117.678c1.745,6.28,4.286,12.002,7.522,17.318l13.968,51.323l2.571,1.13
                                                            c1.174,0.511,29.056,12.547,68.238,12.547c23.051,0,45.222-4.202,65.913-12.473l3.138-1.259l6.46-43.138
                                                            c6.02-7.498,10.556-15.747,13.225-25.287c0.629,0.133,1.21,0.379,1.887,0.379c5.09,0,9.214-4.127,9.214-9.235V84.069
                                                            c0-5.095-4.124-9.231-9.214-9.231c-0.568,0-1.041,0.218-1.578,0.314C296.244,33.167,259.275,0,215.039,0
                                                            c-44.3,0-81.312,33.259-90.854,75.333c-0.801-0.23-1.583-0.495-2.456-0.495c-5.094,0-9.223,4.127-9.223,9.231v24.915
                                                            c0,5.099,4.129,9.235,9.223,9.235C122.718,118.235,123.613,117.958,124.499,117.678z M272.046,156.498
                                                            c-51.832,18.211-99.33,4.771-113.995-0.369v-30.617h113.995V156.498z M275.212,177.809c-18.406,6.919-38.037,10.419-58.406,10.419
                                                            c-30.082,0-53.461-7.74-60.967-10.554l-2.951-10.848c9.379,3.462,33.095,10.928,63.712,10.928
                                                            c18.178,0,38.764-2.701,60.167-10.361L275.212,177.809z M158.051,108.248c0-9.962,8.073-18.031,18.035-18.031h77.931
                                                            c9.967,0,18.029,8.069,18.029,18.031v5.479H158.051V108.248z"/>
                                                        <path d="M290.785,473.6c0-3.13,0.354-6.524,0.935-10.067c-30.581-19.832-50.891-54.208-50.891-93.292
                                                            c0-61.33,49.893-111.219,111.218-111.219c20.462,0,39.582,5.65,56.057,15.329c0.22-5.675,0.336-11.754,0.336-18.402
                                                            c0-42.379-128.35-97.992-128.35-46.116c0,51.875-62.847,46.116-62.847,46.116s-62.84,5.759-62.84-46.116
                                                            c0-51.876-128.354,3.737-128.354,46.116c0,42.387,4.014,64.062,18.717,75.283c14.703,11.232,44.116,18.831,44.116,18.831
                                                            s54.824,82.196,54.824,123.537h73.532H290.785z"/>
                                                        <path d="M406.8,292.051c-15.509-10.896-34.372-17.336-54.762-17.336c-52.746,0-95.517,42.764-95.517,95.517
                                                            c0,31.655,15.473,59.639,39.2,77.023c15.797,11.569,35.233,18.494,56.316,18.494c52.742,0,95.513-42.764,95.513-95.518
                                                            C447.551,337.88,431.414,309.323,406.8,292.051z M410.455,383.549h-45.268v45.275h-26.625v-45.275h-13.333h-31.947v-26.626h45.28
                                                            v-45.271h26.625v32.083v13.188h45.268V383.549z"/>
                                                    </g>
                                                </g>
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
                            <a data-twe-modal-dismiss class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createMenu()">
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
                    <form id="form_menu_permission" class="" method="POST">
                        <input class="" type="hidden" id="edit_id_role" name="edit_id_role" value="">
                        <div class=" p-4 text-gray-900 dark:text-gray-100">
                            <label for="name">ชื่อสิทธิ์</label>
                            <input type="text" id="name_position" name="name_position" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
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
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-5 gap-10 mt-10">
            <div class="form col-span-2">
                <div class="relative w-full overflow-hidden">
                    <div class="fixed flex bottom-16 right-5 z-10">
                        <a
                            type="button"
                            class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group"
                            data-twe-toggle="modal"
                            data-twe-target="#staticBackdrop"
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            onclick="modelManageRole()"
                        >
                            <svg fill="currentColor" class="size-7" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1600 1066.667c117.653 0 213.333 95.68 213.333 213.333v106.667H1920V1760c0 88.213-71.787 160-160 160h-320c-88.213 0-160-71.787-160-160v-373.333h106.667V1280c0-117.653 95.68-213.333 213.333-213.333ZM800 0c90.667 0 179.2 25.6 254.933 73.6 29.867 18.133 58.667 40.533 84.267 66.133 49.067 49.067 84.8 106.88 108.053 169.814 11.307 30.4 20.8 61.44 25.814 94.08l2.24 14.613 3.626 20.16-.533.32v.213l-52.693 32.427c-44.694 28.907-95.467 61.547-193.067 61.867-.427 0-.747.106-1.173.106-24.534 0-46.08-2.133-65.28-5.653-.64-.107-1.067-.32-1.707-.427-56.32-10.773-93.013-34.24-126.293-55.68-9.6-6.293-18.774-12.16-28.16-17.6-27.947-16-57.92-27.306-108.16-27.306h-.32c-57.814.106-88.747 15.893-121.387 36.266-4.48 2.88-8.853 5.44-13.44 8.427-3.093 2.027-6.72 4.16-9.92 6.187-6.293 4.053-12.693 8.106-19.627 12.16-4.48 2.666-9.493 5.013-14.293 7.573-6.933 3.627-13.973 7.147-21.76 10.453-6.613 2.987-13.76 5.547-21.12 8.107-6.933 2.347-14.507 4.267-22.187 6.293-8.96 2.347-17.813 4.587-27.84 6.187-1.173.213-2.133.533-3.306.747v57.6c0 17.066 1.066 34.133 4.266 50.133C454.4 819.2 611.2 960 800 960c195.2 0 356.267-151.467 371.2-342.4 48-14.933 82.133-37.333 108.8-54.4v23.467c0 165.546-84.373 311.786-212.373 398.08h4.906a1641.19 1641.19 0 0 1 294.08 77.76C1313.28 1119.68 1280 1195.733 1280 1280h-106.667v480c0 1.387.427 2.667.427 4.16-142.933 37.547-272.427 49.173-373.76 49.173-345.493 0-612.053-120.32-774.827-221.333L0 1576.32v-196.373c0-140.054 85.867-263.04 218.667-313.28 100.373-38.08 204.586-64.96 310.186-82.347h4.8C419.52 907.413 339.2 783.787 323.2 640c-2.133-17.067-3.2-35.2-3.2-53.333V480c0-56.533 9.6-109.867 27.733-160C413.867 133.333 592 0 800 0Zm800 1173.333c-58.773 0-106.667 47.894-106.667 106.667v106.667h213.334V1280c0-58.773-47.894-106.667-106.667-106.667Z" fill-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
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
                                                <th style="width: 30px">Action</th>
                                                <th style="width: 30px">ID</th>
                                                <th>ชื่อสิทธิ์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($position as $pos_data)
                                                <tr id="pos_{{ $pos_data->id }}" onclick="setAccess({{  $pos_data->id  }})">
                                                    <td class="flex">
                                                        <button
                                                            type="button"
                                                            class="px-2 py-1 left-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group"
                                                            data-twe-toggle="modal"
                                                            data-twe-target="#staticBackdrop"
                                                            data-twe-ripple-init
                                                            data-twe-ripple-color="light"
                                                            onclick="modelManageRole('{{ $pos_data->id }}', '{{ $pos_data->name_position }}')"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                                            </svg>
                                                        </button>
                                                        <!-- <button
                                                            type="button"
                                                            class="px-2 py-1 font-medium tracking-wide bg-[#c72121] hover:bg-[#c23737e3] text-white rounded group"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button> -->
                                                    </td>
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
                <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div class="form col-span-3">
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 cursor-pointer">
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
                                        <tbody id="item-tbody">
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
                                                    <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_view_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_create_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_edit_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                    <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_delete_{{ $menu['id'] }}_0" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                </tr>
                                                @if(!is_null($menu['submenus']))
                                                    @foreach($menu['submenus'] as $submenu)
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="">&nbsp;&nbsp;&nbsp;{{ $submenu['name'] }}</td>
                                                            <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_view_{{ $menu['id'] }}_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_create_{{ $menu['id'] }}_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_edit_{{ $menu['id'] }}_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
                                                            <td class="text-center"><input type="checkbox" class="disabled:bg-zinc-400 disabled:checked:border-slate-400" id="action_delete_{{ $menu['id'] }}_{{ $submenu['id'] }}" name="checkboxes[]" value="{{ $menu['id'] }}" onclick="setMenu(this)"></td>
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
                    <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa] z-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

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
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

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
        let menusAuthPosition = <?php echo json_encode($menusAuthPosition); ?>;

        function modelManageRole(id, name_position) {
            if (id) {
                    jQuery("#edit_id_role").val(id)
                    jQuery("#name_position").val(name_position)
                    jQuery("#staticBackdropLabel").text('แก้ไขสิทธิ์การใช้งาน')
            } else {
                jQuery("#edit_id_role").val('')
                jQuery("#name_position").val('')
                jQuery("#staticBackdropLabel").text('เพิ่มสิทธิ์การใช้งาน')
            }
        }

        function modelManageMenu(id, menu_name, submenus_name) {
            jQuery(".table_submenu").remove('')
            let url = ""
            if(id){
                jQuery("#edit_id").val(id)
                jQuery("#menu_id").val(menu_name)
                jQuery("#exampleModalLgLabel").text('แก้ไขรายการเมนู')
                submenus_name.submenus.forEach((element, index) => {
                    // console.log("🚀 ~ submenus_name.submenu_array.forEach ~ element:", element.name)
                    let seq = Number(index) + 1
                    if (index == 0) {
                        jQuery("#inputs_submenu").val(element.name)
                    } else {
                        $('#table').append(
                        `<tr class="table_submenu">
                            <td>
                                <input class="w-12/12 h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" type="text" name="inputs_submenu[`+ seq +`][submenu_name]" id="inputs_submenu[`+ seq +`][submenu_name]" value="`+ element.name +`" />
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
                    console.log("🚀 ~ createMenu ~ res:", res)
                    $('#exampleModalLg').hide('');
                    $('.w-screen').remove('');
                    $('#exampleModalLg').removeClass('opacity-50 transition-all duration-300 ease-in-out fixed top-0 left-0 z-[1040] bg-black w-screen h-screen')
                    if(res.success == true) {
                        setTimeout(function() {
                            successMessage("Success!");
                        },dlayMessage)
                        setTimeout(function() {
                            toastr.success("Create menu successfully!");
                            // window.location.reload();
                        },dlayMessage)
                        // $('#menuTable').reload();
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
            console.log("🚀 ~ successMessage ~ text:", text)
            $('#loader_create_menu').addClass('hidden');
            $('#menu_id').val('')
            $("#url_id").val('')
            $("#submenu_id").val('')
            $("#submenu_url_id").val('')
            // $('#exampleModalLg').removeClass('opacity-50 transition-all duration-300 ease-in-out fixed top-0 left-0 z-[1040] bg-black w-screen h-screen')
            // $('#exampleModalLg').hide()
            // $('body').css('overflow', 'auto');
            // $('#exampleModalLg').dialog('close')
            // $('#exampleModalLg').hide('');
            // $('.w-screen').remove('');
        }
        function errorMessage(text) {
            $('#loader_create_menu').addClass('hidden');
            $('#menu_id').val('')
            $("#url_id").val('')
            $("#submenu_id").val('')
            $("#submenu_url_id").val('')
        }

        // $('#item-tbody').html('');

        let select_pos;
        function setMenu(data){
            if(select_pos){
                if($(data).prop("checked")){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    let arrs = [];
                    // $('[name="checkboxes[]"]').each(function() {
                    //     // if (this.getAttribute('id') == 'action_view_1') {
                    //     //     if ($(this).is(':checked')) {
                    //     //         arrs.push("1");
                    //     //     } else {
                    //     //         arrs.push("0");
                    //     //     }
                    //     // }
                    // });

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
                    const payload = data.id.split('_')
                    let action = payload[1]
                    let menuId = payload[2]
                    let submenuId = payload[3] || null

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
                                // console.log('checked : '+$(data).val());
                                setTimeout(function() {
                                    successMessage("Create User Successfully!");
                                },dlayMessage)
                                setTimeout(function() {
                                    toastr.success("Create Menu successfully!");
                                },dlayMessage)
                            }else{
                                // console.log('Can not create access.');
                            }
                        }
                    });
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    const payload = data.id.split('_')
                    let action = payload[1]
                    let submenuId = payload[3] || null

                    $.ajax({
                        type: "POST",
                        url: "{{url('delete_access')}}",
                        data: {
                            pos_id:select_pos,
                            menu_id:$(data).val(),
                            action: action,
                            state: data.checked ? 1 : 0,
                            // action_name: jQuery(data).attr('name'),
                            submenuId: submenuId
                        },
                        beforeSend: function () {
                            $('#loader').removeClass('hidden')
                        },
                        success: function(res){
                            if(res){
                                // console.log('checked : '+$(data).val());
                                setTimeout(function() {
                                    successMessage("Create User Successfully!");
                                    // $('#menuTable').reload();
                                    // window.location.reload();
                                },dlayMessage)
                                setTimeout(function() {
                                    toastr.success("Delete Menu Successfully!");
                                },dlayMessage)
                            }else{
                                // console.log('Can not create access.');
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

        setAccess(1);
        $("#pos_1").addClass("highlight");

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
        }

        function ajaxGetMenuAccess(pos_id) {
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
                    let menuAll = <?php echo json_encode($menus); ?>;
                    let menupermission = res.submenu_array.length ? res.submenu_array : []
                    console.log("🚀 ~ ajaxGetMenuAccess ~ menupermission:", menupermission)
                    const result = Object.groupBy(menupermission, ({ menu_id }) => menu_id);
                    console.log("🚀 ~ ajaxGetMenuAccess ~ result:", result)
                    if(true) {
                        menuAll.forEach(menu => {
                            const currentMenu = result[menu.id]
                            console.log("🚀 ~ ajaxGetMenuAccess ~ currentMenu:", currentMenu)
                            if(currentMenu != undefined){
                                const menu_id = menu.id
                                currentMenu.forEach(fmenu => {
                                    const submenu_id = fmenu.submenu_id || 0
                                    $(`#action_view_${menu_id}_${submenu_id}`).prop("checked",!!fmenu.view);
                                    $(`#action_create_${menu_id}_${submenu_id}`).prop("checked",!!fmenu.create);
                                    $(`#action_edit_${menu_id}_${submenu_id}`).prop("checked",!!fmenu.edit);
                                    $(`#action_delete_${menu_id}_${submenu_id}`).prop("checked",!!fmenu.delete);
                                    if(submenu_id === 0 && menu.submenus.length){
                                        let isHaveSubmenu = false;
                                        menu.submenus.forEach(submenu => {
                                            if (!fmenu.view) {
                                                $(`#action_view_${menu.id}_${submenu.id}`).prop("disabled", true);
                                            }else {
                                                $(`#action_view_${menu.id}_${0}`).prop("disabled", true);
                                            }
                                            if (!fmenu.create) {
                                                $(`#action_create_${menu.id}_${submenu.id}`).prop("disabled", true);
                                            } else {
                                                $(`#action_create_${menu.id}_${0}`).prop("disabled", true);
                                            }
                                            if (!fmenu.edit) {
                                                $(`#action_edit_${menu.id}_${submenu.id}`).prop("disabled", true);
                                            } else {
                                                $(`#action_edit_${menu.id}_${0}`).prop("disabled", true);
                                            }
                                            if (!fmenu.delete) {
                                                $(`#action_delete_${menu.id}_${submenu.id}`).prop("disabled", true);
                                            } else {
                                                $(`#action_delete_${menu.id}_${0}`).prop("disabled", true);
                                            }
                                            $(`#action_view_${menu.id}_${submenu.id}`).prop("checked",false);
                                            $(`#action_create_${menu.id}_${submenu.id}`).prop("checked",false);
                                            $(`#action_edit_${menu.id}_${submenu.id}`).prop("checked",false);
                                            $(`#action_delete_${menu.id}_${submenu.id}`).prop("checked",false);
                                        })
                                    }
                                })
                                let dummy = [...currentMenu]
                                dummy.shift()
                                if(dummy.every(e => !e.view)){
                                    $(`#action_view_${menu.id}_${0}`).prop("disabled", false);
                                } else {
                                    $(`#action_view_${menu.id}_${0}`).prop("disabled", true);
                                }
                                if(dummy.every(e => !e.create)){
                                    $(`#action_create_${menu.id}_${0}`).prop("disabled", false);
                                } else {
                                    $(`#action_create_${menu.id}_${0}`).prop("disabled", true);
                                }
                                if(dummy.every(e => !e.edit)){
                                    $(`#action_edit_${menu.id}_${0}`).prop("disabled", false);
                                } else {
                                    $(`#action_edit_${menu.id}_${0}`).prop("disabled", true);
                                }
                                if(dummy.every(e => !e.delete)){
                                    $(`#action_delete_${menu.id}_${0}`).prop("disabled", false);
                                } else {
                                    $(`#action_delete_${menu.id}_${0}`).prop("disabled", false);
                                }
                            } else {
                                $(`#action_view_${menu.id}_${0}`).prop("checked",false);
                                $(`#action_create_${menu.id}_${0}`).prop("checked",false);
                                $(`#action_edit_${menu.id}_${0}`).prop("checked",false);
                                $(`#action_delete_${menu.id}_${0}`).prop("checked",false);

                                $(`#action_view_${menu.id}_${0}`).prop("disabled", false);
                                $(`#action_create_${menu.id}_${0}`).prop("disabled", false);
                                $(`#action_edit_${menu.id}_${0}`).prop("disabled", false);
                                $(`#action_delete_${menu.id}_${0}`).prop("disabled", false);

                                if(menu.submenus.length){
                                    menu.submenus.forEach(submenu => {
                                        $(`#action_view_${menu.id}_${submenu.id}`).prop("disabled", true);
                                        $(`#action_create_${menu.id}_${submenu.id}`).prop("disabled", true);
                                        $(`#action_edit_${menu.id}_${submenu.id}`).prop("disabled", true);
                                        $(`#action_delete_${menu.id}_${submenu.id}`).prop("disabled", true);

                                        $(`#action_view_${menu.id}_${submenu.id}`).prop("checked", false);
                                        $(`#action_create_${menu.id}_${submenu.id}`).prop("checked", false);
                                        $(`#action_edit_${menu.id}_${submenu.id}`).prop("checked", false);
                                        $(`#action_delete_${menu.id}_${submenu.id}`).prop("checked", false);
                                    })
                                }
                            }
                        });
                    }else {
                        console.log('no data');
                    }
                }
            });
        }

        function removeMenu() {
            let menu_count = $("#menuTable").find("input[type='checkbox']").length;
            for(let i = 1; i <= menu_count; i++){
                $("#action_all_" + i).prop("checked", false);
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
