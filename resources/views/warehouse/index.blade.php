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
        .select2-container--default .select2-selection--single .select2-selection__clear {
            float: right;
            cursor: pointer;
            --tw-text-opacity: 1;
            color: rgb(200 30 30 / var(--tw-text-opacity));
            margin-right: 24px!important;
            margin-top: -1px!important;
            font-size: 20px!important;
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
            height: 7px;
            width: 7px;
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


        /* ************************************************************** */
        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .card img {
            max-width: 100%;
            height: auto;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-4 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">List Dimension</p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t-2 border-gray-200 dark:border-gray-700 relative"></ul>
        <!-- <div class="flex right-12 z-10 absolute mt-3">
            <div class="relative" data-twe-dropdown-position="dropstart">
                <button
                    class="flex items-center rounded bg-[#303030] hover:bg-[#404040] px-4 pb-[5px] pt-[6px] text-sm font-bold uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out focus:outline-none focus:ring-0 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                    type="button"
                    id="dropdownMenuWarehouse"
                    data-twe-dropdown-toggle-ref
                    aria-expanded="false"
                    data-twe-ripple-init
                    data-twe-ripple-color="light">
                    <span class="me-2 [&>svg]:h-5 [&>svg]:w-5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd" />
                    </svg>
                    </span>
                        เพิ่มข้อมูลคลังสิ้นค้า
                </button>
                <ul style="z-index: 999999999;" class="absolute divide-y divide-gray-600 rounded-sm w-48 md:w-52 dark:divide-gray-600 float-left m-0 hidden min-w-max list-none overflow-hidden border-none bg-white bg-clip-padding text-base shadow-lg data-[twe-dropdown-show]:block dark:bg-surface-dark"
                    aria-labelledby="dropdownMenuWarehouse"
                    data-twe-dropdown-menu-ref>
                    <li>
                        <a href="{{ route('warehouse.create') }}" class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-bold text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline dark:bg-surface-dark dark:text-white dark:hover:bg-neutral-800/25 dark:focus:bg-neutral-800/25 dark:active:bg-neutral-800/25 group">
                            <svg class="h-5 w-5 hidden transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="currentColor" viewBox="0 0 512 512"  xml:space="preserve">
                                <g>
                                    <path class="st0" d="M504.262,66.75L445.226,7.706c-10.291-10.284-26.938-10.267-37.222,0l-38.278,38.278l96.282,96.266
                                        l38.254-38.295C514.537,93.672,514.554,77.017,504.262,66.75z"/>
                                    <path class="st0" d="M32.815,382.921L0.025,512l129.055-32.83l319.398-319.431l-96.249-96.265L32.815,382.921z M93.179,404.792
                                        l-21.871-21.871l278.289-278.289l21.887,21.887L93.179,404.792z"/>
                                </g>
                            </svg>
                            <span class="ml-2.5">
                                เพิ่มข้อมูล
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div> -->

        {{-- <a href="#" id="fetchDataBtn" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
            </svg>
            Fetch School Balance Data
        </a>

        <div id="responseData" class="mt-5 text-gray-900 dark:text-white"></div> --}}

        <!-- <div class="justify-center items-center">
            <form class="max-w-sm mx-auto">
                <label for="countries" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Select Position</label>
                <select class="js-example-basic-single w-full rounded-sm text-xs" id="filter-select" name="">
                    <option value="" class="text-sm"> --- กรุณาเลือก ---</option>
                    @foreach ($roles as $key => $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="container mx-auto py-8">
            <div id="cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
        </div>

        <div id="pagination-controls" class="mt-8 flex flex-wrap justify-center space-x-2">
            <svg id="prev-btn" fill="currentColor" class="size-9 mt-0.5 ml-0.5 text-[#303030] dark:text-[#EAEAEA] cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="m4.431 12.822 13 9A1 1 0 0 0 19 21V3a1 1 0 0 0-1.569-.823l-13 9a1.003 1.003 0 0 0 0 1.645z"/>
            </svg>
            <div id="pagination-numbers" class="flex flex-wrap justify-center space-x-2"></div>
            <svg id="next-btn" fill="currentColor" class="size-10 mb-1 ml-0.5 text-[#303030] dark:text-[#EAEAEA] cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.536 21.886a1.004 1.004 0 0 0 1.033-.064l13-9a1 1 0 0 0 0-1.644l-13-9A1 1 0 0 0 5 3v18a1 1 0 0 0 .536.886z"/>
            </svg>
        </div> -->

        <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสบริษัท</th>
                            <th>รหัสสินค้า</th>
                            <th>Barcode</th>
                            <th>รหัสผู้ขาย</th>
                            <th>ชื่อภาษาไทย</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
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

        // $(document).ready(function () {
        //     $('#fetchDataBtn').click(function () {
        //         fetch('https://ins.schicher.com/api/users', {
        //             method: 'GET',  // Or 'POST' if the API requires it
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //         })
        //         .then(response => response.json()) // Assuming the API returns JSON
        //         .then(data => {
        //             $('#responseData').html(`<p>Response from API:</p><pre>${JSON.stringify(data, null, 2)}</pre>`);
        //         })
        //         .catch(error => console.error('Error:', error));
        //     });
        // });

        // $(document).ready(function () {
        //     let currentPage = 1;
        //     const cardsPerPage = 8;
        //     let allData = [];

        //     function fetchData() {
        //         fetch('https://ins.schicher.com/api/users', {
        //             method: "GET",
        //             headers: {
        //                 'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
        //                 'X-RapidAPI-Host': 'ott-details.p.rapidapi.com'
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             allData = data;
        //             renderCards(currentPage);
        //             renderPagination();
                    
        //         })
        //         .catch(error => console.error('Error:', error));
        //     }

        //     function renderCards(page) {
        //         console.log("🚀 ~ fetchData ~ allData:", allData)
        //         $('#cards-container').empty();
        //         const start = (page - 1) * cardsPerPage;
        //         const end = start + cardsPerPage;
        //         const pageData = allData.slice(start, end);

        //         pageData.forEach(item => {
        //             const card = `
        //                 <div class="max-w-sm p-1 bg-[#eaeaea] dark:bg-[#292929] cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">
        //                     <img src="${item.imageurl}/300x150" alt="${item.title || 'Unknown'}" class="w-full h-32 object-cover">
        //                     <div class="p-4">
        //                         <h2 class="text-lg font-semibold mb-1 text-gray-900 dark:text-gray-100">${item.name || 'Unknown School'}</h2>
        //                         <p class="text-sm text-gray-400 dark:text-gray-400 uppercase">${item.role || 'N/A'}</p>
        //                     </div>
        //                     <div class="px-4 pb-4 flex items-center space-x-4 text-gray-500 dark:text-gray-300 base:text-xl sm:text-sm">
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>CORS</span>
        //                         </div>
        //                         <div class="flex items-center space-x-1">
        //                             <span>🔒</span>
        //                             <span>HTTPS</span>
        //                         </div>
        //                     </div>
        //                 </div>
        //             `;
        //             $('#cards-container').append(card);
        //         });

        //         updatePaginationControls();
        //     }

        //     function renderPagination() {
        //         $('#pagination-numbers').empty();
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         const maxVisiblePages = 5; // You can adjust this value

        //         function addPageButton(page, isActive = false) {
        //             const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
        //             $('#pagination-numbers').append(pageButton);
        //         }

        //         if (totalPages <= maxVisiblePages) {
        //             // If total pages are less than max visible pages, show all
        //             for (let i = 1; i <= totalPages; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }
        //         } else {
        //             // Show first page
        //             addPageButton(1, currentPage === 1);

        //             // Show an ellipsis if currentPage is far from the first page
        //             if (currentPage > 3) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show pages around the current page
        //             let startPage = Math.max(2, currentPage - 1);
        //             let endPage = Math.min(currentPage + 1, totalPages - 1);

        //             for (let i = startPage; i <= endPage; i++) {
        //                 addPageButton(i, i === currentPage);
        //             }

        //             // Show an ellipsis if currentPage is far from the last page
        //             if (currentPage < totalPages - 2) {
        //                 $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
        //             }

        //             // Show last page
        //             addPageButton(totalPages, currentPage === totalPages);
        //         }

        //         // Add event listeners to page buttons
        //         $('#pagination-numbers button').click(function () {
        //             const page = $(this).data('page');
        //             currentPage = page;
        //             renderCards(currentPage);
        //             renderPagination();
        //         });
        //     }

        //     function updatePaginationControls() {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         $('#prev-btn').prop('disabled', currentPage === 1);
        //         $('#next-btn').prop('disabled', currentPage === totalPages);
        //     }

        //     $('#prev-btn').click(function () {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     $('#next-btn').click(function () {
        //         const totalPages = Math.ceil(allData.length / cardsPerPage);
        //         if (currentPage < totalPages) {
        //             currentPage++;
        //             renderCards(currentPage);
        //             renderPagination();
        //         }
        //     });

        //     fetchData();
        // });

        $(document).ready(function () {
            let currentPage = 1;
            const cardsPerPage = 8;
            let allData = [];
            const cardContainer = $('#cards-container');

            // Fetch data and initialize cards
            function fetchData(type = '') {
                const apiUrl = type
                    ? '{{ route('warehouse.filter.cards') }}' // Backend API with filter
                    : 'https://ins.schicher.com/api/users'; // Default API

                const requestOptions = type
                    ? {
                        method: 'GET',
                        data: { type },
                    }
                    : {
                        method: 'GET',
                        headers: {
                            'X-RapidAPI-Key': '7115427d56mshfff5805283a13cep190338jsn4bc3f4689eb8',
                            'X-RapidAPI-Host': 'ott-details.p.rapidapi.com',
                        },
                    };

                $.ajax(apiUrl, requestOptions)
                    .done((data) => {
                        // console.log("🚀 ~ fetchData ~ requestOptions:", requestOptions)
                        allData = data;
                        renderCards(currentPage);
                        renderPagination();
                    })
                    .fail(() => alert('Error fetching data'));
            }

            // Render cards for the current page
            function renderCards(page) {
                // console.log("🚀 Rendering cards with data:", allData);
                // cardContainer.empty();
                $('#cards-container').empty();
                const start = (page - 1) * cardsPerPage;
                const end = start + cardsPerPage;
                const pageData = allData.slice(start, end);

                pageData.forEach((item) => {
                    // console.log("Item:", item); // Debugging to see item structure
                    const name = item.name || 'Unknown Name';
                    const role = item.role || 'Unknown Role';
                    const imageUrl = item.imageurl || item.image || 'default-image-url.jpg'; // Replace with a fallback image if needed

                    const card = `
                        <div class="max-w-sm p-1 bg-[#eaeaea] dark:bg-[#292929] cursor-pointer rounded shadow-sm hover:shadow-lg hover:shadow-gray-400 dark:hover:shadow-lg dark:hover:shadow-gray-400 transition-shadow duration-300 ease-in-out">
                            <img src="${imageUrl}" alt="${name}" class="w-full h-32 object-cover">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold mb-1 text-gray-900 dark:text-gray-100">${name}</h2>
                                <p class="text-sm text-gray-400 dark:text-gray-400 uppercase">${role}</p>
                            </div>
                            <div class="px-4 pb-4 flex items-center space-x-4 text-gray-500 dark:text-gray-300 base:text-xl sm:text-sm">
                                <div class="flex items-center space-x-1">
                                    <span>🔒</span>
                                    <span>CORS</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span>🔒</span>
                                    <span>HTTPS</span>
                                </div>
                            </div>
                        </div>
                    `;
                    cardContainer.append(card);
                });

                updatePaginationControls();
            }

            // Render pagination
            function renderPagination() {
                $('#pagination-numbers').empty();
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                const maxVisiblePages = 5; // You can adjust this value

                function addPageButton(page, isActive = false) {
                    const pageButton = `<button class="px-4 py-1 mb-2 sm:mb-0 ${isActive ? 'bg-[#303030] text-white' : 'bg-white text-gray-800 border border-gray-300'} rounded hover:bg-[#505050]" data-page="${page}">${page}</button>`;
                    $('#pagination-numbers').append(pageButton);
                }

                if (totalPages <= maxVisiblePages) {
                    // If total pages are less than max visible pages, show all
                    for (let i = 1; i <= totalPages; i++) {
                        addPageButton(i, i === currentPage);
                    }
                } else {
                    // Show first page
                    addPageButton(1, currentPage === 1);

                    // Show an ellipsis if currentPage is far from the first page
                    if (currentPage > 3) {
                        $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
                    }

                    // Show pages around the current page
                    let startPage = Math.max(2, currentPage - 1);
                    let endPage = Math.min(currentPage + 1, totalPages - 1);

                    for (let i = startPage; i <= endPage; i++) {
                        addPageButton(i, i === currentPage);
                    }

                    // Show an ellipsis if currentPage is far from the last page
                    if (currentPage < totalPages - 2) {
                        $('#pagination-numbers').append('<span class="px-2 text-black dark:text-white">...</span>');
                    }

                    // Show last page
                    addPageButton(totalPages, currentPage === totalPages);
                }

                // Add event listeners to page buttons
                $('#pagination-numbers button').click(function () {
                    const page = $(this).data('page');
                    currentPage = page;
                    renderCards(currentPage);
                    renderPagination();
                });
            }

            // Update pagination controls
            function updatePaginationControls() {
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                $('#prev-btn').prop('disabled', currentPage === 1);
                $('#next-btn').prop('disabled', currentPage === totalPages);
            }

            // Pagination navigation buttons
            $('#prev-btn').click(function () {
                if (currentPage > 1) {
                    currentPage--;
                    renderCards(currentPage);
                    renderPagination();
                }
            });

            $('#next-btn').click(function () {
                const totalPages = Math.ceil(allData.length / cardsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderCards(currentPage);
                    renderPagination();
                }
            });

            // Filter cards by type
            $('#filter-select').on('change', function () {
                const type = $(this).val();
                fetchData(type);
            });

            // Initial fetch
            fetchData();
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        function changeLanguage(language) {
            var element = document.getElementById("url");
            element.value = language;
            element.innerHTML = language;
        }

        function showDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
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

                "url": "{{ route('warehouse.list_warehouse') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.brand_id = $('#brand_id').val();
                    // data.BARCODE = $('#BARCODE').val();
                    data.search = $('#search').val();

                    data._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            orderable: true,
            columnDefs: [{
                    targets: 0,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.company_id;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.product_id;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.barcode;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.vendor_id;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.name_thai;
                    }
                },
                {
                    targets: 5,
                    orderable: true,
                    className: 'text-center',
                    render: function(data, type, row) {
                        let disabledRoute = "{{route('warehouse.update', 0)}}".replace('/0', "/" + row.product_id)
                        let text = "#"
                            return `<div class="inline-flex flex items-center rounded-md shadow-sm">
                                        <a href="{{route('warehouse.edit', 0)}}"
                                            type="button" class="px-2 py-1 font-medium tracking-wide bg-[#303030] hover:bg-[#404040] text-white py-1 px-1 rounded group">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor" class="-mt-1.5 hidden h-4 w-4 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                <path d="M5 18.08V19h.92l9.06-9.06-.92-.92z" opacity=".3"></path>
                                                <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                `.replaceAll('/0', "/" + row.product_id);

                    }
                }
            ]
        });

        var filteredData = mytableDatatable
            .column( 0 )
            .data()
            .filter( function ( value, index ) {
                return false;
                // return value > 20 ? true : false;
        } );

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
            return false;
        });
    </script>
@endsection
