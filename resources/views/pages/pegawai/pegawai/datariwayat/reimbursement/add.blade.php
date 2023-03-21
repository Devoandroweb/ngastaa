
@if($Rreimbursement == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Reimbursement</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Reimbursement</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>

<form class="edit-post-form" action="{{route('pegawai.reimbursement.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rreimbursement != null)
    <input type="hidden" name="id" value="{{$Rreimbursement->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Reimbursement<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control Reimbursement" name="kode_reimbursement" required disabled>
                    
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nominal<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nilai') is-invalid @enderror" placeholder="Masukkan Nominal" name="nilai" value="{{$Rreimbursement->nilai ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Keterangan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan" name="keterangan" value="{{$Rreimbursement->keterangan ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="text" value="{{formatDateIndo($Rreimbursement->tanggal_surat ?? null)}}">
                
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$Rreimbursement->nomor_surat ?? ''}}">
                
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
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
