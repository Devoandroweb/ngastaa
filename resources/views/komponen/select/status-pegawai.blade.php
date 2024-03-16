<label class="form-label">Status Kepegawaian</label>
<div class="form-group has-validation">
    <select class="form-control select2 statusPegawai" id=""  name="status_pegawai">
        @foreach (\App\Models\Master\StatusPegawai::all() as $statusPegawai)
            <option value="{{$statusPegawai->nama}}">{{$statusPegawai->nama}}</option>
        @endforeach
    </select>
</div>
