@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Riwayat Lainnya</h2>
    {{ Breadcrumbs::render('edit-lainnya') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.lainnya.store')}}" method="post">
    <input type="hidden" name="id" value="{{$lainnya->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Lainnya</label>
                <input class="form-control @error('kode_lainnya') is-invalid @enderror"  placeholder="Masukkan Kode Lainnya" value="{{$lainnya->kode_lainnya}}" name="kode_lainnya">
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $errors->first('kode_lainnya') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Lainnya</label>
                <input class="form-control"  placeholder="Masukkan Nama Lainnya" value="{{$lainnya->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light">Kembali</button>

</form>
@endsection
