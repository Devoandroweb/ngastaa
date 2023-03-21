"use strict"
var _IMG_LIVE = null;
var _ID_TARGET = null;
var _EXT = null;
$('.image-live img').addClass('cursor-pointer')
// console.log($('.image-live').find('img'))
$(document).on('click','.image-live img',function (e) {
    _IMG_LIVE = $(this).closest('.image-live');
    _ID_TARGET = _IMG_LIVE.data('target');
    _EXT = _IMG_LIVE.data('ext').toLowerCase();
    $("input[name="+_ID_TARGET+"]").click();
});
$(document).on('change','.file-live',function() {
    var file = $(this);
    var files_obj = file[0].files;
    var file_size = files_obj[0].size;
    var file_extention = (files_obj[0].name).split(".");
    var canExtention = (_EXT).split(","); //png,jpeg -> this format data-ext in html image-live
    // console.log(extention.at(-1));

    _IMG_LIVE.siblings('.text-danger').remove();
    if(inExt(file_extention.at(-1),canExtention)){
        if (file_size > 1024000) {
            _IMG_LIVE.after('<div class="text-danger"><i>File Tidak Boleh Lebih besar dari 1Mb ya</i></div>');
            _IMG_LIVE = null;
            return;
        }
        readURL(this);
    }else{
         _IMG_LIVE.after('<div class="text-danger"><i>Format Image Wajib '+_EXT+'</i></div>');
        _IMG_LIVE = null;
    }
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            console.log(_ID_TARGET);
            $("#"+_ID_TARGET).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        _IMG_LIVE = null;
    }
}
function inExt(value, array) {
    for(var i = 0; i < array.length; i++) {
        if(array[i] == value) return true;
    }
    return false;
}