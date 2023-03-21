@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Jurusan</h2>
    {{ Breadcrumbs::render('tambah-jurusan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.jurusan.store')}}" method="post">
    <input type="hidden" name="id" value="{{$jurusan->id}}">
    @csrf
    <div class="row">
        <div class="form-group">
            <label class="form-label">Tingkat Pendidikan</label>
            <select class="form-control select2" name="kode_pendidikan" required>
                <option selected disabled>Select Tingkat Pendidikan</option>
                @foreach($pendidikan as $s)
                @if($jurusan->kode_pendidikan == $s->kode_pendidikan)
                    <option value="{{$s->kode_pendidikan}}">{{$s->nama}}</option>
                    @else
                    <option selected value="{{$s->kode_pendidikan}}">{{$s->nama}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Pendidikan</label>
                <input class="form-control @error('kode_jurusan') is-invalid @enderror"  placeholder="Masukkan Kode Pendidikan" value="{{$jurusan->kode_jurusan}}" name="kode_jurusan">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_jurusan') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama Status" value="{{$jurusan->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
