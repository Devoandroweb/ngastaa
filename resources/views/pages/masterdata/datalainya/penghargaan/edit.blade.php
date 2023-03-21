@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penghargaan</h2>
    {{ Breadcrumbs::render('edit-penghargaan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.penghargaan.store')}}" method="post">
    <input type="hidden" name="id" value="{{$penghargaan->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Penghargaan</label>
                <input class="form-control @error('kode_penghargaan') is-invalid @enderror"  placeholder="Masukkan Kode Penghargaan" value="{{$penghargaan->kode_penghargaan}}" name="kode_penghargaan">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_penghargaan') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Penghargaan</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$penghargaan->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
