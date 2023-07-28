@extends('app')

@section('breadcrumps')
    <h2 class="pg-title">Data Pegawai</h2>
    {{ Breadcrumbs::render('detail-pegawai') }}
@endsection
@section('header_action')
@if(getPermission('pegawai','PK') || role('owner') || role('admin'))
<button type="button" class="btn btn-info me-3" id="btnModalKontrak"><i class="far fa-clock"></i> {{__('Perpanjang Kontrak')}}</button>
@endif
@if(getPermission('pegawai','E') || role('owner') || role('admin'))
<a href="{{route('pegawai.pegawai.export')}}" class="btn btn-danger me-3"><i class="fas fa-file-import"></i> {{__('Export')}}</a>
@endif
@if(getPermission('pegawai','I')  || role('owner') || role('admin'))
<a href="{{route('pegawai.pegawai.import_add')}}" class="btn btn-success me-3"><i class="fas fa-file-import"></i> {{__('Import')}}</a>
@endif
@if(getPermission('pegawai','C') || role('owner') || role('admin'))
<a href="{{route('pegawai.pegawai.add')}}" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
@endif
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
    .select2-container--open .select2-dropdown {
        z-index: 9999;
    }
</style>
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
@if(getPermission('pegawai','PK') || role('owner') || role('admin'))
<div class="modal fade" id="modalKontrak" tabindex="-1" role="dialog" aria-labelledby="modalKontrak" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalKontrak">Perpanjang Kontrak</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form action="#">
                    <div class="form-group">
                        <label for="" class="form-label">Tanggal Akhir Kontrak</label>
                        <div class="input-group">
                            <span class="input-affix-wrapper">
                                <span class="input-prefix"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span></span>
                                <input type="text" class="form-control pe-0 datepicker-single" value="{{date('d/m/Y')}}">
                                <div id="displayRegervation"></div>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Untuk</label>
                        <div class="input-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="sp" value="0">
                                <label class="form-check-label" for="sp">Semua Pegawai</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="pt" value="1">
                                <label class="form-check-label" for="pt">Pegawai Tertentu</label>
                            </div>
                        </div>
                    </div>
                    <div id="pegawai-tertentu">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="form-label">Divisi</label>
                                <select class="form-control form-control-lg" name="divisi" id="select-divisi">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="form-label">Pegawai</label>
                                <select class="form-control form-control-lg" name="pegawai" id="select-pegawai">

                                </select>
                            </div>
                        </div>
                        <div id="alert-pegawai"></div>
                        <div id="list-pegawai" class="form-control p-2">
                            <div class="row m-auto"><div class="text-center text-light">Tidak ada Pegawai</div></div>
                        </div>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flush-success flush-soft-hover btn-simpan">Simpan</button>
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@push('js')
    <script >


        var _TABLE = null;
        var _URL_DATATABLE = '{{route("pegawai.pegawai.datatable")}}';

        var listPegawai = []
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
        @if(getPermission('pegawai','U') || role('owner') || role('admin'))
            $('#data tbody').on('click', 'tr td:not(:nth-child(-n + 2))', function (e) {
                var data = _TABLE.row(this).data();
                window.location.href = data.detail;
            });
        @endif
        _TABLE.ajax.url(_URL_DATATABLE+"?kode_skpd="+data.id).load()
        $(".divisi").select2();
        $('.divisi').on('select2:select', function (e) {
            var data = e.params.data;
            _TABLE.ajax.url(_URL_DATATABLE+"?kode_skpd="+data.id).load()
        });
        // JS FOR MODAL
        @if(getPermission('pegawai','PK') || role('owner') || role('admin'))
        initDatePickerSingle();
        const modalKontrak = new bootstrap.Modal(document.getElementById("modalKontrak"),{backdrop:'static',keyboard:true});
        $(document).on('click',"#btnModalKontrak", function () {
            modalKontrak.show();
            $("#sp").prop('checked',true)
            $("#pegawai-tertentu").hide();
            $("#modalKontrak").find("#select-pegawai").attr('disabled');
            initDevisi()
        });
        $("[name=type]").click(function(e){
            console.log($(this).val())
            if($(this).val() == 1){
                $("#pegawai-tertentu").show();
            }else{
                $("#pegawai-tertentu").hide();
            }
        })
        $('#select-pegawai').on('select2:select',function(e){
            var data = e.params.data;
            console.log(data);
            addPegawai(data.id,data.text)
            $(this).val(null).trigger('change')
        })
        $(document).on("click",".btn-close-lp",function(e){
            // alert('sadas')
            $(this).closest('.cp').remove()
            removeInObject(listPegawai,"nip",$(this).closest('.cp').find('.nip').val())
            checkListPegawai()
            console.log(listPegawai);
        })
        function initDevisi(){
            let getDivisi = (url) => {
                var element = $('#select-divisi');
                let loading = loadingProccesText(element)
                $.ajax({url: url, success: function(data){
                    element.empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: item['label'],
                            id: item['kode_skpd'],
                        }
                    })
                    var value_divisi = data[0].id;
                    element.removeAttr("disabled")
                    element.select2({
                        placeholder:"Pilih Divisi atau ketik disini",
                        data : data,
                        dropdownParent: $('#modalKontrak')
                    }).val(value_divisi).change(function(){
                        initPegawai("{{route('pegawai.pegawai.json')}}?kode_skpd="+$(this).val())
                    }).trigger('change');
                }});
            }
            getDivisi("{{route('master.skpd.json')}}")
        }
        function initPegawai(url,value_pegawai = null){
            let getPegawai = (url) => {
                var element = $('#select-pegawai');
                let loading = loadingProccesText(element)
                $.ajax({url: url, success: function(data){
                    element.empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: item['label'],
                            id: item['nip'],
                        }
                    })

                    element.removeAttr("disabled")
                    element.select2({
                        placeholder:"Ketik Nama Pegawai",
                        data : data,
                        dropdownParent: $('#modalKontrak')
                    }).val(null).change()
                }});
            }
            getPegawai(url);
        }
        function addPegawai(nip,nama){
            $('#alert-pegawai').html("")
            if(inObject(nip,listPegawai,'nip')){
                $('#alert-pegawai').html(`<div class="alert alert-danger text-center">Pegawai sudah di masukkan</div>`)
                return
            }
            listPegawai.push({nip:nip,nama:nama})

            lp = "";
            var btnClose = `<button type="button" class="btn-close btn-close-lp text-danger position-absolute h-100" style="right: 1rem;top:0;z-index:9999"><span aria-hidden="true">×</span></button>`
            listPegawai.forEach(element => {
                lp += `<div class="col-md-4 cp border border-light position-relative p-2 "><input type="hidden" name="list-pegawai[]" class="nip" value="${element.nip}">${element.nama} ${btnClose}</div>`;
            });

            $('#list-pegawai').find('.row').html(lp);
        }
        function checkListPegawai(){
            if(listPegawai.length == 0){
                $('#list-pegawai').html('<div class="text-center text-light">Tidak ada Pegawai</div>');
            }
        }
        @endif
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
