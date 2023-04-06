
@extends('app',['noHeader'=>true])

@section('content')
<style>
    .dataTables_filter {
        float: left !important;
    }
    .dataTables_filter input {
        padding: 5px 5px !important;

    }
    #data_wrapper{
        position: relative;
    }
    .select2-container--default .select2-selection--single.is-invalid{
        border: 1px solid #f00 !important;
    }
    .w-10px{
        width: 15px;
        text-align: center;
    }
</style>

<div class="container-fluid mt-4">
    <div class="profile-wrap">
        <div class="profile-img-wrap">
            <img class="img-fluid rounded-5" src="{{asset('/')}}dist/img/profile-bg.png" alt="Image Description">
        </div>
        <div class="profile-intro">
            <div class="card card-flush w-100 bg-transparent">
                <div class="card-body">
                    <div class="avatar avatar-xxl avatar-rounded position-relative mb-2">
                        {{-- <img src="{{$pegawai->images}}" alt="user" class="avatar-img border border-4 border-white"> --}}
                        <img src="{{$pegawai->foto()}}" alt="user" class="avatar-img border border-4 border-white">
                        <span class="badge badge-indicator badge-success  badge-indicator-xl position-bottom-end-overflow-1 me-1"></span>
                    </div>
                    <h4>{{$pegawai->name}}
                        <i class="bi-check-circle-fill fs-6 text-blue" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Top endorsed"></i>
                    </h4>
                    <p>
                        Venenatis tellus in metus vulputate
                    </p>
                    <ul class="list-inline fs-7 mt-2 mb-0">
                        <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                            <div class="text-primary"><i class="fas w-10px fa-birthday-cake"></i> | {{$pegawai->tempat_lahir}}, {{$pegawai->tlahir}}</div>
                        </li>
                        <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                            <div class="text-primary"><i class="fas w-10px fa-phone-alt"></i> | {{formatPhone("+".$pegawai->no_hp)}}</div>
                        </li>
                        <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                            <div class="text-primary"><i class="far w-10px fa-envelope"></i> | {{$pegawai->email}}</div>
                        </li>
                        <li class="list-inline-item d-sm-inline-block d-block mb-sm-0 mb-1 me-3">
                            <a href="#"><i class="bi w-10px bi-geo-alt"></i> | {{$pegawai->alamat}}</a>
                        </li>
                    </ul>
                    <div class="row nav-justified-start mt-4 ml-3">
                        <div class="col col-sm-3 ml-4">
                            <a class="btn btn-primary w-100" href="{{url('pegawai/berkas/'.$pegawai->nip.'/profile_pdf')}}" >
                                <span>
                                    <span class="icon"><i class="fa fa-print"></i></span>
                                    <span>Unduh Profil</span>
                                </span>
                            </a>
                        </div>
                        <div class="col col-sm-3">
                            <a class="btn btn-primary w-100" href="{{url('pegawai/berkas/'.$pegawai->nip.'/berkas_zip')}}" >
                                <span>
                                    <span class="icon"><i class="fa fa-download"></i></span>
                                    <span>Unduh Berkas</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- tabs --}}
        <ul class="nav nav-tabs nav-line nav-icon nav-light w-auto d-none">
            <li class="nav-item">
                <a class="d-flex align-items-center nav-link active h-100" data-bs-toggle="tab" href="#data_utama">
                    <span class="nav-link-text">Data Utama</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center nav-link h-100" data-bs-toggle="tab" href="#data_riwayat">
                    <span class="nav-link-text">Data Riwayat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center nav-link h-100" data-bs-toggle="tab" href="#data_keluarga">
                    <span class="nav-link-text">Data Keluarga</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center nav-link h-100" data-bs-toggle="tab" href="#data_lainnya">
                    <span class="nav-link-text">Data Lainnya</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center nav-link h-100" data-bs-toggle="tab" href="#unduh_berkas">
                    <span class="nav-link-text">Unduh Berkas</span>
                </a>
            </li>
        </ul>
        <div class="tab-content mb-2 mt-0 d-none">
            <div class="tab-pane fade show active" id="data_utama">
                @include('pages.pegawai.pegawai.menu-pane.data-utama')

            </div>
            <div class="tab-pane fade" id="data_riwayat">
                @include('pages.pegawai.pegawai.menu-pane.data-riwayat')
            </div> 
            <div class="tab-pane fade" id="data_keluarga">
                @include('pages.pegawai.pegawai.menu-pane.data-keluarga')
            </div>
            <div class="tab-pane fade" id="data_lainnya">
                @include('pages.pegawai.pegawai.menu-pane.data-lainnya')
            </div>
            <div class="tab-pane fade" id="unduh_berkas">
                @include('pages.pegawai.pegawai.menu-pane.unduh-berkas')
            </div>
        </div>
        @include('pages.pegawai.pegawai.sidebar-content')
        
        {{-- end tabs --}}
    </div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function () {
    var _URL = null;
    var _COLUMNS = null;
    var _URL_ADD = null;
    var _TABLE = null;
    var loading = '<div class="loader mb-4"><div class="bar"></div></div>';
    var htmlTable = '<table id="data" class="table table-bordered nowrap" width="100%"></table>';
    var _STATUS_SUBMIT = 0;
    var _ID_UPDATE = "";
    var _TIPE_PAGE = 0;
    var _IGNORE_VALIDATE = ["unggah_ktp","unggah_bpjs","file","gelar_belakang","gelar_depan","kode_umk"]
    $('.navbar-toggle').click()
    $('[href="#data_pribadi"]').click()
    $('#sidebar-content .nav-item').click(function(){
        $('#sidebar-content .nav-item').removeClass('active')
        $(this).addClass('active')
        $("#title-content").text($(this).find('.nav-link-text').text())
    });
    $('.item-sidebar-content').click(function(){
        _TIPE_PAGE = $(this).data("tipepage");
    })
    $(".tab-datatable").click(function (e) { 
        e.preventDefault();
        _URL = $(this).data("tableurl");
        console.log($(this).data("tablecolumn"))
        console.log(_URL)
        _COLUMNS = $(this).data("tablecolumn");
        _URL_ADD = $(this).data("tableadd");
        // loadingFormStart();
        $(".target-view").html(htmlTable);
        $(".view-data-utama").empty();
        if(_TABLE == null){
            setDataTable();
        }else{
            _TABLE.destroy();
            $('#data').empty();
            setDataTable();
        }
    });
    
    $('#data_pribadi').click(function (e) { 
        // e.preventDefault();
        _URL = '{{url("pegawai/posisi/".$pegawai->nip)}}'
    });
    $('#data_koor').click(function (e) { 
        _STATUS_SUBMIT = 2;
    });
    // kembali
    $(document).on("click",".btn-back", function () {
        rebuildDatatable()
    });
    $(document).on("click",".edit", function (e) {
        e.preventDefault();
        getView($(this).attr("href"));
        _STATUS_SUBMIT = 2;
    });
    $(document).on("click",".delete", function (e) {
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
            console.log("tyaa "+result.value);
            if (result.value) {
                deleteRow($(this).attr('href'))
            }
        })
    });
    // simpan
    $(document).on("click",".btn-submit", async function (e) {
        e.preventDefault()
        loadingFormStart();
        
        let form = $(this).closest("form");
        console.log(_STATUS_SUBMIT);
        if(_STATUS_SUBMIT == 1){ // new
            let result = await saveForm(form,form.attr("action"),_STATUS_SUBMIT,"post",_IGNORE_VALIDATE,true);
            console.log(result);
            if(result){
                if(form.attr("id") == "form-koor"){
                    $('#tab-koor').click()
                    maps();
                }else{
                    rebuildDatatable()
                }
                loadingFormStop();
            }
        }else if(_STATUS_SUBMIT == 2){ // update
            let result = await saveForm(form,form.attr("action"),_STATUS_SUBMIT,"post",_IGNORE_VALIDATE,true);
            if(result){
                if(form.attr("id") == "form-koor"){
                    $('#tab-koor').click()
                    maps();
                }else{
                    rebuildDatatable()
                }
                loadingFormStop();
                _ID_UPDATE = 0;
            }
        }
        
    });
    $(document).on("click",".btn-reset-koor", function (e) {
        e.preventDefault()
        var url = $(this).attr('href')
        $.ajax({url: url, success: function(response){
             Swal.fire({
                html:
                '<div class="d-flex align-items-center"><i class="ri-checkbox-line me-2 fs-3 text-success"></i><h5 class="text-success mb-0">Koordinat Berhasil di reset</h5></div>',
                customClass: {
                    content: 'p-0 text-start',
                    confirmButton: 'btn btn-primary',
                    actions: 'justify-content-start',
                },
                buttonsStyling: false,
            })
            var target = '#data_koor';
            var url = "{{route('pegawai.kordinat.index',$pegawai->nip)}}";
            ltlgOld = [0,0]
            dataAjax(target,url);
        }});
    });
    function setDataTable(){
        loadingFormStart();
        _TABLE = $('#data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : _URL
            },
            language:{
                searchPlaceholder: "Cari",
                search: ""
            },
            responsive:true,
            columns: _COLUMNS,
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: [0,-1]
                },
            ],
            order: [[1, 'asc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '{!!icons("c-plush")!!} Tambah',
                    className:'btn btn-primary float-end mb-3',
                    action: function ( e, dt, node, config ) {
                        getView(_URL_ADD);
                        _STATUS_SUBMIT = 1;
                    }
                }
            ],
            initComplete:function(){
                loadingFormStop();
            }
        });
    }
    let getView = (url) => { 
        loadingFormStart();
        $.ajax({url: url, success: function(response){
            $(".target-view").html(response.view);
            $(".select2").select2();
            tipePage(response.data);
            loadingFormStop();
            initDatePickerSingle()
        }});
     }
     let deleteRow = (url) => { 
        loadingFormStart();
        $.ajax({url: url, success: function(response){
            loadingFormStop();
            rebuildDatatable();
        }});
     }
     function rebuildDatatable(){
        $(".target-view").html(htmlTable);
        setDataTable();
        _ID_UPDATE = "";
     }
     function tipePage(data){
        switch (_TIPE_PAGE) {
            case 21:
                if(data != null){
                    initDevisi(data.kode_skpd,data.kode_tingkat);
                }else{
                    initDevisi();
                }
                break;
            case 22:
                if(data != null){
                    initGaji(data);
                }else{
                    initGaji();
                }
                setNumeric()
                break;
            case 23:
                if(data != null){
                    initTunjangan(data.kode_tunjangan);
                }else{
                    initTunjangan();
                }
                setNumeric()
                break;
            case 24:
                
                if(data != null){
                    initJenisPotongan(data.kode_kurang);
                }else{
                    initJenisPotongan()
                }
                break;
            case 25:    
                if(data != null){
                    iniPendidikan(data.kode_pendidikan,data.kode_jurusan);
                }else{
                    iniPendidikan();
                }
                break;
            case 26:    
                if(data != null){
                    initKursus(data.kursus);
                }else{
                    initKursus();
                }
                break;
            case 27:
                if(data != null){
                    initCuti(data.kode_cuti);
                }else{
                    initCuti();
                }
                setNumeric()
                break;
            case 28:
                
                setNumeric()
                break;
            case 29:
                if(data != null){
                    initReimbursement(data.kode_reimbursement);
                }else{
                    initReimbursement();
                }
                setNumeric()
                break;
            case 30:
                
                if(data != null){
                    initShift(data.kode_shift);
                }else{
                    initShift();
                }
                setNumeric()
                break;
            case 31:
                if(data != null){
                    initPenghargaan(data.kode_penghargaan);
                }else{
                    initPenghargaan();
                }
                setNumeric()
                break;
            case 32:
                if(data != null){
                    initLainnya(data.kode_lainnya);
                }else{
                    initLainnya();
                }
                setNumeric()
                break;
            case 33:
                setNumeric();
                break;
            default:
                break;
        }
        initDatePickerSingle()
     }

});
window.onload = function() {
  loadingFormStop()
}
</script>
{{-- <script src="{{asset('/')}}delete.js"></script> --}}
<script src="{{asset('/')}}save.js"></script>

@endpush