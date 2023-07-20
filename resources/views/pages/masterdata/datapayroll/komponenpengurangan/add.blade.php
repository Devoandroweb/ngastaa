@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Potongan</h2>
    {{ Breadcrumbs::render('tambah-pengurangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.pengurangan.store')}}" method="post">

    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Kode</label>
            <input class="form-control @error('kode_kurang') is-invalid @enderror" placeholder="Masukkan Kode" name="kode_kurang">
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
        </div>
    </div>
    {{-- <div class="element-presentase"></div> --}}
    <div class="row">
        <div class="form-group">
            <label class="form-label">{{__('Nilai')}}</label>
            <input class="form-control numeric"  placeholder="Masukkan Nilai" name="nilai">
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.payroll.pengurangan.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
<script>

    // var selectPersentase = '';
    // $("#satuan").change(function (e) {
    //     e.preventDefault();
    //     buildPresentaseParent($(this).val())
    // });
    // function buildPresentaseParent(val){
    //     var placeholder = '';
    //     var idEl = null;
    //     selectPersentase = "{!!includeAsJsString('pages.masterdata.datapayroll.komponenpengurangan.select-sumber-pengurangan-dari')!!}";

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
