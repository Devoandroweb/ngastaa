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
                        <label class="form-label">Nomor Induk Pegawai</label>
                        <input class="form-control @error('nip') is-invalid @enderror"  placeholder="Masukkan Kode Pegawai" value="{{old('nip')}}" name="nip">
                        <div class="invalid-feedback">
                            {{ $errors->first('nip') }}
                        </div>
                    </div>

                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">NIK</label>
                        <input class="form-control @error('nik') is-invalid @enderror"  placeholder="Masukkan NIK" name="nik" value="{{old('nik')}}">
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
                        <input class="form-control @error('name') is-invalid @enderror"  placeholder="Masukkan Nama Lengkap" name="name" value="{{old('name')}}">
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Depan</label>
                        <input class="form-control @error('gelar_depan') is-invalid @enderror"  placeholder="Masukkan Gelar Depan" name="gelar_depan" value="{{old('gelar_depan')}}">
                        <div class="invalid-feedback">
                            {{ $errors->first('gelar_depan') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Gelar Belakang</label>
                        <input class="form-control @error('gelar_belakang') is-invalid @enderror"  placeholder="Masukkan Gelar Belakang" name="gelar_belakang" value="{{old('gelar_belakang')}}">
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
                        <input class="form-control @error('tempat_lahir') is-invalid @enderror"  placeholder="Masukkan Tempat Lahir" name="tempat_lahir" value="{{old('tempat_lahir')}}">
                        <div class="invalid-feedback">
                            {{ $errors->first('tempat_lahir') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control datepicker-single @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{old('tanggal_lahir') ?? date('d-m-Y')}}">
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
                            <option value="perempuan" {{old('jenis_kelamin') == "perempuan" ? 'selected' : ''}}>Perempuan</option>
                            <option value="laki-laki" {{old('jenis_kelamin') == "laki-laki" ? 'selected' : ''}}>Laki-Laki</option>
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
                            {!!optionAgama(old('kode_agama'))!!}
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
                            {!!optionStatusPegawai(old('kode_status'))!!}
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
                            {!!optionStatusKawin(old('kode_kawin'))!!}
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
                    {!!optionGolonganDarah(old('golongan_darah'))!!}
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
                        <textarea name="alamat" id="" cols="30" rows="5" class="form-control">{{old('alamat')}}</textarea>
                        <div class="invalid-feedback">
                            {{ $errors->first('alamat') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Alamat Sesuai KTP</label>
                        <textarea name="alamat_ktp" id="" cols="30" rows="5" class="form-control">{{old('alamat_ktp')}}</textarea>
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
                        <input class="form-control @error('no_hp') is-invalid @enderror"  placeholder="Masukkan No Telepon atau Whatsapp" name="no_hp" value="{{old('no_hp')}}">
                        <div class="invalid-feedback">
                            {{ $errors->first('no_hp') }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"  placeholder="Masukkan Email" name="email"  value="{{old('email')}}">
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    </div>
                </div>
            </div>
            @if(role('owner') || role('admin'))
            <div class="hk-pg-header pg-header-wth-tab pt-7 pb-2 mb-2">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h5>Divisi dan Jabatan</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <label class="form-label">Divisi Kerja</label>
                    <div class="form-group has-validation">
                        <select class="form-control jabatanDivisi" id=""  name="kode_skpd" required disabled>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <label class="form-label">Jabatan</label>
                    <div class="form-group">
                        <select class="form-control jabatanTingkat" id="" name="kode_tingkat" required disabled>

                        </select>

                    </div>
                </div>
            </div>
            @endif
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
    @if(role('owner') || role('admin'))
        initDevisi("{{old('kode_skpd')}}","{{old('kode_tingkat')}}");
        // initDevisi(data.kode_skpd,data.kode_tingkat);
        /* JABATAN */
        function initDevisi(value_divisi = null,value_tingkat = null){
            let getDivisi = (url) => {
                var element = $('.jabatanDivisi');
                let loading = loadingProccesText(element)
                $.ajax({url: url, success: function(data){
                    element.empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: item['label'],
                            id: item['kode_skpd'],
                        }
                    })

                    if(value_divisi == null && data.length != 0){
                        value_divisi = data[0].id;
                    }

                    element.removeAttr("disabled")
                    element.select2({
                        placeholder:"Pilih Divisi atau ketik disini",
                        data : data
                    }).val(value_divisi).change(function(){
                        getTingkat("{{url('master/tingkat/json')}}/"+$(this).val(),value_tingkat);
                    }).trigger("change");

                }});
            }
            getDivisi("{{route('master.skpd.json')}}")
        }
        let getTingkat = (url,value_tingkat = null) => {
            let element = $('.jabatanTingkat');
            element.prop('disabled', true)
            let loading = loadingProccesText(element)
            $.ajax({url: url, success: function(data){
                element.empty()
                clearInterval(loading)
                initTingkat(data,value_tingkat,element)
            }})
        }
        function initTingkat(data, value_tingkat,element = null){
            var data = $.map(data, function (item) {
                return {
                    text: item['label'],
                    id: item['value'],
                }
            })

            if(value_tingkat == null && data.length != 0){
                value_tingkat = data[0].id;
            }
            element.removeAttr("disabled")
            element.select2({
                placeholder:"Pilih Jabatan atau ketik disini",
                data : data
            }).val(value_tingkat).trigger("change");
        }
        /* END JABATAN */
    @endif
</script>
@endpush
