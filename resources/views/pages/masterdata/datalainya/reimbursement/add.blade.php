@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Reimbursment</h2>
    {{ Breadcrumbs::render('tambah-reimbursement') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.reimbursement.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">kode Reimbursement</label>
                <input class="form-control mb-3 @error('kode_reimbursement') is-invalid @enderror"  placeholder="Masukkan Kode Reimbursement" name="kode_reimbursement">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_reimbursement') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Reimbursement</label>
                <input class="form-control"  placeholder="Masukkan Nama Reimbursement" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>
</form>
@endsection
