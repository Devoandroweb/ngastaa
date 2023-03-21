

@if($Rbahasa == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Bahasa</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Bahasa</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.bahasa.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 
    @if($Rbahasa != null)
        <input type="hidden" name="id" value="{{$Rbahasa->id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Bahasa<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nama_bahasa') is-invalid @enderror" placeholder="Masukkan Nama Bahasa" name="nama_bahasa" value="{{$Rbahasa->nama_bahasa ?? ''}}">
            </div>
        </div>
    </div>        
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Bahasa<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="jenis" required>
                    <option selected disabled>Select Jenis Bahasa</option>
                    @if ($Rbahasa == null)
                    {!!opttionJenisBahasa()!!}
                    @else
                    {!!opttionJenisBahasa($Rbahasa->jenis)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Penguasaan Bahasa<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="penguasaan" required>
                    <option selected >Select Penguasaan Bahasa</option>
                    @if ($Rbahasa == null)
                    {!!optionPenguasaanBahasa()!!}
                    @else
                    {!!optionPenguasaanBahasa($Rbahasa->penguasaan)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Dokumen</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('file') is-invalid @enderror" placeholder="" name="file" type="file" value="{{$Rbahasa->penguasaan ?? null}}">
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
