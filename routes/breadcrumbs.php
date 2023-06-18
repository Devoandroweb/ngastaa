<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Profil Pegawai
Breadcrumbs::for('profile-pegawai', function (BreadcrumbTrail $trail) {
    $trail->push('Data Pegawai', route('pegawai.pegawai.index'));
});

Breadcrumbs::for('detail-pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('profile-pegawai');
    $trail->push('Index', route('pegawai.pegawai.index'));
});
Breadcrumbs::for('tambah-pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('profile-pegawai');
    $trail->push('Tambah Pegawai', route('pegawai.pegawai.add'));
});
Breadcrumbs::for('edit-pegawai', function (BreadcrumbTrail $trail,$nip) {
    $trail->parent('profile-pegawai');
    $trail->push('Edit Pegawai', route('pegawai.pegawai.edit',$nip));
});

Breadcrumbs::for('import-pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('profile-pegawai');
    $trail->push('Import Pegawai', route('pegawai.pegawai.index'));
});

Breadcrumbs::for('tambah-shift-pegawai', function (BreadcrumbTrail $trail,$pegawai) {
    $trail->parent('profile-pegawai');
    $trail->push('Tambah Shift Pegawai', route('pegawai.pegawai.shift',$pegawai));
});

// Master | Data Jabatan
Breadcrumbs::for('status-pegawai', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Status Pegawai', route('master.status_pegawai.index'));
});
Breadcrumbs::for('tambah-status-pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('status-pegawai');
    $trail->push('Tambah Status Pegawai');
});
Breadcrumbs::for('edit-status-pegawai', function (BreadcrumbTrail $trail) {
    $trail->parent('status-pegawai');
    $trail->push('Edit Status Pegawai');
});

// Master | Divisi Kerja
Breadcrumbs::for('divisi-kerja', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Divisi Kerja', route('master.skpd.index'));
});
Breadcrumbs::for('tambah-divisi-kerja', function (BreadcrumbTrail $trail) {
    $trail->parent('divisi-kerja');
    $trail->push('Tambah Divisi Kerja');
});
Breadcrumbs::for('edit-divisi-kerja', function (BreadcrumbTrail $trail) {
    $trail->parent('divisi-kerja');
    $trail->push('Edit Divisi Kerja');
});

// Master | Tingkat Jabatan
Breadcrumbs::for('tingkat-jabatan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Tingkat Jabatan', route('master.tingkat.index'));
});
Breadcrumbs::for('tambah-tingkat-jabatan', function (BreadcrumbTrail $trail) {
    $trail->parent('tingkat-jabatan');
    $trail->push('Tambah Tingkat Jabatan');
});
Breadcrumbs::for('edit-tingkat-jabatan', function (BreadcrumbTrail $trail) {
    $trail->parent('tingkat-jabatan');
    $trail->push('Edit Tingkat Jabatan');
});

// Master | Level Jabatan
Breadcrumbs::for('level-jabatan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Level Jabatan', route('master.eselon.index'));
});
Breadcrumbs::for('tambah-level-jabatan', function (BreadcrumbTrail $trail) {
    $trail->parent('level-jabatan');
    $trail->push('Tambah Level Jabatan');
});
Breadcrumbs::for('edit-level-jabatan', function (BreadcrumbTrail $trail) {
    $trail->parent('level-jabatan');
    $trail->push('Edit Level Jabatan');
});

// Master | Pendidikan
Breadcrumbs::for('tingkat-pendidikan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Tingkat Pendidikan', route('master.pendidikan.index'));
});
Breadcrumbs::for('tambah-tingkat-pendidikan', function (BreadcrumbTrail $trail) {
    $trail->parent('tingkat-pendidikan');
    $trail->push('Tambah Tingkat Pendidikan');
});
Breadcrumbs::for('edit-tingkat-pendidikan', function (BreadcrumbTrail $trail) {
    $trail->parent('tingkat-pendidikan');
    $trail->push('Edit Tingkat Pendidikan');
});

// Master | Jurusan
Breadcrumbs::for('jurusan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Jurusan', route('master.jurusan.index'));
});
Breadcrumbs::for('tambah-jurusan', function (BreadcrumbTrail $trail) {
    $trail->parent('jurusan');
    $trail->push('Tambah Jurusan');
});
Breadcrumbs::for('edit-jurusan', function (BreadcrumbTrail $trail) {
    $trail->parent('jurusan');
    $trail->push('Edit Jurusan');
});

// Master | Kursus
Breadcrumbs::for('kursus', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Kursus', route('master.kursus.index'));
});
Breadcrumbs::for('tambah-kursus', function (BreadcrumbTrail $trail) {
    $trail->parent('kursus');
    $trail->push('Tambah Kursus');
});
Breadcrumbs::for('edit-kursus', function (BreadcrumbTrail $trail) {
    $trail->parent('kursus');
    $trail->push('Edit Kursus');
});

// Master | Hari Libur
Breadcrumbs::for('hari-libur', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Hari Libur', route('master.hariLibur.index'));
});
Breadcrumbs::for('tambah-hari-libur', function (BreadcrumbTrail $trail) {
    $trail->parent('hari-libur');
    $trail->push('Tambah Hari Libur');
});
Breadcrumbs::for('edit-hari-libur', function (BreadcrumbTrail $trail) {
    $trail->parent('hari-libur');
    $trail->push('Edit Hari Libur');
});

// Master | Izin
Breadcrumbs::for('cuti', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Izin', route('master.cuti.index'));
});
Breadcrumbs::for('tambah-cuti', function (BreadcrumbTrail $trail) {
    $trail->parent('cuti');
    $trail->push('Tambah Izin');
});
Breadcrumbs::for('edit-cuti', function (BreadcrumbTrail $trail) {
    $trail->parent('cuti');
    $trail->push('Edit Izin');
});

// Master | Shift
Breadcrumbs::for('shift', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Shift', route('master.shift.index'));
});
Breadcrumbs::for('tambah-shift', function (BreadcrumbTrail $trail) {
    $trail->parent('shift');
    $trail->push('Tambah Shift');
});
Breadcrumbs::for('edit-shift', function (BreadcrumbTrail $trail) {
    $trail->parent('shift');
    $trail->push('Edit Shift');
});

// Master | Lokasi Kerja
Breadcrumbs::for('lokasi-kerja', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Lokasi Kerja', route('master.lokasi.index'));
});
Breadcrumbs::for('tambah-lokasi-kerja', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi-kerja');
    $trail->push('Tambah Lokasi Kerja');
});
Breadcrumbs::for('edit-lokasi-kerja', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi-kerja');
    $trail->push('Edit Lokasi Kerja');
});

// Master | Lokasi Visit
Breadcrumbs::for('lokasi-visit', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Lokasi Visit', route('master.visit.index'));
});
Breadcrumbs::for('tambah-lokasi-visit', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi-visit');
    $trail->push('Tambah Lokasi Visit');
});
Breadcrumbs::for('edit-lokasi-visit', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi-visit');
    $trail->push('Edit Lokasi Visit');
});

// Master | Tunjangan
Breadcrumbs::for('tunjangan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Tunjangan', route('master.payroll.tunjangan.index'));
});
Breadcrumbs::for('tambah-tunjangan', function (BreadcrumbTrail $trail) {
    $trail->parent('tunjangan');
    $trail->push('Tambah Tunjangan');
});
Breadcrumbs::for('edit-tunjangan', function (BreadcrumbTrail $trail) {
    $trail->parent('tunjangan');
    $trail->push('Edit Tunjangan');
});

// Master | Tunjangan
Breadcrumbs::for('lembur', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Lembur', route('master.payroll.lembur.index'));
});
Breadcrumbs::for('edit-lembur', function (BreadcrumbTrail $trail) {
    $trail->parent('lembur');
    $trail->push('Edit Lembur');
});

// Master / Umk
Breadcrumbs::for('gaji-umk', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Gaji Umk', route('master.payroll.umk.index'));
});
Breadcrumbs::for('tambah-umk', function (BreadcrumbTrail $trail) {
    $trail->parent('gaji-umk');
    $trail->push('Tambah Gaji Umk');
});
Breadcrumbs::for('edit-umk', function (BreadcrumbTrail $trail) {
    $trail->parent('gaji-umk');
    $trail->push('Edit Gaji Umk');
});

// Master | Tunjangan
Breadcrumbs::for('absensi', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Potongan Telat dan Cepat Pulang', route('master.payroll.absensi.index'));
});
Breadcrumbs::for('edit-absensi', function (BreadcrumbTrail $trail) {
    $trail->parent('absensi');
    $trail->push('Edit Potongan Telat dan Cepat Pulang');
});

// Master | Komponen Penambahan
Breadcrumbs::for('penambahan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Komponen Bonus Payroll', route('master.payroll.penambahan.index'));
});
Breadcrumbs::for('tambah-penambahan', function (BreadcrumbTrail $trail) {
    $trail->parent('penambahan');
    $trail->push('Tambah Komponen Bonus Payroll');
});
Breadcrumbs::for('edit-penambahan', function (BreadcrumbTrail $trail) {
    $trail->parent('penambahan');
    $trail->push('Edit Komponen Bonus Payroll');
});

// Master | Komponen Potongan
Breadcrumbs::for('pengurangan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Komponen Potongan Payroll', route('master.payroll.pengurangan.index'));
});
Breadcrumbs::for('tambah-pengurangan', function (BreadcrumbTrail $trail) {
    $trail->parent('pengurangan');
    $trail->push('Tambah Komponen Potongan Payroll');
});
Breadcrumbs::for('edit-pengurangan', function (BreadcrumbTrail $trail) {
    $trail->parent('pengurangan');
    $trail->push('Edit Komponen Potongan Payroll');
});

// Master | Penghargaan
Breadcrumbs::for('penghargaan', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Penghargaan', route('master.penghargaan.index'));
});
Breadcrumbs::for('tambah-penghargaan', function (BreadcrumbTrail $trail) {
    $trail->parent('penghargaan');
    $trail->push('Tambah Penghargaan');
});
Breadcrumbs::for('edit-penghargaan', function (BreadcrumbTrail $trail) {
    $trail->parent('penghargaan');
    $trail->push('Edit Penghargaan');
});

// Master | Lainnya
Breadcrumbs::for('lainnya', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Riwayat Lainnya', route('master.lainnya.index'));
});
Breadcrumbs::for('tambah-lainnya', function (BreadcrumbTrail $trail) {
    $trail->parent('lainnya');
    $trail->push('Tambah Riwayat Lainnya');
});
Breadcrumbs::for('edit-lainnya', function (BreadcrumbTrail $trail) {
    $trail->parent('lainnya');
    $trail->push('Edit Riwayat Lainnya');
});

// Master | Reimbursement
Breadcrumbs::for('reimbursement', function (BreadcrumbTrail $trail) {
    $trail->push('Master', "#");
    $trail->push('Reimbursement', route('master.reimbursement.index'));
});
Breadcrumbs::for('tambah-reimbursement', function (BreadcrumbTrail $trail) {
    $trail->parent('reimbursement');
    $trail->push('Tambah Reimbursement');
});
Breadcrumbs::for('edit-reimbursement', function (BreadcrumbTrail $trail) {
    $trail->parent('reimbursement');
    $trail->push('Edit Reimbursement');
});

// Payroll | Generate
Breadcrumbs::for('generate-payroll', function (BreadcrumbTrail $trail) {
    $trail->push('Payroll', "#");
    $trail->push('Generate Payroll', route('payroll.generate.index'));
});
Breadcrumbs::for('tambah-generate-payroll', function (BreadcrumbTrail $trail) {
    $trail->parent('generate-payroll');
    $trail->push('Tambah Generate Payroll');
});
Breadcrumbs::for('detail-generate-payroll', function (BreadcrumbTrail $trail) {
    $trail->parent('generate-payroll');
    $trail->push('Detail Generate Payroll');
});

// Payroll | Daftar Penambahan
Breadcrumbs::for('daftar-penambahan', function (BreadcrumbTrail $trail) {
    $trail->push('Payroll', "#");
    $trail->push('Daftar Penambahan', route('payroll.tambah.index'));
});
Breadcrumbs::for('tambah-daftar-penambahan', function (BreadcrumbTrail $trail) {
    $trail->parent('daftar-penambahan');
    $trail->push('Tambah Daftar Penambahan');
});
Breadcrumbs::for('edit-daftar-penambahan', function (BreadcrumbTrail $trail) {
    $trail->parent('daftar-penambahan');
    $trail->push('Edit Daftar Penambahan');
});

// Payroll | Daftar Potongan
Breadcrumbs::for('daftar-pengurangan', function (BreadcrumbTrail $trail) {
    $trail->push('Payroll', "#");
    $trail->push('Daftar Potongan', route('payroll.tambah.index'));

});
Breadcrumbs::for('tambah-daftar-pengurangan', function (BreadcrumbTrail $trail) {
    $trail->parent('daftar-pengurangan');
    $trail->push('Tambah Daftar Potongan');
});
Breadcrumbs::for('edit-daftar-pengurangan', function (BreadcrumbTrail $trail) {
    $trail->parent('daftar-pengurangan');
    $trail->push('Edit Daftar Potongan');
});

// Pengajuan | Presensi
Breadcrumbs::for('presensi-harian', function (BreadcrumbTrail $trail) {
    $trail->push('Presensi', "#");
    $trail->push('Presensi Harian', route('pengajuan.presensi.index'));
});

// Pengajuan | Izin
Breadcrumbs::for('pengajuan-cuti', function (BreadcrumbTrail $trail) {
    $trail->push('Pengajuan', "#");
    $trail->push('Pengajuan Izin', route('pengajuan.cuti.index'));
});
Breadcrumbs::for('pengajuan-approved-cuti', function (BreadcrumbTrail $trail) {
    $trail->parent('pengajuan-cuti');
    $trail->push('Persetujuan Pengajuan Izin', route('pengajuan.cuti.index'));
});

// Pengajuan | Cuti
Breadcrumbs::for('pengajuan-lembur', function (BreadcrumbTrail $trail) {
    $trail->push('Pengajuan', "#");
    $trail->push('Pengajuan Lembur', route('pengajuan.lembur.index'));
});
Breadcrumbs::for('pengajuan-approved-lembur', function (BreadcrumbTrail $trail) {
    $trail->parent('pengajuan-lembur');
    $trail->push('Persetujuan Pengajuan Lembur', route('pengajuan.lembur.index'));
});

// Pengajuan | Reimbursement
Breadcrumbs::for('pengajuan-reimbursement', function (BreadcrumbTrail $trail) {
    $trail->push('Pengajuan', "#");
    $trail->push('Pengajuan Reimbursement', route('pengajuan.reimbursement.index'));
});
Breadcrumbs::for('pengajuan-approved-reimbursement', function (BreadcrumbTrail $trail) {
    $trail->parent('pengajuan-reimbursement');
    $trail->push('Persetujuan Pengajuan Reimbursement', route('pengajuan.reimbursement.index'));
});
// Pengajuan | Shift
Breadcrumbs::for('pengajuan-shift', function (BreadcrumbTrail $trail) {
    $trail->push('Pengajuan', "#");
    $trail->push('Pengajuan Shift', route('pengajuan.shift.index'));
});
Breadcrumbs::for('pengajuan-approved-shift', function (BreadcrumbTrail $trail) {
    $trail->parent('pengajuan-shift');
    $trail->push('Persetujuan Pengajuan Shift', route('pengajuan.shift.index'));
});

// Pengajuan | Laporan Pegawai
Breadcrumbs::for('laporan-pegawai', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan', "#");
    $trail->push('Laporan Pegawai', route('pengajuan.presensi.laporan_pegawai'));
});

// Pengajuan | Laporan Divisi
Breadcrumbs::for('laporan-divisi', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan', "#");
    $trail->push('Laporan Divisi', route('pengajuan.presensi.laporan_divisi'));
});

// Pengajuan | Laporan Visit
Breadcrumbs::for('laporan-visit', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan', "#");
    $trail->push('Laporan Visit', route('presensi.laporan_visit.index'));
});

// Pengajuan | Laporan Aktifitas
Breadcrumbs::for('laporan-aktifitas', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan', "#");
    $trail->push('Laporan Aktifitas', route('presensi.aktifitas.index'));
});

// Presensi | Rekap Harian
Breadcrumbs::for('presensi-rekap-harian', function (BreadcrumbTrail $trail) {
    $trail->push('Presensi', "#");
    $trail->push('Presensi Rekap Harian', route('presensi.rekapabsen.index'));
});
// Presensi | Total Presensi
Breadcrumbs::for('presensi-total-presensi', function (BreadcrumbTrail $trail) {
    $trail->push('Presensi', "#");
    $trail->push('Total Presensi', route('presensi.total_presensi.index'));
});
// Presensi | Total Presensi Detail
Breadcrumbs::for('presensi-total-presensi-detail', function (BreadcrumbTrail $trail) {
    $trail->parent('presensi-total-presensi');
    $trail->push('Detail Presensi');
});

// Pengumuman
Breadcrumbs::for('pengumuman', function (BreadcrumbTrail $trail) {
    $trail->push('Payroll', "#");
    $trail->push('Daftar Pengumuman', route('pengumuman.index'));

});
Breadcrumbs::for('tambah-pengumuman', function (BreadcrumbTrail $trail) {
    $trail->parent('pengumuman');
    $trail->push('Tambah Daftar Pengumuman');
});
Breadcrumbs::for('edit-pengumuman', function (BreadcrumbTrail $trail) {
    $trail->parent('pengumuman');
    $trail->push('Edit Daftar Pengumuman');
});

// Management User | HRD/BUK
Breadcrumbs::for('management-user-hrd', function (BreadcrumbTrail $trail) {
    $trail->push('User', "#");
    $trail->push('Management User BUK', route('users.hrd.index'));

});
Breadcrumbs::for('tambah-management-user-hrd', function (BreadcrumbTrail $trail) {
    $trail->parent('management-user-hrd');
    $trail->push('Tambah Management User BUK');
});

// Management User | Divisi
Breadcrumbs::for('management-user-divisi', function (BreadcrumbTrail $trail) {
    $trail->push('User', "#");
    $trail->push('Management User Kepala Divisi', route('users.manager.index'));

});
Breadcrumbs::for('tambah-management-user-divisi', function (BreadcrumbTrail $trail) {
    $trail->parent('management-user-divisi');
    $trail->push('Tambah Management User Kepala Divisi');
});
// Management User | Direksi
Breadcrumbs::for('management-user-direksi', function (BreadcrumbTrail $trail) {
    $trail->push('User', "#");
    $trail->push('Management User', route('users.manager.index'));

});
Breadcrumbs::for('tambah-management-user-direksi', function (BreadcrumbTrail $trail) {
    $trail->parent('management-user-direksi');
    $trail->push('Tambah Management User');
});
// Management User | Finance
Breadcrumbs::for('management-user-finance', function (BreadcrumbTrail $trail) {
    $trail->push('User', "#");
    $trail->push('Management User Finance', route('users.finance.index'));

});
Breadcrumbs::for('tambah-management-user-finance', function (BreadcrumbTrail $trail) {
    $trail->parent('management-user-finance');
    $trail->push('Tambah Management User Finance');
});

// Profile Perusahaan
Breadcrumbs::for('profile-perusahaan', function (BreadcrumbTrail $trail) {
    $trail->push('Perusahaan', "#");
    $trail->push('Profile Perusahaan', route('perusahaan.index'));
});

Breadcrumbs::for('ubah-password-update', function (BreadcrumbTrail $trail) {
    $trail->push('Ubah Password');
});
