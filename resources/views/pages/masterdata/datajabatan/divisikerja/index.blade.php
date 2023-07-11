@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Divisi Kerja</h2>
    {{ Breadcrumbs::render('divisi-kerja') }}
@endsection
@section('header_action')
@if (getPermission('masterDataDivisiKerja','C') || role('admin') || role('owner'))
<a href="{{route('master.skpd.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endif
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
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Singkatan</th>
            <th>Koordinat</th>
            <th>Radius(m)</th>
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
        var _URL_DATATABLE = '{{url("master/skpd/datatable")}}';
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
                        data: 'kode_skpd',
                        name: 'kode_skpd',
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'singkatan',
                        name: 'singkatan',
                    },{
                        data: 'kordinat',
                        name: 'kordinat',
                    },{
                        data: 'jarak',
                        name: 'jarak',
                    },{
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $(document).on("click",".reset", function (e) {
            e.preventDefault();
            Swal.fire({
                html:
                '<div class="mb-3"><i class="ri-refresh-line fs-5 text-danger"></i></div><h5 class="text-danger">Yakin mereset data lokasi & radius?</h5><p>Data tidak dapat dikembalikan!.</p>',
                customClass: {
                    confirmButton: 'btn btn-outline-secondary text-danger',
                    cancelButton: 'btn btn-outline-secondary text-gray',
                    container:'swal2-has-bg'
                },
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                }
            })
        });

    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
