<div class="row">
    <div class="col-4 mb-2">
        <div class="form-check">
            <input type="radio" {{$hariJamKerja ?? 'checked' }} class="form-check-input checked-type-{{$day}}" value="0" data-day="{{$day}}" name="filler_{{$day}}" id="nothing-{{$day}}">
            <label class="form-check-label"  for="nothing-{{$day}}">Tidak ada</label>
        </div>
    </div>
    <div class="col-4 mb-2">
        <div class="form-check">
            <input type="radio" class="form-check-input checked-type-{{$day}}" {{$hariJamKerja?->tipe == 1 ? 'checked' : '' }} value="1" data-day="{{$day}}" name="filler_{{$day}}" id="copy-{{$day}}">
            <label class="form-check-label"  for="copy-{{$day}}">Copy dari hari lain</label>
        </div>
    </div>
    <div class="col-4 mb-2">
        <div class="form-check">
            <input type="radio" class="form-check-input checked-type-{{$day}}" {{$hariJamKerja?->tipe == 2 ? 'checked' : '' }} value="2" data-day="{{$day}}" name="filler_{{$day}}" id="custom-{{$day}}">
            <label class="form-check-label"  for="custom-{{$day}}">Tentukan</label>
        </div>
    </div>
</div>
<div class="copy-other-day-{{$day}}">
    <div class="form-group has-validation">
        <label class="form-label">Copy dari hari apa?<span class="text-danger">*</span></label>
        <select name="copy-other-day-{{$day}}" id="select-copy-other-day-{{$day}}" data-day="{{$day}}" class="form-control">
            @for ($i=1; $i <= 7 ; $i++)
                @if($i != $day)
                    @if($hariJamKerja)
                        <option value="{{$i}}" {{($i==1||$hariJamKerja?->parent==$i)?'selected':''}}>{{hari($i)}}</option>
                        @else
                        <option value="{{$i}}">{{hari($i)}}</option>
                    @endif
                @endif
            @endfor
        </select>
    </div>
</div>
<div class="form-clock-{{$day}}">
<div class="row">
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Buka Datang  <span class="text-danger">*</span></label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_buka_datang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_buka_datang ?? null}}" name="jam_buka_datang[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">

            <label class="form-label">Jam Tepat Datang {{$day}}<span class="text-danger">*</span></label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_datang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tepat_datang ?? null}}" name="jam_tepat_datang[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Tutup Datang<span class="text-danger">*</span></label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_datang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tutup_datang ?? null}}" name="jam_tutup_datang[]">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group has-validation">
        <label class="form-label">Toleransi Datang</label>
        <input class="form-control mb-3 @error('toleransi_datang') is-invalid @enderror" type="number" value="{{$hariJamKerja?->toleransi_datang ?? ''}}" placeholder="Masukkan Toleransi Datang" name="toleransi_datang[]" value="">
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Buka Istirahat</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_buka_istirahat') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_buka_istirahat ?? null}}" name="jam_buka_istirahat[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Tepat Istirahat</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_istirahat') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tepat_istirahat ?? null}}" name="jam_tepat_istirahat[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Tutup Istirahat</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_istirahat') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tutup_istirahat ?? null}}" name="jam_tutup_istirahat[]">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group has-validation">
        <label class="form-label">Toleransi Istirahat</label>
        <input class="form-control mb-3 @error('toleransi_istirahat') is-invalid @enderror" type="number" value="{{$hariJamKerja?->toleransi_istirahat ?? null}}" placeholder="Masukkan Toleransi Istirahat" name="toleransi_istirahat[]" value="">
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Buka pulang</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_buka_pulang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_buka_pulang ?? null}}" placeholder="" name="jam_buka_pulang[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Tepat pulang</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_pulang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tepat_pulang ?? null}}" placeholder="" name="jam_tepat_pulang[]">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group has-validation">
            <label class="form-label">Jam Tutup pulang</label>
            <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_pulang') is-invalid @enderror" type="text" value="{{$hariJamKerja?->jam_tutup_pulang ?? null}}" placeholder="" name="jam_tutup_pulang[]">
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group has-validation">
        <label class="form-label">Toleransi pulang</label>
        <input class="form-control mb-3 @error('toleransi_pulang') is-invalid @enderror" type="number" value="{{$hariJamKerja?->toleransi_pulang ?? null}}" placeholder="Masukkan Toleransi pulang" name="toleransi_pulang[]" value="">
    </div>
</div>
</div>
