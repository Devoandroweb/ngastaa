
@if($Rkgb == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Gaji Pokok</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Gaji Pokok</h4>
    <div class="line-text"></div>
</div>
@endif

<form class="edit-post-form" action="{{route('pegawai.kgb.store',$pegawai->nip)}}?for={{$for}}" method="post" enctype="multipart/form-data" >
    @csrf
    @if($Rkgb != null)
        <input type="hidden" name="id" value="{{$Rkgb->id}}">
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="is_akhir_1" name="is_akhir" class="form-check-input" value="1" {{$Rkgb?->is_akhir == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="is_akhir_1">Gaji Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="is_akhir_2" name="is_akhir" class="form-check-input" value="0" {{$Rkgb?->is_akhir == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="is_akhir_2">Riwayat Gaji</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$Rkgb->nomor_surat ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="text" value="{{formatDateIndo($Rkgb->tanggal_surat ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Tmt<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_tmt') is-invalid @enderror" placeholder="Masukkan Tmt" name="tanggal_tmt" type="text" value="{{formatDateIndo($Rkgb->tanggal_tmt ?? null)}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tipe Gaji</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                
                <select class="form-control select2" name="tipe_gaji" required>
                    @if($Rkgb == null)
                        {!!optionTipeGaji()!!}
                    @else
                        {!!optionTipeGaji($Rkgb->tipe_gaji)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div id="gaji">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Gaji UMK</label>
            </div>
            <div class="col-md-8">
                <div class="form-group has-validation">
                    <input name="gaji_pokok" id="gaji_umk_value" type="hidden">
                    <select class="form-control selectGajiUMK" name="kode_umk" required>
                        
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Masa Kerja</label>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                
                <div class="input-group mb-3">
                    <input class="form-control @error('masa_kerja_tahun') is-invalid @enderror" placeholder="Masukkan tahun" name="masa_kerja_tahun" type="number" value="{{$Rkgb->masa_kerja_tahun ?? ''}}">
                    <span class="input-group-text" id="basic-addon2">Tahun</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <input class="form-control @error('masa_kerja_bulan') is-invalid @enderror" placeholder="Masukkan Bulan" name="masa_kerja_bulan" type="number" value="{{$Rkgb->masa_kerja_bulan ?? ''}}">
                <span class="input-group-text" id="basic-addon2">Bulan</span>
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
