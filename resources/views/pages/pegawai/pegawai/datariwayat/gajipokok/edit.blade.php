
<form class="edit-post-form" action="{{url('pegawai/jabatan/akhir'.$pegawi->nip)}}" method="post">
    {{-- <input type="hidden" name="id" value="{{$pegawai->id}}"> --}}
    @csrf
    
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="gaji_akhir" name="gaji_akhir" class="form-check-input" checked>
                <label class="form-check-label" for="jabatan_akhir">Gaji Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="riwayat_gaji" name="riwayat_gaji" class="form-check-input" checked>
                <label class="form-check-label" for="riwayat_jabatan">Riwayat Gaji</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Surat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_surat') is-invalid @enderror" placeholder="Masukkan Nomor Surat" name="nomor_surat" value="{{$pegawai->nomor_surat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_surat') }}
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
                <input class="form-control mb-3 @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="date" value="{{$pegawai->tanggal_surat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Tmt</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_tmt') is-invalid @enderror" placeholder="Masukkan Tmt" name="tanggal_tmt" type="date" value="{{$pegawai->tanggal_tmt}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_tmt') }}
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
                <input class="form-control mb-3 @error('file') is-invalid @enderror" placeholder="" name="file" type="file" value="{{$pegawai->file}}">
                <div class="invalid-feedback">
                    {{ $errors->first('file') }}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{url('pegawai/kgb/'.$pegawai->nip)}}" class="btn btn-light">Kembali</a>
</form>