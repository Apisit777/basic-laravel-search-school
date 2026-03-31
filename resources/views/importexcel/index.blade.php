
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Icon favicon -->
    <link rel="icon" type="image/png" href="{{ asset('media/favicon2.png')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/twitter-bootstrap4.0.0/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
            height: 10px;
            width: 10px;
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
        .dt-length  {
            color: #818181!important;
        }

        .table td, .table th {
            padding: 0.55rem !important;
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

        .flag-text { margin-left: 10px; }

        /* ==================== Transfer Panel — HUD Dashboard ==================== */
        /* CRT scanline overlay (dark only) */
        .tf-container::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }
        .dark .tf-container::before {
            background:
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,0,0,0.02) 2px, rgba(255,0,0,0.02) 4px);
        }

        /* Corner marks */
        .tf-corner {
            position: absolute;
            width: 14px;
            height: 14px;
            border-color: #cc0000;
            border-style: solid;
            border-width: 0;
            z-index: 5;
        }
        .dark .tf-corner { border-color: #cc0000; }
        .tf-corner-tl { top: 6px; left: 6px; border-top-width: 2px; border-left-width: 2px; }
        .tf-corner-tr { top: 6px; right: 6px; border-top-width: 2px; border-right-width: 2px; }
        .tf-corner-bl { bottom: 6px; left: 6px; border-bottom-width: 2px; border-left-width: 2px; }
        .tf-corner-br { bottom: 6px; right: 6px; border-bottom-width: 2px; border-right-width: 2px; }

        /* Side panels */
        .tf-panel {
            flex: 1;
            max-width: 280px;
            padding: 0 8px;
            z-index: 2;
        }
        .tf-panel-header {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 8px;
        }
        .tf-panel-left .tf-panel-header { justify-content: flex-start; }
        .tf-panel-right .tf-panel-header { justify-content: flex-end; }

        .tf-bracket {
            font-size: 18px;
            font-weight: 300;
            color: #cc000066;
        }
        .dark .tf-bracket { color: #ff1a1a88; }

        .tf-label {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 6px;
            color: #cc0000;
        }
        .dark .tf-label {
            color: #ff1a1a;
            text-shadow: 0 0 15px rgba(255,26,26,0.5), 0 0 30px rgba(255,26,26,0.2);
        }

        .tf-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #aaa;
            margin: 0 4px;
            transition: all 0.3s;
        }
        .dark .tf-dot { background: #666; }
        .tf-dot.active {
            background: #cc0000;
            box-shadow: 0 0 6px rgba(204,0,0,0.6);
        }
        .dark .tf-dot.active {
            background: #ff1a1a;
            box-shadow: 0 0 8px rgba(255,26,26,0.8);
        }
        .tf-dot.done {
            background: #059669;
            box-shadow: 0 0 6px rgba(5,150,105,0.5);
        }
        .dark .tf-dot.done {
            background: #00ff88;
            box-shadow: 0 0 8px rgba(0,255,136,0.8);
        }

        /* Status row */
        .tf-status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .tf-status-lbl {
            font-size: 10px;
            letter-spacing: 2px;
            color: #666;
        }
        .dark .tf-status-lbl { color: #888; }
        .tf-status {
            font-size: 9px;
            letter-spacing: 2px;
            color: #555;
            transition: color 0.3s;
        }
        .dark .tf-status { color: #aaa; }
        .tf-status.active { color: #cc0000; }
        .dark .tf-status.active {
            color: #ff4444;
            text-shadow: 0 0 6px rgba(255,68,68,0.5);
        }
        .tf-status.done { color: #059669; }
        .dark .tf-status.done {
            color: #00ff88;
            text-shadow: 0 0 6px rgba(0,255,136,0.5);
        }

        /* Segmented progress bar */
        .tf-seg-bar {
            position: relative;
            height: 14px;
            background: #e5e7eb;
            border: 1px solid #d1d5db;
            margin: 6px 0;
            overflow: hidden;
        }
        .dark .tf-seg-bar {
            background: #111;
            border-color: #1a1a1a;
        }
        .tf-seg-fill {
            height: 100%;
            width: 0%;
            position: relative;
            transition: width 0.3s ease;
            background: #cc0000;
        }
        .dark .tf-seg-fill {
            background: #ff1a1a;
            box-shadow: 0 0 10px rgba(255,26,26,0.4);
        }
        /* Segment gaps overlay */
        .tf-seg-fill::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(90deg,
                transparent 0px, transparent 12px,
                #e5e7eb 12px, #e5e7eb 14px);
            pointer-events: none;
        }
        .dark .tf-seg-fill::after {
            background: repeating-linear-gradient(90deg,
                transparent 0px, transparent 12px,
                #111 12px, #111 14px);
        }

        /* Data rows */
        .tf-data-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 3px 0;
        }
        .tf-data-lbl {
            font-size: 10px;
            letter-spacing: 2px;
            color: #666;
        }
        .dark .tf-data-lbl { color: #888; }
        .tf-data-val {
            font-size: 10px;
            font-weight: bold;
            color: #cc0000;
            letter-spacing: 1px;
        }
        .dark .tf-data-val {
            color: #ff4444;
            text-shadow: 0 0 4px rgba(255,68,68,0.3);
        }

        /* Center hub area — label on top, arcs below */
        .tf-hub-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 16px;
            gap: 4px;
            z-index: 2;
        }
        .tf-hub {
            position: relative;
            width: 84px;
            height: 84px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* SVG arc rings */
        .tf-hub-ring {
            position: absolute;
            top: 50%;
            left: 50%;
        }
        .tf-arc-outer {
            width: 84px;
            height: 84px;
            transform: translate(-50%, -50%);
            color: #cc0000;
        }
        .dark .tf-arc-outer { color: #cc0000; }
        .tf-arc-inner {
            width: 62px;
            height: 62px;
            transform: translate(-50%, -50%);
            color: #cc0000;
        }
        .dark .tf-arc-inner { color: #cc0000; }

        /* Spinning */
        .tf-arc-outer.spinning {
            /* animation: spinArc 2.5s linear infinite; */
            color: #cc0000;
            filter: drop-shadow(0 0 4px rgba(204,0,0,0.5));
        }
        .dark .tf-arc-outer.spinning {
            color: #ff1a1a;
            filter: drop-shadow(0 0 8px rgba(255,26,26,0.7));
        }
        .tf-arc-inner.spinning {
            /* animation: spinArcRev 1.8s linear infinite; */
            color: #cc0000;
            filter: drop-shadow(0 0 3px rgba(204,0,0,0.4));
        }
        .dark .tf-arc-inner.spinning {
            color: #ff1a1a;
            filter: drop-shadow(0 0 6px rgba(255,26,26,0.6));
        }
        @keyframes spinArc {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @keyframes spinArcRev {
            from { transform: translate(-50%, -50%) rotate(360deg); }
            to { transform: translate(-50%, -50%) rotate(0deg); }
        }

        /* Hub core (center icon) */
        .tf-hub-core {
            width: 30px;
            height: 30px;
            background: radial-gradient(circle, #f9fafb, #f3f4f6);
            border: 1px solid #cc000033;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        .dark .tf-hub-core {
            background: radial-gradient(circle, #1a0a0a, #0a0a0f);
            border-color: #ff1a1a33;
        }
        .tf-hub-core.active {
            border-color: #cc0000;
            box-shadow: 0 0 12px rgba(204,0,0,0.3);
        }
        .dark .tf-hub-core.active {
            border-color: #ff1a1a;
            box-shadow: 0 0 20px rgba(255,26,26,0.4), 0 0 40px rgba(255,26,26,0.1);
        }
        .tf-hub-icon {
            width: 14px;
            height: 14px;
            color: #cc0000;
            transition: color 0.3s;
        }
        .dark .tf-hub-icon { color: #cc0000; }
        .tf-hub-core.active .tf-hub-icon { color: #cc0000; }
        .dark .tf-hub-core.active .tf-hub-icon {
            color: #ff1a1a;
            filter: drop-shadow(0 0 4px rgba(255,26,26,0.6));
        }

        /* Hub label — above arcs */
        .tf-hub-label {
            font-size: 10px;
            letter-spacing: 4px;
            color: #666;
            transition: color 0.3s;
            white-space: nowrap;
        }
        .dark .tf-hub-label { color: #aaa; }
        .tf-hub-label.active { color: #cc0000; }
        .dark .tf-hub-label.active {
            color: #ff4444;
            text-shadow: 0 0 8px rgba(255,68,68,0.4);
        }

        /* Bottom decoration line */
        .tf-bottom-line {
            position: absolute;
            bottom: 8px;
            left: 24px;
            right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #cc000033, #cc000066, #cc000033, transparent);
            z-index: 2;
        }
        .dark .tf-bottom-line {
            background: linear-gradient(90deg, transparent, #ff1a1a22, #ff1a1a44, #ff1a1a22, transparent);
        }

        /* Scan line */
        .tf-scanline {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #cc000044, transparent);
            opacity: 0;
            z-index: 10;
        }
        .dark .tf-scanline {
            background: linear-gradient(90deg, transparent, #ff1a1a44, transparent);
        }
        .tf-scanline.active {
            animation: scanDown 2s linear infinite;
        }
        @keyframes scanDown {
            0% { top: 0; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* ─── Done state ─── */
        .tf-container.done .tf-label { color: #059669; }
        .dark .tf-container.done .tf-label {
            color: #00ff88;
            text-shadow: 0 0 15px rgba(0,255,136,0.5), 0 0 30px rgba(0,255,136,0.2);
        }
        .tf-container.done .tf-seg-fill { background: #059669; }
        .dark .tf-container.done .tf-seg-fill {
            background: #00ff88;
            box-shadow: 0 0 10px rgba(0,255,136,0.4);
        }
        .tf-container.done .tf-hub-core { border-color: #059669; }
        .dark .tf-container.done .tf-hub-core {
            border-color: #00ff88;
            box-shadow: 0 0 20px rgba(0,255,136,0.4);
        }
        .tf-container.done .tf-hub-icon { color: #059669; }
        .dark .tf-container.done .tf-hub-icon { color: #00ff88; }
        .tf-container.done .tf-hub-label { color: #059669; }
        .dark .tf-container.done .tf-hub-label { color: #00ff88; }
        .tf-container.done .tf-arc-outer,
        .tf-container.done .tf-arc-inner { color: #059669; }
        .dark .tf-container.done .tf-arc-outer,
        .dark .tf-container.done .tf-arc-inner { color: #00ff88; filter: drop-shadow(0 0 6px rgba(0,255,136,0.5)); }
        .tf-container.done .tf-data-val { color: #059669; }
        .dark .tf-container.done .tf-data-val { color: #00ff88; }
        .tf-container.done .tf-bottom-line {
            background: linear-gradient(90deg, transparent, #05966933, #05966966, #05966933, transparent);
        }
        .dark .tf-container.done .tf-bottom-line {
            background: linear-gradient(90deg, transparent, #00ff8822, #00ff8844, #00ff8822, transparent);
        }

        /* ************************************************************************* */

        @page {
            size: 210mm 297mm;
            margin: 0;
        }

        @media print {

            /* Print settings */
            body {
                margin-left: 0 !important;
            }

            page {
                width: 210mm;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }
            .print_page_number{
                right: -70 !important;
            }
            .no-overflow {
                overflow: hidden;
            }

            #Header,
            #Footer {
                display: none !important;
            }

            button {
                display: none;
            }

            size: A4 portrait;
            /* ... the rest of the rules ... */
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            #print_page{
                position: relative !important;
                top: -40px !important;
                width: auto !important;
                height: auto !important;
                overflow: visible !important;
                display: block !important;
            }
        }

        .a4-line {
            border-top: 1px dashed black;
            width: 100%;
        }

        /* #coin {
            width: 100px;
            height: 100px;
            animation: flip 2s infinite linear;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        @keyframes flip {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(360deg);
            }
        } */

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




        /* polygon เดิม (frame) */
  .hud-frame{
    clip-path: polygon(
      5% 0%,
      35% 0%,
      40% 5%,
      60% 5%,
      65% 0%,
      95% 0%,
      100% 5%,
      100% 25%,
      97.5% 30%,
      97.5% 70%,
      100% 75%,
      100% 95%,
      95% 100%,
      65% 100%,
      60% 95%,
      40% 95%,
      35% 100%,
      5% 100%,
      0% 95%,
      0% 75%,
      2.5% 70%,
      2.5% 30%,
      0% 25%,
      0% 5%
    );
  }

  .hud-left{
    clip-path: polygon(
      0% 25%,
      100% 30%,
      100% 70%,
      0% 75%
    );
  }

  .hud-right{
    clip-path: polygon(
      100% 25%,
      0% 30%,
      0% 70%,
      100% 75%
    );
  }




  .toggle-btn {
            padding: 4px 5px;
            border: none;
            background: none;
            cursor: pointer;
            color: white;
            background-color: #2a2a2a;
            transition: background 0.3s;
        }
        .toggle-btn.active {
            background-color: #05395D;
        }
        
        /* สไตล์ปุ่ม (แล้วแต่ของเดิม) */
        .toggle-btn {
            background: #404040;
            color: #fff;
            border-radius: 4px;
            transition: 0.2s;
        }
        .toggle-btn:hover { background: #3b3b3b; }
        .toggle-btn.active { background: #05395D; }



        .ui-datepicker-calendar {
            display: none;
        }

        /* jQuery UI Datepicker — z-index + sizing + dark mode */
        .ui-datepicker {
            z-index: 9999 !important;
            overflow: visible !important;
            width: 280px !important;
            padding: 8px !important;
            margin-top: -30px !important;
        }
        .ui-datepicker-header {
            overflow: visible !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 4px !important;
        }
        .ui-datepicker-title {
            display: flex;
            gap: 6px;
        }
        .ui-datepicker select.ui-datepicker-month,
        .ui-datepicker select.ui-datepicker-year {
            width: auto;
            min-width: 75px;
            padding: 2px 4px;
            font-size: 14px;
        }
        .dark .ui-datepicker {
            background: #1e1e1e;
            border: 1px solid #444;
            color: #e0e0e0;
        }
        .dark .ui-datepicker-header {
            background: #2a2a2a;
            border-color: #444;
            color: #e0e0e0;
        }
        .dark .ui-datepicker-header .ui-datepicker-prev,
        .dark .ui-datepicker-header .ui-datepicker-next {
            filter: invert(1);
        }
        .dark .ui-datepicker select.ui-datepicker-month,
        .dark .ui-datepicker select.ui-datepicker-year {
            background: #333;
            color: #e0e0e0;
            border: 1px solid #555;
        }
        .dark .ui-datepicker-buttonpane {
            background: #2a2a2a;
            border-color: #444;
        }
        .dark .ui-datepicker-buttonpane button {
            background: #333;
            color: #e0e0e0;
            border: 1px solid #555;
        }
        .dark .ui-datepicker-buttonpane button:hover {
            background: #444;
        }

    </style>
</head>

    <body x-cloak x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }" class="relative antialiased">

        <nav class="fixed top-0 z-50 w-full border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-[#202020] duration-500 no-print">
            <div class="px-3 py-2 lg:px-5 lg:pl-3">
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
                            $text = "Tranferdata";
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

                        <div class="flex items-center justify-center gap-2 text-center cursor-pointer">
                            <button
                                @click="darkMode=!darkMode"
                                type="button"
                                class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-zinc-200 dark:bg-zinc-900 w-11 focus:outline-none focus:ring-2 focus:ring-neutral-700 focus:ring-offset-2"
                                role="switch"
                                aria-checked="false"
                            >
                                <span class="sr-only">Use setting</span>
                                <span class="relative inline-block w-5 h-5 transition duration-500 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none dark:translate-x-5 ring-0">
                                    <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-500 ease-in opacity-100 dark:opacity-0 dark:duration-100 dark:ease-out" aria-hidden="true">
                                        <img src="{{URL::asset('media/sunny.png')}}" class="w-4 h-4" />
                                    </span>
                                    <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-100 ease-out opacity-0 dark:opacity-100 dark:duration-200 dark:ease-in" aria-hidden="true">
                                        <img src="{{URL::asset('media/half-moon.png')}}" class="w-4 h-4" />
                                    </span>
                                </span>
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </nav>


        <div class="justify-center items-center no-print">
            <div class="bg-white shadow-lg dark:bg-[#232323] duration-500 md:p-1 mt-10">
                <!-- <div class="flex justify-center items-center">
                    <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Stock Tranfer</p>
                </div> -->
                <!-- Import Excel Button -->
                <div class="w-full p-2 flex justify-end">

                    <label for="startDate" class="font-bold text-gray-900 dark:text-gray-100 mr-2 mt-1">Date :</label>
                    <input name="startDate" id="startDate" class="date-picker bg-[#E4E4E7] dark:bg-[#303030] text-gray-900 dark:text-gray-100 rounded-sm cursor-pointer mr-2" data-date-format="mm/yyyy" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off" />

                    <a id="openImportModal"
                        class="inline-flex items-center gap-2 px-2.5 py-1 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded cursor-pointer transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg id="importIconNormal" viewBox="-4 0 64 64" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path d="M5.112.006c-2.802 0-5.073 2.273-5.073 5.074v53.841c0 2.803 2.271 5.074 5.073 5.074h45.774c2.801 0 5.074-2.271 5.074-5.074v-38.605l-18.902-20.31h-31.946z" fill-rule="evenodd" clip-rule="evenodd" fill="#45B058"/>
                            <path d="M19.429 53.938c-.216 0-.415-.09-.54-.27l-3.728-4.97-3.745 4.97c-.126.18-.324.27-.54.27-.396 0-.72-.306-.72-.72 0-.144.035-.306.144-.432l3.89-5.131-3.619-4.826c-.09-.126-.145-.27-.145-.414 0-.342.288-.72.721-.72.216 0 .432.108.576.288l3.438 4.628 3.438-4.646c.127-.18.324-.27.541-.27.378 0 .738.306.738.72 0 .144-.036.288-.127.414l-3.619 4.808 3.891 5.149c.09.126.125.27.125.414 0 .396-.324.738-.719.738zm9.989-.126h-5.455c-.595 0-1.081-.486-1.081-1.08v-10.317c0-.396.324-.72.774-.72.396 0 .721.324.721.72v10.065h5.041c.359 0 .648.288.648.648 0 .396-.289.684-.648.684zm6.982.216c-1.782 0-3.188-.594-4.213-1.495-.162-.144-.234-.342-.234-.54 0-.36.27-.756.702-.756.144 0 .306.036.433.144.828.738 1.98 1.314 3.367 1.314 2.143 0 2.826-1.152 2.826-2.071 0-3.097-7.111-1.386-7.111-5.672 0-1.98 1.764-3.331 4.123-3.331 1.548 0 2.881.468 3.853 1.278.162.144.253.342.253.54 0 .36-.307.72-.703.72-.145 0-.307-.054-.432-.162-.883-.72-1.98-1.044-3.079-1.044-1.44 0-2.467.774-2.467 1.909 0 2.701 7.112 1.152 7.112 5.636 0 1.748-1.188 3.53-4.43 3.53z" fill="#ffffff"/>
                            <path d="M55.953 20.352v1h-12.801s-6.312-1.26-6.127-6.707c0 0 .207 5.707 6.002 5.707h12.926z" fill-rule="evenodd" clip-rule="evenodd" fill="#349C42"/>
                            <path d="M37.049 0v14.561c0 1.656 1.104 5.791 6.104 5.791h12.801l-18.905-20.352z" opacity=".5" fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff"/>
                        </svg>
                        <!-- Spinner (hidden by default) -->
                        <svg id="importIconSpinner" class="h-5 w-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span id="importBtnText">นำเข้าข้อมูล</span>
                    </a>
                </div>

                <!-- Import Modal -->
                <div id="importModal" class="fixed inset-0 z-[9999] items-center justify-start pt-20 bg-black bg-opacity-0 transition-all duration-300 ease-out" style="display:none">
                    <div id="modalContent" class="bg-white dark:bg-[#232323] rounded-lg shadow-xl w-full max-w-lg mx-auto opacity-0 -translate-y-10 transition-all duration-300 ease-out">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">นำเข้าข้อมูล</h3>
                            <button id="closeImportModal" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl leading-none">&times;</button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-4 space-y-4">
                            <form method="POST" enctype="multipart/form-data" id="importFormBoth">
                                @csrf
                                <!-- ========== TO → trn_diary1 ========== -->
                                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    <span class="inline-block px-2 py-0.5 bg-blue-600 text-white text-xs rounded mr-1">TO</span>
                                    เลือกไฟล์ → trn_diary1<span class="text-red-500">*</span>
                                </label>
                                <div id="dropZone1" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 dark:hover:border-blue-400 transition-colors">
                                    <input type="file" name="file1" id="file1" class="hidden" accept=".xls,.xlsx,.csv">
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Drag & Drop or <span class="text-blue-500 hover:underline font-semibold" id="browseBtn1">Browse</span></p>
                                    <p id="fileNameDisplay1" class="mt-1 text-sm text-green-600 dark:text-green-400 hidden"></p>
                                </div>

                                <div class="my-3"></div>

                                <!-- ========== TI → trn_diary2 ========== -->
                                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                                    <span class="inline-block px-2 py-0.5 bg-orange-500 text-white text-xs rounded mr-1">TI</span>
                                    เลือกไฟล์ → trn_diary2<span class="text-red-500">*</span>
                                </label>
                                <div id="dropZone2" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center cursor-pointer hover:border-orange-400 dark:hover:border-orange-400 transition-colors">
                                    <input type="file" name="file2" id="file2" class="hidden" accept=".xls,.xlsx,.csv">
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">Drag & Drop or <span class="text-orange-500 hover:underline font-semibold" id="browseBtn2">Browse</span></p>
                                    <p id="fileNameDisplay2" class="mt-1 text-sm text-green-600 dark:text-green-400 hidden"></p>
                                </div>

                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">รองรับไฟล์ .xls, .xlsx และ .csv ขนาดไม่เกิน 10MB</p>
                            </form>

                            <!-- Preview Compare -->
                            <div class="flex justify-center gap-2">
                                <button type="button" id="previewBtn" class="px-3 py-1 bg-[#0b771f] hover:bg-[#0c9c27] text-white font-semibold rounded transition-colors text-sm">เปรียบเทียบข้อมูล</button>
                                <button type="button" id="clearBtn" class="px-3 py-1 bg-gray-400 hover:bg-gray-500 dark:bg-gray-600 dark:hover:bg-gray-500 text-white font-semibold rounded transition-colors text-sm">ล้างข้อมูล</button>
                            </div>

                            <div id="previewSection" class="hidden">
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-100 dark:bg-[#303030] text-gray-700 dark:text-gray-300">
                                            <tr>
                                                <th class="px-3 py-2">Type</th>
                                                <th class="px-3 py-2 text-right">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody id="previewBody" class="text-gray-800 dark:text-gray-200"></tbody>
                                    </table>
                                </div>
                                <div id="previewStatus" class="mt-2 text-center text-sm font-semibold"></div>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" id="cancelImportModal" class="px-2.5 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-[#b90000] dark:hover:bg-[#ff0000] text-gray-700 dark:text-gray-200 font-semibold rounded transition-colors text-sm">ยกเลิก</button>
                                <button type="button" id="importBtnBoth" class="px-2.5 py-1 bg-[#285192] hover:bg-[#3565b1] text-white font-semibold rounded transition-colors text-sm hidden">ยืนยันการนำเข้า</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <ul class="pt-1 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul> -->
            </div>

            <!-- ==================== Transfer Loading Panel — HUD ==================== -->
            <div id="transferPanel">
                <div class="tf-container relative flex items-center justify-center bg-gray-50 dark:bg-[#202020] border border-gray-200 dark:border-[#1a1a2e] pt-2 px-6 pb-2 overflow-hidden font-mono">

                    <!-- Corner marks -->
                    <div class="tf-corner tf-corner-tl"></div>
                    <div class="tf-corner tf-corner-tr"></div>
                    <div class="tf-corner tf-corner-bl"></div>
                    <div class="tf-corner tf-corner-br"></div>

                    <!-- Scan line -->
                    <!-- <div class="tf-scanline"></div> -->

                    <!-- ─── Left Panel — IDC ─── -->
                    <div class="tf-panel tf-panel-left">
                        <!-- HUD Frame Button -->
                        <div class="relative w-full h-[55px] mb-3">
                            <div class="absolute inset-0 bg-[#cc0000] dark:bg-[#b90000] hud-frame"></div>
                            <div class="absolute inset-[1px] bg-gray-50 dark:bg-[#121212] hud-frame"></div>
                            <div class="absolute left-0 top-0 h-full w-[4px] bg-[#cc0000] dark:bg-[#b90000] hud-left"></div>
                            <div class="absolute right-0 top-0 h-full w-[4px] bg-[#cc0000] dark:bg-[#b90000] hud-right"></div>
                            <div class="absolute inset-0 flex items-center justify-center gap-2">
                                <span class="tf-label">IDC</span>
                                <span class="tf-dot" id="tfDotIDC"></span>
                            </div>
                        </div>

                        <div class="tf-status-row">
                            <span class="tf-status-lbl">STATUS</span>
                            <span class="tf-status" id="tfStatusIDC">STANDBY</span>
                        </div>
                        <div class="tf-seg-bar">
                            <div class="tf-seg-fill" id="tfBarIDC" style="width:0%"></div>
                        </div>
                        <div class="tf-data-row">
                            <span class="tf-data-lbl">ROWS</span>
                            <span class="tf-data-val" id="tfRowsIDC">0</span>
                        </div>
                        <div class="tf-data-row">
                            <span class="tf-data-lbl">PROGRESS</span>
                            <span class="tf-data-val" id="tfPctIDC">0%</span>
                        </div>
                    </div>

                    <!-- ─── Center Hub ─── -->
                    <div class="tf-hub-area">
                        <div class="tf-hub-label" id="tfHubText">TRANSFER</div>
                        <div class="tf-hub">
                            <svg class="tf-hub-ring tf-arc-outer" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5"
                                        stroke-dasharray="85 40 65 93" stroke-linecap="round"/>
                            </svg>
                            <svg class="tf-hub-ring tf-arc-inner" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="38" fill="none" stroke="currentColor" stroke-width="7"
                                        stroke-dasharray="65 35 55 109" stroke-linecap="round"/>
                            </svg>
                            <div class="tf-hub-core" id="tfHubCore">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="tf-hub-icon">
                                    <path d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- ─── Right Panel — KM ─── -->
                    <div class="tf-panel tf-panel-right">
                        <!-- HUD Frame Button -->
                        <div class="relative w-full h-[55px] mb-3">
                            <div class="absolute inset-0 bg-[#cc0000] dark:bg-[#b90000] hud-frame"></div>
                            <div class="absolute inset-[1px] bg-gray-50 dark:bg-[#121212] hud-frame"></div>
                            <div class="absolute left-0 top-0 h-full w-[4px] bg-[#cc0000] dark:bg-[#b90000] hud-left"></div>
                            <div class="absolute right-0 top-0 h-full w-[4px] bg-[#cc0000] dark:bg-[#b90000] hud-right"></div>
                            <div class="absolute inset-0 flex items-center justify-center gap-2">
                                <span class="tf-dot" id="tfDotKM"></span>
                                <span class="tf-label">KM</span>
                            </div>
                        </div>

                        <div class="tf-status-row">
                            <span class="tf-status" id="tfStatusKM">STANDBY</span>
                            <span class="tf-status-lbl">STATUS</span>
                        </div>
                        <div class="tf-seg-bar">
                            <div class="tf-seg-fill" id="tfBarKM" style="width:0%"></div>
                        </div>
                        <div class="tf-data-row">
                            <span class="tf-data-val" id="tfRowsKM">0</span>
                            <span class="tf-data-lbl">ROWS</span>
                        </div>
                        <div class="tf-data-row">
                            <span class="tf-data-val" id="tfPctKM">0%</span>
                            <span class="tf-data-lbl">PROGRESS</span>
                        </div>
                    </div>

                    <!-- Bottom decoration line -->
                    <div class="tf-bottom-line"></div>
                </div>
            </div>

            <div class="buttons-wrapper relative">
                <div class="buttons-panel absolute inset-x-0 top-10 z-20 flex items-center justify-between space-x-2 mr-3">
                    <!-- ซ้าย: 3 ปุ่ม filter -->
                    <div class="flex items-center space-x-2">
                        <!-- <button class="toggle-btn px-3 py-1">รายการทั้งหมด</button> -->
                    </div>

                    <!-- ขวา: ปุ่มสลับ table -->
                    <div class="flex items-center space-x-2">
                        <button id="btn-list-external"
                                class="toggle-btn active px-3 py-1 text-sm">
                            📋 List External
                        </button>
                        <button id="btn-list-km"
                                class="toggle-btn px-3 py-1 text-sm">
                            📋 List KM
                        </button>
                    </div>
                </div>
            </div>

            <!-- ─── View: External ─── -->
            <div id="view-external" class="bg-white shadow-lg dark:bg-[#232323] duration-500 md:p-4">
                <div class="text-gray-900 dark:text-gray-100">
                    <table id="table-external" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>product_id</th>
                                <th>doc_date</th>
                                <th>doc_tp</th>
                                <th>branch_id</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- ─── View: KM ─── -->
            <div id="view-km" class="bg-white shadow-lg dark:bg-[#232323] duration-500 md:p-4" style="display:none">
                <div class="text-gray-900 dark:text-gray-100">
                    <table id="table-km" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>company_id</th>
                                <th>doc_no</th>
                                <th>doc_date</th>
                                <th>doc_tp</th>
                                <th>corporation_id</th>
                                <th>branch_id</th>
                                <th>member_id</th>
                                <th>product_id</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>

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
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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

        // เก็บค่า date_month ที่เลือก (format: "2026-02")
        var selectedDateMonth = '';

        function getDateMonth() {
            return selectedDateMonth;
        }

        // Search ทั้งหมด — reload Transfer + DataTables
        function searchAll() {
            tfLoadStatus();
            if ($.fn.DataTable.isDataTable('#table-external')) {
                $('#table-external').DataTable().ajax.reload();
            }
            if ($.fn.DataTable.isDataTable('#table-km')) {
                $('#table-km').DataTable().ajax.reload();
            }
        }

        $(function() {
            $('.date-picker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                beforeShow: function(input, inst) {
                    setTimeout(function() {
                        inst.dpDiv.css({ zIndex: 9999 });
                    }, 0);
                },
                onClose: function(dateText, inst) {
                    var y = inst.selectedYear;
                    var m = ('0' + (inst.selectedMonth + 1)).slice(-2);
                    $(this).datepicker('setDate', new Date(y, inst.selectedMonth, 1));
                    selectedDateMonth = y + '-' + m;
                    searchAll();
                }
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        // ========== Import Modal ==========
        function openImportModal() {
            var modal = $('#importModal');
            var content = $('#modalContent');
            modal.css('display', 'flex');
            setTimeout(function() {
                modal.removeClass('bg-opacity-0').addClass('bg-opacity-50');
                content.removeClass('opacity-0 -translate-y-10').addClass('opacity-100 translate-y-0');
            }, 10);
        }
        function closeImportModal() {
            var modal = $('#importModal');
            var content = $('#modalContent');
            modal.removeClass('bg-opacity-50').addClass('bg-opacity-0');
            content.removeClass('opacity-100 translate-y-0').addClass('opacity-0 -translate-y-10');
            setTimeout(function() {
                modal.css('display', 'none');
                $('#file1, #file2').val('');
                $('#fileNameDisplay1, #fileNameDisplay2').addClass('hidden').text('');
            }, 300);
        }

        $('#openImportModal').on('click', function() {
            // Show loading on button
            $('#importIconNormal').addClass('hidden');
            $('#importIconSpinner').removeClass('hidden');
            // $('#importBtnText').text('กำลังโหลด...');
            $(this).addClass('pointer-events-none opacity-80');

            setTimeout(function() {
                // Reset button
                $('#importIconNormal').removeClass('hidden');
                $('#importIconSpinner').addClass('hidden');
                $('#importBtnText').text('นำเข้าข้อมูล');
                $('#openImportModal').removeClass('pointer-events-none opacity-80');
                // Open modal
                openImportModal();
            }, 800);
        });
        $('#closeImportModal, #cancelImportModal').on('click', closeImportModal);
        $('#importModal').on('click.backdrop', function(e) {
            if (e.target === this) closeImportModal();
        });

        // ========== Drag & Drop Helper ==========
        function setupDropZone(zoneId, fileId, browseBtnId, displayId, hoverColor) {
            var zone = document.getElementById(zoneId);
            var input = document.getElementById(fileId);
            var btn = document.getElementById(browseBtnId);
            var display = document.getElementById(displayId);

            btn.addEventListener('click', function() { input.click(); });
            zone.addEventListener('click', function(e) { if (e.target !== btn) input.click(); });
            input.addEventListener('change', function() {
                if (this.files.length > 0) {
                    display.textContent = this.files[0].name;
                    display.classList.remove('hidden');
                }
            });
            zone.addEventListener('dragover', function(e) {
                e.preventDefault();
                zone.classList.add('border-' + hoverColor, 'bg-opacity-10');
            });
            zone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                zone.classList.remove('border-' + hoverColor, 'bg-opacity-10');
            });
            zone.addEventListener('drop', function(e) {
                e.preventDefault();
                zone.classList.remove('border-' + hoverColor, 'bg-opacity-10');
                if (e.dataTransfer.files.length > 0) {
                    input.files = e.dataTransfer.files;
                    display.textContent = e.dataTransfer.files[0].name;
                    display.classList.remove('hidden');
                }
            });
        }

        setupDropZone('dropZone1', 'file1', 'browseBtn1', 'fileNameDisplay1', 'blue-400');
        setupDropZone('dropZone2', 'file2', 'browseBtn2', 'fileNameDisplay2', 'orange-400');

        // ========== Preview Compare ==========
        $('#previewBtn').on('click', function() {
            var file1 = document.getElementById('file1');
            var file2 = document.getElementById('file2');

            if (!file1.files.length) {
                toastr.warning('กรุณาเลือกไฟล์ TO ก่อน');
                return;
            }
            if (!file2.files.length) {
                toastr.warning('กรุณาเลือกไฟล์ TI ก่อน');
                return;
            }

            var formData = new FormData(document.getElementById('importFormBoth'));
            var btn = $(this);
            btn.prop('disabled', true).text('กำลังตรวจสอบ...');

            // ป้องกันปิด modal ระหว่างรอ
            $('#closeImportModal, #cancelImportModal').prop('disabled', true);
            $('#importModal').off('click.backdrop');

            $.ajax({
                method: "POST",
                url: "{{ route('diary.preview') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(res) {
                    console.log('Preview response:', res);
                    var html = '';
                    // TI row
                    html += '<tr class="bg-orange-50 dark:bg-orange-900/20 border-b border-gray-200 dark:border-gray-700">';
                    html += '<td class="px-3 py-2"><span class="inline-block px-2 py-0.5 bg-orange-500 text-white text-xs rounded">TI</span></td>';
                    html += '<td class="px-3 py-2 text-right font-semibold">' + res.ti.toLocaleString() + '</td>';
                    html += '</tr>';

                    // TO row
                    html += '<tr class="bg-blue-50 dark:bg-blue-900/20 border-b border-gray-200 dark:border-gray-700">';
                    html += '<td class="px-3 py-2"><span class="inline-block px-2 py-0.5 bg-blue-600 text-white text-xs rounded">TO</span></td>';
                    html += '<td class="px-3 py-2 text-right font-semibold">' + res.to.toLocaleString() + '</td>';
                    html += '</tr>';

                    $('#previewBody').html(html);
                    $('#previewSection').removeClass('hidden');

                    if (res.matched) {
                        $('#previewStatus').html('<span class="text-green-500">Quantity ตรงกัน พร้อม Import</span>');
                        $('#importBtnBoth').removeClass('hidden');
                    } else {
                        $('#previewStatus').html('<span class="text-red-500">Quantity ไม่ตรงกัน (TI: ' + res.ti.toLocaleString() + ' / TO: ' + res.to.toLocaleString() + ')</span>');
                        $('#importBtnBoth').addClass('hidden');
                    }
                },
                error: function(err) {
                    console.log('Preview error:', err.status, err.responseJSON);
                    var msg = 'ตรวจสอบไม่สำเร็จ!';
                    if (err.responseJSON && err.responseJSON.message) {
                        msg = err.responseJSON.message;
                    }
                    toastr.error(msg);
                },
                complete: function() {
                    btn.prop('disabled', false).text('เปรียบเทียบข้อมูล');
                    // เปิดปุ่มปิด modal กลับ
                    $('#closeImportModal, #cancelImportModal').prop('disabled', false);
                    $('#importModal').on('click.backdrop', function(e) {
                        if (e.target === this) closeImportModal();
                    });
                }
            });
        });

        // Reset preview when files change
        $('#file1, #file2').on('change', function() {
            $('#previewSection').addClass('hidden');
            $('#importBtnBoth').addClass('hidden');
        });

        // ========== ล้างข้อมูล ==========
        $('#clearBtn').on('click', function() {
            $('#file1, #file2').val('');
            $('#fileNameDisplay1, #fileNameDisplay2').addClass('hidden').text('');
            $('#previewSection').addClass('hidden');
            $('#previewBody').html('');
            $('#previewStatus').html('');
            $('#importBtnBoth').addClass('hidden');
        });

        // ========== Transfer Panel Control (HUD) ==========
        function tfStart() {
            var container = $('#transferPanel .tf-container');
            container.removeClass('done');

            // Status
            $('#tfStatusIDC, #tfStatusKM').text('CONNECTING...').addClass('active').removeClass('done');
            // Bars
            $('#tfBarIDC, #tfBarKM').css('width', '0%');
            // Data
            $('#tfRowsIDC, #tfRowsKM').text('0');
            $('#tfPctIDC, #tfPctKM').text('0%');
            // Dots
            $('.tf-dot').addClass('active').removeClass('done');
            // Hub
            $('#tfHubCore').addClass('active');
            $('#tfHubText').addClass('active').text('TRANSFER');
            $('.tf-hub-ring').addClass('spinning');
            // Scanline
            $('.tf-scanline').addClass('active');
        }

        function tfProgress(idcPct, kmPct, idcRows, kmRows) {
            $('#tfBarIDC').css('width', idcPct + '%');
            $('#tfBarKM').css('width', kmPct + '%');
            $('#tfRowsIDC').text(idcRows.toLocaleString());
            $('#tfRowsKM').text(kmRows.toLocaleString());
            $('#tfPctIDC').text(Math.round(idcPct) + '%');
            $('#tfPctKM').text(Math.round(kmPct) + '%');
            if (idcPct > 0) $('#tfStatusIDC').text('TRANSFERRING');
            if (kmPct > 0) $('#tfStatusKM').text('TRANSFERRING');
        }

        function tfDone() {
            $('#tfBarIDC, #tfBarKM').css('width', '100%');
            $('#tfPctIDC, #tfPctKM').text('100%');
            $('#tfStatusIDC, #tfStatusKM').text('COMPLETE').removeClass('active').addClass('done');
            $('.tf-dot').removeClass('active').addClass('done');
            $('#tfHubText').text('DONE');
            $('.tf-hub-ring').removeClass('spinning');
            $('.tf-scanline').removeClass('active');
            $('#transferPanel .tf-container').addClass('done');
        }

        function tfError() {
            $('#tfStatusIDC, #tfStatusKM').text('ERROR').removeClass('active');
            $('.tf-dot').removeClass('active done');
            $('#tfHubText').removeClass('active').text('FAILED');
            $('.tf-hub-ring').removeClass('spinning');
            $('.tf-scanline').removeClass('active');
            $('#tfHubCore').removeClass('active');
        }

        function tfHide() {
            // Reset to STANDBY state
            var container = $('#transferPanel .tf-container');
            container.removeClass('done');
            $('#tfStatusIDC, #tfStatusKM').text('STANDBY').removeClass('active done');
            $('#tfBarIDC, #tfBarKM').css('width', '0%');
            $('#tfRowsIDC, #tfRowsKM').text('0');
            $('#tfPctIDC, #tfPctKM').text('0%');
            $('.tf-dot').removeClass('active done');
            $('#tfHubCore').removeClass('active');
            $('#tfHubText').removeClass('active').text('TRANSFER');
            $('.tf-hub-ring').removeClass('spinning');
            $('.tf-scanline').removeClass('active');
        }

        // ========== Load Transfer Status from DB ==========
        var statusPollTimer = null;

        function tfLoadStatus() {
            var dm = getDateMonth();
            $.get("{{ route('diary.transfer_status') }}", { date_month: dm }, function(res) {
                if (!res.status) {
                    tfHide();
                    return;
                }

                tfStart();
                tfProgress(res.idc_pct, res.km_pct, res.idc_rows, res.km_rows);

                if (res.idc_pct >= 100 && res.km_pct >= 100) {
                    tfDone();
                } else if (res.idc_pct >= 100) {
                    $('#tfStatusIDC').text('COMPLETE').removeClass('active').addClass('done');
                } else if (res.km_pct >= 100) {
                    $('#tfStatusKM').text('COMPLETE').removeClass('active').addClass('done');
                }
            });
        }

        function tfStartPolling() {
            tfStart();
            var dm = getDateMonth();
            statusPollTimer = setInterval(function() {
                $.get("{{ route('diary.transfer_status') }}", { date_month: dm }, function(res) {
                    if (!res.status) return;
                    tfProgress(res.idc_pct, res.km_pct, res.idc_rows, res.km_rows);

                    if (res.idc_pct >= 100 && res.km_pct >= 100) {
                        clearInterval(statusPollTimer);
                        statusPollTimer = null;
                        tfDone();
                    }
                });
            }, 1500);
        }

        function tfStopPolling() {
            if (statusPollTimer) {
                clearInterval(statusPollTimer);
                statusPollTimer = null;
            }
        }

        // โหลดสถานะตอนเปิดหน้า
        tfLoadStatus();

        // ========== Import Both ==========
        $('#importBtnBoth').on('click', function() {
            var file1 = document.getElementById('file1');
            var file2 = document.getElementById('file2');

            if (!file1.files.length) {
                toastr.warning('กรุณาเลือกไฟล์ TO ก่อน');
                return;
            }
            if (!file2.files.length) {
                toastr.warning('กรุณาเลือกไฟล์ TI ก่อน');
                return;
            }

            var formData = new FormData(document.getElementById('importFormBoth'));
            var btn = $(this);
            btn.prop('disabled', true).text('กำลัง Import...');
            closeImportModal();

            // Start transfer animation + poll real status
            tfStartPolling();

            $.ajax({
                method: "POST",
                url: "{{ route('diary.import') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (res) {
                    tfStopPolling();
                    // โหลดสถานะจริงจาก DB อีกครั้ง
                    $.get("{{ route('diary.transfer_status') }}", function(st) {
                        if (st.status) {
                            tfProgress(st.idc_pct, st.km_pct, st.idc_rows, st.km_rows);
                        }
                        tfDone();
                    }).fail(function() {
                        tfDone();
                    });
                    toastr.success(res.message || "Import สำเร็จ");
                    $('#table-external').DataTable().ajax.reload();
                },
                error: function (err) {
                    tfStopPolling();
                    tfError();
                    var msg = 'Import ไม่สำเร็จ!';
                    if (err.responseJSON && err.responseJSON.message) {
                        msg = err.responseJSON.message;
                    }
                    toastr.error(msg);
                    setTimeout(tfHide, 4000);
                },
                complete: function() {
                    btn.prop('disabled', false).text('ยืนยันการนำเข้า');
                }
            });
        });

        let selectedProducts = [];

        function fetchDiary() {
            $('#table-external').DataTable().ajax.reload();
        }

        const mytableDatatable = $('#table-external').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "500px",
            "order": [[0, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "pageLength": 20,
            "processing": true,
            "language": {
                "processing": '<div class="flex items-center justify-center gap-2 py-4"><svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span class="text-gray-400 text-sm font-mono tracking-wider">LOADING DATA...</span></div>'
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('diary.list_diary_external') }}",
                "type": "POST",
                'data': function(data) {
                    data.doc_no = $('#search').val();
                    data.date_month = getDateMonth();
                    data._token = $('meta[name="csrf-token"]').attr('content');
                },
                "error": function(xhr, error, thrown) {
                    console.log("AJAX Error: ", error, thrown);
                    console.log(xhr.responseText);
                }
            },
            orderable: true,
            columnDefs: [
                { targets: 0, render: function(d, t, row) { return row.product_id; } },
                { targets: 1, render: function(d, t, row) { return row.doc_date; } },
                { targets: 2, render: function(d, t, row) { return row.doc_tp; } },
                { targets: 3, render: function(d, t, row) { return row.branch_id; } }
            ]
        });

        // ─── KM DataTable ───
        var kmTableInited = false;
        function initKmTable() {
            if (kmTableInited) return;
            kmTableInited = true;
            $('#table-km').DataTable({
                searching: false,
                serverSide: true,
                scrollX: true,
                orderCellsTop: true,
                ordering: false,
                deferRender: true,
                scroller: true,
                scrollY: "500px",
                order: [[0, "desc"]],
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                pageLength: 20,
                processing: true,
                language: {
                    processing: '<div class="flex items-center justify-center gap-2 py-4"><svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span class="text-gray-400 text-sm font-mono tracking-wider">LOADING DATA...</span></div>'
                },
                ajax: {
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{ route('diary.list_diary') }}",
                    type: "POST",
                    data: function(data) {
                        data.doc_no = $('#search').val();
                        data.date_month = getDateMonth();
                        data._token = $('meta[name="csrf-token"]').attr('content');
                    },
                    error: function(xhr, error, thrown) {
                        console.log("KM AJAX Error: ", error, thrown);
                    }
                },
                columnDefs: [
                    { targets: 0, render: function(d, t, row) { return row.company_id; } },
                    { targets: 1, render: function(d, t, row) { return row.doc_no; } },
                    { targets: 2, render: function(d, t, row) { return row.doc_date; } },
                    { targets: 3, render: function(d, t, row) { return row.doc_tp; } },
                    { targets: 4, render: function(d, t, row) { return row.corporation_id; } },
                    { targets: 5, render: function(d, t, row) { return row.branch_id; } },
                    { targets: 6, render: function(d, t, row) { return row.member_id; } },
                    { targets: 7, render: function(d, t, row) { return row.product_id; } }
                ]
            });
        }

        // ─── Toggle: External ↔ KM ───
        $('#btn-list-external').on('click', function() {
            $('#view-km').hide();
            $('#view-external').show();
            $('.toggle-btn').removeClass('active');
            $(this).addClass('active');
            $('#table-external').DataTable().columns.adjust();
        });

        $('#btn-list-km').on('click', function() {
            $('#view-external').hide();
            $('#view-km').show();
            $('.toggle-btn').removeClass('active');
            $(this).addClass('active');
            initKmTable();
            $('#table-km').DataTable().columns.adjust();
        });

        const lines = [
            "     คำเตือน",
            "การ Update ราคาสินค้า",
            "จะไม่สามารถกู้คืนราคาสินค้าเก่าได้",
            "✅ จำนวนสินค้าทั้งหมด: " + selectedProducts.length + " รายการ",
            '',
            "🚀 ChatGPT(Product Master) V. 1.04.1",
        ];

        let currentLine = 0;
        let currentChar = 0;
        let message = '';

        function typeNextCharSwal() {
            if (currentLine >= lines.length) {
                Swal.update({
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, อัปเดต!',
                    cancelButtonText: 'ยกเลิก'
                });
                return;
            }

            const line = lines[currentLine];

            if (currentChar < line.length) {
                message += line[currentChar];
                currentChar++;

                Swal.update({
                    html:`
                        <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                            <div class="coin-wrapper">
                                <div id="coin">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 291.764 291.764" width="60" height="60">
                                        <g>
                                        <path style="fill:#F4B459;" d="M145.882,0c80.573,0,145.882,65.319,145.882,145.882s-65.31,145.882-145.882,145.882
                                            S0,226.446,0,145.882S65.31,0,145.882,0z"/>
                                        <path style="fill:#D07C40;" d="M145.882,27.399c-65.465,0-118.529,53.065-118.529,118.529s53.065,118.529,118.529,118.529
                                            s118.529-53.065,118.529-118.529S211.347,27.399,145.882,27.399z M145.882,246.231c-55.39,0-100.294-44.914-100.294-100.294
                                            c0-55.39,44.904-100.294,100.294-100.294s100.294,44.904,100.294,100.294
                                            C246.176,201.318,201.272,246.231,145.882,246.231z M174.63,141.187c6.738-3.483,10.969-9.601,9.984-19.804
                                            c-1.331-13.941-14.369-18.618-29.395-19.949l-0.009-19.329h-9.355v18.828l-9.3,0.128V82.104h-9.063v19.329
                                            c-2.516,0.055-8.698,0.109-11.124,0.109v-0.064l-16.056-0.009v12.573c0,0,12.008-0.164,11.88,0
                                            c4.714,0,6.255,2.772,6.683,5.161l0.009,22.028l1.231,0.082h-1.231v30.863c-0.201,1.504-1.076,3.902-4.367,3.911
                                            c0.146,0.137-11.889,0-11.889,0l-2.316,14.05h15.144l12.017,0.073l0.009,19.566h8.78l-0.009-19.357
                                            c3.209,0.073,6.282,0.109,9.309,0.1v19.256h10.212v-19.53c19.566-1.131,33.836-6.118,35.541-24.709
                                            C192.701,150.56,185.736,143.886,174.63,141.187z M135.698,114.891c6.574,0,27.216-2.115,27.216,11.762
                                            c0,13.294-20.642,11.753-27.216,11.753V114.891z M135.698,176.162V150.25c7.896,0,32.632-2.289,32.632,12.956
                                            C168.33,177.831,143.594,176.162,135.698,176.162z"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <pre style="text-align: left; white-space: pre-line; color:#ffffff;">${message}</pre>
                    `
                });
                setTimeout(typeNextCharSwal, 50);
            } else {
                message += '\n';
                currentLine++;
                currentChar = 0;
                setTimeout(typeNextCharSwal, 300);
            }
        }

        function confirmUpdate() {
            // รีเซ็ต
            message = '';
            currentLine = 0;
            currentChar = 0;

            // update ค่าที่แสดงใน SweetAlert
            lines[3] = "✅ จำนวนสินค้าทั้งหมด: " + selectedProducts.length + " รายการ";

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่จะให้ AI อัปเดตราคาสินค้า?',
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonColor: '#303030',
                cancelButtonColor: '#e13636',
                color: "#ffffff",
                background: "#202020",
                didOpen: () => {
                    typeNextCharSwal();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    saveUpdate();
                }
            });
        }

        function saveUpdate() {
            // Swal.fire('กำลังอัปเดต...', '', 'info');
            Swal.fire({
                html: `
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20 animate-spin dark:text-black">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                        <pre style="text-align: center; white-space: pre-line; color:#000000;">กำลังอัปเดต...</pre>
                    </div>
                `,
                showConfirmButton: false,
                background: '#e4e4e4e3',  // 🔴 ใช้ตรงนี้สำหรับพื้นหลัง popup
                backdrop: 'rgba(0, 0, 0, 0.2)', // พื้นหลังมืดบาง ๆ
                customClass: {
                    popup: 'p-0 m-0 flex items-center justify-center rounded-none shadow-none w-screen h-screen',
                    container: 'p-0 m-0',
                    htmlContainer: 'w-full flex items-center justify-center',
                },
                didOpen: () => {
                    // 👇 รอ 1.5 วิแล้วค่อยทำงานต่อ
                    setTimeout(() => {
                        Swal.close(); // หรือจะเปลี่ยนเป็นอีก Swal.fire(), redirect หรือ logic อื่นก็ได้
                    }, 2000);
                }
            });
            $.ajax({
                url: '{{ route("manage_price.update") }}', // ✅ ใช้ชื่อ route ที่ประกาศไว้
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    products: selectedProducts
                },
                success: function(response) {
                    setTimeout(function () {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr.success("อัปเดทราคาสำเร็จ");
                        $('#table-external').DataTable().ajax.reload(); // 👈 reload table
                    }, 2000);
                },
                error: function() {
                    // Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการอัปเดต', 'error');
                    Swal.fire({
                        title: 'ผิดพลาด!', 
                        html:`
                            <pre style="text-align: center; white-space: pre-line; color:#ffffff;">เกิดข้อผิดพลาดในการอัปเดต</pre>
                        `,
                        icon: 'error',
                        color: "#ffffff",
                        background: "#202020",
                    });
                }
            });
        }

    </script>

