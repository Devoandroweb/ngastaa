@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Pengajuan Izin</h2>
    {{ Breadcrumbs::render('pengajuan-cuti') }}
@endsection
@section('content')
@include('pages.datapengajuan.alert-style')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
    <thead>
        <tr>
            <th>{{__('No')}}</th>
            <th>{{__('No. Pegawai Nama')}}</th>
            <th>{{__('Jenis Izin')}}</th>
            <th>{{__('Tanggal Mulai')}}</th>
            <th>{{__('Tanggal Selesai')}}</th>
            <th>{{__('Keterangan')}}</th>
            <th>{{__('Status')}}</th>
            <th>{{__('Opsi')}}</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

@endsection
@push('js')
    <script >
                
        var _TABLE = null;
        var _URL_DATATABLE = '{{url("pengajuan/cuti/datatable")}}';
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        setDataTable();
        function setDataTable() {
            _TABLE = $('#data').DataTable({
                
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
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'cuti',
                        name: 'cuti',
                    },{
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai',
                    },{
                        data: 'tanggal_selesai',
                        name: 'tanggal_selesai',
                    },{
                        data: 'keterangan',
                        name: 'keterangan',
                    },{
                        data: 'status',
                        name: 'status',
                    },{
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    }],
                    
            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        
    </script>
    <script src="{{asset('/')}}approval.js"></script>
@endpush
