@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penjadwalan Shift</h2>
    {{-- {{ Breadcrumbs::render('shift') }} --}}
@endsection
@section('header_action')
<a href="{{route('presensi.penjadwalanshift.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endsection
@section('content')
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">

            <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
                <thead>
                    <tr className="fw-bolder text-muted">
                        <th>{{__('No')}}</th>
                        <th>{{__('Divisi')}}</th>
                        <th>{{__('Level')}}</th>
                        <th>{{__('Tingkat')}}</th>
                        <th>{{__('Shift')}}</th>
                        <th>{{__('Jam Datang')}}</th>
                        <th>{{__('Jam Istirahat')}}</th>
                        <th>{{__('Jam Pulang')}}</th>
                        <th>{{__('Toleransi Datang')}}</th>
                        <th>{{__('Toleransi Istirahat')}}</th>
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
                
    //     var _TABLE = null;
    //     var _URL_DATATABLE = '';
    //     // var _URL_DATATABLE = '{{url("master/shift/datatable")}}';
    //     // SESUAIKAN COLUMN DATATABLE
    //     // SESUAIKAN FIELD EDIT MODAL
    //     setDataTable();
    //     function setDataTable() {
    //         _TABLE = $('#data').DataTable({
    //             responsive:true,
    //             processing: true,
    //             serverSide: true,
    //             ajax: {
    //                 url: _URL_DATATABLE,
    //             },
    //             rowReorder: {
    //                 selector: 'td:nth-child(1)'
    //             },
    //             language:{
    //                 searchPlaceholder: "Cari",
    //                 search: ""
    //             },
    //             columns: [{
    //                     "data": 'DT_RowIndex',
    //                     orderable: false,
    //                     searchable: false,
    //                 },{
    //                     data: 'opsi',
    //                     name: 'opsi',
    //                     orderable: false,
    //                     searchable: false
    //                 },{
    //                     data: 'nip',
    //                     name: 'nip',
    //                 },{
    //                     data: 'nama',
    //                     name: 'nama',
    //                 },{
    //                     data: 'divisi',
    //                     name: 'divisi',
    //                 },{
    //                     data: 'level',
    //                     name: 'level',
    //                 },{
    //                     data: 'tingkat',
    //                     name: 'tingkat',
    //                 },{
    //                     data: 'shift',
    //                     name: 'shift',
    //                 },{
    //                     data: 'jam_buka_datang',
    //                     name: 'jam_buka_datang',
    //                 },{
    //                     data: 'jam_buka_istirahat',
    //                     name: 'jam_buka_istirahat',
    //                 },{
    //                     data: 'jam_buka_pulang',
    //                     name: 'jam_buka_pulang',
    //                 },{
    //                     data: 'jam_toleransi_datang',
    //                     name: 'jam_toleransi_datang',
    //                 },{
    //                     data: 'jam_toleransi_istirahat',
    //                     name: 'jam_toleransi_istirahat',
    //                 },{
    //                     data: 'jam_toleransi_pulang',
    //                     name: 'jam_toleransi_pulang',
    //                 }],
                    
    //         });
    //     }
	// 	$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');

    </script>
    {{-- <script src="{{asset('/')}}delete.js"></script> --}}
    
@endpush
