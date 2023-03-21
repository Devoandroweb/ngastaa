<script type="text/javascript">
    function initKursus(value = null){
    let getKursus = (url) => { 
        let element = $('.namaKursus'); 
        let loading = loadingProccesText(element)
        $.ajax({url: url, success: function(data){
            element.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_kursus'],
                }
            })
            
            if(value == null && data.length != 0){
                value = data[0].id;
            }
         
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Kursus atau ketik disini",
                data : data
            }).val(value).trigger("change");

        }});
    }
    getKursus("{{route('master.kursus.json')}}")
}
</script>