@extends('app')

@if($jamKerja == null)
    @section('breadcrumps')
        <h2 class="pg-title">Jam Kerja</h2>
        {{ Breadcrumbs::render('tambah-shift') }}
    @endsection
@else
     @section('breadcrumps')
        <h2 class="pg-title">Jam Kerja</h2>
        {{ Breadcrumbs::render('edit-shift') }}
    @endsection
@endif
@section('content')
<form class="edit-post-form" action="{{route('master.jam_kerja.store')}}?for={{$for}}" method="post">
    @if($jamKerja != null)
        <input type="hidden" name="id"type="text" value="{{$jamKerja->id}}">
    @endif
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Jam Kerja<span class="text-danger">*</span></label>
                <input class="form-control mb-3 @error('kode') is-invalid @enderror" type="text" value="{{$jamKerja->kode ?? null}}" placeholder="Masukkan Kode Jam Kerja" name="kode">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Nama Jam Kerja<span class="text-danger">*</span></label>
                <input class="form-control mb-3 @error('nama') is-invalid @enderror" type="text" value="{{$jamKerja->nama ?? null}}" placeholder="Masukkan Nama Jam Kerja" name="nama">
            </div>
        </div>
    </div>
    <ul class="nav nav-light nav-tabs">
        @for ($i=1; $i <= 7 ; $i++)
        <li class="nav-item">
            <a class="nav-link {{($i==1)?'active':''}}" data-bs-toggle="tab" href="#tab_day_{{$i}}">
                <span class="nav-link-text">{{hari($i)}}</span>
            </a>
        </li>
        @endfor
    </ul>
    <div class="tab-content pt-2">
        @for ($day=1; $day <= 7 ;$day++)
        <div class="tab-pane fade {{($day==1)?'show active':''}}" id="tab_day_{{$day}}">
            @include("pages.masterdata.datapresensi.jam_kerja.form",["day"=>$day,"hariJamKerja"=>$jamKerja?->hariJamKerja?->where('hari',$day)->first()])
        </div>
        @endfor
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.jam_kerja.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection

@push("js")
<script>
    initDatePickerSingle()
    initTimePicker()
    for (let i = 1; i <= 7; i++) {
        hideShowForm(i,$(".checked-type-"+i+":checked"))
        $(".checked-type-"+i).click(function(){
            hideShowForm(i,$(".checked-type-"+i+":checked"))
        })
    }
    function hideShowForm(day,el){
        if(el.val() == 0){
            $(".copy-other-day-"+day).hide();
            $(".form-clock-"+day).hide();
        }else if(el.val() == 1){
            $(".copy-other-day-"+day).show();
            $(".form-clock-"+day).hide();
        }else if(el.val() == 2){
            $(".copy-other-day-"+day).hide();
            $(".form-clock-"+day).show();
        }
    }
</script>
@endpush
