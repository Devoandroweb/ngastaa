@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Management User Direksi</h2>
    {{ Breadcrumbs::render('tambah-management-user-direksi') }}
@endsection
@section('content')

<form class="edit-post-form" action="{{route('users.direksi.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Nama Owner</label>
                <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror">
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
            </div>
        </div>
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror">
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
                <small class="text-danger">* Email di gunakan untuk login</small>
            </div>
        </div>
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="" class="form-control password">
            </div>
        </div>
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="conf_password" id="" class="form-control conf-password">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-save disabled">Simpan</button>
    <a href="{{route('users.direksi.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
<script>
    $(".conf-password").keyup(function (e) { 
        confPass($(".password"))
    });
    $(".password").keyup(function (e) { 
        confPass($(this))
    });
    function confPass(inputPassword){
        $(".conf-password").removeClass("is-invalid")
        $(".conf-password").siblings(".invalid-feedback").remove()
        if($(".conf-password").val() == "" && inputPassword.val() == ""){
            $(".btn-save").addClass("disabled")
        }
        if($(".conf-password").val() != inputPassword.val()){
            $(".btn-save").addClass("disabled")
            $(".conf-password").addClass("is-invalid").after(`<div class="invalid-feedback">
                    Konfirmasi Password harus sama dengan Password
                </div>`)
        }else{
            $(".btn-save").removeClass("disabled")
        }
    }
</script>
@endpush
