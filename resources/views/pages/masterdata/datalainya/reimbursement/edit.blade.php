@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Reimbursment</h2>
    {{ Breadcrumbs::render('edit-reimbursement') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.reimbursement.store')}}" method="post">
    <input type="hidden" name="id" value="{{$reimbursement->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Reimbursement</label>
                <input class="form-control @error('kode_reimbursement') is-invalid @enderror"  placeholder="Masukkan Kode Reimbursement" value="{{$reimbursement->kode_reimbursement}}" name="kode_reimbursement">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_reimbursement') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Penghargaan</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$reimbursement->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
