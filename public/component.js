
function initDatePickerSingle(){
    // console.log($('.datepicker-single').val())
    $('.datepicker-single').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoApply:true,
            minYear: 1970,
            maxYear: new Date().getFullYear() + 15,
            // startDate: $(this).val(),
            locale: {
                format: 'DD/MM/YYYY'
            }
    });
}
console.log(new Date().getFullYear());

function initTimePicker(){
    $('.input-single-timepicker').daterangepicker({
        timePicker: true,
        singletDatePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        locale: {
            format: 'hh:mm'
        }
    }).on('show.daterangepicker', function (ev, picker) {
        picker.container.find(".calendar-table").hide();
    });
}
function initShift(el,kodeSkpd = null,forModal = null,value = null){
    let getShift = (url) => {
        let loading = loadingProccesText(el)
        $.ajax({url: url, success: function(data){
            el.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_shift'],
                }
            })
            if(value == null && data.length != 0){
                value = data[0].id;
            }
            console.log(kodeSkpd,value)
            el.removeAttr("disabled")
            el.select2({
                placeholder:"Pilih shift atau ketik disini",
                data : data,
                dropdownParent:forModal,
                allowClear: true
            }).val(value).trigger("change");
        }});
    }
    getShift(_URL_MAIN+"/master/shift/json?kode_skpd="+kodeSkpd)
}

