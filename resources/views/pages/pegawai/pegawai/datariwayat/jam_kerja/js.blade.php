<script type="text/javascript">
/* shift */
function initJamKerja(value = null){
        console.log("value jam_kerja 1"+value);
        let getJamKerja = (url) => {
            let loading = loadingProccesText($('.jamKerja'))
            $.ajax({url: url, success: function(data){
                $('.jamKerja').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode'],
                    }
                })

                if(value == null && data.length != 0){
                    value = data[0].id;
                }
                console.log(data);
                console.log("value jam_kerja "+value);
                $('.jamKerja').removeAttr("disabled")
                $('.jamKerja').select2({
                    placeholder:"Pilih Jam Kerja atau ketik disini",
                    data : data
                }).val(value).trigger("change");
            }});
        }
        getJamKerja("{{route('master.jam_kerja.json')}}")
    }
</script>
