@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Komponen Bonus Payroll</h2>
    {{ Breadcrumbs::render('tambah-penambahan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.penambahan.store')}}" method="post">

    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Kode</label>
            <input class="form-control @error('kode_tambah') is-invalid @enderror" placeholder="Masukkan Kode" name="kode_tambah">
            <div class="invalid-feedback">
                {{ $errors->first('kode_tambah') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">Nama Komponen</label>
            <input class="form-control"  placeholder="Masukkan Nama Komponen" name="nama">
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">Satuan</label>
            <select class="form-control select2" name="satuan" id="satuan" required>
                <option selected disabled>Select Satuan</option>
                <option value="1">Rupiah</option>
                <option value="2">Persen</option>
            </select>
            <p class="text-danger"><b>Persen</b> akan di hitung dari presentase <b>Gaji Pokok</b></p>
        </div>
    </div>
    {{-- <div class="element-presentase"></div> --}}
    <div class="row">
        <div class="form-group">
            <label class="form-label">{{__('Nilai')}}</label>
            <input class="form-control"  placeholder="Masukkan Nilai" name="nilai">
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.payroll.penambahan.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
<script>
    setNumeric()
    $("#satuan").change(function (e) {

        e.preventDefault();
        var satuan = $(this).val();
        if(satuan == 2){
            $("[name=nilai]").attr('min','0');
            $("[name=nilai]").attr('max','100');
        }else{
            $("[name=nilai]").removeAttr('min');
            $("[name=nilai]").removeAttr('max');
        }
    });
    $("[name=nilai]").change(function (e) {
        e.preventDefault();
        if($("#satuan").val() == 2){
            if(clearNumeric($(this).val()) > 100){
                $(this).val(100);
            }
        }
    });
    // var selectPersentase = '';
    // $("#satuan").change(function (e) {
    //     e.preventDefault();
    //     buildPresentaseParent($(this).val())
    // });
    // function buildPresentaseParent(val){
    //     var placeholder = '';
    //     var idEl = null;
    //     selectPersentase = "{!!includeAsJsString('pages.masterdata.datapayroll.komponenpenambahan.select-sumber-penambahan-dari')!!}";

    //     if(val == 2){
    //         $(".element-presentase").html(selectPersentase);
    //         idEl = "#input_tags_presentase";
    //         placeholder = "Pilih Presentase";
    //         // $(idEl).select2("destroy")
    //         $(idEl).select2({
    //             tags: true,
    //             tokenSeparators: [',', ' '],
    //             placeholder: placeholder,
    //             allowClear: true
    //         });
    //     }else{
    //         $(".element-presentase").empty();;
    //     }
    //     // enableButtonSave();

    // }
</script>

@endpush
