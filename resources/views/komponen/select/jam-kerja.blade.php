<label class="form-label">Jam Kerja</label>
<div class="form-group has-validation">
    <select class="form-control select2 jamKerja" id=""  name="kode_jam_kerja">
        @foreach (\App\Models\MJamKerja::all() as $jamKerja)
            <option value="{{$jamKerja->kode}}">{{$jamKerja->nama}}</option>
        @endforeach
    </select>
</div>
