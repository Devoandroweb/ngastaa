
<div class="form-group">
    <label class="form-label">Pilih Pegawai</label>
    <select class="form-control pegawai" name="kode_keterangan[]"  multiple="multiple" required>
        
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
        @if ($data != null)
            @if(searchId($s->nip,$data))
                <option selected value="{{json_encode($json)}}">{{$s->name}}</option>
            @else
                <option value="{{json_encode($json)}}">{{$s->name}}</option>
            @endif
        @else
            <option value="{{json_encode($json)}}">{{$s->name}}</option>
        @endif
            
        @endforeach
    </select>
    
</div>
