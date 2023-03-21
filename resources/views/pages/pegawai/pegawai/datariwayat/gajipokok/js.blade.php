<script type="text/javascript">
/* JABATAN */
var _SELECT_UMK = `<div class="row">
        <div class="col-md-4">
            <label class="form-label">Gaji UMK</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <input name="gaji_pokok" id="gaji_umk_value" type="hidden">
                <select class="form-control selectGajiUMK" name="kode_umk" required>
                </select>
            </div>
        </div>
    </div>`;
var _GAJI_BARU = `<div class="row">
        <div class="col-md-4">
            <label class="form-label">Gaji Pokok Baru</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control numeric mb-3" placeholder="Masukkan Gaji Pokok Terbaru" name="gaji_pokok" type="text">
            </div>
        </div>
    </div>`

$(document).on("change","[name=tipe_gaji]",function (e) { 
    e.preventDefault();
    console.log($(this).val())
    if($(this).val() == 1){
        $("#gaji").html(_SELECT_UMK);
        initGajiUMK()
    }else{
        $("#gaji").html(_GAJI_BARU);
    }
});
function initGaji(data = null){
    if($("[name=tipe_gaji]").val() == 1){
        if(data != null){
            initGajiUMK(data.kode_umk);
        }else{
            initGajiUMK()
        }
    }else{
        $("#gaji").html(_GAJI_BARU);
        console.log("data edit")
        console.log(data)
        if(data != null){
            $('[name="gaji_pokok"]').val(data.gaji_pokok)
        }else{
            $('[name="gaji_pokok"]').val()
        }
        setNumeric()
    }
}
function initGajiUMK(kode_umk = null){
        let getGajiUMK = (url) => { 
            let loading = loadingProccesText($('.selectGajiUMK'))
            $.ajax({url: url, success: function(data){

                $('.selectGajiUMK').empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['nama_umk'] +" - "+ formatRupiah(item['nominal']),
                        id: item['kode_umk'],
                        nominal: item['nominal'],
                    }
                })
                
                if(kode_umk == null && data.length != 0){
                    kode_umk = data[0].id;
                    $("#gaji_umk_value").val(data[0].nominal)
                }
                console.log(data);
                console.log("value umk "+kode_umk);
                $('.selectGajiUMK').removeAttr("disabled")
                $('.selectGajiUMK').select2({
                    placeholder:"Pilih Gaji UMK atau ketik disini",
                    data : data
                }).val(kode_umk).on('select2:select', function (e) {
                    var data = e.params.data;
                    $("#gaji_umk_value").val(data.nominal)
                }).trigger("change");
            }});
        }
        getGajiUMK("{{route('master.payroll.umk.json')}}")
    }
    $('#mySelect2').on('select2:select', function (e) {
        var data = e.params.data;
        console.log(data);
    });
/* END JABATAN */
</script>