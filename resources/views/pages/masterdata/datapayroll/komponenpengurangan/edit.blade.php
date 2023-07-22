@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Potongan</h2>
    {{ Breadcrumbs::render('edit-pengurangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.pengurangan.store')}}" method="post">
    <input type="hidden" name="id" value="{{$pengurangan->id}}">
    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Kode</label>
            <input class="form-control @error('kode_kurang') is-invalid @enderror" value="{{$pengurangan->kode_kurang}}" placeholder="Masukkan Kode" name="kode_kurang">
            <div class="invalid-feedback">
                {{ $errors->first('kode_kurang') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">Nama Komponen</label>
            <input class="form-control @error('nama') is-invalid @enderror"  placeholder="Masukkan Nama Komponen" value="{{$pengurangan->nama}}" name="nama">
            <div class="invalid-feedback">
                {{ $errors->first('nama') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">Satuan</label>
            <select class="form-control select2" name="satuan" id="satuan" required>
                <option selected disabled>Select Satuan</option>
                @if($pengurangan->satuan == 1)
                    <option value="1" selected>Rupiah</option>
                    <option value="2">Persen</option>
                @else
                    <option value="1">Rupiah</option>
                    <option value="2" selected>Persen</option>
                @endif
            </select>
        </div>
    </div>
    {{-- <div class="element-presentase"></div> --}}
    <div class="row">
        <div class="form-group">
            <label class="form-label">{{__('Nilai')}}</label>
            <input class="form-control numeric @error('nilai') is-invalid @enderror"  placeholder="Masukkan Nilai" value="{{$pengurangan->nilai}}" name="nilai">
             <div class="invalid-feedback">
                {{ $errors->first('nilai') }}
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.payroll.pengurangan.index')}}" class="btn btn-light">Kembali</a>

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

    // buildPresentaseParent('{{$pengurangan->satuan}}')
    // $("#satuan").change(function (e) {
    //     e.preventDefault();
    //     buildPresentaseParent($(this).val())
    // });
    // var selectPersentase = '';
    // function buildPresentaseParent(val){
    //     var placeholder = '';
    //     var idEl = null;

    //     @if($pengurangan->satuan == 2)
    //         selectPersentase = "{!!includeAsJsString('pages.masterdata.datapayroll.komponenpenambahan.select-sumber-penambahan-dari-edit',$tunjangan)!!}";
    //     @else
    //         selectPersentase = "{!!includeAsJsString('pages.masterdata.datapayroll.komponenpenambahan.select-sumber-penambahan-dari')!!}";
    //     @endif

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
