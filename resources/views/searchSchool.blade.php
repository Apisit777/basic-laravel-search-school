@extends('layouts.layout')
@section('title', 'Inspection & deteils')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .table-responsive{-sm|-md|-lg|-xl|-xxl}
        element.style {
            top: 192px;
            left: 758.5px;
            z-index: 10;
            display: block;
        }
        .datepicker {
            padding: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            direction: ltr;
        }

        .arrow {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #000;
            transition: transform ease-in-out 0.3s;
        }

        [x-cloak] {
            display: none;
        }

    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- <body x-cloak x-data="{darkMode: $persist(false)}" :class="{'dark': darkMode === true }" class="antialiased"> -->
        <div class="justify-center items-center">
            <div class="mt-5 mb-5 flex justify-center items-center">
                <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการเลือกให้โรงเรียน</p>
            </div>
            <div class="row flex justify-center items-center mb-3 text-gray-900 dark:text-gray-100">
                <div class="form-group row col-md-10" style="justify-content: center;">
                    <div class="form-group col-md-3">
                        <!-- <label>Sarch Column</label>
                        <select id="contact_status" class="form-select text-gray-900 dark:text-gray-100" aria-label="Default select example" style="height: 35px;">
                            <option value="" selected>ALL</option>
                            <option value="0">doc_no</option>
                            <option value="1">member_id</option>
                            <option value="2">refer_member</option>
                            <option value="3">refer_mobile</option>
                            <option value="4">refer_idcard</option>
                            <option value="5">refer_brand</option>
                            <option value="6">branch_id</option>
                        </select> -->

                        <label for="countries" class="block mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                        <select id="countries" class="border border-[#6b6b6b] text-gray-900 dark:text-gray-900 text-xs rounded-sm block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected>ALL</option>
                            <option value="0">doc_no</option>
                            <option value="1">member_id</option>
                            <option value="2">refer_member</option>
                            <option value="3">refer_mobile</option>
                            <option value="4">refer_idcard</option>
                            <option value="5">refer_brand</option>
                            <option value="6">branch_id</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label>Value</label>
                        <input type="text" style="height: 38px;" class="form-control form-control-sm form-border" name="doc_no" id="doc_no" value="">
                    </div>
                    <div class="form-group col-md-3" style="position:relative">
                        <label for="">ช่วงวันที่</label>
                        <input type="date" style="height: 38px;" class="form-control bg-white dark:bg-[#202020] text-gray-900 dark:text-gray-100 rounded-sm cursor-pointer" data-date-format="dd/mm/yyyy" name="date_start" id="date_start" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                        <!-- <span class="bi bi-calendar" style="font-size: 20px; position: absolute; cursor: pointer; top: 32px; right: 7%;"> -->
                        </span>
                    </div>
                    <div class="form-group col-md-3" style="position:relative">
                        <label for="">ถึงวันที่</label>
                        <input type="date" style="height: 38px;" class="form-control bg-white dark:bg-[#202020] text-gray-900 dark:text-gray-100 rounded-sm cursor-pointer" data-date-format="dd/mm/yyyy" name="date_end" id="date_end" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                        <!-- <span class="bi bi-calendar" style="font-size: 20px; position: absolute; cursor: pointer; top: 32px; right: 7%;"> -->
                        </span>
                    </div>
                </div>

                <!-- <div class="antialiased sans-serif">
                    <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                        <div class="container mx-auto px-4 py-2 md:py-10">
                            <div class="mb-5 w-64">
                                <label for="datepicker" class="font-bold mb-1 text-gray-900 dark:text-white block">ช่วงวันที่</label>
                                <div class="relative">
                                    <input type="hidden" name="date" x-ref="date">
                                    <input
                                        name="date_start"
                                        type="text"
                                        readonly
                                        x-model="datepickerValue"
                                        @click="showDatepicker = !showDatepicker"
                                        @keydown.escape="showDatepicker = false"
                                        class="w-full pl-4 pr-10 leading-none rounded-sm shadow-sm cursor-pointer focus:outline-none focus:shadow-outline text-gray-900 dark:text-white font-medium bg-white dark:bg-[#202020] duration-500"
                                        placeholder="Select date">

                                        <div class="absolute top-0 right-0 px-3 py-2">
                                            <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>

                                        <div
                                            class="bg-white dark:bg-[#303030] duration-500 mt-10 rounded-lg shadow p-4 absolute top-0 -left-2"
                                            style="width: 17rem"
                                            x-show.transition="showDatepicker"
                                            @click.away="showDatepicker = false">

                                            <div class="flex justify-between items-center mb-2">
                                                <div>
                                                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-900 dark:text-white"></span>
                                                    <span x-text="year" class="ml-1 text-lg text-gray-900 dark:text-white font-normal"></span>
                                                </div>
                                                <div>
                                                    <button
                                                        type="button"
                                                        class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                                        :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                                        :disabled="month == 0 ? true : false"
                                                        @click="month--; getNoOfDays()">
                                                        <svg class="h-6 w-6 text-gray-900 dark:text-white inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                                                        :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                                        :disabled="month == 11 ? true : false"
                                                        @click="month++; getNoOfDays()">
                                                        <svg class="h-6 w-6 text-gray-900 dark:text-white inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap mb-3 -mx-1">
                                                <template x-for="(day, index) in DAYS" :key="index">
                                                    <div style="width: 14.26%" class="px-1">
                                                        <div
                                                            x-text="day"
                                                            class="text-gray-900 dark:text-white font-medium text-center text-xs"></div>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="flex flex-wrap -mx-1">
                                                <template x-for="blankday in blankdays">
                                                    <div
                                                        style="width: 14.28%"
                                                        class="text-center border p-1 border-transparent text-sm"
                                                    ></div>
                                                </template>
                                                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                    <div style="width: 14.28%" class="px-1 mb-1">
                                                        <div
                                                            @click="getDateValue(date)"
                                                            x-text="date"
                                                            class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                                            :class="{'bg-blue-500 text-gray-900 dark:text-white': isToday(date) == true, 'text-gray-900 dark:text-white hover:bg-blue-200': isToday(date) == false }"
                                                        ></div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                <div class="form-group col-md-3 my-2 mt-4">
                    <label></label>
                    <button id="btnSerarch" type="button" class="btn btn-warning btn-sm form-control form-border title-search"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                </div>
            </div>
            <!-- <button type="submit" class="absolute right-24 top-96 inline-flex items-center px-3 py-2 text-sm text-gray-100 font-medium text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-sm hover:bg-blue-900 focus:outline-none">
                Add New User
            </button> -->
            <!-- <ul class="pt-5 space-y-2 border-t border-blue-500"> -->
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
            <div class="bg-white rounded shadow-lg dark:bg-[#232323] duration-500 md:p-4 bg-white dark:bg-[#202020]">
                <div id="containerexample" class="text-gray-900 dark:text-gray-100">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap bg-white dark:bg-[#202020] text-gray-900 dark:text-gray-100" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>doc_datetime</th>
                                <th>doc_no</th>
                                <th>event</th>
                                <th>doc_refer</th>
                                <th>flag</th>
                                <th>cancel_date</th>
                                <th>cancel_user</th>
                                <th>member_id</th>
                                <th>do_befor</th>
                                <th>do_reedem</th>
                                <th>do_balance</th>
                                <th>donation_use</th>
                                <th>tb_id</th>
                                <th>school_id</th>
                                <th>remark</th>
                                <th>type_member</th>
                                <th>reg_user</th>
                                <th>reg_time</th>
                                <th>upd_user</th>
                                <th>upd_time</th>
                                <th>time_up</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.bootstrap5.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        const mytableDatatable = $('#example').DataTable({
        // new DataTable('#example', {
            'searching': false,
            "serverSide": true,
            searching: false,
            resposive: true,
            scrollX: true,
            orderCellsTop: true,
            fixedColumns: true,
            scrollCollapse: true,
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

                "url": "{{ route('search_school') }}",
                "type": "POST",
                'data': function(data){
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
                        return row.id;
                    }
                },
                {
                    targets: 1,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.doc_datetime;
                    }
                },
                {
                    targets: 2,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.doc_no;
                    }
                },
                {
                    targets: 3,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.event;
                    }
                },
                {
                    targets: 4,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.doc_refer;
                    }
                },
                {
                    targets: 5,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.flag;
                    }
                },
                {
                    targets: 6,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.cancel_date;
                    }
                },
                {
                    targets: 7,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.cancel_user;
                    }
                },
                {
                    targets: 8,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.member_id;
                    }
                },
                {
                    targets: 9,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.do_befor;
                    }
                },
                {
                    targets: 10,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.do_reedem;
                    }
                },
                {
                    targets: 11,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.do_balance;
                    }
                },
                {
                    targets: 12,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.donation_use;
                    }
                },
                {
                    targets: 13,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.tb_id;
                    }
                },
                {
                    targets: 14,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.school_id;
                    }
                },
                {
                    targets: 15,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.remark;
                    }
                },
                {
                    targets: 16,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.type_member;
                    }
                },
                {
                    targets: 17,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.reg_user;
                    }
                },
                {
                    targets: 18,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.reg_time;
                    }
                },
                {
                    targets: 19,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.upd_user;
                    }
                },
                {
                    targets: 20,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.upd_time;
                    }
                },
                {
                    targets: 21,
                    orderable: true,
                    render: function(data, type, row) {
                        return row.time_up;
                    }
                },
            ]
        });

        $('#btnSerarch').click(function() {
            mytableDatatable.draw();
        });

        // $('#date_start').flatpickr({
        //     'locale': 'th',
        //     'plugins': [new rangePlugin({input: '#date_end'})]
        // });

        // $(document).ready(function(){
        //     $(function () {
        //         $('#date_start').datepicker({
        //             format: 'yyyy/mm/dd'
        //         });
        //         $('#date_end').datepicker({
        //             format: 'yyyy/mm/dd'
        //         });
        //     });
        // });

        // const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        // const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // function app() {
        //     return {
        //         showDatepicker: false,
        //         datepickerValue: '',

        //         month: '',
        //         year: '',
        //         no_of_days: [],
        //         blankdays: [],
        //         days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

        //         initDate() {
        //             let today = new Date();
        //             this.month = today.getMonth();
        //             this.year = today.getFullYear();
        //             this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
        //         },

        //         isToday(date) {
        //             const today = new Date();
        //             const d = new Date(this.year, this.month, date);

        //             return today.toDateString() === d.toDateString() ? true : false;
        //         },

        //         getDateValue(date) {
        //             let selectedDate = new Date(this.year, this.month, date);
        //             this.datepickerValue = selectedDate.toDateString();

        //             this.$refs.date.value = selectedDate.getFullYear() +"-"+ ('0'+ selectedDate.getMonth()).slice(-2) +"-"+ ('0' + selectedDate.getDate()).slice(-2);

        //             console.log(this.$refs.date.value);

        //             this.showDatepicker = false;
        //         },

        //         getNoOfDays() {
        //             let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

        //             let dayOfWeek = new Date(this.year, this.month).getDay();
        //             let blankdaysArray = [];
        //             for ( var i=1; i <= dayOfWeek; i++) {
        //                 blankdaysArray.push(i);
        //             }

        //             let daysArray = [];
        //             for ( var i=1; i <= daysInMonth; i++) {
        //                 daysArray.push(i);
        //             }

        //             this.blankdays = blankdaysArray;
        //             this.no_of_days = daysArray;
        //         }
        //     }
        // }
    </script>
@endsection
