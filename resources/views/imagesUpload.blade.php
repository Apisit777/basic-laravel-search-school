@extends('layouts.layout')
@section('title', '')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        html * {
        box-sizing: border-box;
    }
    p {
        margin: 0;
    }
    .upload__box {
        padding: 0 40px 0 40px;
    }
    .upload__inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .upload__btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        min-width: 116px;
        padding: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 10px;
        line-height: 26px;
        font-size: 14px;
    }
    .upload__btn:hover {
        background-color: unset;
        color: #4045ba;
        transition: all 0.3s ease;
    }
    .upload__btn-box {
        margin-bottom: 20px;
    }
    .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .upload__img-box {
        width: 200px;
        gap: 5px
        /* padding: 0 10px; */
        /* margin-bottom: 12px; */
        /* margin-top: 12px; */
    }
    .upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
    }
    .upload__img-close:after {
        content: '\2716';
        font-size: 14px;
        color: white;
    }
    .img-bg {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-bottom: 100%;
    }

    /* ************************************************* */
    .list-group{
        position: relative;
        display: block;
        padding: .75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        }

        .img-wrap {
            position: relative;
        }
        .img-wrap .close {
            position: absolute;
            right: 0px;
            z-index: 100;
        }
        .close {
            opacity: 0.8;
        }
        .img-thumbnail{
            border: 0px;
            padding: 2px;
            height: 150px;
        }
        .container {
            max-width: 700px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .imgPreview img {
            border-radius: .25rem;
            padding: 2px;
            max-height: 150px;
        }
        .color_reload{
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background-color: #f5f5f5e0;
            z-index: 999;
        }
        .hide-success .active{
            transition: all 5s;
            visibility: visible;
            opacity: 1;
        }
        .hide-success .active{
            transform: translateY(-130%);
            transition-timing-function: ease-in;
            transition: 1s;
            visibility: hidden;
            opacity: 0;
        }
        .closebtn {
            position: absolute;
            top: 7px;
            right: 10px;
            color: rgb(92, 92, 92);
            float: right;
            font-size: 15px;
            line-height: 20px;
            cursor: pointer;
        }
        .upload__img-close {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            /* background-color: rgba(255, 0, 0, 0.734); */
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 21px;
            z-index: 1;
            cursor: pointer;
        }
        .upload__img-close:after {
            content: "✖";
            font-size: 14px;
            color: white;
        }
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: #7f7f7fe3; */
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2@4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
    <div class="mt-5 mb-3 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Upload Images</p>
    </div>
    <div class="justify-center items-center duration-500 p-4" style="position: relative;">
        <!-- <div class="" style="position: relative;"> -->
            {{-- <div class="" style="position: absolute; right: 10px;"> --}}

        <!-- <a href="#lightbox">
            <img
                class="rounded-md"
                src="https://images.unsplash.com/photo-1565191999001-551c187427bb?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Thumbnail"
            />
        </a> -->
        <!-- <img
            class="rounded-sm 2xl:size-auto xl:size-auto md:size-auto sm:size-auto xs:size-auto"
            src="https://images.unsplash.com/photo-1565191999001-551c187427bb?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Gambar Kucing"
        /> -->
        <!-- <div class="lg:col-span-4 py-2 px-10">
            <div class="grid gap-4 gap-y-1 text-sm grid-cols-1 md:grid-cols-6">
                <div class="md:col-span-1 mb-5">
                    <a href="#lightbox" class="group relative flex h-48 items-end overflow-hidden rounded-md bg-gray-100 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&q=75&fit=crop&w=400" loading="lazy" alt="Photo by Minh Pham" class="absolute inset-0 h-full w-full object-cover object-center transition duration-200 group-hover:scale-110" />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-gray-800 via-transparent to-transparent opacity-50">
                        </div>
                        <span class="relative ml-4 mb-3 inline-block text-sm text-white md:ml-5 md:text-lg">
                            VR
                        </span>
                    </a>

                </div>
            </div>
        </div>
        <div id="lightbox" class="hidden target:block fixed inset-0 p-10 bg-black/75 overflow-auto z-100000">
            <a href="#" class="bg-white px-3 py-1 text-black absolute right-0 top-0 rounded-sm"
                >X</a
            >
            <img
                class="rounded-sm 2xl:size-auto xl:size-auto md:size-auto sm:size-auto xs:size-auto"
                src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&q=75&fit=crop&w=1350"
                alt="Gambar Kucing"
            />
        </div> -->

        <!-- <section>
            <div x-data="{
                    imageGalleryOpened: false,
                    imageGalleryActiveUrl: null,
                    imageGalleryImageIndex: null,
                    imageGalleryOpen(event) {
                        this.imageGalleryImageIndex = event.target.dataset.index;
                        this.imageGalleryActiveUrl = event.target.src;
                        this.imageGalleryOpened = true;
                    },
                    imageGalleryClose() {
                        this.imageGalleryOpened = false;
                        setTimeout(() => this.imageGalleryActiveUrl = null, 300);
                    },
                    imageGalleryNext(){
                        if(this.imageGalleryImageIndex == this.$refs.gallery.childElementCount){
                            this.imageGalleryImageIndex = 1;
                        } else {
                            this.imageGalleryImageIndex = parseInt(this.imageGalleryImageIndex) + 1;
                        }
                        this.imageGalleryActiveUrl = this.$refs.gallery.querySelector('[data-index=\'' + this.imageGalleryImageIndex + '\']').src;
                    },
                    imageGalleryPrev() {
                        if(this.imageGalleryImageIndex == 1){
                            this.imageGalleryImageIndex = this.$refs.gallery.childElementCount;
                        } else {
                            this.imageGalleryImageIndex = parseInt(this.imageGalleryImageIndex) - 1;
                        }

                        this.imageGalleryActiveUrl = this.$refs.gallery.querySelector('[data-index=\'' + this.imageGalleryImageIndex + '\']').src;
                        
                    }
                }" 
                @image-gallery-next.window="imageGalleryNext()" @image-gallery-prev.window="imageGalleryPrev()" @keyup.right.window="imageGalleryNext();" @keyup.left.window="imageGalleryPrev();" x-init="
                    imageGalleryPhotos = $refs.gallery.querySelectorAll('img');
                    for(let i=0; i<imageGalleryPhotos.length; i++){
                        imageGalleryPhotos[i].setAttribute('data-index', i+1);
                }
                " class="select-none">
                <div class="max-w-6xl mx-auto duration-1000 delay-300 opacity-0 select-none ease animate-fade-in-view" style="translate: none; rotate: none; scale: none; opacity: 1; transform: translate(0px, 0px);">
                <ul x-ref="gallery" id="gallery" class="grid grid-cols-2 gap-5 lg:grid-cols-5 group">
                    <li><img x-on:click="imageGalleryOpen" src="https://images.pexels.com/photos/2356059/pexels-photo-2356059.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 01"></li>

                    <li><img x-on:click="imageGalleryOpen" src="https://images.pexels.com/photos/3618162/pexels-photo-3618162.jpeg" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 07"></li>
                    <li><img x-on:click="imageGalleryOpen" src="https://cdn.devdojo.com/images/june2023/mountains-10.jpeg" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 10"></li>
                    <li><img x-on:click="imageGalleryOpen" src="https://cdn.devdojo.com/images/june2023/mountains-06.jpeg" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 06"></li>
                    <li><img x-on:click="imageGalleryOpen" src="https://images.pexels.com/photos/1891234/pexels-photo-1891234.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 07"></li>
                    
                    <li><img x-on:click="imageGalleryOpen" src="https://images.unsplash.com/photo-1529655683826-aba9b3e77383?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1965&q=80" class="object-cover select-none w-full h-auto bg-gray-200 rounded cursor-zoom-in aspect-[5/6] lg:aspect-[2/3] xl:aspect-[3/4]" alt="photo gallery image 08"></li>
                </ul>
                </div>
                <template x-teleport="body">
                    <div x-show="imageGalleryOpened" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:leave="transition ease-in-in duration-300" x-transition:leave-end="opacity-0" @click="imageGalleryClose" @keydown.window.escape="imageGalleryClose" x-trap.inert.noscroll="imageGalleryOpened" class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-50 select-none cursor-zoom-out" x-cloak>
                        <div class="relative flex items-center justify-center w-11/12 xl:w-4/5 h-11/12">
                        <div @click="$event.stopPropagation(); $dispatch('image-gallery-prev')" class="absolute left-0 flex items-center justify-center text-white translate-x-10 rounded-full cursor-pointer xl:-translate-x-24 2xl:-translate-x-32 bg-white/10 w-14 h-14 hover:bg-white/20">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </div>
                        <img x-show="imageGalleryOpened" x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0 transform scale-50" x-transition:leave="transition ease-in-in duration-300" x-transition:leave-end="opacity-0 transform scale-50" class="object-contain object-center w-full h-full select-none cursor-zoom-out" :src="imageGalleryActiveUrl" alt="" style="display: none;">
                        <div @click="$event.stopPropagation(); $dispatch('image-gallery-next');" class="absolute right-0 flex items-center justify-center text-white -translate-x-10 rounded-full cursor-pointer xl:translate-x-24 2xl:translate-x-32 bg-white/10 w-14 h-14 hover:bg-white/20">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                        </div>
                    </div>
                </template>
            </div>
        </section> -->

        <!-- <div class="hide-success" style="position: absolute; right: 10;">
            <div class="alert alert-success @if(!$message = Session::get('success')) active @endif" id="messageSuccess" style="display: flex; flex-wrap: wrap; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                &nbsp; อัปโหลดข้อมูลสำเร็จ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fa fa-times closebtn" aria-hidden="true"></i>
            </div>
        </div>
        <div class="hide-success" id="error_noti_div" style="position: absolute; right: 10px;">
            <div class="alert alert-danger active" id="messageError" style="display: flex; flex-wrap: wrap; align-items: center;">
                <i class="fa fa-exclamation-circle" style="font-size: 20px"></i>
                <div id="noti_message_error"></div>
                &nbsp;<p style="color: black;">กรุณาเลือกรูปภาพ</p><p style="color: black; font-weight: bold;">&nbsp;!</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fa fa-times closebtn" style="color: black;" aria-hidden="true"></i>
            </div>
        </div> -->
        <!-- <div class="mt-5 mb-1 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Upload Images</p>
        </div> -->

        <!-- <form action="{{ route('images.store') }}" method='POST' enctype='multipart/form-data' id="file-upload-form">
        @csrf -->

        <!-- <form id="file-upload-form">
            <div class="upload__box mt-5">
                <div class="upload__btn-box">
                    <a href="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>

                    <label class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded">
                        <p>Select images</p>
                        <input type="file" name="files[]" id="file" class="upload__inputfile" multiple="">
                    </label>
                </div>
                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                    <div class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3">
                    </div>
                    <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                <ul class="mt-2.5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                <div class="flex justify-center items-center mt-10 mb-10">
                    <button id="submitBtn" type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">
                        Add Images
                    </button>
                </div>
            </div>
        </form> -->

        <!-- <div class="upload__box">
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                <div class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3"></div>
            <ul class="mt-2.5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
        </div>

        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="file" name="images[]" id="images" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Upload</button>
        </form>

        Preview before upload
        <div id="preview" class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
        Images after upload
        <div id="imagePreview" class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div> -->

        <!-- Grid layout for displaying images -->
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> -->

        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <div class="upload__box mt-5">
                <div class="upload__btn-box">
                    <a href="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>

                    <label class="text-gray-100 bg-[#303030] hover:bg-[#404040] font-bold py-2 px-4 mr-2 rounded">
                        <input type="file" name="images[]" id="images" multiple class="">
                    </label>
                </div>
                <div id="preview" class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                        <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                        <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex justify-center items-center mt-10 mb-10">
                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">Upload Images</button>
                </div>
            </div>
        </form>

        <div class="mt-5 mb-3 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Preview Images</p>
        </div>

        <section x-data="{
            galleryOpen: false,
            activeImageUrl: null,
            currentIndex: null,
            openGallery(index, src) {
                this.currentIndex = index;
                this.activeImageUrl = src;
                this.galleryOpen = true;
            },
            closeGallery() {
                this.galleryOpen = false;
                this.activeImageUrl = null;
            },
            nextImage() {
                this.currentIndex = (this.currentIndex + 1) % this.$refs.gallery.children.length;
                this.activeImageUrl = this.$refs.gallery.children[this.currentIndex].querySelector('img').src;
            },
            prevImage() {
                this.currentIndex = (this.currentIndex - 1 + this.$refs.gallery.children.length) % this.$refs.gallery.children.length;
                this.activeImageUrl = this.$refs.gallery.children[this.currentIndex].querySelector('img').src;
            }
        }" 
        @keyup.right.window="nextImage()" 
        @keyup.left.window="prevImage()" 
        @keydown.escape.window="closeGallery()" 
        class="select-none">
            <div x-ref="gallery" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 object-cover object-center upload__img-wrap bg-[#d7d8db] dark:bg-[#303030]">
            <!-- <div class="container mx-auto px-5 py-2 lg:px-32 lg:pt-24"> -->
                <!-- <div class="-m-1 flex flex-wrap md:-m-2"> -->
                    @foreach($images as $index => $image)
                        <!-- <div class="flex {{ $index % 2 === 0 ? 'w-1/2' : 'w-full' }} flex-wrap"> -->
                            <!-- <div class="{{ $index < 2 ? 'w-1/2' : 'w-full' }} p-1 md:p-2"> -->
                                <img 
                                    src="{{ asset($image->path) }}" 
                                    class="h-auto max-w-full cursor-zoom-in rounded shadow-md"
                                    @click="openGallery({{ $index }}, '{{ asset($image->path) }}')"
                                    alt="Uploaded Image"
                                >
                            <!-- </div>   -->
                        <!-- </div>   -->
                    @endforeach
                <!-- </div> -->
            <!-- </div> -->
            </div>

            <!-- Modal Popup for Large Image View -->
            <div x-show="galleryOpen" x-cloak x-transition 
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="relative w-11/12 h-11/12 xl:w-4/5">
                    <img :src="activeImageUrl" class="object-contain w-full h-full cursor-zoom-out" @click="closeGallery">
                    <button @click="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </div>

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
    
    @if (session('status'))
        <script>
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
            jQuery().ready(function () {
                toastr.success('{{ session('status') }}');
            });
        </script>
    @endif
    <script>

        let imageFiles = []; // Store selected files here
        console.log("🚀 ~ imageFiles:", imageFiles)

        // Handle image selection and preview
        document.getElementById('images').onchange = function(event) {
            const preview = document.getElementById('preview');
            const files = Array.from(event.target.files);
            
            // Append selected files to imageFiles array
            files.forEach(file => {
                imageFiles.push(file);
            });

            updatePreview(); // Call function to update the preview display
        }

        // Function to update the preview display
        function updatePreview() {
            const preview = document.getElementById('preview');
            preview.innerHTML = ''; // Clear previous preview

            imageFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'relative w-full h-64 object-cover rounded-lg shadow-md';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-lg';

                    const closeButton = document.createElement('button');
                    closeButton.innerHTML = '&times;';
                    closeButton.className = 'absolute top-2 right-2 bg-red-500 text-white rounded-full px-2 py-1 text-sm';
                    closeButton.onclick = function() {
                        removeImage(index); // Call the remove image function when clicked
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(closeButton);
                    preview.appendChild(imgContainer);
                }
                reader.readAsDataURL(file);
            });
        }

        // Remove image from preview and imageFiles array
        function removeImage(index) {
            imageFiles.splice(index, 1); // Remove image from array
            updatePreview(); // Update the preview to reflect the change
        }

        // Handle form submission and upload
        document.getElementById('uploadForm').onsubmit = function(event) {
            event.preventDefault();
            const formData = new FormData();
            console.log("🚀 ~ document.getElementById ~ formData:", formData)

            // Append files from imageFiles to the formData
            imageFiles.forEach(file => {
                formData.append('images[]', file);
            });

            $.ajax({
                url: '{{ route('images.store') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(response) {
                    if (response.success == true) {
                        window.location.reload();
                        $('#imagePreview').html(''); // Clear after success
                        response.images.forEach(function(image) {
                            $('#imagePreview').append(`
                                <div class="relative">
                                    <img src="${image}" class="w-full h-64 object-cover rounded-lg shadow-md" alt="Image">
                                </div>
                            `);
                        });
                        // Clear preview after upload
                        $('#preview').html('');
                        document.getElementById('images').value = ''; // Reset the input
                        imageFiles = []; // Clear imageFiles after upload
                    } else if (response.status === 'failed') {
                        setTimeout(function() {
                            errorMessage("Can't Create Username!");
                        },dlayMessage)
                        setTimeout(function() {
                            toastr.error("Please select image!");
                        },dlayMessage)
                    }
                },
                error: (params) => {
                console.log("🚀 ~ checkLogin ~ params:", params)

                toastr.error("Please select image!");
                // errorMessage('Check Username Or Password!')
            }
            });
        }
        const dlayMessage = 500;
        jQuery(document).ready(function () {
            ImgUpload();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function errorMessage(text) {
            $('#loader').addClass('hidden');
        }

        function ImgUpload() {
            let imgWrap = "";
            let imgArray = [];

            $('.upload__inputfile').each(function () {
                $(this).on('change', function (e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    let maxLength = $(this).attr('data-max_length');

                    let files = e.target.files;
                    let filesArr = Array.prototype.slice.call(files);
                    let iterator = 0;
                    filesArr.forEach(function (f, index) {
                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            let len = 0;
                            for (let i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                let reader = new FileReader();
                                reader.onload = function (e) {
                                    let html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function (e) {
                let file = $(this).parent().data("file");
                for (let i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
@endsection
