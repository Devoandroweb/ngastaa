
<div class="form-group">
    <label class="form-label">Presentase dari</label>
    <select class="form-control" id="input_tags_presentase" name="kode_persen[]"  multiple="multiple" required>

        @foreach(\App\Models\Master\Payroll\Tunjangan::get() as $s)
        @php
            $json = [
                "value" => $s->kode_tunjangan,
                "label" => $s->nama,
                "kode_tunjangan" => $s->kode_tunjangan
            ];
        @endphp
            <option value="{{json_encode($json)}}">{{$s->nama}}</option>

        @endforeach
    </select>
    <p class="text-danger"><b>Persen</b> akan di hitung dari presentase <b>Gaji Pokok</b></p>
</div>
