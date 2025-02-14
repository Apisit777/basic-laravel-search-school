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
                position: relative !important;
                top: -40px !important;
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
        grid-auto-rows: minmax(39.3px, auto);
    }

    .wrapper > div {
        border: 2px solid #000;
    }
    .wrapper2 > div {
        border: 1px solid #000;
    }
    .wrapper .one {
        grid-column: 1/3;
        border-bottom: 1px solid #000;
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

    /* .wrapper .eight {
        grid-column: 1/2;
    } */

    .wrapper .eight {
        grid-column: 1/4;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .nine {
        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
    }
    .wrapper .eight_1 {
        grid-column: 1/4;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_2 {
        grid-column: 1/1;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_3 {
        border-top: none;

        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
        border-bottom: 2px solid #000;
    }
    .wrapper .eight_4 {
        grid-column: 1/2;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .CS_eight_4 {
        grid-column: 1/2;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
        /* border-top: 1px solid #000; */
    }
    .wrapper .TARGET_eight_4 {
        grid-column: 1/2;
        border-top: 2px solid #000;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #000;
    }
    .wrapper .eight_5 {
        grid-column: 2/3;
        border-left: 1px solid #000;
        /* border-right: none; */
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_6 {
        grid-column: 3/4;
        border-left: 1px solid #000;
        /* border-right: none; */
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_7 {
        grid-column: 4/5;
        border-left: 1px solid #000;
        /* border-right: none; */
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_8 {
        grid-column: 5/6;
        border-left: 1px solid #000;
        /* border-right: none; */
        border-bottom: 1px solid #000;
    }
    .wrapper .eight_88 {
        grid-column: 5/6;
        border-top: none;
        border-left: 1px solid #000;
        border-bottom: none;
    }
    .wrapper .nine_1 {
        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
    }
    .wrapper .nine_2 {
        grid-column: 2/4;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #000;
    }
    .wrapper .nine_22 {
        grid-column: 2/3;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #000;
    }
    .wrapper .nine_23 {
        grid-column: 3/4;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #000;
    }
    .wrapper .ten {
        grid-column: 1/6;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .elevent {
        grid-column: 1/1;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .wrapper .twel {
        border-right: 1px solid #000;
        border-top: none;
        border-bottom: 1px solid #000;
        border-left: 1px solid #000;
    }
    .wrapper .thirteen {
        border-right: none;
        border-top: none;
        border-bottom: 1px solid #000;
        border-left: none;;
    }
    .rcorners1 {
        border-radius: 0px;
        border: 1px solid #000;
        /* padding: 20px;  */
        width: 25px;
        height: 20px;
    }
    .rcorners2 {
        border-radius: 0px;
        border: 1px solid #000;
        /* padding: 20px;  */
        width: 25px;
        height: 20px;
    }
    .rcorners3 {
        border-radius: 0px;
        border: 1px solid #000;
        /* padding: 20px;  */
        width: 25px;
        height: 20px;
    }
    p {
        /* width: 500px; */
        /* line-height: 1.3; */
        white-space: pre-wrap;
        color: #000000;
        background-image: repeating-linear-gradient(180deg, transparent, transparent 19px, #000000 20px);
    }

    img {
        width: 65px;
        /* mix-blend-mode: multiply; */
    }

    .rcorners3 {
    position: relative;
    top: 131px;
}
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@section('content')
    <div class="bg-white rounded shadow-lg duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
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

                <div class="flex justify-between ...">
                    <span class="m-1 text-xl font-semibold text-black" style="font-size: 20px;">New Product Development Project Brief</span>
                    <div style="margin-top: 2px; margin-right: 85px; margin-left: 50px;">
                        <img src="{{URL::asset('media/ibhs_img.png')}}">
                    </div>
                    </div>
                <div class="row m-1 text-black" style="">
                    <div class="col d-flex flex-row-reverse 2" style="margin-right: -80px;">
                        <div>
                            <div class="row font-semibold" style="width: 380px; margin-top: -10px;">
                                <div style="width: 100px">
                                    <span style="font-size: 14px;">
                                        Document No. :
                                    </span>
                                </div>
                                <div class="col" style="">
                                    <span style="font-size: 14px;">
                                        {{ $dataIBSH->DOC_NO }}
                                    </span>
                                </div>
                            </div>
                            <div class="row font-semibold" style="margin-top: 21px;">
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
                            <div class="row" style="width: 264px; margin-top: 3px;">
                                <div style="width: 95px;">
                                    <span style="font-size: 14px;">
                                        Declared Date :
                                    </span>
                                </div>
                                <div class="col" style="width: 80px;">
                                    <span style="font-size: 14px;">
                                        {{ $dataIBSH->DOC_DT }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" style="width: 64px; margin-right: 170px;">
                        <div>
                            <div class="row text-start" style="width: 300px; margin-top: 3px;">
                                <div style="width: 250px;">
                                    <span style="font-size: 12px;">
                                        Institute of Beauty and Health Sciences Co.,Ltd.
                                    </span>
                                </div>
                                <div class="" style="width: 250px; margin-top: 12px;">
                                    <span style="font-size: 13px;">
                                        Tel : 02-3151074 Ext : 301 Fax : 02-7051573
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper" style="position: relative;">
                    <div class="one" style="border-left: none; border-right: none;">
                        <div class="text-xs" style="position: absolute">BRAND</div>
                        @if ( $dataIBSH->Code >= 20000 && $dataIBSH->Code <= 28999 )
                            <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->BRAND }}</div>
                        @elseif ( $dataIBSH->Code >= 29000 && $dataIBSH->Code <= 29699 )
                            <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">RI</div>
                        @else
                            <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">CM</div>
                        @endif
                    </div>
                    <div class="" style="border-right: none; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                        <div class="text-xs" style="position:absolute">PRODUCT TYPE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->C_DESCRIPTION }}</div>
                    </div>
                    <div class="" style="border-right: none; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                        <div class="text-xs" style="position:absolute">PRODUCT CODE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->Code }}</div>
                    </div>
                    <div class="" style="border-right: none; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                        <div class="text-xs" style="position:absolute">PROJECT REF. NO.</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->JOB_REFNO }}</div>
                    </div>
                </div>

                <div class="wrapper" style="position: relative;">
                    <div class="five" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PROJECT NAME</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->NAME_ENG }}</div>
                    </div>
                    <div class="" style="border-right: none; border-top: none; border-left: 1px solid #000;">
                        <div class="text-xs" style="position:absolute">TARGET GROUP</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->TARGET_GRP }}</div>
                    </div>
                    <div class="" style="border-right: none; border-top: none; border-left: 1px solid #000;">
                        <div class="text-xs" style="position:absolute">COMPARE WITH OEM [YES / NO]</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"> {{ $dataIBSH->OEM == 'Y' ? 'Yes' : 'No' }}</div>
                    </div>
                </div>

                <div style="position: relative;">
                    <div class="">
                        <div class="text-xs" style="position: absolute">
                            PRODUCT CONCEPT
                        </div>
                        <div style="position: absolute; top: 7px; line-height: 34.5px; text-indent: 120px">
                            {{ $dataIBSH->P_CONCEPT }}
                        </div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px;"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="text-xs" style=""></div>
                    </div>
                    <ul class="mt-8 font-medium border-t border-2 border-black"></ul>
                </div>
                <div style="position: relative;">
                    <div class="">
                        <div class="text-xs" style="position:absolute">PRODUCT BENEFIT</div>
                        <div style="position: absolute; top: 7px; line-height: 34.5px; text-indent: 120px">
                            {{ $dataIBSH->P_BENEFIT }}
                        </div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px;"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <div class="" style="border-bottom: 1px solid #000; height:35px"></div>
                        <!-- <div class="" style="border-bottom: 1px solid #000; height:35px"></div> -->
                        <div class="text-md font-semibold" style="position:absolute">Formulation Requirements</div>
                    </div>
                </div>
                <div class="wrapper mt-10" style="position: relative;">
                    <div class="eight" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">ACTIVE INGREDIENT</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->INGREDIENT }}</div>
                    </div>
                    <div class="nine" style="border-right: none; grid-column: 4/6;">
                        <div class="text-xs" style="position:absolute">TEXTURE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->T_DESCRIPTION }}</div>
                    </div>
                    <div class="ten" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">REF. PRODUCT / BENCHMARK (PLEASE IDENTIFY)</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->STD }}</div>
                    </div>
                    <div class="elevent" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">TOTAL COLOR</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->Q_COLOR }}</div>
                    </div>
                    <div class="twel" style="grid-column: 2/4;">
                        <div class="text-xs" style="position:absolute">DETAIL OF COLOR</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->COLOR1 }}</div>
                    </div>
                    <div class="thirteen" style="grid-column: 4/6;">
                        <div class="text-xs" style="position:absolute">REF. OF COLOR</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->REF_COLOR }}</div>
                    </div>
                    <div class="elevent" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">TOTAL FRAGRANCE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->Q_SMELL }}</div>
                    </div>
                    <div class="twel" style="grid-column: 2/4;">
                        <div class="text-xs" style="position:absolute">FRAGRANCE TYPE OR CONCEPT</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->FRANGRANCE }}</div>
                    </div>
                    <div class="thirteen" style="grid-column: 4/6;">
                        <div class="text-xs" style="position:absolute">REF. OF FRAGRANCE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->REF_FRAGRANCE }}</div>
                    </div>
                </div>

                <div style="position: relative;">
                    <div class="">

                        <div class="text-md font-semibold" style="position:absolute">Special Test Requirements</div>
                    </div>
                </div>

                <div class="wrapper mt-10" style="position: relative;">
                    <div class="eight_1" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">EFFICACY TEST</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->OTHER }}</div>
                    </div>
                    <div class="nine_1" style="border-right: none; grid-column: 4/6;">
                        <div class="text-xs" style="position: absolute">COMPARING WITH OEM OR BENCHMARK / OTHERS</div>  
                        <!-- Compare with benchmark/OEM -->
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->REASON2_DES }}</div>
                    </div>
                    <div class="eight_2" style="border-right: none; border-bottom: none;">
                        <div class="text-xs" style="position: absolute">REASON OF USE</div>
                        <div class="" style="position: relative; display:flex; justify-content:center; align-items: center; height: 100%;">
                            
                        </div>
                    </div>
                    <div class="nine_2" style="border-right: none; border-bottom: none;">
                        <div class="text-xs rcorners1" style="position: absolute; top: 50px;">
                            <!-- <div style="position: absolute; top: -12px; line-height: 34.5px; text-indent: 120px">
                                @if ($dataIBSH->REASON1 == 'Y')
                                    <div class=" font-bold text-2xl" style="margin-left: -115px; position: relative; top: 0px;">&#x2713;</div>
                                @else
                                    <div class="ml-1 font-bold text-xl" style="position: relative; top: -10px;"></div>
                                @endif
                            </div> -->
                        </div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">To claim in advertising media</div>
                    </div>
                    <div class="eight_3" style="border-right: none; border-left: none; grid-column: 4/6; border-bottom: none;">
                        <div style="margin-left: -36px; position: absolute;top: 45px; line-height: 29.5px; text-indent: 62px;">
                            Others
                        </div>
                        <div style="margin-left: 15px; position: absolute;top: 45px; line-height: 29.5px; text-indent: 62px;">
                            
                            {{ $dataIBSH->REASON3_DES }}
                        </div>
                        <div class="text-sm rcorners1" style="position: absolute; top: 50px;">
                        </div>
                        <div style="position: absolute; top: 40px; line-height: 34.5px; text-indent: 120px">
                            @if ($dataIBSH->REASON3 == 'Y')
                                <div class=" font-bold text-2xl" style="margin-left: -114px; position: relative; top: 0px;">&#x2713;</div>
                            @else
                                <div class="ml-1 font-bold text-xl" style="position: relative; top: -10px;"></div>
                            @endif

                            <!-- <div class="ml-1 font-bold text-2xl" style="position: relative; top: -12px;">&#x2713;</div> -->
                            <!-- REF. PRODUCT / BENCHMARK (PLEASE IDENTIFY) X-XXX-XXXXXX -->
                        </div>
                        <!-- 39% -->
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 135%;">---------------------------------------------</div>
                        <div class="" style="position: absolute; top: -12px; right: 8px; display:flex; justify-content:center; align-items: center; height: 100%;">-----------</div>
                    </div>
                    <div class="eight_2" style="border-right: none; border-bottom: none;">
                        <div class="text-xs" style="position: absolute"></div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">
                        </div>
                    </div>
                    <div class="nine_2" style="border-right: none; border-bottom: none;">
                        <!-- <div style="position: relative;"> -->
                            <div class="text-xs rcorners2" style="position: absolute; top: 90px;">
                                <div style="position: absolute; top: -13px; line-height: 34.5px; text-indent: 120px">
                                    @if ($dataIBSH->REASON2 == 'Y')
                                        <div class=" font-bold text-2xl" style="margin-left: -115px; position: relative; top: 0px;">&#x2713;</div>
                                    @else
                                        <div class="ml-1 font-bold text-xl" style="position: relative; top: -10px;"></div>
                                    @endif
                                </div>
                            </div>
                        <!-- </div> -->
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">To compare with OEM/Benchmark</div>
                    </div>
                    <div class="eight_3" style="border-right: none; border-left: none; grid-column: 4/6; border-bottom: none;">
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">----------------------------------------------------------------</div>
                    </div>
                    <div class="eight" style="border-right: none;">
                        <div class="text-xs" style="position:absolute">PRIMARY PACKAGING</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->PK }}</div>
                    </div>
                    <div class="nine" style="border-right: none; grid-column: 4/5; border-left: none;">
                        <div class="text-xs rcorners3" style="position: absolute; top: 131px;">
                            @if ($dataIBSH->PACKAGE_BOX == 'Y')
                                <div class="ml-1 font-bold text-2xl" style="position: relative; top: -12px;">&#x2713;</div>
                            @else
                                <div class="ml-1 font-bold text-xl" style="position: relative; top: -10px;"></div>
                            @endif
                        </div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">
                            With an outer box
                        </div>
                    </div>
                    <div class="nine" style="border-right: none; grid-column: 5/6; border-left: none;">
                        <div class="text-xs rcorners3" style="position: absolute; top: 131px;">
                            @if ($dataIBSH->PACKAGE_BOX == 'N')
                                <div class="ml-1 font-bold text-2xl" style="position: relative; top: -12px;">&#x2713;</div>
                            @else
                                <div class="ml-1 font-bold text-xl" style="position: relative; top: -10px;"></div>
                            @endif
                        </div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">
                            Without an outer box
                        </div>
                    </div>
                </div>

                <div style="position: relative;">
                    <div class="">

                        <div class="text-md font-semibold" style="position:absolute">Target Cost & Launching Plan</div>
                    </div>
                </div>
                <div class="wrapper mt-10" style="position: relative;">
                    <div class="eight_4" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">TARGET BULK COST [BATH/KG]</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->PRICE_BULK }}</div>
                    </div>
                    <div class="eight_5" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">NET QUANTITY [g or ml]</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->CAPACITY }}</div>
                    </div>
                    <div class="eight_6" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">FIRST ORDER(PCS)</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->FIRST_ORD }}</div>
                    </div>
                    <div class="eight_5" style="border-right: none; grid-column: 4/6;">
                        <div class="text-xs" style="position: absolute">TARGET LAUNCH DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;">{{ $dataIBSH->TARGET_STK }}</div>
                    </div>
                </div>

                <div style="position: relative;">
                    <div class="">
                        <div class="text-md font-semibold" style="position:absolute">Authorization of Customer</div>
                    </div>
                </div>
                <div class="wrapper mt-10" style="position: relative;">
                    <div class="eight_4" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">NPD COORDINATOR</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_5" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">PRODUCT EXECUTIVE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_6" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">PRODUCT/CATEGORY MANAGER</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_7" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">MARKETING MANAGER/DIRECTOR</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_8" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">CEO</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_4" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_5" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_6" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_7" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_8" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                </div>

                <div class="wrapper" style="position: relative;">
                        <div class="text-md font-semibold" style="border-left: none; border-right: none; border-top: none; grid-column: 1/2;">
                            Customer Service/KM
                        </div>
                        <div class="text-md font-semibold" style="border-left: 1px solid #000; border-right: none; border-top: none; top: -40px; height: 40px; left: 206px; grid-column: 2/6;">
                            IBHS Project Review & Authorization
                        </div>
                </div>

                <div class="wrapper" style="position: relative;">
                        <div class="TARGET_eight_4 text-xs" style="border-left: none; border-right: none; border-top: none; grid-column: 1/2;">
                            TARGET GROUP ON STOCK DATE
                        </div>
                        <div class="nine_2" style="border-right: none;">
                            <div class="text-xs rcorners1" style="position: absolute; top: 10px;"></div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Product Specification & Regulation</div>
                        </div>
                        <div class="eight_3" style="border-right: none; border-left: none; grid-column: 4/6;">
                            <div class="text-xs rcorners1" style="position: absolute; top: 10px;"></div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Resources [Researcher,Equipment,Infrastructure]</div>
                        </div>
                </div>
                
                <div class="wrapper" style="position: relative;">
                        <div class="text-xs" style="border-left: none; border-right: none; border-top: none; border-bottom: none; grid-column: 1/2;">
                            CS COORDINATOR
                        </div>
                        <div class="nine_22" style="border-right: none; border-bottom: none;">
                            <div class="text-xs rcorners1" style="position: absolute; top: 10px;"></div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Skin Care</div>
                        </div>
                        <div class="nine_23" style="border-right: none; border-bottom: none;">
                            <div class="text-xs rcorners1" style="position: absolute; top: 10px;"></div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Hair Care/Toiletries</div>
                        </div>
                        <div class="eight_3" style="border-right: none; border-left: none; grid-column: 4/5; border-bottom: none;">
                            <div class="text-xs rcorners1" style="position: absolute; top: 10px;"></div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;">Make-up</div>
                        </div>
                        <div class="eight_88" style="border-right: none;">
                            <div class="text-xs" style="position: absolute">DIRECTOR OF IBHS</div>
                            <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                        </div>
                </div>
                
                <div class="wrapper" style="position: relative;">
                    <div class="CS_eight_4" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">CS MANAGER/KM</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_5" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">CUSTOMER SERVICE/IBHS</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_6" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">RESEARCHER</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_7" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">DEPT. MANAGER</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_8" style="border-right: none;">
                        <div class="text-xs" style="position: absolute">DIRECTOR OF IBHS</div>
                        <div class="" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_4" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_5" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_6" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_7" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                    <div class="eight_8" style="border-right: none; border-top: none;">
                        <div class="text-xs" style="position: absolute">DATE</div>
                        <div class="mt-1" style="display:flex; justify-content:center; align-items: center; height: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
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
    </script>
@endsection
