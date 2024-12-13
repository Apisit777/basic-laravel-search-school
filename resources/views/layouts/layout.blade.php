<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/twitter-bootstrap4.0.0/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.css') }}" /> --}}

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/flowbite-2.3.0.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>

    <!-- <link rel="stylesheet" href="{{ asset('css/twitter-bootstrap5.0.0/bootstrap.min.css') }}" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.bootstrap5.css"> -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->

    <style>
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    @include('layouts.admin_navbar')
    @include('layouts.admin_menu_sidenav')
    <body x-cloak x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }" class="antialiased ">
        <div class="min-h-screen p-4 md:ml-64 bg-white dark:bg-[#202020] duration-500">
            <div class="p-2 rounded-sm dark:border-gray-700 mt-4">
                <div class="max-w-8xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>

    <!-- contents lg:pointer-events-auto lg:block lg:w-72 lg:overflow-y-auto lg:border-r lg:border-zinc-900/10 lg:px-6 lg:pb-8 lg:pt-4 xl:w-80 lg:dark:border-white/10 -->

    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script>
    // $( document ).ready(function() {
    //     setInterval(()=>{
    //         $.get("{{ route('auth.tokenExpired') }}", function(data) {
    //         }).fail(function() {
    //             Swal.fire({
    //                 title: 'Session Expired',
    //                 text: "กรุณารีโหลดหน้าใหม่",
    //                 icon: 'warning',
    //                 showConfirmButton: true,
    //                 confirmButtonColor: '#00385B',
    //             }).then((result)=>{
    //                 console.log("🚀 result:", result)
    //                 window.location.reload()
    //             })

    //         });

    //     },10000 )
    // });

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
        $('#profile_img').append(
            `<img class="w-12 h-12 md:w-16 md:h-16 rounded-full border-2 border-white dark:border-gray-600 mx-auto" src="${dataJson.data.photo}">`
        );
        $('#auth_img').append(
            `<img class="w-8 h-8 rounded" src="${dataJson.data.photo}">`
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
