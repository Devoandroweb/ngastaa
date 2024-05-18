"use strict"
function alertSizeFile() {
    var file = $(".alertFile").attr('value', value);
    var alertFile = alert(".alertFile".files[0].size);
    if (file != alertFile) {
        file.addClass()
        // '<div class="invalid-feedback"> You must agree before submitting. </div>'
    } else {
        return false;
    }
}

function disableButtonSave(){
    $(".btn-save").addClass('disabled');
    $(".btn-save").attr('disabled','disabled');
}
function enableButtonSave(){
    $(".btn-save").removeClass('disabled');
    $(".btn-save").removeAttr('disabled');
}
function setNumeric(){
    $(".numeric").autoNumeric('init',{aPad:false, aDec: ',', aSep: '.'});
    console.log("set numeric success");
}
function clearNumeric(value){
    return value.split(".").join("")
}
function toRupiah(el,value){
    el.autoNumeric('init',{aPad:false, aDec: ',', aSep: '.'});
    el.autoNumeric('set',value);
}
function redirect(url){
    window.location.href = url;
}
function loadingProccesText(el){
    let text = "Tunggu sebentar ."
    let i = 0;

    el.html(`<option value="0" disabled selected>${text}</option>`)

    let loading = setInterval(() => {
        if(i >= 3){
            text = "Tunggu sebentar ."
            i = 0
        }else{
            text += " ."
            i++
        }

        el.html(`<option value="0" disabled selected>${text}</option>`)
    }, 1000);
    return loading;
}
function getDatesRange(startDate, stopDate) {
    var dateArray = [];
    var currentDate = moment(startDate);
    var stopDate = moment(stopDate);
    while (currentDate <= stopDate) {
        dateArray.push(moment(currentDate).format("YYYY-MM-DD"));
        currentDate = moment(currentDate).add(1, "days");
    }
    return dateArray;
}
function convertMonthToIndo(bulan) {
    switch (bulan) {
        case 0:
            return (bulan = "Januari");
            break;
        case 1:
            return (bulan = "Februari");
            break;
        case 2:
            return (bulan = "Maret");
            break;
        case 3:
            return (bulan = "April");
            break;
        case 4:
            return (bulan = "Mei");
            break;
        case 5:
            return (bulan = "Juni");
            break;
        case 6:
            return (bulan = "Juli");
            break;
        case 7:
            return (bulan = "Agustus");
            break;
        case 8:
            return (bulan = "September");
            break;
        case 9:
            return (bulan = "Oktober");
            break;
        case 10:
            return (bulan = "November");
            break;
        case 11:
            bulan = "Desember";
            break;
    }
}
function formatRupiah(nominal) {
    let rupiah = "";
    const nominalString = nominal.toString();

    for (let i = nominalString.length - 1; i >= 0; i--) {
        rupiah = nominalString[i] + rupiah;
        if ((nominalString.length - i) % 3 === 0 && i !== 0) {
            rupiah = "." + rupiah;
        }
    }

    return rupiah;
}

$(document).on('change','.upload-image',function() {
    var _EXT = $(this).data('ext').toLowerCase();
    var _ID_TARGET = $(this).data('target')
    var file = $(this);
    var files_obj = file[0].files;
    var file_size = files_obj[0].size;
    var file_extention = (files_obj[0].name).split(".");
    var canExtention = (_EXT).split(","); //png,jpeg -> this format data-ext in html image-live
    // console.log(extention.at(-1));
    var _IMG_LIVE = $("#show-image")
    _IMG_LIVE.siblings('.text-danger').remove();
    if(inExt(file_extention.at(-1),canExtention)){
        if (file_size > 1024000) {
            _IMG_LIVE.after('<div class="text-danger"><i>File Tidak Boleh Lebih besar dari 1Mb ya</i></div>');
            return;
        }
        readURL(this,_ID_TARGET);
    }else{
         _IMG_LIVE.after('<div class="text-danger"><i>Format Image Wajib '+_EXT+'</i></div>');
    }
});
function readURL(input,_ID_TARGET) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            console.log(_ID_TARGET);
            $("#"+_ID_TARGET).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function inExt(value, array) {
    for(var i = 0; i < array.length; i++) {
        if(array[i] == value) return true;
    }
    return false;
}
function removeInObject(arrayObject,key,key_value){
    //Find index of specific object using findIndex method.
    var objIndex = arrayObject.findIndex((obj => obj[key] == key_value));
    if(objIndex != -1){
        arrayObject.splice(objIndex,1);
        return true;
    }
    return false;
}
function inObject(value, arrayOject, key) {
    for(var i = 0; i < arrayOject.length; i++) {
        if(arrayOject[i][key] == value) return true;
    }
    return false;
}
function buildLoading(){
    return `<div class="loadingio-spinner-ellipsis-ul1uzlc5yan"><div class="ldio-cvh2xv40fr">
    <div></div><div></div><div></div><div></div><div></div>
    </div></div>
    <p>Tunggu sebentar, sedang memuat halaman ....`;
}
