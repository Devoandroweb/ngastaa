<ul class="nav nav-icon nav-tabs nav-justified nav-segmented-tabs nav-light mt-6">
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="21" href="#jabatan"
            data-tableurl="{{konfigJabatan($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigJabatan($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigJabatan($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><i class="fas fa-chart-line"></i></span>
            <span class="nav-link-text">Jabatan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="211" href="#jabatan"
            data-tableurl="{{konfigJamKerja($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigJamKerja($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigJamKerja($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><i class="fas fa-chart-line"></i></span>
            <span class="nav-link-text">Jam Kerja</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="22" href="#gaji_pokok"
            data-tableurl="{{konfigGajiPokok($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigGajiPokok($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigGajiPokok($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-id-card-alt"></i></span></span>
            <span class="nav-link-text">Gaji Pokok</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="23" href="#data_tunjangan"
            data-tableurl="{{konfigGTunjangan($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigGTunjangan($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigGTunjangan($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fa fa-sort-amount-up"></i></span></span>
            <span class="nav-link-text">Tunjangan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="24" href="#data_potongan"
            data-tableurl="{{konfigPotongan($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigPotongan($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigPotongan($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fa fa-sort-amount-down"></i></span></span>
            <span class="nav-link-text">Potongan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="25" href="#data_pendidikan"
            data-tableurl="{{konfigPendidikan($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigPendidikan($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigPendidikan($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-user-graduate"></i></span></span>
            <span class="nav-link-text">Pendidikan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="26"  href="#data_kursus"
            data-tableurl="{{konfigKursus($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigKursus($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigKursus($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-book-reader"></i></span></span>
            <span class="nav-link-text">Kursus</span>
        </a>
    </li>
</ul>
<ul class="nav nav-icon nav-tabs nav-justified nav-segmented-tabs nav-light mt-2">

    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="27"  href="#data_cuti"
            data-tableurl="{!!konfigCuti($pegawai['nip'])['url']!!}"
            data-tablecolumn='{!!json_encode(konfigCuti($pegawai["nip"])["data"])!!}'
            data-tableadd="{!!konfigCuti($pegawai["nip"])["url_add"]!!}"
            >
            <span class="nav-icon-wrap"><i class="fas fa-calendar-day"></i></span>
            <span class="nav-link-text">Cuti</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="28" href="#data_lembur"
            data-tableurl="{!!konfigLembur($pegawai['nip'])['url']!!}"
            data-tablecolumn='{!!json_encode(konfigLembur($pegawai["nip"])["data"])!!}'
            data-tableadd="{!!konfigLembur($pegawai["nip"])["url_add"]!!}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-user-clock"></i></span></span>
            <span class="nav-link-text">Lembur</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="29"  href="#data_reimbursement"
            data-tableurl="{!!konfigReimbursment($pegawai['nip'])['url']!!}"
            data-tablecolumn='{!!json_encode(konfigReimbursment($pegawai["nip"])["data"])!!}'
            data-tableadd="{!!konfigReimbursment($pegawai["nip"])["url_add"]!!}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-exchange-alt"></i></span></span>
            <span class="nav-link-text">Reimbursment</span>
        </a>
    </li><li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="30"  href="#data_shift"
            data-tableurl="{!!konfigShift($pegawai['nip'])['url']!!}"
            data-tablecolumn='{!!json_encode(konfigShift($pegawai["nip"])["data"])!!}'
            data-tableadd="{!!konfigShift($pegawai["nip"])["url_add"]!!}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-sync-alt"></i></span></span>
            <span class="nav-link-text">Shift</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="31"  href="#data_penghargaan"
            data-tableurl="{!!konfigPenghargaan($pegawai['nip'])['url']!!}"
            data-tablecolumn='{!!json_encode(konfigPenghargaan($pegawai["nip"])["data"])!!}'
            data-tableadd="{!!konfigPenghargaan($pegawai["nip"])["url_add"]!!}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-award"></i></span></span>
            <span class="nav-link-text">Penghargaan</span>
        </a>
    </li>
</ul>

@push("js")
<script>
    $(".nav-segmented-tabs .nav-link").click(function (e) {
        e.preventDefault();
        $('.nav-segmented-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
    });
</script>

@include("pages.pegawai.pegawai.datariwayat.jabatan.js")
@include("pages.pegawai.pegawai.datariwayat.gajipokok.js")
@include("pages.pegawai.pegawai.datariwayat.tunjangan.js")
@include("pages.pegawai.pegawai.datariwayat.potongan.js")
@include("pages.pegawai.pegawai.datariwayat.pendidikan.js")
@include("pages.pegawai.pegawai.datariwayat.kursus.js")
@include("pages.pegawai.pegawai.datariwayat.cuti.js")
@include("pages.pegawai.pegawai.datariwayat.reimbursement.js")
@include("pages.pegawai.pegawai.datariwayat.shift.js")
@include("pages.pegawai.pegawai.datariwayat.jam_kerja.js")
@include("pages.pegawai.pegawai.datariwayat.penghargaan.js")



@endpush
