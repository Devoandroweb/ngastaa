@if($Rpendidikan == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Riwayat Pendidikan</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Riwayat Pendidikan</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="{{route('pegawai.pendidikan.store',$pegawai->nip)}}?for={{$for}}" method="post">
    @csrf
    @if($Rpendidikan != null)
        <input type="hidden" name="id" value="{{$Rpendidikan->id}}">
    @endif
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Pilihan</label>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="aktif" name="is_akhir" class="form-check-input" value="1" {{$Rpendidikan?->is_akhir == 1 ? 'checked':'' }}>
                <label class="form-check-label" for="aktif">Pendidikan Akhir</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-check">
                <input type="radio" id="tidak_aktif" name="is_akhir" class="form-check-input" value="0" {{$Rpendidikan?->is_akhir == 0 ? 'checked':'' }}>
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
                <select class="form-control tingkatPendidikan" name="kode_pendidikan" required>
                    
                </select>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Jurusan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <select class="form-control jurusan" name="kode_jurusan" required>
                    
                </select>
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nomor Ijazah</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 " placeholder="Masukkan Nomor Ijazah" name="nomor_ijazah" value="{{$Rpendidikan->nomor_ijazah ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Tanggal Lulus</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control datepicker-single mb-3 " placeholder="Masukkan Tanggal Lulus" name="tanggal_lulus" type="text" value="{{formatDateIndo($Rpendidikan->tanggal_lulus ?? null)}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Nama Sekolah / Perguruan Tinggi <span class="text-soft-danger">*</span></label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('nama_sekolah') is-invalid @enderror" placeholder="Masukkan Nama Sekolah / Perguruan Tinggi" name="nama_sekolah" value="{{$Rpendidikan->nama_sekolah ?? ''}}">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Gelar Depan</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('gelar_depan') is-invalid @enderror" placeholder="Masukkan Gelar Depan" name="gelar_depan" value="{{$Rpendidikan->gelar_depan ?? ''}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Gelar Belakang</label>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input class="form-control mb-3 @error('gelar_belakang') is-invalid @enderror" placeholder="Masukkan Gelar Belakang" name="gelar_belakang" value="{{$Rpendidikan->gelar_belakang ?? ''}}">

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
