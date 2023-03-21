@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Detail Presensi Izin Pegawai</h2>
    {{ Breadcrumbs::render('presensi-total-presensi-detail') }}
@endsection
@section('header_action')
<div class="input-group">
    <span class="input-affix-wrapper">
        <label for="">Nama Pegawai : <span class="bulan badge badge-danger me-2">{{$user->nip}}</span><span class="tahun badge badge-dark">{{$user->getFullName()}}</span></label>
    </span>
</div>
@endsection
@section('content')
<div class="invoice-list-view">
    <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
        
    </table>
</div>
@endsection 

@push('js')
<script>
    var _COLUMNS = [
        {'title':'No','data':'DT_RowIndex', 'orderable':false ,'searchable': false,width:"5%",className:"text-center"},
        {'title':'Tanggal','data':'tanggal','name':'tanggal'},
        {'title':'Nama Izin','data':'nama_izin','name':'kode_cuti','searchable': false},
    ];
    var _TABLE = null;
    var _URL_DATATABLE = '{{route("presensi.total_presensi.datatable_detail_izin",$user->nip)}}';
    // SESUAIKAN COLUMN DATATABLE
    // SESUAIKAN FIELD EDIT MODAL
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
            columns: _COLUMNS,
                
        });
    }
    $('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
</script>
    
@endpush
