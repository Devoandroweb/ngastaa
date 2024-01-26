@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Lokasi Kerja</h2>
    {{ Breadcrumbs::render('edit-lokasi-kerja') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.lokasi.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="values[id]" value="{{$lokasi->id}}">

    <div class="row">
        <div class="col-md-12">

                <div class="form-group has-validation">
                    <label class="form-label">Kode</label>
                    <input class="form-control @error('kode_lokasi') is-invalid @enderror" value="{{$lokasi->kode_lokasi}}"  placeholder="Masukkan Kode" name="values[kode_lokasi]">
                    <div class="invalid-feedback">
                        {{ $errors->first('kode_lokasi') }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input class="form-control"  placeholder="Masukkan Nama Lokasi" value="{{$lokasi->nama}}" name="values[nama]">
                </div>

                <!-- <div class="form-group">
                    <label class="form-label">Tentukan Shiftnya</label>
                    <select id="select-shift" class="form-control select2 select2-multiple" name="values[kode_shift][]" multiple="multiple" data-placeholder="Select Shift" required>
                        {{-- <option selected disabled>Select Shift</option> --}}
                        @php
                            $arrayShift = json_decode($lokasi->kode_shift);

                        @endphp
                        @foreach($shift as $s)
                            @if (in_array($s->kode_shift,$arrayShift))
                            <option value="{{$s->kode_shift}}" @selected(true)>{{$s->nama}}</option>
                            @else
                            <option value="{{$s->kode_shift}}">{{$s->nama}}</option>
                            @endif
                        @endforeach
                    </select>
                </div> -->
                <div class="form-group d-none">
                    <label class="form-label">Keterangan</label>
                    <select class="form-control select2" name="values[keterangan]" id="values-keterangan" required>
                        <option selected disabled>Select Keterangan</option>
                        @foreach($keterangan as $s)
                            @if($lokasi->keterangan == $s['value'])
                                <option selected value="{{$s['value']}}">{{$s['label']}}</option>
                            @else
                                <option value="{{$s['value']}}">{{$s['label']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="element-keterangan"></div>
                {{-- maps --}}

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Koordinat</label>
                            <input class="form-control" value="{{$lokasi->kordinat}}" name="kordinat[kordinat]" id="koordinat" placeholder="Masukkan Koordinat">
                        </div>
                    </div>
                    <div class="col d-none">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="customRange1" class="form-label">Jarak Wilayah (m)</label>
                                <input type="range" min="100" max="5000" value="{{$lokasi->jarak}}" name="kordinat[jarak]" class="form-range" id="radius">
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label"></label>
                                <input class="form-control" id="radius_count" value="{{$lokasi->jarak}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" class="mb-4" style="height: 500px"></div>
                <input type="hidden" name="kordinat[latitude]" value="{{$lokasi->latitude}}" id="latitude">
                <input type="hidden" name="kordinat[longitude]" value="{{$lokasi->longitude}}" id="longitude">
                <input type="hidden" name="polygon" value="{{$lokasi->polygon}}" id="polygon">
                {{-- end maps --}}
                <button type="submit" class="btn btn-save btn-primary">Simpan</button>
                <a href="{{route('master.lokasi.index')}}" class="btn btn-light">Kembali</a>

        </div>
    </div>
</form>

@endsection
@push('js')
<script>
	// $(".select2").select2("destroy").select2();
    var keterangan = "1";
    var ltlgOld = ("{{$lokasi->kordinat}}").split(",");


    buildKeteranganParent(keterangan)
    // console.log();
    $("#values-keterangan").change(function (e) {
        e.preventDefault();
        const val = $(this).val();
        buildKeteranganParent(val)

    });


    function buildKeteranganParent(val){
        var placeholder = '';
        var idEl = null;
        var htmlSelectPegawai = "";
        var htmlSelectDivisi = "";
        @if($lokasi->keterangan == 1)
            htmlSelectPegawai = "{!!includeAsJsString('pages/masterdata/datapresensi/lokasikerja/select-pegawai-edit',$lokasiDetail)!!}";
        @else
            htmlSelectPegawai = "{!!includeAsJsString('pages/masterdata/datapresensi/lokasikerja/select-pegawai')!!}";
        @endif

        @if($lokasi->keterangan == 3)
            htmlSelectDivisi = "{!!includeAsJsString('pages/masterdata/datapresensi/lokasikerja/select-divisi-edit',$lokasiDetail)!!}";
        @else
            htmlSelectDivisi = "{!!includeAsJsString('pages/masterdata/datapresensi/lokasikerja/select-divisi')!!}";
        @endif


        if(val == 1){
            $(".element-keterangan").html(htmlSelectPegawai);
            idEl = "#input_tags_pegawai";
            placeholder = "Pilih Pegawai";
            // $(idEl).select2("destroy")
            $(idEl).select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: placeholder,
                allowClear: true
            });
        }else if(val == 2){
            $(".element-keterangan").html(`<div class="alert alert-danger">Pilihan ini dalam perbaikan !!</div>`);
            disableButtonSave();
            return;
            // idEl = "#input_tags_pegawai";
            // placeholder = "Pilih Pegawai";
        }else if(val == 3){
            $(".element-keterangan").html(htmlSelectDivisi);
            idEl = "#input_tags_divisi";
            placeholder = "Pilih Divisi";
            // $(idEl).select2("destroy")
            $(idEl).select2({
                placeholder: placeholder,
                allowClear: true
            });
        }
        enableButtonSave();

    }
</script>
<script src="{{asset('/')}}maps.js"></script>
@endpush
