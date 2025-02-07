@php

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\Managemenu\ManageMenuController;

$countUsers = ProductController::count_users();
$menuPpermissions = ManageMenuController::menus_data();

// $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
// $odd_numbers = array_filter($numbers, function($number) {
//     return $number % 2 != 0;
// });
// dd($odd_numbers);

@endphp

<style>
    /* .sidebar .nav-item.active {
        background-color: rgb(243 244 246);
        background-color: #303030;
    } */

    .mt ul:nth-child(1) {
        margin-top: 19px !important;
    }
</style>

<!-- Active menu checked -->
<!-- #C7D7F0 #ABC2E8 -->
<!-- hover:bg-opacity-500 -->
 
<aside id="logo-sidebar" class="sidebar fixed top-12 left-0 z-40 w-64 h-screen -translate-x-full border-r border-gray-200 md:translate-x-0 dark:border-gray-700 transition-all duration-500" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-[#202020] duration-500 mt">
        @if (!empty($routeName))
            @foreach($routeName as $menu)
                <ul class="space-y-2 font-medium">
                    @if (!empty($menu['getPermissionSubmenus'][0]))
                        <li class="relative w-[232px] overflow-hidden group mt-2">
                            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer"  {{ Request::is($menu['url'].'*') ? 'checked duration-500': '' }}>

                            @if ($menu['menu_name'] == 'Manage Menu' || $menu['menu_name'] == 'Product Master' || $menu['menu_name'] == 'Product Detail')
                                <div class="flex peer duration-500 {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-1.5 ml-2 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                    </svg>
                                    <div class="bg-white text-white h-10 w-full pl-2.5 flex items-center duration-500 {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': 'dark:bg-[#202020] duration-500' }}">
                                        <h1 class="text-md text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white': 'duration-500' }}">
                                            {{$menu['menu_name']}}
                                        </h1>
                                    </div>
                                </div>
                            @else
                                <div class="flex peer duration-500 {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 mt-1.5 ml-2 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                        <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="bg-white text-white h-10 w-full pl-2.5 flex items-center duration-500 {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': 'dark:bg-[#202020] duration-500' }}">
                                        <h1 class="text-md text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white dark:text-white': 'duration-500' }}">
                                            {{$menu['menu_name']}}
                                        </h1>
                                    </div>
                                </div>
                            @endif


                            <div class="absolute top-2 right-2 transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @foreach($menu['getPermissionSubmenus'] as $submenu)
                                <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 h-fit after:absolute after:left-[1.20rem] after:top-[2.5rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-gray-600">
                                    <li>
                                        <a class="flex items-center w-full p-1.5 text-gray-900 transition rounded-sm pl-12 group hover:bg-neutral-800/50 dark:text-white dark:hover:bg-[#303030] {{ Request::is($menu['url'].'/'.$submenu['url'].'*') ? 'rounded-sm text-white dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}" href="{{ '/'.$menu['url'].'/'.$submenu['url'] }}">
                                            {{ $submenu->name }}
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        </li>
                    @else
                        @if ($menu['menu_name'] == 'Product Channel')
                            <li class="mt-2">
                                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-neutral-800/50 dark:hover:bg-[#303030] group {{ Request::is($menu['url'].'*') ? 'rounded-sm dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}" href="{{ '/'.$menu['url'] }}">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mt-1.5 ml-2 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                        <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                        <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg> -->
                                    <svg fill="currentColor" version="1.1" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" class="size-6 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        <title>sale</title>
                                        <path d="m28 31h-24c-1.657 0-3-1.344-3-3v-14c0-1.657 1.343-3 3-3h2l8.493-6.518c-0.038-0.155-0.064-0.315-0.064-0.482 0-1.104 0.896-2 2-2s1.999 0.896 1.999 2c0 0.359-0.102 0.692-0.269 0.984l7.841 6.016h2c1.656 0 3 1.343 3 3v14c0 1.656-1.344 3-3 3zm-10.929-6.417h4.031v-0.758h-3.18v-5.688h-0.852v6.446zm-5.768 0 0.706-1.953h2.708l0.742 1.953h0.972l-2.628-6.445h-0.924l-2.478 6.445h0.902zm-5.961-5.689c-0.184 0.284-0.276 0.589-0.276 0.914 0 0.297 0.075 0.564 0.226 0.804s0.38 0.439 0.687 0.602c0.236 0.126 0.649 0.26 1.239 0.402s0.971 0.247 1.144 0.314c0.269 0.104 0.462 0.229 0.581 0.38s0.179 0.326 0.179 0.528c0 0.198-0.061 0.383-0.182 0.552s-0.306 0.302-0.555 0.399c-0.248 0.098-0.534 0.146-0.858 0.146-0.365 0-0.693-0.063-0.985-0.192-0.293-0.127-0.508-0.295-0.646-0.503s-0.228-0.474-0.266-0.797l-0.805 0.07c0.012 0.431 0.13 0.816 0.354 1.157s0.532 0.598 0.925 0.768c0.394 0.17 0.881 0.255 1.463 0.255 0.458 0 0.871-0.084 1.238-0.253 0.367-0.168 0.648-0.402 0.844-0.706s0.294-0.625 0.294-0.968c0-0.345-0.09-0.649-0.269-0.914s-0.456-0.484-0.832-0.656c-0.259-0.117-0.733-0.254-1.423-0.41-0.691-0.157-1.118-0.311-1.281-0.461-0.167-0.148-0.25-0.339-0.25-0.57 0-0.268 0.118-0.495 0.353-0.684s0.609-0.284 1.123-0.284c0.494 0 0.867 0.104 1.119 0.31 0.253 0.207 0.4 0.513 0.444 0.917l0.82-0.062c-0.015-0.378-0.12-0.716-0.315-1.014s-0.476-0.524-0.84-0.678-0.784-0.23-1.261-0.23c-0.433 0-0.826 0.073-1.18 0.22-0.356 0.146-0.625 0.36-0.809 0.644zm12.336-13.344c-0.344 0.277-0.774 0.45-1.249 0.45-0.662 0-1.244-0.325-1.608-0.821l-7.821 5.821h18l-7.322-5.45zm9.258 18.275h-3.953v-2.195h3.562v-0.758h-3.562v-1.977h3.805v-0.758h-4.656v6.445h4.805v-0.757zm-13.622-5.015c0.104 0.353 0.256 0.8 0.457 1.343l0.679 1.782h-2.199l0.715-1.887c0.147-0.407 0.263-0.82 0.348-1.238z"/>
                                    </svg>

                                    <h1 class="flex-1 ms-3 whitespace-nowrap text-md text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        {{$menu['menu_name']}}
                                    </h1>
                                </a>
                            </li>
                        @else
                            <li class="mt-2"><li class="mt-2">
                                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-neutral-800/50 dark:hover:bg-[#303030] group {{ Request::is($menu['url'].'*') ? 'rounded-sm dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}" href="{{ '/'.$menu['url'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                                    </svg>
                                    <h1 class="flex-1 ms-3 whitespace-nowrap text-md text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        {{$menu['menu_name']}}
                                    </h1>
                                </a>
                            </li>
                        @endif
                        <!-- @if ($menu['menu_name'] == 'Account')
                            <li class="mt-2">
                                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-neutral-800/50 dark:hover:bg-[#303030] group {{ Request::is($menu['url'].'*') ? 'rounded-sm dark:text-white !bg-[#014a77] !dark:bg-[#014a77] duration-500': '' }}" href="{{ '/'.$menu['url'] }}">

                                <svg viewBox="0 0 1024 1024" fill="currentColor" class="icon size-6 text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}""  version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M110.4 923.2c-56.8 0-102.4-48-102.4-106.4V285.6c0-58.4 45.6-106.4 102.4-106.4h800.8c56.8 0 102.4 48 102.4 106.4V816c0 58.4-45.6 106.4-102.4 106.4H110.4z m0-701.6c-34.4 0-61.6 28.8-61.6 64V816c0 35.2 28 64 61.6 64h800.8c34.4 0 61.6-28.8 61.6-64V285.6c0-35.2-28-64-61.6-64H110.4z" fill="" />
                                    <path d="M541.6 392c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 511.2c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h328c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24h-328zM541.6 638.4c-12.8 0-23.2-10.4-23.2-24s10.4-24 23.2-24h276.8c12.8 0 23.2 10.4 23.2 24s-10.4 24-23.2 24H541.6zM58.4 886.4c-2.4 0-4.8 0-7.2-0.8-12.8-4-20-18.4-16-32 23.2-78.4 77.6-142.4 148-176l16-8-13.6-12c-40-34.4-63.2-85.6-63.2-139.2 0-100 78.4-180.8 173.6-180.8 96 0 173.6 80.8 173.6 180.8 0 53.6-23.2 104.8-63.2 139.2l-13.6 12 16 8c68 32 132.8 112 157.6 194.4 16 52.8-16.8 36-1.6 16-3.2 4.8-16.8-5.6-32-5.6-12.8 0-19.2 24.8-19.2 22.4-31.2-104-120.8-203.2-217.6-203.2-99.2 0-186.4 67.2-216 166.4-1.6 11.2-11.2 18.4-21.6 18.4z m239.2-498.4c-69.6 0-126.4 58.4-126.4 130.4s56.8 130.4 126.4 130.4c69.6 0 126.4-58.4 126.4-130.4-0.8-72-56.8-130.4-126.4-130.4z" fill="" />
                                </svg>
                                    <h1 class="flex-1 ms-3 whitespace-nowrap text-md text-black dark:text-white {{ Request::is($menu['url'].'*') ? 'rounded-sm text-white': 'duration-500' }}">
                                        {{$menu['menu_name']}}
                                    </h1>
                                </a>
                            </li>  
                        @endif -->
                    @endif
                </ul>
            @endforeach
        @endif

        <!-- <ul class="space-y-2 font-medium">
            <li>
                <a class="flex items-center mt-5 p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (request()->is('new_product_develop') || request()->is('new_product_develop/*')) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '' }}" href="{{ route('new_product_develop.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">NPD Request</span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (request()->is('account') || request()->is('account/*')) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '' }}" href="{{ route('account.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Account</span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (request()->is('product') || request()->is('product/*')) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '' }}" href="{{ route('product_master.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Product Master</span>
                    <span id="count_noti_pm" class="inline-flex items-center justify-center px-2 ms-3 text-xs font-medium text-gray-100 bg-[#C82333] rounded-full dark:bg-[#C82333] dark:text-gray-300"></span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (Request::is('get_users') || Request::is('get_users/*') || Request::is('product_detail_create')) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500' : '' }}" href="{{ route('get_users') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Product Detail</span>
                    <span id="count_noti" class="inline-flex items-center justify-center px-2 ms-3 text-xs font-medium text-gray-100 bg-[#C82333] rounded-full dark:bg-[#C82333] dark:text-gray-300"></span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-1 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (Request::is('manage_menu') || Request::is('manage_menu')) ? 'rounded-sm bg-primary-100 dark:bg-[#014a77] duration-500': '' }}" href="{{ route('manage_menu') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-1 ml-0.5 text-black dark:text-white">
                        <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                        <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap text-gray-900 dark:text-white">Manage Menu</span>
                </a>
            </li>
            <li class="relative w-[230px] overflow-hidden group">
                <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer ">
                <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mt-2 ml-2 text-black dark:text-white">
                        <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                    </svg>
                    <div class="bg-white dark:bg-[#202020] text-white h-10 w-full pl-2.5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                        <h1 class="text-black dark:text-white text-md">
                            อื่นๆ
                        </h1>
                    </div>
                </div>
                <div class="absolute top-2 right-2 transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                    </svg>
                </div>
                <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 h-fit after:absolute after:left-[1rem] after:top-[2.5rem] after:mt-px after:h-[calc(100%-2.45rem)] after:w-px after:bg-neutral-200 after:content-[''] dark:after:bg-gray-700">
                    <li>
                        <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">Products</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">Billing</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-1.5 text-gray-900 transition duration-75 rounded-sm pl-12 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">Invoice</a>
                    </li>
                </ul>
            </li>
        </ul> -->
        <!-- <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                    <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Approve</span>
            </a>
        </li> -->
        {{-- @if (Auth::user()->getUserPermission->name_position == "superadmin") --}}
        {{-- @endif --}}
        <!-- <li>
            <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap text-gray-900 dark:text-white">Tool</span>
            </a>
        </li> -->
        <!-- <ul class="pt-2 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"> -->
        <!-- <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M21 6.375c0 2.692-4.03 4.875-9 4.875S3 9.067 3 6.375 7.03 1.5 12 1.5s9 2.183 9 4.875Z" />
                    <path d="M12 12.75c2.685 0 5.19-.586 7.078-1.609a8.283 8.283 0 0 0 1.897-1.384c.016.121.025.244.025.368C21 12.817 16.97 15 12 15s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.285 8.285 0 0 0 1.897 1.384C6.809 12.164 9.315 12.75 12 12.75Z" />
                    <path d="M12 16.5c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 15.914 9.315 16.5 12 16.5Z" />
                    <path d="M12 20.25c2.685 0 5.19-.586 7.078-1.609a8.282 8.282 0 0 0 1.897-1.384c.016.121.025.244.025.368 0 2.692-4.03 4.875-9 4.875s-9-2.183-9-4.875c0-.124.009-.247.025-.368a8.284 8.284 0 0 0 1.897 1.384C6.809 19.664 9.315 20.25 12 20.25Z" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Database</span>
            </a>
        </li> -->
            <!-- <li>
            <a href="#" class="flex items-center mt-5 p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                </svg>
                <span class="ms-3">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Photo</span>
            </a>
        </li> -->
        <!-- <ul class="pt-2 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"> -->
        <!-- <li class="relative w-[230px] overflow-hidden group">
            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-10 opacity-0 z-10 cursor-pointer ">
            <div class="flex peer group-hover:bg-gray-100 dark:group-hover:bg-[#303030] duration-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 mt-2 ml-3 text-black dark:text-white">
                    <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                </svg>
                <div class="bg-white dark:bg-[#202020] text-white h-10 w-full pl-1.5 flex items-center duration-500 group-hover:bg-gray-100 dark:group-hover:bg-[#303030]">
                    <h1 class="text-black dark:text-white text-md">
                        Category
                    </h1>
                </div>
            </div>
            <div class="absolute top-4 left-1 transition-tranform duration-500 rotate-0 peer-checked:rotate-90">
                <svg class="w-3 h-3 text-gray-800 dark:text-white " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 10 16">
                    <path d="M3.414 1A2 2 0 0 0 0 2.414v11.172A2 2 0 0 0 3.414 15L9 9.414a2 2 0 0 0 0-2.828L3.414 1Z"/>
                </svg>
            </div>
            <ul class="bg-[#f9f9f9] dark:bg-[#232323] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40">
                <li>
                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mt-0.5 mr-1.5 text-black dark:text-white">
                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                        </svg>
                        <a href="#" class="">Products</a>
                    </div>
                </li>
                <li>
                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mt-0.5 mr-1.5 text-black dark:text-white">
                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                        </svg>
                        <a href="#" class="">Billing</a>
                    </div>
                </li>
                <li>
                    <div class="flex w-full p-2 text-gray-900 transition duration-75 rounded-sm pl-8 group hover:bg-gray-100 dark:text-white dark:hover:bg-[#303030]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mt-0.5 mr-1.5 text-black dark:text-white">
                            <path d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                        </svg>
                        <a href="#" class="">Invoice</a>
                    </div>
                </li>
            </ul>
        </li> -->
        <!-- <li>
            <a class="flex items-center p-2 text-gray-900 rounded-sm dark:text-white hover:bg-gray-100 dark:hover:bg-[#303030] group {{ (request()->is('search_school') || request()->is('search_school')) ? 'rounded-sm bg-gray-100 dark:bg-[#303030] duration-500': '' }}" href="{{ route('search_school') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">School</span>
            </a>
        </li> -->
    </div>
</aside>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> -->
<!-- <script src="https://cdn.tailwindcss.com"></script> -->
<!-- <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>

    function ajaxGetNotiPM() {
        $.ajax({
            type: "GET",
            url: "{{ route('get_receive_pm') }}",
            success: function (res) {
                console.log('res', res);
                if(res){
                    $("#count_noti_pm").html(res);

                }else{
                    $("#count_noti_pm").empty();
                }
            },
            error: function(){
                console.log(res);
            }
        });
    }
    function ajaxGetNoti() {
        $.ajax({
            type: "GET",
            url: "{{ route('get_receive') }}",
            success: function (res) {
                console.log('res', res);
                if(res){
                    $("#count_noti").html(res);

                }else{
                    $("#count_noti").empty();
                }
            },
            error: function(){
                console.log(res);
            }
        });
    }

    ajaxGetNotiPM();
    ajaxGetNoti();

    const pusher1  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
    const channel1 = pusher1.subscribe('public');

    channel1.bind('chat', function (data) {
        $.post("/receive", {
            _token:  '{{csrf_token()}}',
            message: data.message,
        })
        .done(function (res) {
            console.log("🚀 ~ res:", res)
            const count_noti = document.getElementById('count_noti')
            if (res == 0) {
                count_noti.remove()
            }else {
                count_noti.innerHTML = res
            }
        });
    });

    let menuAll = <?php echo json_encode($menuPpermissions); ?>;
        // console.log("🚀 ~ menuAll:", menuAll)
        // if(){
            menuAll.forEach((element, index) => {
            });
        // }
</script>
