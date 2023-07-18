@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Pengajuan Izin</h2>
    {{ Breadcrumbs::render('pengajuan-approved-cuti') }}
@endsection
@section('content')
@if(session('messages'))
@include('alert.alert-inv')
@endif
<form class="edit-post-form" action="{{route('pengajuan.cuti.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$cuti->id}}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Nomor Surat</label>
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror"  placeholder="Masukkan Nomor Surat" value="{{old('nomor_surat')}}" name="nomor_surat">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_surat') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Tanggal Surat</label>
                <input type="date" class="form-control mb-3 @error('tanggal_surat') is-invalid @enderror" value="{{old('tanggal_surat')}}" name="tanggal_surat">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="form-group has-validation">
        <label class="form-label">Komentar</label>
        <textarea class="form-control mb-3 @error('komentar') is-invalid @enderror"  placeholder="Masukkan Komentar" name="komentar">{{old('komentar')}}</textarea>
        <div class="invalid-feedback">
            {{ $errors->first('komentar') }}
        </div>
    </div>
    <div class="form-group has-validation">
        <label class="form-label">Unggah Surat Persetujuan</label>
        <input class="form-control"  type="file" name="file">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('pengajuan.cuti.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
