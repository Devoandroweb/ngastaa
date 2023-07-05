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
                "payrollGenerate","payrollPenambahan","payrollPengurangan","absensiHarian","absensiRekap","absensiTotal","dataPengajuanIzin","dataPengajuanLembur","dataPengajuanReimbursement","dataPengajuanShift","laporanPresensi","laporanDivisi","laporanVisit","laporanAktifitas","infoPengumuman",
            ];
        foreach ($data as $value) {
            $$value = true;
        }
    }
    if(role('finance')){
        $data = ["payrollGenerate","payrollPenambahan","payrollPengurangan","dataPengajuanReimbursement"];
        foreach ($data as $value) {
            $$value = true;
        }
    }
    $roleLevel2 = role('level_2'); // HR
    $roleLevel3 = role('level_3'); // BUK
    $roleLevel4 = role('level_4'); // PIC
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
    // dd($roleLevel4);
    if($roleLevel4){
        $data = ["pegawai","dataPengajuanIzin","dataPengajuanReimbursement"];
        foreach ($data as $value) {
            $$value = true;
        }
    }
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
