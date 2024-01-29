<select name="{{$name}}" class="form-control select2 px-2" id="">
    <option selected disabled value="0">Pilih Tingkat Jabatan</option>
    @foreach (\App\Models\Master\Tingkat::orderBy('nama','asc')->get() as $s)
        <option value="{{$s->kode_tingkat}}">{{$s->nama}}</option>
    @endforeach
</select>
