@extends('layouts.layout')
@section('title', '')
    <style>
        .loading_create_menu_consumables {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
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
        span.dt-column-order {
            display: none;
        }
        .dt-length  {
            /* color: #FFFFFF!important; */
            color: #818181!important;
        }

        .search-input {
            width: 100%;
            padding: 3px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .table td, .table th {
            padding: 0.55rem !important;
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

    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_channel_list')</p>
        </div>

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                <thead>
        <tr>
            <th>Brand</th>
            <th>Product</th>
            <th>Product Name</th>
        </tr>
        <tr>
            <th>
                <select class="js-example-basic-single w-full rounded-sm text-xs" id="brand_id" name="" onchange="tentSearch()">
                    <option value=""> --- กรุณาเลือก ---</option>
                    @foreach ($allBrands as $key => $allBrand)
                        <option value={{ $allBrand }}>{{ $allBrand }}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select class="js-example-basic-single w-full rounded-sm text-xs" id="" name="">
                    <option value=""> --- กรุณาเลือก ---</option>
                    @foreach ($allBrands as $key => $allBrand)
                        <option value={{ $allBrand }}>{{ $allBrand }}</option>
                    @endforeach
                </select>
            </th>
            <th>
                <select class="js-example-basic-single w-full rounded-sm text-xs" id="" name="">
                    <option value=""> --- กรุณาเลือก ---</option>
                    @foreach ($allBrands as $key => $allBrand)
                        <option value={{ $allBrand }}>{{ $allBrand }}</option>
                    @endforeach
                </select>
            </th>
        </tr>
    </thead>
    <tbody></tbody>
                </table>
            </div>
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

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        const mytableDatatable = $('#example').DataTable({
            // new DataTable('#example', {
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            "order": [
                [0, "desc"]
            ],
            // "lengthMenu": [20, 50, 100],
            "lengthMenu": [1000],
            // "layout": {
            //     "topStart": {
            //         "buttons": ['excel', 'colvis']
            //         // buttons: ['copy', 'excel', 'pdf', 'colvis']
            //     }
            // },
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('channel.list_product_channel') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
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
                        return row.PRODUCT;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_THAI;
                    }
                }
            ]
        });

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            return false;
        });

        function tentSearch() {
            mytableDatatable.draw();
        }

    </script>
@endsection