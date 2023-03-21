@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Izin</h2>
    {{ Breadcrumbs::render('edit-cuti') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.cuti.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Cuti</label>
                <input class="form-control mb-3 @error('kode_cuti') is-invalid @enderror"  placeholder="Masukkan Kode Cuti" name="kode_cuti">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_cuti') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Cuti</label>
                <input class="form-control"  placeholder="Masukkan Nama Cuti" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>
</form>
@endsection
