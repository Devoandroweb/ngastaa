@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Divisi Kerja</h2>
    {{ Breadcrumbs::render('tambah-divisi-kerja') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.skpd.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <form class="edit-post-form">
                <div class="form-group has-validation">
                    <label class="form-label">Kode</label>
                    <input class="form-control @error('kode_skpd') is-invalid @enderror"  placeholder="Masukkan Kode" name="kode_skpd">
                    <div class="invalid-feedback">
                        {{ $errors->first('kode_skpd') }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input class="form-control"   placeholder="Masukkan Nama" name="nama">
                </div>
                <div class="form-group">
                    <label class="form-label">Singkatan</label>
                    <input class="form-control"  placeholder="Masukkan Singkatan" name="singkatan">
                </div>
                {{-- maps --}}

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
                <div id="map" class="mb-4" style="height: 500px"></div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="polygon" id="polygon" value="">
                {{-- end maps --}}
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                <a href="{{route('master.skpd.index')}}" class="btn btn-light btn-back">Kembali</a>
            </form>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    var ltlgOld = ("-8.1277966,112.7509655").split(",");
</script>
<script src="{{asset('/')}}maps.js"></script>
@endpush
