<div class="integrationsapp-wrap border overflow-hidden">
	<nav class="integrationsapp-sidebar">
		<div data-simplebar class="nicescroll-bar">
			<div class="menu-content-wrap" id="sidebar-content">
				<div class="menu-group">
					<ul class="nav nav-light navbar-nav flex-column">
						<li class="nav-item active">
							<a class="nav-link item-sidebar-content tab-utama" href="#data_pribadi" data-ajax="{{route('pegawai.pegawai.detail_pribadi',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Data Pribadi</span>
							</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link item-sidebar-content tab-utama" href="#akses_akun" data-ajax="{{route('pegawai.pegawai.akses_akun',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Akses Akun</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link item-sidebar-content tab-utama" href="#posisi_jabatan" data-ajax="{{route('pegawai.posisi.index',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Posisi dan Jabatan</span>
							</a>
						</li>
                        <li class="nav-item">
							<a class="nav-link item-sidebar-content tab-utama" href="#data_koor" id="tab-koor" data-ajax="{{route('pegawai.kordinat.index',$pegawai->nip)}}">
								<span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
								<span class="nav-link-text">Data Koordinat</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="menu-gap"></div>
                <div class="nav-header"><span>Riwayat</span></div>
                <div class="menu-group">
					<ul class="nav nav-light navbar-nav flex-column">
						<li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="21" href="#jabatan"
                                data-tableurl="{{konfigJabatan($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigJabatan($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigJabatan($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Jabatan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="22" href="#gaji_pokok"
                                data-tableurl="{{konfigGajiPokok($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigGajiPokok($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigGajiPokok($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Gaji Pokok</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="23" href="#data_tunjangan"
                                data-tableurl="{{konfigGTunjangan($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigGTunjangan($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigGTunjangan($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Tunjangan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="24" href="#data_potongan"
                                data-tableurl="{{konfigPotongan($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigPotongan($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigPotongan($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Potongan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="25" href="#data_pendidikan"
                                data-tableurl="{{konfigPendidikan($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigPendidikan($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigPendidikan($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Pendidikan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="26"  href="#data_kursus"
                                data-tableurl="{{konfigKursus($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigKursus($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigKursus($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Kursus</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="27"  href="#data_cuti" 
                                data-tableurl="{!!konfigCuti($pegawai['nip'])['url']!!}"
                                data-tablecolumn='{!!json_encode(konfigCuti($pegawai["nip"])["data"])!!}'
                                data-tableadd="{!!konfigCuti($pegawai["nip"])["url_add"]!!}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Cuti</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="28" href="#data_lembur"
                                data-tableurl="{!!konfigLembur($pegawai['nip'])['url']!!}"
                                data-tablecolumn='{!!json_encode(konfigLembur($pegawai["nip"])["data"])!!}'
                                data-tableadd="{!!konfigLembur($pegawai["nip"])["url_add"]!!}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Lembur</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="29"  href="#data_reimbursement"
                                data-tableurl="{!!konfigReimbursment($pegawai['nip'])['url']!!}"
                                data-tablecolumn='{!!json_encode(konfigReimbursment($pegawai["nip"])["data"])!!}'
                                data-tableadd="{!!konfigReimbursment($pegawai["nip"])["url_add"]!!}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Reimbursment</span>
                            </a>
                        </li><li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="30"  href="#data_shift"
                                data-tableurl="{!!konfigShift($pegawai['nip'])['url']!!}"
                                data-tablecolumn='{!!json_encode(konfigShift($pegawai["nip"])["data"])!!}'
                                data-tableadd="{!!konfigShift($pegawai["nip"])["url_add"]!!}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Shift</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="31"  href="#data_penghargaan"
                                data-tableurl="{!!konfigPenghargaan($pegawai['nip'])['url']!!}"
                                data-tablecolumn='{!!json_encode(konfigPenghargaan($pegawai["nip"])["data"])!!}'
                                data-tableadd="{!!konfigPenghargaan($pegawai["nip"])["url_add"]!!}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Penghargaan</span>
                            </a>
                        </li>
					</ul>
				</div>
                <div class="menu-gap"></div>
                <div class="nav-header"><span>Keluarga</span></div>
                <div class="menu-group">
                    <ul class="nav nav-light navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#keluarga"
                                data-tableurl="{{konfigSemuaKeluarga($pegawai['nip'])['url']}}"
                                data-tablecolumn='{!!json_encode(konfigSemuaKeluarga($pegawai['nip'])['data'])!!}'
                                data-tableadd="{{konfigSemuaKeluarga($pegawai['nip'])['url_add']}}"
                                >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Semua Keluarga</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#orang_tua" 
                            data-tableurl="{{konfigOrangTua($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigOrangTua($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigOrangTua($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Orang Tua</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#data_koor"
                            data-tableurl="{{konfigIstri($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigIstri($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigIstri($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Istri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#data_koor"
                            data-tableurl="{{konfigAnak($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigAnak($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigAnak($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Anak</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="menu-gap"></div>
                <div class="nav-header"><span>Lainnya</span></div>
                <div class="menu-group">
                    <ul class="nav nav-light navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#data_organisasi"
                            data-tableurl="{{konfigOrganisasi($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigOrganisasi($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigOrganisasi($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Organisasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable"  href="#penguasaan_bahasa"
                            data-tableurl="{{konfigPenguasaanBahasa($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigPenguasaanBahasa($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigPenguasaanBahasa($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Penguasaan Bahasa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" href="#data_koor"
                            data-tableurl="{{konfigSptTahunan($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigSptTahunan($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigSptTahunan($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Rp. SPT Tahunan</span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="33" href="#pengalaman"
                            data-tableurl="{{konfigPengalamanKerja($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigPengalamanKerja($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigPengalamanKerja($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Pengalaman Kerja</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link item-sidebar-content tab-datatable" data-tipepage="32" href="#riwayatlainnya"
                            data-tableurl="{{konfigRiwayatLainnya($pegawai['nip'])['url']}}"
                            data-tablecolumn='{!!json_encode(konfigRiwayatLainnya($pegawai['nip'])['data'])!!}'
                            data-tableadd="{{konfigRiwayatLainnya($pegawai['nip'])['url_add']}}"
                            >
                                <span class="nav-icon-wrap">{!!icons('c-arror-right')!!}</span>
                                <span class="nav-link-text">Riwayat Lainnya</span>
                            </a>
                        </li>
                    </ul>
                </div>
			</div>
		</div>
		<!--Sidebar Fixnav-->
		
		<!--/ Sidebar Fixnav-->
	</nav>
	<div class="integrationsapp-content">
		<div class="integrationsapp-detail-wrap">
			<header class="integrations-header">
				<div class="d-flex align-items-center flex-1">
					<a href="#" class="integrationsapp-title link-dark flex-shrink-0">
						<h1 id="title-content">Data Pribadi</h1>
					</a>
				</div>
				<div class="hk-sidebar-togglable"></div>
			</header>
			<div class="integrations-body">
				<div data-simplebar class="nicescroll-bar">
                <div class="container mt-md-3">
                    <div class="loading text-center mb-2">
                        <div class="loadingio-spinner-ellipsis-ul1uzlc5yan"><div class="ldio-cvh2xv40fr">
                        <div></div><div></div><div></div><div></div><div></div>
                        </div></div>
                        <p>Tunggu sebentar, sedang memuat halaman ....</p>
                    </div>
                    <div id="data_pribadi" class="view-data-utama"></div>
                    <div id="posisi_jabatan" class="view-data-utama"></div>
                    <div id="data_koor" class="view-data-utama"></div>
                    <div id="akses_akun" class="view-data-utama"></div>
                    <div class="target-view"></div>
                </div>
				
			</div>
		</div>
	</div>
</div>