@extends('layouts.layout')
@section('title', 'Inspection & deteils')

    <style>
    
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="justify-center items-center">
        <div class="mt-6 mb-5 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">เพิ่มรายการสินค้า</p>
        </div>
        <div class='w-12/12 mt-12'>
            <form action="" method="POST">
                @csrf
                <table class="table table-bordered text-gray-900 dark:text-gray-100" id="table">
                    <tr>
                        <th class="text-sm">Name</th>
                        <th class="text-sm">Action</th>
                    </tr>
                    <tr>
                        <td>
                            <input class="w-12/12 text-gray-900 text-sm form-control" type="text" name="inputs[0][name]" placeholder="Name">
                        </td>
                        <td>
                            <button type="button" name="add" id="add" class="inline-flex btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                                Add
                            </button>
                        </td>
                    </tr>
                </table>
                <button  type="submit" class="text-gray-100 bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-2 px-4 rounded cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                        <path d="M0 0h24v24H0V0z" fill="none"></path>
                        <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                        <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                    </svg>
                    Save
                </button>
            </form>

            <div class="grid 2xl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-5 mt-5 dark:text-white">
                <div class="relative h-11 w-full min-w-[200px]">
                    <input class="peer h-full w-full rounded-sm border border-blue-gray-200 border-t-transparent bg-transparent px-2 py-3 font-sans text-sm sm:text-xs font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-blue-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50 dark:bg-[#303030] text-center "
                    />
                    <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5
                                      before:w-2.5 before:rounded-tl-sm before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-sm after:border-t after:border-r
                                      after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.1] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-blue-500
                                      peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-blue-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-blue-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 text-gray-900 dark:text-gray-100
                    ">
                        ชื่อ
                    </label>
                </div>
                <div class="relative h-11 w-full min-w-[200px]">
                    <input class="peer h-full w-full rounded-sm border border-blue-gray-200 border-t-transparent bg-transparent px-2 py-3 font-sans text-sm sm:text-xs font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-blue-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50 dark:bg-[#303030] text-center "
                    />
                    <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5
                                      before:w-2.5 before:rounded-tl-sm before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-sm after:border-t after:border-r
                                      after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[4.1] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-blue-500
                                      peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-blue-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-blue-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500 text-gray-900 dark:text-gray-100
                    ">
                        รหัสลูกค้า
                    </label>
                </div>
            </div>
            <ul class="pt-2 mt-8 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <div class="grid 2xl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-2 mt-5 dark:text-white">
                <div class="relative h-11 w-full min-w-[200px]">
                    <a href="#" class="btn btn-block text-gray-100 bg-[#303030] shadow-md shadow-gray-500 rounded-sm hover:bg-[#404040] focus:outline-none group">
                        <button type="submit" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            Back
                        </button>
                    </a>
                </div>
                <div class="relative h-11 w-full min-w-[200px]">
                    <a href="#" class="btn btn-block text-gray-100 bg-[#3b5998] shadow-md shadow-gray-500 rounded-sm hover:bg-[#48639d] focus:outline-none group">
                        <button type="submit" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 md:inline-block">
                                <path fill-rule="evenodd" d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v4.19l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V10.5Z" clip-rule="evenodd" />
                            </svg>
                            Save
                        </button>
                    </a>
                </div>
            </div>

            <form class="" action="" method="POST" id="create_product">
                <div class="grid grid-cols-5 gap-10 mt-10">
                    <div class="form col-span-5">
                        <div class="relative w-full overflow-hidden">
                            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                <h1 class="text-gray-900 dark:text-white text-lg">
                                    ข้อมูลสินค้า
                                </h1>
                            </div>
                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0">
                                <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                    <div class="lg:col-span-4">
                                        <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                                            <div class="md:col-span-3">
                                                <label for="seq">รหัสสินค้า</label>
                                                <input type="text" name="seq" id="seq" class="h-10 rounded-sm px-4 w-full text-center bg-[#e7e7e7] border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-[#101010] dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" aria-label="disabled input" value="" disabled>
                                            </div>
                                            <div class="md:col-span-3">
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">เดือน<span class="text-danger"> *</span></label>
                                                <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5 ">
                                                    <option value="" selected> --- กรุณาเลือก ---</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" class="text-md">{{ $i }} เดือน</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="countries" class="mt-1 mb- text-sm font-medium text-gray-900 dark:text-white">ปี<span class="text-danger"> *</span></label>
                                                <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5">
                                                    <option value="" selected> --- กรุณาเลือก ---</option>
                                                    @for ($i = 1995; $i <= 2024; $i++)
                                                        <option value="{{ $i }}" class="text-md">{{ $i }} ปี</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="countries" class="text-sm font-medium text-gray-900 dark:text-white">ผลิตประเทศ<span class="text-danger"> *</span></label>
                                                <select id="countries" class="bg-gray-50 dark:bg-[#303030] text-gray-900 dark:text-white text-xs rounded-sm w-full p-2.5 ">
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
                                            <div class="md:col-span-3" style="position: relative;">
                                                <label for="name">เลข อย.<span class="text-danger"> *</span></label>
                                                <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-10 mt-10">
                    <div class="form col-span-5">
                        <div class="relative w-full overflow-hidden">
                            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                <h1 class="text-gray-900 dark:text-white text-lg">
                                    ส่วนผสมและการเก็บรักษา
                                </h1>
                            </div>
                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0">
                                <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                    <div class="lg:col-span-4">
                                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                            <div class="md:col-span-3">
                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ส่วนประกอบหลังกล่อง</label>
                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                            </div>
                                            <div class="md:col-span-3" style="position: relative;">
                                                <label for="name">ระยะเวลาหลังเปิดใช้<span class="text-danger"> *</span></label>
                                                <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-5 gap-10 mt-10">
                    <div class="form col-span-5">
                        <div class="relative w-full overflow-hidden">
                            <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                            <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                                <h1 class="text-gray-900 dark:text-white text-lg">
                                    วิธีใช้และคุณสมบัติอื่นๆ
                                </h1>
                            </div>
                            <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-180 peer-checked:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-full peer-checked:max-h-0">
                                <div class="p-2 grid mt-5 gap-2 gap-y-6 text-sm text-gray-900 dark:text-gray-100 grid-cols-1 lg:grid-cols-4">
                                    <div class="lg:col-span-4">
                                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
                                            <div class="md:col-span-3">
                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดหลังกล่อง(ภาษาไทย)</label>
                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดหลังกล่อง(ภาษาอังกฤษ)</label>
                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วิธีใช้(ภาษาไทย)</label>
                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                            </div>
                                            <div class="md:col-span-3">
                                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วิธีใช้(ภาษาอังกฤษ)</label>
                                                <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#303030] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                            </div>
                                            <div class="md:col-span-3" style="position: relative;">
                                                <label for="name">สี(ภาษาอังกฤษ)<span class="text-danger"> *</span></label>
                                                <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                            </div>
                                            <div class="md:col-span-3" style="position: relative;">
                                                <label for="name">สี(ภาษาอังกฤษ)<span class="text-danger"> *</span></label>
                                                <input type="text" name="name" id="name" class="h-10 border-[#303030] dark:border focus:border-blue-500 rounded-sm px-4 w-full bg-gray-50 dark:bg-[#303030] text-center" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loader" class="loading absolute hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin loading_z">
                        <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                        <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="md:col-span-6 text-right mt-4">
                    <div class="inline-flex items-end">
                        <a href="{{ route('manage_general_information.index') }}" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-4 mr-2 rounded group">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            Back
                        </a>
                        <a class="text-gray-100 bg-[#3b5998] hover:bg-[#48639d] text-white font-bold py-2 px-4 rounded cursor-pointer" onclick="createProduct()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF" class="size-6 hidden h-6 w-6 md:inline-block">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            Save
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script> --}}

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

    <script>
        let i = 0;
        $('#add').click(function() {
            ++i;
            $('#table').append(
                `<tr>
                    <td>
                        <input class="w-12/12 text-gray-900 text-sm form-control" type="text" name="inputs[`+ i +`][name]" placeholder="Name">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-table-row">Remove</button>
                    </td>
                </tr>`);
        });
        console.log("Index: ", ++i)
        $(document).on('click', '.remove-table-row', function() {
            $(this).parents('tr').remove();
        });

    </script>
@endsection
