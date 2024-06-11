
<nav class="fixed top-0 z-50 w-full border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-[#202020] duration-500">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-sm sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-[#303030] dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Hamburger icon -->
                    <svg
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </button>
                <span class="self-center text-md font-semibold sm:text-xl whitespace-nowrap text-black dark:text-white ml-2.5">Product Master</span>
            </div>
            <div class="flex items-center space-x-6 rtl:space-x-reverse">
                <div class="text-sm text-black dark:text-white -mr-5">
                    <button @click="darkMode=!darkMode" type="button" class="relative inline-flex flex-shrink-0 h-6 mr-1 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-zinc-200 dark:bg-zinc-700 w-11 focus:outline-none focus:ring-2 focus:ring-neutral-700 focus:ring-offset-2" role="switch" aria-checked="false">
                        <span class="sr-only">Use setting</span>
                        <span class="relative inline-block w-5 h-5 transition duration-500 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none dark:translate-x-5 ring-0">
                        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-500 ease-in opacity-100 dark:opacity-0 dark:duration-100 dark:ease-out" aria-hidden="true">
                            {{--
                            <x-svg class="w-4 h-4 text-neutral-700" svg="sun"/>
                            --}}
                            <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sun w-4 h-4 text-neutral-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>
                            </svg>
                        </span>
                        <span class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-100 ease-out opacity-0 dark:opacity-100 dark:duration-200 dark:ease-in" aria-hidden="true">
                            {{--
                            <x-svg class="w-4 h-4 text-neutral-700" svg="moon"/>
                            --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moon w-4 h-4 text-neutral-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                            </svg>
                        </span>
                        </span>
                    </button>
                </div>
                <div class="relative w-[120px] overflow-hidden rounded-sm bg-white dark:bg-[#303030] shadow-lg">
                    <input type="checkbox" class="peer absolute top-0 inset-x-0 w-full h-7 opacity-0 z-100000 cursor-pointer">
                    <div class="bg-white dark:bg-[#303030] shadow-lg text-white h-7 w-full pl-5 flex items-center">
                        <h1 class="text-black dark:text-white text-sm">
                            Language
                        </h1>
                    </div>
                    <div class="absolute top-1.5 right-3 text-white transition-tranform duration-500 rotate-0 peer-checked:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black dark:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="bg-white dark:bg-[#232323] shadow-lg overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-40 cursor-pointer">
                        <div class="flex justify-center items-center mt-1 hover:bg-gray-100 dark:hover:bg-[#303030]">
                            <img src="https://crm.wsmart.co.th/media/flag/usa-flag-icon.png" style="width: 22px; height: 15px; object-fit: cover;">
                            <p class="inline-block text-md font-bold text-gray-900 dark:text-gray-100 ml-2">EN</p>
                        </div>
                        <ul class="pt-1 mt-1 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-center items-center mb-1 hover:bg-gray-100 dark:hover:bg-[#303030]">
                            <img src="https://crm.wsmart.co.th/media/flag/thailand-flag-icon.png" style="width: 22px; height: 15px; object-fit: cover;">
                            <p class="inline-block text-md font-bold text-gray-900 dark:text-gray-100 ml-2">TH</p>
                        </div>
                    </div>
                </div>  
                <div class="text-black dark:text-white text-sm ml-2 mt-1">
                    <a href="#" class="text-black dark:text-white bg-white dark:bg-[#303030] shadow-lg  py-1 px-2 rounded-sm group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mb-1 hidden h-5 w-5 transition-transform group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>

    </div>
</nav>
