@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Shift</h2>
    {{ Breadcrumbs::render('shift') }}
@endsection
@section('header_action')
@if(getPermission('masterDataShift','C') || role('admin') || role('owner'))
<a href="{{route("master.shift.add")}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
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
                        <th>{{__('Kode')}}</th>
                        <th>{{__('Nama Shift')}}</th>
                        <th>{{__('Jam Buka Datang')}}</th>
                        <th>{{__('Jam Tepat Datang')}}</th>
                        <th>{{__('Jam Tutup Datang')}}</th>
                        <th>{{__('Toleransi Datang')}}</th>
                        <th>{{__('Jam Buka Istirahat')}}</th>
                        <th>{{__('Jam Tepat Istirahat')}}</th>
                        <th>{{__('Jam Tutup Istirahat')}}</th>
                        <th>{{__('Toleransi Istirahat')}}</th>
                        <th>{{__('Jam Buka Pulang')}}</th>
                        <th>{{__('Jam Tepat Pulang')}}</th>
                        <th>{{__('Jam Tutup Pulang')}}</th>
                        <th>{{__('Toleransi Pulang')}}</th>

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
        var _URL_DATATABLE = '{{url("master/shift/datatable")}}';
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
                        data: 'kode_shift',
                        name: 'kode_shift',
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'jam_buka_datang',
                        name: 'jam_buka_datang',
                    },{
                        data: 'jam_tepat_datang',
                        name: 'jam_tepat_datang',
                    },{
                        data: 'jam_tutup_datang',
                        name: 'jam_tutup_datang',
                    },{
                        data: 'toleransi_datang',
                        name: 'toleransi_datang',
                    },{
                        data: 'jam_buka_istirahat',
                        name: 'jam_buka_istirahat',
                    },{
                        data: 'jam_tepat_istirahat',
                        name: 'jam_tepat_istirahat',
                    },{
                        data: 'jam_tutup_istirahat',
                        name: 'jam_tutup_istirahat',
                    },{
                        data: 'toleransi_istirahat',
                        name: 'toleransi_istirahat',
                    },{
                        data: 'jam_buka_pulang',
                        name: 'jam_buka_pulang',
                    },{
                        data: 'jam_tepat_pulang',
                        name: 'jam_tepat_pulang',
                    },{
                        data: 'jam_tutup_pulang',
                        name: 'jam_tutup_pulang',
                    },{
                        data: 'toleransi_pulang',
                        name: 'toleransi_pulang',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');

    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
