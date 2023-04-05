@section('breadcrumps')
    {{-- {{ Breadcrumbs::render('status-pegawai') }} --}}
    <h4>Edit Pegawai</h4>
@endsection
@section('content')
<form class="edit-post-form" action="{{route('pegawai.pegawai.store')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$pegawai->id}}">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="hk-pg-header pg-header-wth-tab pb-2 mb-2">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h5>Informasi Data Diri</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">Kode Pegawai</label>
                        <input class="form-control @error('nip') is-invalid @enderror" value="{{$pegawai->nip}}" placeholder="Masukkan Kode Pegawai" name="nip">
                        <div class="invalid-feedback">
                            {{ $errors->first('nip') }}
                        </div>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="form-group has-validation">
                        <label class="form-label">NIK</label>
                        <input class="form-control @error('nik') is-invalid @enderror" value="{{$pegawai->nik}}" placeholder="Masukkan NIK" name="nik">
                        <div class="invalid-feedback">
                            {{ $errors->first('nik') }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light ">Kembali</button>

</form>
@endsection
@push('js')
<script>
    $("select").select2();
</script>    
@endpush
