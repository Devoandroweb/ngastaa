@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tingkat Jabatan</h2>
    {{ Breadcrumbs::render('tambah-tingkat-jabatan') }}
@endsection

@section('content')

<form class="edit-post-form" action="{{route('master.tingkat.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Divisi Kerja</label>
                <select class="form-control select2" name="kode_skpd" required>
                    <option selected disabled>Select Divisi Kerja</option>
                    @foreach($skpd as $s)
                        <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Jabatan</label>
                <select class="form-control select2" name="jenis_jabatan" required>
                    <option selected disabled>Select Jenis Jabatan</option>
                    @foreach($jenisJabatan as $s)
                        <option value="{{$s['value']}}">{{$s['label']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group has-validation">
                    <label class="form-label">Kode Jabatan</label>
                    <input class="form-control" name="kode_tingkat"  placeholder="Masukkan Kode Tingkat">
            </div>
            <div class="form-group has-validation">
                <label class="form-label">Nama Jabatan</label>
                <input class="form-control" name="nama"  placeholder="Masukkan Kode Tingkat">
            </div>
            <div class="form-group">
                <label class="form-label">Level Jabatan</label>
                <select class="form-control select2" name="kode_eselon" required>
                    <option selected disabled>Select Level Jabatan</option>
                    @foreach($eselon as $s)
                        <option value="{{$s->kode_eselon}}">{{$s->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group has-validation">
                <label class="form-label">Gaji Pokok</label>
                <input class="form-control numeric" name="gaji_pokok"  placeholder="Masukkan Gaji Pokok">
            </div>
            <div class="form-group has-validation">
                <label class="form-label">Tunjangan Jabatan</label>
                <input class="form-control numeric" name="tunjangan"  placeholder="Masukkan Tunjangan Jabatan">
            </div>
            <div class='alert alert-danger'>Lokasi Tidak Wajib ditentukan, Akan tetapi jika di tentukan maka berdasarkan prioritas mulai dari lokasi per pegawai, jabatan, level jabatan, divisi kerja dan terakhir lokasi kerja, jadi jika kordinat kosong di data pegawai akan mencari ke jabatan, jika jabatan kosong akan mencari ke level jabatan, jika di level jabatan kosong akan mencari ke divisi kerja dan jika semuanya kosong maka akan mencari data lokasi kerja dan jika lokasi kerja kosong maka presensi tidak bisa dilakukan </div>
            <div id="map" class="mb-4" style="height: 500px"></div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="form-label">Koordinat</label>
                        <input class="form-control" name="kordinat" id="koordinat" placeholder="Masukkan Koordinat">
                    </div>
                </div>
                <div class="col d-none">
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="customRange1" class="form-label">Jarak Wilayah (m)</label>
                            <input type="range" min="100" max="5000" value="100" name="jarak" class="form-range" id="radius">
                        </div>
                        <div class="form-group col-2">
                            <label class="form-label"></label>
                            <input class="form-control" id="radius_count" value="100">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-save">Simpan</button>
            <a href="{{route('master.tingkat.index')}}" class="btn btn-light">Kembali</a>

        </div>
    </div>

</form>

@endsection
@push("js")
<script>
    var ltlgOld = [-8.1093477,112.7086424]

    disableButtonSave()
    var debounce = null;
    $('input[name=kode_tingkat]').on('keyup', function(e){
        $dom = $(this);
        if($dom.val() == ""){
            disableButtonSave();
            return false;
        }
        clearTimeout(debounce );
        debounce = setTimeout(function(){
            $.ajax({
                type: "post",
                url: "{{route('master.tingkat.checkKodeTingkat')}}",
                data: {kode_tingkat:$dom.val()},
                dataType: "json",
                success: function (response, statusText, xhr) {
                    $dom.removeClass('is-invalid')
                    $dom.siblings('.invalid-feedback').remove()
                    if(xhr.status == 201){
                        $dom.addClass('is-invalid');
                        $dom.after(`<div class="invalid-feedback">${response.msg}</div>`);
                        disableButtonSave();
                    }else if(xhr.status == 200){
                        enableButtonSave();
                    }
                }
            });

        }, 100);
    });




</script>
<script src="{{asset('/')}}maps.js"></script>

@endpush
