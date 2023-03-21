<ul class="nav nav-icon nav-tabs nav-justified nav-segmented-tabs nav-light mt-6">
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#data_pribadi"
        data-tableurl="{{konfigOrganisasi($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigOrganisasi($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigOrganisasi($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-sitemap"></i></span></span>
            <span class="nav-link-text">Organisasi</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab"  href="#penguasaan_bahasa"
        data-tableurl="{{konfigPenguasaanBahasa($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigPenguasaanBahasa($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigPenguasaanBahasa($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-language"></i></span></span>
            <span class="nav-link-text">Penguasaan Bahasa</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#data_koor"
        data-tableurl="{{konfigSptTahunan($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigSptTahunan($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigSptTahunan($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-link-text">Rp. SPT Tahunan</span>
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" data-tipepage="33" href="#pengalaman"
        data-tableurl="{{konfigPengalamanKerja($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigPengalamanKerja($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigPengalamanKerja($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-file"></i></span></span>
            <span class="nav-link-text">Pengalaman Kerja</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-tipepage="32" data-bs-toggle="tab" href="#riwayatlainnya"
        data-tableurl="{{konfigRiwayatLainnya($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigRiwayatLainnya($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigRiwayatLainnya($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-history"></i></span></span>
            <span class="nav-link-text">Riwayat Lainnya</span>
        </a>
    </li>
</ul>
@push('js')
    
<script>
    $(".nav-segmented-tabs .nav-link").click(function (e) { 
        e.preventDefault();
        $('.nav-segmented-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
    });
    
    
</script>
@include("pages.pegawai.pegawai.datalainnya.riwayatlainnya.js")

@endpush