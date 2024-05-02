@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tingkat Jabatan</h2>
    {{ Breadcrumbs::render('tingkat-jabatan') }}
@endsection
@section('header_action')
<a href="{{route('master.tingkat.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endsection
@section('content')
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(role('owner') || role('admin') || role('finance'))
<div class="input-group me-3 mb-3 ">
    <span class="input-affix-wrapper">

        <div class="row w-50 ms-auto">
            <div class="col-sm-12 ps-0">
                <select name="skpd" class="form-control divisi px-2" id="">
                    <option selected value="0">Semua Divisi</option>
                    @foreach ($skpd as $s)
                        <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </span>
</div>
@endif
<table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>No</th>
            <th>Nama Divisi</th>
            <th>Kode Tingkat</th>
            <th>Nama Tingkat</th>
            <th>Nama Level Jabatan</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

@endsection
@push('js')

    <script >

        var _TABLE = null;
        var _URL_DATATABLE = '{{url("master/tingkat/datatable")}}';
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
                    searchPlaceholder: "Cari Data Divisi",
                    search: ""
                },
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },{
                        data: 'nama_skpd',
                        name: 'nama_skpd',
                    },{
                        data: 'kode_tingkat',
                        name: 'kode_tingkat',
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'nama_eselon',
                        name: 'kode_eselon',
                    },{
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $(".divisi").select2();
        $('.divisi').on('select2:select', function (e) {
            var data = e.params.data;
            _TABLE.ajax.url(_URL_DATATABLE+"?kode_skpd="+data.id).load()
        });
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
