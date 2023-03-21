
<div class="mb-2 text-end">
    <a href="{{route('pegawai.kordinat.reset',$pegawai->nip)}}" class="btn btn-primary btn-reset-koor"> {{__('Reset')}}</a>
</div>
<form id="form-koor" class="edit-post-form" action="{{route('pegawai.kordinat.store',$pegawai->nip)}}" method="post">
    @csrf
    <input type="hidden" name="values[id]" value="{{$pegawai->id}}">

    <div class="row">
        <div class="col-md-12">
            
                <div class="element-keterangan"></div>
                {{-- maps --}}
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Koordinat</label>
                            <input class="form-control" value="{{$pegawai->kordinat}}" name="kordinat[kordinat]" id="koordinat" placeholder="Masukkan Koordinat">
                        </div>
                    </div>
                    <div class="col d-none">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="customRange1" class="form-label">Jarak Wilayah (m)</label>
                                <input type="range" min="100" max="5000" value="{{$pegawai->jarak}}" name="kordinat[jarak]" class="form-range" id="radius">
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label"></label>
                                {{-- <input class="form-control" name="radius" id="radius_count" value="0"> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" class="mb-4" style="height: 500px"></div>
                <input type="hidden" name="latitude" value="{{$pegawai->latitude}}" id="latitude">
                <input type="hidden" name="longitude" value="{{$pegawai->longitude}}" id="longitude">
                {{-- end maps --}}
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
                <button type="button" class="btn btn-light btn-back">Kembali</button>

                
        </div>
    </div>
</form>
