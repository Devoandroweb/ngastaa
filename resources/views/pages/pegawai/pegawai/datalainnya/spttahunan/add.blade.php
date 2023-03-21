

@if($Rspt == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat SPT Tahunan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat SPT Tahunan</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.spt.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rspt != null)
        <input type="hidden" name="id" value="{{$Rspt->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tahun<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="tahun" required>
                    <option selected disabled>Select Tahun</option>
                    @if ($Rspt == null)
                    {!!GenerateOptionYear()!!}
                    @else
                    {!!GenerateOptionYear($Rspt->tahun)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Spt<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="jenis_spt" required>
                    <option selected disabled>Select Jenis Spt</option>
                    @if ($Rspt == null)
                    {!!optionJenisSpt()!!}
                    @else
                    {!!optionJenisSpt($Rspt->jenis_spt)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Status Spt</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('status_spt') is-invalid @enderror" placeholder="Masukkan Status Spt" name="status_spt" value="{{$Rspt->status_spt ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nominal</label>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon">Rp.</span>
                    <input class="form-control numeric @error('nominal') is-invalid @enderror" type="text" aria-describedby="basic-addon" placeholder="Masukkan Status Spt" name="nominal" value="{{$Rspt->nominal ?? ''}}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Penyampaian<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_penyampaian') is-invalid @enderror" placeholder="Masukkan Penyampaian" name="tanggal_penyampaian" type="text" value="{{formatDateIndo($Rspt->tanggal_penyampaian ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Tanda Terima Elektronik<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-3">
                <input class="form-control numeric @error('nominal') is-invalid @enderror" aria-describedby="basic-addon" placeholder="Masukkan Nomor Tanda Terima Elektronik" name="nomor_tanda_terima_elektronik" value="{{$Rspt->nomor_tanda_terima_elektronik ?? ''}}">
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
