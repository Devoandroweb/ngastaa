@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Laporan Divisi</h2>
    {{ Breadcrumbs::render('laporan-divisi') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="form-laporan" action="{{route('pengajuan.presensi.laporan_divisi_download')}}" method="get">
    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Divisi Kerja</label>
            <select class="form-control select2 @error('divisi') is-invalid @enderror" name="divisi" id="divisi" required>
                <option selected disabled>Select Divisi Kerja</option>
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('divisi') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Bulan</label>
            <select class="form-control select2 @error('bulan') is-invalid @enderror" name="bulan" id="bulan" required disabled>
                {!!GenerateOptionMont()!!}
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('bulan') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Tahun</label>
            <select class="form-control select2 @error('tahun') is-invalid @enderror" name="tahun" id="tahun" required>
                <option selected disabled>Select Tahun</option>
                {!!GenerateOptionYear()!!}
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('tahun') }}
            </div>
        </div>
    </div>
    {{-- <a href="" type="button" class="me-2 approv btn btn-danger" id="pdf">Download PDF</a>
    <a href="" type="button" class="me-2 reject btn btn-success" id="excel" >Download Excel</a> --}}
    <input type="hidden" name="xl" value="false">
    <button class="btn  btn-custom btn-submit btn-danger icon-wthot-bg approv" id="pdf" disabled><span><span class="icon"><i class="far fa-file-pdf"></i> </span><span>Download PDF</span></span></button>
    <button class="btn  btn-custom btn-submit btn-success icon-wthot-bg reject" id="excel" disabled><span><span class="icon"><i class="far fa-file-excel"></i> </span><span>Download Excel</span></span></button>
</form>
@endsection

@push('js')
<script>
initDevisi();
function initDevisi(){
    let getDivisi = (url) => { 
        var element = $('#divisi');
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
            // cekBulan()
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Divisi atau ketik disini",
                data : data
            }).val("").change(function(){
                if($(this).val() != null){
                    $('#bulan').removeAttr("disabled")
                }
                cekBulan()
            }).trigger("change");

        }});
    }
    getDivisi("{{route('master.skpd.json')}}")
}
function cekBulan(){
    console.log($('#bulan').val())
    console.log($('#divisi').val())
    if($('#bulan').val() == null || $('#divisi').val() == null){
        $(".btn-submit").prop("disabled",true);
    }else{
        $(".btn-submit").prop("disabled",false);
    }
}
// ========================================
// =============================
$(".btn-submit").on("click", function (e) {
    if($(this).attr("id") == "pdf"){
        $("[name=xl]").val(true);
        $(".form-laporan").attr("action","{{route('pengajuan.presensi.laporan_pegawai_download')}}").submit();
    }
    if($(this).attr("id") == "excel"){
        $(".form-laporan").attr("action","{{route('pengajuan.presensi.laporan_pegawai_download')}}").submit();
    }
});
</script>
    
@endpush
