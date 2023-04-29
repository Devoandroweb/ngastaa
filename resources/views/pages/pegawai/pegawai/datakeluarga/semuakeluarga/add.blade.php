
@if($keluarga == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Keluarga</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Keluarga</h4>
    <div class="line-text"></div>
</div>
@endif
<form class="edit-post-form" action="{{route('pegawai.keluarga.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf
    @if($keluarga != null)
        <input type="hidden" name="id" value="{{$keluarga->id}}">
    @endif
    @if($status == 0 || $status == "orang-tua")
    <div class="row  mb-3">
        <div class="col-md-4">
            <label class="form-label">Status Hubungan</label>
        </div>
        <div class="col-md has-validation">
            <select class="form-control select2" name="status" required>
                <option value="0" selected disabled>Select Status Hubungan</option>
                @if($keluarga == null)
                {!! optionKeluarga(null,$status) !!}
                @else
                {!! optionKeluarga($keluarga->status,$status) !!}
                @endif
            </select>
        </div>
    </div>
    @else
    <input type="hidden" name="status" value="{{$status}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama</label>
        </div>
        <div class="col-md">
            <div class="form-group has-validation">
                <input class="form-control mb-3 @error('nama') is-invalid @enderror" value="{{$keluarga->nama ?? ''}}"  placeholder="Masukkan Nama" name="nama">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tempat Lahir</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('tempat_lahir') is-invalid @enderror" value="{{$keluarga->tempat_lahir ?? ''}}" placeholder="Masukkan Tempat Lahir" name="tempat_lahir">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Lahir</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 datepicker-single @error('tanggal_lahir') is-invalid @enderror"  value="{{formatDateIndo($keluarga->tanggal_lahir ?? '')}}" placeholder="Masukkan Tanggal Lahir" name="tanggal_lahir" type="text" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Telepon</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_telepon') is-invalid @enderror" value="{{$keluarga->nomor_telepon ?? ''}}" placeholder="Masukkan Nomor Telepon" name="nomor_telepon">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_telepon') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Alamat</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <textarea class="form-control mb-3 @error('alamat') is-invalid @enderror" value="" placeholder="Masukkan Alamat" name="alamat" rows="3" >{{$keluarga->alamat ?? ''}}</textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('alamat') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Ktp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_ktp') is-invalid @enderror" value="{{$keluarga->nomor_ktp ?? ''}}" placeholder="Masukkan Nomor Ktp" name="nomor_ktp">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_ktp') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Ktp</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('unggah_ktp') is-invalid @enderror" placeholder="Masukkan Unggah Ktp" name="file_ktp" type="file">
                <div class="invalid-feedback">
                    {{ $errors->first('file_ktp') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Bpjs</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nomor_bpjs') is-invalid @enderror" value="{{$keluarga->nomor_bpjs ?? ''}}" placeholder="Masukkan Nomor Bpjs" name="nomor_bpjs">
                <div class="invalid-feedback">
                    {{ $errors->first('nomor_bpjs') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Unggah Bpjs</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('unggah_bpjs') is-invalid @enderror" placeholder="Masukkan Unggah Bpjs" name="file_bpjs" type="file">
                <div class="invalid-feedback">
                    {{ $errors->first('unggah_bpjs') }}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" class="btn btn-light btn-back">Kembali</button>
</form>

