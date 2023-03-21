@if($Rkursus == null)
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
<form class="edit-post-form" action="{{route('pegawai.kursus.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rkursus != null)
        <input type="hidden" name="id" value="{{$Rkursus->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Kursus<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control namaKursus" name="kode_kursus" required>
                    
                </select>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="Masukkan Tempat" name="tempat" value="{{$Rkursus->tempat ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Pelaksana<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="Pelaksana" name="pelaksana" value="{{$Rkursus->pelaksana ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Angkatan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="Angkatan" name="angkatan" value="{{$Rkursus->angkatan ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" type="text" value="{{formatDateIndo($Rkursus->tanggal_mulai ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Selesai" name="tanggal_selesai" type="text" value="{{formatDateIndo($Rkursus->tanggal_selesai ?? null)}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_selesai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jumlah Jp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 " placeholder="Masukkan Jumlah Jp" name="jumlah_jp"  value="{{$Rkursus->jumlah_jp ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">No Sertifikat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 " placeholder="Masukkan No Sertifikat" name="no_sertifikat"  value="{{$Rkursus->no_sertifikat ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sertifikat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Sertifikat" name="tanggal_sertifikat" type="text"  value="{{formatDateIndo($Rkursus->tanggal_sertifikat ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Dokumen</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file') is-invalid @enderror" placeholder="" name="file" type="file" value="">
                <div class="invalid-feedback">
                    {{ $errors->first('file') }}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>