@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Ubah Password</h2>
    {{ Breadcrumbs::render('ubah-password-update') }}
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="edit-post-form" action="{{route('ubah.password.update')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <form class="edit-post-form">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Password Lama</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group has-validation">
                            <div class="input-group password-check">
                                <span class="input-affix-wrapper affix-wth-text">
                                    <input class="form-control password" placeholder="Masukkan password lama" value="" name="password" type="password" id="password" autocomplete="off">
                                    <a href="#" class="input-suffix text-primary text-uppercase fs-8 fw-medium" >
                                        <span><i class="fas fa-eye"></i></span>
                                        <span class="d-none"><i class="fas fa-eye-slash"></i></span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Password Baru</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group has-validation">
                            <div class="input-group password-check">
                                <span class="input-affix-wrapper affix-wth-text">
                                    <input class="form-control password" placeholder="Masukkan password baru" value="" id="password_baru" name="password_baru" type="password" autocomplete="off">
                                    <a href="#" class="input-suffix text-primary text-uppercase fs-8 fw-medium" >
                                        <span><i class="fas fa-eye"></i></span>
                                        <span class="d-none"><i class="fas fa-eye-slash"></i></span>
                                    </a>
                                </span>
                            </div>
                            <span id="msg1"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Konfirmasi Password</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group has-validation">
                            <div class="input-group password-check">
                                <span class="input-affix-wrapper affix-wth-text">
                                    <input class="form-control password" placeholder="Konfirmasi password" value="" id="password_baru2" name="password_baru2" type="password" autocomplete="off">
                                    <a href="#" class="input-suffix text-primary text-uppercase fs-8 fw-medium" >
                                        <span><i class="fas fa-eye"></i></span>
                                        <span class="d-none"><i class="fas fa-eye-slash"></i></span>
                                    </a>
                                </span>
                            </div>
                            <span id="msg2"></span>
                            {{-- <span class="text-success d-none" id="benar2"> Passoword yang anda benar</span> --}}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-submit">Ubah</button>
            </form>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>

    $(document).ready(function () {
        /*Password Check Js*/
        $(document).on("click",".password",function (e) {
            var targetInput = $(this).id.match( /\d/g ).find('input');
            // var targetInput = $(this).closest( "#password" ).find('input');
            if(targetInput.val().length > 0) {
                if('password' == targetInput.attr('type')){
                    targetInput.prop('type', 'text');
                    $(this).find('span').toggleClass('d-none');
                }else{
                    targetInput.prop('type', 'password');
                    $(this).find('span').toggleClass('d-none');
                }
            }
            else {
                $(this).find('span:first-child').removeClass('d-none');
                $(this).find('span:last-child').addClass('d-none');
                
            }
            return false;
        });
        $(document).on("input",".password",function (e) {
            if($(this).val()==""){
                $(this).prop('type', 'password');
                $(this).parent().find('.input-suffix > span:first-child').removeClass('d-none');
                $(this).parent().find('.input-suffix > span:last-child').addClass('d-none');
            }
        });
    });

    $('#password ,#password_baru, #password_baru2').on('keyup', function () {
        var lama = $('#password').val();
        var baru = $('#password_baru').val();
        var baru2 = $('#password_baru2').val();
        if ( baru == lama) {
            $('#msg1').html('Passoword yang anda masukan tidak boleh sama dengan password lama').css('color', 'red') ;
        } else {
            $('#msg1').html('');
        }
        
        if ( baru2 == baru ) {
            $('#msg2').html('') ;
        } else {
            $('#msg2').html('Password yang anda masukan salah').css('color', 'red');
        }
    });


    
</script>
@endpush