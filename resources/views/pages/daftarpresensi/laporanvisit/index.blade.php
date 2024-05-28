@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Laporan Visit</h2>
    {{ Breadcrumbs::render('laporan-visit') }}
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
@if(role('owner') || role('admin') || role('finance'))
<h4>Filter</h4>
<div class="row mb-4 mx-auto">
    <div class="col-md-4 ps-0">
        <select name="kode_skpd" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Divisi</option>
            @foreach ($skpd as $s)
                @if((Session::get('current_select_skpd') ?? 0) == $s->kode_skpd)
                <option value="{{$s->kode_skpd}}" @selected(true)>{{$s->nama}}</option>
                @else
                <option value="{{$s->kode_skpd}}">{{$s->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 ps-0">
        <select name="jenis_visit" class="form-control px-2" id="">
            <option selected value="null" >Semua Jenis</option>
            <option value="0">Visit Baru</option>
            <option value="1">Visit Lama</option>
        </select>
    </div>
    <div class="col-md-4 ps-0">
        <select name="kode_tingkat" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Tingkat Jabatan</option>
            @foreach ($tingkatJabatan as $t)
                @if((Session::get('current_select_kode_tingkat') ?? 0) == $t->kode_tingkat)
                <option value="{{$t->kode_tingkat}}" @selected(true)>{{$t->nama}}</option>
                @else
                <option value="{{$t->kode_tingkat}}">{{$t->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="row mx-auto">
    <div class="col-md-5 ps-0">
        <select class="form-control form-control-lg" name="nip_pegawai[]" id="select-pegawai-nip" multiple size="1"></select>
    </div>
    <div class="col-md-5 ps-0">
        <input type="text" name="nama_pegawai" placeholder="Ketik Nama Pegawai" class="form-control h-100">
    </div>
    <div class="col-md-2 ps-0 d-flex align-items-center">
        <button type="button" class="btn btn-warning w-100 text-center text-nowrap btn-cari"><i class="fas fa-search"></i> Cari</button>
    </div>
</div>
<hr>
@endif
<table id="data" class="table table-bordered nowrap w-100 mb-5 table-responsive">
    <thead>
        <tr className="fw-bolder text-muted">
            <th>{{__('No')}}</th>
            <th>{{__('Jenis Visit')}}</th>
            <th>{{__('No. Pegawai Nama')}}</th>
            <th>{{__('Jabatan')}}</th>
            <th>{{__('Tanggal')}}</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div class="modal fade" id="located-panel" tabindex="-1" role="dialog" aria-labelledby="located-panel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Lokasi Visit</h5>
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
        var _URL_DATATABLE = '{{route("presensi.laporan_visit.datatable")}}';
        $(".divisi").select2();
        initPegawaiNip("{{route('pegawai.pegawai.json')}}?kode_skpd=0")
        setDataTable();
        $(".btn-cari").click(function(e){
            filterPegawai($("[name=kode_skpd]").val(),$('[name=nama_pegawai]').val(),$('[name=jenis_visit]').val(),$('select[name="nip_pegawai[]"]').val(),$('select[name="kode_tingkat"]').val())
        })
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

                        data: 'jenis_visit',
                        name: 'jenis_visit',
                    },{

                        data: 'nama',
                        name: 'nama',
                    },{
                        data: 'jabatan',
                        name: 'jabatan',
                    },{
                        data: 'tanggal',
                        name: 'tanggal',
                    }],
            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $('#data tbody').on('click', 'tr', function (e) {
            var data = _TABLE.row(this).data();
            console.log(data)
            var ltlg = [0,0];
            if(data.kordinat != null && data.kordinat != ''){
                $("#map").show()
                $("#none-map").hide()
                ltlg = (data.kordinat).split(",");
                if(ltlg.length == 1){
                    ltlg = (data.kordinat).split(" ")
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
            $(".nama_pegawai").html(data.nama)
            $(".jabatan").text(data.jabatan)
            $(".tanggal").text(data.tanggal)
            $(".jam_mulai").text(data.created_at)
            $(".keterangan").text(data.tujuan_visit)
            $("#foto").attr("src",data.foto)

        }

        function initPegawaiNip(url,value_pegawai = null){
            let getPegawai = (url) => {
                var element = $('#select-pegawai-nip');
                let loading = loadingProccesText(element)
                $.ajax({url: url, success: function(data){
                    element.empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: `<b>${item['nip']}</b>`,
                            id: item['nip'],
                        }
                    })

                    element.removeAttr("disabled")
                    element.select2({
                        placeholder:"Ketik beberapa NIP Pegawai",
                        data : data,
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        templateResult: function(data) {
                            return data.text;
                        },
                        templateSelection: function(data) {
                            return data.text;
                        }
                    }).val(null).change()
                }});
            }
            getPegawai(url);
        }
        function filterPegawai(kode_skpd,nama_pegawai,jenis_visit,nip_pegawai,kode_tingkat){
            _TABLE.ajax.url(_URL_DATATABLE+`?kode_skpd=${kode_skpd}&nama_pegawai=${nama_pegawai}&jenis_visit=${jenis_visit}&nip_pegawai=${nip_pegawai}&kode_tingkat=${kode_tingkat}`).load()
        }
    </script>

@endpush


