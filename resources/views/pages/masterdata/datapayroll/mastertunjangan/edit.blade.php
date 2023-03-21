@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tunjangan</h2>
    {{ Breadcrumbs::render('edit-tunjangan') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.tunjangan.store')}}" method="post">
    <input type="hidden" name="id" value="{{$tunjangan->id}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode</label>
                <input class="form-control @error('kode_tunjangan') is-invalid @enderror"  placeholder="Masukkan Kode Tunjangan" value="{{$tunjangan->kode_tunjangan}}" name="kode_tunjangan">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama</label>
                <input class="form-control"  placeholder="Masukkan Nama" value="{{$tunjangan->nama}}" name="nama">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>    
    <a href="{{route('master.payroll.tunjangan.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
