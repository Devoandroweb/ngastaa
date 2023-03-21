@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Profile Perusahaan</h2>
    {{ Breadcrumbs::render('profile-perusahaan') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@php
function searchId($id,$data)
{
    foreach ($data as $item):
        if($item['id'] == $id):
            return true;
        endif;
    endforeach;
    return false;
}
@endphp
<form class="edit-post-form" action="{{route('perusahaan.update')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$perusahaan->id}}">
    <div class="row">
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label for="">Nama Perusahaan</label>
                <input type="text" class="form-control" name="nama" value="{{$perusahaan->nama}}">
            </div>
            <div class="form-group">
                <label for="">Alamat Perusahaan</label>
                <textarea id="" class="form-control" cols="30" rows="5" name="alamat">{{$perusahaan->alamat}}</textarea>
            </div>
            <div class="form-group">
                <label for="">Kontak Perusahaan</label>
                <textarea id="" class="form-control" cols="30" rows="5" name="kontak">{{$perusahaan->kontak}}</textarea>
            </div>
            <div class="form-group">
                <label for="">Direktur Perusahaan</label>
                <input type="text" class="form-control" name="direktur" value="{{$perusahaan->direktur}}">
            </div>
            <div class="form-group">
                <label for="">Nomor Pegawai Direktur</label>
                <input type="text" class="form-control" name="nomor" value="{{$perusahaan->nomor}}">
            </div>
            <div class="form-group">
                <label for="">Website</label>
                <input type="text" class="form-control" name="website" value="{{$perusahaan->website}}">
            </div>
            <div class="form-group">
                <label for="">Logo Perusahaan</label>
                <div class="image-live" data-target="logo" data-ext="png,jpg,jpeg">
                    <input type="file" class="d-none file-live" name="logo">
                    <input type="text" class="d-none" value="{{$perusahaan->logo}}" name="logo-old">
                    @if($perusahaan->logo != null)
                    <img id="logo" src="{{url('public/'.$perusahaan->logo)}}"  style="width: 200px; height:200px" class="shadow mb-4 img-fluid" alt="">
                    @else
                    <img id="logo" src="{{asset('no-image.png')}}"  style="width: 200px; height:200px" class="shadow mb-4 img-fluid" alt="">
                    @endif
                </div>
                <div class="text-danger mb-4"><small><i>File Tidak Boleh Lebih besar dari 1Mb</i></small></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>


</form>
@endsection
@push('js')
<script>
    $(".pegawai").select2({allowClear: true});
</script>
<script src="{{asset('/')}}image-live.js"></script>

@endpush
