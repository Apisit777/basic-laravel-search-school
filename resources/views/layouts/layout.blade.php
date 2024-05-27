<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <style>
    </style>
</head>

<body>
    <div id="app">
        @include('layouts.admin_menu')
            <div class="">
                {{-- <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                </a> --}}
                @include('layouts.admin_menu_left')
                <!-- <nav class="fixed bottom-[calc(100vh-theme(spacing.16))] left-0 right-0 top-0 bg-blue-200">Nav</nav> -->
                <div class="flex min-h-screen bg-white dark:bg-[#202020]">
                    <aside class="sticky top-14 h-[calc(100vh-theme(spacing.14))] w-64 overflow-y-auto bg-[#e9e9e9] dark:bg-[#303030] relative">
                        <ul>
                        <li>A</li>
                        <li>B</li>
                        <li>C</li>
                        </ul>
                    </aside>

                    <!-- <main class="flex justify-center items-center"> -->
                        @yield('content')
                    <!-- </main> -->
                </div>
            </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>
