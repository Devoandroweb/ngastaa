@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Izin</h2>
    {{ Breadcrumbs::render('edit-cuti') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.cuti.store')}}" method="post">
    <input type="hidden" name="id" value="{{$cuti->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Cuti</label>
                <input class="form-control @error('kode_cuti') is-invalid @enderror"  placeholder="Masukkan Kode Cuti" value="{{$cuti->kode_cuti}}" name="kode_cuti">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_cuti') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$cuti->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
