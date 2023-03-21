@if($Rpenghargaan == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Penghargaan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Penghargaan</h4>
    <div class="line-text"></div>
</div>
@endif
<form class="edit-post-form" action="{{route('pegawai.penghargaan.store',$pegawai->nip)}}" method="post">
    @csrf 
    @if($Rpenghargaan != null)
        <input type="hidden" name="id" value="{{$Rpenghargaan->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Penghargaan <span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control Penghargaan" name="kode_penghargaan" required>
                    <option selected disabled>Select Nama Penghargaan</option>
                    
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Oleh<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('oleh') is-invalid @enderror" placeholder="Oleh" name="oleh" value="{{$Rpenghargaan->oleh ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_sk') is-invalid @enderror" placeholder="Masukkan Nomor sk" name="nomor_sk" value="{{$Rpenghargaan->nomor_sk ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_sk') is-invalid @enderror" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" type="text" value="{{formatDateIndo($Rpenghargaan->tanggal_sk ?? null)}}">
                
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