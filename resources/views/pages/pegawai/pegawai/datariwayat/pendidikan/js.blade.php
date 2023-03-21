<script type="text/javascript">
/* JABATAN */
function iniPendidikan(value_pendidikan = null,value_jurusan = null){
    let getPendidikan = (url) => { 
        var element = $('.tingkatPendidikan');
        let loading = loadingProccesText(element)
        $.ajax({url: url, success: function(data){
            element.empty()
            clearInterval(loading)
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['kode_pendidikan'],
                }
            })
            
            if(value_pendidikan == null && data.length != 0){
                value_pendidikan = data[0].id;
            }
          
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Pendidikan atau ketik disini",
                data : data
            }).val(value_pendidikan).change(function(){
                getJurusan("{{url('master/jurusan/json')}}/"+$(this).val(),value_jurusan);
            }).trigger("change");

        }});
    }
    getPendidikan("{{route('master.pendidikan.json')}}")
}
let getJurusan = (url,value_jurusan = null) => {
    let element = $('.jurusan');
    element.prop('disabled', true)
    let loading = loadingProccesText(element)
    $.ajax({url: url, success: function(data){
        element.empty()
        clearInterval(loading)
        initJurusan(data,value_jurusan,element)
    }})
}
function initJurusan(data, value_jurusan,element = null){
    var data = $.map(data, function (item) {
        return {
            text: item['label'],
            id: item['kode_jurusan'],
        }
    })
    
    if(value_jurusan == null && data.length != 0){
        value_jurusan = data[0].id;
    }
    element.removeAttr("disabled")
    element.select2({
        placeholder:"Pilih Jurusan atau ketik disini",
        data : data
    }).val(value_jurusan).trigger("change");
}
/* END JABATAN */
</script>