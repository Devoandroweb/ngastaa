<script type="text/javascript">
    function initJenisPotongan(value = null){
    let getPotongan = (url) => { 
        let element = $('.jenisPotongan'); 
        let loading = loadingProccesText(element)
        $.ajax({url: url, success: function(data){
            element.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_kurang'],
                }
            })
            
            if(value == null && data.length != 0){
                value = data[0].id;
            }
         
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Potongan atau ketik disini",
                data : data
            }).val(value).trigger("change");

        }});
    }
    getPotongan("{{route('master.payroll.pengurangan.json')}}")
}
</script>