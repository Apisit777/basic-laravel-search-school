@extends('layouts.layout')
@section('title', '')
@section('content')
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
        .table-responsive{-sm|-md|-lg|-xl|-xxl}
        element.style {
            top: 192px;
            left: 758.5px;
            z-index: 10;
            display: block;
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">NPD Request List</p>
        </div>

        <form action="#">
            @if (Auth::user()->getUserPermission->user_id == Auth::user()->id)
                <!-- <div class="fixed flex bottom-5 right-5 z-10">
                    <a href="{{ route('new_product_develop.create') }}" class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                        </svg>
                        <svg fill="currentColor" class="size-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 496 496" xml:space="preserve">
                            <g>
                                <g>
                                    <g>
                                        <path d="M486.624,300.168L432,252.368V144C432,64.6,367.4,0,288,0h-88C123.304,0,60.592,60.328,56.408,136H32
                                            c-17.648,0-32,14.352-32,32s14.352,32,32,32h24v144c0,54.656,42.376,99.592,96,103.696V496h16v-64h-8c-48.52,0-88-39.48-88-88
                                            V200h32v16h16v-16h21.24c2.56,8,6,15.536,10.288,22.52l-13.352,13.36l33.936,33.936l13.352-13.344
                                            c9.448,5.848,19.672,10.08,30.528,12.632V288h48v-18.888c10.856-2.552,21.088-6.784,30.528-12.632l13.352,13.344l33.936-33.936
                                            l-13.344-13.352c5.848-9.456,10.08-19.68,12.632-30.528H360v-48h-18.888c-2.552-10.848-6.784-21.08-12.632-30.528l13.344-13.352
                                            l-33.936-33.936l-13.352,13.344c-9.456-5.848-19.68-10.08-30.528-12.632V48h-48v18.888c-10.848,2.552-21.08,6.784-30.528,12.632
                                            l-13.352-13.344l-33.936,33.936l13.352,13.36C147.24,120.464,143.808,128,141.24,136H120v-16h-16v16H72.408
                                            C76.568,69.152,132.12,16,200,16h88c70.576,0,128,57.424,128,128v115.632l60.088,52.568c2.48,2.184,3.912,5.32,3.912,8.624
                                            c0,5.256-3.56,9.824-8.664,11.104L416,345.76V400c0,17.648-14.352,32-32,32h-48v64h16v-48h32c26.472,0,48-21.528,48-48v-41.76
                                            l43.208-10.808C487.456,344.384,496,333.44,496,320.824C496,312.912,492.584,305.384,486.624,300.168z M120,152h33.456l1.552-6
                                            c2.736-10.632,7.216-20.36,13.312-28.92l3.92-5.512l-11.44-11.456L172.112,88.8l11.456,11.44l5.504-3.92
                                            c10.848-7.728,23.048-12.776,36.248-14.992L232,80.2V64h16v16.2l6.672,1.128c13.2,2.216,25.4,7.264,36.248,14.992l5.504,3.92
                                            L307.88,88.8l11.312,11.312l-11.44,11.456l3.92,5.512c7.728,10.848,12.776,23.048,14.992,36.248L327.8,160H344v16h-16.2
                                            l-1.128,6.672c-2.216,13.2-7.264,25.4-14.992,36.248l-3.92,5.504l11.44,11.456l-11.312,11.312l-11.456-11.456l-5.504,3.928
                                            c-10.848,7.736-23.048,12.784-36.248,15L248,255.8V272h-16v-16.2l-6.672-1.128c-13.2-2.216-25.4-7.264-36.248-15l-5.504-3.928
                                            L172.12,247.2l-11.312-11.312l11.44-11.456l-3.92-5.504c-6.096-8.56-10.576-18.288-13.312-28.92l-1.56-6.008H120V152z M104,152
                                            v32H32c-8.824,0-16-7.176-16-16c0-8.824,7.176-16,16-16H104z"/>
                                        <path d="M240,232c35.288,0,64-28.712,64-64c0-35.288-28.712-64-64-64c-35.288,0-64,28.712-64,64C176,203.288,204.712,232,240,232
                                            z M240,120c26.472,0,48,21.528,48,48s-21.528,48-48,48s-48-21.528-48-48S213.528,120,240,120z"/>
                                        <rect x="232" y="304" width="16" height="16"/>
                                        <rect x="232" y="336" width="16" height="16"/>
                                        <rect x="232" y="368" width="16" height="16"/>
                                        <rect x="232" y="400" width="16" height="16"/>
                                        <rect x="232" y="432" width="16" height="16"/>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div> -->
            @endif
            <div class="grid mt-5 gap-4 gap-y-2 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
                <div class="lg:col-span-4 xl:grid-cols-4">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                        <div class="md:col-span-3">
                            <label for="BRAND" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Brand</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="BRAND">
                                <option value=""> --- กรุณาเลือก ---</option>
                                @foreach ($brands as $key => $brand)
                                    <option value={{ $brand }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <div class="md:col-span-2" >
                            <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                            <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="BARCODE" name="BARCODE">
                                <option class="" value=""> --- กรุณาเลือก ---</option>
                                @foreach ($productCodeArr as $key => $productCode)
                                    <option value={{ $productCode }}>{{ $productCode }}</option>
                                @endforeach
                            </select>
                        </div> -->
                        <div class="md:col-span-3" >
                            <label for="">ค้นหา</label>
                            <input type="text" name="search" id="search" onkeyup="checkNameBrand()" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" />
                        </div>
                        <div class="md:col-span-6 text-center">
                            <div class="inline-flex items-center">
                                <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                    </svg>
                                    ค้นหา
                                </a>
                                <!-- <button id="btnClearSerarch" style="margin-left:auto;" type="reset" class="btn btn-warning btn-sm btn-qrcode clear">
                                    ล้างข้อมูล
                                </button> -->
                                <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
                                    <svg class="hidden h-6 w-6 md:inline-block rotate"
                                        viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                        <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 93,62 C 83,82 65,96 48,96 32,96 19,89 15,79 L 5,90 5,53 40,53 29,63 c 0,0 5,14 26,14 16,0 38,-15 38,-15 z"/>
                                        <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 5,38 C 11,18 32,4 49,4 65,4 78,11 85,21 L 95,10 95,47 57,47 68,37 C 68,37 63,23 42,23 26,23 5,38 5,38 z"/>
                                    </svg>
                                    ล้างข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 relative"></ul>
        <div class="flex right-12 z-10 absolute">
            <a href="{{ route('new_product_develop.create') }}" type="button" class="mt-1 px-3 py-2 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group" name="add" id="add">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
                <!-- <svg fill="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
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
                </svg> -->
            </a>
        </div>
        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>Barcode</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        $(function(){
            $('form').on('reset', function() {
                localStorage.removeItem('get_refun_url');
                $('#brand_id').val('');
                setTimeout(function() {
                    mytableDatatable.draw();
                }, 500)
            });
        });

        getParameterSearce()
        function getParameterSearce() {
            let dataSearch = localStorage.getItem("get_refun_url");
            let dataJson = JSON.parse(dataSearch)
            console.log("🚀 ~ getParameterSearce ~ dataJson:", dataJson)
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
        const channel = pusher.subscribe('public');

        const add_element = () => {
            const template = document.createElement('div');
            template.classList.add("loaderslide");
            template.setAttribute("id","slide");
            document.body.appendChild(template);
        }

        if (sessionStorage.getItem("first_login") === 'Y') {
            sessionStorage.setItem("first_login", "yes")
            $("#slide").addClass("loaderslide");
        } else {
            $("#slide").remove();
        }

        const mytableDatatable = $('#example').DataTable({
                // new DataTable('#example', {
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 20, 30, 50],
            "layout": {
                "topStart": {
                    "buttons": ['excel', 'colvis']
                    // buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('new_product_develop.list_npd') }}",
                "type": "POST",
                'data': function(data) {
                    data.brand_id = $('#brand_id').val();
                    data.BARCODE = $('#BARCODE').val();
                    data.search = $('#search').val();
                    data._token = $('meta[name="csrf-token"]').attr('content');

                    // SetParameterSearce
                    localStorage.setItem("get_refun_url", JSON.stringify(data));
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BRAND;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Code;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_ENG;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.BARCODE;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let text = "#"
                        let disabledRoute = "{{route('new_product_develop.show_barcode', 0)}}".replace('/0', "/" + row.BARCODE)
                        return `<div class="inline-flex items-center rounded-md shadow-sm">
                                    <a href="{{route('new_product_develop.edit',0)}}"
                                        type="button" class="px-1 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 mr-0.5 rounded group">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                            <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                            <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}', '${row.Code}')"
                                        type="button" class="px-1 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group cursor-pointer">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block"
                                                viewBox="0 0 512 512" xml:space="preserve">
                                            <path d="M509.099,189.867l-145.067-128c-1.707-1.536-3.84-2.219-6.059-2.133H307.2v-51.2C307.2,3.84,303.36,0,298.667,0H8.533
                                                C3.84,0,0,3.84,0,8.533V435.2c0,4.693,3.84,8.533,8.533,8.533H128v59.733c0,4.693,3.84,8.533,8.533,8.533h366.933
                                                c4.693,0,8.533-3.84,8.533-8.533v-307.2C512,193.792,510.976,191.488,509.099,189.867z M366.933,87.211l113.92,100.523h-113.92
                                                V87.211z M128,68.267v358.4H17.067v-409.6h273.067v42.667H137.301C132.437,59.221,128,63.317,128,68.267z M494.933,494.933H145.067
                                                V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059c1.621,1.536,3.755,2.475,6.059,2.475h136.533V494.933z"/>
                                            <g>
                                                <polygon style="fill:#7E939E;" points="480.853,187.733 366.933,187.733 366.933,87.211 	"/>
                                                <rect x="452.267" y="204.8" style="fill:#7E939E;" width="42.667" height="290.133"/>
                                            </g>
                                            <path style="fill:#AFAFAF;" d="M452.267,204.8v290.133h-307.2V76.8h204.8v119.467c0,2.304,0.853,4.437,2.475,6.059
                                                c1.621,1.536,3.755,2.475,6.059,2.475H452.267z"/>
                                            <path style="fill:#7E939E;" d="M290.133,17.067v42.667H137.301c-4.864-0.512-9.301,3.584-9.301,8.533v358.4H17.067v-409.6H290.133z"
                                                />
                                        </svg>
                                        Copy
                                    </a>
                                    <a href="{{route('new_product_develop.show',0)}}" type="button" class="bclose">
                                        <svg class="size-7 cursor-pointer" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 309.267 309.267" xml:space="preserve">
                                            <g>
                                                <path style="fill:#E2574C;" d="M38.658,0h164.23l87.049,86.711v203.227c0,10.679-8.659,19.329-19.329,19.329H38.658
                                                    c-10.67,0-19.329-8.65-19.329-19.329V19.329C19.329,8.65,27.989,0,38.658,0z"/>
                                                <path style="fill:#B53629;" d="M289.658,86.981h-67.372c-10.67,0-19.329-8.659-19.329-19.329V0.193L289.658,86.981z"/>
                                                <path style="fill:#FFFFFF;" d="M217.434,146.544c3.238,0,4.823-2.822,4.823-5.557c0-2.832-1.653-5.567-4.823-5.567h-18.44
                                                    c-3.605,0-5.615,2.986-5.615,6.282v45.317c0,4.04,2.3,6.282,5.412,6.282c3.093,0,5.403-2.242,5.403-6.282v-12.438h11.153
                                                    c3.46,0,5.19-2.832,5.19-5.644c0-2.754-1.73-5.49-5.19-5.49h-11.153v-16.903C204.194,146.544,217.434,146.544,217.434,146.544z
                                                    M155.107,135.42h-13.492c-3.663,0-6.263,2.513-6.263,6.243v45.395c0,4.629,3.74,6.079,6.417,6.079h14.159
                                                    c16.758,0,27.824-11.027,27.824-28.047C183.743,147.095,173.325,135.42,155.107,135.42z M155.755,181.946h-8.225v-35.334h7.413
                                                    c11.221,0,16.101,7.529,16.101,17.918C171.044,174.253,166.25,181.946,155.755,181.946z M106.33,135.42H92.964
                                                    c-3.779,0-5.886,2.493-5.886,6.282v45.317c0,4.04,2.416,6.282,5.663,6.282s5.663-2.242,5.663-6.282v-13.231h8.379
                                                    c10.341,0,18.875-7.326,18.875-19.107C125.659,143.152,117.425,135.42,106.33,135.42z M106.108,163.158h-7.703v-17.097h7.703
                                                    c4.755,0,7.78,3.711,7.78,8.553C113.878,159.447,110.863,163.158,106.108,163.158z"/>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                               `.replaceAll('/0', '/' + row.BARCODE);
                    }
                }
            ]
        });

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            return false;
        });
        // <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}')" type="button"
        //     class="bclose btn btn-sm btn-success refersh_btn"
        // >
        //     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
        //     <path fill-rule="evenodd" d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z" clip-rule="evenodd" />
        //     </svg>
        // </a>
        function disableAppointment(url, e, id, code) {
            const mytableDatatable = $('#example').DataTable();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Copy ข้อมูลรหัสสินค้า ' + code + ' ไปรหัสใหม่',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#303030',
                cancelButtonColor: '#e13636',
                confirmButtonText: `
                <a href="#"
                    type="button" class="px-1 py-1 font-medium tracking-wide text-white py-0.5 px-1 rounded group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
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
                console.log("🚀 ~ disableAppointment ~ result:", result)
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        beforeSend: function() {
                            $(e).parent().parent().addClass('d-none');
                        },
                        success: function (params) {
                            if(params.success){
                                Swal.fire({
                                    title:'เพิ่มข้อมูล ' + ++code + ' เรียบร้อย',
                                    text:'',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                mytableDatatable.draw();
                            }
                            else{
                                Swal.fire({
                                    title:'บันทึกข้อมูลไม่สำเร็จ',
                                    text:'',
                                    icon:'error',
                                });
                                $(e).parent().parent().removeClass('d-none');
                            }
                        },
                        error: function(er){
                            Swal.fire({
                                title:'บันทึกข้อมูลไม่สำเร็จ',
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
