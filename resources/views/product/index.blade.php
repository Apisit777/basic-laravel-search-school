@extends('layouts.layout')
@section('title', '')

    <style>
        .loaderslide {
            width: 100%;
            height: 100%;
            background-color: #303030;
            position: fixed;
            top: 0;
            z-index: 1000;
            animation: slide_up 1s linear 0.7s forwards;
        }
        .btn {
            z-index: 10;
            /* margin: auto; */
        }
        @keyframes slide_up{
            0% {
                height: 100%;
            }
            70% {
                height: 10%;
            }
            100% {
                height: 0%;
            }
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

    <div id="slide" class="loaderslide"></div>

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_registration_list')</p>
        </div>
        <!-- <div id="create_product">
        </div> -->
        <!-- <div class="fixed flex bottom-5 right-5 z-10">
            <a href="{{ route('product.create') }}" class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group">
                <svg xmlns="http:www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div> -->

        <div class="fixed flex bottom-16 right-5 z-10">
            <a
                type="button"
                class="bg-[#303030] hover:bg-[#404040] text-white font-bold cursor-pointer py-2 px-2 mr-2 mt-20 rounded-full group"
                data-twe-toggle="modal"
                data-twe-target="#staticBackdrop"
                data-twe-ripple-init
                data-twe-ripple-color="light"
                onclick="modelManageRole()"
            >
                <svg fill="currentColor" class="size-7" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1600 1066.667c117.653 0 213.333 95.68 213.333 213.333v106.667H1920V1760c0 88.213-71.787 160-160 160h-320c-88.213 0-160-71.787-160-160v-373.333h106.667V1280c0-117.653 95.68-213.333 213.333-213.333ZM800 0c90.667 0 179.2 25.6 254.933 73.6 29.867 18.133 58.667 40.533 84.267 66.133 49.067 49.067 84.8 106.88 108.053 169.814 11.307 30.4 20.8 61.44 25.814 94.08l2.24 14.613 3.626 20.16-.533.32v.213l-52.693 32.427c-44.694 28.907-95.467 61.547-193.067 61.867-.427 0-.747.106-1.173.106-24.534 0-46.08-2.133-65.28-5.653-.64-.107-1.067-.32-1.707-.427-56.32-10.773-93.013-34.24-126.293-55.68-9.6-6.293-18.774-12.16-28.16-17.6-27.947-16-57.92-27.306-108.16-27.306h-.32c-57.814.106-88.747 15.893-121.387 36.266-4.48 2.88-8.853 5.44-13.44 8.427-3.093 2.027-6.72 4.16-9.92 6.187-6.293 4.053-12.693 8.106-19.627 12.16-4.48 2.666-9.493 5.013-14.293 7.573-6.933 3.627-13.973 7.147-21.76 10.453-6.613 2.987-13.76 5.547-21.12 8.107-6.933 2.347-14.507 4.267-22.187 6.293-8.96 2.347-17.813 4.587-27.84 6.187-1.173.213-2.133.533-3.306.747v57.6c0 17.066 1.066 34.133 4.266 50.133C454.4 819.2 611.2 960 800 960c195.2 0 356.267-151.467 371.2-342.4 48-14.933 82.133-37.333 108.8-54.4v23.467c0 165.546-84.373 311.786-212.373 398.08h4.906a1641.19 1641.19 0 0 1 294.08 77.76C1313.28 1119.68 1280 1195.733 1280 1280h-106.667v480c0 1.387.427 2.667.427 4.16-142.933 37.547-272.427 49.173-373.76 49.173-345.493 0-612.053-120.32-774.827-221.333L0 1576.32v-196.373c0-140.054 85.867-263.04 218.667-313.28 100.373-38.08 204.586-64.96 310.186-82.347h4.8C419.52 907.413 339.2 783.787 323.2 640c-2.133-17.067-3.2-35.2-3.2-53.333V480c0-56.533 9.6-109.867 27.733-160C413.867 133.333 592 0 800 0Zm800 1173.333c-58.773 0-106.667 47.894-106.667 106.667v106.667h213.334V1280c0-58.773-47.894-106.667-106.667-106.667Z" fill-rule="evenodd"/>
                </svg>
            </a>
        </div>

        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="staticBackdrop"
            data-twe-backdrop="static"
            data-twe-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div data-twe-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-clip-padding text-current shadow-4 outline-none bg-gray-100 dark:bg-[#202020]">
                    <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                        <h5 class="text-xl font-medium leading-normal text-surface dark:text-white" id="staticBackdropLabel">
                            Copy ข้อมูล
                        </h5>
                        <!-- Close button -->
                        <button
                            type="button"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <form id="form_menu" class="" method="POST">
                        <div class="p-4 lg:col-span-4 text-gray-900 dark:text-gray-100">
                            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="NAME_THAI">ชื่อภาษาไทย</label>
                                    <input type="text" name="NAME_THAI" id="NAME_THAI" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                </div>
                                <div class="md:col-span-3" style="position: relative;">
                                    <label for="SHORT_THAI">ชื่อย่อภาษาไทย</label>
                                    <input type="text" name="SHORT_THAI" id="SHORT_THAI" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                </div>
                            </div>
                        </div>

                        <input class="" type="hidden" id="edit_id_role" name="edit_id_role" value="">
                        <div class="p-4 text-gray-900 dark:text-gray-100">
                            <label for="name">ชื่อสิทธิ์</label>
                            <input type="text" id="name_position" name="name_position" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                        </div>

                        <div class="p-2 ">
                            <ul class="space-y-2 font-large border-t border-gray-200 dark:border-gray-500"></ul>
                        </div>
                        <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md p-2">
                            <a class="text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 rounded cursor-pointer group" onclick="createRole()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                    <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                                </svg>
                                Save
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                    <div class="md:col-span-2" >
                        <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                        <select class="js-example-basic-single w-full rounded-sm text-xs text-center" id="BARCODE" name="BARCODE">
                            <option class="" value=""> --- กรุณาเลือก ---</option>
                            @foreach ($productCodeArr as $key => $productCode)
                                <option value={{ $productCode }}>{{ $productCode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3" >
                        <label for="">ค้นหา</label>
                        <input type="text" name="search" id="search" class="h-10 border-[#303030] dark:border focus:border-blue-500 mt-1 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" placeholder="รหัสสินค้า, ชื่อสินค้า, Barcode ..." value="" />
                    </div>
                    <div class="md:col-span-6 text-center">
                        <div class="inline-flex items-center">
                            <a href="#" id="btnSerarch" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                                ค้นหา
                            </a>
                            <!-- <button  id="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group cursor-pointer btn-rotate" type="reset">
                                <svg class="hidden h-6 w-6 md:inline-block rotate"
                                    viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" version="1.1">
                                    <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 93,62 C 83,82 65,96 48,96 32,96 19,89 15,79 L 5,90 5,53 40,53 29,63 c 0,0 5,14 26,14 16,0 38,-15 38,-15 z"/>
                                    <path style="fill:#6597BB;stroke:#041E31;stroke-width:3;" d="M 5,38 C 11,18 32,4 49,4 65,4 78,11 85,21 L 95,10 95,47 57,47 68,37 C 68,37 63,23 42,23 26,23 5,38 5,38 z"/>
                                </svg>
                                ล้างข้อมูล
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
        <div class="flex right-12 z-10 absolute">
            <a href="{{ route('product.create') }}" type="button" class="mt-1 px-3 py-2 font-bold tracking-wide bg-[#303030] hover:bg-[#404040] text-white rounded group" name="add" id="add">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Add
            </a>
        </div>
        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื้อสินค้า</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        // getParmeterLogin()
        // function getParmeterLogin() {
        //     let dataLogin = sessionStorage.getItem("credetail");
        //     let dataJson = JSON.parse(dataLogin)
        //     console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        //     if ( dataJson.data.roles == "Superadmin") {
        //         $('#create_product').append(
        //             `<div class="fixed flex bottom-5 right-5 z-10">
        //                 <a href="{{ route('product.create') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-2 mr-2 mt-20 rounded-full group">
        //                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
        //                         <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        //                     </svg>
        //                 </a>
        //             </div>
        //             `
        //         );
        //     } else {
        //         $('#create_product').append(``)
        //     }
        // }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

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

                "url": "{{ route('product.list_products') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    const doc_no = $('#doc_no').val();
                    const date_start = $('#date_start').val();
                    const date_end = $('#date_end').val();

                    // Append to data
                    data.doc_no = doc_no;
                    data.date_start = date_start;
                    data.date_end = date_end;

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
                },
                {
                    targets: 3,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let disabledRoute = "{{route('product.update', 0)}}".replace('/0', "/" + row.BARCODE)
                        let text = "#"
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('product.edit', 0)}}"
                                            type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <a onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}', '${row.PRODUCT}')"
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
                                    </div>
                                `.replaceAll('/0', "/" + row.BARCODE);

                    }
                }
            ]
        });

        // <div class="inline-flex flex items-center rounded-md shadow-sm">
        //     <button onclick="disableAppointment('${disabledRoute}',this,'${row.BARCODE}')" class="bclose btn btn-sm btn-success refersh_btn">
        //         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
        //         <path fill-rule="evenodd" d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z" clip-rule="evenodd" />
        //         </svg>
        //     </button>
        //     <button type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
        //         <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
        //             <path d="M0 0h24v24H0V0z" fill="none"></path>
        //             <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
        //             <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
        //         </svg>
        //         Edit
        //     </button>
        // </div>

        // const { value: fruit } = await Swal.fire({
        // title: "Select field validation",
        // input: "select",
        // inputOptions: {
        //     Fruits: {
        //     apples: "Apples",
        //     bananas: "Bananas",
        //     grapes: "Grapes",
        //     oranges: "Oranges"
        //     },
        //     Vegetables: {
        //     potato: "Potato",
        //     broccoli: "Broccoli",
        //     carrot: "Carrot"
        //     },
        //     icecream: "Ice cream"
        // },
        // inputPlaceholder: "Select a fruit",
        // showCancelButton: true,
        // inputValidator: (value) => {
        //     return new Promise((resolve) => {
        //     if (value === "oranges") {
        //         resolve();
        //     } else {
        //         resolve("You need to select oranges :)");
        //     }
        //     });
        // }
        // });
        // if (fruit) {
        // Swal.fire(`You selected: ${fruit}`);
        // }

        let menusAuthPosition = <?php echo json_encode($productCodeArr); ?>;
        console.log("🚀 ~ menusAuthPosition:", menusAuthPosition)

        let codeOptionList = {}
            console.log("🚀 ~ disableAppointment ~ menusAuthPosition:", menusAuthPosition)
         menusAuthPosition.forEach( function(f) {

             codeOptionList[f] = f
         })
        function disableAppointment(url, e, id, PRODUCT) {
            const mytableDatatable = $('#example').DataTable();

            // Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#303030',
            //     cancelButtonColor: '#e13636',
            //     confirmButtonText: `
            //         <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
            //             <path d="M0 0h24v24H0V0z" fill="none"></path>
            //             <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
            //             <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
            //         </svg>
            //         Save
            //     `,
            //     cancelButtonText: `Cancle`,
            //     color: "#ffffff",
            //     background: "#202020",

            // })

            (async () => {
                const { value: fruit } = await Swal.fire({
                    // text: "You won't be able to revert this!",
                    title: "<h5 style='color:red'>" + PRODUCT + "</h5>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#303030',
                    cancelButtonColor: '#e13636',
                    confirmButtonText: `
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                            <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                        </svg>
                        Save
                    `,
                    cancelButtonText: `Cancle`,
                    color: "#ffffff",
                    input: 'select',
                    didOpen: function () {
                        $(".js-example-basic-single").select2({
                            minimumResultsForSearch: 15,
                            width: '100%',
                            placeholder: "Seleziona",
                            language: "it"
                        });
                    },
                    // onOpen: function () {
                    //     $('.js-example-basic-single').select2({
                    //         minimumResultsForSearch: 15,
                    //         width: '100%',
                    //         placeholder: "Seleziona",
                    //         language: "it"
                    //     });
                    // },
                    background: "#202020",
                    inputOptions: codeOptionList,
                    inputPlaceholder: '--- กรุณาเลือก ---',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value === 'oranges') {
                                resolve()
                            } else {
                                resolve('You need to select oranges :)')
                            }
                        })
                    },
                })
                if (fruit) {
                    Swal.fire('You selected: ' + fruit)
                }
            })().then(result => {
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
                                    title:'เพิ่มข้อมูลเรียบร้อย',
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

        $('select[name=your_name]').on('select2:open', ()=>{
            $('.select2-container').css('z-index', 99999999);
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        // function disableAppointment(url, e, id, PRODUCT) {
        //     const mytableDatatable = $('#example').DataTable();
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#303030',
        //         cancelButtonColor: '#e13636',
        //         confirmButtonText: `
        //             <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
        //                 <path d="M0 0h24v24H0V0z" fill="none"></path>
        //                 <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
        //                 <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
        //             </svg>
        //             Save
        //         `,
        //         cancelButtonText: `Cancle`,
        //         color: "#ffffff",
        //         background: "#202020",

        //     }).then(result => {
        //         console.log("🚀 ~ disableAppointment ~ result:", result)
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url:"/broadcast",
        //                 method:'POST',
        //                 headers:{
        //                     'X-Socket-Id': pusher.connection.socket_id
        //                 },
        //                 data:{
        //                     _token:  '{{csrf_token()}}',
        //                     message: 'update notify'
        //                 }
        //                 }).done(function (res) {
        //                     console.log("🚀 ~ $ ~ res:", res)
        //             });
        //             $.ajax({
        //                 type: "DELETE",
        //                 url: url,
        //                 beforeSend: function() {
        //                     $(e).parent().parent().addClass('d-none');
        //                 },
        //                 success: function (params) {
        //                     if(params.success){
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลเรียบร้อย',
        //                             text:'',
        //                             icon:'success',
        //                             showConfirmButton: false,
        //                             timer: 1500
        //                         });
        //                         mytableDatatable.draw();
        //                     }
        //                     else{
        //                         Swal.fire({
        //                             title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                             text:'',
        //                             icon:'error',
        //                         });
        //                         $(e).parent().parent().removeClass('d-none');
        //                     }
        //                 },
        //                 error: function(er){
        //                     Swal.fire({
        //                         title:'อัปเดตข้อมูลไม่สำเร็จ',
        //                         text:'',
        //                         icon:'error',
        //                     });
        //                     $(e).parent().parent().removeClass('d-none');
        //                 }
        //             });
        //         }
        //     });
        // }
    </script>
@endsection
