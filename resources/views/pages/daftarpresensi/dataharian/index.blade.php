@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Presensi Harian</h2>
    {{ Breadcrumbs::render('presensi-harian') }}
@endsection
@section('header_action')
<div class="input-group">
    <span class="input-affix-wrapper">
        <div class="row w-300p">
            <label for="" class="col-sm-3 col-form-label">Divisi : </label>
            <div class="col-sm-9 ps-0">
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
<table id="data" class="table table-bordered nowrap w-100 mb-5 table-responsive">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>{{__('No')}}</th>
            <th>{{__('No. Pegawai Nama')}}</th>
            <th>{{__('Shift')}}</th>
            <th>{{__('Jabatan')}}</th>
            <th>{{__('Tanggal')}}</th>
            <th>{{__('Jam Datang')}}</th>
            <th>{{__('Jam Istirahat')}}</th>
            <th>{{__('Jam Pulang')}}</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<div class="modal fade" id="located-panel" tabindex="-1" role="dialog" aria-labelledby="located-panel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Lokasi Absen</h5>
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
                            <td width="15%" class="fw-bold">Tanggal</td>
                            <td class="tanggal"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jabatan</td>
                            <td class="jabatan"></td>
                            <td class="fw-bold">Jam Datang</td>
                            <td class="jam_datang"></td>
                            
                        </tr>
                        <tr>
                            <td class="fw-bold">Shift</td>
                            <td class="shift"></td>
                            <td class="fw-bold">Jam Istirahat</td>
                            <td class="jam_istirahat"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Lokasi</td>
                            <td class="lokasi"></td>
                            <td class="fw-bold">Jam Pulang</td>
                            <td class="jam_pulang"></td>
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
                            <td class="fw-bold">Jabatan</td>
                            <td class="jabatan"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Shift</td>
                            <td class="shift"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Lokasi</td>
                            <td class="lokasi"></td>
                        </tr>
                        <tr>
                            <td width="15%" class="fw-bold">Tanggal</td>
                            <td class="tanggal"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jam Datang</td>
                            <td class="jam_datang"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jam Istirahat</td>
                            <td class="jam_istirahat"></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jam Pulang</td>
                            <td class="jam_pulang"></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12 col-md-7">
                        {{-- maps --}}
                        <div id="map" class="mb-4" style="height: 500px"></div>
                        <input type="hidden" value="0" id="radius" >
                        {{-- end maps --}}
                    </div>
                    <div class="col-12 col-md-5">
                        <img src="" id="foto_datang" class="img-fluid" alt="" srcset="">
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
    <script src='{{asset('/')}}vendors/turfjs/turf.js'></script>
    {{-- <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script> --}}

    <script >
        
        var _TABLE = null;
        var _URL_DATATABLE = '{{url("pengajuan/presensi/datatable")}}';
        $(".divisi").select2();
        $(".divisi").on("select2:select",function(e){
            var data = e.params.data;
            _URL_DATATABLE = '{{url("pengajuan/presensi/datatable")}}?skpd='+data.id;
            _TABLE.ajax.url(_URL_DATATABLE).load()
        });
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
                    searchPlaceholder: "Cari",
                    search: ""
                },
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },{

                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'shift',
                        name: 'data_presensi.kode_shift',
                    },{
                        data: 'jabatan',
                        name: 'jabatan',
                    },{
                        data: 'tanggal',
                        name: 'tanggal',
                    },{
                        data: 'jam_datang',
                        name: 'jam_datang',
                    },{
                        data: 'jam_istirahat',
                        name: 'jam_istirahat',
                    },{
                        data: 'jam_pulang',
                        name: 'jam_pulang',
                    }],
            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $('#data tbody').on('click', 'tr', function (e) {
            var data = _TABLE.row(this).data();
            console.log(data);
            var ltlg = [0,0];
            if(data.kordinat_datang != null){
                ltlg = (data.kordinat_datang).split(",");
            }
            shootToModal(data);
            var myModal = new bootstrap.Modal($("#located-panel"))
            myModal.show();
            setTimeout(function() {
                updateMap(ltlg);
                map.invalidateSize();
            }, 1000);
        });
        function shootToModal(data){
            $(".nama_pegawai").html(data.nama)
            $(".jabatan").text(data.jabatan)
            $(".jam_datang").text(data.jam_datang)
            $(".jam_pulang").text(data.jam_pulang)
            $(".jam_istirahat").text(data.jam_istirahat)
            $(".tanggal").text(data.tanggal)
            $(".shift").text(data.shift)
            $("#foto_datang").attr("src","{{url('public/images')}}/"+data.foto_datang)
            // $("#keterangan").text(data.keterangan)
            if(data.kordinat_datang != null){
                $(".lokasi").text(checkVisitLokasi(data.kordinat_datang))
            }
        }
        let lokasi = @json($dataLokasi);
        
        function checkVisitLokasi(location_target){
            var namaLokasi = "-";
            var location_target = (location_target).split(",");
            lokasi.forEach(e => {
                if((e.polygon).length == 0){
                    return;
                }
                // return;
                var polygon = {
                    type: 'Feature',
                    geometry: {
                        type: 'Polygon',
                        // Note order: longitude, latitude.
                        coordinates: [e.polygon]
                    },
                    properties: {}
                };
                // Note order: longitude, latitude.
                var turfKoor = [
                    parseFloat(location_target[1].split(" ").join("")),
                    parseFloat(location_target[0].split(" ").join(""))
                ];
        
                var point = turf.point(turfKoor);
                var isInside = turf.booleanPointInPolygon(point, polygon);
                console.log(isInside);
                if((e.polygon).length != 0){
                    L.polygon(JSON.parse(e.polygonAsli), { color: "red" }).addTo(drawnItems);
                }
                
                if(isInside){
                    namaLokasi = e.nama
                }
            });
            return namaLokasi;
        }
    </script>
    
@endpush
