@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Status Pegawai</h2>
    {{ Breadcrumbs::render('tambah-status-pegawai') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.status_pegawai.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Status</label>
                <input class="form-control @error('kode_status') is-invalid @enderror"  placeholder="Masukkan Kode Status" name="kode_status">
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama Status" name="nama">
            </div>
        </div>
       
    </div>
    <button type="submit" class="btn btn-primary submit">Simpan</button>    
    <a href="{{route('master.status_pegawai.index')}}" class="btn btn-light">Kembali</a>


</form>
@endsection
