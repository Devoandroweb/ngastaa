@section('breadcrumps')
    {{-- {{ Breadcrumbs::render('status-pegawai') }} --}}
    <h4>Edit Pegawai</h4>
@endsection
@section('content')
<form class="edit-post-form" action="{{route('pegawai.pegawai.store')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="hk-pg-header pg-header-wth-tab pb-2 mb-2">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h5>Informasi Data Diri</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Kode Pegawai</label>
                        <input class="form-control @error('nip') is-invalid @enderror" value="{{$pegawai->nip}}" placeholder="Masukkan Kode Pegawai" name="nip">
                        <div class="invalid-feedback">
                            {{ $errors->first('nip') }}
                        </div>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">NIK</label>
                        <input class="form-control @error('nik') is-invalid @enderror" value="{{$pegawai->nik}}" placeholder="Masukkan NIK" name="nik">
                        <div class="invalid-feedback">
                            {{ $errors->first('nik') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-validation">
                        <label class="form-label">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror" value="{{$pegawai->name}}" placeholder="Masukkan Nama Lengkap" name="name">
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Depan</label>
                        <input class="form-control @error('gelar_depan') is-invalid @enderror" value="{{$pegawai->gelar_depan}}" placeholder="Masukkan Gelar Depan" name="gelar_depan">
                        <div class="invalid-feedback">
                            {{ $errors->first('gelar_depan') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Belakang</label>
                        <input class="form-control @error('gelar_belakang') is-invalid @enderror" value="{{$pegawai->gelar_belakang}}" placeholder="Masukkan Gelar Belakang" name="gelar_belakang">
                        <div class="invalid-feedback">
                            {{ $errors->first('gelar_belakang') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Tempat Lahir</label>
                        <input class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{$pegawai->tempat_lahir}}" placeholder="Masukkan Tempat Lahir" name="tempat_lahir">
                        <div class="invalid-feedback">
                            {{ $errors->first('tempat_lahir') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{$pegawai->tanggal_lahir}}" name="tanggal_lahir">
                        <div class="invalid-feedback">
                            {{ $errors->first('tanggal_lahir') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror"  name="jenis_kelamin"  id="">
                            @if($pegawai->gelar_belakang == 'perempuan')
                                <option selected value="perempuan">Perempuan</option>
                                <option value="laki-laki">Laki-Laki</option>
                            @elseif($pegawai->gelar_belakang == 'laki-laki')
                                <option value="perempuan">Perempuan</option>
                                <option selected value="laki-laki">Laki-Laki</option>
                            @else
                                <option value="perempuan">Perempuan</option>
                                <option value="laki-laki">Laki-Laki</option>
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('jenis_kelamin') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Agama</label>
                        <select class="form-control @error('kode_agama') is-invalid @enderror" name="kode_agama"  id="">
                            {!!optionAgama($pegawai->kode_agama)!!}
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('kode_agama') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Status Pegawai</label>
                        <select class="form-control @error('kode_status') is-invalid @enderror" name="kode_status"  id="">
                            {!!optionStatusPegawai($pegawai->kode_status)!!}
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('kode_status') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Status Pernikahan</label>
                        <select class="form-control @error('kode_kawin') is-invalid @enderror" name="kode_kawin"  id="">
                            {!!optionStatusKawin($pegawai->kode_kawin)!!}
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('kode_kawin') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group  has-validation">
                <label class="form-label">Golongan Darah</label>
                <select class="form-control @error('golongan_darah') is-invalid @enderror" name="golongan_darah"  id="">
                    {!!optionGolonganDarah($pegawai->golongan_darah)!!}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('golongan_darah') }}
                </div>
            </div>
            <div class="hk-pg-header pg-header-wth-tab pt-7 pb-2 mb-2">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h5>Informasi Alamat</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Alamat Domisili</label>
                        <textarea name="alamat" id="" cols="30" rows="5" class="form-control">{{$pegawai->alamat}}</textarea>
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Alamat Sesuai KTP</label>
                        <textarea name="alamat_ktp" id="" cols="30" rows="5" class="form-control">{{$pegawai->alamat_ktp}}</textarea>
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat_ktp') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="hk-pg-header pg-header-wth-tab pt-7 pb-2 mb-2">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h5>Informasi Kontak</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">No Telepon / WA</label>
                        <input class="form-control @error('no_hp') is-invalid @enderror" value="{{$pegawai->no_hp}}"  placeholder="Masukkan No Telepon atau Whatsapp" name="no_hp">
                        <div class="invalid-feedback">
                            {{ $errors->first('no_hp') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" value="{{$pegawai->email}}"  placeholder="Masukkan Email" name="email">
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light ">Kembali</button>

</form>
@endsection
@push('js')
<script>
    $("select").select2();
</script>    
@endpush
