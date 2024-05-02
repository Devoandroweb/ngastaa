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
<h4>Filter</h4>
<div class="row mb-4 m-auto">
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
        <select name="kode_lokasi" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Lokasi Kerja</option>
            @foreach ($lokasiKerja as $s)
                @if((Session::get('current_select_lokasi')?? 0) == $s->kode_lokasi)
                <option value="{{$s->kode_lokasi}}" @selected(true)>{{$s->nama}}</option>
                @else
                <option value="{{$s->kode_lokasi}}">{{$s->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 ps-0">
        <select name="status_pegawai" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Status</option>
            @foreach ($statusPegawai as $s)
                @if((Session::get('current_select_status_pegawai') ?? "") == $s->kode_status)
                <option value="{{$s->nama}}" @selected(true)>{{$s->nama}}</option>
                @else
                <option value="{{$s->nama}}">{{$s->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-4 m-auto">
    <div class="col-md-6 ps-0">
        <select name="kode_eselon" class="form-control divisi px-2" id="">
            <option selected value="0">Semua Level Jabatan</option>
            @foreach ($levelJabatan as $l)
                @if((Session::get('current_select_kode_eselon') ?? 0) == $l->kode_eselon)
                <option value="{{$l->kode_eselon}}" @selected(true)>{{$l->nama}}</option>
                @else
                <option value="{{$l->kode_eselon}}">{{$l->nama}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-6 ps-0">
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
    <div class="col-md-4 ps-0">
        <input type="text" name="nama_pegawai" placeholder="Ketik Nama Pegawai" class="form-control h-100">
    </div>
    <div class="col-md-3 ps-0 d-flex align-items-center">
        <button type="button" class="btn btn-warning w-100 me-2 text-center text-nowrap btn-cari"><i class="fas fa-search"></i> Cari</button>
        <button id="btn-change-pegawai" type="button" class="btn btn-info w-100 text-center text-nowrap "><i class="fas fa-user-edit"></i> Ubah</button>
    </div>
</div>
<hr>
@include('pages.pegawai.pegawai.change-pegawai')
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
            <th><input type="checkbox" id="check-all" class="form-check-input"></th>
            <th>No</th>
            <th>Opsi</th>
            <th>Foto</th>
            <th>No Pegawai & Nama Lengkap</th>
            <th>Jabatan & Divisi</th>
            <th>Lokasi Kerja</th>
            <th>Jam Kerja</th>
            <th>Status</th>
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
                <form id="form-modal" action="#">
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
        const btnLoading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...`;

        /* DATATABLE */
        setDataTable();
        function setDataTable() {
            _TABLE = $('#data').DataTable({
                responsive:false,
                scrollX: true,
                processing: true,
                serverSide: true,
                stateSave:true,
                bFilter:false,
                searchDelay: 0, // Menetapkan penundaan pencarian menjadi 0
                search: {
                    smart: false // Menonaktifkan pencarian cerdas
                },
                ajax: {
                    url: _URL_DATATABLE+"?kode_skpd="+$(".divisi").val(),
                },
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },
                language:{
                    searchPlaceholder: "Ketik Lalu Enter",
                    search: ""
                },
                columns: [
                    {
                        "data": 'checkbox',
                        orderable: false,
                        searchable: false,
                        visible:false
                    },{
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
                        data: 'lokasi_kerja',
                        name: 'lokasi_kerja',
                    },{
                        data: 'jam_kerja',
                        name: 'jam_kerja',
                    },{
                        data: 'kode_status',
                        name: 'kode_status',
                    }
                ],
                drawCallback:function(){
                    $("#check-all").prop('checked',false)
                }

            });
        }
        _TABLE.column(0).visible(false)
        /* END DATATABLE */
        $('#data_filter input').unbind().bind('keyup', function(e) {
            if (e.keyCode == 13) {
                _TABLE.search(this.value).draw();
            }
        });
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        @if(getPermission('pegawai','U') || role('owner') || role('admin'))
            $('#data tbody').on('click', 'tr td:not(:nth-child(-n + 2))', function (e) {
                var data = _TABLE.row(this).data();
                window.open(data.detail,"_blank");
            });
        @endif
        // _TABLE.ajax.url(_URL_DATATABLE+"?kode_skpd="+data.id).load()
        $(".divisi").select2();
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
        $(".btn-simpan").click(function (e) {
            e.preventDefault();
            saveShift($(this))
        });
        $("[name=type]").click(function(e){
            console.log($(this).val())
            if($(this).val() == 1){
                $("#pegawai-tertentu").show();
            }else{
                $("#pegawai-tertentu").hide();
            }
        })
        $(".btn-cari").click(function(e){
            filterPegawai($("[name=kode_skpd]").val(),$('[name=kode_lokas]').val(),$('[name=nama_pegawai]').val(),$('[name=status_pegawai]').val(),$('select[name="nip_pegawai[]"]').val(),$('select[name="kode_tingkat"]').val(),$('select[name="kode_eselon"]').val())
        })
        $('#select-pegawai').on('select2:select',function(e){
            var data = e.params.data;
            console.log(data);
            addPegawai(data.id,data.text)
            $(this).val(null).trigger('change')
        })

        /* CHANGE PEGAWAI SHOW/HIDE */
        var changeShow = false;
        $("#btn-change-pegawai").click(function (e) {

            console.log(changeShow);
            if(changeShow){
                _TABLE.column(0).visible(false)
                $(this).html(`<i class="fas fa-user-edit"></i> Ubah`)
                changeShow = false;
                $(this).toggleClass("bg-danger")
                $("#change-pegawai").fadeOut()
            }else{
                _TABLE.column(0).visible(true)
                changeShow = true;
                $(this).toggleClass("bg-danger")
                $(this).html(`<i class="fas fa-times"></i> Tutup`)
                $("#change-pegawai").fadeIn()
            }
        });
        /* END */
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
                        allowClear:true,
                        dropdownParent: $('#modalKontrak')
                    }).val(value_divisi).change(function(){
                        initPegawai("{{route('pegawai.pegawai.json')}}?kode_skpd="+$(this).val())
                    }).trigger('change');
                }});
            }
            getDivisi("{{route('master.skpd.json')}}")
        }
        initPegawaiNip("{{route('pegawai.pegawai.json')}}?kode_skpd=0")
        function initPegawai(url,value_pegawai = null){
            let getPegawai = (url) => {
                var element = $('#select-pegawai');
                let loading = loadingProccesText(element)
                $.ajax({url: url, success: function(data){
                    element.empty()
                    clearInterval(loading)
                    var data = $.map(data, function (item) {
                        return {
                            text: `<b>[ ${item['nip']} ]</b> ${item['label']}`,
                            id: item['nip'],
                        }
                    })

                    element.removeAttr("disabled")
                    element.select2({
                        placeholder:"Ketik Nama Pegawai",
                        data : data,
                        dropdownParent: $('#modalKontrak'),
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
        function saveShift(elBtn){
            var btn = elBtn.html();
            elBtn.attr('disabled');
            elBtn.html(btnLoading);
            $.ajax({
                type: "post",
                url: "{{route('pegawai.pegawai.update-kontrak')}}",
                data: $("#form-modal").serialize(),
                dataType: "JSON",
                success: function (response) {
                    modalKontrak.hide()
                    clearModal()
                    Swal.fire(
                      'Sukses Update',
                      response.message,
                      'success'
                    )
                    elBtn.removeAttr('disabled');
                    elBtn.html(btn);
                    _TABLE.ajax.reload()
                    return true;
                },
                error:function(response){
                    modalKontrak.hide()
                    Swal.fire(
                      'Error',
                      'Error Server',
                      'error'
                    )
                    elBtn.removeAttr('disabled');
                    elBtn.html(btn);
                    return false;
                }
            });
        }
        function clearModal(){
            $("#modalKontrak").find("#pt").prop('checked',true);
            listPegawai = [];
            $("#alert-pegawai").empty()
            checkListPegawai()
        }
        function filterPegawai(kode_skpd,kode_lokasi,nama_pegawai,status_pegawai,nip_pegawai,kode_tingkat,kode_eselon){
            _TABLE.ajax.url(_URL_DATATABLE+`?kode_skpd=${kode_skpd}&kode_lokasi=${kode_skpd}&nama_pegawai=${nama_pegawai}&status_pegawai=${status_pegawai}&nip_pegawai=${nip_pegawai}&kode_tingkat=${kode_tingkat}&kode_eselon=${kode_eselon}`).load()
        }

        @endif
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
