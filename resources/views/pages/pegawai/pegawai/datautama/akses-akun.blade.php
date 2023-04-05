
<div class="d-flex flex-wrap justify-content-between flex-1">
    <div class="mb-lg-0 mb-2 me-8">
        <h4 class="fw-bold">Informasi Login</h4>
    </div>
    <div class="pg-header-action-wrap">
        {{-- <a href="{{route('pegawai.pegawai.edit',$pegawai->nip)}}" class="btn btn-outline-danger btn-rounded me-2"><i class="fas fa-pencil-alt fa-sm"></i> Edit</a> --}}
    </div>
</div>
<div class="row mb-4 text-dark">
    <div class="col-12 col-sm-3 mb-4">
        <p>Nomor Pegawai</p>
        <b>{{$pegawai->nip}}</b>
    </div>
    <div class="col-12 col-sm-3 mb-4">
        <p>Password</p>
        <b>********</b>
    </div>
</div>