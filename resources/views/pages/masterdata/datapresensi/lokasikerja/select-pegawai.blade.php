
<div class="form-group">
    <label class="form-label">Pilih Pegawai</label>
    <select class="form-control" id="input_tags_pegawai" name="keterangan[]"  multiple="multiple" required>
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
            <option value="{{json_encode($json)}}">{{$s->name}}</option>
        @endforeach
    </select>
    
</div>