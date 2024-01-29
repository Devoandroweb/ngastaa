<select name="{{$name}}" class="form-control select2 px-2" id="">
    <option selected disabled value="0">Pilih Divisi</option>
    @foreach (\App\Models\Master\Skpd::orderBy('kode_skpd','asc')->get() as $s)
        <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
    @endforeach
</select>
