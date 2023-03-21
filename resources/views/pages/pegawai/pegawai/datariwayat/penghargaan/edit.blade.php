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
            <label class="form-label">Nama Penghargaan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="nama_penghargaan" required>
                    <option selected disabled>Select Nama Penghargaan</option>
                    <option selected >Select Nama Penghargaan</option>
                    {{-- @foreach($pegawai as $s)
                        <option value="{{$s->kode_potongan}}">{{$s->status}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('nama_penghargaan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Oleh<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('oleh') is-invalid @enderror" placeholder="Oleh" name="oleh" value="{{$pegawai->oleh}}">
                <div class="invalid-feedback">
                    {{ $errors->first('oleh') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_sk') is-invalid @enderror" placeholder="Masukkan Nomor sk" name="nomor_sk" value="{{$pegawai->nomor_sk}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_sk') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_sk') is-invalid @enderror" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" type="date" value="{{$pegawai->tanggal_sk}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_sk') }}
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
