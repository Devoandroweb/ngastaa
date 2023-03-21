<script type="text/javascript">
/* Penghargaan */
function initPenghargaan(value){
        let getPenghargaan = (url) => { 
            let loading = loadingProccesText($('.Penghargaan'))
            $.ajax({url: url, success: function(data){
                
                $('.Penghargaan').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode_penghargaan'],
                    }
                })
                
                if(value == null && data.length != 0){
                    value = data[0].id;
                }
                console.log(data);
                console.log("value Penghargaan "+value);
                $('.Penghargaan').removeAttr("disabled")
                $('.Penghargaan').select2({
                    placeholder:"Pilih Penghargaan atau ketik disini",
                    data : data
                }).val(value).trigger("change");
            }});
        }
        getPenghargaan("{{route('master.penghargaan.json')}}")
    }
/* END JABATAN */
</script>