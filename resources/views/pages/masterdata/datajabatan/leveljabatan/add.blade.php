@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Level Jabatan</h2>
    {{ Breadcrumbs::render('tambah-level-jabatan') }}
@endsection

@section('content')
<form class="edit-post-form" action="{{route('master.eselon.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Level</label>
                <input type="number" class="form-control @error('kode_eselon') is-invalid @enderror"  placeholder="Masukkan Kode Level" name="kode_eselon">
                <div class="invalid-feedback">
                    {{ $errors->first('kode_eselon') }}
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Nama Level</label>
                <input class="form-control"  placeholder="Masukkan Nama Level" value="{{old('nama')}}" name="nama">
            </div>
        </div>
        
    </div>
    {{-- maps --}}
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
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
    <input type="hidden" name="polygon" id="polygon">
    {{-- end maps --}}
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.eselon.index')}}" class="btn btn-light">Kembali</a>
</form>
@endsection
@push('js')
<script>
    var ltlgOld = ("-8.1277966,112.7509655").split(",");
</script>
<script src="{{asset('/')}}maps.js"></script>
@endpush