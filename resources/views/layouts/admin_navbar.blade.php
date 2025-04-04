<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    .cl-select {
        padding: 5px;
        border-radius: 5px;
    }
    .btn-rotate:hover .rotate{
        transform: rotate(180deg);
        transition: 0.5s all;
    }
    @font-face {
        font-family: NotoColorEmojiLimited;
        unicode-range: U+1F1E6-1F1FF;
        /* src: url(https://raw.githack.com/googlefonts/noto-emoji/main/fonts/NotoColorEmoji.ttf); */
        src: url('{{ asset('fonts/noto.ttf') }}');
    }

    div {
        font-family: 'NotoColorEmojiLimited', -apple-system, BlinkMacSystemFont,
        'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji',
        'Segoe UI Emoji', 'Segoe UI Symbol';
    }
    </style>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css"> -->
</head>

<nav class="fixed top-0 z-50 w-full border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-[#202020] duration-500 no-print animate-fade-in-down">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-sm md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-[#303030] dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Hamburger icon -->
                    <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>

                @php
                    $text = "Product Master";
                @endphp

                <span class="self-center text-md font-semibold sm:text-xl whitespace-nowrap text-black dark:text-white ml-2.5 animate-fade-in-up">
                    @foreach(collect(mb_str_split($text)) as $index => $char)
                        <span class="text-black dark:text-white opacity-0 animate-slide-in" style="animation-delay: {{ $index * 0.1 }}s">
                            {!! $char === ' ' ? '&nbsp;' : $char !!}
                        </span>
                    @endforeach
                </span>
            </div>
            <div class="flex items-center space-x-1 rtl:space-x-reverse">

                <div class="relative" data-twe-dropdown-ref>
                    <button
                        class="flex items-center rounded bg-[#00000] dark:bg-[#303030] hover:bg-gray-100 dark:hover:bg-[#404040] pr-2.5 pb-0.5 pt-0.5 text-sm uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        type="button"
                        id="dropdownMenuButton1"
                        data-twe-dropdown-toggle-ref
                        aria-expanded="false"
                        data-twe-ripple-init
                        data-twe-ripple-color="light">
                        <div id="auth_img" class="mr-1"></div>
                        <div id="auth_personcode_login" class="flex"></div>
                        <div id="auth_departmant_login" class="hidden md:inline-block"></div>
                        <span class="font-bold ms-0 w-2 [&>svg]:h-5 [&>svg]:w-5">
                        <svg
                            class="font-bold text-black dark:text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                            fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                        </svg>
                        </span>
                    </button>
                    <ul class="pb-0.5 pt-0.5 absolute divide-y divide-gray-600 rounded-sm w-auto md:w-64 dark:divide-gray-600 z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-[#303030]"
                        aria-labelledby="dropdownMenuButton1"
                        data-twe-dropdown-menu-ref>
                        <li>
                            <div class="text-center">
                                <div id="profile_img" class="mt-2 mb-1"></div>
                                <div id="auth_fullname_login" class=""></div>
                                <div id="auth_department" class=""></div>
                                <div id="auth_email_login" class="text-gray-900 dark:text-white">
                                <!-- @if (Auth::user()->userRole->pluck('position.name_position')->count() > 1)
                                    <span class="text-gray-900 dark:text-white">Test</span>
                                @endif
                                {{ Auth::user()->userRole->pluck('position.name_position')->implode(', ') }} -->
                                </div>
                            </div>
                        </li>
                        @if (Auth::user()->userRole->pluck('position.name_position')->count() > 1)
                            <li>
                                <a href="{{ route('switch_role') }}" class="btn-rotate">
                                    <div class="text-center cursor-pointer bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-[#303030] dark:text-white dark:hover:bg-[#404040] dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25">
                                        <svg class="hidden h-5 w-5 md:inline-block rotate"
                                            viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1" fill="currentColor">
                                            <path d="M 93,62 C 83,82 65,96 48,96 32,96 19,89 15,79 L 5,90 5,53 40,53 29,63 c 0,0 5,14 26,14 16,0 38,-15 38,-15 z"/>
                                            <path d="M 5,38 C 11,18 32,4 49,4 65,4 78,11 85,21 L 95,10 95,47 57,47 68,37 C 68,37 63,23 42,23 26,23 5,38 5,38 z"/>
                                        </svg>
                                        <span class="text-gray-900 dark:text-white">Switch Role</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}" class="flex items-center justify-center w-full bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-[#303030] dark:text-white dark:hover:bg-[#404040] dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                                <svg fill="currentColor" class="mr-1 mt-1 hidden h-5 w-5 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- @php
                    $current_lang = session()->get('locale');
                @endphp
                <div class="flex ml-2">
                    <select id="select_locale" class="block w-full p-2 bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm">
                        <option value="en" {{ $current_lang == 'en' ? 'selected' :'' }} style="font-family: Noto Emoji, sans-serif; font-size:14">
                            @lang('global.menu.en')
                        </option>
                        <ul class="pt-1 mt-1 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                        <option value="th" {{ $current_lang == 'th' ? 'selected' :'' }} style="font-family: Noto Emoji, sans-serif; font-size:14">
                            @lang('global.menu.th')
                        </option>
                    </select>
                </div> -->

                @php
                    $current_lang = session()->get('locale', 'en');
                    $languages = [
                        'en' => ['flag' => '🇬🇧', 'label' => __('global.menu.en')],
                        'th' => ['flag' => '🇹🇭', 'label' => __('global.menu.th')],
                    ];
                @endphp

                <!-- ช่อง input ซ่อนค่า lang -->
                <input type="hidden" id="url" value="{{ $current_lang }}">

                <div class="relative">
                    <!-- ปุ่มแสดงภาษาปัจจุบัน -->
                    <button id="dropdownMenuButton2" class="md:w-24 flex items-center rounded px-1 py-0.5 text-gray-900 dark:text-white bg-[#00000] dark:bg-[#303030] hover:bg-gray-100 dark:hover:bg-[#404040] pr-2.5 pb-0.5 pt-0.5 text-sm uppercase leading-normal shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none">
                        <div id="img_flag" class="mr-1">{{ $languages[$current_lang]['flag'] }}</div>
                        <div id="text_language" class="flex">{{ $languages[$current_lang]['label'] }}</div>
                        <span class="font-bold ms-6 w-5">
                            <svg class="font-bold text-black dark:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <!-- Dropdown เลือกภาษา -->
                    <ul id="languageDropdown" class="absolute hidden z-[1000] w-auto md:w-24 list-none bg-white dark:bg-[#303030] shadow-lg">
                        @foreach ($languages as $lang => $data)
                            <li>
                                <div class="text-center text-black dark:text-white cursor-pointer px-2 py-2 text-sm font-bold hover:bg-zinc-200/60 dark:hover:bg-[#404040]" onclick="changeLanguage('{{ $lang }}', '{{ $data['flag'] }}', '{{ $data['label'] }}')">
                                    <span>{{ $data['flag'] }} {{ $data['label'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-sm text-black dark:text-white ml-2">
                    <button @click="darkMode=!darkMode" type="button" class="relative inline-flex flex-shrink-0 h-6 mr-1 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-zinc-200 dark:bg-zinc-700 w-11 focus:outline-none focus:ring-2 focus:ring-neutral-700 focus:ring-offset-2" role="switch" aria-checked="false">
                        <span class="sr-only">Use setting</span>
                        <span class="relative inline-block w-5 h-5 transition duration-500 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none dark:translate-x-5 ring-0">
                        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-500 ease-in opacity-100 dark:opacity-0 dark:duration-100 dark:ease-out" aria-hidden="true">
                            {{--
                            <x-svg class="w-4 h-4 text-neutral-700" svg="sun"/>
                            --}}
                            <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun w-4 h-4 text-neutral-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                            </svg>
                        </span>
                        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-100 ease-out opacity-0 dark:opacity-100 dark:duration-200 dark:ease-in" aria-hidden="true">
                            {{--
                            <x-svg class="w-4 h-4 text-neutral-700" svg="moon"/>
                            --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moon w-4 h-4 text-neutral-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                            </svg>
                        </span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</nav>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            console.log("✅ JavaScript Loaded!");

            // เปิด/ปิด Dropdown
            document.getElementById("dropdownMenuButton2").addEventListener("click", function () {
                let dropdown = document.getElementById("languageDropdown");
                dropdown.classList.toggle("hidden");
            });

            // เปลี่ยนภาษา
            window.changeLanguage = function (lang, flag, label) {
                console.log("🔄 Changing language to:", lang, flag, label);

                let authImg = document.getElementById('img_flag');
                let authLabel = document.getElementById('text_language');
                let hiddenInput = document.getElementById("url");

                if (authImg) authImg.innerHTML = flag;
                if (authLabel) authLabel.innerHTML = label;
                if (hiddenInput) hiddenInput.value = lang;

                console.log("✅ UI Updated:", authImg.innerHTML, authLabel.innerHTML);

                // ส่งค่าไปเปลี่ยนภาษาใน Session
                fetch(`/greeting/${lang}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("🔄 API Response:", data);
                        if (data.status === 200) {
                            // รีโหลดหน้าเพื่อให้ภาษาเปลี่ยน
                            setTimeout(() => {
                                window.location.reload(true);
                            }, 300);
                        } else {
                            console.error("❌ Failed to update language on server.");
                        }
                    })
                    .catch(error => console.error("❌ Error changing language:", error));
            };
        });

    </script>
