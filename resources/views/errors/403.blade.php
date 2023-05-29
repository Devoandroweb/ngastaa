<!DOCTYPE html>
<!--
Jampack
Author: Hencework
Contact: contact@hencework.com
-->
<html lang="en">
<head>
    <!-- Meta Tags -->
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <meta name="description" content=""/>

	<!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('/')}}dist/img/logo-dsm.ico">
    <link rel="icon" href="{{asset('/')}}dist/img/logo-dsm.ico" type="image/x-icon">

	<!-- CSS -->
    <link href="{{asset('/')}}dist/css/style.css" rel="stylesheet" type="text/css">

</head>
<div class="row mb-4">
    <div class="col-xl-7 col-lg-6 d-lg-block d-none">
        <div class="auth-content py-md-0 py-8">
            <div class="row">
                <div class="col-xl-12 text-center">
                    <img src="{{asset('dist/img/403.svg')}}" class="img-fluid w-sm-80 w-50" alt="login">
                    <p class="p-xs mt-5 text-light">Illustrations powered by <a href="https://freepik.com/" target="_blank" class="text-light"><u>Icons8</u></a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-6 col-md-7 col-sm-10">
        <div class="auth-content py-md-0 py-8">
            <div class="w-100">
                <div class="row">
                    <div class="col-xxl-9 col-xl-8 col-lg-11 d-flex align-items-center" style="height:100vh">
                        <div>
                            <h1 class="display-4 fw-bold mb-2">403</h1>
                            <p class="p-lg">Maaf, anda tidak boleh mengakses halaman ini.</p>
                            <a href="{{url('/')}}" class="btn btn-gradient-primary btn-animate mt-4">Ke Halaman Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include("panels.footer")

<!-- Bootstrap Core JS -->
<script src="{{asset('/')}}vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

