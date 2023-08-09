@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tambah Pegawai</h2>
    {{ Breadcrumbs::render('tambah-pegawai') }}
@endsection
@section('header_action')
@if(getPermission('masterDataShift','C') || role('admin') || role('owner'))
<a href="{{route("-")}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endif
@endsection
@section('content')
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">
            <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
                <thead>
                    <tr className="fw-bolder text-muted">
                        <th>{{__('No')}}</th>
                        <th>{{__('Opsi')}}</th>
                        <th>{{__('No Pegawai & Nama Lengkap')}}</th>
                        <th>{{__('Jabatan & Divisi')}}</th>
                        <th>{{__('Level')}}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script >

        var _TABLE = null;
        var _URL_DATATABLE = '{{url("-")}}';
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
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    },{
                        data: 'nama',
                        name: 'name',
                    },{
                        data: 'nama_jabatan',
                        name: 'nama_jabatan',
                    },{
                        data: 'level',
                        name: 'level',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');

    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
