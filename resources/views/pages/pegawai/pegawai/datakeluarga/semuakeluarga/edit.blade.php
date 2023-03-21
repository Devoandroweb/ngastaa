@extends('app')
@section('breadcrumps')
    {{-- {{ Breadcrumbs::render('pendidikan') }} --}}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="edit-post-form" action="{{url('pegawai/keluarga/store')}}" method="post">
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    @csrf
    <div class="row">
        
        <div class="col-md-4">
            <label class="form-label">Status Hubungan</label>
        </div>
        <div class="col-md-6">
            <select class="form-control select2" name="kode_status" required>
                <option selected disabled>Select Status Hubungan</option>
                @foreach($keluarga as $s)
                    <option value="{{$s->kode_status}}">{{$s->status}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama</label>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <input class="form-control mb-3 @error('nama') is-invalid @enderror"  placeholder="Masukkan Nama" name="nama" value="{{$keluarga->nama}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nama') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat Lahir</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tempat_lahir') is-invalid @enderror" placeholder="Masukkan Tempat Lahir" name="tempat_lahir" value="{{$keluarga->tempat_lahir}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tempat_lahir') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Lahir</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_lahir') is-invalid @enderror" placeholder="Masukkan Tanggal Lahir" name="tanggal_lahir" type="date" value="{{$keluarga->tanggal_lahir}}" >
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_lahir') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Telepon</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_telepon') is-invalid @enderror" placeholder="Masukkan Nomor Telepon" name="nomor_telepon">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_telepon') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Alamat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <textarea class="form-control mb-3 @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" name="alamat" rows="3" value="{{$keluarga->alamat}}" >
                <div class="invalid-feedback">
                    {{ $errors->first('alamat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Ktp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_ktp') is-invalid @enderror" placeholder="Masukkan Nomor Ktp" name="nomor_ktp" value="{{$keluarga->nomor_ktp}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_ktp') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Ktp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file_ktp') is-invalid @enderror" placeholder="Masukkan Unggah Ktp" name="file_ktp" type="file" value="{{$keluarga->file_ktp}}">
                <div class="invalid-feedback">
                    {{ $errors->first('file_ktp') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Bpjs</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_bpjs') is-invalid @enderror" placeholder="Masukkan Nomor Bpjs" name="nomor_bpjs" value="{{$keluarga->nomor_bpjs}}>
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_bpjs') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Bpjs</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file_bpjs') is-invalid @enderror" placeholder="Masukkan Unggah Bpjs" name="file_bpjs" type="file" value="{{$keluarga->file_bpjs}}>
                <div class="invalid-feedback">
                    {{ $errors->first('file_bpjs') }}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{url('pegawai/keluarga/'.$pegawai->nip)}}" class="btn btn-light">Kembali</a>
</form>
@endsection
@push('js')
    
@endpush
