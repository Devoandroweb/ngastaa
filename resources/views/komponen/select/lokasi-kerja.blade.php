<label class="form-label">Lokasi Kerja</label>
<div class="form-group has-validation">
    <select class="form-control select2 lokasiKerja" id=""  name="kode_lokasi">
        @foreach (\App\Models\Master\Lokasi::all() as $lokasi)
            <option value="{{$lokasi->kode_lokasi}}">{{$lokasi->nama}}</option>
        @endforeach
    </select>
</div>
