
<div class="form-group">
    <label class="form-label">Sumber Potongan</label>
    <select class="form-control" id="input_tags_kode_tunjangan" name="kode_tunjangan[]"  multiple="multiple" required>
        @php
            function searchId($kode_tunjangan,$tunjangan)
            {
                foreach ($tunjangan as $item):
                    if($item->kode_tunjangan == $kode_tunjangan):
                        return true;
                    endif;
                endforeach;
                return false;
            }    
        @endphp
        @foreach($tunjanganAll as $s)
        @php
            $json = [
                "value" => $s->kode_tunjangan,
                "label" => $s->nama,
                "kode_tunjangan" => $s->kode_tunjangan
            ];
        @endphp
            @if(searchId($s->kode_tunjangan,$tunjangan))
                <option selected value="{{json_encode($json)}}">{{$s->nama}}</option>
            @else
                <option value="{{json_encode($json)}}">{{$s->nama}}</option>
            @endif
        @endforeach
    </select>
</div>