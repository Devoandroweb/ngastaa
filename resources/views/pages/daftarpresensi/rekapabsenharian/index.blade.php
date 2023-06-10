@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Rekab Absen harian</h2>
    {{ Breadcrumbs::render('presensi-rekap-harian') }}
@endsection
@section('header_action')
    <button id="export-excel" class="btn btn-success me-3"><span><span class="icon"><i class="far fa-file-excel"></i></span><span>Export Excel</span></span></button>
    <button class="btn btn-info show-all"><span><span class="icon"><i class="far fa-file-excel"></i></span><span>Show All</span></span></button>
@endsection
@section('content')
<style>
    .dt-button{
        display: none;
    }
</style>
<div class="row justify-content-end">
    {{-- <div class="col">
        <div class="input-group w-250p">
            <span class="input-affix-wrapper">
                <label class="me-2" for="">Bulan : <span class="bulan badge badge-danger"></span></label>
                <label for="">Tahun : <span class="tahun badge badge-info"></span></label>
            </span>
        </div>
    </div> --}}
    <div class="col">
        <div class="form-group">
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
            {'title':'NO','data':'DT_RowIndex', 'orderable':false ,'searchable': false},
            {'title':'JABATAN','data':'jabatan','name':'jabatan','searchable': false},
            {'title':'NIP','data':'nip','name':'nip'},
            {'title':'','data':'nama_pegawai','name':'name','searchable': false},
        ];
        var _START_DATE = y+"/"+m+"/01";
        var _END_DATE = y+"/"+m+"/"+lastDay;
        var _TABLE_REKAP_HARIAN = null;
        var _KODE_SKPD = $(".divisi").val();
        console.log("divisi",_KODE_SKPD)
        var _DATERANGE = getDatesRange(_START_DATE,_END_DATE);

        // INIT ELEMENT
        $(".bulan").text(convertMonthToIndo(m-1));
        $(".tahun").text(y);
        $(".divisi").select2();
        _DATERANGE.forEach(e => {
            var date = e.split("-");
            var tanggal = new Date(e);
            var namaBulan = tanggal.toLocaleString('default', { month: 'long' });
            _COLUMNS.push({'title':`${namaBulan}-${date[2]}`,'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
        });
        _COLUMNS.push({'title':'REKAP','data':'rekap','name':null,'orderable':false ,'searchable': false})
        setDataTable(_COLUMNS,_START_DATE,_END_DATE);

        $('#export-excel').on('click', function () {
            Swal.fire({
              text: 'Apakah ingin meng-export data ini?',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya',
              cancelButtonText: 'Tidak',
            }).then((result) => {
              if (result.value) {
                _TABLE_REKAP_HARIAN.button(0).trigger();
              }
            })
        });
        $('.show-all').on('click', function () {
            _TABLE_REKAP_HARIAN.page.len(-1).draw();
        })
        $(".divisi").on("select2:select",function(e){
            _KODE_SKPD = e.params.data.id;
            setDataTable(_COLUMNS,_START_DATE,_END_DATE);
        });

		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');

        function setDataTable(columns,start_date,end_date) {
            // console.log(_URL_DATATABLE)
            $("#datatable").html(datatableElement);
            var options = {
                    searchDelay: 100,
                    responsive:false,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{route("presensi.rekapabsen.datatable")}}?date_start='+start_date+'&date_end='+end_date+'&kode_skpd='+_KODE_SKPD,
                    },
                    rowReorder: {
                        selector: 'td:nth-child(1)'
                    },
                    language:{
                        searchPlaceholder: "Cari",
                        search: ""
                    },
                    columns: columns,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'Rekap-absen',
                            className: 'btn btn-primary'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Rekap-absen'
                        }
                    ]
                }

            _TABLE_REKAP_HARIAN = $('#data').DataTable(options);
        }

        // FUNCTION
        function initDateRangePickerMaksMonth(){
            $(".daterangepicker-maks-month").daterangepicker({
                // singleDatePicker: true,
                // linkedCalendars: false,
                startDate: $(".daterangepicker-maks-month").val(),
                showDropdowns: true,
                autoApply: true,
                maxDate:(d+"/"+m+"/"+y), // ILINGNO CAK
                minYear: 1970,
                maxYear: new Date().getFullYear(),
                locale: {
                    format: "DD/MM/YYYY",
                },

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
                        var tanggal = new Date(e);
                        var namaBulan = tanggal.toLocaleString('default', { month: 'long' });
                        col.push({'title':`${namaBulan}-${date[2]}`,'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false})
                    });
                    col.push({'title':'REKAP','data':'rekap','name':null,'orderable':false ,'searchable': false})

                    // console.log("ini primary",_COLUMNS_PRIMARY)
                    console.log(col)
                    _TABLE_REKAP_HARIAN.destroy();
                    _TABLE_REKAP_HARIAN = null;
                    $("#datatable").empty();
                    setDataTable(col,date_start,date_end);
                }
            );
            // $(".drp-calendar.right").hide();
            // $(".drp-calendar.left").addClass("single");

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

