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
<form class="edit-post-form" action="{{url('pegawai/potongan/edit'.$pegawi->nip)}}" method="post">
    {{-- <input type="hidden" name="id" value="{{$pegawai->id}}"> --}}
    @csrf
    
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="aktif" name="aktif" class="form-check-input" checked>
                <label class="form-check-label" for="aktif">Aktif (Terhitung pada Payroll)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="tidak_aktif" name="tidak_aktif" class="form-check-input" checked>
                <label class="form-check-label" for="tidak_aktif">Tidak Aktif (Tidak terhitung pada Payroll)</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Potongan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="jenis_potongan" required>
                    <option selected disabled>Select Jenis Potongan</option>
                    <option selected >Select Jenis Potongan</option>
                    {{-- @foreach($pegawai as $s)
                        <option value="{{$s->kode_potongan}}">{{$s->status}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('jenis_potongan') }}
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
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_sk') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_sk') is-invalid @enderror" placeholder="Masukkan Nomor Sk" name="nomor_sk" type="nomor_sk" value="{{$pegawai->nomor_sk}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_sk') }}
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
