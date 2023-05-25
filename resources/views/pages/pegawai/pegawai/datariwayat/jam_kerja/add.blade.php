@if(!isset($front))
@if($RJamKerja == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Jam Kerja</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Jam Kerja</h4>
    <div class="line-text"></div>
</div>
@endif
@endif
<form class="edit-post-form" action="{{route('pegawai.jam_kerja.store',$pegawai->nip)}}?for={{$for}}{{(isset($front)) ? $front : '' }}" method="post">
    @csrf
    @if($RJamKerja != null)
    <input type="hidden" name="id" value="{{$RJamKerja->id}}">
    @endif
    <div class="row mb-3 {{(isset($front)) ? 'd-none' : '' }}">
        <div class="col-md-4">
            <label class="form-label">Status<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="jam_kerja_aktif" name="is_akhir" value="1" class="form-check-input" {{$RJamKerja?->is_akhir == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="jam_kerja_aktif">Aktif</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="jam_kerja_tidak_aktif" name="is_akhir" value="0" class="form-check-input" {{$RJamKerja?->is_akhir == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="jam_kerja_tidak_aktif">Tidak Aktif</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jam Kerja<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control jamKerja" name="kode_jam_kerja" required>
                    <option selected disabled>Select Jam Kerja</option>

                </select>

            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    @if(!isset($front))
    <button type="button" class="btn btn-light btn-back">Kembali</button>
    @else
    <a href="{{route("pegawai.pegawai.index")}}" class="btn btn-light">Kembali</a>
    @endif

</form>
