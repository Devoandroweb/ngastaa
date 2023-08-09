@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penjadwalan Shift</h2>
    {{-- {{ Breadcrumbs::render('tambah-shift-libur') }} --}}
@endsection
@section('content')
@if($shift == null)
<div class="d-flex align-items-center header-form">
    <h4>Tambah Penjadwalan Shift</h4>
    <div class="line-text"></div>
</div>
@else
<div class="d-flex align-items-center header-form">
    <h4>Edit Penjadwalan Shift</h4>
    <div class="line-text"></div>
</div>
@endif
<hr>
<form class="edit-post-form" action="" method="post">
    {{-- {{route('master.shift.store')}}?for={{$for}} --}}
    @csrf
    @if($shift != null)
        {{-- <input type="hidden" name="id"type="text" value="{{$shift->id}}"> --}}
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Divisi Kerja </label>
                <select class="form-control jabatanDivisi mb-3  @error('kode_divisi') is-invalid @enderror"  value="{{$shift->kode_divisi ?? null}}" name="kode_divisi" disabled>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Tingkat Jabatan</label>
                <select class="form-control mb-3 jabatanTingkat @error('kode_tingkat') is-invalid @enderror"  value="{{$shift->kode_tingkat ?? null}}" name="kode_tingkat" disabled>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Level Jabatan</label>
                <select class="form-control mb-3  @error('kode_level') is-invalid @enderror"  value="{{$shift->kode_level ?? null}}" name="kode_level" disabled>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group has-validation">
            <label class="form-label">Nama Shift<span class="text-danger">*</span></label>
            <select class="form-control select2 mb-3 @error('nama') is-invalid @enderror"  value="{{$shift->kode_shift ?? null}}" placeholder="" name="kode_shift" >
            @foreach ($shift as $i)
                <option value="{{$i->kode_shift}}">{{$i->nama}}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Datang<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_datang') is-invalid @enderror" type="text" value="{{$shift->jam_buka_datang ?? null}}" placeholder="" name="jam_buka_datang" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam pulang<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_pulang') is-invalid @enderror" type="text" value="{{$shift->jam_buka_pulang ?? null}}" placeholder="" name="jam_buka_pulang" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group has-validation">
                <label class="form-label">Jam Istirahat<span class="text-danger">*</span></label>
                <input class="form-control mb-3 input-single-timepicker @error('jam_buka_istirahat') is-invalid @enderror" type="text" value="{{$shift->jam_buka_istirahat ?? null}}" placeholder="" name="jam_buka_istirahat" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <label class="form-label">Periode Shift<span class="text-danger">*</span></label>
        <span class="input-affix-wrapper mb-3">
            <span class="input-prefix ms-2"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span></span>
            <input type="text" class="form-control pe-0 daterangepicker-maks-month" value="{{date('01/m/Y') ." - ". date('t/m/Y')}}">
            <div id="displayRegervation"></div>
        </span>
    </div>
    <button type="submit" class="btn btn-primary">{{__('Simpan')}}</button>
    <a href="{{route('presensi.penjadwalanshift.index')}}" class="btn btn-light">{{__('Kembali')}}</a>

</form>
@endsection

@include('pages.penjadwalanshift.js')
@push("js")
<script>
    // initShift();
    initDevisi();
    initTingkat();
    initTimePicker();
    var date=new Date();
    var y = date.getFullYear()
    var m = date.getMonth()+1;
    var lastDay = new Date(y, m, 0).getDate();
    console.log(lastDay)
    initDateRangePickerMaksMonth();
    var _START_DATE = y+"/"+m+"/01";
    var _END_DATE = y+"/"+m+"/"+lastDay;
    var _DATERANGE = getDatesRange(_START_DATE,_END_DATE);
    _COLUMNS = _COLUMNS_PRIMARY;
    _DATERANGE.forEach(e => {
        var date = e.split("-");
        _COLUMNS.push({'title':date[2],'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
    });
    $(".bulan").text(convertMonthToIndo(m-1));
    $(".tahun").text(y);

    function initDateRangePickerMaksMonth(){
        $(".daterangepicker-maks-month").daterangepicker({
            // singleDatePicker: true,
            linkedCalendars: false,
            startDate: $(".daterangepicker-maks-month").val(),
            showDropdowns: true,
            autoApply: true,
            maxDate:'t/m/Y', // ILINGNO CAK
            minYear: 1970,
            maxYear: new Date().getFullYear(),
            locale: {
                format: "DD/MM/YYYY",
            },
            dateLimit: {
                months: 1,
                days: -1,
            }

        },
        function (start, end, label) {
                $(".bulan").text(convertMonthToIndo(parseInt(start.format("M"))-1));
                $(".tahun").text(start.format("YYYY"));
                var dateRange = getDatesRange(start.format("YYYY-MM-DD"),end.format("YYYY-MM-DD"))
                var date_start = start.format("YYYY/MM/DD");
                var date_end = end.format("YYYY/MM/DD");
                var columns = _COLUMNS_PRIMARY;
                dateRange.forEach(e => {
                    var date = e.split("-");
                    console.log(date);
                    columns.push({'title':date[2],'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
                });
                console.log(columns)
                _TABLE.destroy();
                $("#datatable").empty();
                setDataTable(columns,date_start,date_end);
            }
        );
        $(".drp-calendar.right").hide();
        $(".drp-calendar.left").addClass("single");

        $(".calendar-table").on("DOMSubtreeModified", function () {
            var el = $(".prev.available").parent().children().last();
            if (el.hasClass("next available")) {
                return;
            }
            el.addClass("next available");
            el.append("<span></span>");
        });
    }

    $(document).ready(function() {
        $('.select2').select2();
    });


</script>
@endpush
