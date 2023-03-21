@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tingkat Pendidikan</h2>
    {{ Breadcrumbs::render('tambah-tingkat-pendidikan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.pendidikan.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Pendidikan</label>
                <input class="form-control mb-3 @error('kode_pendidikan') is-invalid @enderror"  placeholder="Masukkan Kode Pendidikan" name="kode_pendidikan">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_pendidikan') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>
</form>
@endsection
