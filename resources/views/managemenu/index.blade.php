@extends('layouts.layout')
@section('title', 'Inspection & deteils')

    <style>
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
@section('content')
    <div class="justify-center items-center">
        <div class="mt-5 mb-5 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการจัดการเมนู</p>
        </div>
        <div class="grid grid-cols-5 gap-10 mt-12"> 
            <div class="form col-span-2"> 
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            สิทธิ์เข้าถึงผู้ใช้งาน
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40">
                        <p class="p-4 text-gray-900 dark:text-white">
                            For example
                            You enter the room you will see three row of the table,
                            I shit recentre under the air conditionner just like you.
                        </p>
                    </div>
                </div> 
                <!-- <div class="grid 2xl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-10 mt-5 mb-5 dark:text-white"> 
                </div>  -->
            </div> 
            <div class="form col-span-3"> 
                <div class="relative w-full overflow-hidden">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-12 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-[#d7d8db] dark:bg-[#303030] text-white h-12 w-full pl-5 flex items-center">
                        <h1 class="text-gray-900 dark:text-white text-lg">
                            รายการเมนู
                        </h1>
                    </div>
                    <div class="absolute top-3 right-3 text-white transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-900 dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="bg-gray-100 dark:bg-[#404040] overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40">
                        <p class="p-4 text-gray-900 dark:text-white">
                            For example
                            You enter the room you will see three row of the table,
                            I shit recentre under the air conditionner just like you.
                        </p>
                    </div>
                </div>
                <!-- <div class="grid 2xl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 gap-10 mt-5 mb-5 dark:text-white"> 
                </div>  -->
            </div> 
        </div> 
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <script type="text/javascript"  src="../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script> --}}
    <script>

    </script>
@endsection
