<div class="form-group">
    <label class="form-label">Pilih Jabatan</label>
    <select class="form-control tingkat-jabatan" name="kode_keterangan" required>

        @foreach (\App\Models\Master\Tingkat::orderBy('nama')->get() as $s)
            @php
            $json = [
                "value" => $s->kode_tingkat,
                "label" => $s->nama,
                "kode_tingkat" => $s->kode_tingkat,
            ];
        @endphp
        @if ($data != null)
            @if($s->kode_tingkat==$data)
                <option selected value="{{json_encode($json)}}">{{$s->nama}}</option>
            @else
                <option value="{{json_encode($json)}}">{{$s->nama}}</option>
            @endif
        @else
            <option value="{{json_encode($json)}}">{{$s->nama}}</option>
        @endif
        @endforeach
    </select>
</div>
