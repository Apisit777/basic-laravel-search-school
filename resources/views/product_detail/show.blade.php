@extends('layouts.layout')
@section('title', '')

    <style>
        /* A4 = 210mm x 297mm */
        @page {
            size: A4 portrait;
            margin: 0;
        }

        /* Page container styles - ขนาด A4 */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm 15mm;
            margin: 10px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            position: relative;
            page-break-after: always;
            box-sizing: border-box;
            overflow: hidden;
        }

        .page:last-child {
            page-break-after: auto;
        }

        /* Page number styles */
        .page-number {
            position: absolute;
            top: 0mm;
            right: 17mm;
            font-size: 11px;
            color: #333;
        }

        /* Content area */
        .page-content {
            max-height: 260mm;
            overflow: hidden;
        }

        /* Header ที่จะแสดงทุกหน้า */
        .page-header {
            margin-bottom: 5mm;
        }

        /* Section styles */
        .content-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .field-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .field-label {
            width: 180px;
            color: #087EF0;
            font-weight: 500;
        }

        .field-separator {
            width: 20px;
            text-align: center;
        }

        .field-value {
            color: #F72B2B;
            flex: 1;
        }

        /* Checkbox styles */
        .checkbox-row {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-right: 50px;
        }

        .checkbox-box {
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkbox-box.checked::after {
            content: '✓';
            font-size: 12px;
        }

        /* Table styles */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Dotted line separator */
        .dotted-separator {
            border-bottom: 2px dotted #000000;
            margin: 15px 0;
        }

        /* Hide original content after pagination */
        #original-content {
            display: none;
        }

        #original-content.show-original {
            display: block;
        }

        #pages-container {
            display: block;
        }

        #pages-container.hide-pages {
            display: none;
        }

        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .page {
                width: 100% !important;
                min-height: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 10mm 15mm !important;
                box-shadow: none !important;
                page-break-after: always !important;
                page-break-inside: avoid !important;
                overflow: visible !important;
            }

            .page:last-child {
                page-break-after: auto !important;
            }

            .page-content {
                max-height: none !important;
                overflow: visible !important;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            #original-content {
                display: none !important;
            }
        }

        /* ******************************************************************* */
        p {
            white-space: pre-wrap;
            color: #000000;
        }

        img {
            width: 65px;
        }

        /* List item with bullet */
        .list-item {
            display: flex;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .list-bullet {
            width: 30px;
            color: #000000;
        }

        .list-content {
            flex: 1;
        }
    </style>

@section('content')
    <div class="bg-white dark:bg-[#232323] rounded shadow-lg duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <!-- Buttons -->
            <div class="md:col-span-6 text-left mt-2 no-print">
                <a href="{{ route('product_detail.pd_detail_index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 mr-2 rounded group">
                    <svg fill="#fff" class="-mt-1 size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26.676 26.676">
                        <g>
                            <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59
                                c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815
                                C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029
                                c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562
                                C26.18,21.891,26.141,21.891,26.105,21.891z"/>
                        </g>
                    </svg>
                    Back
                </a>
                <a type="button" onclick="window.print()" class="cursor-pointer text-white bg-[#303030] hover:bg-[#404040] font-bold py-1 px-2 mr-2 rounded group">
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

            <!-- Pages Container - แสดงหน้าที่ถูก generate -->
            <div id="pages-container"></div>

            <!-- Original Content (Hidden - ใช้เป็น template) -->
            <div id="original-content">
                <!-- REF และ DATE OF ISSUE -->
                <div class="content-item ref-section" style="display: flex; justify-content: flex-end; margin-bottom: 15px; margin-top: 0px;">
                    <div style="display:grid; grid-template-columns: 130px 117px; column-gap: 10px; row-gap: 6px; align-items:baseline;">

                        <div style="text-align:right; font-weight:600; font-size: 14px;">REF :</div>
                        <div style="text-align:left; font-size: 14px; color: #F72B2B;">รหัสเอกสารของ IB</div>

                        <div style="text-align:right; font-weight:600; font-size: 14px;">DATE OF ISSUE :</div>
                        <div style="text-align:left; font-size: 14px; color: #F72B2B;">วันที่ออกเอกสาร</div>

                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="content-item content-section">
                    <div class="field-row">
                        <span class="field-label">PRODUCT CODE</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">เป็น bulk code ที่อยู่ใน BOM Bulk SAP เช่น 3-2CP291143</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">JOB REFFERENCE NO</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">เลขทะเบียนงานวิจัย เช่น CSCP-68022</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">PRODUCT NAME</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">ชื่อสินค้าที่แบรนด์สรุปแจ้งนักวิจัยเมื่อ confirm สูตร</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">APPEARANCE</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">ลักษณะเนื้อ สี ของ bulk</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">CATEGORY</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">ประเภทสินค้า</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">SHELF-LIFE (Months)</span>
                        <span class="field-separator">:</span>
                        <span class="field-value"></span>
                    </div>
                </div>

                <div class="content-item dotted-separator"></div>

                <!-- FDA Notification Section -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 15px; text-decoration: underline;">
                        FDA notification is required :
                    </div>
                    <div class="checkbox-row" style="margin-left: 100px;">
                        <div class="checkbox-group">
                            <div class="checkbox-box"></div>
                            <span>Yes</span>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-box"></div>
                            <span>No</span>
                        </div>
                    </div>
                </div>

                <!-- ต้องแสดงคำเตือนบนฉลาก Section -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 15px;">
                        ต้องแสดงคำเตือนบนฉลาก
                    </div>
                    <div class="checkbox-row" style="margin-left: 100px;">
                        <div class="checkbox-group">
                            <div class="checkbox-box"></div>
                            <span>Yes</span>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-box"></div>
                            <span>No</span>
                        </div>
                    </div>
                </div>

                <!-- รายการสารที่ต้องแสดงคำเตือน -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 15px; text-decoration: underline;">
                        รายการสารที่ต้องแสดงคำเตือน
                    </div>
                    <div style="margin-left: 30px;">
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">-</span>
                        </div>
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">-</span>
                        </div>
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">-</span>
                        </div>
                    </div>
                </div>

                <!-- ===== Special Ingredients ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Special Ingredients
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ส่วนผสม บรรยายสรรพคุณ พร้อมรูปภาพ เช่น สารสกัด วิตามิน เทคโนโลยี (ใส่ effective dose หรือ just claimed) ต้องการให้</div>
                        <div style="margin: 5px 0;">สามารถแนบไฟล์ได้ทั้ง word, excel, pdf</div>
                    </div>
                </div>

                <!-- ===== Characteristic ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Characteristic
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">คุณสมบัติของสูตรผลิตภัณฑ์ นักวิจัยบรรยายอย่างง่ายให้แต่ละสูตร เพื่อแบรนด์นำไปพิจารณา จะใช้หรือปรับข้อความตามเหมาะสม</div>
                    </div>
                </div>

                <!-- ===== Fragrance ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Fragrance 
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">บางผลิตภัณฑ์ไม่ต้องแสดงข้อมูลนี้ได้ การแสดงข้อมูลมีบรรยายแนวกลิ่น และรูป Triangle น้ำหอม หรืออาจขอแนบเป็นไฟล์ pdf</div>
                    </div>
                </div>

                <!-- ===== How To Use ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        How To Use 
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ข้อแนะนำวิธีการใช</div>
                    </div>
                </div>

                <!-- ===== Qualification claimed ===== -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Qualification claimed
                    </div>
                    <div style="display: flex; gap: 40px; font-size: 12px;">
                        <!-- Left Column -->
                        <div style="flex: 1;">

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->alcohol_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Alcohol-free (หมายถึง ปราศจากสาร Ethyl Alcohol)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->colorant_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Colorant-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->fragrance_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Fragrance Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->mineral_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Mineral Oil Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->oil_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Oil-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->paraben_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Paraben-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->petrolatum_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Petrolatum-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->petroleum_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Petroleum-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->phthalate_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Phthalate-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->silicone_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Silicone-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->triethanolamin_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Triethanolamine Free (TEA)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->chil_over_6year == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Safe for Children Over 6 Years Old.</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->pregnancy == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Safe for Pregnant</span>
                            </div>

                        </div>
                        <!-- Right Column -->
                        <div style="flex: 1;">
                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->non_comedogenic == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Non-Comedogenic (Ingredients)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->synthetic_fragrance == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>No Synthetic Fragrance</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->synthetic_colorant == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>No Synthetic Colorant</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->certified_organic == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Certified Organic Ingredients</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->certified_food == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Certified Food Grade Flavors</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->natural_alcohol == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Natural Alcohol</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->cruelty_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Cruelty-Free **(Product Only)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->hypoallergenic == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Hypoallergenic</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->tested == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Irritation Tested</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->ph_balance == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>pH Balanced (5.0-5.5)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->sls_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>SLS/SLES-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->talc_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Talc-Free</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data->sls_free == 'Y')
                                        <span style="
                                            position:absolute;
                                            top:11%;
                                            left:69%;
                                            transform:translate(-50%,-50%);
                                            font-size:22px;
                                            font-weight:700;
                                            line-height:1;
                                        ">&#x2713;</span>
                                    @endif
                                </div>
                                <span>Formula Free From (Not Listed Above and Suitable)................</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Not Recommend For Pregnant -->
                <div class="content-item content-section">
                    <div class="checkbox-row" style="margin: 5px 0; align-items: flex-start;">
                        <div class="checkbox-box" style="margin-top: 3px; flex-shrink: 0;"></div>
                        <div style="display: flex; gap: 20px; flex: 1;">
                            <!-- Left Column - Labels -->
                            <div style="flex: 1; font-size: 12px;">
                                <div style="margin-bottom: 3px;">Not Recommend For Pregnant <span style="color: #F72B2B;">(ตัวอย่าง) ควรหลีกเลี่ยงเพื่อลด</span style="color: #F72B2B;"></div>
                                <div style="margin-bottom: 3px; color: #F72B2B;">โอกาสการระคายเคือ เนื่องจากผลิตภัณฑ์มีค่า SPF50 PA++++</div>
                                <div style="color: #F72B2B;">ส่วนประกอบของ Chemical Sunscreen เป็นส่วนใหญ่</div>
                            </div>
                            <!-- Right Column - Input fields -->
                            <div style="flex: 1;">
                                <div style="border-bottom: 1px solid #000; margin-bottom: 5px; min-height: 18px;"></div>
                                <div style="border-bottom: 1px solid #000; margin-bottom: 5px; min-height: 18px;"></div>
                                <div style="border-bottom: 1px solid #000; min-height: 18px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Efficacy Test -->
                <div class="content-item content-section">
                    <div class="checkbox-row" style="margin: 5px 0; font-size: 12px; align-items: flex-end;">
                        <div class="checkbox-box" style="flex-shrink: 0; margin-bottom: 3px;"></div>
                        <span style="flex-shrink: 0;">Product Efficacy Test :</span>
                        <span style="flex: 1; border-bottom: 1px solid #000; margin: 0 0px 0px 0px;"></span>
                    </div>
                    <div class="checkbox-row" style="margin-top: 22px; font-size: 12px; align-items: flex-end;">
                        <span style="flex: 1; border-bottom: 1px solid #000; margin: 0 0px 0px 0px;"></span>
                    </div>
                    <div class="checkbox-row" style="margin-top: 22px; font-size: 12px; align-items: flex-end;">
                        <span style="flex: 1; border-bottom: 1px solid #000; margin: 0 0px 0px 0px;"></span>
                    </div>
                </div>

                <!-- Review Before Making Full Ingredients -->
                <div class="content-item content-section">
                    <div style="display: flex; margin-top: 15px; font-size: 12px;">
                        <div class="checkbox-row" style="width: 50%;">
                            <div class="checkbox-box"></div>
                            <span>No Need to Review Before Making Full Ingredients</span>
                        </div>
                        <div class="checkbox-row" style="width: 50%;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="checkbox-box"></div>
                            <span>Need to Review Before Making Full Ingredients</span>
                        </div>
                    </div>
                </div>

                <!-- ===== Natural claimed ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px;">
                        %Natural claimed
                    </div>
                    <div style="margin-left: 20px; font-size: 12px;">
                        <div style="margin: 5px 0;">....%.... Natural active ingredients</div>
                        <div style="margin: 5px 0;">....%.... Ingredient from natural origin</div>
                        <div style="margin: 5px 0;">....%.... Ingredient from natural (Ref. ISO16128)</div>
                    </div>
                </div>

                <div class="content-item dotted-separator"></div>

                <!-- ===== Ingredient List ===== -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Ingredient List
                    </div>
                    <div style="color: #087EF0; font-size: 12px;">
                        (อ้างอิง IBH-F195, Date of issue:.............. , Revision......)
                    </div>
                </div>

                <!-- Note about RA -->
                <div class="content-item content-section">
                    <div style="color: #F72B2B; font-size: 12px; margin-top: 10px;">
                        สูตรที่ไม่ต้องรับรองแจ้ง อย. สามารถใช้ข้อมูลให้ทันต่อเกาะการส่งเอกสารครั้งที่หนึ่ง
                    </div>
                    <div style="color: #F72B2B; font-size: 12px;">
                        สูตรที่ต้องรองแจ้ง เมื่อ RA ยืนยันแล้ว จะได้ Ingredient list ตามที่ยื่นจดแจ้ง ทุกข้อสารตั้งต้นด้วยตัวพิมพ์ ( , )
                    </div>
                </div>

                <div class="content-item dotted-separator"></div>

                <!-- ===== ISSUED BY / AUTHORIZED BY ===== -->
                <div class="content-item content-section" style="margin-top: 30px;">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="flex: 1;">
                            <div style="margin-bottom: 10px;">
                                <span style="font-weight: bold; font-size: 12px;">ISSUED BY :</span>
                                <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; margin-left: 10px;"></span>
                            </div>
                            <div>
                                <span style="font-weight: bold; font-size: 12px;">DATE</span>
                                <span style="margin-left: 28px;">:</span>
                                <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; margin-left: 10px;"><p style="text-align: center; font-size: 14px;"><?php echo date('Y-m-d'); ?></p></span>
                            </div>
                        </div>
                        <div style="flex: 1;">
                            <div style="margin-bottom: 10px;">
                                <span style="font-weight: bold; font-size: 12px;">AUTHORIZED BY :</span>
                                <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; margin-left: 10px;"></span>
                            </div>
                            <div>
                                <span style="font-weight: bold; font-size: 12px;">DATE</span>
                                <span style="margin-left: 64px;">:</span>
                                <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; margin-left: 10px;"><p style="text-align: center; center; font-size: 14px;"><?php echo date('Y-m-d'); ?></p></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Max content height per page
            // Page 1 มี header (~120px) จึงใส่เนื้อหาได้น้อยกว่า
            // Page 2+ ไม่มี header จึงใส่เนื้อหาได้มากกว่า
            const MAX_CONTENT_HEIGHT_PAGE1 = 850; // pixels - หน้าแรกมี header
            const MAX_CONTENT_HEIGHT_OTHER = 1000; // pixels - หน้าอื่นไม่มี header

            // Get header HTML template (เฉพาะหน้าแรก)
            function getHeaderHTML(pageNum, totalPages) {
                return `
                    <div class="page-header">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <span style="font-size: 20px; font-weight: 600; color: #000;">Product Description</span>
                            <div style="margin-right: 75px;">
                                <img src="{{ URL::asset('media/ibhs_img.png') }}" style="width: 65px;">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                            <div>
                                <div style="display: flex; margin-bottom: 5px;">
                                    <span style="font-weight: 600; font-size: 14px; width: 110px;">Document No. :</span>
                                    <span style="font-size: 14px;">IBH-F018</span>
                                </div>
                                <div style="font-weight: 600; font-size: 14px; margin-top: 15px;">Product Details</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 14px;">Declared Date : 26/01/15</div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 12px;">Institute of Beauty and Health Sciences Co.,Ltd.</div>
                                <div style="font-size: 13px; margin-top: 5px;">Tel : 02-3151074 Ext : 301 Fax : 02-7051573</div>
                            </div>
                        </div>
                        <div style="border-top: 2px solid #000; margin-top: 10px;"></div>
                    </div>
                `;
            }

            // Pagination function
            function paginateContent() {
                const originalContent = document.getElementById('original-content');
                const pagesContainer = document.getElementById('pages-container');
                const contentItems = originalContent.querySelectorAll('.content-item');

                if (contentItems.length === 0) {
                    console.log('No content items found');
                    return;
                }

                // Show original content temporarily to measure
                originalContent.style.display = 'block';
                originalContent.style.visibility = 'hidden';
                originalContent.style.position = 'absolute';

                // Group content into pages
                const pages = [];
                let currentPageItems = [];
                let currentHeight = 0;
                let currentPageIndex = 0; // 0 = page 1

                contentItems.forEach((item, index) => {
                    const itemHeight = item.offsetHeight + 15; // Add margin
                    // หน้าแรกใช้ค่าน้อยกว่าเพราะมี header
                    const maxHeight = currentPageIndex === 0 ? MAX_CONTENT_HEIGHT_PAGE1 : MAX_CONTENT_HEIGHT_OTHER;

                    if (currentHeight + itemHeight > maxHeight && currentPageItems.length > 0) {
                        // Save current page and start new one
                        pages.push([...currentPageItems]);
                        currentPageItems = [];
                        currentHeight = 0;
                        currentPageIndex++;
                    }

                    currentPageItems.push(item.outerHTML);
                    currentHeight += itemHeight;
                });

                // Add remaining items
                if (currentPageItems.length > 0) {
                    pages.push(currentPageItems);
                }

                // Hide original content
                originalContent.style.display = 'none';
                originalContent.style.visibility = '';
                originalContent.style.position = '';

                // Generate pages HTML
                const totalPages = pages.length;
                let pagesHTML = '';

                pages.forEach((pageItems, index) => {
                    const pageNum = index + 1;
                    const isFirstPage = pageNum === 1;
                    const pageNumberStyle = isFirstPage ? '' : 'top: 10mm;';

                    pagesHTML += `
                        <div class="page mt-6">
                            <div class="page-number" style="${pageNumberStyle}">Page ${pageNum} of ${totalPages}</div>
                            ${isFirstPage ? getHeaderHTML(pageNum, totalPages) : '<div style="height: 15mm;"></div>'}
                            <div class="page-content">
                                ${pageItems.join('')}
                            </div>
                        </div>
                    `;
                });

                pagesContainer.innerHTML = pagesHTML;

                console.log(`Generated ${totalPages} page(s)`);
            }

            // Initialize pagination
            paginateContent();

            // Re-paginate on resize
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(paginateContent, 250);
            });
        });
    </script>
@endsection
