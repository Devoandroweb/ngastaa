@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Status Pegawai</h2>
    {{ Breadcrumbs::render('edit-status-pegawai') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.status_pegawai.store')}}" method="post">
    <input type="hidden" name="id" value="{{$status_pegawai->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Status</label>
                <input class="form-control @error('kode_status') is-invalid @enderror"  placeholder="Masukkan Kode Status" value="{{$status_pegawai->kode_status}}" name="kode_status">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_status') }}
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama Status" value="{{$status_pegawai->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.status_pegawai.index')}}" class="btn btn-light">Kembali</a>
</form>
@endsection
