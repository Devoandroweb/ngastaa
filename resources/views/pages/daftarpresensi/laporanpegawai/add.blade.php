@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Laporan Presensi Pegawai</h2>
    {{ Breadcrumbs::render('laporan-pegawai') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="form-laporan mb-2" method="get">
    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Divisi Kerja</label>
            <select class="form-control @error('kode_divisi') is-invalid @enderror" name="kode_divisi" id="kode_divisi" required>
                <option selected disabled>Select Divisi Kerja</option>
                {{-- @foreach($skpd as $s)
                    <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Pegawai</label>
            <select class="form-control @error('pegawai') is-invalid @enderror disabled" name="pegawai" id="select_pegawai" required>
                <option selected disabled>Select Pegawai</option>
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('pegawai') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pilih Bulan</label>
            <select class="form-control select2 @error('bulan') is-invalid @enderror" name="bulan" id="bulan" required>
                {{-- <option selected disabled>Select Bulan</option> --}}
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
    <input type="hidden" name="xl" value="0">
    <button id="pdf" class="btn btn-custom btn-submit btn-danger icon-wthot-bg" disabled><span><span class="icon"><i class="far fa-file-pdf"></i> </span><span>Download PDF</span></span></button>
    <button id="excel" class="btn btn-custom btn-submit btn-success icon-wthot-bg" disabled><span><span class="icon"><i class="far fa-file-excel"></i> </span><span>Download Excel</span></span></button>
    <button id="show" class="btn btn-custom btn-show btn-info icon-wthot-bg" disabled><span><span class="icon"><i class="far fa-eye"></i> </span><span>Tampilkan</span></span></button>
    {{-- <button class="btn  btn-custom me-2 btn-danger icon-wthot-bg approv"><span><i class="far fa-file-pdf"></i><span> Download PDF</span></span></button>
    <button class="btn  btn-custom  btn-success icon-wthot-bg reject"><span><i class="far fa-file-excel"></i><span> Download Excel</span></span></button> --}}
    {{-- <embed src="{{public_path('document-laporan-presensi-pegawai.pdf')}}" type="application/pdf" width="300px" height="500px"></embed> --}}
</form>
<div id="iframe-pdf" class="text-center mb-2"></div>
@endsection

@push('js')
<script>
initDevisi();
function initDevisi(){
    let getDivisi = (url) => {
        var element = $('#kode_divisi');
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

            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Divisi atau ketik disini",
                data : data
            }).val(null).change(function(){
                getPegawai("{{route('pegawai.pegawai.json_skpd')}}",$(this).val());
                if($(this).val() != null){
                    $('#select_pegawai').removeAttr("disabled")
                }
                cekPegawai()
            }).trigger("change");

        }});
    }
    getDivisi("{{route('master.skpd.json')}}")
}
let getPegawai = (url,value_skpd) => {
    let element = $('#select_pegawai');
    element.prop('disabled', true)
    let loading = loadingProccesText(element)
    $.ajax({url: url+"?skpd="+value_skpd, success: function(data){
        element.empty()
        clearInterval(loading)
        initSelectPegawai(data,value_skpd,element)
    }})
}
function initSelectPegawai(data,value_skpd,element = null){
    var data = $.map(data, function (item) {
        return {
            text: item['label'],
            id: item['value'],
        }
    })
    if(value_skpd == null && data.length != 0){
        value_skpd = data[0].id;
    }
    // element.removeAttr("disabled")
    element.select2({
        placeholder:"Pilih Pegawai atau ketik disini",
        data : data
    }).val("").change(function(){
        cekPegawai()
    }).trigger("change");
}
$(".btn-submit").on("click", function (e) {
    e.preventDefault();
    if($(this).attr("id") == "pdf"){
        $("[name=xl]").val(0);
        $(".form-laporan").attr("action","{{route('pengajuan.presensi.laporan_pegawai_download')}}").submit();
    }
    if($(this).attr("id") == "excel"){
        $("[name=xl]").val(1);
        $(".form-laporan").attr("action","{{route('pengajuan.presensi.laporan_pegawai_download')}}?xl=true").submit();
    }
    $(".form").submit();
});
$("#show").on("click", function (e) {
    e.preventDefault()
    getPresensiPegawai()
});
// =============================
function cekPegawai(){
    if($('#select_pegawai').val() == null || $('#select_pegawai').val() == ""){
        $(".btn-submit").prop("disabled",true);
        $(".btn-show").prop("disabled",true);
    }else{
        $(".btn-submit").prop("disabled",false);
        $(".btn-show").prop("disabled",false);
    }
}
function getPresensiPegawai(){
    $("#iframe-pdf").html(buildLoading())
    $.ajax({
        type: "get",
        url: "{{route('pengajuan.presensi.generate_laporan_pegawai')}}",
        dataType: "JSON",
        data: $(".form-laporan").serialize(),
        success: function (response) {
            if(response.status){
                $("#iframe-pdf").html(`<embed class="iframe-pdf" src="{{route('pengajuan.presensi.show_pdf')}}?path=${response.file}" type="application/pdf" width="100%" height="800" frameborder="0"></embed>`)
            }else{
                Swal.fire(
                  'Gagal',
                  response.messages,
                  'error'
                )
            }
        }
    });
}

// /pengajuan/presensi/laporan-pegawai-download?nip=${data.nip}&bulan=${data.bulan}&tahun=${data.tahun}`, '_blank', 'noopener,noreferrer
</script>

@endpush
@include("pages.daftarpresensi.laporanpegawai.js")
