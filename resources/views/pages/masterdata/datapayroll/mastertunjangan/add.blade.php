@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tunjangan</h2>
    {{ Breadcrumbs::render('tambah-tunjangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.tunjangan.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Tunjangan</label>
                <input class="form-control mb-3 @error('kode_tunjangan') is-invalid @enderror"  placeholder="Masukkan Kode Tunjangan" name="kode_tunjangan">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_tunjangan') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama Tunjangan" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>
</form>
@endsection
