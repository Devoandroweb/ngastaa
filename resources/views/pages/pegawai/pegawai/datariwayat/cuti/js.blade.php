<script type="text/javascript">
/* CUTI */
function initCuti(value_cuti){
        let getCuti = (url) => { 
            let loading = loadingProccesText($('.namaCuti'))
            $.ajax({url: url, success: function(data){
                $('.namaCuti').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode_cuti'],
                    }
                })
                
                if(value_cuti == null && data.length != 0){
                    value_cuti = data[0].id;
                }
                console.log(data);
                console.log("value cuti "+value_cuti);
                $('.namaCuti').removeAttr("disabled")
                $('.namaCuti').select2({
                    placeholder:"Pilih Cuti atau ketik disini",
                    data : data
                }).val(value_cuti).trigger("change");
            }});
        }
        getCuti("{{route('master.cuti.json')}}")
    }
/* END JABATAN */
</script>