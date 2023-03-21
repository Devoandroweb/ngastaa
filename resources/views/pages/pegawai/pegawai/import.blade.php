@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penjadwalan Shift</h2>
    {{-- {{ Breadcrumbs::render('tambah-shift-libur') }} --}}
@endsection
@section('content')
<div class="d-flex align-items-center header-form">
    <h4>Import Data Pegawai</h4>
    <div class="line-text"></div>
</div>
<hr>
<form class="edit-post-form" action="{{route('pegawai.pegawai.import_pegawai')}}" method="post">
    @csrf
        
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Import File disini<span class="text-danger">*</span></label>
            <input class="form-control mb-3 @error('file') is-invalid @enderror" name="file" type="file" >
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{__('Simpan')}}</button>
    <a href="{{route('pegawai.pegawai.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection



