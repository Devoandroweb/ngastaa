@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Manage Lokasi Kerja</h2>
    {{ Breadcrumbs::render('manage-lokasi-kerja') }}
@endsection
@section('header_action')
<a href="#" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
{{-- @if(getPermission('masterDataShift','C') || role('admin') || role('owner'))
@endif --}}
@endsection
@section('content')
@if(role('owner') || role('admin') || role('finance'))
<div class="row mb-4 m-auto">
    <div class="col-md-3 ps-0">
        <select name="kode_skpd" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Divisi</option>
            @foreach ($skpd as $s)
                @if((Session::get('current_select_skpd')['pegawai'] ?? 0) == $s->kode_skpd)
                <option value="{{$s->kode_skpd}}" @selected(true)>{{$s->nama}}</option>
                @else
                <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
@endif
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">
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
                        <th>{{__('Nama Divisi')}}</th>
                        <th>{{__('Kode Lokasi')}}</th>
                        <th>{{__('Nama Lokasi')}}</th>
                        <th>{{__('Total Pegawai')}}</th>
                        <th>{{__('Opsi')}}</th>
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
        var _URL_DATATABLE = '{{route("manage_lokasi_kerja.datatable")}}';
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
                        data: 'divisi',
                        name: 'divisi',
                    },{
                        data: 'kode_lokasi',
                        name: 'kode_lokasi',
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'total_pegawai',
                        name: 'total_pegawai',
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
