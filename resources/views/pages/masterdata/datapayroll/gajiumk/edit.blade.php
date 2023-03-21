@extends('app') 
@section('content')
@section('breadcrumps')
    <h2 class="pg-title">Edit Gaji Umk</h2>
    {{ Breadcrumbs::render('edit-umk') }}
@endsection

<form class="edit-post-form" action="{{route('master.payroll.umk.store')}}?for={{$for}}" method="post">
    @csrf
    @if($umk != null)
        <input type="hidden" name="id"type="text" value="{{$umk->id}}">
    @endif
        
    <div class="row">
        <div class="col">
            <div class="form-group has-validation">
            <label class="form-label">Kode umk<span class="text-danger">*</span></label>
                <input class="form-control mb-3  @error('kode_umk') is-invalid @enderror"  value="{{$umk->kode_umk ?? null}}" placeholder="Masukkan Kode umk" name="kode_umk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group has-validation">
                <label class="form-label">Nama umk<span class="text-danger">*</span></label>
                <input class="form-control mb-3 @error('nama_umk') is-invalid @enderror" type="text" value="{{$umk->nama_umk ?? null}}" placeholder="Masukkan nama umk" name="nama_umk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kabupaten/kota<span class="text-danger">*</span></label>
                <select class="form-control mb-3 select2 @error('kode_kabupaten') is-invalid @enderror"  value="{{$umk->kode_kabupaten ?? ''}}" placeholder="" name="kode_kabupaten">
                    <option value="" disabled>Pilih Kabupaten/Kota</option>
                    @foreach ($kabupaten as $i)
                        <option value="{{$i->kode_kabupaten}}">{{$i->nama_kabupaten}}</option>
                    @endforeach
                </select>        
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Tahun<span class="text-danger">*</span></label>
                <select class="form-control mb-3 select2 @error('tahun') is-invalid @enderror" type="text" value="{{$umk->tahun ?? null}}" placeholder="Masukkan tahun" name="tahun">
                    @if ($umk == null)
                        {!!GenerateOptionYear()!!};
                    @else
                        {!!GenerateOptionYear($umk->tahun)!!};
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group has-validation">
                <label class="form-label">Nominal<span class="text-danger">*</span></label>
                <input class="form-control mb-3 numeric @error('nominal') is-invalid @enderror" type="text" value="{{$umk->nominal ?? ''}}" placeholder="Masukkan Nominal" name="nominal">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.payroll.umk.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection

@push("js")
<script>
    initDatePickerSingle();
    initTimePicker();
    setNumeric();
    GenerateOptionYear();
</script>
@endpush