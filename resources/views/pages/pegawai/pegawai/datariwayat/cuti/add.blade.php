
@if($Rcuti == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Cuti</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Cuti</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" novalidate action="{{route('pegawai.cuti.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rcuti != null)
    <input type="hidden" name="id" value="{{$Rcuti->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Cuti<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control namaCuti" name="kode_cuti" required disabled>
                    
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$Rcuti->nomor_surat ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="text" value="{{formatDateIndo($Rcuti->tanggal_surat ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_mulai') is-invalid @enderror" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" type="text" value="{{formatDateIndo($Rjabatan->tanggal_mulai ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_selesai') is-invalid @enderror" placeholder="Masukkan Tanggal Selesai" name="tanggal_selesai" type="text" value="{{formatDateIndo($Rcuti->tanggal_selesai ?? null)}}">
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
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
