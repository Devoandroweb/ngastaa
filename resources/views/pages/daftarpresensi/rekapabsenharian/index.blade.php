@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Rekab Absen harian</h2>
    {{ Breadcrumbs::render('presensi-rekap-harian') }}
@endsection
@section('header_action')
    <button class="btn btn-success"><span><span class="icon"><i class="far fa-file-excel"></i></span><span>Export Excel</span></span></button>
@endsection
@section('content')
<div class="row justify-content-end">
    <div class="col">
        <div class="input-group w-250p">
            <span class="input-affix-wrapper">
                <label class="me-2" for="">Bulan : <span class="bulan badge badge-danger"></span></label>
                <label for="">Tahun : <span class="tahun badge badge-info"></span></label>
            </span>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group float-end">
            <div class="input-group">
                <span class="input-affix-wrapper">
                    <div class="row w-300p">
                        <label for="" class="col-sm-3 col-form-label">Divisi : </label>
                        <div class="col-sm-9 ps-0">
                            <select name="skpd" class="form-control divisi px-2" id="">
                                <option selected value="0">Semua Divisi</option>
                                @foreach ($skpd as $s)
                                    <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
    <div class="col-3 text-end">
        <div class="form-group w-100 float-end">
            <div class="input-group">
                <span class="input-affix-wrapper">
                    <span class="input-prefix"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span></span>
                    <input type="text" class="form-control pe-0 daterangepicker-maks-month" value="{{date('01/m/Y') ." - ". date('t/m/Y')}}">
                    <div id="displayRegervation"></div>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="border-bottom mb-3"></div>
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div id="datatable"></div>
    </div>
</div>

@endsection
@push('js')
    <script>
        initDateRangePickerMaksMonth();
        // "use strict";
        var date=new Date();
        var d = date.getDate()
        var y = date.getFullYear()
        var m = date.getMonth()+1;
        var lastDay = new Date(y, m, 0).getDate();
        var datatableElement = '<table id="data" class="table mt-2 nowrap w-100 mb-5 table-bordered"></table>';
        const _COLUMNS = [
            {'title':'No','data':'DT_RowIndex', 'orderable':false ,'searchable': false},
            {'title':'Jabatan','data':'jabatan','name':'jabatan','searchable': false},
            {'title':'Nip','data':'nip','name':'nip'},
            {'title':'Nama Pegawai','data':'nama_pegawai','name':'name','searchable': false},
        ];
        var _START_DATE = y+"/"+m+"/01";
        var _END_DATE = y+"/"+m+"/"+lastDay;
        var _TABLE = null;
        var _DATERANGE = getDatesRange(_START_DATE,_END_DATE);
        
        _DATERANGE.forEach(e => {
            var date = e.split("-");
            _COLUMNS.push({'title':date[2],'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
        });
        $(".bulan").text(convertMonthToIndo(m-1));
        $(".tahun").text(y);
       
        setDataTable(_COLUMNS,_START_DATE,_END_DATE);
        function setDataTable(columns,start_date,end_date) {
            // console.log(_URL_DATATABLE)
            $("#datatable").html(datatableElement);
            var options = {
                    searchDelay: 100,
                    responsive:true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{route("presensi.rekapabsen.datatable")}}?date_start='+start_date+'&date_end='+end_date,
                    },
                    rowReorder: {
                        selector: 'td:nth-child(1)'
                    },
                    language:{
                        searchPlaceholder: "Cari",
                        search: ""
                    },
                    columns: columns,
                }

            _TABLE = $('#data').DataTable(options);
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        function initDateRangePickerMaksMonth(){
            $(".daterangepicker-maks-month").daterangepicker({
                // singleDatePicker: true,
                linkedCalendars: false,
                startDate: $(".daterangepicker-maks-month").val(),
                showDropdowns: true,
                autoApply: true,
                maxDate:(d+"/"+m+"/"+y), // ILINGNO CAK
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
                    var col = [
                        {'title':'No','data':'DT_RowIndex', 'orderable':false ,'searchable': false},
                        {'title':'Jabatan','data':'jabatan','name':'jabatan','searchable': false},
                        {'title':'Nip','data':'nip','name':'nip'},
                        {'title':'Nama Pegawai','data':'nama_pegawai','name':'name','searchable': false},
                    ];
                    dateRange.forEach(e => {
                        var date = e.split("-");
                        col.push({'title':date[2],'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
                    });
                    // console.log("ini primary",_COLUMNS_PRIMARY)
                    console.log(col)
                    _TABLE.destroy();
                    _TABLE = null;
                    $("#datatable").empty();
                    setDataTable(col,date_start,date_end);
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

    </script>
    
@endpush

