

<div class="form-group">
    <label class="form-label">Pilih Divisi</label>
    <select class="form-control" id="input_tags_divisi" name="keterangan" required>

        @foreach(\App\Models\Master\Skpd::orderBy('nama')->get() as $s)
        @if($data != null)
            {{-- {{dd($data)}} --}}
            @if($data->kode_skpd == $s->kode_skpd)
                    <option selected value="{{$s->kode_skpd}}">{{$s->nama}}</option>
            @else
                <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
            @endif
        @else
            <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
        @endif
        @endforeach
    </select>
</div>
