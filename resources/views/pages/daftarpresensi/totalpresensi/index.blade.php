@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Total Presensi</h2>
    {{ Breadcrumbs::render('presensi-total-presensi') }}
@endsection
@section('header_action')
<div class="input-group ">
    <span class="input-affix-wrapper">
        <div class="row w-300p">
            <div class="col-sm-11 ps-0">
                <select name="skpd" class="form-control periode_bulan px-2" id="">
                    @foreach ($periodeBulan as $s)
                    @php
                        $periode = explode("-",$s);
                    @endphp
                        <option value="{{$s}}">{{bulan($periode[1])." ".$periode[0]}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </span>
</div>
<div class="input-group">
    <span class="input-affix-wrapper">
        <div class="row w-300p">
            <div class="col-sm ps-0">
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
@endsection
@section('content')

<style>
    tr td:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4)):hover
    {
        cursor: pointer;
        background: #0d6efd;
        color:#fff;
        transition: background 0.5s;
    }
    tr td:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4))
    {
        color: #0d6efd;
    }
    td:hover a{
        color:#fff;
    }
</style>
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">
            <table class="table table-bordered" id="data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jabatan</th>
                        <th>Nip</th>
                        <th>Nama</th>
                        <th>Masuk</th>
                        <th>Telat</th>
                        <th>Tidak Masuk</th>
                        <th>Izin</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    var _TABLE = null;
    var _PERIODE_BULAN = 0;
    var _SKPD = 0;
    var _URL_DATATABLE = '{{route("presensi.total_presensi.datatable")}}?periode_bulan='+_PERIODE_BULAN+"&skpd="+_SKPD;

    $(".divisi").select2();
    $(".periode_bulan").select2({
        placeholder: "Periode Bulan",
        allowClear: true
    });
    $(".divisi").on("select2:select",function(e){
        var data = e.params.data;
        _SKPD = data.id;
        refreshDatatable()
    });
    $(".periode_bulan").on("select2:select",function(e){
        var data = e.params.data;
        _PERIODE_BULAN = data.id;
        refreshDatatable()
    });

    setDataTable();
    function setDataTable() {
        _TABLE = $('#data').DataTable({
            responsive:true,
            processing: true,
            serverSide: true,
            ajax: {
                url: _URL_DATATABLE,
            },
            rowReorder: {
                selector: 'td:nth-child(1)'
            },
            language:{
                searchPlaceholder: "Cari",
                search: ""
            },
            columns: [{
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width:"5%",
                    className:"text-center"
                },{
                    data: 'jabatan',
                    name: 'jabatan',
                },{
                    data: 'nip',
                    name: 'nip',
                },{
                    data: 'nama_pegawai',
                    name: 'name',
                },{
                    data: 'masuk',
                    name: 'masuk',
                    searchable:false,
                    className:"absen",
                    'createdCell':  function (td, cellData, rowData, row, col) {
                            $(td).attr('href', rowData.href_masuk);
                    }
                },{
                    data: 'telat',
                    name: 'telat',
                    searchable:false,
                    className:"absen",
                    'createdCell':  function (td, cellData, rowData, row, col) {
                            $(td).attr('href', rowData.href_telat);
                    }
                },{
                    data: 'alfa',
                    name: 'alfa',
                    searchable:false,
                    className:"absen",
                    'createdCell':  function (td, cellData, rowData, row, col) {
                            $(td).attr('href', rowData.href_alfa);
                    }
                },{
                    data: 'izin',
                    name: null,
                    searchable:false,
                    className:"absen",
                    'createdCell':  function (td, cellData, rowData, row, col) {
                            $(td).attr('href', rowData.href_izin);
                    }
                }],

        });
    }

    function refreshDatatable() {
        _URL_DATATABLE = '{{route("presensi.total_presensi.datatable")}}?skpd='+_SKPD+'&periode_bulan='+_PERIODE_BULAN;
        _TABLE.ajax.url(_URL_DATATABLE).load()
     }
    $('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
    // setTimeout(() => {
    //     _TABLE.ajax.url(_URL_DATATABLE+'?skpd=3').load()
    // }, 3000);
    $(document).on("click",".absen", function (e) {
        redirect($(this).attr('href'));
    });
</script>

@endpush
