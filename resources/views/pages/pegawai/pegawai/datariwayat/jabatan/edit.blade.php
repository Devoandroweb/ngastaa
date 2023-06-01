
<form class="edit-post-form" action="{{url('pegawai/jabatan/'.$pegawai->nip)}}" method="post">
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    @csrf
    
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="jabatan_akhir" name="jabatan_akhir" class="form-check-input" checked>
                <label class="form-check-label" for="jabatan_akhir">Jabatan Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="riwayat_jabatan" name="riwayat_jabatan" class="form-check-input" checked>
                <label class="form-check-label" for="riwayat_jabatan">Riwayat Jabatan</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Jabatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control select2" name="jenis_jabatan" required>
                    <option selected disabled>Select Jenis Jabatan</option>
                    {!!optionJenisJabatan()!!}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('jenis_jabatan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Divisi Kerja</label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control " id="jabatanDivisi" name="divisi_kerja" required>
                    <option selected disabled>Select Divisi Kerja</option>
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('divisi_kerja') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jabatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jabatan') is-invalid @enderror" placeholder="Masukkan Jabatan" name="jabatan" value="{{$pegawai->tingkat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('jabatan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">No Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('no_sk') is-invalid @enderror" placeholder="Masukkan No SK" name="no_sk" type="number" value="{{$pegawai->no_sk}}">
                <div class="invalid-feedback">
                    {{ $errors->first('no_sk') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_sk') is-invalid @enderror" placeholder="Masukkan Tanggal SK" name="tanggal_sk" type="date" value="{{$pegawai->tanggal_sk}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_sk') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai Kontrak</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_tmt') is-invalid @enderror" placeholder="Masukkan Tanggal SK" name="tanggal_tmt" type="date" value="{{$pegawai->tanggal_tmt}}">
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
    <a href="{{url('pegawai/keluarga/')}}" class="btn btn-light">Kembali</a>
</form>@endsection
@push('js')
    
@endpush
