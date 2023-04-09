
@if($Rpotongan == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Potongan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Potongan</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.potongan.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf
    @if($Rpotongan != null)
        <input type="hidden" name="id" value="{{$Rpotongan->id}}">
    @endif
    {{-- bagian sini ada kurang (private) --}}
    @if(role('owner'))
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="is_private_1" name="is_private" class="form-check-input" value="1" {{$Rpotongan?->is_private == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="is_private_1">Aktif (Terhitung pada Payroll)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="is_private_2" name="is_private" class="form-check-input" value="0" {{$Rpotongan?->is_private == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="is_private_2">Tidak Aktif (Tidak terhitung pada Payroll)</label>
            </div>    
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Potongan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control jenisPotongan" name="kode_kurang" required>

                </select>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" type="text" value="{{formatDateIndo($Rjabatan->tanggal_sk ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="Masukkan Nomor Sk" name="nomor_sk" type="text" value="{{$Rpotongan->nomor_sk ?? ''}}">
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
