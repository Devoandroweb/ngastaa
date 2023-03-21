@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Gaji Umk</h2>
    {{ Breadcrumbs::render('gaji-umk') }}
@endsection
@section('header_action')
<a href="{{route("master.payroll.umk.add")}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endsection
@section('content')
<div class="invoice-body">
    <div class="invoice-list-view">
        <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
            <thead>
                <tr className="fw-bolder text-muted">
                    <th>{{__('No')}}</th>
                    <th>{{__('Kode umk')}}</th>
                    <th>{{__('Nama umk')}}</th>
                    <th>{{__('Nominal')}}</th>
                    <th>{{__('kabupaten')}}</th>
                    <th>{{__('Tahun')}}</th>
                    <th>{{__('Opsi')}}</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('js')
    <script >
                
        var _TABLE = null;
        var _URL_DATATABLE = '{{route("master.payroll.umk.datatable")}}';
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
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },{
                        data: 'kode_umk',
                        name: 'kode_umk',
                    },{
                        data: 'nama_umk',
                        name: 'nama_umk',
                    },{
                        data: 'nominal',
                        name: 'nominal',
                    },{
                        data: 'kabupaten',
                        name: 'kabupaten',
                    },{
                        data: 'tahun',
                        name: 'tahun',
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
