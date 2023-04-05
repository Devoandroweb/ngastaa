
        <div class="d-flex flex-wrap justify-content-between flex-1">
            <div class="mb-lg-0 mb-2 me-8">
                <h4 class="fw-bold">Personal Detail</h4>
            </div>
            <div class="pg-header-action-wrap">
                <a href="{{route('pegawai.pegawai.edit',$pegawai->nip)}}" class="btn btn-outline-danger btn-rounded me-2"><i class="fas fa-pencil-alt fa-sm"></i> Edit</a>
            </div>
        </div>
        <hr>
        <div class="row mb-4 text-dark">
            <div class="col-12 col-sm-3 mb-4">
                <p>Nomor Pegawai</p>
                <b>{{$pegawai->nip}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>Nama Lengkap</p>
                <b>{{$pegawai->name}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>Tempat Lahir</p>
                <b>{{$pegawai->tempat_lahir}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>Tanggal Lahir</p>
                <b>{{$pegawai->tlahir}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4 text-capitalize">
                <p>Jenis Kelamin</p>
                <b>{{$pegawai->jenis_kelamin}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4 text-capitalize">
                <p>Agama</p>
                <b>{{$pegawai->kode_agama}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4 text-capitalize">
                <p>Status Perkawinan</p>
                <b>{{$pegawai->kode_kawin}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>Golongan Darah</p>
                <b>{{$pegawai->golongan_darah}}</b>
            </div> 
            <div class="col-12 col-sm-3 mb-4">
                <p>Nomor KTP</p>
                <b>{{$pegawai->nik}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>No. HP</p>
                <b>{{$pegawai->no_hp}}</b>
            </div>
            <div class="col-12 col-sm-3 mb-4">
                <p>Email</p>
                <b>{{$pegawai->email}}</b>
            </div>
        </div>
        <h4 class="fw-bold">Alamat</h4>
        <hr>
        <div class="row text-dark">
            <div class="col-12 col-sm-6 mb-4">
                <p>Alamat Domisili</p>
                <b>{{$pegawai->alamat}}</b>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <p>Alamat Sesuai KTP</p>
                <b>{{$pegawai->alamat_ktp}}</b>
            </div>
        </div>
    





