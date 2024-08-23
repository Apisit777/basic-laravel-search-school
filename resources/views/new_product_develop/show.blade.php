@extends('layouts.layout')
@section('title', '')

    <style>

        @page {
            size: 210mm 297mm;
            margin: 0;
        }

        @media print {

            /* Print settings */
            body {
                margin-left: 0 !important;
            }

            page {
                width: 210mm;
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }
            .print_page_number{
                right: -70 !important;
            }
            .no-overflow {
                overflow: hidden;
            }

            #Header,
            #Footer {
                display: none !important;
            }

            button {
                display: none;
            }

            size: A4 portrait;
            /* ... the rest of the rules ... */
        }

        

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

            #print_page{
                width: auto !important;
                height: auto !important;
                overflow: visible !important;
                display: block !important;
            }
        }

/* ******************************************************************* */
    .wrapper {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0px;
        grid-auto-rows: minmax(45px, auto);
    }

    .wrapper > div {
        border: 2px solid #000;
    }
    .wrapper .one {
        grid-column: 1/3;
    }
    .wrapper .five {
        grid-column: 1/4;
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .wrapper .six {
        border-top: none;
        border-right: none;
    }
    .wrapper .sevent {
        border-top: none;
        border-right: none;
    }

    p {
        /* width: 500px; */
        /* line-height: 1.3; */
        white-space: pre-wrap;
        color: #000000;
        background-image: repeating-linear-gradient(180deg, transparent, transparent 19px, #000000 20px);
    }

    img {
        width: 70px;
        /* mix-blend-mode: multiply; */
    }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="bg-white rounded shadow-lg duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <!-- <div class="mt-5 flex justify-items-start">
                <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">New Product Development Request</p>
            </div> -->
            <div id="print_page">
                <div class="md:col-span-6 text-right mt-4 no-print">
                    <div class="inline-flex items-end">
                        <a href="{{ route('new_product_develop.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg> -->

                            <svg fill="#fff" class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                viewBox="0 0 26.676 26.676" xml:space="preserve">
                                <g>
                                    <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59
                                        c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815
                                        C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029
                                        c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562
                                        C26.18,21.891,26.141,21.891,26.105,21.891z"/>
                                    <g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                </g>
                            </svg>
                            Back
                        </a>
                        <a type="button" onclick="myFunction()" class="cursor-pointer text-white bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve"
                                class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <rect x="153.361" y="65.14" style="fill:#FFFFFF;" width="205.278" height="95.191"/>
                                <path style="fill:#1E0478;" d="M512,144.296v172.838c0,19.889-16.176,36.066-36.066,36.066h-95.582v104.517
                                    c0,5.993-4.864,10.857-10.857,10.857H142.504c-5.993,0-10.857-4.864-10.857-10.857V353.2H36.066C16.176,353.2,0,337.023,0,317.134
                                    V144.296c0-19.889,16.176-36.066,36.066-36.066h95.582V54.283c0-5.993,4.864-10.857,10.857-10.857h226.991
                                    c5.993,0,10.857,4.864,10.857,10.857v53.947h95.582C495.824,108.23,512,124.406,512,144.296z M490.287,317.134V144.296
                                    c0-7.915-6.438-14.353-14.353-14.353h-47.976v41.244c0,5.993-4.864,10.857-10.857,10.857H94.898
                                    c-5.993,0-10.857-4.864-10.857-10.857v-41.244H36.066c-7.915,0-14.353,6.438-14.353,14.353v172.838
                                    c0,7.915,6.438,14.353,14.353,14.353h95.582v-27.608h-19.803c-5.993,0-10.857-4.864-10.857-10.857s4.864-10.857,10.857-10.857
                                    h30.659h226.991h30.659c5.993,0,10.857,4.864,10.857,10.857s-4.864,10.857-10.857,10.857h-19.803v27.608h95.582
                                    C483.849,331.486,490.287,325.048,490.287,317.134z M406.245,160.331v-30.388h-25.893v30.388H406.245z M358.639,446.86V303.878
                                    H153.361V446.86L358.639,446.86L358.639,446.86z M358.639,160.331V65.14H153.361v95.191H358.639z M131.648,160.331v-30.388h-25.893
                                    v30.388H131.648z"/>
                                <path style="fill:#9B8CCC;" d="M490.287,144.296v172.838c0,7.915-6.438,14.353-14.353,14.353h-95.582v-27.608h19.803
                                    c5.993,0,10.857-4.864,10.857-10.857s-4.864-10.857-10.857-10.857h-30.659H142.504h-30.659c-5.993,0-10.857,4.864-10.857,10.857
                                    s4.864,10.857,10.857,10.857h19.803v27.608H36.066c-7.915,0-14.353-6.438-14.353-14.353V144.296c0-7.915,6.438-14.353,14.353-14.353
                                    h47.976v41.244c0,5.993,4.864,10.857,10.857,10.857h322.204c5.993,0,10.857-4.864,10.857-10.857v-41.244h47.976
                                    C483.849,129.943,490.287,136.381,490.287,144.296z M82.391,219.261c0-7.513-6.08-13.603-13.593-13.603s-13.603,6.091-13.603,13.603
                                    s6.091,13.603,13.603,13.603C76.311,232.864,82.391,226.774,82.391,219.261z"/>
                                <rect x="380.352" y="129.943" style="fill:#6F7CCD;" width="25.893" height="30.388"/>
                                <path style="fill:#94E7EF;" d="M358.639,303.878V446.86H153.361V303.878H358.639z M320.684,342.343
                                    c0-6.004-4.853-10.857-10.857-10.857H202.173c-6.004,0-10.857,4.853-10.857,10.857c0,5.993,4.853,10.857,10.857,10.857h107.655
                                    C315.831,353.2,320.684,348.336,320.684,342.343z M263.708,397.31c0-5.993-4.864-10.857-10.857-10.857h-50.679
                                    c-6.004,0-10.857,4.864-10.857,10.857s4.853,10.857,10.857,10.857h50.679C258.844,408.167,263.708,403.303,263.708,397.31z"/>
                                <g>
                                    <path style="fill:#1E0478;" d="M309.827,331.486c6.004,0,10.857,4.853,10.857,10.857c0,5.993-4.853,10.857-10.857,10.857H202.173
                                        c-6.004,0-10.857-4.864-10.857-10.857c0-6.004,4.853-10.857,10.857-10.857H309.827z"/>
                                    <path style="fill:#1E0478;" d="M252.852,386.454c5.993,0,10.857,4.864,10.857,10.857s-4.864,10.857-10.857,10.857h-50.679
                                        c-6.004,0-10.857-4.864-10.857-10.857s4.853-10.857,10.857-10.857H252.852z"/>
                                </g>
                                <rect x="105.755" y="129.943" style="fill:#6F7CCD;" width="25.893" height="30.388"/>
                                <path style="fill:#1E0478;" d="M68.799,205.658c7.513,0,13.593,6.091,13.593,13.603s-6.08,13.603-13.593,13.603
                                    s-13.603-6.091-13.603-13.603S61.286,205.658,68.799,205.658z"/>
                            </svg>
                            Print
                        </a>
                    </div>
                </div>
                <ul class="m-1 font-medium border-t border-2 border-black"></ul>
                <!-- <div class="justify-items-start mt-1 mb-3">
                    <span class="m-1 text-xl font-semibold text-black" style="font-size: 20px;">New Product Development Project Brief</span>
                </div> -->
                
                <div class="flex justify-between ...">
                    <span class="m-1 text-xl font-semibold text-black" style="font-size: 20px;">New Product Development Project Brief</span>
                    <!-- <div>02</div> -->
                    <!-- <div>03</div> -->
                    <div style="margin-top: 10px; margin-right: 85px; margin-left: 50px;">
                        <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQaOvxEZSnjYjoYtsSJUJMgaPq3WPTVvkqUywlyynplww2bv6A0" style="">
                    </div>
                    </div>
                <div class="row m-1 text-black mb-10 -mt-10 z-auto" style="">
                    <div class="col d-flex flex-row-reverse 2" style="margin-right: -80px;">
                        <div>
                            <div class="row font-semibold" style="width: 380px;">
                                <div style="width: 100px">
                                    <span style="font-size: 14px;">
                                        Document No. :
                                    </span>
                                </div>
                                <div class="col" style="">
                                    <span style="font-size: 14px;">
                                        IBH-F155
                                    </span>
                                </div>
                            </div>
                            <div class="row font-semibold" style="margin-top: 20px;">
                                <div style="width: 250px;">
                                    <span style="font-size: 14px;">
                                        Customer & Product Requirements
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex flex-row-reverse 2" style="width: 89px; margin-right: -50px;">
                        <div>
                            <div class="row" style="width: 264px; margin-top: 20px;">
                                <div style="width: 95px;">
                                    <span style="font-size: 14px;">
                                        Declared Date :
                                    </span>
                                </div>
                                <div class="col" style="width: 80px;">
                                    <span style="font-size: 14px;">
                                        26/01/15
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" style="width: 64px; margin-right: 170px;">
                        <div>
                            <div class="row text-start" style="width: 300px; margin-top: 22px;">
                                <div style="width: 250px;">
                                    <span style="font-size: 12px;">
                                        Institute of Beauty and Health Sciences Co.,Ltd.
                                    </span>
                                </div>
                                <div class="" style="width: 250px;">
                                    <span style="font-size: 13px;">
                                        Tel : 02-3151074 Ext : 301 Fax : 02-7051573
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <table class="normal_tb table table-bordered border-2 border-black" style="width: 100%; margin-top: 30px;">
                    <tbody>
                        <tr class="border-2 border-black">
                            <td class="text-center border-lb" colspan="2" width="30%" style="border-left: none; border-top: none;">รายละเอียดผู้ให้บริการ :</td>
                            <td class="text-center border-lb" colspan="1" width="20%" style="border-right: none;"></td>
                            <td colspan="1" width="20%"></td>
                            <td colspan="1" width="20%"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="" style="border-left-style: none;">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table> --}}

                <div class="wrapper mt-3" style="position: relative;">
                    <div class="one" style="border-left: none; border-right: none;">
                        <div class="text-xs" style="position:absolute">BRAND</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">OP</div>
                    </div>
                    <div class="" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PRODUCT TYPE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Make Up</div>
                    </div>
                    <div class="" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PRODUCT CODE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">23692</div>
                    </div>
                    <div class="" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PROJECT REF. NO.</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">-</div>
                    </div>
                    <div class="five" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PROJECT NAME</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Beneficial Lipstick - KISS FROM A ROSE SHEENY TINT&GLOSS</div>
                    </div>
                    <div class="" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position:absolute">TARGET GROUP</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">18-35</div>
                    </div>
                    <div class="" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position:absolute">COMPARE WITH OEM [YES / NO]</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">No</div>
                    </div>
                </div>
                <div style="position: relative;">
                    <div class="">
                        <div class="text-xs" style="position:absolute">PRODUCT CONCEPT</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; top: 5px;">
                            <p class="font-normal"> 
                                2 คุณค่าใน 1 เดียว ด้วยสีทาปากสูตรน้ําเพิ่มสีสันสดใส พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ริมฝีปาก พร้อมลิปกลอสเนื้อเนียนนุ่มเพิ่มความชุ่มช่ําอิมเอิบแก่ริมฝีปาก
                            </p>
                        </div>
                    </div>
                </div>
                <ul class="mt-4 font-medium border-t border-2 border-black"></ul>
                <div style="position: relative;">
                    <div class="">
                        <div class="text-xs" style="position:absolute">PRODUCT BENEFIT</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; top: 5px;">
                            <p class="font-normal"> 
                                สีทาปากสูตรน้ําที่ให้การติดทน พร้อมลิปกลอสที่ช่วยเพิ่มความชุ่มชื้นให้ริมฝีปาก อวบอิ่มเป็นประกายแวววาว พร้อมลิปกลอสที่ช่วยเพิ่มความชุ่มชื้นให้ริมฝีปาก อวบอิ่มเป็นประกายแวววาว พร้อมลิปกลอสที่ช่วยเพิ่มความชุ่มชื้นให้ริมฝีปาก อวบอิ่มเป็นประกายแวววาว พร้อมลิปกลอสที่ช่วยเพิ่มความชุ่มชื้นให้ริมฝีปาก อวบอิ่มเป็นประกายแวววาว
                            </p>
                        </div>
                    </div>
                </div>
                <div style="position: relative;">
                    <div class="">
                        <div class="text-md font-semibold" style="position:absolute">Formulation Requirements</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center;">-</div>
                    </div>
                </div>
                <ul class="-mt-1 font-medium border-t border-2 border-black"></ul>
            </div>
        </div>
        <!-- <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 no-print"></ul> -->
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>

        function myFunction() {
            window.print();
        }

        getParmeterLogin()
        function getParmeterLogin() {
            let dataLogin = sessionStorage.getItem("credetail");
            let dataJson = JSON.parse(dataLogin)
            console.log("🚀 ~ getParmeterLogin ~ dataJson:", dataJson)
        }

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

        const dlayMessage = 1000;
    </script>
@endsection
