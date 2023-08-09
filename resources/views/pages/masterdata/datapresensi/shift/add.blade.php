@extends('app')

@if($shift == null)
    @section('breadcrumps')
        <h2 class="pg-title">Shift</h2>
        {{ Breadcrumbs::render('tambah-shift') }}
    @endsection
@else
     @section('breadcrumps')
        <h2 class="pg-title">Shift</h2>
        {{ Breadcrumbs::render('edit-shift') }}
    @endsection
@endif
@section('content')
<form class="edit-post-form" action="{{route('master.shift.store')}}?for={{$for}}" method="post">
    @csrf
    @if($shift != null)
        <input type="hidden" name="id"type="text" value="{{$shift->id}}">
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-validation">
                <label class="form-label">Divisi Kerja </label>
                <select class="form-control jabatanDivisi mb-3 " name="kode_skpd" disabled>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Kode Shift<span class="text-danger">*</span></label>
                <input class="form-control mb-3 @error('kode_shift') is-invalid @enderror" type="text" value="{{$shift->kode_shift ?? null}}" placeholder="Masukkan Kode Shift" name="kode_shift">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group has-validation">
                <label class="form-label">Nama Shift<span class="text-danger">*</span></label>
                <input class="form-control mb-3 @error('nama') is-invalid @enderror" type="text" value="{{$shift->nama ?? null}}" placeholder="Masukkan Nama shift" name="nama">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Buka Datang<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_datang') is-invalid @enderror" type="text" value="{{($shift != null) ? date("H:i:s",strtotime($shift->jam_buka_datang)) : date("H:i:s")}}" name="jam_buka_datang">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tepat Datang<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_datang') is-invalid @enderror" type="text" value="{{$shift->jam_tepat_datang ?? null}}" name="jam_tepat_datang">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tutup Datang<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_datang') is-invalid @enderror" type="text" value="{{$shift->jam_tutup_datang ?? null}}" name="jam_tutup_datang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Toleransi Datang</label>
            <input class="form-control mb-3 @error('toleransi_datang') is-invalid @enderror" type="number" value="{{$shift->toleransi_datang ?? ''}}" placeholder="Masukkan Toleransi Datang" name="toleransi_datang" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Buka Istirahat</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_istirahat') is-invalid @enderror" type="text" value="{{$shift->jam_buka_istirahat ?? null}}" name="jam_buka_istirahat">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tepat Istirahat</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_istirahat') is-invalid @enderror" type="text" value="{{$shift->jam_tepat_istirahat ?? null}}" name="jam_tepat_istirahat">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tutup Istirahat</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_istirahat') is-invalid @enderror" type="text" value="{{$shift->jam_tutup_istirahat ?? null}}" name="jam_tutup_istirahat">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Toleransi Istirahat</label>
            <input class="form-control mb-3 @error('toleransi_istirahat') is-invalid @enderror" type="number" value="{{$shift->toleransi_istirahat ?? null}}" placeholder="Masukkan Toleransi Istirahat" name="toleransi_istirahat" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Buka pulang</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_pulang') is-invalid @enderror" type="text" value="{{$shift->jam_buka_pulang ?? null}}" placeholder="" name="jam_buka_pulang">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tepat pulang</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tepat_pulang') is-invalid @enderror" type="text" value="{{$shift->jam_tepat_pulang ?? null}}" placeholder="" name="jam_tepat_pulang">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Tutup pulang</label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_tutup_pulang') is-invalid @enderror" type="text" value="{{$shift->jam_tutup_pulang ?? null}}" placeholder="" name="jam_tutup_pulang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Toleransi pulang</label>
            <input class="form-control mb-3 @error('toleransi_pulang') is-invalid @enderror" type="number" value="{{$shift->toleransi_pulang ?? null}}" placeholder="Masukkan Toleransi pulang" name="toleransi_pulang" value="">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('master.shift.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection

@push("js")
<script>
    initDatePickerSingle();
    // initTimePicker();
    initDevisi();
    function initDevisi(kode_skpd = null){
        let getDivisi = (url) => {
            var element = $('.jabatanDivisi');
            let loading = loadingProccesText(element)
            $.ajax({url: url, success: function(data){
                element.empty()
                clearInterval(loading)
                var data = $.map(data, function (item) {
                    return {
                        text: item['label'],
                        id: item['kode_skpd'],
                    }
                })

                if(kode_skpd == null && data.length != 0){
                    kode_skpd = data[0].id;
                }

                element.removeAttr("disabled")
                element.select2({
                    placeholder:"Pilih Divisi atau ketik disini",
                    data : data
                }).val(kode_skpd).change();
            }});
        }
        getDivisi("{{route('master.skpd.json')}}")
    }
</script>
@endpush
