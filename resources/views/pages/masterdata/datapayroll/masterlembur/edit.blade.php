@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Lembur</h2>
    {{ Breadcrumbs::render('edit-lembur') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.payroll.lembur.update')}}" method="post">
    @csrf
  
    <input type="hidden" name="id" value="{{$lembur->id}}">
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Jam Ke</label>
            <input class="form-control @error('jam') is-invalid @enderror"  placeholder="Masukkan Jam Ke" value="{{$lembur->jam}}" name="jam">
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $errors->first('jam') }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Pengali</label>
            <input class="form-control @error('pengali') is-invalid @enderror"  placeholder="Masukkan pengali Ke" value="{{$lembur->pengali}}" name="pengali">
            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $errors->first('pengali') }}
            </div>
        </div>
    </div>
    
    @include('pages.masterdata.datapayroll.masterlembur.select-sumber-pengali');

    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    <button type="button" onclick="history.back()" class="btn btn-light mt-3">Kembali</button>
    
</form>
@endsection

@push("js")
<script>
$("#input_tags_kode_tunjangan").select2({
    tags: true,
    tokenSeparators: [',', ' '],
    allowClear: true
});
    

</script>

@endpush