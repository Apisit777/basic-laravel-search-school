<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/twitter-bootstrap4.0.0/bootstrap.min.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/twitter-bootstrap5.0.0/bootstrap.min.css') }}" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.bootstrap5.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->

    <style>
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    @include('layouts.admin_navbar')
    @include('layouts.admin_menu_sidenav')
    <body x-cloak x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }" class="antialiased ">
        <div class="min-h-screen p-6 md:ml-64 bg-white dark:bg-[#202020] duration-500">
            <div class="p-2 rounded-sm dark:border-gray-700 mt-4">
                <div class="max-w-8xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>

    <!-- contents lg:pointer-events-auto lg:block lg:w-72 lg:overflow-y-auto lg:border-r lg:border-zinc-900/10 lg:px-6 lg:pb-8 lg:pt-4 xl:w-80 lg:dark:border-white/10 -->

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#select_locale').change(function(event) {
            jQuery.ajax({
                url: "{{ route('setLocale', 0) }}/".replaceAll('/0', '/' + event.target.value),
                type: 'GET',
                success: function (response) {
                    if(response.status === 200) {
                        window.location.reload()
                    }
                }
            })
        })

        let dataLogin = sessionStorage.getItem("credetail");
        let dataJson = JSON.parse(dataLogin)
        $('#auth_img').append(
            `<button id="dropdown-button-1" class="flex-shrink-0 z-10 inline-flex items-center " type="button">
                <img class="w-8 h-8 rounded" src="${dataJson.data.photo}">   
            </button>
            `
        );
        $('#auth_fullname_login').append(
            `<span class="text-gray-900 dark:text-white">${dataJson.data.fullname}</span>`
        );
        $('#auth_email_login').append(
            `<span class="text-gray-900 dark:text-white">${dataJson.data.email}</span>`
        );
        $('#auth_personcode_login').append(
            `<span class="text-gray-900 dark:text-white">${dataJson.data.emp_tiger.personcode}</span>`
        );
        $('#auth_departmant_login').append(
            `<span class="text-gray-900 dark:text-white">(${dataJson.data.emp_tiger.cmb1namet})</span>`
        );
        $('#auth_department').append(
            `<span class="text-gray-900 dark:text-white p-2">${dataJson.data.emp_tiger.cmb1namet}</span></button>`
        );
    </script>

</html>
