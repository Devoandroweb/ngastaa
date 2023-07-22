<div class="form-group">
    <label class="form-label">Pilih Divisi</label>
    <select class="form-control skpd" name="kode_keterangan" required>

        @foreach (\App\Models\Master\Skpd::orderBy('nama')->get() as $s)
        @php
            // dd($data);
            $json = [
                "value" => $s->kode_skpd,
                "label" => $s->nama,
                "kode_skpd" => $s->kode_skpd,
            ];
        @endphp
        @if ($data != null)
            @if($s->kode_skpd == $data)
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
