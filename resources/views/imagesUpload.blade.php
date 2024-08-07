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
            z-index: 1000;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="mt-5 mb-3 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Upload Images</p>
    </div>
    <div class="justify-center items-center duration-500" style="position: relative;">
        <!-- <div class="" style="position: relative;"> -->
            {{-- <div class="" style="position: absolute; right: 10px;"> --}}
        <div class="hide-success" style="position: absolute; right: 10;">
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
        </div>
        <!-- <div class="mt-5 mb-1 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Upload Images</p>
        </div> -->
        <form method="POST" id="file-upload-form" enctype="multipart/form-data">
            <div class="upload__box">
                <div class="upload__btn-box">
                    <a href="" class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-4 mr-2 rounded group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hidden h-6 w-6 transition-transform duration-300 group-hover:translate-x-1 rtl:rotate-180 rtl:group-hover:-translate-x-1 md:inline-block">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>

                    <label class="text-gray-100 bg-[#303030] hover:bg-[#404040] text-white font-bold py-2 px-4 mr-2 rounded">
                        <p>Upload images</p>
                        <input type="file" name="files[]" id="file" class="upload__inputfile" multiple="">
                    </label>
                </div>
                <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                    <div class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3 relative">
                    </div>
                    <div id="loader" class="loading absolute hidden bg-[#e4e4e4e3] dark:bg-[#2a2a2afa]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 animate-spin dark:text-white">
                            <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                            <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                <ul class="mt-2.5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                <div class="flex justify-center items-center mt-10 mb-10">
                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">
                        Add Images
                    </button>
                </div>
            </div>
        </form>
        <div class="mt-5 mb-3 flex justify-center items-center">
            <p class="inline-block space-y-2 border-b border-gray-200 dark:border-gray-700 text-xl font-bold text-gray-900 dark:text-gray-100">รายการ Preview Images</p>
        </div>
        <div class="upload__box">
            <ul class="pt-2.5 mt-5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
                <div class="upload__img-wrap bg-[#d7d8db] dark:bg-[#303030] p-3"></div>
            <ul class="mt-2.5 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"></ul>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
        const dlayMessage = 500;
        jQuery(document).ready(function () {
            ImgUpload();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        let url = "{{ route('images_upload') }}";
        $("#file-upload-form").submit(function(event) {
            event.preventDefault();
            // const formData = new FormData(this);
            $.ajax({
                type: "POST",
                url,
                // data: formData,
                data: $("#file-upload-form").serialize(),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loader').removeClass('hidden')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#messageSuccess').removeClass('hide-success')
                        setTimeout(function() {
                            $('#messageSuccess').addClass('hide-success')
                        }, 3000)
                    }
                    else if (response.status === 'failed') {
                        // $('#error_noti_div').removeClass('hide-success')
                        // setTimeout(function() {
                        //     $('#error_noti_div').addClass('hide-success')
                        // }, 3000)
                        setTimeout(function() {
                            errorMessage("Can't Create Username!");
                        },dlayMessage)
                        setTimeout(function() {
                            toastr.error("Please select image!");
                        },dlayMessage)
                    }
                },
                error: function(error) {

                }
            })
        })

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
