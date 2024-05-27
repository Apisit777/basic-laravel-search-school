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
        {{-- <div class="row"> --}}
            <div class="">
                {{-- <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                    <i class="fas fa-bars"></i>
                </a> --}}
                @include('layouts.admin_menu_left')
                <main class="page-content">
                    {{-- <div class="container-fluid"> --}}
                        @yield('content')
                    {{-- </div> --}}
                </main>
            </div>
        {{-- </div> --}}
    </div>

    <script></script>
</body>

</html>
