
<div class="form-group">
    <label class="form-label">Pilih Pegawai</label>
    <select class="form-control" id="input_tags_pegawai" name="keterangan[]"  multiple="multiple" required>
        @php
            function searchId($id,$data)
            {
                foreach ($data as $item):
                    if($item['id'] == $id):
                        return true;
                    endif;
                endforeach;
                return false;
            }    
        @endphp
        @foreach(\App\Models\User::role('pegawai')->orderBy('name')->get() as $s)
        @php
            $json = [
                "value" => $s->nip,
                "label" => $s->name,
                "kode_suku" => $s->kode_suku,
                "kode_status" => $s->kode_status,
                "nip" => $s->nip,
            ];
        @endphp
            @if(searchId($s->id,$data))
                <option selected value="{{json_encode($json)}}">{{$s->name}}</option>
            @else
                <option value="{{json_encode($json)}}">{{$s->name}}</option>
            @endif
        @endforeach
    </select>
</div>