@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Perpanjang Kontrak Pegawai</h2>
    {{ Breadcrumbs::render('kontrak-pegawai') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {!!session('messages')!!}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="edit-post-form" action="{{route('pegawai.pegawai.import_pegawai')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="form-group has-validation">
            <div class="row">
                <div class="col">
                    <label class="form-label">Import File disini<span class="text-danger">*</span></label>
                </div>
                <div class="col text-md-end">
                    <a href="{{route('donwload_template_import')}}">{!!icons('download')!!} Unduh Template Excel</a>
                </div>
            </div>
            <input class="form-control mb-3 @error('file') is-invalid @enderror" name="file" type="file" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{__('Simpan')}}</button>
    <a href="{{route('pegawai.pegawai.index')}}" class="btn btn-light">{{__('Kembali')}}</a>
</form>
@endsection
