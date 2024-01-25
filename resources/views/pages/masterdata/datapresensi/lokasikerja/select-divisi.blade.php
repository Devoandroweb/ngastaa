<div class="form-group">
    <label class="form-label">untuk Divisi apa?</label>
    <select class="form-control" id="input_tags_divisi" name="keterangan" required>
        @php
            $skpd = \App\Models\Master\Skpd::orderBy('nama')->get();
            // SelectResource::withoutWrapping();
            // $skpd = SelectResource::collection($skpd);
        @endphp
        @foreach($skpd as $s)
            <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
        @endforeach
    </select>

</div>
