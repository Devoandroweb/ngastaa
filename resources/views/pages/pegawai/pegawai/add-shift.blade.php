@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tambah Shift Pegawai</h2>
    {{ Breadcrumbs::render('tambah-shift-pegawai',$pegawai) }}
    {{-- <h1>Data Pegawai <small class="text-muted">/ Tambah Pegawai</small> </h1> --}}
@endsection
@section('header_action')
<div class="input-group">
    <span class="input-affix-wrapper">
        <label for="">Nama Pegawai : <span class="badge badge-danger rounded-end-0">{{$pegawai->nip}}</span><span class="badge rounded-start-0 badge-warning text-dark fw-bold">{{$pegawai->getFullName()}}</span></label>
    </span>
</div>
@endsection
@section('content')
@include('pages.pegawai.pegawai.datariwayat.shift.add',compact('for','Rshift','pegawai'))
@endsection
@push('js')
@include('pages.pegawai.pegawai.datariwayat.shift.js')
<script>
    initShift();
</script>
@endpush