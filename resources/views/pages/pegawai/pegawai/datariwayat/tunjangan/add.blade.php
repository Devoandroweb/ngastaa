@if($Rtunjangan == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Tunjangan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Tunjangan</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.tunjangan.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf
    @if($Rtunjangan != null)
        <input type="hidden" name="id" value="{{$Rtunjangan->id}}">
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="aktif" value="1" name="is_aktif" class="form-check-input" {{$Rtunjangan?->is_aktif == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="aktif">Aktif (Terhitung pada Payroll)</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="tidak_aktif" value="0" name="is_aktif" class="form-check-input" {{$Rtunjangan?->is_aktif == 0 ? 'checked':'' }}>
                <label class="form-check-label" for="tidak_aktif">Tidak Aktif (Tidak terhitung pada Payroll)</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Tunjangan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control jenisTunjangan" name="kode_tunjangan" disabled required>
                    
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
                <input class="form-control numeric mb-3" placeholder="Masukkan Nominal" name="nilai" type="text" value="{{$Rtunjangan->nilai ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Sk</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" type="text"  value="{{formatDateIndo($Rtunjangan->tanggal_sk ?? null)}}" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Sk<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="Masukkan Nomor Sk" name="nomor_sk" type="number" value="{{$Rtunjangan->nomor_sk ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Dokumen</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3" placeholder="" name="file" type="file" >
            </div>
        </div>
    </div>
    <hr>  
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>
</form>
