@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Hari Libur</h2>
    {{ Breadcrumbs::render('tambah-hari-libur') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.hariLibur.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Tanggal Mulai</label>
                <input type="text" class="form-control mb-3 datepicker-single @error('tanggal_mulai') is-invalid @enderror" value="{{date("d/m/Y")}}"  placeholder="Masukkan Kode Kursus" name="tanggal_mulai">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Tanggal Selesai</label>
                <input type="text" class="form-control mb-3 datepicker-single @error('tanggal_selesai') is-invalid @enderror" value="{{date("d/m/Y")}}"  placeholder="Masukkan Kode Kursus" name="tanggal_selesai">
            </div>
        </div>
        
    </div>
    <div class="form-group has-validation">
        <label class="form-label">Nama Hari</label>
        <input class="form-control mb-3 @error('nama') is-invalid @enderror"  placeholder="Masukkan Nama Hari" name="nama">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.hariLibur.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection

@push("js")
<script>
    initDatePickerSingle();
</script>
@endpush