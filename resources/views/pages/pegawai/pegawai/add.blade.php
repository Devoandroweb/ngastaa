@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Data Pegawai</h2>
    {{ Breadcrumbs::render('tambah-pegawai') }}
    {{-- <h1>Data Pegawai <small class="text-muted">/ Tambah Pegawai</small> </h1> --}}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('pegawai.pegawai.store')}}" method="post">
    @csrf
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
                        <input class="form-control @error('nip') is-invalid @enderror"  placeholder="Masukkan Kode Pegawai" name="nip">
                        <div class="invalid-feedback">
                            {{ $errors->first('nip') }}
                        </div>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">NIK</label>
                        <input class="form-control @error('nik') is-invalid @enderror"  placeholder="Masukkan NIK" name="nik">
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
                        <input class="form-control @error('name') is-invalid @enderror"  placeholder="Masukkan Nama Lengkap" name="name">
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Depan</label>
                        <input class="form-control @error('gelar_depan') is-invalid @enderror"  placeholder="Masukkan Gelar Depan" name="gelar_depan">
                        <div class="invalid-feedback">
                            {{ $errors->first('gelar_depan') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Belakang</label>
                        <input class="form-control @error('gelar_belakang') is-invalid @enderror"  placeholder="Masukkan Gelar Belakang" name="gelar_belakang">
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
                        <input class="form-control @error('tempat_lahir') is-invalid @enderror"  placeholder="Masukkan Tempat Lahir" name="tempat_lahir">
                        <div class="invalid-feedback">
                            {{ $errors->first('tempat_lahir') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control datepicker-single @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{date('d-m-Y')}}">
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
                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin"  id="">
                            <option value="perempuan">Perempuan</option>
                            <option value="laki-laki">Laki-Laki</option>
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
                            {!!optionAgama()!!}
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
                            {!!optionStatusPegawai()!!}
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
                            {!!optionStatusKawin()!!}
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
                    {!!optionGolonganDarah()!!}
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
                        <textarea name="alamat" id="" cols="30" rows="5" class="form-control"></textarea>
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Alamat Sesuai KTP</label>
                        <textarea name="alamat_ktp" id="" cols="30" rows="5" class="form-control"></textarea>
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
                        <input class="form-control @error('no_hp') is-invalid @enderror"  placeholder="Masukkan No Telepon atau Whatsapp" name="no_hp">
                        <div class="invalid-feedback">
                            {{ $errors->first('no_hp') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"  placeholder="Masukkan Email" name="email">
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('pegawai.pegawai.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
<script>
    initDatePickerSingle();
    $("select").select2();
</script>    
@endpush
