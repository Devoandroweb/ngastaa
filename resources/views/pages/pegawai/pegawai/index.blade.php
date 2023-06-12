@extends('app')

@section('breadcrumps')
    <h2 class="pg-title">Data Pegawai</h2>
    {{ Breadcrumbs::render('detail-pegawai') }}
@endsection
@section('header_action')

<a href="{{route('pegawai.pegawai.import_add')}}" class="btn btn-success me-3"><i class="fas fa-file-import"></i> {{__('Import')}}</a>
<a href="{{route('pegawai.pegawai.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>

@endsection

@section('content')
<style>
    tbody tr:hover {
        background-color: rgb(221, 219, 219) !important;
        transition: background-color 0.5s;
        cursor: pointer;
    }
    tbody tr {
        background-color: auto;
        transition: background-color 0.5s;
    }
</style>
@if(role('owner') || role('admin'))
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
@if(session('messages'))
<div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
	<span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<table id="data" class="table hover mt-2 w-100 nowrap mb-5 table-responsive table-bordered">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>No</th>
            <th>Opsi</th>
            <th>Foto</th>
            <th>No Pegawai & Nama Lengkap</th>
            <th>Jabatan & Divisi</th>
            <th>Level</th>
            <th>Kuota Cuti</th>
            <th>No Hp & Email</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

@endsection
@push('js')
    <script >

        var _TABLE = null;
        var _URL_DATATABLE = '{{route("pegawai.pegawai.datatable")}}';
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        setDataTable();
        function setDataTable() {
            _TABLE = $('#data').DataTable({
                responsive:true,
                scrollX: true,
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
                        data: 'images',
                        name: 'images',
                    },{
                        data: 'nama',
                        name: 'name',
                    },{
                        data: 'nama_jabatan',
                        name: 'nama_jabatan',
                    },{
                        data: 'level',
                        name: 'level',
                    },{
                        data: 'cuti',
                        name: 'maks_cuti',
                    },{
                        data: 'no_hp',
                        name: 'no_hp',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $('#data tbody').on('click', 'tr td:not(:nth-child(-n + 2))', function (e) {
            var data = _TABLE.row(this).data();
            window.location.href = data.detail;
        });
        $(".divisi").select2();
        $('.divisi').on('select2:select', function (e) {
            var data = e.params.data;
            _TABLE.ajax.url(_URL_DATATABLE+"?kode_skpd="+data.id).load()
        });
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
