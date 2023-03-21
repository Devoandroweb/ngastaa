
<form class="edit-post-form" action="{{url('pegawai/potongan/akhir')}}" method="post">
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    @csrf
    
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="aktif" name="aktif" class="form-check-input" checked>
                <label class="form-check-label" for="aktif">Pendidikan Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="tidak_aktif" name="tidak_aktif" class="form-check-input" checked>
                <label class="form-check-label" for="tidak_aktif">Riwayat Pendidikan</label>
            </div>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tingkat Pendidikan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="tingkat_pendidikan" required>
                    <option selected disabled>Select Tingkat Pendidikan</option>
                    <option selected >Select Tingkat Pendidikan</option>
                    
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('tingkat_pendidikan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jurusan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="jurusan" required>
                    <option selected disabled>Select Jurusan</option>
                    <option selected >Select Jurusan</option>
                    {{-- @foreach($pegawai as $s)
                        <option value="{{$s->kode_potongan}}">{{$s->status}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('jurusan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Ijazah</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_ijazah') is-invalid @enderror" placeholder="Masukkan Nomor Ijazah" name="nomor_ijazah" value="{{$pegawai->nomor_ijazah}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_ijazah') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Lulus</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_lulus') is-invalid @enderror" placeholder="Masukkan Tanggal Lulus" name="tanggal_lulus" type="date" value="{{$pegawai->tanggal_lulus}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tanggal_lulus') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Sekolah / Perguruan Tinggi <span class="text-soft-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nama_sekolah') is-invalid @enderror" placeholder="Masukkan Nama Sekolah / Perguruan Tinggi" name="nama_sekolah" value="{{$pegawai->nama_sekolah}}">
                <div class="invalid-feedback">
                    {{ $errors->first('nama_sekolah') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Gelar Depan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('gelar_depan') is-invalid @enderror" placeholder="Masukkan Gelar Depan" name="gelar_depan" value="{{$pegawai->gelar_depan}}">
                <div class="invalid-feedback">
                    {{ $errors->first('gelar_depan') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Gelar Belakang</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('gelar_belakang') is-invalid @enderror" placeholder="Masukkan Gelar Belakang" name="gelar_belakang" value="{{$pegawai->gelar_belakang}}">
                <div class="invalid-feedback">
                    {{ $errors->first('gelar_belakang') }}
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
    <a href="{{url('pegawai/kgb/')}}" class="btn btn-light">Kembali</a>

</form>
