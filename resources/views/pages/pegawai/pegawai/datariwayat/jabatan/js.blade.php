<script type="text/javascript">
/* JABATAN */
function initDevisi(value_divisi = null,value_tingkat = null){
    let getDivisi = (url) => { 
        var element = $('.jabatanDivisi');
        let loading = loadingProccesText(element)
        $.ajax({url: url, success: function(data){
            element.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_skpd'],
                }
            })
            
            if(value_divisi == null && data.length != 0){
                value_divisi = data[0].id;
            }
            
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Divisi atau ketik disini",
                data : data
            }).val(value_divisi).change(function(){
                getTingkat("{{url('master/tingkat/json')}}/"+$(this).val(),value_tingkat);
            }).trigger("change");

        }});
    }
    getDivisi("{{route('master.skpd.json')}}")
}
let getTingkat = (url,value_tingkat = null) => {
    let element = $('.jabatanTingkat');
    element.prop('disabled', true)
    let loading = loadingProccesText(element)
    $.ajax({url: url, success: function(data){
        element.empty()
        clearInterval(loading)
        initTingkat(data,value_tingkat,element)
    }})
}
function initTingkat(data, value_tingkat,element = null){
    var data = $.map(data, function (item) {
        return {
            text: item['label'],
            id: item['value'],
        }
    })
    
    if(value_tingkat == null && data.length != 0){
        value_tingkat = data[0].id;
    }
    element.removeAttr("disabled")
    element.select2({
        placeholder:"Pilih Jabatan atau ketik disini",
        data : data
    }).val(value_tingkat).trigger("change");
}
/* END JABATAN */
</script>