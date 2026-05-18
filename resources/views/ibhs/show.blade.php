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
            height: 297mm;
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
            overflow: hidden;
        }

        /* Header ที่จะแสดงทุกหน้า */
        .page-header {
            /* margin-bottom: 5mm; */
        }

        /* Section styles */
        .content-section {
            /* margin-bottom: 15px; */
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
            width: 190px;
            color: #087EF0;
            font-weight: 500;
        }

        .field-separator {
            width: 5px;
            text-align: center;
        }

        .field-value {
            /* color: #F72B2B; */
            color: #000000;
            flex: 1;
        }

        /* Checkbox styles */
        .checkbox-row {
            display: flex;
            align-items: center;
            /* margin: 10px 0; */
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
            margin: 5px 0;
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
                overflow: hidden !important;
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

        /* ******************************************************************* */
        
        .si-grid{
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 10px;

            /* ✅ เอา max-width ออก หรือเพิ่มให้กว้างขึ้น */
            /* max-width: 520px; */   /* ลบทิ้ง */
            width: 100%;
        }

        .si-img{
            width: 75%;
            height: 130px;        /* ✅ เพิ่มจาก 120 -> 200 (ปรับได้ 180/220/240) */
            object-fit: cover;
            display: block;
            border-radius: 8px;
            cursor: pointer;

            box-shadow: none !important;
            transform: none !important;
            transition: none !important;
        }
    </style>

@section('content')
    <div class="bg-white dark:bg-[#232323] rounded shadow-lg duration-500 md:p-4 mt-10">
        <div class="justify-center items-center">
            <!-- Buttons -->
            <div class="md:col-span-6 no-print mt-2 flex items-center gap-2 flex-nowrap">
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

                @if(!empty($bomRows) && count($bomRows) > 1)
                    <form method="get" class="flex items-center flex-nowrap mt-6">
                        <span class="shrink-0 text-sm text-gray-700 dark:text-gray-200 mb-2">เอกสาร: &nbsp;</span>
                        <select name="code"
                                class="js-example-basic-single"
                                onchange="this.form.submit()">
                            @foreach($bomRows as $r)
                                <option value="{{ $r['code'] }}"
                                    @selected(($selectedBom['code'] ?? '') === ($r['code'] ?? ''))>
                                    {{ $r['c_code'] ?? '-' }} ({{ $r['code'] }})
                                </option>
                            @endforeach
                        </select>

                        @foreach(request()->except('code') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                    </form>
                @endif
            </div>


            <!-- Pages Container - แสดงหน้าที่ถูก generate -->
            <div id="pages-container"></div>

            <!-- Original Content (Hidden - ใช้เป็น template) -->
            <div id="original-content">
                <!-- REF และ DATE OF ISSUE -->
                <div class="content-item ref-section" style="display: flex; justify-content: flex-end; margin-bottom: 15px; margin-top: 0px;">
                    <div style="display:grid; grid-template-columns: 130px 117px; column-gap: 10px; row-gap: 6px; align-items:baseline;">

                        <!-- <div style="text-align:right; font-weight:600; font-size: 14px;">REF :</div>
                        <div style="text-align:left; font-size: 14px; color: #F72B2B;">รหัสเอกสารของ IB</div> -->

                        <div style="text-align:right; font-weight:600; font-size: 14px;">DATE OF ISSUE :</div>
                        <div style="text-align:left; font-size: 14px;"><?php echo date('Y-m-d'); ?></div>

                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="content-item content-section">
                    <div class="field-row">
                        <span class="field-label">BULK CODE</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->bulk_id ?? '-' }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">JOB REFFERENCE NO</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->job_ref_no ?? '-' }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">PRODUCT NAME</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->product_name ?? '-' }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">APPEARANCE</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->appearance ?? '-' }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">CATEGORY</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->category ?? '-' }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">SHELF-LIFE (Months)</span>
                        <span class="field-separator">:</span>
                        <span class="field-value">{{ $data->shelf_life ?? '-' }}</span>
                    </div>
                    <div class="field-label" style="font-size: 13px;">
                        FDA notification is required
                    </div>
                    <div class="checkbox-row" style="margin-left: 100px;">
                        <div class="checkbox-group">
                            <div class="checkbox-box {{ ($data->fda_noti ?? '') == 'Y' ? 'checked' : '' }}"></div>
                            <span style="font-size: 14px;">Yes</span>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-box {{ ($data->fda_noti ?? '') != 'Y' ? 'checked' : '' }}"></div>
                            <span style="font-size: 14px;">No</span>
                        </div>
                    </div>
                </div>

                <div class="content-item dotted-separator"></div>

                <!-- FDA Notification Section -->
                <!-- <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; text-decoration: underline;">
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
                </div> -->

                <!-- ต้องแสดงคำเตือนบนฉลาก Section -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px;">
                        ต้องแสดงคำเตือนบนฉลาก
                    </div>
                    <div class="checkbox-row" style="margin-left: 100px;">
                        <div class="checkbox-group">
                            <div class="checkbox-box {{ ($data->warning_display ?? '') == 'Y' ? 'checked' : '' }}"></div>
                            <span style="font-size: 14px;">Yes</span>
                        </div>
                        <div class="checkbox-group">
                            <div class="checkbox-box {{ ($data->warning_display ?? '') != 'Y' ? 'checked' : '' }}"></div>
                            <span style="font-size: 14px;">No</span>
                        </div>
                    </div>
                </div>

                <!-- รายการสารที่ต้องแสดงคำเตือน -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 15px; text-decoration: underline;">
                        รายการสารที่ต้องแสดงคำเตือน
                    </div>
                    <div style="margin-left: 30px;">
                        @if(!empty($data->list_substances_warning_1))
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">{{ $data->list_substances_warning_1 }}</span>
                        </div>
                        @endif
                        @if(!empty($data->list_substances_warning_2))
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">{{ $data->list_substances_warning_2 }}</span>
                        </div>
                        @endif
                        @if(!empty($data->list_substances_warning_3))
                        <div class="list-item">
                            <span class="list-bullet">ชื่อสาร</span>
                            <span class="list-content">{{ $data->list_substances_warning_3 }}</span>
                        </div>
                        @endif
                        @if(empty($data->list_substances_warning_1) && empty($data->list_substances_warning_2) && empty($data->list_substances_warning_3))
                        <div class="list-item" style="color: #999; font-style: italic; font-size: 12px;">-</div>
                        @endif
                    </div>
                </div>

                <!-- ===== Special Ingredients ===== -->
                <!-- Title + text เป็น 1 item -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Special Ingredients
                    </div>
                    {{-- <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ส่วนผสม บรรยายสรรพคุณ พร้อมรูปภาพ เช่น สารสกัด วิตามิน เทคโนโลยี (ใส่ effective dose หรือ just claimed) ต้องการให้</div>
                        <div style="margin: 5px 0;">สามารถแนบไฟล์ได้ทั้ง excel, pdf</div>
                    </div> --}}
                    @if(!empty($data->ingredients))
                    <div style="margin-left: 20px; font-size: 12px; white-space: pre-wrap; word-break: break-word;">{{ $data->ingredients }}</div>
                    @endif
                </div>
                <!-- แต่ละแถวรูป (3 รูป) เป็น 1 item แยก → pagination จัดหน้าได้ละเอียดขึ้น -->
                @if($ibshSpecialImages->count())
                    @foreach($ibshSpecialImages->chunk(3) as $row)
                        <div class="content-item">
                            <div style="margin-left: 20px;">
                                <div class="si-grid" style="margin-top: 0;">
                                    @foreach($row as $ibsh)
                                        <div class="img-item">
                                            <img src="{{ asset($ibsh->path) }}" class="si-img" alt="Special Ingredients">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="content-item">
                        <div style="margin-left: 20px; font-size: 12px; color: #999; font-style: italic;">No images</div>
                    </div>
                @endif

                <!-- ===== Characteristic ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Characteristic
                    </div>
                    {{-- <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">คุณสมบัติของสูตรผลิตภัณฑ์ นักวิจัยบรรยายอย่างง่ายให้แต่ละสูตร เพื่อแบรนด์นำไปพิจารณา จะใช้หรือปรับข้อความตามเหมาะสม</div>
                    </div> --}}
                    @if(!empty($data->characteristic))
                    <div style="margin-left: 20px; font-size: 12px; white-space: pre-wrap; word-break: break-word;">{{ $data->characteristic }}</div>
                    @endif
                </div>
                @if($ibshCharacteristicImages->count())
                    @foreach($ibshCharacteristicImages->chunk(3) as $row)
                        <div class="content-item">
                            <div style="margin-left: 20px;">
                                <div class="si-grid" style="margin-top: 0;">
                                    @foreach($row as $ibsh)
                                        <div class="img-item">
                                            <img src="{{ asset($ibsh->path) }}" class="si-img" alt="Characteristic">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="content-item">
                        <div style="margin-left: 20px; font-size: 12px; color: #999; font-style: italic;">No images</div>
                    </div>
                @endif

                <!-- ===== Fragrance ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Fragrance 
                    </div>
                    {{-- <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">บางผลิตภัณฑ์ไม่ต้องแสดงข้อมูลนี้ได้ การแสดงข้อมูลมีบรรยายแนวกลิ่น และรูป Triangle น้ำหอม หรืออาจขอแนบเป็นไฟล์ pdf</div>
                    </div> --}}
                    @if(!empty($data->fragrance))
                    <div style="margin-left: 20px; font-size: 12px; white-space: pre-wrap; word-break: break-word;">{{ $data->fragrance }}</div>
                    @endif
                </div>

                <!-- ===== How To Use ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        How To Use
                    </div>
                    {{-- <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ข้อแนะนำวิธีการใช</div>
                    </div> --}}
                    @if(!empty($data->how_to_use))
                    <div style="margin-left: 20px; font-size: 12px; white-space: pre-wrap; word-break: break-word;">{{ $data->how_to_use }}</div>
                    @endif
                </div>
                <!-- <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        How To Use 
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ข้อแนะนำวิธีการใช</div>
                    </div>
                </div>
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        How To Use 
                    </div>
                    <div style="margin-left: 20px; font-size: 12px; color: #F72B2B;">
                        <div style="margin: 5px 0;">ข้อแนะนำวิธีการใช</div>
                    </div>
                </div> -->

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
                                    @if ($data && $data->alcohol_free == 'Y')
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
                                    @if ($data && $data->colorant_free == 'Y')
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
                                    @if ($data && $data->fragrance_free == 'Y')
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
                                    @if ($data && $data->mineral_free == 'Y')
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
                                    @if ($data && $data->oil_free == 'Y')
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
                                    @if ($data && $data->paraben_free == 'Y')
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
                                    @if ($data && $data->petrolatum_free == 'Y')
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
                                    @if ($data && $data->petroleum_free == 'Y')
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
                                    @if ($data && $data->phthalate_free == 'Y')
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
                                    @if ($data && $data->silicone_free == 'Y')
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
                                    @if ($data && $data->triethanolamin_free == 'Y')
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
                                    @if ($data && $data->chil_over_6year == 'Y')
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
                                    @if ($data && $data->pregnancy == 'Y')
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

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data && $data->no_need_to_review_before_making_full_ingredients == 'Y')
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
                                <span>No Need to Review Before Mading Full Ingredients</span>
                            </div>

                        </div>
                        <!-- Right Column -->
                        <div style="flex: 1;">
                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data && $data->non_comedogenic == 'Y')
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
                                    @if ($data && $data->synthetic_fragrance == 'Y')
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
                                    @if ($data && $data->synthetic_colorant == 'Y')
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
                                    @if ($data && $data->certified_organic == 'Y')
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
                                    @if ($data && $data->certified_food == 'Y')
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
                                    @if ($data && $data->natural_alcohol == 'Y')
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
                                    @if ($data && $data->cruelty_free == 'Y')
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
                                    @if ($data && $data->hypoallergenic == 'Y')
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
                                    @if ($data && $data->tested == 'Y')
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
                                    @if ($data && $data->ph_balance == 'Y')
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
                                    @if ($data && $data->sls_free == 'Y')
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
                                    @if ($data && $data->talc_free == 'Y')
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
                                    @if ($data && $data->breastfeed == 'Y')
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
                                <span>Safe for Breastfeeding</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data && $data->formula_free_from == 'Y')
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
                                <span>Formula Free From (Not Listed Above and Suitable)</span>
                            </div>

                            <div class="checkbox-row" style="margin:5px 0; display:flex; align-items:center; gap:8px;">
                                <div class="checkbox-box" style="width:16px; height:16px; border:1px solid #000; position:relative;">
                                    @if ($data && $data->need_to_review_before_making_full_ingredients == 'Y')
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
                                <span>Need to Review Before Making Full Ingredients</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Not Recommend For Pregnant -->
                @if(!empty($data->not_recommend_pregnant_text) || ($data->not_recommend_pregnant_checkbox ?? 'N') == 'Y')
                <div class="content-item content-section">
                    <div class="checkbox-row" style="margin: 5px 0; font-size: 12px; align-items: flex-end;">
                        <div class="checkbox-box checked" style="flex-shrink: 0; margin-bottom: 3px; width:16px; height:16px; border:1px solid #000; position:relative;">
                            <span style="position:absolute; top:11%; left:69%; transform:translate(-50%,-50%); font-size:22px; font-weight:700; line-height:1;">&#x2713;</span>
                        </div>
                        <span style="flex-shrink: 0; margin-left: 6px;">Not Recommend For Pregnant :</span>
                    </div>
                    @if(!empty($data->not_recommend_pregnant_text))
                    <div style="margin-left: 24px; font-size: 12px; white-space: pre-wrap;">{{ $data->not_recommend_pregnant_text }}</div>
                    @endif
                </div>
                @endif

                <!-- Product Efficacy Test -->
                @if(!empty($data->product_efficacy_test_text) || ($data->product_efficacy_test_checkbox ?? 'N') == 'Y')
                <div class="content-item content-section">
                    <div class="checkbox-row" style="margin: 5px 0; font-size: 12px; align-items: flex-end;">
                        <div class="checkbox-box checked" style="flex-shrink: 0; margin-bottom: 3px; width:16px; height:16px; border:1px solid #000; position:relative;">
                            <span style="position:absolute; top:11%; left:69%; transform:translate(-50%,-50%); font-size:22px; font-weight:700; line-height:1;">&#x2713;</span>
                        </div>
                        <span style="flex-shrink: 0; margin-left: 6px;">Product Efficacy Test :</span>
                    </div>
                    @if(!empty($data->product_efficacy_test_text))
                    <div style="margin-left: 24px; font-size: 12px; white-space: pre-wrap;">{{ $data->product_efficacy_test_text }}</div>
                    @endif
                </div>
                @endif

                <!-- Review Before Making Full Ingredients -->
                <!-- <div class="content-item content-section">
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
                </div> -->

                <!-- ===== Custom Free Form ===== -->
                @php
                    $customFreeForms = json_decode($data->custom_free_forms ?? '[]', true) ?: [];
                @endphp
                @php
                    $cffWithNote = collect($customFreeForms)->filter(fn($c) => !empty($c['note']));
                    $cffNoNote = collect($customFreeForms)->filter(fn($c) => empty($c['note']));
                @endphp

                {{-- Items WITHOUT note: display 2 per row (left/right) like Qualification claimed --}}
                @if($cffNoNote->count())
                    <div class="content-item content-section">
                        @foreach($cffNoNote->chunk(2) as $pair)
                            <div style="display: flex; margin-top: 5px; font-size: 12px;">
                                @php $pairArr = $pair->values(); @endphp
                                <div class="checkbox-row" style="width: 50%;">
                                    <div class="checkbox-box" style="position:relative;">
                                        @if(($pairArr[0]['value'] ?? 'N') === 'Y')
                                            <span style="position:absolute; top:11%; left:69%; transform:translate(-50%,-50%); font-size:22px; font-weight:700; line-height:1;">&#x2713;</span>
                                        @endif
                                    </div>
                                    <span>{{ $pairArr[0]['name'] ?? '' }}</span>
                                </div>
                                @if(isset($pairArr[1]))
                                    <div class="checkbox-row" style="width: 50%;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="checkbox-box" style="position:relative;">
                                            @if(($pairArr[1]['value'] ?? 'N') === 'Y')
                                                <span style="position:absolute; top:11%; left:69%; transform:translate(-50%,-50%); font-size:22px; font-weight:700; line-height:1;">&#x2713;</span>
                                            @endif
                                        </div>
                                        <span>{{ $pairArr[1]['name'] ?? '' }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Items WITH note: display full width with lines --}}
                @foreach($cffWithNote as $cff)
                    <div class="content-item content-section">
                        <div style="display: flex; align-items: center; font-size: 12px; margin: 5px 0;">
                            <div class="checkbox-box" style="flex-shrink: 0; width:16px; height:16px; border:1px solid #000; position:relative; margin-right: 6px;">
                                @if(($cff['value'] ?? 'N') === 'Y')
                                    <span style="position:absolute; top:11%; left:69%; transform:translate(-50%,-50%); font-size:22px; font-weight:700; line-height:1;">&#x2713;</span>
                                @endif
                            </div>
                            <span style="flex-shrink: 0; font-weight: 500;">{{ $cff['name'] ?? '' }} :</span>
                        </div>
                        <div style="
                            font-size: 12px;
                            margin-left: 22px;
                            margin-top: 2px;
                            white-space: pre-wrap;
                            word-break: break-word;
                            overflow-wrap: break-word;
                            line-height: 22px;
                            min-height: 22px;
                            background: repeating-linear-gradient(
                                to bottom,
                                transparent 0px,
                                transparent 21px,
                                #000 21px,
                                #000 22px
                            );
                        ">{{ $cff['note'] }}</div>
                    </div>
                @endforeach

                <!-- ===== Natural claimed ===== -->
                <div class="content-item content-section" style="margin-top: 20px;">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px;">
                        %Natural claimed
                    </div>
                    <div style="margin-left: 20px; font-size: 12px;">
                        <div style="margin: 5px 0;">{{ $data->natural_claimed_1 ?? '-' }} Natural active ingredients %</div>
                        <div style="margin: 5px 0;">{{ $data->natural_claimed_2 ?? '-' }} Ingredient from natural origin %</div>
                        <div style="margin: 5px 0;">{{ $data->natural_claimed_3 ?? '-' }} Ingredient from natural (Ref. ISO16128) %</div>
                    </div>
                </div>

                <div class="content-item dotted-separator"></div>

                <!-- ===== Ingredient List ===== -->
                <div class="content-item content-section">
                    <div style="font-weight: bold; font-size: 14px; margin-bottom: 10px; text-decoration: underline;">
                        Ingredient List
                    </div>
                    <!-- <div style="color: #087EF0; font-size: 12px;">
                        (อ้างอิง IBH-F195, Date of issue:.............. , Revision......)
                    </div> -->
                </div>

                <!-- Note about RA -->
                <div class="content-item content-section">
                    <!-- <div style="color: #F72B2B; font-size: 12px; margin-top: 10px;"> -->
                    <div style="color: #087EF0; font-size: 12px; margin-top: 10px;">
                        {{ $data->ingredients }}
                    </div>
                    <!-- <div style="color: #F72B2B; font-size: 12px; margin-top: 10px;">
                        สูตรที่ไม่ต้องรับรองแจ้ง อย. สามารถใช้ข้อมูลให้ทันต่อเกาะการส่งเอกสารครั้งที่หนึ่ง
                    </div>
                    <div style="color: #F72B2B; font-size: 12px;">
                        สูตรที่ต้องรองแจ้ง เมื่อ RA ยืนยันแล้ว จะได้ Ingredient list ตามที่ยื่นจดแจ้ง ทุกข้อสารตั้งต้นด้วยตัวพิมพ์ ( , )
                    </div> -->
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
                <!-- <div class="content-item content-section" style="margin-top: 30px;">
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
                </div> -->

            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/select2@4.1.0.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Header HTML (หน้าแรกเท่านั้น)
            function getHeaderHTML() {
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
                        <div style="border-top: 2px solid #000; margin-top: 0px;"></div>
                    </div>
                `;
            }

            // ===== Dynamic Pagination =====
            // ใช้ page.scrollHeight > page.clientHeight (integer-based) แทน getBoundingClientRect (float)
            // เหตุผล: getBoundingClientRect ใช้ float coordinates ที่อาจคลาดเคลื่อนเมื่อ page อยู่ไกลจาก viewport
            function paginateContent() {
                var originalContent = document.getElementById('original-content');
                var pagesContainer = document.getElementById('pages-container');

                originalContent.style.display = 'block';
                originalContent.style.visibility = 'hidden';
                originalContent.style.position = 'absolute';
                originalContent.style.left = '-9999px';
                originalContent.style.width = '180mm';

                var items = Array.from(originalContent.querySelectorAll('.content-item'));
                if (!items.length) return;

                pagesContainer.innerHTML = '';
                var idx = 0;
                var pageNum = 0;

                while (idx < items.length) {
                    pageNum++;
                    var isFirst = (pageNum === 1);

                    var page = document.createElement('div');
                    page.className = 'page mt-6';

                    var pnDiv = document.createElement('div');
                    pnDiv.className = 'page-number';
                    if (!isFirst) pnDiv.style.top = '10mm';
                    page.appendChild(pnDiv);

                    if (isFirst) {
                        var hWrap = document.createElement('div');
                        hWrap.innerHTML = getHeaderHTML();
                        while (hWrap.firstChild) page.appendChild(hWrap.firstChild);
                    } else {
                        var spacer = document.createElement('div');
                        spacer.style.height = '15mm';
                        page.appendChild(spacer);
                    }

                    var pc = document.createElement('div');
                    pc.className = 'page-content';
                    page.appendChild(pc);

                    pagesContainer.appendChild(page);

                    var added = 0;
                    // Screen renders content slightly taller than print (font metrics, mm-to-px differences).
                    // Allow 8% tolerance so items that fit in print aren't rejected on screen.
                    var cH = page.clientHeight;
                    var tolerance = Math.round(cH * 0.27);
                    console.log('[Page ' + pageNum + '] clientH=' + cH + ' tolerance=' + tolerance + 'px pcOffsetTop=' + pc.offsetTop);
                    while (idx < items.length) {
                        var clone = items[idx].cloneNode(true);
                        if (added === 0) clone.style.marginTop = '0';
                        pc.appendChild(clone);

                        var sH = page.scrollHeight;
                        var label = (clone.textContent||'').substring(0,35).trim();

                        if (sH > cH + tolerance && added > 0) {
                            console.log('  ✗ REJECT "' + label + '" pcH=' + pc.offsetHeight + ' scrollH=' + sH + ' limit=' + (cH+tolerance) + ' over=' + (sH-cH-tolerance) + 'px');
                            pc.removeChild(clone);
                            break;
                        }

                        console.log('  ✓ "' + label + '" pcH=' + pc.offsetHeight + ' scrollH=' + sH + ' remain=' + (cH+tolerance-sH) + 'px');
                        idx++;
                        added++;
                    }

                    // กัน infinite loop: item ตัวเดียวใหญ่เกินหน้า → บังคับใส่
                    if (added === 0 && idx < items.length) {
                        var forceClone = items[idx].cloneNode(true);
                        forceClone.style.marginTop = '0';
                        pc.appendChild(forceClone);
                        idx++;
                    }
                }

                originalContent.style.display = 'none';
                originalContent.style.visibility = '';
                originalContent.style.position = '';
                originalContent.style.left = '';
                originalContent.style.width = '';

                var allPages = pagesContainer.querySelectorAll('.page');
                var total = allPages.length;
                allPages.forEach(function(p, i) {
                    p.querySelector('.page-number').textContent = 'Page ' + (i + 1) + ' of ' + total;
                    // Screen: expand page height to show tolerance-overflow content (no clipping)
                    // Print CSS has height:auto so this doesn't affect print
                    if (p.scrollHeight > p.clientHeight) {
                        p.style.height = p.scrollHeight + 'px';
                    }
                });


                console.log('Pagination: ' + total + ' page(s), pageClientH=' + (allPages[0] ? allPages[0].clientHeight : '-'));
            }

            // ===== รอรูปภาพโหลดเสร็จก่อน paginate =====
            var origContent = document.getElementById('original-content');
            // แสดง off-screen เพื่อให้รูปโหลด (display:none จะไม่โหลดรูปในบาง browser)
            origContent.style.display = 'block';
            origContent.style.visibility = 'hidden';
            origContent.style.position = 'absolute';
            origContent.style.left = '-9999px';

            var imgs = origContent.querySelectorAll('img');
            var loadedCount = 0;

            function tryPaginate() {
                if (loadedCount >= imgs.length) {
                    paginateContent();
                }
            }

            if (imgs.length === 0) {
                paginateContent();
            } else {
                imgs.forEach(function(img) {
                    if (img.complete) {
                        loadedCount++;
                    } else {
                        img.addEventListener('load', function() { loadedCount++; tryPaginate(); });
                        img.addEventListener('error', function() { loadedCount++; tryPaginate(); });
                    }
                });
                tryPaginate();
            }

            // Re-paginate on resize
            var resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(paginateContent, 250);
            });
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
