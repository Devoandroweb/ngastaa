<script type="text/javascript">
/* shift */

function initShift(value = null){
    let getShift = (url) => {
        let loading = loadingProccesText($('.Shift'))
        $.ajax({url: url, success: function(data){
            $('.Shift').empty()
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
            console.log(value)
            $('.Shift').removeAttr("disabled")
            $('.Shift').select2({
                placeholder:"Pilih shift atau ketik disini",
                data : data
            }).val(value).trigger("change");
        }});
    }
    getShift("{{route('master.shift.json')}}?kode_skpd="+$('[name=kode_skpd]').val())
}
</script>
