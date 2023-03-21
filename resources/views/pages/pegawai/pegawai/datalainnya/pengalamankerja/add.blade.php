

@if($Rpmk == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Pengalaman Kerja</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Pengalaman Kerja</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.pmk.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rpmk != null)
        <input type="hidden" name="id" value="{{$Rpmk->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Perusahaan<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="jenis_pmk" required>
                    <option selected disabled>Select Jenis Perusahaan</option>
                    @if ($Rpmk == null)
                    {!!optionJenisInstansi()!!}
                    @else
                    {!!optionJenisInstansi($Rpmk->jenis_pmk)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Perusahaan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('instansi') is-invalid @enderror" placeholder="Masukkan Perusahaan" name="instansi" value="{{$Rpmk->instansi ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Awal</label>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-3">
                <input class="form-control datepicker-single @error('tanggal_awal') is-invalid @enderror" type="text" placeholder="" name="tanggal_awal" value="{{formatDateIndo($Rpmk->tanggal_awal ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Akhir</label>
        </div>
        <div class="col-md-8">
            <div class="form-group mb-3">
                
                {{-- <input class="form-control mb-3 datepicker-single" placeholder="Masukkan Tanggal Sk" name="tanggal_sk" type="text"  value="{{formatDateIndo($Rtunjangan->tanggal_sk ?? null)}}" > --}}
                <input class="form-control datepicker-single @error('tanggal_akhir') is-invalid @enderror" type="text" placeholder="" name="tanggal_akhir" value="{{formatDateIndo($Rpmk->tanggal_akhir ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Masa Kerja<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Tahun</span>
                    <input class="form-control  @error('masa_kerja_tahun') is-invalid @enderror" type="number" max="90" type="" aria-describedby="basic-addon1" placeholder="Masukkan Masa Kerja Tahun" name="masa_kerja_tahun" value="{{$Rpmk->masa_kerja_tahun ?? ''}}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2">Bulan</span>
                    <input class="form-control  @error('masa_kerja_bulan') is-invalid @enderror" type="number" max="12" type="" aria-describedby="basic-addon2" placeholder="Masukkan Masa Kerja Bulan" name="masa_kerja_bulan" value="{{$Rpmk->masa_kerja_bulan ?? ''}}">
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
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
