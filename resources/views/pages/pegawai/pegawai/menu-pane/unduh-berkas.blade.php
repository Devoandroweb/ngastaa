<div class="row nav-justified-start mt-4 ml-3">
    <div class="col col-sm-3 ml-4">
        <a class="btn btn-primary w-100" href="{{url('pegawai/berkas/'.$pegawai->nip.'/profile_pdf')}}" >
            <span>
                <span class="icon"><i class="fa fa-print"></i></span>
                <span>Unduh Profil</span>
            </span>
        </a>
    </div>
    <div class="col col-sm-3">
        <a class="btn btn-primary w-100" href="{{url('pegawai/berkas/'.$pegawai->nip.'/berkas_zip')}}" >
            <span>
                <span class="icon"><i class="fa fa-download"></i></span>
                <span>Unduh Berkas</span>
            </span>
        </a>
    </div>
</div>