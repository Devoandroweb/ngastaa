@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Import Data Pegawai</h2>
    {{ Breadcrumbs::render('import-pegawai') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {!!session('messages')!!}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@error('file')
<div class="alert alert-inv alert-inv-danger alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ $errors->first('file') }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@enderror
<form class="form" action="{{route('pegawai.pegawai.import_pegawai')}}" method="post" enctype="multipart/form-data">
    @csrf
    @if (role('admin') || role('owner'))
    <div class="row">
        <div class="col-md">
            <label class="form-label">Pilih Divisi Kerja</label>
            <div class="form-group has-validation">
                <select class="form-control jabatanDivisi" id=""  name="kode_skpd" required disabled>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <label class="form-label">Jabatan</label>
            <div class="form-group">
                <select class="form-control jabatanTingkat" id="" name="kode_tingkat" required disabled>

                </select>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="form-group has-validation">
            <div class="row">
                <div class="col">
                    <label class="form-label">Import File disini<span class="text-danger">*</span></label>
                </div>
                <div class="col text-md-end">
                    <a href="{{route('donwload_template_import')}}">{!!icons('download')!!} Unduh Template Excel</a>
                </div>
            </div>
            <input class="form-control mb-3 @error('file') is-invalid @enderror" name="file" type="file" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-save">{{__('Simpan')}}</button>
    <a href="{{route('pegawai.pegawai.index')}}" class="btn btn-light">{{__('Kembali')}}</a>
</form>
@endsection
@push('js')
<script>
    initDatePickerSingle();
    $("select").select2();

    var _DIVISI = "None Divisi";
    @if(role('owner') || role('admin'))
        $(".btn-save").prop('disable',true)
        $(".btn-save").addClass('disabled')
        initDevisi("{{old('kode_skpd')}}","{{old('kode_tingkat')}}");
        // initDevisi(data.kode_skpd,data.kode_tingkat);
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
                        _DIVISI = data[$(this).prop('selectedIndex')].text;
                        $(".btn-save").prop('disable',false)
                        $(".btn-save").removeClass('disabled')
                        console.log(_DIVISI);
                    }).trigger("change")
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
        $(".btn-save").click(function (e) {
            e.preventDefault();
            Swal.fire({
              text: 'Data ini akan di simpan sebagai divisi '+_DIVISI,
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, Saya yakin',
              cancelButtonText: 'Tidak',
            }).then((result) => {
              if (result.value) {
                $(".form").submit()
              }
            })
        });
    @endif
</script>
@endpush


