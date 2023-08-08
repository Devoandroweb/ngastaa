{{-- sidebar --}}
@php
    $pegawai = false;
    $hrd = false;
    $penjadwalanShift = false;

    $masterDataStatusPegawai = false;
    $masterDataDivisiKerja = false;
    $masterDataTingkatJabatan = false;
    $masterDataLevelJabatan = false;
    $masterDataTingkatPendidikan = false;
    $masterDataJurusan = false;
    $masterDataKursus = false;
    $masterDataLokasiKerja = false;
    $masterDataLokasiVisit = false;
    $masterDataHariLibur = false;
    $masterDataIzin = false;
    $masterDataShift = false;
    $masterDataJamKerja = false;
    $masterDataGajiUMK = false;
    $masterDataTunjangan = false;
    $masterDataLembur = false;
    $masterDataKomponenPotonganTelat = false;
    $masterDataKomponenBonus = false;
    $masterDataKomponenPotongan = false;
    $masterDataPenghargaan = false;
    $masterDataRiwayatLainnya = false;
    $masterDataReimbursement = false;

    $payrollGenerate = false;
    $payrollPenambahan = false;
    $payrollPengurangan = false;

    $absensiHarian = false;
    $absensiRekap = false;
    $absensiTotal = false;

    $dataPengajuanIzin = false;
    $dataPengajuanLembur = false;
    $dataPengajuanReimbursement = false;
    $dataPengajuanShift = false;

    $laporanPresensi = false;
    $laporanDivisi = false;
    $laporanVisit = false;
    $laporanAktifitas = false;

    $infoPengumuman = false;
    $setting = false;
    $menuPerusahaan = false;

    // if(role('owner') || role('admin')){
    //     $data = ["pegawai","setting","menuPerusahaan",
    //             "masterDataStatusPegawai","masterDataDivisiKerja","masterDataTingkatJabatan","masterDataLevelJabatan","masterDataTingkatPendidikan","masterDataJurusan","masterDataKursus","masterDataLokasiKerja","masterDataLokasiVisit","masterDataHariLibur","masterDataIzin","masterDataShift","masterDataJamKerja","masterDataGajiUMK","masterDataTunjangan","masterDataLembur","masterDataKomponenPotonganTelat","masterDataKomponenBonus","masterDataKomponenPotongan","masterDataPenghargaan","masterDataRiwayatLainnya","masterDataReimbursement",
    //             "payrollGenerate","payrollPenambahan","payrollPengurangan","absensiHarian","absensiRekap","absensiTotal","dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift","laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas","infoPengumuman",
    //         ];
    //     foreach ($data as $value) {
    //         $$value = true;
    //     }
    // }

    // if(role('finance')){
    //     $data = ["pegawai","hrd",
    //             "payrollGenerate","payrollPenambahan","payrollPengurangan",
    //             "dataPengajuanReimbursement"
    //             ];
    //     foreach ($data as $value) {
    //         $$value = true;
    //     }
    // }

    $kodeTingkat = getKodeJabatanUser();

    $menu = \App\Models\MRoleMenu::where('kode_tingkat',$kodeTingkat)->get();
    // dd($menu->pluck('kode_menu')->toArray());
    // $roleLevel2 = role('level_2'); // HR
    // $roleLevel3 = role('level_3'); // BUK
    // $roleLevel4 = role('level_4'); // PIC

    $data = $menu->pluck('kode_menu')->toArray();
    foreach ($data as $value) {
        $$value = true;
    }

    // if($roleLevel2){
    //     $data = ["pegawai","hrd",
    //             "masterDataDivisiKerja","masterDataLokasiKerja","masterDataLokasiVisit",
    //             "absensiHarian","absensiRekap","absensiTotal",
    //             "dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift",
    //             "laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas"
    //             ];
    //     foreach ($data as $value) {
    //         $$value = true;
    //     }
    // }
    // // dd($roleLevel4);
    // if($roleLevel4){
    //     $data = ["pegawai","hrd",
    //             "payrollGenerate",
    //             "absensiHarian","absensiRekap","absensiTotal",
    //             "dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift",
    //             "laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas"
    //             ];
    //     foreach ($data as $value) {
    //         $$value = true;
    //     }
    // }
    # PEGAWAI #
    // $pegawai = role('owner') || role('admin') || role('opd');

    // $hrd = role('owner') || role('admin') || role('opd');
    // $masterData = role('owner') || role('admin');
    // $masterPayroll = role('owner') || role('admin') || role('finance');
    // $absensiHarian = role('owner') || role('admin');
    // $absensiRekap = role('owner') || role('admin');
    // $absensiTotal = role('owner') || role('admin');
    // $dataPengajuan = role('owner') || role('admin');
    // $laporanPresensi = role('owner') || role('admin');
    // $laporanDivisi = role('owner') || role('admin');
    // $laporanVisit = role('owner') || role('admin');
    // $laporanAktifitas = role('owner') || role('admin');
    // $infoPengumuman = role('owner') || role('admin');

@endphp

<div class="hk-menu">
    <!-- Brand -->
    <div class="menu-header">
        <span>
        <a class="navbar-brand" href="{{url("/")}}">
                <img class="brand-img img-fluid" width="40px" src="{{url('public/'.$perusahaan->logo)}}" alt="brand" />
                {{-- <img class="brand-img img-fluid" src="{{asset('/')}}dist/img/Jampack.svg" alt="brand" /> --}}
                <span class="fw-bold ms-2">DSM Absen</span>
            </a>
            <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
                <span class="icon">
                    <span class="svg-icon fs-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="10" y1="12" x2="20" y2="12"></line>
                            <line x1="10" y1="12" x2="14" y2="16"></line>
                            <line x1="10" y1="12" x2="14" y2="8"></line>
                            <line x1="4" y1="4" x2="4" y2="20"></line>
                        </svg>
                    </span>
                </span>
            </button>
        </span>
    </div>
    <!-- /Brand -->

    <!-- Main Menu -->
    <div data-simplebar class="nicescroll-bar">
        <div class="menu-content-wrap">

            <div class="menu-group">
                {{-- Dashboar --}}
                <div class="menu-group">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item {{activeMenu("dashboard")}}">
                            <a class="nav-link" href="{{url('dashboard')}}">
                                <span class="nav-icon-wrap">
                                    <span class="svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <rect x="4" y="4" width="16" height="4" rx="1" />
                                            <rect x="4" y="12" width="6" height="8" rx="1" />
                                            <line x1="14" y1="12" x2="20" y2="12" />
                                            <line x1="14" y1="16" x2="20" y2="16" />
                                            <line x1="14" y1="20" x2="20" y2="20" />
                                        </svg>
                                    </span>
                                </span>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav flex-column">
                    {{-- Profil Pegawai --}}
                    @if($pegawai)
                    <li class="nav-item {{activeMenu("pegawai")}}">
                        <a class="nav-link" href="{{route('pegawai.pegawai.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Pegawai</span>
                        </a>
                    </li>
                    @endif
                    @if($penjadwalanShift)
                    <li class="nav-item {{activeMenu("penjadwalanshift")}}">
                        <a class="nav-link" href="{{route('penjadwalanshift.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697"></path>
                                        <path d="M18 14v4h4"></path>
                                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2"></path>
                                        <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M8 11h4"></path>
                                        <path d="M8 15h3"></path>
                                    </svg>
                                </span>
                            </span>
                            <span class="nav-link-text">Penjadwalan Shift</span>
                        </a>
                    </li>
                    @endif
                    @if($masterDataStatusPegawai)
                    <li class="nav-item {{activeMenu("status-pegawai")}}">
                        <a class="nav-link" href="{{route('master.status_pegawai.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Status Pegawai</span>
                        </a>
                    </li>
                    @endif
                    @if($masterDataDivisiKerja)
                    <li class="nav-item {{activeMenu("skpd")}}">
                        <a class="nav-link" href="{{route('master.skpd.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Divisi Kerja</span>
                        </a>
                    </li>
                    @endif
                    @if($masterDataLokasiKerja)
                    <li class="nav-item {{activeMenu("lokasi")}}">
                        <a class="nav-link" href="{{route('master.lokasi.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Lokasi Kerja</span>
                        </a>
                    </li>
                    @endif
                    @if($masterDataLokasiVisit)
                    <li class="nav-item {{activeMenu("visit")}}">
                        <a class="nav-link" href="{{route('master.visit.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Lokasi Visit</span>
                        </a>
                    </li>
                    @endif

                    @if($masterDataShift && $masterDataJamKerja)
                    <li class="nav-item {{activeMenu("shift")}}{{activeMenu("jam_kerja")}}">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_presensi">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('file-text')!!}
                                </span>
                            </span>
                            <span class="nav-link-text">Data Presensi</span>
                        </a>
                        <ul id="data_presensi" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    @if($masterDataShift)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('master.shift.index')}}"><span class="nav-link-text">Shift</span></a>
                                    </li>
                                    @endif
                                    @if($masterDataJamKerja)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('master.jam_kerja.index')}}"><span class="nav-link-text">Jam Kerja</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if($payrollGenerate)
                    <li class="nav-item {{activeMenu("generate")}}">
                        <a class="nav-link" href="{{route('payroll.generate.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!! icons('users') !!}
                                </span>
                            </span>
                            <span class="nav-link-text">Generate Payroll</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- /Main Menu -->
</div>
<div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
{{-- sidebar end --}}
