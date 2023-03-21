@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Payroll Detail</h2>
    {{ Breadcrumbs::render('detail-generate-payroll') }}
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-6">
        <table class="float-end w-100 text-dark">
            <tr><td>Periode</td><td>:</td><td>{{bulan($generate->bulan)." ".$generate->tahun}}</td></tr>
            <tr><td width="15%">Divisi</td><td width="3%">:</td><td>{{$generate->kode_skpd == "" ? "Semua Divisi Kerja" : get_skpd($generate->kode_skpd)}}</td></tr>
            <tr><td>Status</td><td>:</td><td>{!!isActifBagde($generate->is_aktif)!!}</td></tr>
        </table>
    </div>
    <div class="col-12 col-md-6 text-center text-md-start">
        <div class="text-center">
            <small>Kode Payroll : </small>
            <h2 class="text-primary fw-bold">{{$generate->kode_payroll}}</h2>
        </div>
    </div>
    <hr>
    @if(session('messages'))
    <div class="alert alert-inv alert-inv-@if(session('type') == 'error'){{'danger'}}@else{{'success'}}@endif alert-wth-icon alert-dismissible fade show" role="alert">
        <span class="alert-icon-wrap"><i class="zmdi @if(session('type') == 'error') {{'zmdi-bug'}}  @else {{'zmdi-check-circle'}} @endif "></i></span> {{session('messages')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <table class="table table-bordered nowrap" id="data">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP & Nama Pegawai</th>
                <th>Jabatan & Divisi</th>
                <th>Gaji Pokok</th>
                <th>Total Tunjangan</th>
                <th>Total Potongan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    
</div>
@endsection

@push("js")
<script>
    var _TABLE = null;
        var _URL_DATATABLE = '{{route("payroll.generate.payrollDatatable",$generate)}}';
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        setDataTable();
        function setDataTable() {
            _TABLE = $('#data').DataTable({
                // responsive:true,
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
                        data: 'nama_pegawai',
                        name: 'nama_pegawai',
                    },{
                        data: 'jabatan_divisi',
                        name: 'jabatan_divisi',
                    },{
                        data: 'gaji_pokok',
                        name: 'gaji_pokok',
                    },{
                        data: 'total_penambahan',
                        name: 'total_penambahan',
                    },{
                        data: 'total_potongan',
                        name: 'total_potongan',
                    },{
                        data: 'total',
                        name: 'total',
                    },{
                        data: 'status',
                        name: 'status',
                    },{
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    }],
            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $(document).on("click",".approval", function (e) {
            e.preventDefault();
            Swal.fire({
                html:
                '<div class="mb-3"><i class="ri-delete-bin-6-line fs-5 text-danger"></i></div><h5 class="text-danger">Yakin ingin menghapus data ini?</h5><p>Data tidak dapat dikembalikan!.</p>',
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
                if (result.value) {
                    window.location.href = $(this).attr('href');
                }
            })
        });
    </script>
    
</script>
@endpush