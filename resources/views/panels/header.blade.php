<!DOCTYPE html>
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
    <link rel="shortcut icon" href="{{ url("public/".perusahaan('favicon')) }}">
    <link rel="icon" href="{{ url("public/".perusahaan('favicon')) }}" type="image/x-icon">

	<!-- Daterangepicker CSS -->
    <link href="{{asset('/')}}vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

	<!-- Data Table CSS -->
    <link href="{{asset('/')}}vendors/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/')}}vendors/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    {{-- <link href="{{asset('/')}}vendors/datatables.net-buttons/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" /> --}}

	<!-- CSS -->
    <link href="{{asset('/')}}dist/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}vendors/leaflet/leaflet.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}tooltip-dw.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}loading.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}custom.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}clock.css" rel="stylesheet" type="text/css">
    <link href="{{asset('/')}}vendors/izitoast/css/iziToast.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>const _URL_MAIN = "{{url('/')}}"</script>
</head>
