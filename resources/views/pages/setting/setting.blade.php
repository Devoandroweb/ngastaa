@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Pengaturan</h2>
    {{ Breadcrumbs::render('pengaturan') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<ul class="nav nav-tabs nav-icon nav-light">
	<li class="nav-item">
		<a class="nav-link active" data-bs-toggle="tab" href="#tab_block_12">
			<span class="nav-icon-wrap"><span class="feather-icon"><i data-feather="log-in"></i></span></span>
			<span class="nav-link-text">Login Page</span>
		</a>
	</li>
	{{-- <li class="nav-item">
		<a class="nav-link" data-bs-toggle="tab" href="#tab_block_22">
			<span class="nav-icon-wrap"><span class="feather-icon"><i data-feather="file-text"></i></span></span>
			<span class="nav-link-text">Link</span>
		</a>
	</li> --}}
</ul>
<div class="tab-content">
	<div class="tab-pane fade show active" id="tab_block_12">
        <form class="edit-post-form" action="{{ route('setting.setting.updatePageLogin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" class="form-control" name="title" value="{{$sLogin?->title}}">
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <textarea name="desk" class="form-control" cols="30" rows="10">{{$sLogin?->desk}}</textarea>
            </div>
            <div class="form-group">
                <label for="">Logo</label>
                <div class="image-live" data-target="logo" data-ext="png,jpg,jpeg">
                    <input type="file" class="d-none file-live" name="logo">
                    <input type="text" class="d-none" value="{{$sLogin?->logo}}" name="logo-old">
                    @if($sLogin?->logo != null)
                    <img id="logo" src="{{url('public/'.$sLogin?->logo)}}"  style="width: 500px; height:200px" class="shadow mb-4 img-fluid" alt="">
                    @else
                    <img id="logo" src="{{asset('no-image.png')}}"  style="width: 500px; height:200px" class="shadow mb-4 img-fluid p-3 rounded" alt="">
                    @endif
                </div>
                <div class="text-danger mb-4"><small><i>File Tidak Boleh Lebih besar dari 1Mb</i></small></div>
            </div>
            <div class="form-group">
                <label for="">Cover</label>
                <div class="image-live" data-target="cover" data-ext="png,jpg,jpeg">
                    <input type="file" class="d-none file-live" name="cover">
                    <input type="text" class="d-none" value="{{$sLogin?->cover}}" name="cover-old">
                    @if($sLogin?->cover != null)
                    <img id="cover" src="{{url('public/'.$sLogin?->cover)}}"  style="width: 400px; height:400px" class="shadow mb-4 img-fluid" alt="">
                    @else
                    <img id="cover" src="{{asset('no-image.png')}}"  style="width: 400px; height:400px" class="shadow mb-4 img-fluid p-3 rounded" alt="">
                    @endif
                </div>
                <div class="text-danger mb-4"><small><i>File Tidak Boleh Lebih besar dari 1Mb</i></small></div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
	</div>
	{{-- <div class="tab-pane fade" id="tab_block_22">
		<p>iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
	</div> --}}
</div>
@endsection
@push('js')
<script src="{{asset('/')}}image-live.js"></script>
@endpush
