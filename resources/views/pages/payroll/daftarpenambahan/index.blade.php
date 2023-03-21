@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Daftar Penambahan</h2>
    {{ Breadcrumbs::render('daftar-penambahan') }}
@endsection
@section('header_action')
<a href="{{route('payroll.tambah.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>{{__('No')}}</th>
            <th>{{__('Nama Komponen')}}</th>
            <th>{{__('Periode')}}</th>
            <th>{{__('Berdasarkan')}}</th>
            <th>{{__('Detail')}}</th>
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
        var _URL_DATATABLE = '{{route("payroll.tambah.datatable")}}';
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
                        data: 'tanggal',
                        name: 'tanggal',
                    },{
                        data: 'keterangan',
                        name: 'keterangan',
                    },{
                        data: 'detail',
                        name: 'detail',
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
    <script src="{{asset('/')}}delete.js"></script>
    
@endpush
