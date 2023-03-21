

@if($Rorganisasi == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Organisasi</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Organisasi</h4>
    <div class="line-text"></div>
</div>
@endif
<form class="edit-post-form" action="{{route('pegawai.organisasi.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf 

    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Organisasi<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nama_organisasi') is-invalid @enderror" placeholder="Masukkan Nama Organisasi" name="nama_organisasi" value="{{$Rorganisasi->nama_organisasi ?? ''}}">
            </div>
        </div>
    </div>        
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jenis Organisasi<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group has-validation">
                <select class="form-control select2" name="jenis_organisasi" required>
                    <option selected disabled>Select Jenis Organisasi</option>
                    @if ($Rorganisasi == null)
                        {!!generateJenisOrganisasi()!!}
                    @else
                        {!!generateJenisOrganisasi($Rorganisasi->jenis_organisasi)!!}
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jabatan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('jabatan') is-invalid @enderror" placeholder="Masukkan Jabatan" name="jabatan" value="{{$Rorganisasi->jabatan ?? ''}}">
                <div class="invalid-feedback">
                    {{ $errors->first('jabatan') }}
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
                <input class="form-control mb-3 datepicker-single @error('tanggal_mulai') is-invalid @enderror" placeholder="Masukkan Tanggal Mulai" name="tanggal_mulai" type="text" value="{{formatDateIndo($Rorganisasi->tanggal_mulai ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Selesai</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_selesai') is-invalid @enderror" placeholder="Masukkan Tanggal Selesai" name="tanggal_selesai" type="text" value="{{formatDateIndo($Rorganisasi->tanggal_selesai ?? null)}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Pimpinan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nama_pemimpin') is-invalid @enderror" placeholder="Masukkan Nama Pimpinan" name="nama_pimpinan" type="" value="{{$Rorganisasi->nama_pimpinan ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tempat') is-invalid @enderror" placeholder="Masukkan Nama Tempat" name="tempat" type="" value="{{$Rorganisasi->tempat ?? ''}}">
                <div class="invalid-feedback">
                    {{ $errors->first('tempat') }}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>
    

</form>
