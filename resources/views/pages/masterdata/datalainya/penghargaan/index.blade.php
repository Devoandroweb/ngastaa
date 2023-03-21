@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penghargaan</h2>
    {{ Breadcrumbs::render('penghargaan') }}
@endsection
@section('header_action')
<a href="{{route('master.penghargaan.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endsection
@section('content')
<table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>{{__('No')}}</th>
            <th>{{__('Kode Penghargaan')}}</th>
            <th>{{__('Nama Penghargaan')}}</th>
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
        var _URL_DATATABLE = '{{url("master/penghargaan/datatable")}}';
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
                        data: 'kode_penghargaan',
                        name: 'kode_penghargaan',
                    },{
                        data: 'nama',
                        name: 'nama',
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
    
@endpush
