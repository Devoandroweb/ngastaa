<div class="form-group">
    <label class="form-label">Pilih Level</label>
    <select class="form-control skpd" name="kode_keterangan" required>
        
        @foreach (\App\Models\Master\Skpd::orderBy('nama')->get(); as $s)
        @php
            $json = [
                "value" => $s->kode_skpd,
                "label" => $s->nama,
                "kode_skpd" => $s->kode_skpd,
            ];
        @endphp
        @if ($data != null)
            @if(searchId($s->id,$data))
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