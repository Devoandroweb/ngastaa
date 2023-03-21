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
            <label class="form-label">Tanggal<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal') is-invalid @enderror" placeholder="Masukkan Tanggal" name="tanggal" type="date" value="{{$pegawai->tanggal}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jam Mulai<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jam_mulai') is-invalid @enderror" placeholder="Jam Mulai" name="jam_mulai" type="time" value="{{$pegawai->jam_mulai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('jam_mulai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jam Selesai<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jam_selesai') is-invalid @enderror" placeholder="Jam Selesai" name="jam_selesai" type="time" value="{{$pegawai->jam_selesai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('jam_selesai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">keterangan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan" name="keterangan" value="{{$pegawai->keterangan}}">
                <div class="invalid-feedback">
                    {{ $errors->first('keterangan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="date" value="{{$pegawai->tanggal_surat}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$pegawai->nomor_surat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_surat') }}
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
