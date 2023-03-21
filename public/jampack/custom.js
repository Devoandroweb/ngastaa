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