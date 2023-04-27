@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Pengumuman</h2>
    {{ Breadcrumbs::render('edit-pengumuman') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('pengumuman.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$pengumuman->id}}">
    <div class="row">
        <div class="col">
            <div class="form-group has-validation">
                <label class="form-label">Judul</label>
                <input class="form-control @error('judul') is-invalid @enderror" value="{{$pengumuman->judul}}" placeholder="Masukkan Judul" name="judul">
                <div class="invalid-feedback">
                    {{ $errors->first('judul') }}
                </div>
            </div>
            <div class="form-group has-validation">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror"  rows="5" placeholder="Masukkan deskripsi" name="deskripsi">{{$pengumuman->deskripsi}}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('deskripsi') }}
                </div>
            </div>
            <div class="form-group has-validation">
                <label class="form-label">PDF / Gambar</label>
                <div class="input-group">
                    <input type="hidden" name="old-file" value="{{$pengumuman->file}}">
                    <a href="{{url($pengumuman->file)}}" class="btn btn-success" target="_blank">File Saat ini</a>
                    <input type="file" class="form-control @error('file') is-invalid @enderror"  placeholder="Masukkan File" name="file">
                </div>
                <div class="invalid-feedback">
                    {{ $errors->first('file') }}
                </div>
            </div>
        </div>
       
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('pengumuman.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
