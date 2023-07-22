<div class="form-group">
    <label class="form-label">Pilih Bulan</label>
    <select class="form-control" id="bulan" name="bulan" required>
        {!!GenerateOptionMont($data?->bulan)!!}
    </select>
</div>
<div class="form-group">
    <label class="form-label">Pilih Tahun</label>
    <select class="form-control" id="tahun" name="tahun" required>
        {!!GenerateOptionYear($data?->tahun)!!}
    </select>
</div>
