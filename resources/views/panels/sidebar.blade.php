{{-- sidebar --}}
@php
    $pegawai = false;
    $hrd = false;

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
    $payrollBonus = false;
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

    if(role('owner') || role('admin')){
        $data = ["pegawai","setting","menuPerusahaan",
                "masterDataStatusPegawai","masterDataDivisiKerja","masterDataTingkatJabatan","masterDataLevelJabatan","masterDataTingkatPendidikan","masterDataJurusan","masterDataKursus","masterDataLokasiKerja","masterDataLokasiVisit","masterDataHariLibur","masterDataIzin","masterDataShift","masterDataJamKerja","masterDataGajiUMK","masterDataTunjangan","masterDataLembur","masterDataKomponenPotonganTelat","masterDataKomponenBonus","masterDataKomponenPotongan","masterDataPenghargaan","masterDataRiwayatLainnya","masterDataReimbursement",
                "payrollGenerate","payrollPenambahan","payrollBonus","payrollPengurangan","absensiHarian","absensiRekap","absensiTotal","dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift","laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas","infoPengumuman",
                "setting"
            ];
        foreach ($data as $value) {
            $$value = true;
        }
    }

    if(role('finance')){
        $data = ["pegawai","hrd",
                "payrollGenerate","payrollBonus","payrollPenambahan","payrollPengurangan",
                "dataPengajuanReimbursement"
                ];
        foreach ($data as $value) {
            $$value = true;
        }
    }

    // $levelUser = getLevelUser();
    // $menu = \App\Models\MRoleMenu::where('kode_level','level_'.$levelUser)->get();
    // dd($menu->pluck('kode_menu')->toArray());
    $roleLevel2 = role('level_2'); // HR
    $roleLevel3 = role('level_3'); // BUK
    $roleLevel4 = role('level_4'); // PIC

    // if($roleLevel3){
    //     $data = $menu->pluck('kode_menu')->toArray();
    //     foreach ($data as $value) {
    //         $$value = true;
    //     }
    // }
    if($roleLevel2){
        $data = ["pegawai","hrd",
                "masterDataDivisiKerja","masterDataLokasiKerja","masterDataLokasiVisit",
                "absensiHarian","absensiRekap","absensiTotal",
                "dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift",
                "laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas"
                ];
        foreach ($data as $value) {
            $$value = true;
        }
    }
    if($roleLevel3){
        $data = ["pegawai","hrd",
                "masterDataDivisiKerja","masterDataLokasiKerja","masterDataLokasiVisit","masterDataJamKerja","masterDataShift",
                "payrollGenerate",
                ];
        foreach ($data as $value) {
            $$value = true;
        }
    }
    // dd($roleLevel4);
    if($roleLevel4){
        $data = ["pegawai","hrd",
                "payrollGenerate",
                "absensiHarian","absensiRekap","absensiTotal",
                "dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift",
                "laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas"
                ];
        foreach ($data as $value) {
            $$value = true;
        }
    }

@endphp

<div class="hk-menu">
    <!-- Brand -->
    <div class="menu-header">
        <span>
        <a class="navbar-brand" href="{{url("/")}}">
                <img class="brand-img img-fluid" width="40px" src="{{url('public/'.$perusahaan->logo)}}" alt="brand" />
                {{-- <img class="brand-img img-fluid" src="{{asset('/')}}dist/img/Jampack.svg" alt="brand" /> --}}
                <span class="fw-bold ms-2">{{config('app.name')}}</span>
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
                    {{-- FOR HRD --}}
                    @if($hrd)
                    @include('panels.sidebar-hrd')
                    @endif
                    <li class="nav-item d-none">
                        {{-- {{activeMenu("pegawai")}} --}}
                        <a class="nav-link" href="{{route('presensi.penjadwalanshift.index')}}">
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
                    @if(role('owner') || role('admin') || role('finance') || $roleLevel4)
                    {{-- Master --}}
                    @if(!role('finance') && !$roleLevel4)
                    <div class="menu-gap"></div>
                    <div class="nav-header">
                        <span>Master</span>
                    </div>
                    {{-- Master Data --}}
                    <li class="nav-item {{activeMenu("master")}}">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#master">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('box',24)!!}
                                </span>
                            </span>
                            <span class="nav-link-text">Master Data</span>
                        </a>
                        <ul id="master" class="nav flex-column collapse  nav-children">
                            {{-- Data Jabatan --}}
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_jabatan">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('git-merge')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Kepegawaian</span>
                                </a>
                                <ul id="data_jabatan" class="nav flex-column collapse sub2menu nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataStatusPegawai)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.status_pegawai.index')}}"><span class="nav-link-text">Status Pegawai</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataTingkatJabatan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.eselon.index')}}"><span class="nav-link-text">Level Jabatan</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataDivisiKerja)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.skpd.index')}}"><span class="nav-link-text">Divisi Kerja</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataTingkatJabatan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.tingkat.index')}}"><span class="nav-link-text">Tingkat Jabatan</span></a>
                                            </li>
                                            @endif

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- Data Pendidikan --}}
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_pendidikan">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('book-open')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Pendidikan</span>
                                </a>
                                <ul id="data_pendidikan" class="nav flex-column sub2menu collapse  nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataTingkatPendidikan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.pendidikan.index')}}"><span class="nav-link-text">Tingkat Pendidikan</span></a>
                                            </li>
                                            @endif
                                            @if ($masterDataJurusan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.jurusan.index')}}"><span class="nav-link-text">Jurusan</span></a>
                                            </li>
                                            @endif
                                            @if ($masterDataKursus)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.kursus.index')}}"><span class="nav-link-text">Kursus & Pelatihan</span></a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- Data Presensi --}}
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_location">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('location')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Lokasi</span>
                                </a>
                                <ul id="data_location" class="nav flex-column sub2menu collapse  nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataLokasiKerja)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.lokasi.index')}}"><span class="nav-link-text">Lokasi Kerja</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataLokasiVisit)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.visit.index')}}"><span class="nav-link-text">Lokasi Visit</span></a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- Data Presensi --}}
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_presensi">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('file-text')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Presensi</span>
                                </a>
                                <ul id="data_presensi" class="nav flex-column sub2menu collapse  nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataHariLibur)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.hariLibur.index')}}"><span class="nav-link-text">Hari Libur</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataIzin)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.cuti.index')}}"><span class="nav-link-text">Izin</span></a>
                                            </li>
                                            @endif
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
                            {{-- Data Payroll --}}

                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_payroll">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('dollar')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Payroll</span>
                                </a>
                                <ul id="data_payroll" class="nav flex-column sub2menu collapse  nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataGajiUMK)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.umk.index')}}"><span class="nav-link-text">Gaji Umk</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataTunjangan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.tunjangan.index')}}"><span class="nav-link-text">Tunjangan</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataLembur)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.lembur.index')}}"><span class="nav-link-text">Lembur</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataKomponenPotonganTelat)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.absensi.index')}}"><span class="nav-link-text">Potongan Telat & Cepat Pulang</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataKomponenBonus)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.penambahan.index')}}"><span class="nav-link-text">Komponen Bonus</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataKomponenPotongan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.payroll.pengurangan.index')}}"><span class="nav-link-text">Komponen Potongan</span></a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            {{-- Data Lainya --}}
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_lainya">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            {!!icons('more-vertical')!!}
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Data Lainya</span>
                                </a>
                                <ul id="data_lainya" class="nav flex-column collapse sub2menu nav-children">
                                    <li class="nav-item">
                                        <ul class="nav flex-column">
                                            @if($masterDataPenghargaan)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.penghargaan.index')}}"><span class="nav-link-text">Penghargaan</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataRiwayatLainnya)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.lainnya.index')}}"><span class="nav-link-text">Riwayat Lainya</span></a>
                                            </li>
                                            @endif
                                            @if($masterDataReimbursement)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('master.reimbursement.index')}}"><span class="nav-link-text">Reimbursement</span></a>
                                            </li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    {{-- Payroll --}}
                    <li class="nav-item {{activeMenu("payroll")}}">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#payroll">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    <span class="svg-icon">
                                        {!!icons('dollar')!!}
                                    </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Payroll</span>
                        </a>
                        <ul id="payroll" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    @if($payrollGenerate)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('payroll.generate.index')}}"><span class="nav-link-text">Generate Payroll</span></a>
                                    </li>
                                    @endif
                                    @if($payrollPenambahan)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('payroll.tambah.index')}}"><span class="nav-link-text">Tunjangan</span></a>
                                    </li>
                                    @endif
                                    @if($payrollBonus)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('payroll.bonus.index')}}"><span class="nav-link-text">Bonus</span></a>
                                    </li>
                                    @endif
                                    @if($payrollPengurangan)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('payroll.kurang.index')}}"><span class="nav-link-text">Potongan</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(role('owner') || role('admin') || role('finance') || role('opd') || $roleLevel2 || $roleLevel4)
                    {{-- Menu Riwayat --}}
                    <div class="menu-gap"></div>
                    <div class="nav-header">
                        <span>Absensi</span>
                    </div>
                    {{-- Daftar Presensi --}}
                    @if($absensiHarian)
                    <li class="nav-item {{activeMenu("presensi")}}">
                        <a class="nav-link" href="{{route('pengajuan.presensi.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('file-text')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Presensi Harian</span>
                        </a>
                    </li>
                    @endif
                    @if($absensiRekap)
                    <li class="nav-item {{activeMenu("rekapabsen")}}">
                        {{-- {{activeMenu("pegawai")}} --}}
                        <a class="nav-link " href="{{route('presensi.rekapabsen.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path>
                                        <path d="M14 19l2 2l4 -4"></path>
                                        <path d="M9 8h4"></path>
                                        <path d="M9 12h2"></path>
                                    </svg>
                                </span>
                            </span>
                            <span class="nav-link-text">Rekap Presensi</span>
                        </a>
                    </li>
                    @endif
                    @if($absensiTotal)
                    <li class="nav-item {{activeMenu("total_presensi")}}">
                        <a class="nav-link" href="{{route('presensi.total_presensi.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('hash')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Total Presensi</span>
                        </a>
                    </li>
                    @endif
                    {{-- Pengajuan --}}
                    <li class="nav-item {{activeMenu("pengajuan")}}">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_pengajuan">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    <span class="svg-icon">
                                        {!!icons('plane')!!}
                                    </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Data Pengajuan</span>
                        </a>
                        <ul id="data_pengajuan" class="nav flex-column collapse  nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    @if($dataPengajuanIzin)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('pengajuan.cuti.index')}}"><span class="nav-link-text">Pengajuan Izin</span></a>
                                    </li>
                                    @endif
                                    @if($dataPengajuanLembur)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('pengajuan.lembur.index')}}"><span class="nav-link-text">Pengajuan Lembur</span></a>
                                    </li>
                                    @endif
                                    @if($dataPengajuanReimbursement)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('pengajuan.reimbursement.index')}}"><span class="nav-link-text">Pengajuan Reimbursement</span></a>
                                    </li>
                                    @endif
                                    @if($dataPengajuanShift)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('pengajuan.shift.index')}}"><span class="nav-link-text">Pengajuan Shift</span></a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(role('owner') || role('admin') || $roleLevel2)
                    <div class="menu-gap"></div>
                    <div class="nav-header">
                        <span>Laporan</span>
                    </div>
                    @if($laporanPresensi)
                    <li class="nav-item {{activeMenu("laporan-pegawai")}}">
                        <a class="nav-link" href="{{route('pengajuan.presensi.laporan_pegawai')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('paper')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Presensi Pegawai</span>
                        </a>
                    </li>
                    @endif
                    {{-- @if($laporanDivisi)
                    <li class="nav-item {{activeMenu("laporan-divisi")}}">
                        <a class="nav-link" href="{{route('pengajuan.presensi.laporan_divisi')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('paper')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Divisi</span>
                        </a>
                    </li>
                    @endif --}}
                    @if($laporanVisit)
                    <li class="nav-item {{activeMenu("laporan-visit")}}">
                        <a class="nav-link" href="{{route('presensi.laporan_visit.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('paper')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Visit</span>
                        </a>
                    </li>
                    @endif
                    @if($laporanAktifitas)
                    <li class="nav-item {{activeMenu("laporan-aktifitas")}}">
                        <a class="nav-link" href="{{route('presensi.aktifitas.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('paper')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Aktifitas</span>
                        </a>
                    </li>
                    @endif
                    @endif
                    @if(role('owner') || role('admin'))
                    @if ($infoPengumuman)
                    {{-- Menu Informasi --}}
                    <div class="menu-gap"></div>
                    <div class="nav-header">
                        <span>Informasi</span>
                    </div>
                    {{-- Pengumuman --}}
                    <li class="nav-item {{activeMenu("pengumuman")}}">
                        <a class="nav-link" href="{{route('pengumuman.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('alert-octagon')!!}
                                </span>
                                </span>
                            </span>
                            <span class="nav-link-text">Pengumuman</span>
                        </a>
                    </li>
                    @endif

                    @if($setting)
                    {{-- Setting --}}
                    <div class="menu-gap d-block d-md-none"></div>
                    <div class="nav-header d-block d-md-none">
                        <span>Setting</span>
                    </div>
                    <li class="nav-item d-block {{activeMenu("role-menu")}}">
                        <a class="nav-link" href="{{route('setting.role-menu.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('building')!!}
                                </span>
                            </span>
                            <span class="nav-link-text">Role Management</span>
                        </a>
                    </li>
                    @endif

                    @if($menuPerusahaan)
                    {{-- Manajemen User --}}
                    <li class="nav-item d-block d-md-none {{activeMenu("manajemen-user")}}">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#manajemen_user">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('user-check')!!}
                                </span>
                            </span>
                            <span class="nav-link-text">Manajemen User</span>
                        </a>
                        <ul id="manajemen_user" class="nav flex-column collapse nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('users.hrd.index')}}"><span class="nav-link-text">HRD</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('users.manager.index')}}"><span class="nav-link-text">Kepala Divisi</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Profile Perusahaan --}}
                    <li class="nav-item d-block d-md-none {{activeMenu("perusahaan")}}">
                        <a class="nav-link" href="{{route('perusahaan.index')}}">
                            <span class="nav-icon-wrap">
                                <span class="svg-icon">
                                    {!!icons('building')!!}
                                </span>
                            </span>
                            <span class="nav-link-text">Profile Perusahaan</span>
                        </a>
                    </li>
                    @endif
                    @endif
                </ul>
            </div>



        </div>
    </div>
    <!-- /Main Menu -->
</div>
<div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
{{-- sidebar end --}}
