@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Pengaturan</h2>
    {{ Breadcrumbs::render('pengaturan') }}
@endsection
@section('content')
@push('style')
<style>
    #refresh-cw{
        animation: rotate360 2s linear infinite;
    }
    @keyframes rotate360{
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
}
</style>
@endpush
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<ul class="nav nav-tabs nav-icon nav-light">
	<li class="nav-item">
		<a class="nav-link active" data-bs-toggle="tab" href="#login_page">
			<span class="nav-icon-wrap"><span class="feather-icon"><i data-feather="log-in"></i></span></span>
			<span class="nav-link-text">Login Page</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-bs-toggle="tab" href="#whatsapp_api">
			<span class="nav-icon-wrap"><span class="feather-icon"><i data-feather="message-circle"></i></span></span>
			<span class="nav-link-text">Whatsapp Web Services</span>
		</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane fade show active" id="login_page">
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
	<div class="tab-pane fade" id="whatsapp_api">
		<div class="form-group">
            <label for="">Nomor Whatsapp</label>
            <div class="row mb-3">
                <div class="col-8">
                    <input type="text" value="6285745325535" name="wa_number" placeholder="(62)__-___-___" data-mask="(62)99-999-999-999" class="form-control">
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col">
                            <button id="connect-wa" class="btn btn-success w-100" disabled>
                                <span id="loadingConnect" style="display: none"><span id="refresh-cw" class="feather-icon"><i data-feather="refresh-cw"></i></span><span> Tunggu...</span></span>
                                <span id="buttonConnect"><span class="feather-icon"><i data-feather="git-pull-request"></i></span><span> Connect</span></span>
                            </button>
                        </div>
                        <div class="col">
                            <button id="logout-wa" class="btn btn-danger w-100" disabled>
                                <span id="loadingLogout" style="display: none"><span id="refresh-cw" class="feather-icon"><i data-feather="refresh-cw"></i></span><span> Tunggu...</span></span>
                                <span id="buttonLogout"><span class="feather-icon"><i data-feather="git-pull-request"></i></span><span> Logout</span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless w-100">
                    <tr>
                        <td class="text-muted">Server</td>
                        <td class="fw-medium text-dark">
                            <span id="indicate-server-loading" class="badge badge-sm badge-info">
                                <span>
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                    Check Server...
                                </span>

                            </span>
                            <span id="indicate-server-off" class="badge badge-sm badge-danger" style="display: none">
                                <span>
                                    <svg class="badge-dot" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8"/>
                                    </svg>Off
                                </span>
                            </span>
                            <span id="indicate-server-on" class="badge badge-sm badge-success" style="display: none">
                                <span>
                                    <svg class="badge-dot" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="8"/>
                                    </svg>On
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td id="status" class="fw-medium">-</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="info-wa" class="alert alert-inv bg-gradient-dusk" style="display: none">
            <h5 class="alert-heading mb-2">Masukkan Kode <span id="code-wa"></span> melalui langkah berikut !</h5>
            <ol>
                <li>
                    Ketuk titik tiga kanan atas > Perangkat tertaut > Tautkan perangkat > Tautkan dengan nomor telepon saja.
                </li>
                <li>
                    Buka kunci telepon utama:
                    <ul>
                        <li>
                            Jika perangkat Anda memiliki fitur autentikasi biometrik, silakan ikuti petunjuk yang ditampilkan di layar.
                        </li>
                        <li>
                            Jika tidak mengaktifkan autentikasi biometrik, Anda akan diminta memasukkan PIN yang digunakan untuk membuka kunci telepon.
                        </li>
                    </ul>
                </li>
                <li>
                    Masukkan kode 8 karakter dari perangkat pendamping di telepon utama Anda untuk menautkan perangkat.
                </li>
            </ol>
        </div>
	</div>
</div>
@endsection
@push('js')
<script src="{{asset('/')}}vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="{{asset('/')}}image-live.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script type="text/javascript">
    const _WA_HOST = `{{ config('app.go_wa_host') }}`

    checkServer()
    $("#connect-wa").click(function (e) {
        e.preventDefault();
        if(checkServer()){
            const thisHtml = $(this).html();
            $("#loadingConnect").show();
            $("#buttonConnect").hide();
            $("#connect-wa").attr("disabled","disabled")
            var waNumber = $("input[name=wa_number]").val();
            waNumber = waNumber.replace(/[^0-9]/g, '')

            $.ajax({
                type: "post",
                url: `${_WA_HOST}/create-devices`,
                data: {key:waNumber,number:waNumber},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    $("#loadingConnect").hide();
                    $("#buttonConnect").show();
                    $("#info-wa").show()
                    $("#code-wa").text(response.code)
                }
            });
        }
    });
    function checkServer(){
        $.ajax({
            url: _WA_HOST,
            type: 'GET',
            success: function() {
                $("#indicate-server-loading").hide()
                $("#indicate-server-off").hide()
                $("#indicate-server-on").show()
                $("#connect-wa").removeAttr("disabled")
                checkAuth()
                return true;
            },
            error: function() {
                $("#indicate-server-off").show()
                $("#indicate-server-on").hide()
                $("#indicate-server-loading").hide()
                Swal.fire(
                    'Server Whatsapp Not Running',
                    'silahkan hubungi Developer',
                    'error'
                )
                return false;
            }
        });
    }
    function checkAuth(){
        $("#connect-wa").attr("disabled","disabled")
        $("input[name=wa_number]").attr("disabled","disabled")
        $("#loadingConnect").show();
        $("#buttonConnect").hide();
        var waNumber = $("input[name=wa_number]").val();
        waNumber = waNumber.replace(/[^0-9]/g, '')
        if(waNumber){
            $.ajax({
                type: "get",
                url: _WA_HOST+"/check-auth?key="+waNumber,
                success: function (response) {
                    if(response.auth){
                        buttonIsConnect()
                        feather.replace();
                    }else{
                        buttonIsNotConnect()
                    }
                }
            });
        }
    }
    function buttonIsConnect(){
        $("#status").addClass("text-info")
        $("#status").text("Connected")
        $("#buttonConnect").html(`<span class="feather-icon"><i data-feather="git-pull-request"></i></span><span> Connected</span>`)
        $("#connect-wa").attr("disabled","disabled")
        $("#logout-wa").removeAttr("disabled")
        $("input[name=wa_number]").attr("disabled","disabled")
        $("#loadingConnect").hide();
        $("#buttonConnect").show();
    }
    function buttonIsNotConnect(){
        $("#status").addClass("text-danger")
        $("#status").text("Not Connected")
        $("#connect-wa").removeAttr("disabled")
        $("#logout-wa").attr("disabled","disabled")
        $("input[name=wa_number]").removeAttr("disabled")
    }
    /* PUSHER */
    var pusher = new Pusher('b0a89d4911a784081887', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        if(data.message=="server-on"){
            checkServer();
        }
        if(data.message=="login"){
            buttonIsConnect()
        }
        if(data.message=="logout"){
            buttonIsNotConnect()
        }

    });
</script>

@endpush
