@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Potongan Telat dan Cepat Pulang</h2>
    {{ Breadcrumbs::render('edit-absensi') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.absensi.update')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$absensi->id}}">
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">{{__('Menit Ke')}}</label>
            <input class="form-control @error('menit') is-invalid @enderror"  placeholder="Masukkan Menit Ke" value="{{$absensi->menit}}" name="menit">
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $errors->first('menit') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <label class="form-label">{{__('Pengali (Persen)')}}</label>
            <input class="form-control @error('pengali') is-invalid @enderror"  placeholder="Masukkan Pengali" value="{{$absensi->pengali}}" name="pengali">
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $errors->first('pengali') }}
            </div>
        </div>
    </div>
    @include('pages.masterdata.datapayroll.potongantelat.select-sumber-potongan');

    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light mt-3">Kembali</button>
    
</form>
@endsection
@push("js")
<script>
$("#input_tags_kode_tunjangan").select2({
    tags: true,
    tokenSeparators: [',', ' '],
    allowClear: true
});
    

</script>

@endpush