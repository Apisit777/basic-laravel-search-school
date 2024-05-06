<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    html * {
	 box-sizing: border-box;
}
 p {
	 margin: 0;
}
 .upload__box {
	 padding: 40px;
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
	 padding: 0 10px;
	 margin-bottom: 12px;
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
        background-color: rgba(255, 0, 0, 0.734);
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
</style>

<div class="justify-center items-center" style="position: relative;">
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
            &nbsp;<p style="color: black; font-weight: bold;">กรุณาเลือกรูปภาพ!</p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fa fa-times closebtn" aria-hidden="true"></i>
        </div>
    </div>
    <div class="mt-5 mb-5 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b border-blue-500 text-xl font-bold">รายการ Upload Images</p>
    </div>
    <form method="POST" id="file-upload-form" enctype="multipart/form-data">
        <div class="upload__box">
            <div class="upload__btn-box">
                <label class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">
                    <p>Upload images</p>
                    <input type="file" name="files[]" id="file" class="upload__inputfile">
                </label>
            </div>
            <ul class="pt-5 space-y-2 border-t border-blue-500">
                <div class="upload__img-wrap bg=[#202020]"></div>
            <ul class="pt-5 space-y-2 border-t border-blue-500">
            <div class="flex justify-center items-center mb-10">
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white text-center bg-blue-800 shadow-lg shadow-gray-500 rounded-lg hover:bg-blue-900 focus:outline-none">
                    Add Images
                </button>
            </div>
        </div>
    </form>
    <div class="mt-10 mb-10 flex justify-center items-center">
        <p class="inline-block space-y-2 border-b border-blue-500 text-xl font-bold">รายการ Preview Images</p>
    </div>
    <div class="mt-10">
        <ul class="pt-5 space-y-2 border-t border-blue-500">
            <div class="upload__img-wrap bg=[#202020]"></div>
        <ul class="pt-5 space-y-2 border-t border-blue-500">
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
jQuery(document).ready(function () {
    ImgUpload();

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#file-upload-form").submit(function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: "{{route('images_upload')}}",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#messageSuccess').removeClass('hide-success')
                    setTimeout(function() {
                        $('#messageSuccess').addClass('hide-success')
                    }, 3000)
                }
                else if (response.status === 'failed') {
                    $('#error_noti_div').removeClass('hide-success')
                    setTimeout(function() {
                        $('#error_noti_div').addClass('hide-success')
                    }, 3000)
                }
            },
            error: function(error) {

            }
        })
    })
});

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
