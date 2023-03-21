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
<form class="edit-post-form" action="{{url('pegawai/potongan/edit')}}" method="post">
    {{-- <input type="hidden" name="id" value="{{$pegawai->id}}"> --}}
    @csrf
    
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Kursus</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="nama_kursus" required>
                    <option selected disabled>Select Nama Kursus</option>
                    <option selected >Select Nama Kursus</option>
                    {{-- @foreach($pegawai as $s)
                        <option value="{{$s->kode_potongan}}">{{$s->status}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('nama_kursus') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tempat') is-invalid @enderror" placeholder="Masukkan Tempat" name="tempat" value="{{$pegawai->tempat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tempat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Pelaksana</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('pelaksana') is-invalid @enderror" placeholder="Pelaksana" name="pelaksana" value="{{$pegawai->pelaksana}}">
                <div class="invalid-feedback">
                    {{ $errors->first('pelaksana') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Angkatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('angkatan') is-invalid @enderror" placeholder="Angkatan" name="angkatan" value="{{$pegawai->angkatan}}">
                <div class="invalid-feedback">
                    {{ $errors->first('angkatan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_mulai') is-invalid @enderror" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" type="date" value="{{$pegawai->tanggal_mulai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_mulai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_selesai') is-invalid @enderror" placeholder="Masukkan Tanggal Selesai" name="tanggal_selesai" type="date" value="{{$pegawai->tanggal_selesai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_selesai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jumlah Jp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jumlah_jp') is-invalid @enderror" placeholder="Masukkan Jumlah Jp" name="jumlah_jp" value="{{$pegawai->jumlah_jp}}">
                <div class="invalid-feedback">
                    {{ $errors->first('jumlah_jp') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">No Sertifikat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('no_sertifikat') is-invalid @enderror" placeholder="Masukkan No Sertifikat" name="no_sertifikat" value="{{$pegawai->no_sertifikat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('no_sertifikat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sertifikat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_sertifikat') is-invalid @enderror" placeholder="Masukkan Tanggal Sertifikat" name="tanggal_sertifikat" type="date" value="{{$pegawai->tanggal_sertifikat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_sertifikat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Dokumen</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file') is-invalid @enderror" placeholder="" name="file" type="file" value="{{$pegawai->file}}">
                <div class="invalid-feedback">
                    {{ $errors->first('file') }}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{url('pegawai/kgb/')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
    <script>
        
    </script>
@endpush
