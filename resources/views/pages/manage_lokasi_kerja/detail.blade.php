@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Tambah Pegawai</h2>
    {{ Breadcrumbs::render('tambah-pegawai') }}
@endsection
@section('header_action')
<a href="#" id="btnModalAddPegawai" class="btn btn-primary">{!!icons('c-plush')!!} {{__('Tambah')}}</a>
{{-- @if(getPermission('masterDataShift','C') || role('admin') || role('owner'))
@endif --}}
@endsection
@section('content')
<style>
    .select2-container--open .select2-dropdown {
        z-index: 9999;
    }
</style>
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div class="invoice-list-view">
            <table id="data" class="table mt-2 nowrap w-100 mb-5 table-responsive table-bordered">
                <thead>
                    <tr className="fw-bolder text-muted">
                        <th>{{__('No')}}</th>
                        <th>{{__('Opsi')}}</th>
                        <th>{{__('No Pegawai & Nama Lengkap')}}</th>
                        <th>{{__('Jabatan & Divisi')}}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAddPegawai" tabindex="-1" role="dialog" aria-labelledby="modalAddPegawai" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalAddPegawai">Tambahkan Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form id="form-modal" action="#">
                    <input type="hidden" name="kode_lokasi" value="{{$kode_lokasi}}">
                    <input type="hidden" name="kode_skpd" value="{{$kode_skpd}}">
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
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-flush-success flush-soft-hover btn-simpan">Simpan</button>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
    <script >
        const modalAddPegawai = new bootstrap.Modal(document.getElementById("modalAddPegawai"),{backdrop:'static',keyboard:true});
        const btnLoading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...`;
        
        var _TABLE = null;
        var _URL_DATATABLE = '{{route("manage_lokasi_kerja.datatable_detail")}}?kode_lokasi={{$kode_lokasi}}';
        // SESUAIKAN COLUMN DATATABLE
        // SESUAIKAN FIELD EDIT MODAL
        var listPegawai = []
        setDataTable();
        function setDataTable() {
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
                        data: 'name',
                        name: 'name',
                    },{
                        data: 'nama_jabatan',
                        name: 'nama_jabatan',
                    }],

            });
        }
		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        $(document).on('click',"#btnModalAddPegawai", function () {

            modalAddPegawai.show();
            $("#sp").prop('checked',true)
            $("#pegawai-tertentu").hide();
            $("#modalAddPegawai").find("#select-pegawai").attr('disabled');
        });
        $(".btn-simpan").click(function (e) {
            e.preventDefault();
            savePegawai($(this))
        });
        $('#select-pegawai').on('select2:select',function(e){
            var data = e.params.data;
            console.log(data);
            addPegawai(data.id,data.text)
            $(this).val(null).trigger('change')
        })
        initPegawai("{{route('pegawai.pegawai.json')}}?kode_skpd="+$("[name=kode_skpd]").val())
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
                        dropdownParent: $('#modalAddPegawai'),
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
                lp += `<div class="col-md-4 cp border border-light position-relative p-2 mb-2 shadow"><input type="hidden" name="list-pegawai[]" class="nip" value="${element.nip}">${element.nama} ${btnClose}</div>`;
            });
            console.log(listPegawai,lp);

            $('#list-pegawai').find('.row').html(lp);
        }
        function clearModal(){
            listPegawai = [];
            $("#alert-pegawai").empty()
            checkListPegawai()
        }
        function checkListPegawai(){
            if(listPegawai.length == 0){
                $('#list-pegawai').html('<div class="row m-auto"><div class="text-center text-light">Tidak ada Pegawai</div></div>');
            }
        }
        function savePegawai(elBtn){
            var btn = elBtn.html();
            elBtn.attr('disabled');
            elBtn.html(btnLoading);
            $.ajax({
                type: "post",
                url: "{{route('manage_lokasi_kerja.store')}}",
                data: $("#form-modal").serialize(),
                dataType: "JSON",
                success: function (response) {
                    modalAddPegawai.hide()
                    clearModal()
                    Swal.fire(
                      'Sukses',
                      response.message,
                      'success'
                    )
                    elBtn.removeAttr('disabled');
                    elBtn.html(btn);
                    _TABLE.ajax.reload()
                    return true;
                },
                error:function(response){
                    modalAddPegawai.hide()
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
    </script>
    <script src="{{asset('/')}}delete.js"></script>

@endpush
