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
        <div class="mt-5 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการจัดการเมนู</p>
        </div>
        <div class="grid grid-cols-5 gap-10 mt-10">
            <div class="form col-span-2">
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            สิทธิ์เข้าถึงผู้ใช้งาน
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
                                                <tr id="pos_{{ $pos_data->id_position }}" onclick="setAccess({{  $pos_data->id_position  }})">
                                                    <td>{{ $pos_data->id_position }}</td>
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
            <div class="form col-span-3 relative">
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
                                <table id="menuTable" class="table table-bordered table-hover text-gray-900 dark:text-white cursor-pointer" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th style="width: 30px">ID</th>
                                            <th>ชื่อเมนู</th>
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
                                        @foreach ($menu as $menu_data)
                                            <tr>
                                                <td><input type="checkbox" id="action_all_{{ $menu_data->id }}" value="{{ $menu_data->id }}" onclick="setMenu(this)"></td>
                                                <td>{{ $menu_data->id }}</td>
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
            </div>
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
        let select_pos;
        function setMenu(data){
            if(select_pos){
                if($(data).prop("checked")){
                    console.log("🚀 ~ setMenu ~ data:", data.checked)
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
                    let action =  data.id.split('_')[1]
                    let menuId =  data.id.split('_')[2]
                    $.ajax({
                        type: "POST",
                        url: "{{url('create_access')}}",
                        data: {
                            pos_id: select_pos,
                            menu_id: menuId,
                            action: action,
                            state: data.checked ? 1 : 0,
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
                    console.log("🚀 ~ ajaxGetMenuAccess ~ res:", res)
                    if(res){
                        for(let i = 0; i < res.length; i++){
                            $("#action_all_" + res[i]).prop("checked",true);
                        }
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
    </script>
@endsection
