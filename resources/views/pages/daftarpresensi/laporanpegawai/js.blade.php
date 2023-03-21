<script type="text/javascript">
/* JABATAN */
function initDivisi(value){
        let getDivisi = (url) => { 
            let loading = loadingProccesText($('.Divisi'))
            $.ajax({url: url, success: function(data){
                $('.Divisi').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode_skpd'],
                    }
                })
                
                if(value == null && data.length != 0){
                    value = data[0].id;
                }
                console.log(data);
                console.log("value Divisi "+value);
                $('.Divisi').removeAttr("disabled")
                $('.Divisi').select2({
                    placeholder:"Pilih Divisi atau ketik disini",
                    data : data
                }).val(value).trigger("change");
            }});
        }
        getDivisi("{{route('master.skpd.json')}}")
    }
/* END JABATAN */
</script>