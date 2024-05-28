
@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Laporan Aktifitas</h2>
    {{ Breadcrumbs::render('laporan-aktifitas') }}
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
    #foto:hover{
        height: 380px !important;
        transition: height 0.5s;
    }
    #foto{
        height: 200px;
        transition: height 0.5s;
    }
</style>
<table id="data" class="table table-bordered nowrap w-100 mb-5 table-responsive">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>{{__('No')}}</th>
            <th>{{__('No. Pegawai Nama')}}</th>
            <th>{{__('Jabatan')}}</th>
            <th>{{__('Jam Mulai')}}</th>
            <th>{{__('Jam Selesai')}}</th>
            <th>{{__('Tanggal')}}</th>
            <th>{{__('Keterangan')}}</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div class="modal fade" id="located-panel" tabindex="-1" role="dialog" aria-labelledby="located-panel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Lokasi Aktifitas</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="d-none d-md-block">
                    <table class="table table-bordered w-100">
                        <tr>
                            <td width="15%" class="fw-bold">Nama Pegawai</td>
                            <td class="nama_pegawai"></td>
                            <td class="fw-bold">Jabatan</td>
                            <td colspan="3" class="jabatan"></td>
                        </tr>
                        <tr>
                            <td width="15%" class="fw-bold">Tanggal</td>
                            <td class="tanggal"></td>
                            <td width="15%" class="fw-bold">Jam Mulai</td>
                            <td colspan="3" class="jam_mulai"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Keterangan</td>
                            <td colspan="3" class="keterangan"></td>
                        </tr>
                    </table>
                </div>
                <div class="d-block d-md-none">
                    <table class="table table-bordered w-100">
                        <tr>
                            <td width="15%" class="fw-bold">Nama Pegawai</td>
                            <td class="nama_pegawai"></td>
                        </tr>
                        <tr>
                            <td width="15%" class="fw-bold">Jam Mulai</td>
                            <td colspan="3" class="jam_mulai"></td>
                        </tr>
                        <tr>
                            <td width="15%" class="fw-bold">Tanggal</td>
                            <td class="tanggal"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jabatan</td>
                            <td class="jabatan"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Keterangan</td>
                            <td class="keterangan"></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{-- maps --}}
                        <div class="position-relative">
                            <div id="map" class="mb-4 img-thumbnail" style="height: 400px"></div>
                            <div id="none-map" class="mb-4 position-relative img-thumbnail" style="height: 500px; display:none">
                                <img class="m-auto w-25" src="{{asset('dist/img/route-not-found.png')}}" style="position:absolute;top:35%;left:35%">
                            </div>
                            <input type="hidden" value="0" id="radius" >
                            <div class="position-absolute" style="position: absolute;top: 10px;z-index: 999;right: 10px;">
                                <img src="" id="foto" class="img-fluid img-thumbnail" alt="" srcset="">
                            </div>
                        </div>
                        {{-- end maps --}}
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
    <script>
        var ltlgOld = ('-8.1277966,112.7509655').split(",");
    </script>
    <script src="{{asset('/')}}maps.js"></script>

    <script >

        var _TABLE = null;
        var _URL_DATATABLE = '{{route("presensi.aktifitas.datatable")}}';
        $(".divisi").select2();

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
                    searchPlaceholder: "Cari Nama Pegawai",
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
                        data: 'jabatan',
                        name: 'jabatan',
                    },{
                        data: 'jam_mulai',
                        name: 'jam_mulai',
                        searchable: false,
                    },{
                        data: 'jam_selesai',
                        name: 'jam_selesai',
                        searchable: false,
                    },{
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                    },{
                        data: 'keterangan',
                        name: 'keterangan',
                        searchable: false,
                    }],
            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $('#data tbody').on('click', 'tr', function (e) {
            var data = _TABLE.row(this).data();
            console.log(data)
            var ltlg = [0,0];
            if(data.koordinat != null && data.koordinat != ''){
                $("#map").show()
                $("#none-map").hide()
                ltlg = (data.koordinat).split(",");
                if(ltlg.length == 1){
                    ltlg = (data.koordinat).split(" ")
                }
                setTimeout(function() {
                    updateMap(ltlg);
                    map.invalidateSize();
                }, 1000);
                console.log(ltlg.length);
            }else{
                $("#map").hide()
                $("#none-map").show()
                Swal.fire(
                  'Lokasi',
                  'Lokasi tidak di temukan',
                  'warning'
                )
            }
            shootToModal(data);
            var myModal = new bootstrap.Modal($("#located-panel"))
            myModal.show();

        });
        function shootToModal(data){
            $(".jam_mulai").html(data.jam_mulai)
            $(".nama_pegawai").html(data.nama_pegawai)
            $(".jabatan").text(data.jabatan)
            $(".tanggal").text(data.created_at)
            $("#foto").attr("src",data.foto)
            $(".keterangan").html(data.keterangan)
        }

    </script>

@endpush
