
<form class="edit-post-form" action="{{url('pegawai/cuti/'.$pegawai->nip)}}" method="post">
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    @csrf
    
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Cuti<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control select2" name="kode_cuti" required>
                    <option selected disabled>Select Nama Cuti</option>
                    <option selected >Select Nama Cuti</option>
                    {{-- @foreach($pegawai as $s)
                        <option value="{{$s->kode_potongan}}">{{$s->status}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                    {{ $errors->first('kode_cuti') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tempat') is-invalid @enderror" placeholder="Masukkan Tempat" name="tempat" value="{{$pegawai->tempat}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tempat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_surat') is-invalid @enderror" placeholder="Masukkan Tanggal Surat" name="tanggal_surat" type="date" value="{{$pegawai->tanggal_surat}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_surat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Mulai<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_mulai') is-invalid @enderror" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" type="date" value="{{$pegawai->tanggal_mulai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_mulai') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tanggal_selesai') is-invalid @enderror" placeholder="Masukkan Tanggal Selesai" name="tanggal_selesai" type="date" value="{{$pegawai->tanggal_selesai}}">
                <div class="invalid-feedback"'> '
                    {{ $errors->first('tanggal_selesai') }}
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
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>

</form>
