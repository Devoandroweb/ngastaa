@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Lokasi Visit</h2>
    @if(!is_null($visit->id))
        {{ Breadcrumbs::render('edit-lokasi-visit') }}
    @else
        {{ Breadcrumbs::render('tambah-lokasi-visit') }}
    @endif
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.visit.store')}}" method="post">
    @csrf
    @if(!is_null($visit->id))
        <input type="hidden" name="id" value="{{$visit->id}}">
    @endif
    <div class="row">
        <div class="col-md-12">
            <form class="edit-post-form">
                <div class="form-group has-validation">
                    <label class="form-label">Nama Lokasi</label>
                    <input class="form-control @error('nama') is-invalid @enderror"  placeholder="Masukkan Nama Lokasi" name="nama" value="{{$visit->nama ?? ''}}">
                    <div class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </div>
                </div>
                {{-- maps --}}
                <div id="map" class="mb-4" style="height: 500px"></div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Koordinat</label>
                            <input class="form-control" name="kordinat" id="koordinat" placeholder="Masukkan Koordinat" value="{{$visit->kordinat ?? ''}}">
                        </div>
                    </div>
                    <div class="col d-none">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="customRange1" class="form-label">Jarak Wilayah (m)</label>
                                <input type="range" min="100" max="5000" value="{{$visit->jarak ?? '0'}}" name="jarak" class="form-range" id="radius" >
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label"></label>
                                <input class="form-control" id="radius_count" value="{{$visit->jarak ?? '0'}}">
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    if(!is_null($visit->id)):
                        $lglt = explode(",",$visit->kordinat);
                    endif
                @endphp
                <input type="hidden" name="latitude" id="latitude" value="{{isset($lglt[0]) ?? ''}}">
                <input type="hidden" name="longitude" id="longitude" value="{{isset($lglt[1]) ?? ''}}">
                <input type="hidden" name="polygon" id="polygon" value="{{$visit->polygon ?? ''}}">
                {{-- end maps --}}
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>    
                <a href="{{route('master.visit.index')}}" class="btn btn-light">Kembali</a>
            </form>
        </div>
    </div>
</form>

@endsection
@push('js')
<script>
    var ltlgOld = ('{{$visit->kordinat ?? '-8.1277966,112.7509655'}}').split(",");
    var htmlSelctPegawai = "{!!includeAsJsString('pages/masterdata/datapresensi/lokasikerja/select-pegawai')!!}";
    $(".element-keterangan").html(htmlSelctPegawai);
	// $(".select2").select2("destroy").select2();
	
    $("#input_tags_pwgawai").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        placeholder: "Pilih Pegawai",
        // allowClear: true
    });
</script>
<script src="{{asset('/')}}maps.js"></script>
@endpush