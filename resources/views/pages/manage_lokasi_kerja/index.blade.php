@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Manage Lokasi Kerja</h2>
    {{ Breadcrumbs::render('manage-lokasi-kerja') }}
@endsection
@section('header_action')
@if(getPermission('masterDataShift','C') || role('admin') || role('owner'))
<a href="{{route("-")}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endif
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
    <div class="col-md-5 ps-0">
        <input type="text" name="nama_pegawai" placeholder="Ketik Nama Pegawai" class="form-control h-100">
    </div>
    <div class="col-md-1 ps-0">
        <button type="button" class="btn btn-warning w-100 h-100 text-center btn-cari"><i class="fas fa-search"></i> Cari</button>
    </div>
</div>
@endif
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">
            <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
                <thead>
                    <tr className="fw-bolder text-muted">
                        <th>{{__('No')}}</th>
                        <th>{{__('Kode Lokasi')}}</th>
                        <th>{{__('Nama Lokasi')}}</th>
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
                        data: 'kode_lokasi',
                        name: 'kode_lokasi',
                    },{
                        data: 'nama',
                        name: 'nama',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');

    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
