 <?php

use App\Http\Controllers\CAktifitas;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Master\BidangController;
use App\Http\Controllers\Master\CutiController;
use App\Http\Controllers\Master\DiklatStrukturalController;
use App\Http\Controllers\Master\EselonController;
use App\Http\Controllers\Master\GolonganController;
use App\Http\Controllers\Master\HariLiburController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\JenisKpController;
use App\Http\Controllers\Master\JurusanController;
use App\Http\Controllers\Master\KursusController;
use App\Http\Controllers\Master\LainnyaController;
use App\Http\Controllers\Master\LokasiController;
use App\Http\Controllers\Master\PayrollAbsensiController;
use App\Http\Controllers\Master\PayrollLemburController;
use App\Http\Controllers\Master\PayrollPotonganController;
use App\Http\Controllers\Master\PayrollTunjanganContoller;
use App\Http\Controllers\Master\PenambahanPayrollController;
use App\Http\Controllers\Master\PendidikanController;
use App\Http\Controllers\Master\PenghargaanController;
use App\Http\Controllers\Master\PenguranganPayrollController;
use App\Http\Controllers\Master\ReimbursementController;
use App\Http\Controllers\Master\SeksiController;
use App\Http\Controllers\Master\ShiftController;
use App\Http\Controllers\Master\SkpdController;
use App\Http\Controllers\Master\StatusPegawaiController;
use App\Http\Controllers\Master\SukuController;
use App\Http\Controllers\Master\TingkatController;
use App\Http\Controllers\Master\UmkController;
use App\Http\Controllers\Master\VisitController;
use App\Http\Controllers\Payroll\GeneratePayrollController;
use App\Http\Controllers\Payroll\KurangPayrollController;
use App\Http\Controllers\Payroll\TambahPayrollController;
use App\Http\Controllers\Pegawai\DataKordinatController;
use App\Http\Controllers\Pegawai\DataPosisiControlller;
use App\Http\Controllers\Pegawai\DataPresensiController;
use App\Http\Controllers\Pegawai\DataVisitController;
use App\Http\Controllers\Pegawai\KeluargaController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Pegawai\PegawaiJabatanController;
use App\Http\Controllers\Pegawai\RiwayatBahasaController;
use App\Http\Controllers\Pegawai\RiwayatCutiController;
use App\Http\Controllers\Pegawai\RiwayatDiklatController;
use App\Http\Controllers\Pegawai\RiwayatGolonganController;
use App\Http\Controllers\Pegawai\RiwayatKgbController;
use App\Http\Controllers\Pegawai\RiwayatKursusController;
use App\Http\Controllers\Pegawai\RiwayatLainnyaController;
use App\Http\Controllers\Pegawai\RiwayatLemburController;
use App\Http\Controllers\Pegawai\RiwayatLhkasnController;
use App\Http\Controllers\Pegawai\RiwayatLhkpnController;
use App\Http\Controllers\Pegawai\RiwayatOrganisasiController;
use App\Http\Controllers\Pegawai\RiwayatPendidikanController;
use App\Http\Controllers\Pegawai\RiwayatPenghargaanController;
use App\Http\Controllers\Pegawai\RiwayatPmkController;
use App\Http\Controllers\Pegawai\RiwayatPotonganController;
use App\Http\Controllers\Pegawai\RiwayatReimbursementController;
use App\Http\Controllers\Pegawai\RiwayatShiftController;
use App\Http\Controllers\Pegawai\RiwayatSptController;
use App\Http\Controllers\Pegawai\RiwayatStatusController;
use App\Http\Controllers\Pegawai\RiwayatTunjanganController;
use App\Http\Controllers\Pegawai\UnduhBerkasController;
use App\Http\Controllers\Pengajuan\CutiPengajuanController;
use App\Http\Controllers\Pengajuan\LemburPengajuanController;
use App\Http\Controllers\Pengajuan\ReimbursementPengajuanController;
use App\Http\Controllers\Pengajuan\ShiftPengajuanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PenjadwalanShiftController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\Presensi\LaporanVisitController;
use App\Http\Controllers\Presensi\RekapAbsensHarianController;
use App\Http\Controllers\Presensi\TotalPresensiController;
use App\Http\Controllers\UbahPassword;
use App\Http\Controllers\Users\DireksiController;
use App\Http\Controllers\Users\HrdController;
use App\Http\Controllers\Users\ManagerController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('login');
});

Route::get('/getroute', function () {
    $routes = Route::getRoutes();
    $routeFilter = [];
    foreach ($routes as $route) {
        if (strstr($route->uri(), "datatable")) {
            array_push($routeFilter, $route->uri());
        }
    }
    dd($routeFilter);
});
Route::get('/maintenance', function () {
    return inertia("Maintenance");
})->name('maintenance');

Route::middleware(['auth'])
    ->group(function () {

        Route::get('dashboard', DashboardController::class)->name('dashboard');
        // Route::post('payrollStatistic', [DashboardController::class,'payrollStatistic'])->name('payrollStatistic');
        Route::get('dashboard-datatable', [DashboardController::class,'datatable'])->name('dashboard_datatable');
        Route::get('dashboard-statstik-payroll', [DashboardController::class,"payrollStatistic"])->name('payrollStatistic');
        Route::get('logs', [LogController::class, 'index'])->name('logs');
        Route::get('ubah-password', [UbahPassword::class, 'index'])->name('password.index');
        Route::post('ubah-password-update', [UbahPassword::class, 'update'])->name('ubah.password.update');
        
        Route::prefix('presensi')
            ->name("presensi.")
            ->middleware('role:opd|admin|owner')
            ->group(function () {

                Route::controller(TotalPresensiController::class)
                ->prefix('total_presensi')
                ->name("total_presensi.")
                ->group(function () {
                    Route::get('', 'index')->name('index');
                    Route::get('detail_izin/{user}', 'detail_izin')->name('detail_izin');
                    Route::get('detail_absen/{user}/{status}', 'detail_absen')->name('detail_absen');
                    Route::get('datatable', 'datatable')->name('datatable');
                    Route::get('datatable_detail_izin/{nip}', 'datatable_detail_izin')->name('datatable_detail_izin');
                    Route::get('datatable_detail_absen/{nip}/{status}', 'datatable_detail_absen')->name('datatable_detail_absen');
                });
                
                Route::prefix('penjadwalanshift')
                ->controller(PenjadwalanShiftController::class)
                    ->name("penjadwalanshift.")
                    ->middleware('role:admin|owner')
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{penjadwalanshift}', 'edit')->name('edit');
                        Route::get('delete/{penjadwalanshift}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
                
                Route::prefix('rekapabsen')
                ->controller(RekapAbsensHarianController::class)
                    ->name("rekapabsen.")
                    ->middleware('role:admin|owner')
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
                Route::prefix('laporan-visit')
                ->controller(LaporanVisitController::class)
                    ->name("laporan_visit.")
                    ->middleware('role:admin|owner|opd')
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
                Route::prefix('aktifitas')
                ->controller(CAktifitas::class)
                    ->name("aktifitas.")
                    ->middleware('role:admin|owner|opd')
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
            });
        Route::prefix('pengumuman')
        ->controller(PengumumanController::class)
            ->name("pengumuman.")
            ->middleware('role:admin|owner')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('add', 'add')->name('add');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{pengumuman}', 'edit')->name('edit');
                Route::get('delete/{pengumuman}', 'delete')->name('delete');
                Route::get('datatable', 'datatable')->name('datatable');
            });

        Route::prefix('perusahaan')
        ->controller(PerusahaanController::class)
            ->name("perusahaan.")
            ->middleware('role:admin|owner')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::post('update', 'update')->name('update');
            });

        Route::prefix('pegawai')
            ->name("pegawai.")
            ->group(function () {

                Route::controller(PegawaiController::class)
                    ->prefix('data')
                    ->name("pegawai.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::get('json-skpd', 'json_skpd')->name('json_skpd');
                        Route::post('store', 'store')->name('store');
                        Route::post('upload', 'upload')->name('upload');
                        Route::get('edit/{pegawai}', 'edit')->name('edit');
                        Route::get('detail/{pegawai}', 'detail')->name('detail');
                        Route::get('detail/pribadi/{pegawai}', 'detailPribadi')->name('detail_pribadi');
                        Route::get('delete/{pegawai}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                        Route::get('import_add', 'import_add')->name('import_add');
                        Route::post('import_pegawai', 'import_pegawai')->name('import_pegawai');
                        Route::get('download-template-import', 'donwloadTemplate')->name('donwload_template_import');
                        Route::get('shift/{pegawai}', 'shift')->name('shift');
                        Route::get('akses-akun/{pegawai}', 'aksesAkun')->name('akses_akun');

                    });

                Route::controller(DataKordinatController::class)
                    ->prefix('kordinat/{pegawai}')
                    ->name("kordinat.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('reset', 'reset')->name('reset');
                        Route::post('store', 'store')->name('store');
                    });
                

                Route::controller(PegawaiJabatanController::class)
                    ->prefix('jabatan/{pegawai}')
                    ->name("jabatan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rjabatan}', 'edit')->name('edit');
                        Route::get('akhir/{Rjabatan}', 'akhir')->name('akhir');
                        Route::get('delete/{Rjabatan}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatTunjanganController::class)
                    ->prefix('tunjangan/{pegawai}')
                    ->name("tunjangan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rtunjangan}', 'edit')->name('edit');
                        Route::get('akhir/{Rtunjangan}', 'akhir')->name('akhir');
                        Route::get('delete/{Rtunjangan}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatPotonganController::class)
                    ->prefix('potongan/{pegawai}')
                    ->name("potongan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rpotongan}', 'edit')->name('edit');
                        Route::get('akhir/{Rpotongan}', 'akhir')->name('akhir');
                        Route::get('delete/{Rpotongan}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatStatusController::class)
                    ->prefix('status/{pegawai}')
                    ->name("status.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rstatus}', 'edit')->name('edit');
                        Route::get('akhir/{Rstatus}', 'akhir')->name('akhir');
                        Route::get('delete/{Rstatus}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatGolonganController::class)
                    ->prefix('golongan/{pegawai}')
                    ->name("golongan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rgolongan}', 'edit')->name('edit');
                        Route::get('akhir/{Rgolongan}', 'akhir')->name('akhir');
                        Route::get('delete/{Rgolongan}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatPendidikanController::class)
                    ->prefix('pendidikan/{pegawai}')
                    ->name("pendidikan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rpendidikan}', 'edit')->name('edit');
                        Route::get('akhir/{Rpendidikan}', 'akhir')->name('akhir');
                        Route::get('delete/{Rpendidikan}', 'delete')->name('delete');
                    });

                Route::controller(KeluargaController::class)
                    ->prefix('keluarga/{pegawai}')
                    ->name("keluarga.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('pasangan', 'pasangan')->name('pasangan');
                        Route::get('anak', 'anak')->name('anak');
                        Route::get('orang-tua', 'orang_tua')->name('orang_tua');
                        Route::get('{status?}/add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('{status?}/edit/{Rkeluarga}', 'edit')->name('edit');
                        Route::get('delete/{Rkeluarga}', 'delete')->name('delete');
                    });

                Route::controller(UnduhBerkasController::class)
                    ->prefix('berkas/{pegawai}')
                    ->name("berkas.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('profile', 'profile')->name('profile');
                        Route::get('profile_pdf', 'profile_pdf')->name('profile_pdf');
                        Route::get('berkas_zip', 'berkas_zip')->name('berkas_zip');
                    });

                Route::controller(DataPosisiControlller::class)
                    ->prefix('posisi/{pegawai}')
                    ->name("posisi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                    });

                Route::controller(RiwayatDiklatController::class)
                    ->prefix('diklat/{pegawai}')
                    ->name("diklat.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rdiklat}', 'edit')->name('edit');
                        Route::get('delete/{Rdiklat}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatKursusController::class)
                    ->prefix('kursus/{pegawai}')
                    ->name("kursus.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rkursus}', 'edit')->name('edit');
                        Route::get('delete/{Rkursus}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatPenghargaanController::class)
                    ->prefix('penghargaan/{pegawai}')
                    ->name("penghargaan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rpenghargaan}', 'edit')->name('edit');
                        Route::get('delete/{Rpenghargaan}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatCutiController::class)
                    ->prefix('cuti/{pegawai}')
                    ->name("cuti.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rcuti}', 'edit')->name('edit');
                        Route::get('delete/{Rcuti}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatLemburController::class)
                    ->prefix('lembur/{pegawai}')
                    ->name("lembur.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rlembur}', 'edit')->name('edit');
                        Route::get('delete/{Rlembur}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatReimbursementController::class)
                    ->prefix('reimbursement/{pegawai}')
                    ->name("reimbursement.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rreimbursement}', 'edit')->name('edit');
                        Route::get('delete/{Rreimbursement}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatShiftController::class)
                    ->prefix('shift/{pegawai}')
                    ->name("shift.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rshift}', 'edit')->name('edit');
                        Route::get('delete/{Rshift}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatKgbController::class)
                    ->prefix('kgb/{pegawai}')
                    ->name("kgb.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('akhir/{Rkgb}', 'akhir')->name('akhir');
                        Route::get('edit/{Rkgb}', 'edit')->name('edit');
                        Route::get('delete/{Rkgb}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatLhkpnController::class)
                    ->prefix('lhkpn/{pegawai}')
                    ->name("lhkpn.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rlhkpn}', 'edit')->name('edit');
                        Route::get('delete/{Rlhkpn}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatLhkasnController::class)
                    ->prefix('lhkasn/{pegawai}')
                    ->name("lhkasn.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rlhkasn}', 'edit')->name('edit');
                        Route::get('delete/{Rlhkasn}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatOrganisasiController::class)
                    ->prefix('organisasi/{pegawai}')
                    ->name("organisasi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rorganisasi}', 'edit')->name('edit');
                        Route::get('delete/{Rorganisasi}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatBahasaController::class)
                    ->prefix('bahasa/{pegawai}')
                    ->name("bahasa.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rbahasa}', 'edit')->name('edit');
                        Route::get('delete/{Rbahasa}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatSptController::class)
                    ->prefix('spt/{pegawai}')
                    ->name("spt.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rspt}', 'edit')->name('edit');
                        Route::get('delete/{Rspt}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatPmkController::class)
                    ->prefix('pmk/{pegawai}')
                    ->name("pmk.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rpmk}', 'edit')->name('edit');
                        Route::get('delete/{Rpmk}', 'delete')->name('delete');
                    });

                Route::controller(RiwayatLainnyaController::class)
                    ->prefix('lainnya/{pegawai}')
                    ->name("lainnya.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{Rlainnya}', 'edit')->name('edit');
                        Route::get('delete/{Rlainnya}', 'delete')->name('delete');
                    });
                    // NEW DATATABLE
                    // ============== Data Riwayat ===================
                    Route::get('jabatan/{pegawai}/datatable', [PegawaiJabatanController::class, "datatable"]);
                    Route::get('kgb/{pegawai}/datatable', [RiwayatKgbController::class, "datatable"]);
                    Route::get('tunjangan/{pegawai}/datatable', [RiwayatTunjanganController::class, "datatable"]);
                    Route::get('potongan/{pegawai}/datatable', [RiwayatPotonganController::class, "datatable"]);
                    Route::get('pendidikan/{pegawai}/datatable', [RiwayatPendidikanController::class, "datatable"]);
                    Route::get('kursus/{pegawai}/datatable', [RiwayatKursusController::class, "datatable"]);
                    Route::get('penghargaan/{pegawai}/datatable', [RiwayatPenghargaanController::class, "datatable"]);
                    Route::get('cuti/{pegawaida}/datatable', [RiwayatCutiController::class, "datatable"]);
                    Route::get('lembur/{pegawai}/datatable', [RiwayatLemburController::class, "datatable"]);
                    Route::get('reimbursement/{pegawai}/datatable', [RiwayatReimbursementController::class, "datatable"]);
                    Route::get('shift/{pegawai}/datatable', [RiwayatShiftController::class, "datatable"]);
                    // ============== Data Keluarga ===================
                    Route::get('keluarga/{pegawai}/datatable_keluarga', [KeluargaController::class, "datatable_keluarga"]);
                    Route::get('keluarga/{pegawai}/datatable_orangtua', [KeluargaController::class, "datatable_orangtua"]);
                    Route::get('keluarga/{pegawai}/datatable_istri', [KeluargaController::class, "datatable_istri"]);
                    Route::get('keluarga/{pegawai}/datatable_anak', [KeluargaController::class, "datatable_anak"]);
                    // ============== Data Lainya ===================
                    Route::get('organisasi/{pegawai}/datatable', [RiwayatOrganisasiController::class, "datatable"]);
                    Route::get('bahasa/{pegawai}/datatable', [RiwayatBahasaController::class, "datatable"]);
                    Route::get('spt/{pegawai}/datatable', [RiwayatSptController::class, "datatable"]);
                    Route::get('pmk/{pegawai}/datatable', [RiwayatPmkController::class, "datatable"]);
                    Route::get('lainnya/{pegawai}/datatable', [RiwayatLainnyaController::class, "datatable"]);


                });

        Route::prefix('payroll')
            ->name("payroll.")
            ->middleware('role:admin|owner')
            ->group(function () {

                Route::controller(TambahPayrollController::class)
                    ->prefix('tambah')
                    ->name("tambah.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{tambah}', 'edit')->name('edit');
                        Route::get('delete/{tambah}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(KurangPayrollController::class)
                    ->prefix('kurang')
                    ->name("kurang.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{kurang}', 'edit')->name('edit');
                        Route::get('delete/{kurang}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(GeneratePayrollController::class)
                    ->prefix('generate')
                    ->name("generate.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('slip/{dataPayroll}', 'slip')->name('slip')->withoutMiddleware(['auth']);
                        Route::post('store', 'store')->name('store');
                        Route::get('detail/{generate}', 'detail')->name('detail');
                        Route::get('regenerate/{generate}', 'regenerate')->name('regenerate');
                        Route::get('approved/{generate}/{payroll?}', 'approved')->name('approved');
                        Route::get('rejected/{generate}/{payroll?}', 'rejected')->name('rejected');
                        Route::get('delete/{generate}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                        Route::get('payroll-datatable/{generate}', 'payrollDatatable')->name('payrollDatatable');
                    });
            });
        
        Route::prefix('pengajuan')
            ->name("pengajuan.")
            ->middleware('role:opd|admin|owner')
            ->group(function () {

                Route::controller(DataPresensiController::class)
                    ->prefix('presensi')
                    ->name("presensi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('laporan-pegawai', 'laporan_pegawai')->name('laporan_pegawai');
                        Route::get('laporan-pegawai-download', 'laporan_pegawai_download')->name('laporan_pegawai_download');
                        Route::get('laporan-divisi', 'laporan_divisi')->name('laporan_divisi');
                        Route::get('laporan-divisi-download', 'laporan_divisi_download')->name('laporan_divisi_download');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
                
                Route::controller(CutiPengajuanController::class)
                    ->prefix('cuti')
                    ->name("cuti.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('reject/{cuti}', 'reject')->name('reject');
                        Route::get('approved/{cuti}', 'approved')->name('approved');
                        Route::post('update', 'update')->name('update');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(ShiftPengajuanController::class)
                    ->prefix('shift')
                    ->name("shift.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('reject/{shift}', 'reject')->name('reject');
                        Route::get('approved/{shift}', 'approved')->name('approved');
                        Route::post('update', 'update')->name('update');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(LemburPengajuanController::class)
                    ->prefix('lembur')
                    ->name("lembur.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('reject/{lembur}', 'reject')->name('reject');
                        Route::get('approved/{lembur}', 'approved')->name('approved');
                        Route::post('update', 'update')->name('update');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(ReimbursementPengajuanController::class)
                    ->prefix('reimbursement')
                    ->name("reimbursement.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('reject/{reimbursement}', 'reject')->name('reject');
                        Route::get('approved/{reimbursement}', 'approved')->name('approved');
                        Route::post('update', 'update')->name('update');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });
            });
        
        Route::prefix('manajemen-user')
            ->name("users.")
            ->middleware('role:admin|owner')
            ->group(function () {

                Route::controller(DireksiController::class)
                    ->prefix('direksi')
                    ->name("direksi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('delete/{direksi}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(HrdController::class)
                    ->prefix('hrd')
                    ->name("hrd.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('delete/{hrd}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(ManagerController::class)
                    ->prefix('kepala-divisi')
                    ->name("manager.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('delete/{manager}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });
            });


        Route::prefix('master')
            ->name("master.")
            ->middleware('role:admin|owner')
            ->group(function () {

                Route::prefix('payroll')
                    ->name("payroll.")
                    ->group(function () {

                        Route::controller(PenambahanPayrollController::class)
                            ->prefix('penambahan')
                            ->name("penambahan.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::get('add', 'add')->name('add');
                                Route::get('json', 'json')->name('json');
                                Route::post('store', 'store')->name('store');
                                Route::get('edit/{tambahan}', 'edit')->name('edit');
                                Route::get('delete/{tambahan}', 'delete')->name('delete');
                                Route::get('datatable', 'datatable')->name('datatable');

                            });

                        Route::controller(PenguranganPayrollController::class)
                            ->prefix('pengurangan')
                            ->name("pengurangan.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::get('add', 'add')->name('add');
                                Route::get('json', 'json')->name('json');
                                Route::post('store', 'store')->name('store');
                                Route::get('edit/{pengurangan}', 'edit')->name('edit');
                                Route::get('delete/{pengurangan}', 'delete')->name('delete');
                                Route::get('datatable', 'datatable')->name('datatable');

                            });

                        Route::controller(PayrollTunjanganContoller::class)
                            ->prefix('tunjangan')
                            ->name("tunjangan.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::get('add', 'add')->name('add');
                                Route::get('json', 'json')->name('json');
                                Route::get('jsonAll', 'jsonAll')->name('jsonAll');
                                Route::post('store', 'store')->name('store');
                                Route::get('edit/{tunjangan}', 'edit')->name('edit');
                                Route::get('delete/{tunjangan}', 'delete')->name('delete');
                                Route::get('datatable', 'datatable')->name('datatable');
                            });

                        Route::controller(PayrollPotonganController::class)
                            ->prefix('potongan')
                            ->name("potongan.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::get('add', 'add')->name('add');
                                Route::get('json', 'json')->name('json');
                                Route::post('store', 'store')->name('store');
                                Route::get('edit/{potongan}', 'edit')->name('edit');
                                Route::get('delete/{potongan}', 'delete')->name('delete');
                            });

                        Route::controller(PayrollLemburController::class)
                            ->prefix('lembur')
                            ->name("lembur.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::post('update', 'update')->name('update');
                                Route::get('edit/{lembur}', 'edit')->name('edit');
                                Route::get('datatable', 'datatable')->name('datatable');

                            });
                        Route::controller(PayrollAbsensiController::class)
                            ->prefix('absensi')
                            ->name("absensi.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::post('update', 'update')->name('update');
                                Route::get('edit/{absensi}', 'edit')->name('edit');
                                Route::get('datatable', 'datatable')->name('datatable');

                            });
                        Route::controller(UmkController::class)
                            ->prefix('umk')
                            ->name("umk.")
                            ->group(function () {
                                Route::get('', 'index')->name('index');
                                Route::get('add', 'add')->name('add');
                                Route::get('edit/{umk}', 'edit')->name('edit');
                                Route::post('store', 'store')->name('store');
                                Route::post('update', 'update')->name('update');
                                Route::get('datatable', 'datatable')->name('datatable');
                                Route::get('delete/{umk}', 'delete')->name('delete');
                                Route::get('json', 'json')->name('json');
                            });
                    });

                Route::controller(SkpdController::class)
                    ->prefix('skpd')
                    ->name("skpd.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::get('bawahan', 'bawahan')->name('bawahan');
                        Route::post('store', 'store')->name('store');
                        Route::post('reset/{skpd}', 'reset')->name('reset');
                        Route::get('edit/{skpd}', 'edit')->name('edit');
                        Route::get('delete/{skpd}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(EselonController::class)
                    ->prefix('level')
                    ->name("eselon.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::post('reset/{eselon}', 'reset')->name('reset');
                        Route::get('edit/{eselon}', 'edit')->name('edit');
                        Route::get('delete/{eselon}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(JabatanController::class)
                    ->prefix('jabatan')
                    ->name("jabatan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('atasan/{skpd}', 'atasan')->name('atasan');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{jabatan}', 'edit')->name('edit');
                        Route::get('delete/{jabatan}', 'delete')->name('delete');
                    });

                Route::controller(GolonganController::class)
                    ->prefix('golongan')
                    ->name("golongan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{golongan}', 'edit')->name('edit');
                        Route::get('delete/{golongan}', 'delete')->name('delete');
                    });

                Route::controller(JenisKpController::class)
                    ->prefix('jeniskp')
                    ->name("jeniskp.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{jeniskp}', 'edit')->name('edit');
                        Route::get('delete/{jeniskp}', 'delete')->name('delete');
                    });

                Route::controller(SukuController::class)
                    ->prefix('suku')
                    ->name("suku.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{suku}', 'edit')->name('edit');
                        Route::get('delete/{suku}', 'delete')->name('delete');
                    });

                Route::controller(ShiftController::class)
                    ->prefix('shift')
                    ->name("shift.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::get('json_all', 'json_all')->name('json_all');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{shift}', 'edit')->name('edit');
                        Route::get('delete/{shift}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(LokasiController::class)
                    ->prefix('lokasi')
                    ->name("lokasi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{lokasi}', 'edit')->name('edit');
                        Route::get('delete/{lokasi}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(StatusPegawaiController::class)
                    ->prefix('status-pegawai')
                    ->name("status_pegawai.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::get('datatable', 'datatable')->name('datatable');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{status_pegawai}', 'edit')->name('edit');
                        Route::get('delete/{status_pegawai}', 'delete')->name('delete');
                    });

                Route::controller(PendidikanController::class)
                    ->prefix('pendidikan')
                    ->name("pendidikan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{pendidikan}', 'edit')->name('edit');
                        Route::get('delete/{pendidikan}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(JurusanController::class)
                    ->prefix('jurusan')
                    ->name("jurusan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json/{pendidikan?}', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{jurusan}', 'edit')->name('edit');
                        Route::get('delete/{jurusan}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(BidangController::class)
                    ->prefix('bidang')
                    ->name("bidang.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json/{skpd?}', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{bidang}', 'edit')->name('edit');
                        Route::get('delete/{bidang}', 'delete')->name('delete');
                    });

                Route::controller(SeksiController::class)
                    ->prefix('seksi')
                    ->name("seksi.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json/{bidang?}', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{seksi}', 'edit')->name('edit');
                        Route::get('delete/{seksi}', 'delete')->name('delete');
                    });

                Route::controller(DiklatStrukturalController::class)
                    ->prefix('diklatStruktural')
                    ->name("diklatStruktural.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{diklatStruktural}', 'edit')->name('edit');
                        Route::get('delete/{diklatStruktural}', 'delete')->name('delete');
                    });

                Route::controller(KursusController::class)
                    ->prefix('kursus')
                    ->name("kursus.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{kursus}', 'edit')->name('edit');
                        Route::get('delete/{kursus}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(PenghargaanController::class)
                    ->prefix('penghargaan')
                    ->name("penghargaan.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{penghargaan}', 'edit')->name('edit');
                        Route::get('delete/{penghargaan}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(CutiController::class)
                    ->prefix('cuti')
                    ->name("cuti.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{cuti}', 'edit')->name('edit');
                        Route::get('delete/{cuti}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(HariLiburController::class)
                    ->prefix('hariLibur')
                    ->name("hariLibur.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{hariLibur}', 'edit')->name('edit');
                        Route::get('delete/{hariLibur}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });

                Route::controller(VisitController::class)
                    ->prefix('visit')
                    ->name("visit.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{visit}', 'edit')->name('edit');
                        Route::get('delete/{visit}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                    });


                Route::controller(LainnyaController::class)
                    ->prefix('lainnya')
                    ->name("lainnya.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{lainnya}', 'edit')->name('edit');
                        Route::get('delete/{lainnya}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });

                Route::controller(TingkatController::class)
                    ->prefix('tingkat')
                    ->name("tingkat.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('org', 'org')->name('org');
                        Route::get('json/{skpd?}', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{tingkat}', 'edit')->name('edit');
                        Route::get('delete/{tingkat}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');
                        Route::post('check-kode-tingkat', 'checkKodeTingkat')->name('checkKodeTingkat');
                    });

                Route::controller(ReimbursementController::class)
                    ->prefix('reimbursement')
                    ->name("reimbursement.")
                    ->group(function () {
                        Route::get('', 'index')->name('index');
                        Route::get('add', 'add')->name('add');
                        Route::get('json', 'json')->name('json');
                        Route::post('store', 'store')->name('store');
                        Route::get('edit/{reimbursement}', 'edit')->name('edit');
                        Route::get('delete/{reimbursement}', 'delete')->name('delete');
                        Route::get('datatable', 'datatable')->name('datatable');

                    });
            });
    });

require __DIR__ . '/auth.php';
