
<div class="form-group">
    <label class="form-label">Presentase dari</label>
    <select class="form-control" id="input_tags_presentase" name="kode_persen[]"  multiple="multiple" required>
        @php
            function searchId($kode_tunjangan,$data)
            {
                foreach ($data as $item):
                    if($item->kode_tunjangan == $kode_tunjangan):
                        return true;
                    endif;
                endforeach;
                return false;
            }    
        @endphp
        @foreach(\App\Models\Master\Payroll\Tunjangan::get() as $s)
        @php
            $json = [
                "value" => $s->kode_tunjangan,
                "label" => $s->nama,
                "kode_tunjangan" => $s->kode_tunjangan
            ];
        @endphp
            @if(searchId($s->kode_tunjangan,$data))
                <option selected value="{{json_encode($json)}}">{{$s->nama}}</option>
            @else
                <option value="{{json_encode($json)}}">{{$s->nama}}</option>
            @endif
        @endforeach
    </select>
</div>