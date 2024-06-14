
    <div class="col">
        <label class="form-label">Pilih Divisi Kerja</label>
        <div class="form-group has-validation">
            <select class="form-control select-tingkat" id="" name="kode_skpd" required disabled>

            </select>
        </div>
    </div>
    <div class="col">
        <label class="form-label">Jabatan</label>
        <div class="form-group">
            <select class="form-control select-tingkat" id="" name="kode_tingkat" required disabled>
            </select>
        </div>
    </div>

@push('js')
<script>
    // initDevisi("{{old('kode_skpd')}}","{{old('kode_tingkat')}}");
    initDevisi();
    /* JABATAN */
    function initDevisi(value_divisi = null,value_tingkat = null){

        let getDivisi = (url) => {
            var element = $('.select-tingkat');
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

                // if(value_divisi == null && data.length != 0){
                //     value_divisi = data[0].id;
                // }

                element.removeAttr("disabled")
                element.select2({
                    placeholder:"Pilih Divisi atau ketik disini",
                    allowClear: true,
                    data : data
                }).val("").change()

                element.change(function(){
                    getTingkat("{{url('master/tingkat/json')}}/"+$(this).val(),value_tingkat);
                    _DIVISI = data[$(this).prop('selectedIndex')].text;
                    $(".btn-save").prop('disable',false)
                    $(".btn-save").removeClass('disabled')
                })
            }});
        }
        getDivisi("{{route('master.skpd.json')}}")
    }
    let getTingkat = (url,value_tingkat = null) => {
        let element = $('.select-tingkat');
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
        }).val("").change()
        // .val(value_tingkat).trigger("change");
    }

</script>
@endpush
