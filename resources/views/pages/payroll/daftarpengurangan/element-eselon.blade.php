<div class="form-group">
    <label class="form-label">Pilih Level</label>
    <select class="form-control eselon" name="kode_keterangan" required>

        @foreach (\App\Models\Master\Eselon::orderBy('nama')->get() as $s)
            @php
            $json = [
                "value" => $s->kode_eselon,
                "label" => $s->nama,
                "kode_eselon" => $s->kode_eselon,
            ];
        @endphp
        @if ($data != null)
            @if($s->kode_eselon == $data)
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
