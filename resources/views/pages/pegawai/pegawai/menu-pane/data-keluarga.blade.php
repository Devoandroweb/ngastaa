<ul class="nav nav-icon nav-tabs nav-justified nav-segmented-tabs nav-light mt-6">
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#data_pribadi"
            data-tableurl="{{konfigSemuaKeluarga($pegawai['nip'])['url']}}"
            data-tablecolumn='{!!json_encode(konfigSemuaKeluarga($pegawai['nip'])['data'])!!}'
            data-tableadd="{{konfigSemuaKeluarga($pegawai['nip'])['url_add']}}"
            >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-users"></i></span></span>
            <span class="nav-link-text">Semua Keluarga</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#orang_tua" 
        data-tableurl="{{konfigOrangTua($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigOrangTua($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigOrangTua($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-id-card-alt"></i></span></span>
            <span class="nav-link-text">Orang Tua</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#data_koor"
        data-tableurl="{{konfigIstri($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigIstri($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigIstri($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-user-friends"></i></span></span>
            <span class="nav-link-text">Istri</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link bg-primary text-white tab-datatable" data-bs-toggle="tab" href="#data_koor"
        data-tableurl="{{konfigAnak($pegawai['nip'])['url']}}"
        data-tablecolumn='{!!json_encode(konfigAnak($pegawai['nip'])['data'])!!}'
        data-tableadd="{{konfigAnak($pegawai['nip'])['url_add']}}"
        >
            <span class="nav-icon-wrap"><span class="feather-icon"><i class="fas fa-child"></i></span></span>
            <span class="nav-link-text">Anak</span>
        </a>
    </li>
</ul>

{{-- @push("js")
<script>
    $(".nav-segmented-tabs .nav-link").click(function (e) { 
        e.preventDefault();
        $('.nav-segmented-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
    });
</script>
@endpush --}}