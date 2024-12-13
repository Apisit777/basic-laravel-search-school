@extends('layouts.layout')
@section('title', 'Inspection & deteils')
@section('content')

    <style>
        span.dt-column-order {
            display: none;
        }
        .dt-length  {
            color: #818181!important;
        }
        .page-item.active .page-link {
            color: #fff !important;
            background: #1F2226 !important;
        }
        .col-md-auto {
        width: 221px!important;
        }
        div.dt-container div.dt-info {
            padding-top: 0em!important;
        }
        .btn-group, .btn-group-vertical {
            padding-left: 18px!important;
        }
        .buttons-collection{
            color: #fff !important;
            background: #1F2226 !important;
        }
        /* div.dt-container div.dt-paging {
            padding-left: 34px!important;
        } */
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    <div class="p-4 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <div class="lg:col-span-4">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-9">
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand OP</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_op" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand CPS</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_cps" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand SSUP</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_ssup" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-600"></ul>
            <div class="lg:col-span-4">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-9">
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand GNC</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_gnc" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand KM</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_km" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand KSHOP</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_kshop" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-600"></ul>
            <div class="lg:col-span-4">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-9">
                    <!-- <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand KSHOPCR</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_kshopcr" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand KMCR</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_kmcr" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand DEALER</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_dealer" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-600"></ul>
            <div class="lg:col-span-4">
                <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-9">
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand BB</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_bb" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand LL</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_ll" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number 0-9</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-3" style="position: relative;">
                        <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">Brand Empty('')</p>
                        <div class="bg-white rounded shadow-lg dark:bg-[#404040] duration-500">
                            <div class="text-gray-900 dark:text-gray-100 mt-5">
                                <div class="table-wrapper">
                                    <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                                        <table id="table_empty" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Letter A-Z</th>
                                                    <th>Count</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-600"></ul>
        </div>
    </div>

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
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.min.js') }}"></script>
    <script>
        function onOpenhandler(params) {
            document.querySelectorAll('.setpcollep').forEach((element, index) => {
                element.addEventListener('click', function (params) {
                    document.querySelectorAll('.setcheckbox').forEach(ee => {
                        ee.checked = false
                    });
                    document.querySelectorAll('.bg_step_color').forEach(ee => {
                        ee.classList.remove('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                        ee.classList.add('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                    });
                    let el = document.querySelectorAll('.setcheckbox')[index]
                    let el_colr = document.querySelectorAll('.bg_step_color')[index]
                    el.checked = !el.checked
                    if( el.checked){
                        el_colr.classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
                        el_colr.classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
                    }
                })
            });
        }

        $(document).ready(function() {
            onOpenhandler();
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
        });
        
        const mytableDatatableOp = $('#table_op').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_op') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });

        const mytableDatatableCps = $('#table_cps').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_cps') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableSsup = $('#table_ssup').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_ssup') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableGnc = $('#table_gnc').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_gnc') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableKm = $('#table_km').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_km') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableKshop = $('#table_kshop').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_kshop') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableKshopcr = $('#table_kshopcr').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_kshopcr') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableKmcr = $('#table_kmcr').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_kmcr') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableDealer = $('#table_dealer').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_dealer') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableBb = $('#table_bb').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_bb') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableLl = $('#table_ll').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_ll') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });
        const mytableDatatableEmpty = $('#table_empty').DataTable({
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [10, 25, 50, 100],
            "layout": {
                "topEnd": {
                    "buttons": ['colvis']
                }
            },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('list_brand_empty') }}",
                "type": "POST"
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Number;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Count;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.Total;
                    }
                }
            ]
        });

    </script>
@endsection
