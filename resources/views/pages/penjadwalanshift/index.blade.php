@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Penjadwalan Shift</h2>
    {{ Breadcrumbs::render('penjadwalan-shift') }}
@endsection
@section('header_action')
    @if(getPermission('penjadwalanShift','E') || role('owner') || role('admin'))
    <button class="btn btn-success me-3 export" data-ext="excel"><span><span class="icon"><i class="far fa-file-excel"></i></span><span>Export Excel</span></span></button>
    @endif
@endsection
@section('content')
<style>
    .dt-button{
        display: none;
    }
    .ui-datepicker-unselectable.ui-state-hover span {
        background: #ffcccc !important;
        cursor: not-allowed !important;
    }
</style>
@if(getPermission('penjadwalanShift','U') || role('owner') || role('admin'))
<style>
    tbody tr .time{
        cursor: pointer;
    }
    tbody tr .time .show-edit{
        position: absolute;
        bottom: 0;
        left: 0;
        height: 0%;
        width: 100%;
        display: flex;
    }
    tbody tr .time .show-edit a{
        margin: auto;
    }
    tbody tr .time:hover .show-edit{
        background: #009ee6;
        color:#fff !important;
        height: 100%;
        transition: height 0.5s;
    }
    tbody tr .time .btn-ubah{
        display: none;

    }
    tbody tr .time:hover .btn-ubah{
        display: block;
    }
</style>
@endif
<div class="row justify-content-end">
    <div class="col">
        <div class="form-group">
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
        </div>
    </div>
    <div class="col-3 text-end">
        <div class="form-group w-100 float-end">
            <div class="input-group">
                <span class="input-affix-wrapper">
                    <span class="input-prefix"><span class="feather-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></span></span>
                    <input type="text" class="form-control pe-0 daterangepicker-maks-month" value="{{date('01/m/Y') ." - ". date('t/m/Y')}}">
                    <div id="displayRegervation"></div>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="border-bottom mb-3"></div>
<div class="invoice-body">
    <div data-simplebar class="nicescroll-bar">
        <div id="datatable"></div>
    </div>
</div>
{{-- MODAL --}}
<div class="modal fade" id="modalEditShift" tabindex="-1" role="dialog" aria-labelledby="modalEditShiftLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalEditShiftLabel">Edit Shift</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <form action="#">

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
    <script>
        initDateRangePickerMaksMonth();
        // "use strict";
        var date=new Date();
        var d = date.getDate()
        var y = date.getFullYear()
        var m = date.getMonth()+1
        var lastDay = new Date(y, m, 0).getDate();
        var datatableElement = '<table id="data" class="table mt-2 nowrap w-100 mb-5 table-bordered"></table>';
        var _COLUMNS = [
            {'title':'NO','data':'DT_RowIndex', 'orderable':false ,'searchable': false},
            {'title':'JABATAN','data':'jabatan','name':'jabatan','searchable': false},
            {'title':'NIP','data':'nip','name':'nip'},
            {'title':'Nama','data':'nama_pegawai','name':'name','searchable': true},
        ];
        var _START_DATE = y+"/"+m+"/01";
        var _END_DATE = y+"/"+m+"/"+lastDay;

        var _DATATABLE = null;
        var _KODE_SKPD = $(".divisi").val();
        var _DATERANGE = getDatesRange(_START_DATE,_END_DATE);
        const modalEditShift = new bootstrap.Modal(document.getElementById("modalEditShift"),{backdrop: 'static', keyboard: false});
        const btnLoading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...`;
        // INIT ELEMENT
        $(".bulan").text(convertMonthToIndo(m-1));
        $(".tahun").text(y);
        $(".divisi").select2();
        _DATERANGE.forEach(e => {
            var date = e.split("-");
            var tanggal = new Date(e);
            var namaBulan = tanggal.toLocaleString('default', { month: 'long' });
            _COLUMNS.push({'title':`${namaBulan}-${date[2]}`,'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false,'className':'time position-relative'})
        });

        setDataTable(_COLUMNS,_START_DATE,_END_DATE);

        $('.export').on('click', function () {
            var ext = $(this).data('ext');
            Swal.fire({
              text: 'Apakah ingin meng-export data ini?',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya',
              cancelButtonText: 'Tidak',
            }).then((result) => {
              if (result.value) {
                window.location.href = `{{route('penjadwalanshift.export')}}?date_start=${_START_DATE}&date_end=${_END_DATE}&ext=${ext}`
              }
            })
        });

        $('.show-all').on('click', function () {
            _DATATABLE.page.len(-1).draw();
        })

        $(".divisi").on("select2:select",function(e){
            _KODE_SKPD = e.params.data.id;
            setDataTable(_COLUMNS,_START_DATE,_END_DATE);
        });

		$('.dataTables_wrapper .dataTables_filter input').css('width','85% !important');
        @if(getPermission('penjadwalanShift','U') || role('owner') || role('admin'))
        $(document).on('click',".show-edit", function () {
            modalEditShift.show()
            var data = _DATATABLE.row($(this).closest('tr')).data()
            var html = buildNamaPegawai(data.name)+buildTanggal($(this))+buildShift()+buildNip(data.nip);
            $('#modalEditShift').find("form").html(html);
            $("[name='kode_shift']").select2({
                dropdownParent:$('#modalEditShift'),
                placeholder:"Pilih Shift",
                allowClear: true
            }).val($(this).data('kodeshift')).change();
        });
        @endif
        $(".btn-simpan").click(function (e) {
            e.preventDefault();
            saveShift($(this))
        });
        function setDataTable(columns,start_date,end_date) {
            $("#datatable").html(datatableElement);
            var options = {
                searchDelay: 100,
                responsive:false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route("penjadwalanshift.datatable")}}?date_start='+start_date+'&date_end='+end_date+'&kode_skpd='+_KODE_SKPD,
                },
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },
                language:{
                    searchPlaceholder: "Cari",
                    search: ""
                },
                columns: columns,
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'excelHtml5',
                //         title: 'Rekap-absen',
                //         className: 'btn btn-primary'
                //     },
                //     {
                //         extend: 'pdfHtml5',
                //         title: 'Rekap-absen'
                //     }
                // ],
                // "createdRow": function ( row, data, index ) {
                //     console.log(row);
                // }
            }
            _DATATABLE = $('#data').DataTable(options);
        }
        function saveShift(elBtn){
            var btn = elBtn.html();
            elBtn.attr('disabled');
            elBtn.html(btnLoading);
            $.ajax({
                type: "post",
                url: "{{route('penjadwalanshift.update')}}",
                data: $("form").serialize(),
                dataType: "JSON",
                success: function (response) {
                    Swal.fire(
                      'Sukses Update',
                      response.message,
                      'success'
                    )
                    elBtn.removeAttr('disabled');
                    elBtn.html(btn);
                    setDataTable(_COLUMNS,_START_DATE,_END_DATE);
                    return true;
                },
                error:function(response){
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
        // FUNCTION
        function initDateRangePickerMaksMonth(){

            var maxHoverDays = 31;
            var maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 31);
            console.log(maxDate);
            $(".daterangepicker-maks-month").daterangepicker({
                // singleDatePicker: true,
                // linkedCalendars: false,
                startDate: "{{date('01/m/Y')}}",
                endDate: "{{date('t/m/Y')}}",
                showDropdowns: true,
                autoApply: true,
                // maxDate:maxDate, // ILINGNO CAK
                minYear: 1970,
                maxYear: new Date().getFullYear(),
                locale: {
                    format: "DD/MM/YYYY",
                }
            },
            function (start, end, label) {
                    $(".bulan").text(convertMonthToIndo(parseInt(start.format("M"))-1));
                    $(".tahun").text(start.format("YYYY"));
                    var dateRange = getDatesRange(start.format("YYYY-MM-DD"),end.format("YYYY-MM-DD"))
                    var date_start = start.format("YYYY/MM/DD");
                    var date_end = end.format("YYYY/MM/DD");
                    var col = [
                        {'title':'No','data':'DT_RowIndex', 'orderable':false ,'searchable': false},
                        {'title':'Jabatan','data':'jabatan','name':'jabatan','searchable': false},
                        {'title':'Nip','data':'nip','name':'nip'},
                        {'title':'Nama Pegawai','data':'nama_pegawai','name':'name','searchable': false},
                    ];

                    dateRange.forEach(e => {
                        var date = e.split("-");
                        var tanggal = new Date(e);
                        var namaBulan = tanggal.toLocaleString('default', { month: 'long' });
                        col.push({'title':`${namaBulan}-${date[2]}`,'data':'day_'+date[2],'name':null,'orderable':false ,'searchable': false,'className':'time position-relative'})
                    });

                    if((col.length - 5) > 31){
                        Swal.fire({
                            icon: 'error',
                            text: 'Tanggal tidak boleh lebih dari 31 hari'
                        })
                        return;
                    }
                    console.log(col)
                    _DATATABLE.destroy();
                    $("#datatable").empty();
                    _DATATABLE = null;
                    _START_DATE = date_start
                    _END_DATE = date_end
                    _COLUMNS = col
                    console.log(col,date_start,date_end);
                    setDataTable(col,date_start,date_end);
                }
            );
        }
        function buildShift(){
            var shift = @json($shift);
            var slctShift = `<div class="form-group">
                                <label class="form-label">Shift</label>`;
            slctShift += "<select class='form-control' name='kode_shift'>";
            shift.forEach(element => {
                slctShift += `<option value="${element.kode_shift}">${element.nama}</option>`;
            });
            slctShift += "</select></div>";
            return slctShift;
        }
        function buildTanggal(el){
            return `<div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <label class="form-control">${el.data('tglindo')}</label>
                                <input type="hidden" name="tanggal" value="${el.data('tgl')}"/>
                                </div>`

        }
        function buildNip(nip){
            return `<input type="hidden" name="nip" value="${nip}"/>`
        }
        function buildNamaPegawai(nama_pegawai){
            return `<div class="form-group">
                                <label class="form-label">Nama Pegawai</label>
                                <label class="form-control">${nama_pegawai}</label>
                                </div>`
        }
    </script>

@endpush

