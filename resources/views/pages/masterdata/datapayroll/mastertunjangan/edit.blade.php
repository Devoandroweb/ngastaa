@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tunjangan</h2>
    {{ Breadcrumbs::render('edit-tunjangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.tunjangan.store')}}" method="post">
    <input type="hidden" name="id" value="{{$tunjangan->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode</label>
                <input class="form-control @error('kode_tunjangan') is-invalid @enderror"  placeholder="Masukkan Kode Tunjangan" value="{{$tunjangan->kode_tunjangan}}" name="kode_tunjangan">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$tunjangan->nama}}" name="nama">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">Satuan</label>
            <select class="form-control select2" name="satuan" id="satuan" required>
                @if($tunjangan->satuan == 0)
                    <option value="0" selected>Rupiah</option>
                    <option value="1">Persen</option>
                @else
                    <option value="0">Rupiah</option>
                    <option value="1" selected>Persen</option>
                @endif
            </select>
            <p class="text-danger"><b>Persen</b> akan di hitung dari presentase <b>Gaji Pokok</b></p>
        </div>
    </div>
    <div class="element-presentase"></div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">{{__('Nilai')}}</label>
            <input class="form-control numeric"  placeholder="Masukkan Nilai" value="{{$tunjangan->nilai}}" name="nilai">
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <a href="{{route('master.payroll.tunjangan.index')}}" class="btn btn-light">Kembali</a>

</form>
@push('js')
<script>
    setNumeric()
    $("#satuan").change(function (e) {

        e.preventDefault();
        var satuan = $(this).val();
        if(satuan == 1){
            $("[name=nilai]").attr('min','0');
            $("[name=nilai]").attr('max','100');
        }else{
            $("[name=nilai]").removeAttr('min');
            $("[name=nilai]").removeAttr('max');
        }
    });
    $("[name=nilai]").change(function (e) {
        e.preventDefault();
        if($("#satuan").val() == 1){
            if(clearNumeric($(this).val()) > 100){
                $(this).val(100);
            }
        }
    });
</script>
@endpush
@endsection
