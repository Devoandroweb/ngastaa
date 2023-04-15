@if(!isset($front))
@if($Rshift == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Shift</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Shift</h4>
    <div class="line-text"></div>
</div>
@endif
@endif
<form class="edit-post-form" action="{{route('pegawai.shift.store',$pegawai->nip)}}?for={{$for}}{{(isset($front)) ? $front : '' }}" method="post">
    @csrf 
    @if($Rshift != null)
    <input type="hidden" name="id" value="{{$Rshift->id}}">
    @endif
    <div class="row mb-3 {{(isset($front)) ? 'd-none' : '' }}">
        <div class="col-md-4">
            <label class="form-label">Pilihan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="shift_aktif" name="is_akhir" value="1" class="form-check-input" {{$Rshift?->is_akhir == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="shift_aktif">Shif Aktif</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="shif_tidak_aktif" name="is_akhir" value="0" class="form-check-input" {{$Rshift?->is_akhir == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="shif_tidak_aktif">Shif Tidak Aktif</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Shif<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control Shift" name="kode_shift" required>
                    <option selected disabled>Select Shif</option>
                    
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('kode_shift') }}
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
                <input class="form-control mb-3 @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan" name="keterangan" value="{{$Rshift->keterangan ?? ''}}">
                <div class="invalid-feedback">
                    {{ $errors->first('keterangan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="text" value="{{formatDateIndo($Rshift->tanggal_surat ?? null)}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$Rshift->nomor_surat ?? ''}}">
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
    @if(!isset($front))
    <button type="button" class="btn btn-light btn-back">Kembali</button>
    @else
    <a href="{{route("pegawai.pegawai.index")}}" class="btn btn-light">Kembali</a>
    @endif

</form>