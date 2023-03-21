@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penghargaan</h2>
    {{ Breadcrumbs::render('tambah-penghargaan') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="edit-post-form" action="{{route('master.penghargaan.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Penghargaan</label>
                <input class="form-control mb-3 @error('kode_penghargaan') is-invalid @enderror"  placeholder="Masukkan Kode Penghargaan" name="kode_penghargaan">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_penghargaan') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Penghargaan</label>
                <input class="form-control"  placeholder="Masukkan Nama Penghargaan" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.penghargaan.index')}}" class="btn btn-light">Kembali</a>
</form>
@endsection
