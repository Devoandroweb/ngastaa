<script type="text/javascript">
    /* JABATAN */
    function initLainnya(value){
            let getLainnya = (url) => { 
                let loading = loadingProccesText($('.Lainnya'))
                $.ajax({url: url, success: function(data){
                    $('.Lainnya').empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: item['label'],
                            id: item['kode_lainnya'],
                        }
                    })
                    
                    if(value == null && data.length != 0){
                        value = data[0].id;
                    }
                    console.log(data);
                    console.log("value lainnya "+value);
                    $('.Lainnya').removeAttr("disabled")
                    $('.Lainnya').select2({
                        placeholder:"Pilih lainnya atau ketik disini",
                        data : data
                    }).val(value).trigger("change");
                }});
            }
            getLainnya("{{route('master.lainnya.json')}}")
        }
    /* END JABATAN */
    </script>