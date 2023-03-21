<?php

use App\Models\Logs;
use App\Models\Master\Skpd;
use App\Models\Payroll\DaftarKurangPayroll;
use App\Models\Payroll\DaftarTambahPayroll;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\Pegawai\RiwayatTunjangan;

function get_masa_kerja($tanggal)
{
    $date = new DateTime($tanggal);
    $now = new DateTime(date('Y-m-d'));
    $interval = $now->diff($date);
    return "$interval->y Tahun $interval->m Bulan";
}

function tambah_log($target_nip, $model_type, $model_id, $action)
{

    $data = [
        'user_nip' => auth()->user()->nip,
        'target_nip' => $target_nip,
        'model_type' => $model_type,
        'model_id' => $model_id,
        'action' => $action,
    ];

    Logs::create($data);
}

function get_gapok($nip)
{
    return RiwayatKgb::where('nip', $nip)->where('is_akhir', 1)->value('gaji_pokok');
}

function get_tunjangan($nip)
{
    return RiwayatTunjangan::with('tunjangan')
                    ->where('nip', $nip)
                    ->where('is_aktif', 1)
                    ->select('nilai', 'kode_tunjangan')
                    ->get();
}

function get_potongan($nip)
{
    return RiwayatPotongan::with('potongan')
                    ->where('nip', $nip)
                    ->where('is_aktif', 1)
                    ->select('kode_kurang')
                    ->get();
}


function get_lembur($nip, $bulan, $tahun)
{
    return DataPengajuanLembur::where('nip', $nip)
                    ->where('status', 1)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();
}


function get_tunjangan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarTambahPayroll::with('tambah')->where('bulan', $bulan)->where('tahun', $tahun);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_tunjangan_selamanya($nip, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarTambahPayroll::with('tambah')->where('is_periode', 0);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_potongan_person($nip, $bulan, $tahun, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarKurangPayroll::with('kurang')->where('bulan', $bulan)->where('tahun', $tahun);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_potongan_selamanya($nip, $kode_tingkat, $kode_level, $kode_skpd)
{
    $qry = DaftarKurangPayroll::with('kurang')->where('is_periode', 0);
    // Semua Pegawai
    $semua = with(clone $qry)->where('keterangan', 'semua');
    // Pegawai Tertentu
    $pegawai = with(clone $qry)->where('keterangan', 1)->where('kode_keterangan', 'LIKE', "%$nip%");
    // Tingkat Tertentu
    $tingkat = with(clone $qry)->where('keterangan', 2)->where('kode_keterangan', $kode_tingkat);
    // Level Tertentu
    $level = with(clone $qry)->where('keterangan', 3)->where('kode_keterangan', $kode_level);
    // Divisi Tertentu
    $skpd = with(clone $qry)->where('keterangan', 4)->where('kode_keterangan', $kode_skpd)
                ->union($semua)
                ->union($pegawai)
                ->union($tingkat)
                ->union($level)
                ->get();
    

    return $skpd;
}

function get_skpd($kode_skpd)
{
    return Skpd::where('kode_skpd', $kode_skpd)->value('nama');
}