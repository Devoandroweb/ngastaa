@if($Rjabatan == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Jabatan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Jabatan</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" novalidate action="{{route('pegawai.jabatan.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf
    @if($Rjabatan != null)
        <input type="hidden" name="id" value="{{$Rjabatan->id}}">
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="customRadioc1" name="is_akhir" value="1" class="form-check-input" {{$Rjabatan?->is_akhir == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="customRadioc1">Jabatan Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="customRadioc2" name="is_akhir" value="0" class="form-check-input" {{$Rjabatan?->is_akhir == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="customRadioc2">Riwayat Jabatan</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Jabatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control select2" name="jenis_jabatan" required>
                    <option value="0" selected disabled>Select Jenis Jabatan</option>
                    @if($Rjabatan == null)
                        {!!optionJenisJabatan()!!}
                    @else
                        {!!optionJenisJabatan($Rjabatan->jenis_jabatan)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Divisi Kerja</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control jabatanDivisi" id=""  name="kode_skpd" required disabled>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jabatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control jabatanTingkat" id="" name="kode_tingkat" required disabled>

                </select>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label class="form-label">No Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('no_sk') is-invalid @enderror" placeholder="Masukkan No SK" name="no_sk" type="number" value="{{$Rjabatan->no_sk ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_sk') is-invalid @enderror" placeholder="Masukkan Tanggal SK" name="tanggal_sk" type="text" value="{{formatDateIndo($Rjabatan->tanggal_sk ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_tmt') is-invalid @enderror" placeholder="Masukkan Tanggal SK" name="tanggal_tmt" type="text" value="{{formatDateIndo($Rjabatan->tanggal_tmt ?? null)}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_tmt') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Dokumen</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file') is-invalid @enderror" placeholder="" name="file" type="file" >
            </div>
        </div>
    </div>

    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
