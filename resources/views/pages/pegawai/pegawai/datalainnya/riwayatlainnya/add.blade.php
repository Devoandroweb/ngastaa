

@if($Rlainnya == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Lainnya</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Lainnya</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.lainnya.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rlainnya != null)
        <input type="hidden" name="id" value="{{$Rlainnya->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control Lainnya" name="kode_lainnya" required >
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_sk') is-invalid @enderror" placeholder="Masukkan Nomor Sk" name="nomor_sk" value="{{$Rlainnya->nomor_sk ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-3">
                <input class="form-control datepicker-single @error('tanggal_sk') is-invalid @enderror" type="text" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" value="{{formatDateIndo($Rlainnya->tanggal_sk ?? null)}}">
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
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
