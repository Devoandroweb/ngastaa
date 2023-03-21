@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Jurusan</h2>
    {{ Breadcrumbs::render('edit-jurusan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.jurusan.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="form-group">
            <label class="form-label">Tingkat Pendidikan</label>
            <select class="form-control select2" name="kode_pendidikan" required>
                <option selected disabled>Select Tingkat Pendidikan</option>
                @foreach($pendidikan as $s)
                    <option value="{{$s->kode_pendidikan}}">{{$s->nama}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Jurusan</label>
                <input class="form-control mb-3 @error('kode_jurusan') is-invalid @enderror"  placeholder="Masukkan Kode Jurusan" name="kode_jurusan">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_jurusan') }}
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
