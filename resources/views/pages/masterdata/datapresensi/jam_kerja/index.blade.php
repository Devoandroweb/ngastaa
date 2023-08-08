@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Jam Kerja</h2>
    {{ Breadcrumbs::render('shift') }}
@endsection
@section('header_action')
@if(getPermission('masterDataJamKerja','C') || role('admin') || role('owner'))
<a href="{{route("master.jam_kerja.add")}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endif
@endsection
@section('content')
<style>
    /* Custom Animation for Modal Fade Top */
    @keyframes modalFadeInTop {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes modalFadeOutTop {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }

    .fade-top .modal-dialog {
        animation: modalFadeInTop 0.3s;
    }

    /* Add this class to apply fade-out animation when closing the modal */
    .fade-out-top .modal-dialog {
        animation: modalFadeOutTop 0.3s;
    }
</style>
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
                        <th>{{__('Opsi')}}</th>
                        <th>{{__('Kode')}}</th>
                        <th>{{__('Nama Shift')}}</th>
                        @for ($i=1;$i<=7;$i++)
                        <th>{{hari($i)}}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade fade-top" id="modalDetailJam" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script >
        var _ModalShiftJam = new bootstrap.Modal(document.getElementById('modalDetailJam'));
        var _TABLE = null;
        var _URL_DATATABLE = '{{url("master/jam_kerja/datatable")}}';

        // $(document).on("click",".detail-jam", function () {
        //     var data = $(this).data('json');
        //     console.log(data)
        // });
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        setDataTable();
        function setDataTable() {
            var _COLUMN = [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },{
                        data: 'opsi',
                        name: 'opsi',
                        orderable: false,
                        searchable: false
                    },{
                        data: 'kode',
                        name: 'kode',
                    },{
                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'senin',
                        name: 'senin',
                    },{
                        data: 'selasa',
                        name: 'selasa',
                    },{
                        data: 'rabu',
                        name: 'rabu',
                    },{
                        data: 'kamis',
                        name: 'kamis',
                    },{
                        data: 'jumat',
                        name: 'jumat',
                    },{
                        data: 'sabtu',
                        name: 'sabtu',
                    },{
                        data: 'minggu',
                        name: 'minggu',
                    }
                ];

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
                columns: _COLUMN,
                "rowCallback": function( row, data ) {
                    // console.log(data)
                }

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $(document).on('click', '.detail-jam', function () {
            var hari = $(this).data('hari');
            var parent = $(this).data('parent');
            var tipe = $(this).data('tipe');

            var data = _TABLE.row($(this).closest('tr')).data()
            var kodeJamKerja = data.kode
            var namaJamKerja = data.nama
            var hariJamKerja = null;
            if(tipe == 1){
                hariJamKerja = JSON.parse(data[parent+"_json"])
            }else{
                hariJamKerja = JSON.parse(data[hari+"_json"])
            }
            var htmlCol = "";

            var row = `<div class="row mb-4 text-dark">
                        #COL#
                    </div>`;
            var col = `<div class="col-12 col-sm-4 text-center mb-4">
                            <p>#LABEL#</p>
                            <b>#VALUE#</b>
                        </div>`;

            var jsonData = [
                {label:"Jam Buka Datang",key:"jam_buka_datang"},
                {label:"Jam Tepat Datang",key:"jam_tepat_datang"},
                {label:"Jam Tutup Datang",key:"jam_tutup_datang"},
                {label:"Jam Buka Istirahat",key:"jam_buka_istirahat"},
                {label:"Jam Tepat Istirahat",key:"jam_tepat_istirahat"},
                {label:"Jam Tutup Istirahat",key:"jam_tutup_istirahat"},
                {label:"Jam Buka Pulang",key:"jam_buka_pulang"},
                {label:"Jam Tepat Pulang",key:"jam_tepat_pulang"},
                {label:"Jam Tutup Pulang",key:"jam_tutup_pulang"},
            ]
            $("#modalTitleId").html(`${namaJamKerja} (${kodeJamKerja}) | <span class="text-capitalize">${hari}</span>`)
            jsonData.forEach(element => {
                var colAttach = "";
                colAttach += col.replace("#LABEL#",element.label);
                colAttach = colAttach.replace("#VALUE#",hariJamKerja[element.key]);
                htmlCol += colAttach;
            });
            html = row.replace("#COL#",htmlCol)
            $("#modal-body").html(html)
            _ModalShiftJam.show()
        })
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
