@extends('layouts.layout')
@section('title', 'Inspection & deteils')
@section('content')

    <style>

    </style>

<div class="justify-center items-center">
        <div class="mt-5 mb-5 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการเลือกให้โรงเรียน</p>
        </div>
            <div class="row flex justify-center items-center mb-3 text-gray-900 dark:text-gray-100">
                <div class="form-group row col-md-10" style="justify-content: center;">
                    <div class="form-group col-md-3">
                        <label for="countries" class="block mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">Sarch Column</label>
                        <select id="countries" class="border border-[#6b6b6b] text-gray-900 dark:text-gray-100 text-xs rounded-sm block w-full p-2.5 text-gray-900 dark:text-gray-900 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <input type="date" style="height: 38px;" class="form-control" data-date-format="dd/mm/yyyy" name="date_start" id="date_start" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                        </span>
                    </div>
                    <div class="form-group col-md-3" style="position:relative">
                        <label for="">ถึงวันที่</label>
                        <input type="date" style="height: 38px;" class="form-control" data-date-format="dd/mm/yyyy" name="date_end" id="date_end" placeholder="คลิ๊กเพื่อเลือกวัน" autocomplete="off">
                        </span>
                    </div>
                </div>
                <div class="form-group col-md-3 my-2 mt-4">
                    <label></label>
                    <button id="btnSerarch" type="button" class="btn btn-warning btn-sm form-control form-border title-search"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
                </div>
            </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script>

@endsection
