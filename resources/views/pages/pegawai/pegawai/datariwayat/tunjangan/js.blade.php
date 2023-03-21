<script type="text/javascript">
    function initTunjangan(value = null){
    let getTunjangan = (url) => { 
        let element = $('.jenisTunjangan'); 
        let loading = loadingProccesText(element)
        $.ajax({url: url, success: function(data){
            element.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_tunjangan'],
                }
            })
            
            if(value == null && data.length != 0){
                value = data[0].id;
            }
         
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Tunjangan atau ketik disini",
                data : data
            }).val(value).trigger("change");

        }});
    }
    getTunjangan("{{route('master.payroll.tunjangan.json')}}")
}
</script>