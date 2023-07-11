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
<form class="edit-post-form" action="{{route('pegawai.pegawai.import_pegawai')}}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- <div class="row">
        <div class="col-md">
            <label class="form-label">Divisi Kerja</label>
            <div class="form-group has-validation">
                <select class="form-control jabatanDivisi" id=""  name="kode_skpd" required disabled>
                </select>
            </div>
        </div>
    </div> --}}
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
    <button type="submit" class="btn btn-primary">{{__('Simpan')}}</button>
    <a href="{{route('pegawai.pegawai.index')}}" class="btn btn-light">{{__('Kembali')}}</a>
</form>
@endsection
@push('js')
<script>
    initDatePickerSingle();
    $("select").select2();
    @if(role('owner') || role('admin'))
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
                    })

                }});
            }
            getDivisi("{{route('master.skpd.json')}}")
        }
        /* END JABATAN */
    @endif
</script>
@endpush


