@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Kursus</h2>
    {{ Breadcrumbs::render('edit-kursus') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.kursus.store')}}" method="post">
    <input type="hidden" name="id" value="{{$kursus->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode</label>
                <input class="form-control @error('kode_kursus') is-invalid @enderror"  placeholder="Masukkan Kode Kursus" value="{{$kursus->kode_kursus}}" name="kode_kursus">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_kursus') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$kursus->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
