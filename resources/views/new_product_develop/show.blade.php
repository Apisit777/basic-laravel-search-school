@extends('layouts.layout')
@section('title', '')

    <style>
        body {
            /* background: rgb(204, 204, 204); */
        }

        page {
            background: #fff;
            display: block;
            margin: 0 auto;
            margin-bottom: 5mm;
            margin-top: 5mm;
        }

        page[size="A4"] {
            width: 210mm;
            height: 297mm;

        }
        .background_img {
            background-image: url("https://www.ssup.co.th/wp-content/uploads/2022/11/site-logo-g.png");
            z-index: 1;
            position: absolute;
            width: 200%;
            height: 200%;
            left: -433px;
            transform: rotate(25deg);
        }

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

        button {
            background-color: black;
            /* width: 245px; */
            /* border: none; */
            outline: 0;
            color: #fff;
            font-family: 'Oswald', Helvetica, Arial, sans-serif;
            font-size: 20px;
            font-weight: bold;
            padding: 8px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 0px 550px;
            cursor: pointer;
            text-transform: uppercase
        }

        button:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
            /* color: #da2d2d; */
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

        #button {
            width: 200mm;
            height: 40px;
            position: fixed;
            z-index: 10;
            /* background: #da2d2d;
            border-bottom: solid #da2d2d 6px; */
            /* background: #000000;
            border-bottom: solid #000000 6px; */
            top: 19px;
            right: 45px
        }

        #back {
            width: 200mm;
            position: fixed;
            top: 19px;
            left: 3px;
            z-index: 10;
        }
        /* ***************************************************************** */
        .size-a4 {
            width: 8.3in;
            height: 11.7in;
        }

        .pdf-header-center {
            padding: 50px 0 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .test-pdf {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .pdf-header {
            position: absolute;
            top: 1in;
            height: .6in;
            left: .5in;
            right: .5in;
            /* border-bottom: 1px solid #e5e5e5; */
        }

        .pdf-page {
            margin: 0 auto;
            /* box-sizing: border-box; */
            /* box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .3); */
            /* color: #333; */
            position: relative;

            /* background image add */
            /* background:#fff url(http://www.arabianhsr.com/en/images/footer.gif) bottom center no-repeat; */
            background-size: contain;

            /* background-color: #fff; */
        }

        .company-logo {
            /* font-size: 30px; */
            font-weight: bold;
            padding: 20px 0 0 0;
            /* color: #3aabf0; */
        }

        .invoice-number1 {
            padding-top: .25in;
            float: right;
        }
        .invoice-number2 {
            /* padding-top: .17in; */
            float: right;
        }
        /* ********************************************************** */
        .test_limit {
            padding: 70px 0 0 100px;
        }
        a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            padding: 10px 20px;
            /* border: thin solid #555; */
            font-size: 18px;
        }
        a.active {
            /* background-color: #0d81cd; */
            color:  #fff;
            border: thin solid #0d81cd;
        }
        a:focus {
            border: 1px solid #00ff00;
        }
        .page-info {
            margin-top: 90px;
            font-size: 18px;
            font-weight: bold;
        }
        .pagination {
            margin-top: 20px;
        }
        .content p {
            margin-bottom: 25px;
        }
        .page-numbers {
            display: inline-block;
        }

        /* .columns {
  column-count: 4;
  column-rule: 2px solid #303030;
} */
.newspaper {
  column-count: 3;
  column-gap: 40px;
  column-rule-style: solid;
}

/* ******************************************************************* */
    .wrapper {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0px;
        grid-auto-rows: minmax(45px, auto);
        /* border: 2px solid #000; */
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
        /* border-left: none; */
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
                <div class="md:col-span-6 text-right mt-4 no-print text-white">
                    <!-- <div id="button" class="no-print text-gray-900 dark:text-white mt-16">
                        <button type="button" onclick="myFunction()"><span class="button-txt"><i class="fa fa-print" aria-hidden="true"></i>
                                &nbsp;Print</span></button>
                    </div> -->
                    <a type="button" onclick="myFunction()" class="cursor-pointer text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 512 512" xml:space="preserve"
                            class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
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
                <ul class="m-2 font-medium border-t border-2 border-black"></ul>
                <div class="justify-items-start mt-1 mb-3">
                    <p class="m-2 text-xl font-semibold text-black" style="font-size: 20px;">New Product Development Project Brief</p>
                </div>
                <div class="row m-2 text-black mb-10" style="">
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
                                <!-- <div class="col" style="width: 80px;">
                                    <span style="font-size: 14px;">
                                        111111111111111
                                    </span>
                                </div> -->
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
                            <!-- <div class="row" style="margin-top: 10px;">
                                <div style="width: 80px;">
                                    <span style="font-size: 14px;">
                                        ชื่อโรงเรียน
                                    </span>
                                </div>
                                <div class="col" style="width: 310px;">
                                    <span style="font-size: 12px;" >
                                        11111111111111111111111
                                    </span>
                                </div>
                            </div> -->
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
                            <!-- <div class="row" style="margin-top: 10px;">
                                <div style="width: 70px;">
                                    <span style="font-size: 12px;">
                                        วันที่                    </span>
                                </div>
                                <div class="col" style="width: 80px;border-bottom: 1px solid black;">
                                    <span style="font-size: 12px;">08 พฤษภาคม 2567</span>
                                </div>
                            </div> -->
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

                <div class="wrapper" style="position: relative;">
                    <div class="one" style=" border-left: none; border-right: none;">
                        <div class="1one" style="position:absolute">Test</div>
                        <div class="1one" style="display:flex; justify-content:center; align-items: center; height: 100%;">aaaaaaaaaaaa</div>
                    </div>
                    <div class="two" style=" border-right: none">two</div>
                    <div class="three" style=" border-right: none">Three</div>
                    <div class="four" style=" border-right: none">Four</div>
                    <div class="five" style="">Five</div>
                    <div class="six" style="border-top: none">Six</div>
                    <div class="sevent" style="border-top: none">Six</div>
                  </div>
            </div>
        </div>
        <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700 no-print"></ul>
        <div class="md:col-span-6 text-right mt-4 no-print">
            <div class="inline-flex items-end">
                <a href="{{ route('new_product_develop.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                        <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            $('.js-example-basic-single').select2();
            onOpenhandler()
            document.querySelectorAll('.setcheckbox')[0].checked = true
            document.querySelectorAll('.bg_step_color')[0].classList.remove('!bg-primary-100', '!text-primary-700', 'dark:!bg-slate-900', 'dark:!text-primary-500')
            document.querySelectorAll('.bg_step_color')[0].classList.add('bg-success-100', 'text-success-700', 'dark:bg-green-950', 'dark:text-success-500/80')
        });

        // let i = 0;
        // $('#add').click( () => {
        //     ++i;
        //     $('#table').append(
        //         `<tr>
        //             <td>
        //                 <input class="w-11/12 text-gray-900 text-sm form-control" type="text" name="inputs[`+ i +`][name]" placeholder="Name">
        //             </td>
        //             <td>
        //                 <button type="button" class="btn btn-danger remove-table-row">Remove</button>
        //             </td>
        //         </tr>`);
        // });
        // console.log("Index: ", ++i)
        // $(document).on('click', '.remove-table-row', function() {
        //     $(this).parents('tr').remove();
        // });

        jQuery('#username_loading').hide();
        jQuery("#username_alert").hide();
        jQuery("#correct_username").hide();

        function checkNameBrand() {
            const edit_id = jQuery('#edit_id').val();
            const name = jQuery('#id_brand').val();

            jQuery.ajax({
                method: "POST",
                url: '{{ route('checknamebrand') }}',
                data: {
                        _token: "{{ csrf_token() }}",
                        edit_id, name
                    },
                dataType: 'json',
                beforeSend: function () {
                    jQuery("#submitButton").attr("disabled", true);
                    jQuery('#username_loading').show();
                    jQuery("#correct_username").hide();
                    jQuery("#username_alert").hide();
                },
                success: function (checknamebrand) {
                    jQuery('#username_loading').hide();
                    jQuery("#correct_username").hide();

                    if (name == '') {
                        jQuery("#submitButton").attr("disabled", false);
                        jQuery("#correct_username").hide();
                        jQuery("#username_alert").hide();
                        jQuery("#id_brand").removeClass("is-invalid");
                    } else if (checknamebrand == true) {
                        jQuery("#submitButton").attr("disabled", false);
                        jQuery("#username_alert").hide();
                        jQuery("#id_brand").removeClass("is-invalid");
                        jQuery("#correct_username").show();
                    } else {
                        jQuery("#username_alert").show();
                        jQuery("#id_brand").addClass("is-invalid");
                        jQuery("#correct_username").hide();
                    }
                },
                error: function (params) {
                }
            });
        }

        function brandIdChange(e, params) {
            let url = "";
            let select = "";

            if (params === 'brand_id') {
                url = '{{ route('ajax_brand_id') }}?brand_id=' + e.value;
                select = jQuery('#product_id');
                jQuery('#product_id').find("option").remove();
                select.find("option").remove();
                const newop = new Option("--- กรุณาเลือก ---", "");
                jQuery(newop).appendTo(jQuery('#product_id'))
            }

            jQuery.ajax({
                method: "GET",
                url,
                dataType: 'json',
                beforeSend: function () {
                    select.find("option").remove();
                    const newoption = new Option("LOADING..", "");
                    jQuery(newoption).appendTo(select)

                },
                success: function (data) {
                    if (data) {
                        select.find("option").remove();
                        const newop = new Option("--- กรุณาเลือก ---", "");
                        jQuery(newop).appendTo(select)
                        data.map((item, index) => {
                            console.log('item', item)
                            const newoption = new Option(item.product_id, item.seq);
                            jQuery(newoption).appendTo(select)
                        });
                    }
                },
                error: function (params) {
                    select.find("option").remove();
                    const newop = new Option("error", "");
                    jQuery(newop).appendTo(select)
                    console.log('ajax error ::', params);
                }
            });
        }

        function onSelect(seq) {
            console.log("🚀 ~ funnctiononSelect ~ r:", seq.value);
            if (seq) {
                $('#company_products').val(seq.value);
            } else {
                $('#company_products').val();
            }
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

        // function createNPDRequest() {
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         method: "POST",
        //         url: "/create_new_product_develop",
        //         data: $("#create_NPDRequest").serialize(),
        //         beforeSend: function () {
        //             $('#loader').removeClass('hidden')
        //         },
        //         success: function(res){
        //             if(res.success == true) {
        //                 window.location = "/new_product_develop";
        //             } else {
        //                 toastr.error("Can't Create Product!");
        //             }
        //             return false;
        //         },
        //         error: function (params) {
        //             setTimeout(function() {
        //                 errorMessage("Can't Create Username!");
        //             },dlayMessage)
        //             setTimeout(function() {
        //                 toastr.error("Can't Create Username!");
        //             },dlayMessage)
        //         }
        //     });
        // }

        // function successMessage(text) {
        //     $('#loader').addClass('hidden');
        //     $('#name').val('')
        // }
        // function errorMessage(text) {
        //     $('#loader').addClass('hidden');
        //     $('#name').val('')
        // }
    </script>
@endsection
