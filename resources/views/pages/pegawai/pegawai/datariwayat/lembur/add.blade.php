
@if($Rlembur == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Lembur</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Lembur</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.lembur.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
        
    @if($Rlembur != null)
    <input type="hidden" name="id" value="{{$Rlembur->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal') is-invalid @enderror" placeholder="Masukkan Tanggal" name="tanggal" type="text" value="{{formatDateIndo($Rlembur->tanggal ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jam Mulai<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jam_mulai') is-invalid @enderror" placeholder="Jam Mulai" name="jam_mulai" type="time" value="{{$Rlembur->jam_mulai ?? ''}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('jam_mulai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jam Selesai<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jam_selesai') is-invalid @enderror" placeholder="Jam Selesai" name="jam_selesai" type="time" value="{{$Rlembur->jam_selesai ?? ''}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('jam_selesai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Keterangan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan" name="keterangan" value="{{$Rlembur->keterangan ?? ''}}">
                <div class="invalid-feedback">
                    {{ $errors->first('keterangan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="text" value="{{formatDateIndo($Rlembur->tanggal_surat ?? null)}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$Rlembur->nomor_surat ?? ''}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_surat') }}
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

