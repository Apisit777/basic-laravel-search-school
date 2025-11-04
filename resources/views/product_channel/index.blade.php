@extends('layouts.layout')
@section('title', '')
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

        .select2-container--default .select2-selection--single {
            height: 2rem!important;
            border-width: 1px;
            padding: 0.1rem!important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            position: absolute;
            margin-top: -5px!important;
        }
        .h-10 {
            height: 2rem!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: small!important;
        }


        /* เมื่อเต็มจอ บังคับ wrapper และ dataTables ให้กว้างไม่เกิน viewport */
        .is-fullscreen { width:100vw; height:100vh; max-width:100vw; max-height:100vh; }
        .is-fullscreen .dataTables_wrapper { width:100vw !important; max-width:100vw; }
        /* ป้องกันพ่อ/พี่ที่ตั้ง min-width ทำให้ดันล้น */
        #table-wrapper, #table-wrapper * { min-width: 0; }


        
    </style>

    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
@section('content')
    <div class="justify-center items-center">
        <div class="mt-8 bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4">
            <div class="flex justify-center items-center">
                <p class="inline-block space-y-2 border-b-2 border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">@lang('global.content.product_channel_list')</p>
            </div>

            <div class="flex xs:right-14 sm:right-14 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-8">
                <!-- search icon = แสดงตอนปิด -->
                <svg id="off-icon" xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mt-1 mr-2.5 text-gray-900 dark:text-white cursor-pointer hidden" viewBox="0 0 330 330" fill="currentColor"
                >
                    <g id="XMLID_17_">
                        <path id="XMLID_18_" d="M125.005,165.008c-22.058,0-40.003-17.945-40.003-40.002c0-8.284-6.716-15-15-15c-8.284,0-15,6.716-15,15   
                                c0,38.6,31.403,70.002,70.003,70.002c8.284,0,15-6.716,15-15C140.005,171.724,133.289,165.008,125.005,165.008z"/>
                        <path id="XMLID_19_" d="M325.606,304.394L223.329,202.117c16.706-21.256,26.682-48.04,26.682-77.111 
                                C250.011,56.077,193.934,0,125.005,0C56.077,0,0,56.077,0,125.005C0,193.933,56.077,250.01,125.005,250.01   
                                c29.07,0,55.855-9.975,77.111-26.681l102.278,102.277C307.322,328.536,311.161,330,315,330c3.839,0,7.678-1.464,10.606-4.394   
                                C331.464,319.749,331.464,310.251,325.606,304.394z M30,125.005C30,72.619,72.619,30,125.005,30   
                                c52.386,0,95.006,42.619,95.006,95.005c0,52.386-42.62,95.005-95.006,95.005C72.619,220.01,30,177.391,30,125.005z"/>
                    </g>
                </svg>

                <!-- off icon = แสดงตอนเปิด (ค่าเริ่มต้นแสดงฟิลเตอร์ จึงให้ไอคอนนี้โชว์) -->
                <svg id="search-icon" xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 mt-1 mr-2 text-gray-900 dark:text-white cursor-pointer" viewBox="0 0 100 100" fill="currentColor"
                >
                    <circle cx="40" cy="40" r="30" stroke="currentColor" stroke-width="7" fill="none"/>
                    <line x1="60" y1="60" x2="85" y2="85" stroke="currentColor" stroke-width="7"/>
                    <line x1="10" y1="10" x2="90" y2="85" stroke="currentColor" stroke-width="7"/>
                </svg>

                <svg id="btn-enter-full" 
                    fill="currentColor"
                    class="h-7 w-7 text-gray-900 dark:text-white cursor-pointer" 
                    viewBox="0 0 32 32" 
                    version="1.1" 
                    id="fullscreen" 
                    enable-background="new 0 0 32 32" 
                    xml:space="preserve"
                >
                    <path d="M9 23h14V9H9V23zM11 11h10v10H11V11z"/>
                    <polygon points="7,21 5,21 5,27 11,27 11,25 7,25 "/>
                    <polygon points="7,7 11,7 11,5 5,5 5,11 7,11 "/>
                    <polygon points="25,25 21,25 21,27 27,27 27,21 25,21 "/>
                    <polygon points="21,5 21,7 25,7 25,11 27,11 27,5 "/>
                </svg>

                <!-- ปุ่มเข้าโหมดเต็มหน้าจอ -->
                <!-- <svg id="btn-enter-full"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="h-7 w-7 text-gray-900 dark:text-white cursor-pointer"
                    viewBox="0 0 32 32">
                <path d="M9 23h14V9H9V23zM11 11h10v10H11V11z"/>
                <polygon points="7,21 5,21 5,27 11,27 11,25 7,25 "/>
                <polygon points="7,7 11,7 11,5 5,5 5,11 7,11 "/>
                <polygon points="25,25 21,25 21,27 27,27 27,21 25,21 "/>
                <polygon points="21,5 21,7 25,7 25,11 27,11 27,5 "/>
                </svg> -->
            </div>

            <!-- ครอบทั้งส่วนด้วย Alpine -->
            <div x-data="fullTable()" x-init="init()">
                <div class="flex xs:right-14 sm:right-14 md:right-14 lg:right-14 xl:right-14 z-10 absolute mt-8">
                    <!-- ปุ่ม FULL -->
                    <svg @click="openFull()"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                        fill="currentColor"
                        class="h-7 w-7 text-gray-900 dark:text-white cursor-pointer">
                        <path d="M9 23h14V9H9V23zM11 11h10v10H11V11z"/>
                        <polygon points="7,21 5,21 5,27 11,27 11,25 7,25"/>
                        <polygon points="7,7 11,7 11,5 5,5 5,11 7,11"/>
                        <polygon points="25,25 21,25 21,27 27,27 27,21 25,21"/>
                        <polygon points="21,5 21,7 25,7 25,11 27,11 27,5"/>
                    </svg>
                </div>
                <!-- ที่อยู่ปกติของตาราง -->
                <div x-ref="tableHome">
                    <div x-ref="tableWrapper" class="bg-white dark:bg-[#232323] rounded shadow-lg md:p-4 text-gray-900 dark:text-gray-100">
                        <table id="example" class="w-full table table-striped table-bordered dt-responsive nowrap text-gray-900 dark:text-gray-100" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Product</th>
                                    <th>Product Price</th>
                                    <th>Product Name Thai</th>
                                    <th>Product Name Eng</th>
                                </tr>
                                <!-- 3) แถวฟิลเตอร์: ใช้ตัวห่อเพื่อทำ slide -->
                                <!-- แถวฟิลเตอร์ (มี 5 คอลัมน์ให้ตรงกับหัวคอลัมน์) -->
                                <tr id="filter-row">
                                    <!-- **ทริค slide**: ทำ wrapper ในแต่ละเซลล์แล้ว animate max-height/padding -->
                                    <th class="p-0 align-top">
                                        <div class="filter-cell overflow-hidden transition-all duration-300 max-h-14">
                                        <select class="js-example-basic-single w-full rounded-sm text-xs"
                                                id="BRAND_SEARCH" onchange="tentSearch()">
                                            <option value="" class="text-xs"> --- กรุณาเลือก ---</option>
                                            @foreach ($allBrands as $allBrand)
                                            <option value="{{ $allBrand }}">{{ $allBrand }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </th>

                                    <th class="p-0 align-top">
                                        <div class="filter-cell overflow-hidden transition-all duration-300 max-h-14">
                                        <input type="text" id="searchProduct"
                                                class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center"
                                                placeholder="รหัสสินค้า . . ." onkeyup="searchTable()"/>
                                        </div>
                                    </th>

                                    <th class="p-0 align-top">
                                        <div class="filter-cell overflow-hidden transition-all duration-300 max-h-14">
                                        <input type="text" id="searchProductPrice"
                                                class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center"
                                                placeholder="ราคาสินค้า . . ." onkeyup="searchTable()"/>
                                        </div>
                                    </th>

                                    <th class="p-0 align-top">
                                        <div class="filter-cell overflow-hidden transition-all duration-300 max-h-14">
                                        <input type="text" id="searchProductNameTH"
                                                class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center"
                                                placeholder="ชื่อสินค้า . . ." onkeyup="searchTable()"/>
                                        </div>
                                    </th>

                                    <th class="p-0 align-top">
                                        <div class="filter-cell overflow-hidden transition-all duration-300 max-h-14">
                                        <input type="text" id="searchProductNameEN"
                                                class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center"
                                                placeholder="ชื่อสินค้า . . ." onkeyup="searchTable()"/>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Overlay เต็มหน้าจอแบบตัวอย่างของคุณ -->
                <div x-show="modalVisible" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 transition-opacity duration-300"
                    @click.self="closeFull()"  @keydown.escape.window="closeFull()">
                    <!-- กล่องที่รองรับตาราง (95% ของจอ) -->
                    <div class="relative w-[95vw] h-[95vh] bg-neutral-900/40 rounded-lg shadow-xl ring-1 ring-white/10 p-2 overflow-auto"
                        x-ref="overlayBox">
                    <!-- ปุ่ม EXIT มุมขวาบน -->
                    <button @click="closeFull()"
                            class="absolute right-3 top-3 z-[60] rounded bg-black/70 text-white px-2 py-1">
                        <!-- fullscreen-exit -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16" class="pointer-events-none">
                        <path d="M5.5 0a.5.5 0 0 1 .5.5v4A1.5 1.5 0 0 1 4.5 6h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5m5 0a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 10 4.5v-4a.5.5 0 0 1 .5-.5M0 10.5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 6 11.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5m10 1a1.5 1.5 0 0 1 1.5-1.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0z"/>
                        </svg>
                    </button>
                    </div>
                </div>
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
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script>

        // ฟังก์ชัน toggle สำหรับแสดง/ซ่อน SVG
        function setFilters(open) {
            const row = document.getElementById('filter-row');
            const cells = document.querySelectorAll('#filter-row .filter-cell');
            const searchIcon = document.getElementById('search-icon');
            const offIcon = document.getElementById('off-icon');

            if (open) {
                row.classList.remove('hidden');                     // เอาแถวกลับมาก่อน
                cells.forEach(c => { c.classList.replace('max-h-0','max-h-14'); c.classList.replace('py-0','py-2'); });
                searchIcon.classList.add('hidden'); offIcon.classList.remove('hidden');
            } else {
                cells.forEach(c => { c.classList.replace('max-h-14','max-h-0'); c.classList.replace('py-2','py-0'); });
                // ซ่อนแถวออกจาก layout หลังจบ slide
                const onEnd = e => { if (e.propertyName==='max-height'){ row.classList.add('hidden'); row.removeEventListener('transitionend', onEnd, true);} };
                row.addEventListener('transitionend', onEnd, true);
                searchIcon.classList.remove('hidden'); offIcon.classList.add('hidden');
            }
        }

        // เริ่มต้น = เปิด
        document.addEventListener('DOMContentLoaded', () => setFilters(true));
        document.getElementById('search-icon').addEventListener('click', () => setFilters(true));
        document.getElementById('off-icon').addEventListener('click', () => setFilters(false));

        // เริ่มต้นให้เปิด
        document.addEventListener('DOMContentLoaded', () => setFilters(true));

        // bind icon
        document.getElementById('search-icon').addEventListener('click', () => setFilters(true));
        document.getElementById('off-icon').addEventListener('click', () => setFilters(false));

        function fullTable() {
            return {
                modalVisible: false,
                placeholder: null,

                init(){ /* reserved for future */ },

                // ย้ายตารางเข้า overlay
                openFull() {
                    if (this.modalVisible) return;
                    this.placeholder = document.createComment('table-placeholder');
                    // เก็บตำแหน่งเดิม
                    this.$refs.tableHome.insertBefore(this.placeholder, this.$refs.tableWrapper);
                    // ย้ายเข้ากล่อง overlay
                    this.$refs.overlayBox.appendChild(this.$refs.tableWrapper);
                    // ✅ บังคับให้ตารางขยายเต็ม modal
                    const table = this.$refs.tableWrapper.querySelector('table');
                    if (table) {
                        table.style.width = '100%';
                        table.style.maxWidth = '100%';
                    }

                    this.modalVisible = true;
                    document.body.classList.add('overflow-hidden');

                    // ให้ DataTables คำนวณความกว้างใหม่
                    queueMicrotask(() => {
                        if (window.jQuery?.fn?.dataTable) {
                            const dt = jQuery('#example').DataTable?.();
                            if (dt) {
                                dt.columns.adjust();
                                dt.responsive?.recalc();
                                dt.draw(false);
                            }
                        }
                    });
                },
                // ย้ายตารางกลับตำแหน่งเดิม
                closeFull(){
                    if(!this.modalVisible) return;
                    this.$refs.tableHome.insertBefore(this.$refs.tableWrapper, this.placeholder);
                    this.placeholder.remove();
                    this.modalVisible = false;
                    document.body.classList.remove('overflow-hidden');
                    // ปรับ DataTables หลังกลับบ้าน
                    queueMicrotask(()=> {
                        if (window.jQuery?.fn?.dataTable) {
                        const dt = jQuery('#example').DataTable?.();
                            if (dt) { 
                                dt.columns.adjust(); dt.responsive?.recalc(); dt.draw(false); 
                            }
                        }
                    });
                },
            }
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        const mytableDatatable = $('#example').DataTable({
            serverSide: true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            ordering: false,
            deferRender: true,
            scroller: true,
            scrollY: "590px",
            "order": [[1, "desc"]],
            "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]], // เพิ่ม "All"
            "pageLength": 20, // ค่าเริ่มต้นคือ "20"
            "ajax": {
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                "url": "{{ route('channel.list_product_channel') }}",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    data.BRAND = $('#BRAND_SEARCH').val();
                    data.NAME_THAI = $('#NAME_THAI_SEARCH').val();
                    data.searchProduct = $('#searchProduct').val();
                    data.searchProductNameTH = $('#searchProductNameTH').val();
                    data.searchProductNameEN = $('#searchProductNameEN').val();

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
                        return String(row.PRODUCT);
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.PRICE;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_THAI;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.NAME_ENG;
                    }
                }
            ]
        });

        // Function สำหรับเรียกใช้ DataTable เมื่อมีการพิมพ์
        function searchTable() {
            console.log("Search: ", $('#search').val());
            // บังคับให้ DataTables รีโหลดข้อมูลใหม่
            mytableDatatable.ajax.reload(null, false); 
        }

        function tentSearch() {
            mytableDatatable.draw();
        }

    </script>
@endsection