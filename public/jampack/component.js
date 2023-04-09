
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
        startDate: $(this).val(),
        locale: {
            format: 'hh:mm'
        }
    }).on('show.daterangepicker', function (ev, picker) {
        picker.container.find(".calendar-table").hide();
    });
}
