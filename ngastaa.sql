-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Waktu pembuatan: 17 Apr 2023 pada 06.24
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngastaa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aktifitas`
--

CREATE TABLE `aktifitas` (
  `id` int(11) NOT NULL,
  `nip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` text NOT NULL,
  `koordinat` text NOT NULL,
  `foto` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aktifitas`
--

INSERT INTO `aktifitas` (`id`, `nip`, `nama`, `koordinat`, `foto`, `created_at`, `updated_at`) VALUES
(1, '28', 'Cek gudang belakang', '-7.006793068102385,110.41733718795163\n', 'aktifitas/28/1679856335_image.png', '2023-04-15 09:58:32', '2023-04-15 04:57:08'),
(5, '28', 'cek gudang 2', '-7.006793068102385,110.41733718795163', 'aktifitas/28/1681537352_ss.jpg', '2023-04-15 12:42:32', '2023-04-15 12:42:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_status_function`
--

CREATE TABLE `app_status_function` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `value` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `app_status_function`
--

INSERT INTO `app_status_function` (`id`, `name`, `value`) VALUES
(1, 'calculate_presensi', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuti`
--

CREATE TABLE `cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_cuti` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cuti`
--

INSERT INTO `cuti` (`id`, `kode_cuti`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '1', 'Sakit', '2023-02-26 06:53:47', '2023-04-03 14:27:16', '2023-04-03 14:27:16'),
(4, 'M', 'CAP (Cuti Menikah)', '2023-04-03 14:27:32', '2023-04-03 14:27:32', NULL),
(5, 'I', 'Izin', '2023-04-03 14:27:44', '2023-04-03 14:27:44', NULL),
(6, 'S', 'Sakit', '2023-04-03 14:28:01', '2023-04-03 14:28:01', NULL),
(7, 'C', 'Cuti Tahunan', '2023-04-03 14:28:08', '2023-04-03 14:28:08', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_kurang_payroll`
--

CREATE TABLE `daftar_kurang_payroll` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kurang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_periode` tinyint(4) DEFAULT 0 COMMENT '0 berarti selamanya',
  `bulan` tinyint(4) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0 Semua Pegawai, 1 Pegawai Terpilih, 2 Jabatan Terpilih, 3 Level Jabatan, 4 Divisi Kerja',
  `kode_keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `daftar_kurang_payroll`
--

INSERT INTO `daftar_kurang_payroll` (`id`, `kode_kurang`, `is_periode`, `bulan`, `tahun`, `keterangan`, `kode_keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123', 1, 3, 2019, 'semua', '', '2022-07-12 23:40:07', '2022-07-12 23:40:07', NULL),
(2, '13', 0, NULL, NULL, 'semua', '', '2022-07-17 00:19:15', '2022-07-17 00:19:15', NULL),
(3, '3', 0, NULL, NULL, 'semua', '', '2022-08-31 16:15:06', '2022-08-31 16:15:06', NULL),
(4, '123', 1, 1, 2023, '1', '111111,66', '2023-02-22 03:35:07', '2023-02-22 03:35:07', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_tambah_payroll`
--

CREATE TABLE `daftar_tambah_payroll` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_tambah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_periode` tinyint(4) DEFAULT 0 COMMENT '0 berarti selamanya',
  `bulan` tinyint(4) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0 Semua Pegawai, 1 Pegawai Terpilih, 2 Jabatan Terpilih, 3 Level Jabatan, 4 Divisi Kerja',
  `kode_keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `daftar_tambah_payroll`
--

INSERT INTO `daftar_tambah_payroll` (`id`, `kode_tambah`, `is_periode`, `bulan`, `tahun`, `keterangan`, `kode_keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123', 1, 1, 2023, '1', '28,66', '2022-07-12 14:02:19', '2023-02-22 04:30:31', NULL),
(2, '123', 1, 1, 2022, 'semua', '', '2022-07-14 10:07:08', '2022-07-14 10:07:08', NULL),
(3, '123', 1, 1, 2022, '4', '102242', '2022-07-14 10:07:48', '2022-07-14 10:07:48', NULL),
(4, '13', 0, NULL, NULL, 'semua', '', '2022-07-17 00:17:20', '2022-07-17 00:17:20', NULL),
(5, '123', 0, NULL, NULL, '0', NULL, '2023-02-17 18:47:33', '2023-02-26 16:17:36', '2023-02-26 16:17:36'),
(6, '123', 1, 1, 2023, '4', '1', '2023-02-22 03:17:57', '2023-02-22 03:17:57', NULL),
(7, '123', 1, 1, 2023, '2', '1', '2023-02-22 03:18:21', '2023-02-22 03:18:21', NULL),
(8, '13', 0, NULL, NULL, '1', '10', '2023-02-22 03:19:56', '2023-02-22 03:19:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_payroll`
--

CREATE TABLE `data_payroll` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_payroll` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bulan` tinyint(4) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_tingkat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gaji_pokok` double DEFAULT 0,
  `tunjangan` double DEFAULT NULL,
  `total_penambahan` double DEFAULT NULL,
  `total_potongan` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `is_aktif` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_payroll`
--

INSERT INTO `data_payroll` (`id`, `kode_payroll`, `bulan`, `tahun`, `nip`, `kode_tingkat`, `jabatan`, `divisi`, `gaji_pokok`, `tunjangan`, `total_penambahan`, `total_potongan`, `total`, `is_aktif`, `created_at`, `updated_at`) VALUES
(36, '20220717072145zEwdw8U01t', 7, 2022, '28', '1022420200', 'Sekretaris Dinas Komunikasi & Informatika', 'Dinas Komunikasi & Informatika', 10000000, 1250000, 11700000, 265000, 21435000, 1, '2022-07-17 00:21:45', '2023-02-21 04:56:33'),
(37, '20220717072145zEwdw8U01t', 7, 2022, '66', '102104', 'Kepala BKD', 'Kepegawaian Daerah', 1230000, 1250000, 4160000, 887574.94736842, 4502425.0526316, 1, '2022-07-17 00:21:45', '2023-02-21 04:58:04'),
(38, '20220825213005eg4Ab3qwlt', 8, 2022, '28', '1022420200', 'Sekretaris Dinas Komunikasi & Informatika', 'Dinas Komunikasi & Informatika', 10000000, 1250000, 1700000, 265000, 11435000, 0, '2022-08-25 14:30:05', '2022-08-25 14:30:05'),
(39, '20220825213005eg4Ab3qwlt', 8, 2022, '28', '1022420200', 'Sekretaris Dinas Komunikasi & Informatika', 'Dinas Komunikasi & Informatika', 10000000, 1250000, 1700000, 265000, 171435000, 0, '2022-09-25 14:30:05', '2022-08-25 14:30:05'),
(40, '20220825213005eg4Ab3qwlt', 8, 2022, '28', '1022420200', 'Sekretaris Dinas Komunikasi & Informatika', 'Dinas Komunikasi & Informatika', 10000000, 1250000, 1700000, 265000, 20000000, 0, '2022-06-25 14:30:05', '2022-08-25 14:30:05'),
(41, '202302221128231vIpCcviIi', 2, 2023, '66', '102104', 'Supervisor', 'Kepegawaian Daerah', 1230000, 0, 1680000, 39600, 2870400, 0, '2023-02-22 04:28:24', '2023-02-22 04:29:03'),
(42, '202302221128231vIpCcviIi', 2, 2023, '28', '1', 'Lead', 'Operasional', 2000000, 200000, 2650000, 55000, 4595000, 0, '2023-02-22 04:28:26', '2023-02-22 04:29:04'),
(43, '20230309054918LSbeljJrJ8', 3, 2023, '66', '102104', NULL, NULL, 1230000, 0, 1680000, 39600, 2870400, 0, '2023-03-08 22:49:18', '2023-03-08 22:49:41'),
(44, '20230309054918LSbeljJrJ8', 3, 2023, '28', '1', NULL, NULL, 2000000, 0, 450000, 55000, 2395000, 0, '2023-03-08 22:49:19', '2023-03-08 22:49:41'),
(45, '20230309054918LSbeljJrJ8', 3, 2023, '10', '102104', NULL, NULL, 0, 0, 900000, 15000, 885000, 0, '2023-03-08 22:49:19', '2023-03-08 22:49:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengajuan_cuti`
--

CREATE TABLE `data_pengajuan_cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_cuti` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `komentar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_pengajuan_cuti`
--

INSERT INTO `data_pengajuan_cuti` (`id`, `nip`, `kode_cuti`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`, `file`, `status`, `komentar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, '28', 'M', '2023-04-14', '2023-04-15', NULL, '', '1', NULL, NULL, '2023-04-14 00:32:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengajuan_lembur`
--

CREATE TABLE `data_pengajuan_lembur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_mulai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_selesai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `komentar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_pengajuan_lembur`
--

INSERT INTO `data_pengajuan_lembur` (`id`, `nip`, `tanggal`, `jam_mulai`, `jam_selesai`, `keterangan`, `file`, `nomor_surat`, `tanggal_surat`, `status`, `komentar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, '28', '1970-01-01', '28', '28', '28', 'lembur/28/1680496850_image.png', NULL, NULL, '2', 'tolak', '2023-04-03 04:40:50', '2023-04-03 06:54:11', NULL),
(10, '28', '1970-01-01', '28', '28', '28', 'lembur/28/1680505006_image.png', NULL, NULL, '0', NULL, '2023-04-03 06:56:46', '2023-04-03 06:56:46', NULL),
(11, '123', '2023-04-06', '08:00', '20:00', 'update', '123/123-lembur-2231.pdf', '22333', '2023-04-06', '0', NULL, '2023-04-05 07:55:12', '2023-04-05 07:58:06', '2023-04-05 07:58:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pengajuan_reimbursement`
--

CREATE TABLE `data_pengajuan_reimbursement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_reimbursement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` double NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `komentar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_pengajuan_reimbursement`
--

INSERT INTO `data_pengajuan_reimbursement` (`id`, `nip`, `kode_reimbursement`, `nilai`, `keterangan`, `file`, `nomor_surat`, `tanggal_surat`, `status`, `komentar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40, '28', '100', 5677, 'xjxjxjx', 'reimbursement/28/1680509764_image.png', NULL, NULL, '2', 'Tolak', '2023-04-03 08:16:04', '2023-04-03 08:39:05', NULL),
(41, '28', '102', 50000, 'kereta api', 'reimbursement/28/1680511198_image.png', NULL, NULL, '2', 'Tolak', '2023-04-03 08:39:58', '2023-04-03 08:40:49', NULL),
(42, '28', '100', 20000, 'telkomsel', 'reimbursement/28/1680511309_image.png', NULL, NULL, '2', 'Tolak', '2023-04-03 08:41:49', '2023-04-03 08:43:27', NULL),
(43, '123', '103', 1000000, 'update', '123/123-reimbursement-2311.pdf', '23122', '2023-01-04', '0', NULL, '2023-04-05 08:01:22', '2023-04-05 08:44:59', '2023-04-05 08:44:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_presensi`
--

CREATE TABLE `data_presensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periode_bulan` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_shift` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_tingkat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_datang` timestamp NULL DEFAULT NULL,
  `kordinat_datang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_datang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_istirahat` timestamp NULL DEFAULT NULL,
  `kordinat_istirahat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_istirahat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_pulang` timestamp NULL DEFAULT NULL,
  `kordinat_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_visit`
--

CREATE TABLE `data_visit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_visit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kordinat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_visit`
--

INSERT INTO `data_visit` (`id`, `nip`, `kode_visit`, `tanggal`, `kordinat`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '28', '4e4d902a-37a1-4005-839b-fce03784ef29', '2023-03-26 15:58:32', '-4.008623719794147, 119.62394763518633', '/visit/28/fida2.png', '2022-09-01 02:40:53', '2022-09-01 02:40:53', NULL),
(4, '28', '578b7d6c-4300-4fbc-8cd5-e5eba61046a6', '2023-03-26 15:58:35', '-4.008623719794147, 119.62394763518633', '/visit/28/fida3.png', '2022-09-01 03:04:09', '2022-09-01 03:04:09', NULL),
(5, '28', 'fauzan sans', '2023-04-02 18:04:41', '-7.9720515, 112.5995652', '', '2023-04-02 18:04:41', '2023-04-02 18:04:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `districts`
--

CREATE TABLE `districts` (
  `id` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regency_id` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `eselon`
--

CREATE TABLE `eselon` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_eselon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kordinat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak` int(11) NOT NULL DEFAULT 0,
  `polygon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `eselon`
--

INSERT INTO `eselon` (`id`, `kode_eselon`, `nama`, `kordinat`, `latitude`, `longitude`, `jarak`, `polygon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Level 1', '-7.006793068102385, 110.41733718795163', '-7.006793068102385', '110.41733718795163', 100, NULL, '2022-06-24 15:13:19', '2023-04-03 14:30:54', NULL),
(2, '2', 'Level 2', '-8.1277966,112.7509655', '-8.1277966', '112.7509655', 100, NULL, '2022-06-24 15:13:25', '2023-02-24 07:33:02', NULL),
(3, '3', 'Level 3', '-8.1093477,112.7086424', '-8.1093477', '112.7086424', 100, NULL, '2023-02-03 01:39:44', '2023-02-28 11:57:52', NULL),
(4, '4', 'Level 4', NULL, NULL, NULL, 100, NULL, '2023-02-28 11:58:08', '2023-02-28 11:58:08', NULL),
(5, '5', 'Level 5', NULL, NULL, NULL, 100, NULL, '2023-04-03 14:31:57', '2023-04-03 14:32:12', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `generate_payroll`
--

CREATE TABLE `generate_payroll` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_payroll` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_skpd` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'null berarti semua dinas',
  `bulan` tinyint(4) NOT NULL,
  `tahun` year(4) NOT NULL,
  `is_aktif` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `generate_payroll`
--

INSERT INTO `generate_payroll` (`id`, `kode_payroll`, `kode_skpd`, `bulan`, `tahun`, `is_aktif`, `created_at`, `updated_at`, `deleted_at`) VALUES
(25, '20220717072145zEwdw8U01t', NULL, 7, 2022, 1, '2022-07-17 00:21:45', '2023-02-21 04:58:04', NULL),
(26, '20220825213005eg4Ab3qwlt', '102242', 8, 2022, 0, '2022-08-25 14:30:05', '2022-08-25 14:30:05', NULL),
(27, '20230115020304ivEodnNkWH', '1', 1, 2023, 0, '2023-01-14 19:03:04', '2023-02-21 04:30:22', NULL),
(28, '202302221128231vIpCcviIi', NULL, 2, 2023, 0, '2023-02-22 04:28:23', '2023-02-22 04:29:03', NULL),
(29, '20230309054918LSbeljJrJ8', NULL, 3, 2023, 0, '2023-03-08 22:49:18', '2023-03-08 22:49:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `hari_libur`
--

INSERT INTO `hari_libur` (`id`, `tanggal_mulai`, `tanggal_selesai`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '2022-07-14', '2022-07-16', 'Hari Kebalikan', '2022-07-14 12:13:34', '2022-07-14 12:14:43', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `imei`
--

CREATE TABLE `imei` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `imei`
--

INSERT INTO `imei` (`id`, `nip`, `kode`, `created_at`, `updated_at`) VALUES
(69, '28', '122133', '2023-04-15 04:54:38', '2023-04-15 04:54:38'),
(70, '28', 'f57a5768a3aa9548', '2023-04-15 13:11:36', '2023-04-15 13:11:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(73, 'default', '{\"uuid\":\"730cc2d0-5891-44de-a75b-042605d570e2\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:59:\\\"Pengajuan Cuti Tahunan telah diterima , Catatan : bagus mi!\\\";}\"}}', 0, NULL, 1658020556, 1658020556),
(74, 'default', '{\"uuid\":\"bc25bb59-8fcf-4562-ae94-7fd4c2d89951\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:74:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 118 menit! :(\\\";}\"}}', 0, NULL, 1658021290, 1658021290),
(75, 'default', '{\"uuid\":\"09f0e1da-cd15-4ad8-a376-c0f6976d5cb7\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:74:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 312 menit! :(\\\";}\"}}', 0, NULL, 1658983348, 1658983348),
(76, 'default', '{\"uuid\":\"c1f7bb51-2e28-4e7a-a665-59668c820ba8\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:63:\\\"Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D\\\";}\"}}', 0, NULL, 1659105854, 1659105854),
(77, 'default', '{\"uuid\":\"7775e0f8-5e92-4c5a-a1c0-1dce70f70275\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:73:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 43 menit! :(\\\";}\"}}', 0, NULL, 1659485603, 1659485603),
(78, 'default', '{\"uuid\":\"2dfd4afa-9900-4971-8ef4-149f7c626300\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:73:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 20 menit! :(\\\";}\"}}', 0, NULL, 1659570623, 1659570623),
(79, 'default', '{\"uuid\":\"424335ab-7046-4c1f-a468-6eb2cf087490\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1661434205, 1661434205),
(80, 'default', '{\"uuid\":\"fecc2bc1-3361-49cc-b77a-7e4303b6384c\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:73:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 78 menit! :(\\\";}\"}}', 0, NULL, 1661651334, 1661651334),
(81, 'default', '{\"uuid\":\"d65b4f5b-71d5-4705-8845-1f799c349496\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:63:\\\"Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D\\\";}\"}}', 0, NULL, 1661728070, 1661728070),
(82, 'default', '{\"uuid\":\"5f438b74-2d06-4e81-b635-91083aff43eb\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"082396151291\\\";s:5:\\\"pesan\\\";s:63:\\\"Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D\\\";}\"}}', 0, NULL, 1661728524, 1661728524),
(83, 'default', '{\"uuid\":\"cab7efa7-fbf5-401a-9c39-37261472ec14\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"085316787777\\\";s:5:\\\"pesan\\\";s:74:\\\"Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat 287 menit! :(\\\";}\"}}', 0, NULL, 1667189841, 1667189841),
(84, 'default', '{\"uuid\":\"582118f6-8ee3-4730-baa2-a271d52250ff\",\"displayName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\ProcessGeneratePayroll\\\":6:{s:3:\\\"nip\\\";s:2:\\\"28\\\";s:5:\\\"no_hp\\\";s:13:\\\"6285712893128\\\";s:7:\\\"jabatan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:33:\\\"App\\\\Models\\\\Pegawai\\\\RiwayatJabatan\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"kode_payroll\\\";s:24:\\\"20220717072145zEwdw8U01t\\\";s:5:\\\"bulan\\\";i:7;s:5:\\\"tahun\\\";s:4:\\\"2022\\\";}\"}}', 0, NULL, 1676657954, 1676657954),
(85, 'default', '{\"uuid\":\"d2767f6f-b40b-4008-b2ab-82d37fb8b385\",\"displayName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\ProcessGeneratePayroll\\\":6:{s:3:\\\"nip\\\";s:2:\\\"66\\\";s:5:\\\"no_hp\\\";s:12:\\\"085316787777\\\";s:7:\\\"jabatan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:33:\\\"App\\\\Models\\\\Pegawai\\\\RiwayatJabatan\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"kode_payroll\\\";s:24:\\\"20220717072145zEwdw8U01t\\\";s:5:\\\"bulan\\\";i:7;s:5:\\\"tahun\\\";s:4:\\\"2022\\\";}\"}}', 0, NULL, 1676657954, 1676657954),
(86, 'default', '{\"uuid\":\"2bda82e3-012a-4bf6-a285-2775a62aef55\",\"displayName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessGeneratePayroll\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\ProcessGeneratePayroll\\\":6:{s:3:\\\"nip\\\";s:2:\\\"28\\\";s:5:\\\"no_hp\\\";s:13:\\\"6285712893128\\\";s:7:\\\"jabatan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:33:\\\"App\\\\Models\\\\Pegawai\\\\RiwayatJabatan\\\";s:2:\\\"id\\\";i:10;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"kode_payroll\\\";s:24:\\\"20220825213005eg4Ab3qwlt\\\";s:5:\\\"bulan\\\";i:8;s:5:\\\"tahun\\\";s:4:\\\"2022\\\";}\"}}', 0, NULL, 1677029297, 1677029297),
(87, 'default', '{\"uuid\":\"1c1ee832-c8d6-4b01-a1e1-2465f5208213\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"085316787777\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1677040106, 1677040106),
(88, 'default', '{\"uuid\":\"59e960d7-58a4-4f3b-8791-680648c5740f\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1677040107, 1677040107),
(89, 'default', '{\"uuid\":\"b726df85-7f43-4868-9139-4a4af447ec84\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"085316787777\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1677040143, 1677040143),
(90, 'default', '{\"uuid\":\"f30728fe-a16f-499d-9988-06cee14deeda\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1677040144, 1677040144),
(91, 'default', '{\"uuid\":\"1506d9f4-34f0-4a50-92b4-5a7eef542f7f\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"085316787777\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315759, 1678315759),
(92, 'default', '{\"uuid\":\"84a663fa-897b-4d26-a492-91951e896b9c\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315759, 1678315759),
(93, 'default', '{\"uuid\":\"28e83bbd-2b3a-4d92-a58f-5868edb6c64d\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:14:\\\"08571212121211\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315759, 1678315759),
(94, 'default', '{\"uuid\":\"86cca143-e455-4f6d-b1e3-47a600408a37\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:12:\\\"085316787777\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315781, 1678315781),
(95, 'default', '{\"uuid\":\"c5c426c8-9767-4b32-8292-125d7481046d\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315781, 1678315781),
(96, 'default', '{\"uuid\":\"582965bd-ac01-4528-a494-8a9cc133a2d2\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:14:\\\"08571212121211\\\";s:5:\\\"pesan\\\";s:157:\\\"Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!\\\";}\"}}', 0, NULL, 1678315782, 1678315782),
(97, 'default', '{\"uuid\":\"e06f137e-ce1d-457b-bdfe-2dcc1d008403\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:63:\\\"Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D\\\";}\"}}', 0, NULL, 1678794075, 1678794075),
(98, 'default', '{\"uuid\":\"3a388653-e951-4991-a136-450ecde573ea\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:35:\\\"Pengajuan Sakit Ditolak karena coba\\\";}\"}}', 0, NULL, 1680499301, 1680499301),
(99, 'default', '{\"uuid\":\"ad45f516-b677-478b-93fc-978b18b95261\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:36:\\\"Pengajuan Sakit Ditolak karena cobak\\\";}\"}}', 0, NULL, 1680499334, 1680499334),
(100, 'default', '{\"uuid\":\"e5566baf-4af4-417c-8b9e-1f8813915710\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:47:\\\"Pengajuan Sakit telah diterima , Catatan : oke!\\\";}\"}}', 0, NULL, 1680502780, 1680502780),
(101, 'default', '{\"uuid\":\"e9cc5a96-e837-4c5d-b91c-6e5b6f4d43b1\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:37:\\\"Pengajuan Lembur Ditolak karena tolak\\\";}\"}}', 0, NULL, 1680504851, 1680504851),
(102, 'default', '{\"uuid\":\"2c7d64e4-8b0b-46a7-9e8d-11b83d6027ca\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:63:\\\"Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D\\\";}\"}}', 0, NULL, 1680612726, 1680612726),
(103, 'default', '{\"uuid\":\"11ebfbb9-77c7-4dd3-8228-db0739eaf142\",\"displayName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessWaNotif\",\"command\":\"O:23:\\\"App\\\\Jobs\\\\ProcessWaNotif\\\":2:{s:4:\\\"nohp\\\";s:13:\\\"6285712893128\\\";s:5:\\\"pesan\\\";s:45:\\\"Pengajuan CAP (Cuti Menikah) telah diterima !\\\";}\"}}', 0, NULL, 1681432871, 1681432871);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_pendidikan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `kode_pendidikan`, `kode_jurusan`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '1', 'SD', '2022-07-17 01:49:23', '2022-07-17 01:49:23', NULL),
(2, '7', '01', 'Teknik Informatika', '2022-08-13 02:47:01', '2022-09-01 00:08:34', '2022-09-01 00:08:34'),
(3, '7', '2', 'Jurusan Teknik Sipil', '2022-09-01 00:09:17', '2022-09-01 00:09:17', NULL),
(4, '7', '3', 'Jurusan Teknik Elektro', '2022-09-01 00:09:38', '2022-09-01 00:09:38', NULL),
(5, '7', '4', 'Jurusan Teknik Geodesi', '2022-09-01 00:09:56', '2022-09-01 00:09:56', NULL),
(6, '7', '5', 'Jurusan Teknik Fisika', '2022-09-01 00:10:13', '2022-09-01 00:10:13', NULL),
(7, '7', '7', 'Jurusan Teknik Industri', '2022-09-01 00:10:48', '2022-09-01 00:10:48', NULL),
(8, '7', '8', 'Jurusan Teknik Kimia', '2022-09-01 00:11:09', '2022-09-01 00:11:09', NULL),
(9, '7', '9', 'Jurusan Teknik Mesin', '2022-09-01 00:11:25', '2022-09-01 00:11:25', NULL),
(10, '7', '10', 'Jurusan Teknik Nuklir', '2022-09-01 00:11:43', '2022-09-01 00:11:43', NULL),
(11, '7', '11', 'Jurusan Perencanaan Wilayah dan Kota', '2022-09-01 00:12:25', '2022-09-01 00:12:25', NULL),
(12, '7', '12', 'Jurusan Arsitektur', '2022-09-01 00:12:42', '2022-09-01 00:12:42', NULL),
(13, '7', '13', 'Jurusan Sosiologi', '2022-09-01 00:12:59', '2022-09-01 00:12:59', NULL),
(14, '7', '14', 'Jurusan Ilmu Komunikasi', '2022-09-01 00:14:37', '2022-09-01 00:14:37', NULL),
(15, '7', '15', 'Jurusan Hubungan Internasional', '2022-09-01 00:14:56', '2022-09-01 00:14:56', NULL),
(16, '7', '16', 'Jurusan Manajemen Kebijakan Publik', '2022-09-01 00:15:14', '2022-09-01 00:15:14', NULL),
(17, '7', '17', 'Jurusan Politik dan Pemerintahan', '2022-09-01 00:15:39', '2022-09-01 00:15:39', NULL),
(18, '7', '18', 'Jurusan Pembangunan Sosial dan Kesejahteraan', '2022-09-01 00:15:55', '2022-09-01 00:15:55', NULL),
(19, '7', '19', 'Jurusan Kriminologi', '2022-09-01 00:16:16', '2022-09-01 00:16:16', NULL),
(20, '7', '20', 'Jurusan Psikologi', '2022-09-01 00:16:39', '2022-09-01 00:16:39', NULL),
(21, '7', '21', 'Jurusan Antropologi', '2022-09-01 00:16:55', '2022-09-01 00:16:55', NULL),
(22, '7', '22', 'Jurusan Ilmu Sejarah', '2022-09-01 00:18:00', '2022-09-01 00:18:00', NULL),
(23, '7', '23', 'Jurusan Sastra Indonesia', '2022-09-01 00:18:21', '2022-09-01 00:18:21', NULL),
(24, '7', '24', 'Jurusan Sastra Inggris', '2022-09-01 00:18:37', '2022-09-01 00:18:37', NULL),
(25, '7', '25', 'Jurusan Sastra Prancis', '2022-09-01 00:18:54', '2022-09-01 00:18:54', NULL),
(26, '7', '26', 'Jurusan Sastra Arab', '2022-09-01 00:19:17', '2022-09-01 00:19:17', NULL),
(27, '7', '27', 'Jurusan Pariwisata', '2022-09-01 00:19:36', '2022-09-01 00:19:36', NULL),
(28, '7', '28', 'Jurusan Sastra Jepang', '2022-09-01 00:19:50', '2022-09-01 00:19:50', NULL),
(29, '7', '29', 'Jurusan Arkeologi', '2022-09-01 00:20:04', '2022-09-01 00:20:04', NULL),
(30, '7', '30', 'Jurusan Filsafat', '2022-09-01 00:20:22', '2022-09-01 00:20:22', NULL),
(31, '7', '31', 'Jurusan Kedokteran', '2022-09-01 00:20:44', '2022-09-01 00:20:44', NULL),
(32, '7', '32', 'Jurusan Farmasi', '2022-09-01 00:21:02', '2022-09-01 00:21:02', NULL),
(33, '7', '33', 'Jurusan Kedokteran Hewan', '2022-09-01 00:31:01', '2022-09-01 00:31:01', NULL),
(34, '7', '34', 'Jurusan Keperawatan', '2022-09-01 00:31:17', '2022-09-01 00:31:17', NULL),
(35, '7', '35', 'Jurusan Kedokteran Gigi', '2022-09-01 00:31:45', '2022-09-01 00:31:45', NULL),
(36, '7', '36', 'Jurusan Ilmu Gizi', '2022-09-01 00:32:03', '2022-09-01 00:32:03', NULL),
(37, '7', '37', 'Jurusan Seni Kriya', '2022-09-01 00:32:57', '2022-09-01 00:32:57', NULL),
(38, '7', '38', 'Jurusan Seni Musik', '2022-09-01 00:33:13', '2022-09-01 00:33:13', NULL),
(39, '7', '39', 'Jurusan Seni Pertunjukan', '2022-09-01 00:33:28', '2022-09-01 00:33:28', NULL),
(40, '7', '40', 'Jurusan Seni Pedalangan', '2022-09-01 00:33:52', '2022-09-01 00:33:52', NULL),
(41, '7', '41', 'Jurusan Fotografi', '2022-09-01 00:34:07', '2022-09-01 00:34:07', NULL),
(42, '7', '42', 'Jurusan Etnomusikologi', '2022-09-01 00:34:22', '2022-09-01 00:34:22', NULL),
(43, '7', '43', 'Jurusan Seni Karawitan', '2022-09-01 00:34:44', '2022-09-01 00:34:44', NULL),
(44, '7', '44', 'Jurusan Seni Tari', '2022-09-01 00:35:03', '2022-09-01 00:35:03', NULL),
(45, '7', '45', 'Jurusan Ilmu Ekonomi', '2022-09-01 00:35:54', '2022-09-01 00:35:54', NULL),
(46, '7', '46', 'Jurusan Akuntansi', '2022-09-01 00:36:11', '2022-09-01 00:36:11', NULL),
(47, '7', '47', 'Jurusan Manajemen', '2022-09-01 00:36:30', '2022-09-01 00:36:30', NULL),
(48, '7', '48', 'Jurusan Fisika', '2022-09-01 00:38:44', '2022-09-01 00:38:44', NULL),
(49, '7', '49', 'Jurusan Kimia', '2022-09-01 00:39:41', '2022-09-01 00:39:41', NULL),
(50, '7', '50', 'Jurusan Biologi', '2022-09-01 00:40:04', '2022-09-01 00:40:04', NULL),
(51, '7', '52', 'Jurusan Matematika', '2022-09-01 00:40:30', '2022-09-01 00:40:30', NULL),
(52, '7', '51', 'Jurusan Geofisika', '2022-09-01 00:40:53', '2022-09-01 00:40:53', NULL),
(53, '7', '53', 'Jurusan Ilmu Komputer', '2022-09-01 00:41:24', '2022-09-01 00:41:24', NULL),
(54, '7', '54', 'Jurusan Elektronika dan Instrumentasi', '2022-09-01 00:41:43', '2022-09-01 00:41:43', NULL),
(55, '7', '55', 'Jurusan Ilmu Aktuaria: Sarjana Aktuaria', '2022-09-01 00:42:01', '2022-09-01 00:42:01', NULL),
(56, '7', '56', 'Jurusan Statistika: Sarjana Statistika', '2022-09-01 00:42:15', '2022-09-01 00:42:15', NULL),
(57, '7', '57', 'Jurusan Pendidikan Luar Sekolah', '2022-09-01 00:42:35', '2022-09-01 00:42:35', NULL),
(58, '7', '58', 'Jurusan Pendidikan Anak Usia Dini', '2022-09-01 00:42:54', '2022-09-01 00:42:54', NULL),
(59, '7', '59', 'Jurusan Pendidikan Guru Sekolah Dasar', '2022-09-01 00:43:16', '2022-09-01 00:43:16', NULL),
(60, '7', '60', 'Jurusan Manajemen Pendidikan', '2022-09-01 00:44:34', '2022-09-01 00:44:34', NULL),
(61, '7', '61', 'Jurusan Teknologi Pendidikan', '2022-09-01 00:44:49', '2022-09-01 00:44:49', NULL),
(62, '7', '62', 'Jurusan Pendidikan Agama Islam', '2022-09-01 00:45:05', '2022-09-01 00:45:05', NULL),
(63, '7', '63', 'Jurusan Kehutanan', '2022-09-01 00:45:25', '2022-09-01 00:45:25', NULL),
(64, '7', '64', 'Jurusan Agroteknologi', '2022-09-01 00:45:43', '2022-09-01 00:45:43', NULL),
(65, '7', '65', 'Jurusan Agribisnis', '2022-09-01 00:45:57', '2022-09-01 00:45:57', NULL),
(66, '7', '66', 'Jurusan Perikanan', '2022-09-01 00:46:10', '2022-09-01 00:46:10', NULL),
(67, '7', '67', 'Jurusan Ilmu Tanah', '2022-09-01 00:46:24', '2022-09-01 00:46:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluarga`
--

CREATE TABLE `keluarga` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nip_keluarga` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kehidupan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidup',
  `status_pernikahan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_ibu` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_anak` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anak_ke` tinyint(4) DEFAULT NULL,
  `jenis_kelamin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_ktp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_ktp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_bpjs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_bpjs` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_akta_kelahiran` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_akta_kelahiran` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `keluarga`
--

INSERT INTO `keluarga` (`id`, `nip`, `status`, `nama`, `tempat_lahir`, `tanggal_lahir`, `nip_keluarga`, `status_kehidupan`, `status_pernikahan`, `id_ibu`, `status_anak`, `anak_ke`, `jenis_kelamin`, `alamat`, `nomor_telepon`, `nomor_ktp`, `file_ktp`, `nomor_bpjs`, `file_bpjs`, `nomor_akta_kelahiran`, `file_akta_kelahiran`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28', 'suami/istri', 'Retno', 'Solo', '1994-10-29', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'Mutihan', '123455', '3374012511901231', NULL, '123124335', NULL, NULL, NULL, '2022-08-23 05:34:34', '2022-08-23 05:34:34', NULL),
(2, '28', 'istri', 'Retno', 'Solo', '1990-10-24', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-23 05:35:03', '2023-02-12 15:29:54', '2023-02-12 15:29:54'),
(3, '28', 'ayah', 'Nana', 'Malang', '2023-02-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'asdasd', NULL, '123139', NULL, '12312313', NULL, NULL, NULL, '2023-02-12 10:53:03', '2023-02-12 10:53:03', NULL),
(4, '28', 'ibu', 'Nani!!', 'Wajak', '2023-02-18', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'lmalam', NULL, '2424234', NULL, '1313123', NULL, NULL, NULL, '2023-02-12 11:26:51', '2023-02-12 11:26:51', NULL),
(5, '28', 'ayah', 'Fathur', 'Mlang', '1998-03-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'dadaskdm', NULL, '131030', NULL, '091238139', NULL, NULL, NULL, '2023-02-12 12:05:06', '2023-02-12 12:05:06', NULL),
(6, '28', 'ayah', 'afasa', 'masldm', '1998-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'adadm', '12345', '239234892384', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 12:06:55', '2023-02-12 14:36:54', NULL),
(7, '28', 'ayah', 'Fauzan', 'Babi', '1886-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'asdasdasd', NULL, '1231313', NULL, '1313', NULL, NULL, NULL, '2023-02-12 12:13:59', '2023-02-12 14:49:08', '2023-02-12 14:49:08'),
(8, '28', 'ayah', 'Dafe', 'asda', '1998-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'asasddsa', NULL, '123123', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 12:14:57', '2023-02-12 12:14:57', NULL),
(9, '28', 'ibu', 'Dafe', 'asda', '1997-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'asdasd', NULL, '123123', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 12:18:15', '2023-02-12 12:18:15', NULL),
(10, '28', 'ayah', 'Dafe', 'asda', '1998-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'asasddsa', '12345', '123123', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 14:30:26', '2023-02-12 14:30:26', NULL),
(11, '28', 'ayah', 'afasa', 'masldm', '1998-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'adadm', '12345', '239234892384', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 14:30:38', '2023-02-12 15:08:23', '2023-02-12 15:08:23'),
(12, '28', 'ayah', 'afasa', 'masldm', '1998-12-12', NULL, 'hidup', NULL, NULL, NULL, NULL, NULL, 'adadm', '12345', '239234892384', NULL, '12313123', NULL, NULL, NULL, '2023-02-12 14:35:38', '2023-02-12 15:08:15', '2023-02-12 15:08:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursus`
--

CREATE TABLE `kursus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kursus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kursus`
--

INSERT INTO `kursus` (`id`, `kode_kursus`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Kursus Bahasa Inggris', '2022-08-13 02:51:33', '2022-08-13 02:51:33', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lainnya`
--

CREATE TABLE `lainnya` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_lainnya` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `logs`
--

INSERT INTO `logs` (`id`, `user_nip`, `target_nip`, `model_type`, `model_id`, `action`, `created_at`, `updated_at`) VALUES
(2, '123', '66', 'App\\Pegawai\\DataPengajuanCuti', '2', 'tolak', '2022-07-03 06:59:23', '2022-07-03 06:59:23'),
(3, '123', '66', 'App\\Pegawai\\DataPengajuanCuti', '3', 'terima', '2022-07-03 07:04:21', '2022-07-03 07:04:21'),
(4, '66', '28', 'App\\Pegawai\\DataPengajuanCuti', '5', 'terima', '2022-07-03 07:07:30', '2022-07-03 07:07:30'),
(5, '66', '28', 'App\\Pegawai\\DataPengajuanCuti', '6', 'diajukan', '2022-07-03 07:08:16', '2022-07-03 07:08:16'),
(6, '123', '28', 'App\\Pegawai\\DataPengajuanCuti', '6', 'tolak', '2022-07-03 07:08:34', '2022-07-03 07:08:34'),
(7, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '2', 'tolak', '2022-07-03 07:23:52', '2022-07-03 07:23:52'),
(8, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '4', 'terima', '2022-07-03 07:24:13', '2022-07-03 07:24:13'),
(9, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '34', 'tolak', '2022-07-03 07:31:52', '2022-07-03 07:31:52'),
(10, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '10', 'tolak', '2022-07-03 07:31:58', '2022-07-03 07:31:58'),
(11, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '6', 'tolak', '2022-07-03 07:32:20', '2022-07-03 07:32:20'),
(12, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '5', 'dihapus', '2022-07-03 09:54:58', '2022-07-03 09:54:58'),
(13, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '7', 'ditambahkan', '2022-07-03 09:55:51', '2022-07-03 09:55:51'),
(14, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '6', 'dihapus', '2022-07-03 09:56:03', '2022-07-03 09:56:03'),
(15, '123', '66', 'App\\Pegawai\\DataPengajuanLembur', '2', 'dihapus', '2022-07-03 09:56:17', '2022-07-03 09:56:17'),
(16, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '35', 'ditambahkan', '2022-07-03 10:10:42', '2022-07-03 10:10:42'),
(17, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '1', 'diubah', '2022-07-03 10:11:26', '2022-07-03 10:11:26'),
(18, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '2', 'dihapus', '2022-07-03 10:11:43', '2022-07-03 10:11:43'),
(19, '123', '66', 'App\\Pegawai\\DataPengajuanReimbursement', '5', 'dihapus', '2022-07-03 10:11:48', '2022-07-03 10:11:48'),
(20, '123', '66', 'App\\Pegawai\\RiwayatTunjangan', '1', 'ditambahkan', '2022-07-12 00:13:05', '2022-07-12 00:13:05'),
(21, '123', '66', 'App\\Pegawai\\RiwayatTunjangan', '1', 'dinonaktifkan', '2022-07-12 03:17:10', '2022-07-12 03:17:10'),
(22, '123', '66', 'App\\Pegawai\\RiwayatTunjangan', '1', 'diaktifkan', '2022-07-12 03:17:17', '2022-07-12 03:17:17'),
(23, '123', '66', 'App\\Pegawai\\RiwayatTunjangan', '1', 'diubah', '2022-07-12 03:18:56', '2022-07-12 03:18:56'),
(24, '123', '66', 'App\\Pegawai\\DataPengajuanCuti', '4', 'terima', '2022-07-12 13:05:38', '2022-07-12 13:05:38'),
(25, '123', '66', 'App\\Pegawai\\RiwayatPotongan', '1', 'ditambahkan', '2022-07-16 23:53:17', '2022-07-16 23:53:17'),
(26, '123', '28', 'App\\Pegawai\\RiwayatPotongan', '2', 'ditambahkan', '2022-07-16 23:59:27', '2022-07-16 23:59:27'),
(27, '123', '66', 'App\\Pegawai\\RiwayatPotongan', '1', 'dinonaktifkan', '2022-07-17 02:03:27', '2022-07-17 02:03:27'),
(28, '123', '66', 'App\\Pegawai\\DataPengajuanCuti', '1', 'terima', '2022-07-17 02:15:56', '2022-07-17 02:15:56'),
(29, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '2', 'ditambahkan', '2023-02-14 08:32:29', '2023-02-14 08:32:29'),
(30, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '3', 'ditambahkan', '2023-02-14 08:45:49', '2023-02-14 08:45:49'),
(31, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '2', 'diubah', '2023-02-14 09:11:13', '2023-02-14 09:11:13'),
(32, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '3', 'diubah', '2023-02-14 09:43:58', '2023-02-14 09:43:58'),
(33, '123', '28', 'App\\Pegawai\\RiwayatPotongan', '3', 'ditambahkan', '2023-02-14 10:21:28', '2023-02-14 10:21:28'),
(34, '123', '28', 'App\\Pegawai\\RiwayatPotongan', '3', 'diubah', '2023-02-14 10:23:18', '2023-02-14 10:23:18'),
(35, '123', '28', 'App\\Pegawai\\RiwayatPotongan', '3', 'diubah', '2023-02-14 10:24:25', '2023-02-14 10:24:25'),
(36, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '2', 'diubah', '2023-02-14 10:24:46', '2023-02-14 10:24:46'),
(37, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '2', 'diubah', '2023-02-14 10:25:22', '2023-02-14 10:25:22'),
(38, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '2', 'dihapus', '2023-02-14 10:25:32', '2023-02-14 10:25:32'),
(39, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '3', 'dihapus', '2023-02-14 10:27:24', '2023-02-14 10:27:24'),
(40, '123', '28', 'App\\Pegawai\\RiwayatPotongan', '2', 'dihapus', '2023-02-14 10:29:02', '2023-02-14 10:29:02'),
(41, '123', '28', 'App\\Pegawai\\RiwayatTunjangan', '4', 'ditambahkan', '2023-02-17 08:58:39', '2023-02-17 08:58:39'),
(42, '123', '123', 'App\\Pegawai\\RiwayatShift', '1', 'terima', '2023-02-24 11:25:49', '2023-02-24 11:25:49'),
(43, '28', '28', 'App\\Pegawai\\DataPengajuanCuti', '7', 'diajukan', '2023-03-13 04:58:00', '2023-03-13 04:58:00'),
(44, '28', '28', 'App\\Pegawai\\DataPengajuanLembur', '8', 'diajukan', '2023-03-13 05:03:00', '2023-03-13 05:03:00'),
(45, '66', '66', 'App\\Pegawai\\DataPengajuanCuti', '8', 'diajukan', '2023-03-13 13:06:32', '2023-03-13 13:06:32'),
(46, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '36', 'diajukan', '2023-03-13 16:41:18', '2023-03-13 16:41:18'),
(47, '123', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '36', 'tolak', '2023-03-13 16:46:40', '2023-03-13 16:46:40'),
(48, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '37', 'diajukan', '2023-03-13 16:46:45', '2023-03-13 16:46:45'),
(49, '123', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '37', 'tolak', '2023-03-13 16:47:53', '2023-03-13 16:47:53'),
(50, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '38', 'diajukan', '2023-03-13 16:48:21', '2023-03-13 16:48:21'),
(51, '123', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '38', 'tolak', '2023-03-13 16:52:44', '2023-03-13 16:52:44'),
(52, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '39', 'diajukan', '2023-03-13 16:53:22', '2023-03-13 16:53:22'),
(53, '66', '28', 'App\\Pegawai\\RiwayatShift', '2', 'diajukan', '2023-03-14 03:51:03', '2023-03-14 03:51:03'),
(54, '66', '28', 'App\\Pegawai\\RiwayatShift', '3', 'diajukan', '2023-03-14 03:57:50', '2023-03-14 03:57:50'),
(55, '28', '28', 'App\\Pegawai\\RiwayatShift', '4', 'diajukan', '2023-03-14 03:58:37', '2023-03-14 03:58:37'),
(56, '123', '28', 'App\\Pegawai\\RiwayatShift', '5', 'ditambahkan', '2023-03-14 07:20:30', '2023-03-14 07:20:30'),
(57, '123', '28', 'App\\Pegawai\\RiwayatShift', '5', 'terima', '2023-03-14 07:21:08', '2023-03-14 07:21:08'),
(58, '123', '28', 'App\\Pegawai\\RiwayatShift', '4', 'terima', '2023-03-14 07:22:26', '2023-03-14 07:22:26'),
(59, '123', '28', 'App\\Pegawai\\RiwayatShift', '6', 'ditambahkan', '2023-03-14 07:29:24', '2023-03-14 07:29:24'),
(60, '123', '28', 'App\\Pegawai\\RiwayatShift', '5', 'diubah', '2023-03-14 07:29:53', '2023-03-14 07:29:53'),
(61, '123', '28', 'App\\Pegawai\\RiwayatShift', '5', 'dihapus', '2023-03-14 07:30:01', '2023-03-14 07:30:01'),
(62, '123', '28', 'App\\Pegawai\\RiwayatShift', '4', 'dihapus', '2023-03-14 07:30:04', '2023-03-14 07:30:04'),
(63, '123', '28', 'App\\Pegawai\\RiwayatShift', '7', 'ditambahkan', '2023-03-14 07:30:24', '2023-03-14 07:30:24'),
(64, '123', '28', 'App\\Pegawai\\RiwayatShift', '8', 'ditambahkan', '2023-03-14 07:31:04', '2023-03-14 07:31:04'),
(65, '123', '28', 'App\\Pegawai\\RiwayatShift', '8', 'terima', '2023-03-14 07:32:16', '2023-03-14 07:32:16'),
(66, '123', '28', 'App\\Pegawai\\RiwayatShift', '9', 'ditambahkan', '2023-03-14 07:32:31', '2023-03-14 07:32:31'),
(67, '123', '28', 'App\\Pegawai\\RiwayatShift', '9', 'terima', '2023-03-14 10:09:52', '2023-03-14 10:09:52'),
(68, '28', '28', 'App\\Pegawai\\DataPengajuanCuti', '9', 'diajukan', '2023-03-26 17:13:01', '2023-03-26 17:13:01'),
(69, '28', '28', 'App\\Pegawai\\DataPengajuanCuti', '10', 'diajukan', '2023-03-26 17:17:20', '2023-03-26 17:17:20'),
(70, '28', '28', 'App\\Pegawai\\DataPengajuanCuti', '11', 'diajukan', '2023-04-03 04:39:38', '2023-04-03 04:39:38'),
(71, '28', '28', 'App\\Pegawai\\DataPengajuanLembur', '9', 'diajukan', '2023-04-03 04:40:50', '2023-04-03 04:40:50'),
(72, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '11', 'terima', '2023-04-03 06:19:39', '2023-04-03 06:19:39'),
(73, '0', '28', 'App\\Pegawai\\DataPengajuanLembur', '9', 'tolak', '2023-04-03 06:54:11', '2023-04-03 06:54:11'),
(74, '28', '28', 'App\\Pegawai\\DataPengajuanCuti', '12', 'diajukan', '2023-04-03 06:55:30', '2023-04-03 06:55:30'),
(75, '28', '28', 'App\\Pegawai\\DataPengajuanLembur', '10', 'diajukan', '2023-04-03 06:56:46', '2023-04-03 06:56:46'),
(76, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '40', 'diajukan', '2023-04-03 08:16:04', '2023-04-03 08:16:04'),
(77, '0', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '40', 'tolak', '2023-04-03 08:39:05', '2023-04-03 08:39:05'),
(78, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '41', 'diajukan', '2023-04-03 08:39:58', '2023-04-03 08:39:58'),
(79, '0', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '41', 'tolak', '2023-04-03 08:40:49', '2023-04-03 08:40:49'),
(80, '28', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '42', 'diajukan', '2023-04-03 08:41:49', '2023-04-03 08:41:49'),
(81, '0', '28', 'App\\Pegawai\\DataPengajuanReimbursement', '42', 'tolak', '2023-04-03 08:43:27', '2023-04-03 08:43:27'),
(82, '0', '28', 'App\\Pegawai\\RiwayatShift', '10', 'ditambahkan', '2023-04-03 15:05:30', '2023-04-03 15:05:30'),
(83, '0', '123', 'App\\Pegawai\\RiwayatTunjangan', '5', 'ditambahkan', '2023-04-05 06:45:26', '2023-04-05 06:45:26'),
(84, '0', '123', 'App\\Pegawai\\RiwayatPotongan', '4', 'ditambahkan', '2023-04-05 07:29:02', '2023-04-05 07:29:02'),
(85, '0', '123', 'App\\Pegawai\\RiwayatPotongan', '4', 'diubah', '2023-04-05 07:29:18', '2023-04-05 07:29:18'),
(86, '0', '123', 'App\\Pegawai\\RiwayatPotongan', '4', 'diubah', '2023-04-05 07:29:27', '2023-04-05 07:29:27'),
(87, '0', '123', 'App\\Pegawai\\RiwayatPotongan', '4', 'diubah', '2023-04-05 07:29:48', '2023-04-05 07:29:48'),
(88, '0', '123', 'App\\Pegawai\\RiwayatPotongan', '4', 'dihapus', '2023-04-05 07:32:10', '2023-04-05 07:32:10'),
(89, '0', '123', 'App\\Pegawai\\RiwayatTunjangan', '5', 'dihapus', '2023-04-05 07:35:57', '2023-04-05 07:35:57'),
(90, '0', '123', 'App\\Pegawai\\DataPengajuanLembur', '11', 'ditambahkan', '2023-04-05 07:55:12', '2023-04-05 07:55:12'),
(91, '0', '123', 'App\\Pegawai\\DataPengajuanLembur', '11', 'diubah', '2023-04-05 07:57:29', '2023-04-05 07:57:29'),
(92, '0', '123', 'App\\Pegawai\\DataPengajuanLembur', '11', 'dihapus', '2023-04-05 07:58:06', '2023-04-05 07:58:06'),
(93, '0', '123', 'App\\Pegawai\\DataPengajuanReimbursement', '43', 'ditambahkan', '2023-04-05 08:01:22', '2023-04-05 08:01:22'),
(94, '0', '123', 'App\\Pegawai\\DataPengajuanReimbursement', '43', 'diubah', '2023-04-05 08:01:45', '2023-04-05 08:01:45'),
(95, '0', '123', 'App\\Pegawai\\DataPengajuanReimbursement', '43', 'diubah', '2023-04-05 08:42:44', '2023-04-05 08:42:44'),
(96, '0', '123', 'App\\Pegawai\\DataPengajuanReimbursement', '43', 'diubah', '2023-04-05 08:44:35', '2023-04-05 08:44:35'),
(97, '0', '123', 'App\\Pegawai\\DataPengajuanReimbursement', '43', 'dihapus', '2023-04-05 08:44:59', '2023-04-05 08:44:59'),
(98, '0', '004', 'App\\Pegawai\\RiwayatShift', '11', 'ditambahkan', '2023-04-12 05:20:48', '2023-04-12 05:20:48'),
(99, '0', '004', 'App\\Pegawai\\RiwayatShift', '11', 'terima', '2023-04-12 05:21:59', '2023-04-12 05:21:59'),
(100, '0', '28', 'App\\Pegawai\\RiwayatShift', '8', 'dihapus', '2023-04-14 00:03:42', '2023-04-14 00:03:42'),
(101, '0', '28', 'App\\Pegawai\\RiwayatShift', '5', 'dihapus', '2023-04-14 00:03:49', '2023-04-14 00:03:49'),
(102, '0', '28', 'App\\Pegawai\\RiwayatShift', '9', 'dihapus', '2023-04-14 00:03:52', '2023-04-14 00:03:52'),
(103, '0', '28', 'App\\Pegawai\\RiwayatShift', '12', 'ditambahkan', '2023-04-14 00:04:41', '2023-04-14 00:04:41'),
(104, '0', '28', 'App\\Pegawai\\RiwayatShift', '13', 'ditambahkan', '2023-04-14 00:12:41', '2023-04-14 00:12:41'),
(105, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:32:51', '2023-04-14 00:32:51'),
(106, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:34:21', '2023-04-14 00:34:21'),
(107, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:36:45', '2023-04-14 00:36:45'),
(108, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:39:47', '2023-04-14 00:39:47'),
(109, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:40:27', '2023-04-14 00:40:27'),
(110, '0', '28', 'App\\Pegawai\\DataPengajuanCuti', '13', 'terima', '2023-04-14 00:41:05', '2023-04-14 00:41:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_lokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kordinat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak` int(11) NOT NULL DEFAULT 0,
  `keterangan` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 memilih pegawai, 1 berdasarkan atasan dan bawahannya, 2 berdasarkan jabatan itu saja',
  `polygon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `kode_lokasi`, `kode_shift`, `nama`, `kordinat`, `latitude`, `longitude`, `jarak`, `keterangan`, `polygon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '01', '01', 'Deta Sukses Makmur Head Office', '-7.006793068102385, 110.41733718795163', '-7.006793068102385', '110.41733718795163', 1268, 3, '[[{\"lat\":-7.97261888221635,\"lng\":112.59557463340913},{\"lat\":-7.9759764112458775,\"lng\":112.59737722617726},{\"lat\":-7.975041405930768,\"lng\":112.60171203259593},{\"lat\":-7.971343863972851,\"lng\":112.60252749122914},{\"lat\":-7.968921318364716,\"lng\":112.59862187356477},{\"lat\":-7.970578851119622,\"lng\":112.5966476052949}]]', '2022-06-28 12:53:56', '2023-04-03 14:14:53', NULL),
(14, '02', '01', 'DSM DKP', '-7.430180, 110.804071', '-7.430180', '110.804071', 1268, 3, NULL, '2022-06-28 12:53:56', '2023-04-03 14:15:57', NULL),
(15, '03', '01', 'DSM JMP', '-7.4285714909850435, 110.80366654414584', '-7.4285714909850435', '110.80366654414584', 100, 3, NULL, '2023-04-03 14:21:59', '2023-04-03 14:21:59', NULL),
(16, 'Grapari Telkomsel Yogyakarta', '01', 'Grapari Telkomsel Yogyakarta', '-7.782966,110.361411', '-7.782966', '110.361411', 100, 1, NULL, '2023-04-09 02:29:25', '2023-04-09 02:29:25', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi_detail`
--

CREATE TABLE `lokasi_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_lokasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_tipe` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 memilih pegawai, 1 berdasarkan atasan dan bawahannya, 2 berdasarkan jabatan itu saja',
  `keterangan_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lokasi_detail`
--

INSERT INTO `lokasi_detail` (`id`, `kode_lokasi`, `keterangan_tipe`, `keterangan_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '0101', '2', '1022420300', '2022-06-27 14:29:51', '2022-06-29 14:37:35', '2022-06-29 14:37:35'),
(6, '0202', '1', '28', '2022-06-29 14:36:38', '2022-06-29 14:38:16', '2022-06-29 14:38:16'),
(7, '0101', '2', '1022420200', '2022-06-29 14:37:35', '2022-06-29 14:41:46', '2022-06-29 14:41:46'),
(8, '0202', '1', '66', '2022-06-29 14:38:16', '2023-02-23 01:20:13', '2023-02-23 01:20:13'),
(9, '0101', '2', '1022420300', '2022-06-29 14:41:46', '2022-11-19 06:02:58', '2022-11-19 06:02:58'),
(10, '0303', '3', '102242', '2022-06-29 14:47:32', '2022-06-29 14:58:32', '2022-06-29 14:58:32'),
(11, '0303', '3', '102242', '2022-06-29 14:58:32', '2023-02-22 13:58:14', '2023-02-22 13:58:14'),
(12, '0303', '1', '10', '2023-02-22 13:58:14', '2023-02-22 13:58:35', '2023-02-22 13:58:35'),
(13, '0303', '1', '111111', '2023-02-22 13:58:14', '2023-02-22 13:58:35', '2023-02-22 13:58:35'),
(14, '0303', '1', '10', '2023-02-22 13:58:35', '2023-02-22 14:04:07', '2023-02-22 14:04:07'),
(15, '0303', '1', '111111', '2023-02-22 13:58:35', '2023-02-22 14:04:07', '2023-02-22 14:04:07'),
(16, '0303', '1', '10', '2023-02-22 14:04:07', '2023-02-22 14:04:32', '2023-02-22 14:04:32'),
(17, '0303', '1', '111111', '2023-02-22 14:04:07', '2023-02-22 14:04:32', '2023-02-22 14:04:32'),
(18, '0303', '1', '10', '2023-02-22 14:04:32', '2023-02-22 14:12:24', '2023-02-22 14:12:24'),
(19, '0303', '1', '111111', '2023-02-22 14:04:33', '2023-02-22 14:12:24', '2023-02-22 14:12:24'),
(20, '0303', '1', '10', '2023-02-22 14:12:24', '2023-02-22 14:17:03', '2023-02-22 14:17:03'),
(21, '0303', '1', '111111', '2023-02-22 14:12:24', '2023-02-22 14:17:03', '2023-02-22 14:17:03'),
(22, '0303', '1', '10', '2023-02-22 14:17:03', '2023-02-23 01:21:32', '2023-02-23 01:21:32'),
(23, '0303', '1', '111111', '2023-02-22 14:17:03', '2023-02-23 01:21:32', '2023-02-23 01:21:32'),
(24, '0202', '1', '66', '2023-02-23 01:20:13', '2023-02-23 01:20:39', '2023-02-23 01:20:39'),
(25, '0202', '1', '66', '2023-02-23 01:20:39', '2023-02-23 01:21:05', '2023-02-23 01:21:05'),
(26, '0202', '1', '66', '2023-02-23 01:21:05', '2023-02-23 03:00:10', '2023-02-23 03:00:10'),
(27, '0303', '1', '10', '2023-02-23 01:21:32', '2023-02-23 01:21:32', NULL),
(28, '0303', '1', '111111', '2023-02-23 01:21:32', '2023-02-23 01:21:32', NULL),
(29, '0202', '1', '66', '2023-02-23 03:00:10', '2023-02-23 03:17:51', '2023-02-23 03:17:51'),
(30, '0202', '1', '66', '2023-02-23 03:17:51', '2023-02-23 03:40:17', '2023-02-23 03:40:17'),
(31, '0202', '1', '66', '2023-02-23 03:40:17', '2023-03-02 02:20:36', '2023-03-02 02:20:36'),
(32, '0202', '1', '66', '2023-03-02 02:20:36', '2023-03-02 02:20:36', NULL),
(33, '0100', '1', '66', '2023-03-02 03:08:18', '2023-03-02 03:08:38', '2023-03-02 03:08:38'),
(34, '0100', '1', '28', '2023-03-02 03:08:38', '2023-03-02 05:11:41', '2023-03-02 05:11:41'),
(35, '0100', '1', '66', '2023-03-02 03:08:38', '2023-03-02 05:11:41', '2023-03-02 05:11:41'),
(36, '0100', '3', '01', '2023-03-02 05:11:41', '2023-03-02 05:11:41', NULL),
(37, '01', '3', '01', '2023-04-03 14:14:53', '2023-04-03 14:14:53', NULL),
(38, '02', '3', '04', '2023-04-03 14:15:37', '2023-04-03 14:15:57', '2023-04-03 14:15:57'),
(39, '02', '3', '04', '2023-04-03 14:15:57', '2023-04-03 14:15:57', NULL),
(40, '03', '3', '03', '2023-04-03 14:21:59', '2023-04-03 14:21:59', NULL),
(41, 'Grapari Telkomsel Yogyakarta', '1', '111111', '2023-04-09 02:29:25', '2023-04-09 02:29:25', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_05_02_140432_create_provinces_tables', 1),
(4, '2017_05_02_140444_create_regencies_tables', 1),
(5, '2017_05_02_142019_create_districts_tables', 1),
(6, '2017_05_02_143454_create_villages_tables', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(9, '2022_05_25_110739_create_permission_tables', 1),
(10, '2022_05_25_111446_add_all_to_users_table', 1),
(11, '2022_05_25_134820_create_skpds_table', 1),
(12, '2022_05_26_051222_create_eselons_table', 1),
(13, '2022_05_26_145144_create_sukus_table', 1),
(14, '2022_05_26_151320_create_status_pegawais_table', 1),
(15, '2022_05_26_191349_create_riwayat_jabatans_table', 1),
(16, '2022_05_27_173753_add_kode_skpd_to_riwayat_jabatan_table', 1),
(17, '2022_05_27_204157_create_riwayat_statuses_table', 1),
(18, '2022_05_28_073547_create_riwayat_pendidikans_table', 1),
(19, '2022_05_28_074032_create_pendidikans_table', 1),
(20, '2022_05_28_074109_create_jurusans_table', 1),
(21, '2022_05_28_091050_create_keluargas_table', 1),
(22, '2022_06_05_213444_create_kursuses_table', 1),
(23, '2022_06_05_214423_create_riwayat_kursuses_table', 1),
(24, '2022_06_05_220235_create_penghargaans_table', 1),
(25, '2022_06_05_220810_create_riwayat_penghargaans_table', 1),
(26, '2022_06_05_222414_create_cutis_table', 1),
(27, '2022_06_05_222947_create_riwayat_cutis_table', 1),
(28, '2022_06_06_130103_create_riwayat_kgbs_table', 1),
(29, '2022_06_06_133940_create_riwayat_lhkpns_table', 1),
(30, '2022_06_06_141402_create_riwayat_lhkasns_table', 1),
(31, '2022_06_06_142553_create_riwayat_organisasis_table', 1),
(32, '2022_06_06_150657_create_riwayat_bahasas_table', 1),
(33, '2022_06_06_164227_create_riwayat_spts_table', 1),
(34, '2022_06_16_142907_create_riwayat_pmks_table', 1),
(35, '2022_06_16_145752_create_lainnyas_table', 1),
(36, '2022_06_16_150348_create_riwayat_lainnyas_table', 1),
(37, '2022_06_23_201100_create_tingkats_table', 1),
(39, '2022_06_25_055032_create_shifts_table', 2),
(42, '2022_06_25_125940_create_lokasis_table', 3),
(43, '2022_06_25_130030_create_lokasi_details_table', 3),
(44, '2022_06_27_203509_add_gapok_to_tingkat_table', 4),
(45, '2022_06_29_182647_add_kordinat_to_users_table', 5),
(47, '2022_06_30_133350_create_data_presensis_table', 6),
(48, '2022_06_30_142016_create_data_pengajuan_cutis_table', 7),
(50, '2022_06_30_144255_create_data_pengajuan_lemburs_table', 8),
(51, '2022_06_30_145133_create_reimbursements_table', 9),
(52, '2022_06_30_150330_create_data_pengajuan_reimbursements_table', 10),
(53, '2022_07_03_055452_create_jobs_table', 11),
(54, '2022_07_03_130419_create_logs_table', 12),
(55, '2022_07_04_150819_create_data_payrolls_table', 13),
(56, '2022_07_04_152048_create_payroll_tambahs_table', 14),
(57, '2022_07_04_152542_create_payroll_kurangs_table', 15),
(60, '2022_07_04_153201_create_tambahans_table', 16),
(61, '2022_07_04_153214_create_pengurangans_table', 16),
(62, '2022_07_12_063508_create_riwayat_tunjangans_table', 17),
(63, '2022_07_12_064404_create_tunjangans_table', 17),
(65, '2022_07_12_102315_create_lemburs_table', 18),
(68, '2022_07_12_200801_create_daftar_tambah_payrolls_table', 19),
(69, '2022_07_13_062744_create_data_kurang_payrolls_table', 20),
(70, '2022_07_13_064734_create_absensis_table', 21),
(71, '2022_07_13_161137_create_generate_payrolls_table', 22),
(72, '2022_07_14_185622_create_hari_liburs_table', 23),
(75, '2022_07_17_062139_create_riwayat_potongans_table', 24),
(76, '2022_07_17_062514_create_potongans_table', 24),
(77, '2022_07_30_093706_create_riwayat_shifts_table', 25),
(78, '2022_07_30_183639_create_imeis_table', 26),
(79, '2022_07_31_053825_create_pengumumen_table', 26),
(80, '2022_08_01_070258_create_perusahaans_table', 26),
(81, '2022_08_29_065717_add_foto_to_data_presensi_table', 27),
(82, '2022_08_29_072224_create_visits_table', 28),
(83, '2022_08_29_163148_add_is_private_to_riwayat_kgb', 28),
(84, '2022_08_31_210318_add_is_private_to_riwayat_tunjangan_table', 29),
(85, '2022_08_31_210333_add_is_private_to_riwayat_potongan_table', 29),
(86, '2022_08_31_212958_create_data_visits_table', 30);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 23),
(3, 'App\\Models\\User', 24),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29),
(3, 'App\\Models\\User', 30),
(3, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 32),
(3, 'App\\Models\\User', 33),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 60),
(3, 'App\\Models\\User', 61),
(3, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 63),
(3, 'App\\Models\\User', 64),
(3, 'App\\Models\\User', 65),
(3, 'App\\Models\\User', 66),
(3, 'App\\Models\\User', 67),
(3, 'App\\Models\\User', 68),
(3, 'App\\Models\\User', 69),
(3, 'App\\Models\\User', 70),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 22);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_absensi`
--

CREATE TABLE `ms_absensi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menit` tinyint(4) NOT NULL,
  `keterangan` tinyint(4) DEFAULT NULL COMMENT '1 : datang, 2 : pulang',
  `kode_tunjangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengali` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_absensi`
--

INSERT INTO `ms_absensi` (`id`, `menit`, `keterangan`, `kode_tunjangan`, `pengali`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '1', '0.01', '2022-07-12 23:55:31', '2022-07-16 03:31:12'),
(2, 15, 1, '1', '0.015', '2022-07-12 23:55:31', '2022-07-16 03:31:22'),
(3, 30, 1, '1', '0.02', '2022-07-12 23:55:31', '2022-07-16 03:31:29'),
(4, 45, 1, '1', '0.025', '2022-07-12 23:55:31', '2022-07-16 03:31:37'),
(5, 60, 1, '1', '0.03', '2022-07-12 23:55:31', '2022-07-16 03:31:44'),
(6, 90, 1, NULL, NULL, '2022-07-12 23:55:31', '2022-07-12 23:55:31'),
(7, 120, 1, NULL, NULL, '2022-07-12 23:55:31', '2022-07-12 23:55:31'),
(9, 1, 2, '1', '0.01', '2022-07-12 23:55:31', '2022-07-13 00:09:31'),
(10, 15, 2, '1', '0.015', '2022-07-12 23:55:31', '2022-07-13 00:09:22'),
(11, 30, 2, '1', '0.02', '2022-07-12 23:55:31', '2022-07-13 00:08:12'),
(12, 45, 2, '1', '0.025', '2022-07-12 23:55:31', '2022-07-12 23:59:10'),
(13, 60, 2, '1', '0.03', '2022-07-12 23:55:31', '2022-07-12 23:59:28'),
(14, 90, 2, NULL, NULL, '2022-07-12 23:55:31', '2022-07-12 23:55:31'),
(15, 120, 2, NULL, NULL, '2022-07-12 23:55:31', '2022-07-12 23:55:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_lembur`
--

CREATE TABLE `ms_lembur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jam` tinyint(4) NOT NULL,
  `kode_tunjangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengali` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_lembur`
--

INSERT INTO `ms_lembur` (`id`, `jam`, `kode_tunjangan`, `pengali`, `created_at`, `updated_at`) VALUES
(1, 1, '1', '1.5 * 137', '2022-07-12 04:08:16', '2022-07-12 08:37:34'),
(2, 2, '1', '2 * 137', '2022-07-12 04:08:16', '2022-07-12 08:36:08'),
(3, 3, '1', '2 * 137', '2022-07-12 04:08:16', '2022-07-12 08:36:27'),
(4, 4, '1, 90', '1,5 * 180', '2022-07-12 04:08:16', '2022-07-12 10:21:37'),
(5, 5, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(6, 6, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(7, 7, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(8, 8, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(9, 9, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(10, 10, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(11, 11, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(12, 12, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(13, 13, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(14, 14, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(15, 15, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(16, 16, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(17, 17, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(18, 18, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(19, 19, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(20, 20, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(21, 21, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(22, 22, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(23, 23, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16'),
(24, 24, NULL, NULL, '2022-07-12 04:08:16', '2022-07-12 04:08:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_pengurangan`
--

CREATE TABLE `ms_pengurangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kurang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Rupiah, 2: Persen',
  `nilai` double NOT NULL,
  `kode_persen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 : gaji pokok, selainnya dari kode tambah',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_pengurangan`
--

INSERT INTO `ms_pengurangan` (`id`, `kode_kurang`, `nama`, `satuan`, `nilai`, `kode_persen`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123', 'BPJS Kesehatan', 2, 4, '60,1', '2022-07-12 10:44:11', '2022-08-29 05:05:28', NULL),
(2, '13', 'Iuran Pegawai', 1, 15000, '', '2022-07-17 00:18:44', '2022-07-17 00:18:44', NULL),
(3, '3', 'BP Jamsostek', 2, 2, '1', '2022-08-31 16:12:27', '2022-09-01 04:09:23', NULL),
(4, '12', 'Pinjam Koperasi DSM', 2, 300000, '1', '2023-02-21 03:02:31', '2023-03-14 09:08:27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_potongan`
--

CREATE TABLE `ms_potongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_potongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_tambahan`
--

CREATE TABLE `ms_tambahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_tambah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Rupiah, 1: Persen',
  `nilai` double NOT NULL,
  `kode_persen` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 : gaji pokok, selainnya dari kode tambah',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_tambahan`
--

INSERT INTO `ms_tambahan` (`id`, `kode_tambah`, `nama`, `satuan`, `nilai`, `kode_persen`, `created_at`, `updated_at`) VALUES
(6, '123', 'THR', 2, 100, '1,60', '2022-07-12 10:16:46', '2022-07-12 10:16:46'),
(7, '13', 'Uang Makan', 1, 450000, '', '2022-07-17 00:16:59', '2022-07-17 00:16:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_tunjangan`
--

CREATE TABLE `ms_tunjangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_tunjangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_tunjangan`
--

INSERT INTO `ms_tunjangan` (`id`, `kode_tunjangan`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '90', 'Tunjangan ABcd', '2022-07-11 23:57:11', '2022-08-31 15:56:49', '2022-08-31 15:56:49'),
(2, '31', 'Tunjangan Prestasi', '2022-07-11 23:57:16', '2022-08-31 15:56:44', '2022-08-31 15:56:44'),
(3, '60', 'Tunjangan Kinerja', '2022-07-11 23:57:20', '2022-08-31 15:56:39', '2022-08-31 15:56:39'),
(4, '1', 'Gaji Pokok', '2022-07-12 03:30:54', '2022-07-12 03:30:54', NULL),
(5, '2', 'Tunjangan Jabatan', '2022-07-14 10:17:22', '2022-07-14 10:17:22', NULL),
(6, '3', 'Tunjangan Istri dan Anak', '2022-08-31 15:56:58', '2022-08-31 15:56:58', NULL),
(7, '4', 'Tunjangan Jabatan', '2022-08-31 15:57:14', '2022-08-31 15:57:14', NULL),
(8, '5', 'Tunjangan Kesehatan', '2022-08-31 15:57:32', '2022-08-31 15:57:32', NULL),
(9, '6', 'Tunjangan Hari Tua', '2022-08-31 15:57:47', '2022-08-31 15:57:47', NULL),
(10, '7', 'Tunjangan Perumahan', '2022-08-31 15:58:00', '2022-08-31 15:58:00', NULL),
(11, '8', 'Tunjangan Makan', '2022-08-31 15:58:14', '2022-08-31 15:58:14', NULL),
(12, '9', 'Tunjangan Transportasi', '2022-08-31 15:58:26', '2022-08-31 15:58:26', NULL),
(13, '10', 'Tunjangan Kinerja', '2022-08-31 15:58:38', '2022-08-31 15:58:38', NULL),
(14, '11', 'Tunjangan Lembur', '2022-08-31 15:58:54', '2022-08-31 15:58:54', NULL),
(15, '12', 'Tunjangan Keahlian', '2022-08-31 15:59:06', '2022-08-31 15:59:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payroll_kurang`
--

CREATE TABLE `payroll_kurang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_payroll` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_kurang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payroll_kurang`
--

INSERT INTO `payroll_kurang` (`id`, `kode_payroll`, `nip`, `kode_kurang`, `keterangan`, `nilai`, `created_at`, `updated_at`) VALUES
(10, '20220717072145zEwdw8U01t', '28', '123', 'BPJS', 250000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(11, '20220717072145zEwdw8U01t', '28', '13', 'Iuran Pegawai', 15000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(12, '20220717072145zEwdw8U01t', '66', '123', 'BPJS', 30750, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(13, '20220717072145zEwdw8U01t', '66', '13', 'Iuran Pegawai', 15000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(14, '20220717072145zEwdw8U01t', '66', 'absensi-072022', 'Presensi 07 2022', 841824.94736842, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(15, '20220825213005eg4Ab3qwlt', '28', '123', 'BPJS', 250000, '2022-08-25 14:30:05', '2022-08-25 14:30:05'),
(16, '20220825213005eg4Ab3qwlt', '28', '13', 'Iuran Pegawai', 15000, '2022-08-25 14:30:05', '2022-08-25 14:30:05'),
(17, '202302221128231vIpCcviIi', '66', '13', 'Iuran Pegawai', 15000, '2023-02-22 04:28:24', '2023-02-22 04:28:24'),
(18, '202302221128231vIpCcviIi', '66', '3', 'BP Jamsostek', 24600, '2023-02-22 04:28:25', '2023-02-22 04:28:25'),
(19, '202302221128231vIpCcviIi', '28', '13', 'Iuran Pegawai', 15000, '2023-02-22 04:28:27', '2023-02-22 04:28:27'),
(20, '202302221128231vIpCcviIi', '28', '3', 'BP Jamsostek', 40000, '2023-02-22 04:28:27', '2023-02-22 04:28:27'),
(21, '20230309054918LSbeljJrJ8', '66', '13', 'Iuran Pegawai', 15000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(22, '20230309054918LSbeljJrJ8', '66', '3', 'BP Jamsostek', 24600, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(23, '20230309054918LSbeljJrJ8', '28', '13', 'Iuran Pegawai', 15000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(24, '20230309054918LSbeljJrJ8', '28', '3', 'BP Jamsostek', 40000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(25, '20230309054918LSbeljJrJ8', '10', '13', 'Iuran Pegawai', 15000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(26, '20230309054918LSbeljJrJ8', '10', '3', 'BP Jamsostek', 0, '2023-03-08 22:49:19', '2023-03-08 22:49:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payroll_tambah`
--

CREATE TABLE `payroll_tambah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_payroll` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_tambahan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payroll_tambah`
--

INSERT INTO `payroll_tambah` (`id`, `kode_payroll`, `nip`, `kode_tambahan`, `keterangan`, `nilai`, `created_at`, `updated_at`) VALUES
(35, '20220717072145zEwdw8U01t', '28', '123', 'THR', 10000000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(36, '20220717072145zEwdw8U01t', '28', '13', 'Uang Makan', 450000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(37, '20220717072145zEwdw8U01t', '66', '90', 'Tunjangan ABcd', 1230000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(38, '20220717072145zEwdw8U01t', '66', '123', 'THR', 1230000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(39, '20220717072145zEwdw8U01t', '66', '13', 'Uang Makan', 450000, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(40, '20220717072145zEwdw8U01t', '66', 'lembur-2022-07-01', 'Lembur', 0, '2022-07-17 00:21:45', '2022-07-17 00:21:45'),
(41, '20220825213005eg4Ab3qwlt', '28', '13', 'Uang Makan', 450000, '2022-08-25 14:30:05', '2022-08-25 14:30:05'),
(42, '202302221128231vIpCcviIi', '66', '90', NULL, 1230000, '2023-02-22 04:28:24', '2023-02-22 04:28:24'),
(43, '202302221128231vIpCcviIi', '66', '13', 'Uang Makan', 450000, '2023-02-22 04:28:24', '2023-02-22 04:28:24'),
(44, '202302221128231vIpCcviIi', '28', '13', 'Uang Makan', 450000, '2023-02-22 04:28:26', '2023-02-22 04:28:26'),
(45, '202302221128231vIpCcviIi', '28', '123', 'THR', 2000000, '2023-02-22 04:28:27', '2023-02-22 04:28:27'),
(46, '20230309054918LSbeljJrJ8', '66', '90', NULL, 1230000, '2023-03-08 22:49:18', '2023-03-08 22:49:18'),
(47, '20230309054918LSbeljJrJ8', '66', '13', 'Uang Makan', 450000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(48, '20230309054918LSbeljJrJ8', '28', '13', 'Uang Makan', 450000, '2023-03-08 22:49:19', '2023-03-08 22:49:19'),
(49, '20230309054918LSbeljJrJ8', '10', '13', 'Uang Makan', 450000, '2023-03-08 22:49:19', '2023-03-08 22:49:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_pendidikan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendidikan`
--

INSERT INTO `pendidikan` (`id`, `kode_pendidikan`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'SD', '2022-07-17 01:48:47', '2022-07-17 01:48:47', NULL),
(2, '2', 'SMP', '2022-07-26 03:14:02', '2022-07-26 03:14:02', NULL),
(3, '3', 'SMP', '2022-07-26 03:14:43', '2022-07-26 03:14:43', NULL),
(4, '4', 'SMA', '2022-07-26 03:14:56', '2022-07-26 03:14:56', NULL),
(5, '5', 'D1', '2022-07-26 03:15:05', '2022-07-26 03:15:05', NULL),
(6, '6', 'D3', '2022-07-26 03:15:14', '2022-07-26 03:15:14', NULL),
(7, '7', 'S1', '2022-07-26 03:15:22', '2022-07-26 03:15:22', NULL),
(8, '8', 'S2', '2022-07-26 03:15:31', '2022-07-26 03:15:31', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penghargaan`
--

CREATE TABLE `penghargaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_penghargaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penghargaan`
--

INSERT INTO `penghargaan` (`id`, `kode_penghargaan`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '01', 'Best Employee', '2023-04-03 14:43:32', '2023-04-03 14:43:32', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `deskripsi`, `file`, `created_at`, `updated_at`) VALUES
(1, 'Aplikasi HR System V.1.0', 'Aplikasi HR System V.1.0\r\n\r\nAplikasi HR System terlengkap', 'uploads/pengumuman/jY81ZqrUTiBO3eXc4yrqDZ3TF3mYDTCpMtNRT7FB.png', '2022-08-03 01:35:01', '2023-02-02 00:54:04'),
(2, 'Presensi Berdasarkan Radius Lokasi Kerja', 'Presensi Berdasarkan Radius Lokasi Kerja', 'uploads/pengumuman/nR4IXSWtQcNHMLyBuY2J8If8ilzsdHC6RPHhSEhL.jpg', '2022-08-03 01:34:24', '2022-08-03 01:34:24'),
(3, 'Besuk Libur', 'Hallo Besuk libur yah', 'uploads/pengumuman/eLrbSs4QcTN4eBmsZiIdTqz8LPXpMDyqXLf0oNEa.jpg', '2022-08-25 14:25:28', '2022-08-25 14:25:28'),
(7, 'Testing', 'testing', 'uploads/pengumuman/MLZn73jSNf1EvFVs8JB8CGbFLHgEchoxccI82TlM.png', '2023-04-05 06:39:42', '2023-04-05 06:39:42'),
(8, 'Test', 'Makan sahur dengan yang cantik', 'uploads/pengumuman/9ZvBirBMGtRnqhpRehFD373K0khgQLBHJHB7KJxo.jpg', '2023-04-11 12:47:36', '2023-04-11 12:47:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(19, 'App\\Models\\User', 3, 'auth-token', 'dc71f6be1f4efa4301329e4fb9c17b7bc116f44febe3c554a05ae1a4dfac104b', '[\"*\"]', NULL, '2022-06-29 10:41:06', '2022-06-29 10:41:06'),
(20, 'App\\Models\\User', 3, 'auth-token', '30ce096215c974927406d018ea756189e2e517987ef3719d59fde38998f84d47', '[\"*\"]', NULL, '2022-06-29 13:35:09', '2022-06-29 13:35:09'),
(21, 'App\\Models\\User', 3, 'auth-token', 'd000e2c775416dfd03d104665c95688b1391da853d4bf01b927203f5b5cc86f3', '[\"*\"]', '2022-07-03 07:08:16', '2022-06-29 13:57:16', '2022-07-03 07:08:16'),
(22, 'App\\Models\\User', 3, 'auth-token', '30c17eea7d7f1533c8c3743d2a8db7e3be283bd814744dd84f1e5a662490340b', '[\"*\"]', NULL, '2022-06-30 06:18:09', '2022-06-30 06:18:09'),
(23, 'App\\Models\\User', 3, 'auth-token', '8b711bb275daad245a8a5f893717fb2c336b004e00524d1b659dd52c511eb15e', '[\"*\"]', NULL, '2022-06-30 06:26:37', '2022-06-30 06:26:37'),
(24, 'App\\Models\\User', 3, 'auth-token', '9a89a48a29e75748b3629671edf61fd6130a012dedecd99f77ae6ffef5705d8d', '[\"*\"]', NULL, '2022-06-30 06:27:34', '2022-06-30 06:27:34'),
(25, 'App\\Models\\User', 3, 'auth-token', '95c0cef96d42689c1171065b202880e84e88ecd4ac6ec5a9143a4485431daef0', '[\"*\"]', NULL, '2022-06-30 12:09:04', '2022-06-30 12:09:04'),
(26, 'App\\Models\\User', 3, 'auth-token', '8e12f61b5307fdc30a92164c506b60e308d0d7385a995d6e16f0036d7fbc92ad', '[\"*\"]', NULL, '2022-06-30 12:24:04', '2022-06-30 12:24:04'),
(27, 'App\\Models\\User', 3, 'auth-token', 'b1d766632d831bfaaa05168a6c8ed305b7a7d66c8229e3acb0227425b97d18df', '[\"*\"]', NULL, '2022-06-30 13:17:14', '2022-06-30 13:17:14'),
(28, 'App\\Models\\User', 3, 'auth-token', '5e2ad4a04422796994b5a3ada600d30acc8d37a39906d55cbfcef156606c9c4b', '[\"*\"]', NULL, '2022-06-30 13:21:13', '2022-06-30 13:21:13'),
(29, 'App\\Models\\User', 3, 'auth-token', '480c6176d4fb3339954605637611f4bba43804692a9564f1a333bad5dbcd39eb', '[\"*\"]', NULL, '2022-06-30 13:21:53', '2022-06-30 13:21:53'),
(30, 'App\\Models\\User', 3, 'auth-token', 'caff027e3e3fb4b20e33b7777e0553290b4e31509307bcf39506f3d3aa21324d', '[\"*\"]', NULL, '2022-06-30 13:26:21', '2022-06-30 13:26:21'),
(31, 'App\\Models\\User', 3, 'auth-token', 'a9cef5f60f7aa93ecf0aa095f8f468a48a050e8f785dc123449eea357d238088', '[\"*\"]', NULL, '2022-06-30 13:26:46', '2022-06-30 13:26:46'),
(32, 'App\\Models\\User', 3, 'auth-token', 'cccef29b41d268cc5032c6349ef69039be8e8e96aafd02a6df36bfe303db7744', '[\"*\"]', NULL, '2022-06-30 13:27:12', '2022-06-30 13:27:12'),
(33, 'App\\Models\\User', 3, 'auth-token', '00c77d8ee896809f036b4960df9580eecc89f5e5a7e9bf6eb5b7e7a4ac4af912', '[\"*\"]', NULL, '2022-06-30 13:28:39', '2022-06-30 13:28:39'),
(34, 'App\\Models\\User', 3, 'auth-token', '7fda4d2a7a8bf65fdd933f7220204f9dd7472fed0dc2ad30e61f1fbd6ad6566e', '[\"*\"]', NULL, '2022-06-30 13:29:08', '2022-06-30 13:29:08'),
(35, 'App\\Models\\User', 3, 'auth-token', '7b6da3759a09aad8f9d23549beb730a3d7b66ab1e684a536f4903d184d28b9ae', '[\"*\"]', NULL, '2022-06-30 13:30:36', '2022-06-30 13:30:36'),
(36, 'App\\Models\\User', 3, 'auth-token', 'b6db3e2f4f2c6ae261a8b528f67d3d8e92f8a7a58ed4c2fddc5cd16f1595946e', '[\"*\"]', NULL, '2022-06-30 13:30:51', '2022-06-30 13:30:51'),
(37, 'App\\Models\\User', 3, 'auth-token', '2d5e6947dd297e53169470e68d16760323dc4a27605ea806c90c847ed1a8f01a', '[\"*\"]', NULL, '2022-06-30 13:31:09', '2022-06-30 13:31:09'),
(38, 'App\\Models\\User', 3, 'auth-token', '6911e61c204453c3aebab02ae3a83825c13c5f12c4c506998dab53a814a526f2', '[\"*\"]', NULL, '2022-06-30 13:33:58', '2022-06-30 13:33:58'),
(39, 'App\\Models\\User', 3, 'auth-token', 'f8a0bac8f6f3e063ce9caa636129e6ece9fea1e385ca057feb9314fa53779edd', '[\"*\"]', NULL, '2022-06-30 13:34:28', '2022-06-30 13:34:28'),
(40, 'App\\Models\\User', 3, 'auth-token', 'de814a52667e3d77314e0df215e524fa9ad6696c65f8881ca663503749e7ef72', '[\"*\"]', NULL, '2022-06-30 13:38:34', '2022-06-30 13:38:34'),
(41, 'App\\Models\\User', 3, 'auth-token', '4bc6f69280260752bf898d614be470073d9a1232e4923859df37171c192acb10', '[\"*\"]', NULL, '2022-06-30 13:43:33', '2022-06-30 13:43:33'),
(42, 'App\\Models\\User', 3, 'auth-token', '6a253d413f92d92e109948a6a4de824f521564b74fbf407597e34c6a53602a1a', '[\"*\"]', NULL, '2022-06-30 13:46:43', '2022-06-30 13:46:43'),
(43, 'App\\Models\\User', 3, 'auth-token', '11c2add0828d883cccded2588fd1cb99d11f8b77efb1faa804275bdcbbd1bfac', '[\"*\"]', NULL, '2022-06-30 13:54:55', '2022-06-30 13:54:55'),
(44, 'App\\Models\\User', 3, 'auth-token', '1fe2479d56f5ae177883ce5e8dcc1854b0f0121b6296d096adb5c1a8d1b6ec7a', '[\"*\"]', NULL, '2022-06-30 13:58:58', '2022-06-30 13:58:58'),
(45, 'App\\Models\\User', 3, 'auth-token', '980a8098adffecc688d31532b994fd2a0fa2fa826aadf3b37fa8fd5c63ad3c00', '[\"*\"]', NULL, '2022-06-30 14:15:38', '2022-06-30 14:15:38'),
(46, 'App\\Models\\User', 3, 'auth-token', '24afa07848108bb40ced5c5665624d652935d07650940e1872036d44d8eb9a0d', '[\"*\"]', NULL, '2022-06-30 14:21:00', '2022-06-30 14:21:00'),
(47, 'App\\Models\\User', 3, 'auth-token', '92be4cb4054e053f77e3ebd9ecdd6d07d20acf7a6ba63e00510ce6dd5dc0f828', '[\"*\"]', NULL, '2022-06-30 14:21:11', '2022-06-30 14:21:11'),
(48, 'App\\Models\\User', 3, 'auth-token', 'da7ff820c66d991c0a8de33f800b6149890c92896cfedfb111959b884dfcb3a9', '[\"*\"]', NULL, '2022-06-30 14:21:24', '2022-06-30 14:21:24'),
(49, 'App\\Models\\User', 3, 'auth-token', '36eb8dbbf1e22b919dfd51c49b7b62d124e55ceb5dcd36c80b407aa350f93be3', '[\"*\"]', NULL, '2022-06-30 14:21:39', '2022-06-30 14:21:39'),
(50, 'App\\Models\\User', 3, 'auth-token', 'ef0bc8973f1414235f69a379d06579d2a6e4acc0a4f0dc75453932214ccbc007', '[\"*\"]', NULL, '2022-06-30 14:21:49', '2022-06-30 14:21:49'),
(51, 'App\\Models\\User', 3, 'auth-token', 'ec6e78deaa0d9f7ac37c51b276555aa2465573922ef03c7f1749b37f0c80a7ec', '[\"*\"]', NULL, '2022-06-30 14:22:22', '2022-06-30 14:22:22'),
(52, 'App\\Models\\User', 3, 'auth-token', '5ea1be828dce66b7adadaf06c2b0f425f2bf2b9443519b915ad564fc6ae71a23', '[\"*\"]', NULL, '2022-06-30 14:22:33', '2022-06-30 14:22:33'),
(53, 'App\\Models\\User', 3, 'auth-token', 'e9bbf3f57ca3a7ec2c206d263520ac8814333ee401ff2b255c909eefead7abe6', '[\"*\"]', NULL, '2022-06-30 14:23:10', '2022-06-30 14:23:10'),
(54, 'App\\Models\\User', 3, 'auth-token', 'd5308de4bfc19908fc5a20bd3d9c07576fd1d2191feb1b072d06325a0be66f6c', '[\"*\"]', NULL, '2022-06-30 14:42:53', '2022-06-30 14:42:53'),
(56, 'App\\Models\\User', 3, 'auth-token', 'f9645681e31defff00eaebf84064db86ae883ab551a0b6cdd85f82a96dda2667', '[\"*\"]', NULL, '2022-06-30 14:49:51', '2022-06-30 14:49:51'),
(58, 'App\\Models\\User', 3, 'auth-token', 'b5d486d63fe28ee93800205aeafd1db529ded75ca461e4a632ab5f81a6e65443', '[\"*\"]', NULL, '2022-06-30 14:50:59', '2022-06-30 14:50:59'),
(59, 'App\\Models\\User', 3, 'auth-token', 'dc953bb872979a38167ec71b9ae9ae7a8a3b46e6f6e1d84f14cf1d9846d9d036', '[\"*\"]', '2022-07-01 04:59:06', '2022-06-30 23:32:49', '2022-07-01 04:59:06'),
(60, 'App\\Models\\User', 3, 'auth-token', '6cfdd1db4460f9f6fcb3640db0f6d6403136150469938e58525f1b88883e0b3f', '[\"*\"]', '2022-07-01 05:03:19', '2022-07-01 05:01:08', '2022-07-01 05:03:19'),
(61, 'App\\Models\\User', 3, 'auth-token', '535810ae155895757e9fb68706279cfba70bb5e6f971e8284e80567d273da131', '[\"*\"]', '2022-07-01 13:15:18', '2022-07-01 13:15:16', '2022-07-01 13:15:18'),
(62, 'App\\Models\\User', 3, 'auth-token', '3673768ac5ebd723d133010fa6f0a881e8fe708f06db385821ca71f08f4226e7', '[\"*\"]', '2022-07-01 13:17:27', '2022-07-01 13:15:49', '2022-07-01 13:17:27'),
(63, 'App\\Models\\User', 3, 'auth-token', '779cc65d2f1dcc23345ff5345869842b6d5ac0d03f981ef9e5cf503e0c6fc2ba', '[\"*\"]', '2022-07-01 13:18:06', '2022-07-01 13:18:05', '2022-07-01 13:18:06'),
(64, 'App\\Models\\User', 3, 'auth-token', '4142670bd6715074aa09a3da55b3e8099c9dd2be0307891c19861a77723e9b31', '[\"*\"]', '2022-07-01 14:28:13', '2022-07-01 13:24:11', '2022-07-01 14:28:13'),
(65, 'App\\Models\\User', 3, 'auth-token', '678ff8c2e99f0624c2a134e52ca0baf5f42e7ebd7228fa748506fb8451e700f5', '[\"*\"]', '2022-07-01 14:33:02', '2022-07-01 14:29:14', '2022-07-01 14:33:02'),
(66, 'App\\Models\\User', 3, 'auth-token', 'a4de238aff5c6a506e131c672abe522f3371c8d1cabca3b135039b1c1d119a94', '[\"*\"]', '2022-07-01 15:03:09', '2022-07-01 14:33:30', '2022-07-01 15:03:09'),
(67, 'App\\Models\\User', 3, 'auth-token', '18af0ee34ce152896cf8d8645ffaa906d71454d1319dbc1d871cf378efdf0271', '[\"*\"]', '2022-07-01 15:23:25', '2022-07-01 15:03:52', '2022-07-01 15:23:25'),
(68, 'App\\Models\\User', 3, 'auth-token', '8eaea6c87739f844b8af5ba421cbd2a016793c3312ea755cc5399fe81987a802', '[\"*\"]', '2022-07-01 15:49:39', '2022-07-01 15:27:02', '2022-07-01 15:49:39'),
(69, 'App\\Models\\User', 3, 'auth-token', '8a45d8c3a622a7a133d6cc8d3807bc1209e258c745c5682ac789c1c22ebe9961', '[\"*\"]', '2022-07-02 09:26:05', '2022-07-02 09:25:44', '2022-07-02 09:26:05'),
(70, 'App\\Models\\User', 3, 'auth-token', 'f3d2922c0e40397bf63b99ac4ceceab21e792348f9fcffd985397700c6160c54', '[\"*\"]', '2022-07-02 09:42:36', '2022-07-02 09:41:10', '2022-07-02 09:42:36'),
(71, 'App\\Models\\User', 3, 'auth-token', '4c1ed714998df5d52fcabf604e27016eebffdf0bb94ece231d1191369614ee84', '[\"*\"]', '2022-07-02 09:43:00', '2022-07-02 09:42:59', '2022-07-02 09:43:00'),
(72, 'App\\Models\\User', 3, 'auth-token', '77945bdb3388aca2befb5f722fc1176ae8fa3ee76b40edc0bce66d3e35cf2fe6', '[\"*\"]', '2022-07-02 09:43:12', '2022-07-02 09:43:11', '2022-07-02 09:43:12'),
(73, 'App\\Models\\User', 3, 'auth-token', 'b02115bfd32bb19523200945c9c0f3b60c7c006d20189a0d39db3abfc1a65349', '[\"*\"]', '2022-07-02 09:44:41', '2022-07-02 09:44:39', '2022-07-02 09:44:41'),
(74, 'App\\Models\\User', 3, 'auth-token', '907e724fbf609b509415d4728806b2b68aa7be8a8017c16600832c58b3e16eb7', '[\"*\"]', '2022-07-02 09:46:40', '2022-07-02 09:45:47', '2022-07-02 09:46:40'),
(75, 'App\\Models\\User', 3, 'auth-token', '0dd753d677366337ae13d7ab52c8463365c7cacc951d6bf2cb9cda2b3acae6dc', '[\"*\"]', '2022-07-02 09:58:06', '2022-07-02 09:56:56', '2022-07-02 09:58:06'),
(76, 'App\\Models\\User', 3, 'auth-token', '601834798b1d2a93f58fbcdc0f96d72b3de1471d01d5cf904005040341357247', '[\"*\"]', '2022-07-02 10:04:16', '2022-07-02 10:04:15', '2022-07-02 10:04:16'),
(77, 'App\\Models\\User', 3, 'auth-token', '139ce3e78699b9215bde81a3e6872a9e6e8e8e7d8761c35dbc801d8c201709a7', '[\"*\"]', '2022-07-02 10:04:25', '2022-07-02 10:04:24', '2022-07-02 10:04:25'),
(78, 'App\\Models\\User', 3, 'auth-token', 'f4fd80d483ba446b0b9cbd80aeef9b86034eaaef3c79f2f064c6e926a8caaa0a', '[\"*\"]', '2022-07-02 10:07:14', '2022-07-02 10:07:13', '2022-07-02 10:07:14'),
(79, 'App\\Models\\User', 3, 'auth-token', 'c7aa5a011b14f60e7f9f6aee4466278b94e6958e5acc4242b0d7b010e506c39b', '[\"*\"]', '2022-07-02 10:53:52', '2022-07-02 10:07:38', '2022-07-02 10:53:52'),
(80, 'App\\Models\\User', 3, 'auth-token', '4d828129043fb90c0ec00df577c5b094b17b764d728fa266a1e9d1916c35cba7', '[\"*\"]', '2022-07-02 10:56:03', '2022-07-02 10:56:02', '2022-07-02 10:56:03'),
(81, 'App\\Models\\User', 3, 'auth-token', 'dcf71ef5641b8ba332f46cef75436d7e93ddfbaa963f42f667f88c99cd0f308c', '[\"*\"]', '2022-07-02 11:06:49', '2022-07-02 11:06:46', '2022-07-02 11:06:49'),
(82, 'App\\Models\\User', 3, 'auth-token', '4e62785d27e0b1cad980beab8aaa0e7f0645fe20089b35aa9ab91001b0aa780b', '[\"*\"]', '2022-07-02 11:07:11', '2022-07-02 11:07:10', '2022-07-02 11:07:11'),
(83, 'App\\Models\\User', 3, 'auth-token', 'a71642700309fcfc07cb6e0e78e27cc7c25c282ba33257d53a94f06b3005c3fb', '[\"*\"]', '2022-07-02 11:07:35', '2022-07-02 11:07:34', '2022-07-02 11:07:35'),
(84, 'App\\Models\\User', 3, 'auth-token', 'ccaa7fe697f7bfa63c16a61035ce789ee6e0cc9a73836c8f71bc1b70a2ec6a07', '[\"*\"]', '2022-07-02 11:28:46', '2022-07-02 11:28:45', '2022-07-02 11:28:46'),
(85, 'App\\Models\\User', 3, 'auth-token', '314ed169c9623f584d5a1e461bd23f057eca92dccd32cb01872a6ec32b391592', '[\"*\"]', '2022-07-02 12:12:43', '2022-07-02 11:33:14', '2022-07-02 12:12:43'),
(86, 'App\\Models\\User', 3, 'auth-token', 'af25e659cbc07776163eadcb28fe163b8952ea0df065a24534ebfbb397411dbc', '[\"*\"]', '2022-07-02 12:20:50', '2022-07-02 12:19:35', '2022-07-02 12:20:50'),
(87, 'App\\Models\\User', 3, 'auth-token', '4e0b85e5dbd3af026f82d3635c4d56052a459bc058ae7fd0f5d2e39591d1af02', '[\"*\"]', '2022-07-02 12:23:57', '2022-07-02 12:23:32', '2022-07-02 12:23:57'),
(88, 'App\\Models\\User', 3, 'auth-token', '6e46a92f6bc92cf9f5f221895ad5781bec412f8bedc88721bef95d559ca67861', '[\"*\"]', '2022-07-02 13:06:25', '2022-07-02 13:06:15', '2022-07-02 13:06:25'),
(89, 'App\\Models\\User', 3, 'auth-token', '992fb57fe6431b46c649b526c4322c5ea7e719569e7be0719315af0b4e11cb07', '[\"*\"]', '2022-07-02 13:07:25', '2022-07-02 13:06:57', '2022-07-02 13:07:25'),
(90, 'App\\Models\\User', 3, 'auth-token', 'a17fc83292473f0a561c3dc2e397f812a7de7d3ab2d79347669c46d7967d8cab', '[\"*\"]', '2022-07-02 13:15:35', '2022-07-02 13:14:30', '2022-07-02 13:15:35'),
(91, 'App\\Models\\User', 3, 'auth-token', 'b12f78d3dc9d5811fbaf891ec0eba769de1817b2c0117cb0bd0b030c577f846f', '[\"*\"]', '2022-07-02 13:21:25', '2022-07-02 13:21:24', '2022-07-02 13:21:25'),
(92, 'App\\Models\\User', 3, 'auth-token', '7c4ee1a3258f704a884ec9b843ab14f5aae765ad28d11eba68506c269fc57f3f', '[\"*\"]', '2022-07-02 13:21:48', '2022-07-02 13:21:46', '2022-07-02 13:21:48'),
(93, 'App\\Models\\User', 3, 'auth-token', '45a2b0af052282fb1c3cfc1008b3c48407e47115b2026a3955cfd9c36d3bd38f', '[\"*\"]', '2022-07-02 13:32:50', '2022-07-02 13:25:01', '2022-07-02 13:32:50'),
(94, 'App\\Models\\User', 3, 'auth-token', 'b3df2466e09713e193cb96a9161222f39071f1019f0ed631f679d7a3af060f72', '[\"*\"]', '2022-07-02 13:37:41', '2022-07-02 13:33:01', '2022-07-02 13:37:41'),
(95, 'App\\Models\\User', 3, 'auth-token', '993c3dcf9990a11ab9525d096209d75fb6acebef75a36264162333c7789a516b', '[\"*\"]', '2022-07-02 13:40:21', '2022-07-02 13:38:10', '2022-07-02 13:40:21'),
(96, 'App\\Models\\User', 3, 'auth-token', '3eb0fa6baf5ed4157d37265a3c413f6d23763e42b01bbe515004c0606edce23c', '[\"*\"]', '2022-07-02 13:46:12', '2022-07-02 13:41:32', '2022-07-02 13:46:12'),
(97, 'App\\Models\\User', 3, 'auth-token', 'e42ed6183e0fc62cf4e8854b8dc095c4eda6a35a2f39c42125d6a69e15d64047', '[\"*\"]', '2022-07-02 13:49:02', '2022-07-02 13:46:27', '2022-07-02 13:49:02'),
(98, 'App\\Models\\User', 3, 'auth-token', '7ffb93c2cb360fa69ef6f4964843dc27f94a9cefcf6d2390e3351eed23de7ffa', '[\"*\"]', '2022-07-02 13:54:49', '2022-07-02 13:51:45', '2022-07-02 13:54:49'),
(99, 'App\\Models\\User', 3, 'auth-token', '46cd8b403fd2573b2beec20b8f03a9f36d9c797c7525186dad8ff97c21fc2b57', '[\"*\"]', '2022-07-17 00:33:05', '2022-07-17 00:32:35', '2022-07-17 00:33:05'),
(100, 'App\\Models\\User', 3, 'auth-token', 'd636dabfba8ed6f77878936c6c39d11af91ccdd7f9cc14f7d3731a454a9c1951', '[\"*\"]', '2022-07-17 02:29:05', '2022-07-17 02:26:42', '2022-07-17 02:29:05'),
(102, 'App\\Models\\User', 3, 'auth-token', '7019b579ac441614cc5cfc56b4ced04970c53e65dc82bc0bd1682e157f80f4b5', '[\"*\"]', '2022-07-18 02:15:11', '2022-07-18 02:15:01', '2022-07-18 02:15:11'),
(103, 'App\\Models\\User', 3, 'auth-token', '74ba8f3435458692eccdfafb330f1b4ba7753b6e7a68bfb02e81fe7199585327', '[\"*\"]', '2022-07-25 08:59:30', '2022-07-25 08:59:16', '2022-07-25 08:59:30'),
(104, 'App\\Models\\User', 3, 'auth-token', '901424503a7a9eae559df30d611fa93bdb7f613bbd9c365608670129242967b8', '[\"*\"]', '2022-07-25 22:41:58', '2022-07-25 22:41:43', '2022-07-25 22:41:58'),
(105, 'App\\Models\\User', 3, 'auth-token', '85c9a1eebe988b3487ce37dbd6c75b6d9189e3077b7419c8631c12bd1e75a4f1', '[\"*\"]', '2022-07-28 05:42:30', '2022-07-28 05:42:20', '2022-07-28 05:42:30'),
(106, 'App\\Models\\User', 3, 'auth-token', '7bb78033a439f54b24d3897ea0428316fc5ef4ee93b0519cdc51b22fa34793a6', '[\"*\"]', '2022-07-29 15:44:18', '2022-07-29 15:42:04', '2022-07-29 15:44:18'),
(107, 'App\\Models\\User', 3, 'auth-token', 'b51981d656653d9a60b44863b4fa270514f09ecab81bfab6e391b80b35330598', '[\"*\"]', NULL, '2022-07-29 23:33:30', '2022-07-29 23:33:30'),
(108, 'App\\Models\\User', 3, 'auth-token', '933240744e265ce8aa20e3b0f2b343d6d3ed36f033461c795eaf6ec1e8fe7068', '[\"*\"]', '2022-07-30 00:08:28', '2022-07-29 23:35:36', '2022-07-30 00:08:28'),
(110, 'App\\Models\\User', 3, 'auth-token', '04f94f817b9882fb6e135c2a30827c158997f4f734cf65adcb1e3ae271932b1f', '[\"*\"]', '2022-08-04 03:07:07', '2022-07-30 00:31:16', '2022-08-04 03:07:07'),
(113, 'App\\Models\\User', 3, 'auth-token', 'c09ca151bb1cb439151cc5d1a7edde122c233af3b4ae6079a1c4e6fa99af6ec2', '[\"*\"]', '2022-08-03 08:59:35', '2022-08-03 08:59:25', '2022-08-03 08:59:35'),
(115, 'App\\Models\\User', 3, 'auth-token', 'ae566695b848bed94f562c9d590d84acdc2f23f9c75a82d69a26634cfa34c2ec', '[\"*\"]', '2022-08-03 09:03:26', '2022-08-03 09:03:26', '2022-08-03 09:03:26'),
(117, 'App\\Models\\User', 4, 'auth-token', 'f60cc62ccc866980f6b88959d761be0dfbb37f8a174b61e50a6d2bba7b0bd9ce', '[\"*\"]', NULL, '2022-08-03 09:09:12', '2022-08-03 09:09:12'),
(119, 'App\\Models\\User', 2, 'auth-token', '855781cfc85dce5c75f85e63d00099269d0784e9b39439120bedef035db50911', '[\"*\"]', '2022-08-03 09:13:34', '2022-08-03 09:11:19', '2022-08-03 09:13:34'),
(120, 'App\\Models\\User', 4, 'auth-token', '8a8f4a5e5d03b6170b9b062fb0d9149feb6a2d10fc05cb24c4af3c85e5eaafdf', '[\"*\"]', NULL, '2022-08-03 09:12:07', '2022-08-03 09:12:07'),
(121, 'App\\Models\\User', 4, 'auth-token', '0d275a13772f19a9a9e06b3b58f085ff7e37f7ed93bd498c85ef50b341880eb6', '[\"*\"]', NULL, '2022-08-03 09:12:10', '2022-08-03 09:12:10'),
(122, 'App\\Models\\User', 3, 'auth-token', '900ba2e8cf41ae3cab7f3a361567ac17b0b3b2e8d9080449bbe4fcfd2a4e85f9', '[\"*\"]', '2022-08-03 16:58:14', '2022-08-03 16:58:13', '2022-08-03 16:58:14'),
(124, 'App\\Models\\User', 3, 'auth-token', 'e4e7ce064684d7a5ef84942426a87d0eb511f31239b93f9a73fad2b4afe6b7dc', '[\"*\"]', '2022-08-04 04:15:47', '2022-08-04 04:14:23', '2022-08-04 04:15:47'),
(125, 'App\\Models\\User', 3, 'auth-token', '4a7811948923e32f258b420b4c0713f83dadb1250a8fb6a8d5a83adbfe3cfc98', '[\"*\"]', '2022-08-04 04:15:57', '2022-08-04 04:15:55', '2022-08-04 04:15:57'),
(126, 'App\\Models\\User', 3, 'auth-token', '7107cef515d66f486ab89f91ce2e9c3793bf4bc661b77bab15d255bf9ad26775', '[\"*\"]', '2022-08-28 02:38:16', '2022-08-28 02:36:59', '2022-08-28 02:38:16'),
(127, 'App\\Models\\User', 3, 'auth-token', '23329fbd6a232f1025abba7b5d04e70bc8a000b84720d6320fb70f187a94fe58', '[\"*\"]', '2022-08-28 02:50:07', '2022-08-28 02:48:20', '2022-08-28 02:50:07'),
(128, 'App\\Models\\User', 3, 'auth-token', '455ea085e5229fc509d1ccd737508bfb9ca18e96bf1ad63dc4570a2f51f17007', '[\"*\"]', '2022-10-01 04:14:49', '2022-08-28 02:52:36', '2022-10-01 04:14:49'),
(129, 'App\\Models\\User', 3, 'auth-token', '58907d7c8e02df6130f3d5b9f175901b6f474196df1e83b0406477a222f43a6e', '[\"*\"]', '2022-08-29 00:15:26', '2022-08-28 23:19:08', '2022-08-29 00:15:26'),
(130, 'App\\Models\\User', 3, 'auth-token', '38b951e578d0e2c6fff0ee66869f1c0b10fa50780032cc8bac585ab5352995ee', '[\"*\"]', '2022-09-07 06:58:25', '2022-09-01 00:23:12', '2022-09-07 06:58:25'),
(131, 'App\\Models\\User', 1, 'auth-token', 'b075cc4e0d51258070cf1c0c524ffcdc28fe4c77eb35071206e3519666efb0cf', '[\"*\"]', '2022-11-05 16:56:28', '2022-09-02 14:14:23', '2022-11-05 16:56:28'),
(132, 'App\\Models\\User', 3, 'auth-token', '8ad23d7d385125276d007c3f2940a5fd8d6a761efc5864c142f2defd07a30142', '[\"*\"]', '2022-09-04 04:30:32', '2022-09-04 04:29:53', '2022-09-04 04:30:32'),
(133, 'App\\Models\\User', 1, 'auth-token', '87be724745572b8d09abc2f2b6b4cb0b727e64348dd3a3145fedc530e8d77c94', '[\"*\"]', '2022-09-05 09:29:16', '2022-09-05 09:27:43', '2022-09-05 09:29:16'),
(137, 'App\\Models\\User', 3, 'auth-token', '250e55e1e2f43b63225d67c52411537eb32dd03e472bc08a69a8095459b8f1a3', '[\"*\"]', '2022-09-23 06:39:06', '2022-09-22 14:33:03', '2022-09-23 06:39:06'),
(138, 'App\\Models\\User', 3, 'auth-token', '978d19a0a551291dacb83a47d378f957cc69c69b2b90bf67f46c0bbd7bcb78be', '[\"*\"]', '2022-11-14 10:10:22', '2022-10-20 05:42:22', '2022-11-14 10:10:22'),
(140, 'App\\Models\\User', 3, 'auth-token', '663d3cc7b338a9f95753275c51a54376801a4004dfa19de267b1a1934e20fd74', '[\"*\"]', '2023-01-09 07:21:01', '2022-11-08 15:14:02', '2023-01-09 07:21:01'),
(141, 'App\\Models\\User', 3, 'auth-token', '3d9acb5771073ec235a9b0dd85962a163c7eba956ee6367d1b18d162324812dc', '[\"*\"]', '2022-11-19 06:02:16', '2022-11-19 06:02:11', '2022-11-19 06:02:16'),
(143, 'App\\Models\\User', 3, 'auth-token', '8f08926c7412d8b890762e7847f5d071bbc20aa508cc43c9669a975533e9a386', '[\"*\"]', NULL, '2023-03-01 21:16:51', '2023-03-01 21:16:51'),
(144, 'App\\Models\\User', 3, 'auth-token', '9414b2d8238562b45c5e0af613926c8698874fa0e18caa60be534d66f4ded2a9', '[\"*\"]', '2023-03-02 06:19:12', '2023-03-01 23:04:55', '2023-03-02 06:19:12'),
(145, 'App\\Models\\User', 3, 'auth-token', 'fbd6dc3a4d940eb968cbe4d31b94e8725f22abbb98079db80b8bb8a90cc28af2', '[\"*\"]', '2023-03-02 02:12:33', '2023-03-02 02:11:57', '2023-03-02 02:12:33'),
(146, 'App\\Models\\User', 3, 'auth-token', '12bc414ec168686bde9e278b61dbf4432e56bda55af20c0fc13b07cf7816058b', '[\"*\"]', '2023-03-02 02:24:45', '2023-03-02 02:21:04', '2023-03-02 02:24:45'),
(147, 'App\\Models\\User', 3, 'auth-token', 'b3a2927cb844249ba2e34faf9ff7985e075c11665150703e15dabe642d88ec68', '[\"*\"]', '2023-03-07 11:54:48', '2023-03-02 06:20:29', '2023-03-07 11:54:48'),
(148, 'App\\Models\\User', 3, 'auth-token', 'f2b10e8e198dfe108906f9b22c426a4d5a6773ba742be9e79c762bed719bbaf4', '[\"*\"]', NULL, '2023-03-03 06:07:12', '2023-03-03 06:07:12'),
(149, 'App\\Models\\User', 3, 'auth-token', '8e4c99b48af25b973e41f2e9ecd9ca6ffd167840df775243c8d3839cb2db78bc', '[\"*\"]', NULL, '2023-03-03 11:11:41', '2023-03-03 11:11:41'),
(150, 'App\\Models\\User', 3, 'auth-token', '656301959b202f82dc908d493b6edd0ce6ff8d06e3ff133b6e63c43ca47f21bf', '[\"*\"]', NULL, '2023-03-03 11:33:12', '2023-03-03 11:33:12'),
(151, 'App\\Models\\User', 2, 'auth-token', '1e784f058884e84e323c52fbec411322f7e96b5d244a6792d49a32bed0ba71b5', '[\"*\"]', '2023-03-08 07:59:08', '2023-03-08 07:55:25', '2023-03-08 07:59:08'),
(152, 'App\\Models\\User', 3, 'auth-token', 'fc9ab849a56474a4841b9e4a3e2f7df9f6bef86d2186662c5f5f793622b7c7e3', '[\"*\"]', '2023-03-14 06:16:45', '2023-03-08 22:52:12', '2023-03-14 06:16:45'),
(153, 'App\\Models\\User', 3, 'auth-token', 'e75558b2d310f13eaf0732302ea4970cab3942bb1bc9416a6074a0a36c2f7e32', '[\"*\"]', NULL, '2023-03-13 00:06:10', '2023-03-13 00:06:10'),
(154, 'App\\Models\\User', 3, 'auth-token', '240cdabb80727096bfc773ec7ce6a680ca487a5186b7804a25b7e909f4c67522', '[\"*\"]', NULL, '2023-03-13 01:54:31', '2023-03-13 01:54:31'),
(155, 'App\\Models\\User', 3, 'auth-token', '7a9c84e26d9b13bebddd8a9f3990cdcdc79741c9ce756c8a187323374ea4eb7b', '[\"*\"]', '2023-03-14 07:14:33', '2023-03-13 03:18:05', '2023-03-14 07:14:33'),
(156, 'App\\Models\\User', 2, 'auth-token', '5562c6c1d53b1c04b77a72c4f9ef685d131a880dc3a045715efbd588d8f883ef', '[\"*\"]', '2023-03-14 07:08:05', '2023-03-13 04:57:01', '2023-03-14 07:08:05'),
(157, 'App\\Models\\User', 3, 'auth-token', 'fff0afd8b2582790501bf82489318c3bbd68b245d88f63ae8ff6a2b5ffc2a25b', '[\"*\"]', '2023-03-14 07:01:00', '2023-03-13 11:21:58', '2023-03-14 07:01:00'),
(158, 'App\\Models\\User', 2, 'auth-token', 'b67a0105f3f3907a2e785c0d0c592ab8b40e436de1b6ed3f8cb28ba599867325', '[\"*\"]', '2023-03-13 21:43:32', '2023-03-13 16:29:41', '2023-03-13 21:43:32'),
(159, 'App\\Models\\User', 3, 'auth-token', '4221e72546107f4cb4b4e4591435e2254aed9471a1d73c608d4850deefbe004e', '[\"*\"]', NULL, '2023-03-14 06:27:25', '2023-03-14 06:27:25'),
(160, 'App\\Models\\User', 3, 'auth-token', '5044e09a3e45a637d19853361578f4d56e8dcf21e101b08f3845f97bcadc224e', '[\"*\"]', NULL, '2023-03-14 06:32:03', '2023-03-14 06:32:03'),
(161, 'App\\Models\\User', 3, 'auth-token', 'c6152a704c9698bd30458b8be30d3b159c2fad6ce6f77834b19cd81d71a86c49', '[\"*\"]', NULL, '2023-03-14 06:32:13', '2023-03-14 06:32:13'),
(162, 'App\\Models\\User', 3, 'auth-token', '0c4249323498e1964e6c919499e5ac05be754a2115e997a6e4adb5b9ee34bdc5', '[\"*\"]', NULL, '2023-03-14 06:32:20', '2023-03-14 06:32:20'),
(163, 'App\\Models\\User', 3, 'auth-token', 'fe411df54425acafc59654cdc8ada336b4d9330d8c1e848be659f6de23116d6f', '[\"*\"]', NULL, '2023-03-14 06:33:30', '2023-03-14 06:33:30'),
(164, 'App\\Models\\User', 3, 'auth-token', '2a786b0d0eb5fe2fdc5c38fbf5811ad495e031afbff9fddaaf94d87664f77ecd', '[\"*\"]', NULL, '2023-03-14 06:34:08', '2023-03-14 06:34:08'),
(165, 'App\\Models\\User', 3, 'auth-token', '491df0146c0599aa553eea999216aa4e6af9ddcca2f8cc111fd1c4dc6f726066', '[\"*\"]', NULL, '2023-03-14 06:34:31', '2023-03-14 06:34:31'),
(166, 'App\\Models\\User', 3, 'auth-token', '5406f256564a704742aad38c44771322b010bc105d86378e3d41d4dcfea5104f', '[\"*\"]', NULL, '2023-03-14 06:41:49', '2023-03-14 06:41:49'),
(167, 'App\\Models\\User', 3, 'auth-token', '4c98a85894710f45cf718b34bcd2c7efde38132e1d118786ff3354835a86bc8f', '[\"*\"]', NULL, '2023-03-14 06:45:50', '2023-03-14 06:45:50'),
(168, 'App\\Models\\User', 3, 'auth-token', '0a481fbffd9f9e01a616e201043d40074c2b0beea6f5ae60679e1bb55a92a3e3', '[\"*\"]', '2023-03-14 07:06:42', '2023-03-14 07:02:36', '2023-03-14 07:06:42'),
(169, 'App\\Models\\User', 3, 'auth-token', 'be696659086391083613d98df2e08d8915dfc4896008a27f73aece0b7ff70a57', '[\"*\"]', '2023-03-14 07:27:02', '2023-03-14 07:04:24', '2023-03-14 07:27:02'),
(170, 'App\\Models\\User', 2, 'auth-token', '0ac3e471651c8ba51d754865dd1e83e9a209179869598445e4a97b52a2abfb47', '[\"*\"]', '2023-03-14 07:57:01', '2023-03-14 07:09:58', '2023-03-14 07:57:01'),
(171, 'App\\Models\\User', 2, 'auth-token', '1efc811d55bf1fdbe06337482e04d31cb6c173a3676c838f3ffb58994c3e409a', '[\"*\"]', '2023-03-28 06:48:08', '2023-03-14 07:45:51', '2023-03-28 06:48:08'),
(172, 'App\\Models\\User', 2, 'auth-token', 'b5eac877310379a1ea4434b011515b3970ab3fecbc51b437f5d06ab5edd001da', '[\"*\"]', NULL, '2023-03-14 08:02:00', '2023-03-14 08:02:00'),
(173, 'App\\Models\\User', 2, 'auth-token', '881d999eb168c3a3d6eac85a0bd5e3a8028ae51e537d02200ba15cbad895aa00', '[\"*\"]', '2023-03-14 08:05:43', '2023-03-14 08:02:03', '2023-03-14 08:05:43'),
(174, 'App\\Models\\User', 2, 'auth-token', '30b1b0483d9517c1ff0e767b7c25cc1ce8b067656cf9689b9575641c351e08b7', '[\"*\"]', NULL, '2023-03-14 08:04:42', '2023-03-14 08:04:42'),
(175, 'App\\Models\\User', 2, 'auth-token', 'ecb953cf4a600b0ac3acef16325bf40483a9bd4dc970d5b05c0f39030486c5b9', '[\"*\"]', NULL, '2023-03-14 08:04:49', '2023-03-14 08:04:49'),
(176, 'App\\Models\\User', 2, 'auth-token', '7e98fdede1830649549634475780a31bd10019e47e3249c174510bf25ad63a3a', '[\"*\"]', NULL, '2023-03-14 08:14:56', '2023-03-14 08:14:56'),
(177, 'App\\Models\\User', 2, 'auth-token', '48a18e558615bcdf535eba0495932c8d3e938f7e9a56c7840410058d61644390', '[\"*\"]', '2023-03-14 08:15:58', '2023-03-14 08:15:09', '2023-03-14 08:15:58'),
(178, 'App\\Models\\User', 2, 'auth-token', 'cd3f9db03e58400247f102a3ac4903e203d20d34ef87feb137801b606058dbd7', '[\"*\"]', '2023-03-14 08:16:45', '2023-03-14 08:16:43', '2023-03-14 08:16:45'),
(179, 'App\\Models\\User', 2, 'auth-token', '1dcca15b4ec8f806317cd25f572d97654c990445ba0b0faa4877d81f832d46b9', '[\"*\"]', '2023-03-21 00:24:47', '2023-03-14 08:18:14', '2023-03-21 00:24:47'),
(180, 'App\\Models\\User', 2, 'auth-token', '75755550e1fb32582ac07cb15d8c8cbd83d1d30e3ab18c1331024ce8f249eebf', '[\"*\"]', '2023-04-03 06:38:09', '2023-03-14 08:34:08', '2023-04-03 06:38:09'),
(181, 'App\\Models\\User', 2, 'auth-token', 'b957370479c183be2edc2d2396c2386d6b266711eedd55ea4eadf805ec0b6072', '[\"*\"]', '2023-03-21 02:45:51', '2023-03-21 02:01:51', '2023-03-21 02:45:51'),
(182, 'App\\Models\\User', 2, 'auth-token', 'd0ae323fe753633a00b380edc1c080cd57af9980b5cc23d6c28809d0dbae889d', '[\"*\"]', '2023-03-26 20:28:26', '2023-03-22 02:11:37', '2023-03-26 20:28:26'),
(183, 'App\\Models\\User', 2, 'auth-token', '054aca242eb073243d906294bd19c00a44cdd4b6edb1232a3930096206326667', '[\"*\"]', '2023-03-22 04:19:46', '2023-03-22 04:10:11', '2023-03-22 04:19:46'),
(184, 'App\\Models\\User', 2, 'auth-token', 'f41e5ab527b4c46dd10bcec0e720682b642f24553ba8a563e5d3c27f076cd83c', '[\"*\"]', '2023-03-22 04:11:24', '2023-03-22 04:11:19', '2023-03-22 04:11:24'),
(185, 'App\\Models\\User', 2, 'auth-token', 'e228d6b5e3c56320a07f96f7f42dce173a928b3954b2feec4106315a9eb02ec3', '[\"*\"]', NULL, '2023-03-22 08:30:06', '2023-03-22 08:30:06'),
(186, 'App\\Models\\User', 2, 'auth-token', 'ce3432a238a30f4326ac97b464d7d1579dccf571a0b68b4259fc37d80266c4b2', '[\"*\"]', NULL, '2023-03-26 12:57:52', '2023-03-26 12:57:52'),
(187, 'App\\Models\\User', 2, 'auth-token', '7a5ae309fb796fec5ac46e190acb3de997753d2eec88abfd15c7ed5919a35dc0', '[\"*\"]', NULL, '2023-03-26 13:14:29', '2023-03-26 13:14:29'),
(188, 'App\\Models\\User', 2, 'auth-token', '0ba7ee80763ca07ca253e206e06e6029898b4e6a6a1276abfa3fe2bc6a271284', '[\"*\"]', '2023-03-26 17:35:02', '2023-03-26 16:58:11', '2023-03-26 17:35:02'),
(189, 'App\\Models\\User', 4, 'auth-token', '3a0236ab5f26d1ba4c6e86a0c44bcca639bfa2cf0ff95b96f1047335d24a7607', '[\"*\"]', '2023-03-26 20:30:29', '2023-03-26 20:30:07', '2023-03-26 20:30:29'),
(190, 'App\\Models\\User', 2, 'auth-token', '9ada781f6caab3345d266acf59cf9d6a3b07b8d06206de429f760e6931d004f7', '[\"*\"]', '2023-03-27 03:18:47', '2023-03-27 03:17:19', '2023-03-27 03:18:47'),
(191, 'App\\Models\\User', 2, 'auth-token', 'd91b55d25eba22aa257797d8b905f0189c5a9ea023d9cd74e7d9fb9f972b1715', '[\"*\"]', '2023-03-27 03:45:01', '2023-03-27 03:19:26', '2023-03-27 03:45:01'),
(192, 'App\\Models\\User', 2, 'auth-token', 'e25a0c88af2e9988b1eb48372c2398fee617a3f0a15169852ee595dec8718d34', '[\"*\"]', '2023-03-28 04:20:18', '2023-03-28 04:19:31', '2023-03-28 04:20:18'),
(193, 'App\\Models\\User', 2, 'auth-token', '45af39d2d7ff34721bf2150dd2c85dc9acd8c18b5a2018314ddd79d6788a23eb', '[\"*\"]', '2023-04-13 02:31:38', '2023-03-28 05:16:53', '2023-04-13 02:31:38'),
(194, 'App\\Models\\User', 2, 'auth-token', 'de3c09dc24ffbb4381d559e4822aceee05ed61e5aeb3e1cd8ae8d146967e8c71', '[\"*\"]', '2023-03-28 05:44:36', '2023-03-28 05:43:58', '2023-03-28 05:44:36'),
(196, 'App\\Models\\User', 2, 'auth-token', '14d9c2ce73bb7d06b61a1b5231dc8a0cf6eff5e4b7c6bcc6f5ae6bbeb11fc3ef', '[\"*\"]', NULL, '2023-03-28 07:14:25', '2023-03-28 07:14:25'),
(198, 'App\\Models\\User', 2, 'auth-token', 'c3db90313ea0980345e46693ac65e3ca357f92f29b9c0cc60e5142e626140831', '[\"*\"]', '2023-03-28 13:23:47', '2023-03-28 07:26:20', '2023-03-28 13:23:47'),
(203, 'App\\Models\\User', 4, 'auth-token', '37bea83c54902997d85c2006129a48f6ea5fdd14d7a8fe00fb93a6a5fc99bcec', '[\"*\"]', '2023-04-03 04:19:51', '2023-03-28 14:14:40', '2023-04-03 04:19:51'),
(204, 'App\\Models\\User', 2, 'auth-token', '20da8b2f3353ea57720e15505542a2f83e97a676e953c6f34e1caf9da2296cfb', '[\"*\"]', '2023-04-03 07:14:50', '2023-03-28 18:04:13', '2023-04-03 07:14:50'),
(205, 'App\\Models\\User', 2, 'auth-token', '35c9773a6d82eeb181d1dbb729e3f9c9e811a3b8be49beb85e685aba86449008', '[\"*\"]', '2023-04-03 01:10:44', '2023-04-03 01:09:41', '2023-04-03 01:10:44'),
(206, 'App\\Models\\User', 2, 'auth-token', '1e78568aab757a9787857d00d69fcfcdff61cabeb5d99b99943a42bd05118dbe', '[\"*\"]', '2023-04-03 05:10:01', '2023-04-03 04:26:14', '2023-04-03 05:10:01'),
(207, 'App\\Models\\User', 2, 'auth-token', '6785728256acdeb460f51dc7e9362394353fb7cd3661a820053568ce95cd4aea', '[\"*\"]', '2023-04-03 07:00:01', '2023-04-03 05:12:42', '2023-04-03 07:00:01'),
(208, 'App\\Models\\User', 2, 'auth-token', 'c378ce482dacf6bdb48bd87d3e56695d0b89ddd813e3c8d0fef6812d2c776d4a', '[\"*\"]', '2023-04-06 08:14:33', '2023-04-03 06:26:18', '2023-04-06 08:14:33'),
(209, 'App\\Models\\User', 2, 'auth-token', '10c4bff40376df07e39877fbbce5d6b449be48ad91bebd291a4019dff14acc0c', '[\"*\"]', '2023-04-05 06:34:44', '2023-04-03 06:39:32', '2023-04-05 06:34:44'),
(210, 'App\\Models\\User', 2, 'auth-token', '08cafabcc3bca9a4fa22a6561e80613a9fc7c21457c4049ca514daf6329b8164', '[\"*\"]', '2023-04-03 07:19:35', '2023-04-03 07:00:44', '2023-04-03 07:19:35'),
(211, 'App\\Models\\User', 2, 'auth-token', '657d5e1ae3778e348d7a00e65a8e4f6dcc643feb9342ee87ff124fd2ea0bec3b', '[\"*\"]', '2023-04-03 14:07:09', '2023-04-03 07:17:06', '2023-04-03 14:07:09'),
(212, 'App\\Models\\User', 2, 'auth-token', '29c9393937c498010e3bc93461b1271e2a1ee5cc5f5900d4d0f093855bd6302c', '[\"*\"]', '2023-04-03 07:21:50', '2023-04-03 07:20:20', '2023-04-03 07:21:50'),
(213, 'App\\Models\\User', 2, 'auth-token', 'a529d8501f2041bed57952ad2f8010e2bd024802e5e9180cd93a8b76ff69c661', '[\"*\"]', '2023-04-03 07:56:01', '2023-04-03 07:55:15', '2023-04-03 07:56:01'),
(214, 'App\\Models\\User', 2, 'auth-token', '8897acb9cbe5e8e0b9733b9f5743f66905dcc835654003772869273f4d2bd5a9', '[\"*\"]', '2023-04-05 07:25:26', '2023-04-03 08:37:17', '2023-04-05 07:25:26'),
(215, 'App\\Models\\User', 2, 'auth-token', '9cb2afa0eb47559ff63d11e9e804d339559c79f20bff3b229b70f092d3c61648', '[\"*\"]', '2023-04-12 14:43:16', '2023-04-04 01:24:45', '2023-04-12 14:43:16'),
(216, 'App\\Models\\User', 2, 'auth-token', 'bbc7131c6a01d2d7fa6e59d430f925b21d2b3e3c2d0b108cf7b6ffa719823c1a', '[\"*\"]', NULL, '2023-04-05 02:35:42', '2023-04-05 02:35:42'),
(217, 'App\\Models\\User', 2, 'auth-token', '559f39b80ba58ee4f2511a542fccff5974bbb8ae26525cf6e62eea6504248966', '[\"*\"]', NULL, '2023-04-05 02:38:21', '2023-04-05 02:38:21'),
(218, 'App\\Models\\User', 2, 'auth-token', '1d5d7fe8e5a2274251910309744584609cb6586c74b9d93f46c9591e1aa7b1b9', '[\"*\"]', '2023-04-06 08:36:32', '2023-04-06 07:34:51', '2023-04-06 08:36:32'),
(219, 'App\\Models\\User', 2, 'auth-token', '30b7ee20749fe72bde7e985712acfa182cf38921f3b19ea23f9f888f4d7cd3df', '[\"*\"]', '2023-04-06 07:55:05', '2023-04-06 07:43:01', '2023-04-06 07:55:05'),
(220, 'App\\Models\\User', 2, 'auth-token', '55f793145cad9bd1d25830726e516a6a2ed6e7ba5fbe6f31ec4f3ab0c15d3ca9', '[\"*\"]', '2023-04-06 07:58:28', '2023-04-06 07:48:25', '2023-04-06 07:58:28'),
(221, 'App\\Models\\User', 2, 'auth-token', 'f175df7135963e56001f8a49f4a9f518125aa499de93211f737e267903e339dd', '[\"*\"]', '2023-04-06 08:06:56', '2023-04-06 07:56:31', '2023-04-06 08:06:56'),
(222, 'App\\Models\\User', 2, 'auth-token', '7f40346c083272deb319c4dc355d089d25e4ac69d4c9ff84fbf5d998cb223e5c', '[\"*\"]', NULL, '2023-04-06 08:01:52', '2023-04-06 08:01:52'),
(223, 'App\\Models\\User', 2, 'auth-token', 'b74ed72f29e4bf65e9d7caba245788f5ca8407d9773e879a274326de0c6304f3', '[\"*\"]', '2023-04-08 03:32:12', '2023-04-06 08:07:11', '2023-04-08 03:32:12'),
(224, 'App\\Models\\User', 2, 'auth-token', '3f120f0ba336a9d974b319066f35d69bd9473deda7af8f2dba909ef84e199e32', '[\"*\"]', '2023-04-08 14:31:09', '2023-04-06 08:38:42', '2023-04-08 14:31:09'),
(225, 'App\\Models\\User', 2, 'auth-token', '9b92e4abfad3d256ebb1e45be905c523b1769f117ec617c0ab2a3b3b37d46a6f', '[\"*\"]', '2023-04-09 14:01:16', '2023-04-09 13:58:34', '2023-04-09 14:01:16'),
(226, 'App\\Models\\User', 2, 'auth-token', '6de7966a8a74fcf917031da1d03f2633240eee59b25d21cde6d3e0de7d958edc', '[\"*\"]', '2023-04-12 07:36:47', '2023-04-09 14:11:37', '2023-04-12 07:36:47'),
(227, 'App\\Models\\User', 2, 'auth-token', '27ffb72f1a6355286fbc36659ddb87af1cbc139767f5e25a4de5f53a7eac42ef', '[\"*\"]', '2023-04-10 03:19:35', '2023-04-10 03:19:34', '2023-04-10 03:19:35'),
(228, 'App\\Models\\User', 2, 'auth-token', '045b48bcf4c368d620b6184f1d46fe573e1adac2af140d84397956857a844f88', '[\"*\"]', '2023-04-10 03:24:57', '2023-04-10 03:20:01', '2023-04-10 03:24:57'),
(229, 'App\\Models\\User', 2, 'auth-token', '2435a53e5c69f5eb8524917ae1d7cde755bbd710cb65d5c486781963dccc66be', '[\"*\"]', '2023-04-10 03:23:22', '2023-04-10 03:23:21', '2023-04-10 03:23:22'),
(230, 'App\\Models\\User', 2, 'auth-token', 'e5b7527bede5dd2305dbfc576b7d023340b213405f983fcf3c312cb0805cd03a', '[\"*\"]', '2023-04-10 03:28:42', '2023-04-10 03:24:51', '2023-04-10 03:28:42'),
(231, 'App\\Models\\User', 2, 'auth-token', '0aeee26ea94162825be9c63eaae0c2f54d2cb416626d8fb8dd4193cf3bd79fc7', '[\"*\"]', '2023-04-11 00:31:13', '2023-04-11 00:30:07', '2023-04-11 00:31:13'),
(232, 'App\\Models\\User', 13, 'auth-token', 'a29b1260321c90ab2d1f41d51efb984d25f674d2d41de33de0c272fd4d72e65f', '[\"*\"]', '2023-04-13 02:13:40', '2023-04-12 06:55:38', '2023-04-13 02:13:40'),
(233, 'App\\Models\\User', 13, 'auth-token', '6ea7e180ca6ac113339de422efd6df5bbd6ae1b4825d3fca25b9ede8eba08f71', '[\"*\"]', NULL, '2023-04-12 07:40:08', '2023-04-12 07:40:08'),
(234, 'App\\Models\\User', 13, 'auth-token', 'df925bc5ba6b7be19c54551dd7cb1b54d8c19046c4d78239d96db643f7ca5ffc', '[\"*\"]', '2023-04-12 07:59:41', '2023-04-12 07:42:43', '2023-04-12 07:59:41'),
(235, 'App\\Models\\User', 14, 'auth-token', '36f9cc12e0547ce3051ca08c7ab5ed09f1d34b11113af4ae7b2593f127ae3e28', '[\"*\"]', NULL, '2023-04-12 08:04:12', '2023-04-12 08:04:12'),
(236, 'App\\Models\\User', 14, 'auth-token', '131b7258e4274ff8761870b2bac121b5383cd7f33aa174a0e41b7cdbab0e2547', '[\"*\"]', NULL, '2023-04-12 08:31:16', '2023-04-12 08:31:16'),
(237, 'App\\Models\\User', 15, 'auth-token', '7487c1844f4bff38288c11a45e8e10bdc4fde11c57eaf4f40c06e433b8cfb2c1', '[\"*\"]', '2023-04-12 14:46:20', '2023-04-12 14:43:30', '2023-04-12 14:46:20'),
(238, 'App\\Models\\User', 14, 'auth-token', 'c85788017b87768528a0dc6cf872a3b759a10e4acb292b7987848e996d87a3a6', '[\"*\"]', '2023-04-13 08:36:46', '2023-04-13 08:36:04', '2023-04-13 08:36:46'),
(239, 'App\\Models\\User', 14, 'auth-token', 'a5ecb1f29f886bb3fdbc1a5462f7ffb401f6c757d9e16b6c6a61b6926dce6268', '[\"*\"]', '2023-04-13 08:39:46', '2023-04-13 08:38:02', '2023-04-13 08:39:46'),
(240, 'App\\Models\\User', 14, 'auth-token', 'b975d27e87ff62a38d394868fed7c87462b7dc1997fd3b970d47808b2ad7c723', '[\"*\"]', NULL, '2023-04-13 08:40:38', '2023-04-13 08:40:38'),
(241, 'App\\Models\\User', 14, 'auth-token', '58dde5ac4e208f1b02faf0e6bcaf56f44fb5f66a41e16acb1479299fee523c88', '[\"*\"]', '2023-04-13 08:47:55', '2023-04-13 08:47:51', '2023-04-13 08:47:55'),
(242, 'App\\Models\\User', 2, 'auth-token', '794644e5295ca581d64e30a3d4b8316a383f555617a03a8feb63c0b243cd041f', '[\"*\"]', '2023-04-13 08:52:00', '2023-04-13 08:50:14', '2023-04-13 08:52:00'),
(243, 'App\\Models\\User', 14, 'auth-token', '99c2dbbf8569b4a2a590dd967c8c0643ee4ef545f7a970ef13dcdd9dff5005e5', '[\"*\"]', '2023-04-13 08:51:01', '2023-04-13 08:50:56', '2023-04-13 08:51:01'),
(244, 'App\\Models\\User', 14, 'auth-token', 'aaa9589b49ecffec8a078980888c8e4c0cf6a70a22aac6fb50c4ec69b9cd3963', '[\"*\"]', '2023-04-13 15:19:15', '2023-04-13 08:52:29', '2023-04-13 15:19:15'),
(245, 'App\\Models\\User', 14, 'auth-token', 'f8bf8494367884f824a1f389ee482e847d9d43168006f544bb9221e4de91f8c9', '[\"*\"]', NULL, '2023-04-13 08:55:07', '2023-04-13 08:55:07'),
(246, 'App\\Models\\User', 2, 'auth-token', 'b039957de04c88e3e6237424845d546db646c20467e117a683727426099ae915', '[\"*\"]', '2023-04-15 11:30:12', '2023-04-15 04:54:40', '2023-04-15 11:30:12'),
(247, 'App\\Models\\User', 2, 'auth-token', '682652218420b877d65e308f1b59386dab7291972bf5ed0c0ec44f0426fdded9', '[\"*\"]', '2023-04-15 22:20:05', '2023-04-15 13:11:36', '2023-04-15 22:20:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direktur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id`, `nama`, `alamat`, `kontak`, `logo`, `direktur`, `nomor`, `website`, `created_at`, `updated_at`) VALUES
(1, 'PT. Deta Sukses Makmur', 'Jalan Letnan Jenderal S. Parman.76 Lantai Dua, Semarang City, Central Java 50232', '024 8445533', 'uploads/logo/1676902937_logo-dsm.png', 'Esti Widsyandari', '001', 'https://detasuksesmakmur.com/', '2022-08-05 10:42:35', '2023-03-02 02:22:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinces`
--

CREATE TABLE `provinces` (
  `id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_city`
--

CREATE TABLE `ref_city` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'id entry',
  `code` varchar(15) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='kota/kabupaten';

--
-- Dumping data untuk tabel `ref_city`
--

INSERT INTO `ref_city` (`id`, `code`, `name`, `parent`) VALUES
(1, '1101', 'Kab. Aceh Selatan', '11'),
(2, '1102', 'Kab. Aceh Tenggara', '11'),
(3, '1103', 'Kab. Aceh Timur', '11'),
(4, '1104', 'Kab. Aceh Tengah', '11'),
(5, '1105', 'Kab. Aceh Barat', '11'),
(6, '1106', 'Kab. Aceh Besar', '11'),
(7, '1107', 'Kab. Pidie', '11'),
(8, '1108', 'Kab. Aceh Utara', '11'),
(9, '1109', 'Kab. Simeulue', '11'),
(10, '1110', 'Kab. Aceh Singkil', '11'),
(11, '1111', 'Kab. Bireuen', '11'),
(12, '1112', 'Kab. Aceh Barat Daya', '11'),
(13, '1113', 'Kab. Gayo Lues', '11'),
(14, '1114', 'Kab. Aceh Jaya', '11'),
(15, '1115', 'Kab. Nagan Raya', '11'),
(16, '1116', 'Kab. Aceh Tamiang', '11'),
(17, '1117', 'Kab. Bener Meriah', '11'),
(18, '1118', 'Kab. Pidie Jaya', '11'),
(19, '1171', 'Kota Banda Aceh', '11'),
(20, '1172', 'Kota Sabang', '11'),
(21, '1173', 'Kota Lhokseumawe', '11'),
(22, '1174', 'Kota Langsa', '11'),
(23, '1175', 'Kota Subulussalam', '11'),
(24, '1201', 'Kab. Tapanuli Tengah', '12'),
(25, '1202', 'Kab. Tapanuli Utara', '12'),
(26, '1203', 'Kab. Tapanuli Selatan', '12'),
(27, '1204', 'Kab. Nias', '12'),
(28, '1205', 'Kab. Langkat', '12'),
(29, '1206', 'Kab. Karo', '12'),
(30, '1207', 'Kab. Deli Serdang', '12'),
(31, '1208', 'Kab. Simalungun', '12'),
(32, '1209', 'Kab. Asahan', '12'),
(33, '1210', 'Kab. Labuhanbatu', '12'),
(34, '1211', 'Kab. Dairi', '12'),
(35, '1212', 'Kab. Toba Samosir', '12'),
(36, '1213', 'Kab. Mandailing Natal', '12'),
(37, '1214', 'Kab. Nias Selatan', '12'),
(38, '1215', 'Kab. Pakpak Bharat', '12'),
(39, '1216', 'Kab. Humbang Hasundutan', '12'),
(40, '1217', 'Kab. Samosir', '12'),
(41, '1218', 'Kab. Serdang Bedagai', '12'),
(42, '1219', 'Kab. Batu Bara', '12'),
(43, '1220', 'Kab. Padang Lawas Utara', '12'),
(44, '1221', 'Kab. Padang Lawas', '12'),
(45, '1222', 'Kab. Labuhanbatu Selatan', '12'),
(46, '1223', 'Kab. Labuhanbatu Utara', '12'),
(47, '1224', 'Kab. Nias Utara', '12'),
(48, '1225', 'Kab. Nias Barat', '12'),
(49, '1271', 'Kota Medan', '12'),
(50, '1272', 'Kota Pematang Siantar', '12'),
(51, '1273', 'Kota Sibolga', '12'),
(52, '1274', 'Kota Tanjung Balai', '12'),
(53, '1275', 'Kota Binjai', '12'),
(54, '1276', 'Kota Tebing Tinggi', '12'),
(55, '1277', 'Kota Padangsidimpuan', '12'),
(56, '1278', 'Kota Gunungsitoli', '12'),
(57, '1301', 'Kab. Pesisir Selatan', '13'),
(58, '1302', 'Kab. Solok', '13'),
(59, '1303', 'Kab. Sijunjung', '13'),
(60, '1304', 'Kab. Tanah Datar', '13'),
(61, '1305', 'Kab. Padang Pariaman', '13'),
(62, '1306', 'Kab. Agam', '13'),
(63, '1307', 'Kab. Lima Puluh Kota', '13'),
(64, '1308', 'Kab. Pasaman', '13'),
(65, '1309', 'Kab. Kepulauan Mentawai', '13'),
(66, '1310', 'Kab. Dharmasraya', '13'),
(67, '1311', 'Kab. Solok Selatan', '13'),
(68, '1312', 'Kab. Pasaman Barat', '13'),
(69, '1371', 'Kota Padang', '13'),
(70, '1372', 'Kota Solok', '13'),
(71, '1373', 'Kota Sawahlunto', '13'),
(72, '1374', 'Kota Padang Panjang', '13'),
(73, '1375', 'Kota Bukittinggi', '13'),
(74, '1376', 'Kota Payakumbuh', '13'),
(75, '1377', 'Kota Pariaman', '13'),
(76, '1401', 'Kab. Kampar', '14'),
(77, '1402', 'Kab. Indragiri Hulu', '14'),
(78, '1403', 'Kab. Bengkalis', '14'),
(79, '1404', 'Kab. Indragiri Hilir', '14'),
(80, '1405', 'Kab. Pelalawan', '14'),
(81, '1406', 'Kab. Rokan Hulu', '14'),
(82, '1407', 'Kab. Rokan Hilir', '14'),
(83, '1408', 'Kab. Siak', '14'),
(84, '1409', 'Kab. Kuantan Singingi', '14'),
(85, '1410', 'Kab. Kepulauan Meranti', '14'),
(86, '1471', 'Kota Pekanbaru', '14'),
(87, '1472', 'Kota Dumai', '14'),
(88, '1501', 'Kab. Kerinci', '15'),
(89, '1502', 'Kab. Merangin', '15'),
(90, '1503', 'Kab. Sarolangun', '15'),
(91, '1504', 'Kab. Batanghari', '15'),
(92, '1505', 'Kab. Muaro Jambi', '15'),
(93, '1506', 'Kab. Tanjung Jabung Barat', '15'),
(94, '1507', 'Kab. Tanjung Jabung Timur', '15'),
(95, '1508', 'Kab. Bungo', '15'),
(96, '1509', 'Kab. Tebo', '15'),
(97, '1571', 'Kota Jambi', '15'),
(98, '1572', 'Kota Sungai Penuh', '15'),
(99, '1601', 'Kab. Ogan Komering Ulu', '16'),
(100, '1602', 'Kab. Ogan Komering Ilir', '16'),
(101, '1603', 'Kab. Muara Enim', '16'),
(102, '1604', 'Kab. Lahat', '16'),
(103, '1605', 'Kab. Musi Rawas', '16'),
(104, '1606', 'Kab. Musi Banyuasin', '16'),
(105, '1607', 'Kab. Banyuasin', '16'),
(106, '1608', 'Kab. Ogan Komering Ulu Timur', '16'),
(107, '1609', 'Kab. Ogan Komering Ulu Selatan', '16'),
(108, '1610', 'Kab. Ogan Ilir', '16'),
(109, '1611', 'Kab. Empat Lawang', '16'),
(110, '1612', 'Kab. Penukal Abab Lematang Ilir', '16'),
(111, '1613', 'Kab. Musi Rawas Utara', '16'),
(112, '1671', 'Kota Palembang', '16'),
(113, '1672', 'Kota Pagar Alam', '16'),
(114, '1673', 'Kota Lubuk Linggau', '16'),
(115, '1674', 'Kota Prabumulih', '16'),
(116, '1701', 'Kab. Bengkulu Selatan', '17'),
(117, '1702', 'Kab. Rejang Lebong', '17'),
(118, '1703', 'Kab. Bengkulu Utara', '17'),
(119, '1704', 'Kab. Kaur', '17'),
(120, '1705', 'Kab. Seluma', '17'),
(121, '1706', 'Kab. Muko Muko', '17'),
(122, '1707', 'Kab. Lebong', '17'),
(123, '1708', 'Kab. Kepahiang', '17'),
(124, '1709', 'Kab. Bengkulu Tengah', '17'),
(125, '1771', 'Kota Bengkulu', '17'),
(126, '1801', 'Kab. Lampung Selatan', '18'),
(127, '1802', 'Kab. Lampung Tengah', '18'),
(128, '1803', 'Kab. Lampung Utara', '18'),
(129, '1804', 'Kab. Lampung Barat', '18'),
(130, '1805', 'Kab. Tulang Bawang', '18'),
(131, '1806', 'Kab. Tanggamus', '18'),
(132, '1807', 'Kab. Lampung Timur', '18'),
(133, '1808', 'Kab. Way Kanan', '18'),
(134, '1809', 'Kab. Pesawaran', '18'),
(135, '1810', 'Kab. Pringsewu', '18'),
(136, '1811', 'Kab. Mesuji', '18'),
(137, '1812', 'Kab. Tulang Bawang Barat', '18'),
(138, '1813', 'Kab. Pesisir Barat', '18'),
(139, '1871', 'Kota Bandar Lampung', '18'),
(140, '1872', 'Kota Metro', '18'),
(141, '1901', 'Kab. Bangka', '19'),
(142, '1902', 'Kab. Belitung', '19'),
(143, '1903', 'Kab. Bangka Selatan', '19'),
(144, '1904', 'Kab. Bangka Tengah', '19'),
(145, '1905', 'Kab. Bangka Barat', '19'),
(146, '1906', 'Kab. Belitung Timur', '19'),
(147, '1971', 'Kota Pangkal Pinang', '19'),
(148, '2101', 'Kab. Bintan', '21'),
(149, '2102', 'Kab. Karimun', '21'),
(150, '2103', 'Kab. Natuna', '21'),
(151, '2104', 'Kab. Lingga', '21'),
(152, '2105', 'Kab. Kepulauan Anambas', '21'),
(153, '2171', 'Kota Batam', '21'),
(154, '2172', 'Kota Tanjung Pinang', '21'),
(155, '3101', 'Kab. Adm. Kep. Seribu', '31'),
(156, '3171', 'Kota Adm. Jakarta Pusat', '31'),
(157, '3172', 'Kota Adm. Jakarta Utara', '31'),
(158, '3173', 'Kota Adm. Jakarta Barat', '31'),
(159, '3174', 'Kota Adm. Jakarta Selatan', '31'),
(160, '3175', 'Kota Adm. Jakarta Timur', '31'),
(161, '3201', 'Kab. Bogor', '32'),
(162, '3202', 'Kab. Sukabumi', '32'),
(163, '3203', 'Kab. Cianjur', '32'),
(164, '3204', 'Kab. Bandung', '32'),
(165, '3205', 'Kab. Garut', '32'),
(166, '3206', 'Kab. Tasikmalaya', '32'),
(167, '3207', 'Kab. Ciamis', '32'),
(168, '3208', 'Kab. Kuningan', '32'),
(169, '3209', 'Kab. Cirebon', '32'),
(170, '3210', 'Kab. Majalengka', '32'),
(171, '3211', 'Kab. Sumedang', '32'),
(172, '3212', 'Kab. Indramayu', '32'),
(173, '3213', 'Kab. Subang', '32'),
(174, '3214', 'Kab. Purwakarta', '32'),
(175, '3215', 'Kab. Karawang', '32'),
(176, '3216', 'Kab. Bekasi', '32'),
(177, '3217', 'Kab. Bandung Barat', '32'),
(178, '3218', 'Kab. Pangandaran', '32'),
(179, '3271', 'Kota Bogor', '32'),
(180, '3272', 'Kota Sukabumi', '32'),
(181, '3273', 'Kota Bandung', '32'),
(182, '3274', 'Kota Cirebon', '32'),
(183, '3275', 'Kota Bekasi', '32'),
(184, '3276', 'Kota Depok', '32'),
(185, '3277', 'Kota Cimahi', '32'),
(186, '3278', 'Kota Tasikmalaya', '32'),
(187, '3279', 'Kota Banjar', '32'),
(188, '3301', 'Kab. Cilacap', '33'),
(189, '3302', 'Kab. Banyumas', '33'),
(190, '3303', 'Kab. Purbalingga', '33'),
(191, '3304', 'Kab. Banjarnegara', '33'),
(192, '3305', 'Kab. Kebumen', '33'),
(193, '3306', 'Kab. Purworejo', '33'),
(194, '3307', 'Kab. Wonosobo', '33'),
(195, '3308', 'Kab. Magelang', '33'),
(196, '3309', 'Kab. Boyolali', '33'),
(197, '3310', 'Kab. Klaten', '33'),
(198, '3311', 'Kab. Sukoharjo', '33'),
(199, '3312', 'Kab. Wonogiri', '33'),
(200, '3313', 'Kab. Karanganyar', '33'),
(201, '3314', 'Kab. Sragen', '33'),
(202, '3315', 'Kab. Grobogan', '33'),
(203, '3316', 'Kab. Blora', '33'),
(204, '3317', 'Kab. Rembang', '33'),
(205, '3318', 'Kab. Pati', '33'),
(206, '3319', 'Kab. Kudus', '33'),
(207, '3320', 'Kab. Jepara', '33'),
(208, '3321', 'Kab. Demak', '33'),
(209, '3322', 'Kab. Semarang', '33'),
(210, '3323', 'Kab. Temanggung', '33'),
(211, '3324', 'Kab. Kendal', '33'),
(212, '3325', 'Kab. Batang', '33'),
(213, '3326', 'Kab. Pekalongan', '33'),
(214, '3327', 'Kab. Pemalang', '33'),
(215, '3328', 'Kab. Tegal', '33'),
(216, '3329', 'Kab. Brebes', '33'),
(217, '3371', 'Kota Magelang', '33'),
(218, '3372', 'Kota Surakarta', '33'),
(219, '3373', 'Kota Salatiga', '33'),
(220, '3374', 'Kota Semarang', '33'),
(221, '3375', 'Kota Pekalongan', '33'),
(222, '3376', 'Kota Tegal', '33'),
(223, '3401', 'Kab. Kulon Progo', '34'),
(224, '3402', 'Kab. Bantul', '34'),
(225, '3403', 'Kab. Gunung Kidul', '34'),
(226, '3404', 'Kab. Sleman', '34'),
(227, '3471', 'Kota Yogyakarta', '34'),
(228, '3501', 'Kab. Pacitan', '35'),
(229, '3502', 'Kab. Ponorogo', '35'),
(230, '3503', 'Kab. Trenggalek', '35'),
(231, '3504', 'Kab. Tulungagung', '35'),
(232, '3505', 'Kab. Blitar', '35'),
(233, '3506', 'Kab. Kediri', '35'),
(234, '3507', 'Kab. Malang', '35'),
(235, '3508', 'Kab. Lumajang', '35'),
(236, '3509', 'Kab. Jember', '35'),
(237, '3510', 'Kab. Banyuwangi', '35'),
(238, '3511', 'Kab. Bondowoso', '35'),
(239, '3512', 'Kab. Situbondo', '35'),
(240, '3513', 'Kab. Probolinggo', '35'),
(241, '3514', 'Kab. Pasuruan', '35'),
(242, '3515', 'Kab. Sidoarjo', '35'),
(243, '3516', 'Kab. Mojokerto', '35'),
(244, '3517', 'Kab. Jombang', '35'),
(245, '3518', 'Kab. Nganjuk', '35'),
(246, '3519', 'Kab. Madiun', '35'),
(247, '3520', 'Kab. Magetan', '35'),
(248, '3521', 'Kab. Ngawi', '35'),
(249, '3522', 'Kab. Bojonegoro', '35'),
(250, '3523', 'Kab. Tuban', '35'),
(251, '3524', 'Kab. Lamongan', '35'),
(252, '3525', 'Kab. Gresik', '35'),
(253, '3526', 'Kab. Bangkalan', '35'),
(254, '3527', 'Kab. Sampang', '35'),
(255, '3528', 'Kab. Pamekasan', '35'),
(256, '3529', 'Kab. Sumenep', '35'),
(257, '3571', 'Kota Kediri', '35'),
(258, '3572', 'Kota Blitar', '35'),
(259, '3573', 'Kota Malang', '35'),
(260, '3574', 'Kota Probolinggo', '35'),
(261, '3575', 'Kota Pasuruan', '35'),
(262, '3576', 'Kota Mojokerto', '35'),
(263, '3577', 'Kota Madiun', '35'),
(264, '3578', 'Kota Surabaya', '35'),
(265, '3579', 'Kota Batu', '35'),
(266, '3601', 'Kab. Pandeglang', '36'),
(267, '3602', 'Kab. Lebak', '36'),
(268, '3603', 'Kab. Tangerang', '36'),
(269, '3604', 'Kab. Serang', '36'),
(270, '3671', 'Kota Tangerang', '36'),
(271, '3672', 'Kota Cilegon', '36'),
(272, '3673', 'Kota Serang', '36'),
(273, '3674', 'Kota Tangerang Selatan', '36'),
(274, '5101', 'Kab. Jembrana', '51'),
(275, '5102', 'Kab. Tabanan', '51'),
(276, '5103', 'Kab. Badung', '51'),
(277, '5104', 'Kab. Gianyar', '51'),
(278, '5105', 'Kab. Klungkung', '51'),
(279, '5106', 'Kab. Bangli', '51'),
(280, '5107', 'Kab. Karangasem', '51'),
(281, '5108', 'Kab. Buleleng', '51'),
(282, '5171', 'Kota Denpasar', '51'),
(283, '5201', 'Kab. Lombok Barat', '52'),
(284, '5202', 'Kab. Lombok Tengah', '52'),
(285, '5203', 'Kab. Lombok Timur', '52'),
(286, '5204', 'Kab. Sumbawa', '52'),
(287, '5205', 'Kab. Dompu', '52'),
(288, '5206', 'Kab. Bima', '52'),
(289, '5207', 'Kab. Sumbawa Barat', '52'),
(290, '5208', 'Kab. Lombok Utara', '52'),
(291, '5271', 'Kota Mataram', '52'),
(292, '5272', 'Kota Bima', '52'),
(293, '5301', 'Kab. Kupang', '53'),
(294, '5302', 'Kab Timor Tengah Selatan', '53'),
(295, '5303', 'Kab. Timor Tengah Utara', '53'),
(296, '5304', 'Kab. Belu', '53'),
(297, '5305', 'Kab. Alor', '53'),
(298, '5306', 'Kab. Flores Timur', '53'),
(299, '5307', 'Kab. Sikka', '53'),
(300, '5308', 'Kab. Ende', '53'),
(301, '5309', 'Kab. Ngada', '53'),
(302, '5310', 'Kab. Manggarai', '53'),
(303, '5311', 'Kab. Sumba Timur', '53'),
(304, '5312', 'Kab. Sumba Barat', '53'),
(305, '5313', 'Kab. Lembata', '53'),
(306, '5314', 'Kab. Rote Ndao', '53'),
(307, '5315', 'Kab. Manggarai Barat', '53'),
(308, '5316', 'Kab. Nagekeo', '53'),
(309, '5317', 'Kab. Sumba Tengah', '53'),
(310, '5318', 'Kab. Sumba Barat Daya', '53'),
(311, '5319', 'Kab. Manggarai Timur', '53'),
(312, '5320', 'Kab. Sabu Raijua', '53'),
(313, '5321', 'Kab. Malaka', '53'),
(314, '5371', 'Kota Kupang', '53'),
(315, '6101', 'Kab. Sambas', '61'),
(316, '6102', 'Kab. Mempawah', '61'),
(317, '6103', 'Kab. Sanggau', '61'),
(318, '6104', 'Kab. Ketapang', '61'),
(319, '6105', 'Kab. Sintang', '61'),
(320, '6106', 'Kab. Kapuas Hulu', '61'),
(321, '6107', 'Kab. Bengkayang', '61'),
(322, '6108', 'Kab. Landak', '61'),
(323, '6109', 'Kab. Sekadau', '61'),
(324, '6110', 'Kab. Melawi', '61'),
(325, '6111', 'Kab. Kayong Utara', '61'),
(326, '6112', 'Kab. Kubu Raya', '61'),
(327, '6171', 'Kota Pontianak', '61'),
(328, '6172', 'Kota Singkawang', '61'),
(329, '6201', 'Kab. Kotawaringin Barat', '62'),
(330, '6202', 'Kab. Kotawaringin Timur', '62'),
(331, '6203', 'Kab. Kapuas', '62'),
(332, '6204', 'Kab. Barito Selatan', '62'),
(333, '6205', 'Kab. Barito Utara', '62'),
(334, '6206', 'Kab. Katingan', '62'),
(335, '6207', 'Kab. Seruyan', '62'),
(336, '6208', 'Kab. Sukamara', '62'),
(337, '6209', 'Kab. Lamandau', '62'),
(338, '6210', 'Kab. Gunung Mas', '62'),
(339, '6211', 'Kab. Pulang Pisau', '62'),
(340, '6212', 'Kab. Murung Raya', '62'),
(341, '6213', 'Kab. Barito Timur', '62'),
(342, '6271', 'Kota Palangkaraya', '62'),
(343, '6301', 'Kab. Tanah Laut', '63'),
(344, '6302', 'Kab. Kotabaru', '63'),
(345, '6303', 'Kab. Banjar', '63'),
(346, '6304', 'Kab. Barito Kuala', '63'),
(347, '6305', 'Kab. Tapin', '63'),
(348, '6306', 'Kab. Hulu Sungai Selatan', '63'),
(349, '6307', 'Kab. Hulu Sungai Tengah', '63'),
(350, '6308', 'Kab. Hulu Sungai Utara', '63'),
(351, '6309', 'Kab. Tabalong', '63'),
(352, '6310', 'Kab. Tanah Bumbu', '63'),
(353, '6311', 'Kab. Balangan', '63'),
(354, '6371', 'Kota Banjarmasin', '63'),
(355, '6372', 'Kota Banjarbaru', '63'),
(356, '6401', 'Kab. Paser', '64'),
(357, '6402', 'Kab. Kutai Kartanegara', '64'),
(358, '6403', 'Kab. Berau', '64'),
(359, '6407', 'Kab. Kutai Barat', '64'),
(360, '6408', 'Kab. Kutai Timur', '64'),
(361, '6409', 'Kab. Penajam Paser Utara', '64'),
(362, '6411', 'Kab. Mahakam Ulu', '64'),
(363, '6471', 'Kota Balikpapan', '64'),
(364, '6472', 'Kota Samarinda', '64'),
(365, '6474', 'Kota Bontang', '64'),
(366, '6501', 'Kab. Bulungan', '65'),
(367, '6502', 'Kab. Malinau', '65'),
(368, '6503', 'Kab. Nunukan', '65'),
(369, '6504', 'Kab. Tana Tidung', '65'),
(370, '6571', 'Kota Tarakan', '65'),
(371, '7101', 'Kab. Bolaang Mongondow', '71'),
(372, '7102', 'Kab. Minahasa', '71'),
(373, '7103', 'Kab. Kepulauan Sangihe', '71'),
(374, '7104', 'Kab. Kepulauan Talaud', '71'),
(375, '7105', 'Kab. Minahasa Selatan', '71'),
(376, '7106', 'Kab. Minahasa Utara', '71'),
(377, '7107', 'Kab. Minahasa Tenggara', '71'),
(378, '7108', 'Kab. Bolaang Mongondow Utara', '71'),
(379, '7109', 'Kab. Kep. Siau Tagulandang Biaro', '71'),
(380, '7110', 'Kab. Bolaang Mongondow Timur', '71'),
(381, '7111', 'Kab. Bolaang Mongondow Selatan', '71'),
(382, '7171', 'Kota Manado', '71'),
(383, '7172', 'Kota Bitung', '71'),
(384, '7173', 'Kota Tomohon', '71'),
(385, '7174', 'Kota Kotamobagu', '71'),
(386, '7201', 'Kab. Banggai', '72'),
(387, '7202', 'Kab. Poso', '72'),
(388, '7203', 'Kab. Donggala', '72'),
(389, '7204', 'Kab. Toli Toli', '72'),
(390, '7205', 'Kab. Buol', '72'),
(391, '7206', 'Kab. Morowali', '72'),
(392, '7207', 'Kab. Banggai Kepulauan', '72'),
(393, '7208', 'Kab. Parigi Moutong', '72'),
(394, '7209', 'Kab. Tojo Una Una', '72'),
(395, '7210', 'Kab. Sigi', '72'),
(396, '7211', 'Kab. Banggai Laut', '72'),
(397, '7212', 'Kab. Morowali Utara', '72'),
(398, '7271', 'Kota Palu', '72'),
(399, '7301', 'Kab. Kepulauan Selayar', '73'),
(400, '7302', 'Kab. Bulukumba', '73'),
(401, '7303', 'Kab. Bantaeng', '73'),
(402, '7304', 'Kab. Jeneponto', '73'),
(403, '7305', 'Kab. Takalar', '73'),
(404, '7306', 'Kab. Gowa', '73'),
(405, '7307', 'Kab. Sinjai', '73'),
(406, '7308', 'Kab. Bone', '73'),
(407, '7309', 'Kab. Maros', '73'),
(408, '7310', 'Kab. Pangkajene Kepulauan', '73'),
(409, '7311', 'Kab. Barru', '73'),
(410, '7312', 'Kab. Soppeng', '73'),
(411, '7313', 'Kab. Wajo', '73'),
(412, '7314', 'Kab. Sidenreng Rappang', '73'),
(413, '7315', 'Kab. Pinrang', '73'),
(414, '7316', 'Kab. Enrekang', '73'),
(415, '7317', 'Kab. Luwu', '73'),
(416, '7318', 'Kab. Tana Toraja', '73'),
(417, '7322', 'Kab. Luwu Utara', '73'),
(418, '7324', 'Kab. Luwu Timur', '73'),
(419, '7326', 'Kab. Toraja Utara', '73'),
(420, '7371', 'Kota Makassar', '73'),
(421, '7372', 'Kota Pare Pare', '73'),
(422, '7373', 'Kota Palopo', '73'),
(423, '7401', 'Kab. Kolaka', '74'),
(424, '7402', 'Kab. Konawe', '74'),
(425, '7403', 'Kab. Muna', '74'),
(426, '7404', 'Kab. Buton', '74'),
(427, '7405', 'Kab. Konawe Selatan', '74'),
(428, '7406', 'Kab. Bombana', '74'),
(429, '7407', 'Kab. Wakatobi', '74'),
(430, '7408', 'Kab. Kolaka Utara', '74'),
(431, '7409', 'Kab. Konawe Utara', '74'),
(432, '7410', 'Kab. Buton Utara', '74'),
(433, '7411', 'Kab. Kolaka Timur', '74'),
(434, '7412', 'Kab. Konawe Kepulauan', '74'),
(435, '7413', 'Kab. Muna Barat', '74'),
(436, '7414', 'Kab. Buton Tengah', '74'),
(437, '7415', 'Kab. Buton Selatan', '74'),
(438, '7471', 'Kota Kendari', '74'),
(439, '7472', 'Kota Bau Bau', '74'),
(440, '7501', 'Kab. Gorontalo', '75'),
(441, '7502', 'Kab. Boalemo', '75'),
(442, '7503', 'Kab. Bone Bolango', '75'),
(443, '7504', 'Kab. Pahuwato', '75'),
(444, '7505', 'Kab. Gorontalo Utara', '75'),
(445, '7571', 'Kota Gorontalo', '75'),
(446, '7601', 'Kab. Mamuju Utara', '76'),
(447, '7602', 'Kab. Mamuju', '76'),
(448, '7603', 'Kab. Mamasa', '76'),
(449, '7604', 'Kab. Polewali Mandar', '76'),
(450, '7605', 'Kab. Majene', '76'),
(451, '7606', 'Kab. Mamuju Tengah', '76'),
(452, '8101', 'Kab. Maluku Tengah', '81'),
(453, '8102', 'Kab. Maluku Tenggara', '81'),
(454, '8103', 'Kab Maluku Tenggara Barat', '81'),
(455, '8104', 'Kab. Buru', '81'),
(456, '8105', 'Kab. Seram Bagian Timur', '81'),
(457, '8106', 'Kab. Seram Bagian Barat', '81'),
(458, '8107', 'Kab. Kepulauan Aru', '81'),
(459, '8108', 'Kab. Maluku Barat Daya', '81'),
(460, '8109', 'Kab. Buru Selatan', '81'),
(461, '8171', 'Kota Ambon', '81'),
(462, '8172', 'Kota Tual', '81'),
(463, '8201', 'Kab. Halmahera Barat', '82'),
(464, '8202', 'Kab. Halmahera Tengah', '82'),
(465, '8203', 'Kab. Halmahera Utara', '82'),
(466, '8204', 'Kab. Halmahera Selatan', '82'),
(467, '8205', 'Kab. Kepulauan Sula', '82'),
(468, '8206', 'Kab. Halmahera Timur', '82'),
(469, '8207', 'Kab. Pulau Morotai', '82'),
(470, '8208', 'Kab. Pulau Taliabu', '82'),
(471, '8271', 'Kota Ternate', '82'),
(472, '8272', 'Kota Tidore Kepulauan', '82'),
(473, '9101', 'Kab. Merauke', '91'),
(474, '9102', 'Kab. Jayawijaya', '91'),
(475, '9103', 'Kab. Jayapura', '91'),
(476, '9104', 'Kab. Nabire', '91'),
(477, '9105', 'Kab. Kepulauan Yapen', '91'),
(478, '9106', 'Kab. Biak Numfor', '91'),
(479, '9107', 'Kab. Puncak Jaya', '91'),
(480, '9108', 'Kab. Paniai', '91'),
(481, '9109', 'Kab. Mimika', '91'),
(482, '9110', 'Kab. Sarmi', '91'),
(483, '9111', 'Kab. Keerom', '91'),
(484, '9112', 'Kab Pegunungan Bintang', '91'),
(485, '9113', 'Kab. Yahukimo', '91'),
(486, '9114', 'Kab. Tolikara', '91'),
(487, '9115', 'Kab. Waropen', '91'),
(488, '9116', 'Kab. Boven Digoel', '91'),
(489, '9117', 'Kab. Mappi', '91'),
(490, '9118', 'Kab. Asmat', '91'),
(491, '9119', 'Kab. Supiori', '91'),
(492, '9120', 'Kab. Mamberamo Raya', '91'),
(493, '9121', 'Kab. Mamberamo Tengah', '91'),
(494, '9122', 'Kab. Yalimo', '91'),
(495, '9123', 'Kab. Lanny Jaya', '91'),
(496, '9124', 'Kab. Nduga', '91'),
(497, '9125', 'Kab. Puncak', '91'),
(498, '9126', 'Kab. Dogiyai', '91'),
(499, '9127', 'Kab. Intan Jaya', '91'),
(500, '9128', 'Kab. Deiyai', '91'),
(501, '9171', 'Kota Jayapura', '91'),
(502, '9201', 'Kab. Sorong', '92'),
(503, '9202', 'Kab. Manokwari', '92'),
(504, '9203', 'Kab. Fak Fak', '92'),
(505, '9204', 'Kab. Sorong Selatan', '92'),
(506, '9205', 'Kab. Raja Ampat', '92'),
(507, '9206', 'Kab. Teluk Bintuni', '92'),
(508, '9207', 'Kab. Teluk Wondama', '92'),
(509, '9208', 'Kab. Kaimana', '92'),
(510, '9209', 'Kab. Tambrauw', '92'),
(511, '9210', 'Kab. Maybrat', '92'),
(512, '9211', 'Kab. Manokwari Selatan', '92'),
(513, '9212', 'Kab. Pegunungan Arfak', '92'),
(514, '9271', 'Kota Sorong', '92');

-- --------------------------------------------------------

--
-- Struktur dari tabel `regencies`
--

CREATE TABLE `regencies` (
  `id` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reimbursement`
--

CREATE TABLE `reimbursement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_reimbursement` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reimbursement`
--

INSERT INTO `reimbursement` (`id`, `kode_reimbursement`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '43', 'Sppd Ke Daerah', '2022-06-30 08:00:03', '2022-08-31 15:34:25', '2022-08-31 15:34:25'),
(2, '44', 'Pinjaman Ke Perusahaan', '2022-06-30 08:01:02', '2022-08-31 15:34:21', '2022-08-31 15:34:21'),
(3, '102', 'Transportasi', '2022-08-31 15:33:45', '2022-08-31 15:33:45', NULL),
(4, '100', 'Komunikasi', '2022-08-31 15:34:15', '2022-08-31 15:34:15', NULL),
(5, '101', 'Makan', '2022-08-31 15:34:34', '2023-02-17 17:26:11', '2023-02-17 17:26:11'),
(6, '103', 'Entertainment', '2023-04-03 14:54:55', '2023-04-03 14:55:04', NULL),
(7, '104', 'Hotel', '2023-04-03 15:00:48', '2023-04-03 15:00:48', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_bahasa`
--

CREATE TABLE `riwayat_bahasa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bahasa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penguasaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_bahasa`
--

INSERT INTO `riwayat_bahasa` (`id`, `nip`, `nama_bahasa`, `penguasaan`, `jenis`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28', 'Korea', 'aktif', 'asing', NULL, '2022-08-13 02:37:09', '2022-08-13 02:37:09', NULL),
(2, '28', 'Inggris', 'aktif', 'asing', NULL, '2022-08-23 05:35:39', '2022-08-23 05:35:39', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_cuti`
--

CREATE TABLE `riwayat_cuti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_cuti` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_cuti`
--

INSERT INTO `riwayat_cuti` (`id`, `nip`, `kode_cuti`, `nomor_surat`, `tanggal_surat`, `tanggal_mulai`, `tanggal_selesai`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '66', '52', 'ets-no-surat', '2022-07-04', '2022-07-09', '2022-07-14', '66/66-cuti-ets-no-surat.jpg', '2022-07-02 23:07:28', '2022-07-02 23:07:28', NULL),
(2, '66', '19', '342es-fa/sadf-2021', '2022-07-07', '2022-01-02', '2022-01-12', '', '2022-07-02 23:10:27', '2022-07-02 23:10:27', NULL),
(3, '66', '19', 'tes', '2022-07-14', '2022-07-09', '2022-07-14', '', '2022-07-03 07:04:21', '2022-07-03 07:04:21', NULL),
(4, '66', '52', '123-456', '2022-07-12', '2022-07-09', '2022-07-14', '66/66-cuti-123-456.png', '2022-07-12 13:05:38', '2022-07-12 13:05:38', NULL),
(5, '66', '19', '123', '2022-07-13', '2022-01-02', '2022-01-12', '', '2022-07-17 02:15:56', '2022-07-17 02:15:56', NULL),
(6, '28', '1', '123456', '2023-04-03', '2023-04-04', '2023-04-05', '', '2023-04-03 06:19:40', '2023-04-03 06:19:40', NULL),
(11, '28', 'M', '123456', '2023-04-14', '2023-04-14', '2023-04-15', '', '2023-04-14 00:36:45', '2023-04-14 00:36:45', NULL),
(12, '28', 'M', '123456', '2023-04-14', '2023-04-14', '2023-04-15', '', '2023-04-14 00:39:47', '2023-04-14 00:39:47', NULL),
(13, '28', 'M', '123456', '2023-04-14', '2023-04-14', '2023-04-15', '', '2023-04-14 00:40:27', '2023-04-14 00:40:27', NULL),
(14, '28', 'M', '123456', '2023-04-14', '2023-04-14', '2023-04-15', '', '2023-04-14 00:41:05', '2023-04-14 00:41:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_jabatan`
--

CREATE TABLE `riwayat_jabatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_jabatan` tinyint(4) NOT NULL,
  `kode_skpd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_tingkat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `tanggal_tmt` date NOT NULL,
  `sebagai` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'defenitif',
  `is_akhir` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_jabatan`
--

INSERT INTO `riwayat_jabatan` (`id`, `nip`, `jenis_jabatan`, `kode_skpd`, `kode_tingkat`, `no_sk`, `tanggal_sk`, `tanggal_tmt`, `sebagai`, `is_akhir`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28', 1, '102242', '1022420200', '1234', '2022-06-28', '2022-06-28', 'defenitif', 0, '28/28-jabatan-1234.pdf', '2022-06-28 14:46:26', '2023-02-13 11:00:53', '2023-02-13 11:00:53'),
(2, '28', 2, '3', '2113', '1234', '1970-01-01', '1970-01-01', 'PLT', 0, '28/28-jabatan-1234.pdf', '2022-06-28 14:46:26', '2023-04-03 15:03:43', '2023-04-03 15:03:43'),
(3, '66', 1, '102104', '102104', '123', '2022-06-30', '2022-06-30', 'defenitif', 1, NULL, '2022-06-30 08:29:40', '2022-06-30 08:29:40', NULL),
(4, '101090', 1, '102242', '1022420100', 'DSM 112121', '2015-08-29', '2024-08-29', 'defenitif', 0, NULL, '2022-08-29 05:01:13', '2022-08-29 05:01:13', NULL),
(5, '101090', 1, '102242', '1022420100', 'DSM 112121', '2015-08-29', '2024-08-29', 'defenitif', 1, NULL, '2022-08-29 05:01:13', '2022-08-29 05:01:13', NULL),
(6, '28', 1, '3', '1', '1313123', '2023-03-02', '2023-02-15', 'defenitif', 0, '28/28-jabatan-20230213175433.pdf', '2023-02-13 10:54:36', '2023-02-13 11:00:41', '2023-02-13 11:00:41'),
(7, '28', 2, '3', '1', '32342', '2023-02-09', '2023-02-09', 'defenitif', 0, '28/28-jabatan-20230213175851.pdf', '2023-02-13 10:58:51', '2023-04-03 15:03:48', '2023-04-03 15:03:48'),
(8, '28', 2, '3', '1', '80000', '1970-01-01', '1970-01-01', 'defenitif', 0, '28/28-jabatan-20230213175956.pdf', '2023-02-13 10:59:56', '2023-02-14 05:37:21', '2023-02-14 05:37:21'),
(9, '28', 1, '3', '1', '3343', '2023-02-23', '2023-02-09', 'defenitif', 0, '28/28-jabatan-20230213180630.pdf', '2023-02-13 11:06:30', '2023-02-13 11:09:04', '2023-02-13 11:09:04'),
(10, '28', 1, '01', 'DSM 05', '123123', '2023-02-28', '2023-02-28', 'defenitif', 0, '28/28-jabatan-20230213180848.pdf', '2023-02-13 11:08:48', '2023-04-09 08:01:02', NULL),
(11, '10', 1, '04', 'JMP STP', '123', '2023-02-24', '2023-02-24', 'defenitif', 1, NULL, '2023-02-24 07:37:09', '2023-03-26 20:42:34', NULL),
(12, '123', 1, '01', 'DSM 01', '123776', '2023-04-05', '2023-04-29', 'defenitif', 1, 'data_pegawai/123/riwayat_jabatan/123-jabatan-20230405134302.pdf', '2023-04-05 06:43:02', '2023-04-05 06:46:53', '2023-04-05 06:46:53'),
(13, '123', 1, '01', 'DSM 02', '123322', '2023-04-08', '2023-04-30', 'defenitif', 0, 'data_pegawai/123/riwayat_jabatan/123-jabatan-20230405135715.pdf', '2023-04-05 06:57:15', '2023-04-05 06:57:49', NULL),
(14, '28', 2, '01', 'DSM 02', '8992', '2023-04-10', '2023-04-11', 'defenitif', 1, 'data_pegawai/28/riwayat_jabatan/1681027262_MENU Aplikasi absen 1.2 (2).pdf', '2023-04-09 08:01:02', '2023-04-09 08:01:02', NULL),
(15, '004', 1, '01', 'DSM 03', '024001', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:44:55', '2023-04-12 03:44:55', NULL),
(16, '005', 1, '01', 'DSM 03', '024002', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:46:14', '2023-04-12 03:46:14', NULL),
(17, '008', 1, '01', 'DSM 06', '024003', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:49:08', '2023-04-12 03:49:08', NULL),
(18, '010', 1, '01', 'DSM 07', '024004', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:51:19', '2023-04-12 03:51:19', NULL),
(19, '009', 1, '01', 'DSM 08', '024005', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:53:50', '2023-04-12 03:53:50', NULL),
(20, '012', 1, '01', 'DSM 05', '024006', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:54:21', '2023-04-12 03:54:21', NULL),
(21, '011', 1, '03', 'DSM 0271', '0271001', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 03:57:03', '2023-04-12 03:57:03', NULL),
(22, '007', 1, '09', 'DSM 021', '021003', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 04:10:35', '2023-04-12 04:10:35', NULL),
(23, '003', 1, '10', 'DSM 031', '031001', '2023-04-12', '2023-04-12', 'defenitif', 1, NULL, '2023-04-12 04:18:28', '2023-04-12 04:18:28', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_kgb`
--

CREATE TABLE `riwayat_kgb` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_tmt` date NOT NULL,
  `tipe_gaji` tinyint(4) NOT NULL COMMENT '1: umk\r\n2: non-umk',
  `kode_umk` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji_pokok` double NOT NULL,
  `masa_kerja_tahun` int(11) NOT NULL,
  `masa_kerja_bulan` int(11) NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_akhir` tinyint(4) DEFAULT NULL,
  `is_private` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_kgb`
--

INSERT INTO `riwayat_kgb` (`id`, `nip`, `nomor_surat`, `tanggal_surat`, `tanggal_tmt`, `tipe_gaji`, `kode_umk`, `gaji_pokok`, `masa_kerja_tahun`, `masa_kerja_bulan`, `file`, `is_akhir`, `is_private`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '66', 'Cum reiciendis est e', '2022-06-09', '1971-12-28', 0, '', 1230000, 0, 0, NULL, 1, 0, '2022-07-12 03:53:38', '2022-07-12 03:54:32', NULL),
(2, '28', '123', '1970-01-01', '1970-01-01', 0, '', 70000, 2, 1, NULL, 0, 0, '2023-02-14 05:07:52', '2023-02-14 05:34:15', '2023-02-14 05:34:15'),
(3, '28', '123456', '2023-02-17', '2023-02-17', 0, '', 2000000, 1, 2, NULL, 1, 0, '2023-02-17 08:03:25', '2023-02-17 08:03:25', NULL),
(4, '28', '123456', '2023-03-09', '2023-03-09', 1, '123123', 3000000, 1, 1, NULL, 0, 0, '2023-03-08 22:47:48', '2023-03-08 22:48:17', NULL),
(5, '123', '1233333', '2023-04-05', '2023-04-05', 1, '123123', 3000000, 2, 2, '123/123-kgb-12331231.pdf', 0, 0, '2023-04-05 06:44:29', '2023-04-05 06:55:25', '2023-04-05 06:55:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_kursus`
--

CREATE TABLE `riwayat_kursus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kursus` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelaksana` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `angkatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `jumlah_jp` int(11) DEFAULT NULL,
  `no_sertifikat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sertifikat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_kursus`
--

INSERT INTO `riwayat_kursus` (`id`, `nip`, `kode_kursus`, `tempat`, `pelaksana`, `angkatan`, `tanggal_mulai`, `tanggal_selesai`, `jumlah_jp`, `no_sertifikat`, `tanggal_sertifikat`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28', '1', 'Malang', 'Bagio', '1234', '2023-02-14', '2023-02-14', 4, '121311313', '2023-02-14', NULL, '2023-02-14 13:01:48', '2023-02-14 13:01:48', NULL),
(2, '123', '1', 'malang', 'tahu', '2020', '2020-04-09', '2020-04-23', 400, '33122', '2020-04-29', '123/123-kursus-33122.pdf', '2023-04-05 07:37:33', '2023-04-05 07:42:57', '2023-04-05 07:42:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_lainnya`
--

CREATE TABLE `riwayat_lainnya` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_lainnya` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_sk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_lhkasn`
--

CREATE TABLE `riwayat_lhkasn` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pelaporan` date NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_lhkpn`
--

CREATE TABLE `riwayat_lhkpn` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pelaporan` date NOT NULL,
  `jenis_form` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_organisasi`
--

CREATE TABLE `riwayat_organisasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_organisasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_organisasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `nama_pimpinan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pendidikan`
--

CREATE TABLE `riwayat_pendidikan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pendidikan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lulus` date NOT NULL,
  `nomor_ijazah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sekolah` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar_depan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_belakang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_akhir` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_pendidikan`
--

INSERT INTO `riwayat_pendidikan` (`id`, `nip`, `kode_pendidikan`, `kode_jurusan`, `tanggal_lulus`, `nomor_ijazah`, `nama_sekolah`, `gelar_depan`, `gelar_belakang`, `file`, `is_akhir`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28', '7', '01', '2015-08-13', 'TI12345857', 'USM Semarang', NULL, 'S.Kom', NULL, 1, '2022-08-13 02:48:16', '2022-08-13 02:48:16', NULL),
(2, '28', '7', '64', '2023-02-14', '123', 'UB', 'Dr', 'S.Kom', NULL, 0, '2023-02-14 11:01:56', '2023-02-14 11:10:11', NULL),
(3, '123', '7', '64', '2023-04-28', '879098', 'univ a', NULL, 'M.pd', '123/123-pendidikan-8790987.pdf', 1, '2023-04-05 07:33:37', '2023-04-05 07:34:19', '2023-04-05 07:34:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_penghargaan`
--

CREATE TABLE `riwayat_penghargaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_penghargaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oleh` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_sk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pmk`
--

CREATE TABLE `riwayat_pmk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pmk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `nomor_sk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `masa_kerja_bulan` int(11) DEFAULT NULL,
  `masa_kerja_tahun` int(11) DEFAULT NULL,
  `nomor_bkn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_bkn` date DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_potongan`
--

CREATE TABLE `riwayat_potongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kurang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_sk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_sk` date DEFAULT NULL,
  `is_aktif` tinyint(4) NOT NULL DEFAULT 0,
  `is_private` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_potongan`
--

INSERT INTO `riwayat_potongan` (`id`, `nip`, `kode_kurang`, `nomor_sk`, `tanggal_sk`, `is_aktif`, `is_private`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '66', '123', NULL, '2022-07-17', 0, 0, NULL, '2022-07-16 23:53:17', '2022-07-17 02:03:27', NULL),
(2, '28', '123', 'abcd', '2022-07-26', 1, 0, NULL, '2022-07-16 23:59:27', '2023-02-14 10:29:02', '2023-02-14 10:29:02'),
(3, '28', '3', '99999', '2023-02-14', 0, 0, NULL, '2023-02-14 10:21:28', '2023-02-14 10:21:28', NULL),
(4, '123', '3', '122333', '2023-04-29', 0, 0, '123/123-potongan-zhfmt.pdf', '2023-04-05 07:29:02', '2023-04-05 07:32:10', '2023-04-05 07:32:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_shift`
--

CREATE TABLE `riwayat_shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat` date DEFAULT NULL,
  `is_akhir` tinyint(4) NOT NULL DEFAULT 0,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `komentar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_shift`
--

INSERT INTO `riwayat_shift` (`id`, `kode_shift`, `nip`, `nomor_surat`, `tanggal_surat`, `is_akhir`, `keterangan`, `komentar`, `status`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, '01', '28', '123456', '1970-01-01', 0, 'Untuk kali ini', NULL, 1, NULL, '2023-04-14 00:12:41', '2023-04-14 00:12:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_spt`
--

CREATE TABLE `riwayat_spt` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `jenis_spt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_spt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `tanggal_penyampaian` date DEFAULT NULL,
  `nomor_tanda_terima_elektronik` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_status`
--

CREATE TABLE `riwayat_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_golongan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `tanggal_tmt` date NOT NULL,
  `is_akhir` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_tunjangan`
--

CREATE TABLE `riwayat_tunjangan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_tunjangan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_sk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sk` date NOT NULL,
  `nilai` double NOT NULL,
  `is_aktif` tinyint(4) NOT NULL,
  `is_private` tinyint(4) NOT NULL DEFAULT 0,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayat_tunjangan`
--

INSERT INTO `riwayat_tunjangan` (`id`, `nip`, `kode_tunjangan`, `nomor_sk`, `tanggal_sk`, `nilai`, `is_aktif`, `is_private`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '66', '90', '123-456-789', '2022-07-12', 1230000, 1, 0, '66/66-tunjangan-.pdf', '2022-07-12 00:13:05', '2022-07-12 03:18:56', NULL),
(2, '28', '6', '9090909', '1970-01-01', 50000, 0, 0, NULL, '2023-02-14 08:32:28', '2023-02-14 10:25:33', '2023-02-14 10:25:33'),
(3, '28', '3', '9090909', '2021-01-29', 50000, 0, 0, NULL, '2023-02-14 08:45:49', '2023-02-14 10:27:24', '2023-02-14 10:27:24'),
(4, '28', '6', '9898989', '2023-02-17', 125000, 0, 0, NULL, '2023-02-17 08:58:39', '2023-02-17 08:58:39', NULL),
(5, '123', '3', '231122', '2023-04-29', 1000000, 1, 0, '123/123-tunjangan-20230405014526.pdf', '2023-04-05 06:45:26', '2023-04-05 07:35:57', '2023-04-05 07:35:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2022-05-30 07:27:58', '2022-05-30 07:27:58'),
(2, 'opd', 'web', '2022-05-30 07:28:01', '2022-05-30 07:28:01'),
(3, 'pegawai', 'web', '2022-05-30 07:28:04', '2022-05-30 07:28:04'),
(4, 'owner', 'web', '2022-05-30 07:28:04', '2022-05-30 07:28:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_shift` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_buka_datang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tepat_datang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tutup_datang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toleransi_datang` int(11) DEFAULT NULL COMMENT 'dalam menit',
  `jam_buka_istirahat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tepat_istirahat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tutup_istirahat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toleransi_istirahat` int(11) DEFAULT NULL COMMENT 'dalam menit',
  `jam_buka_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tepat_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_tutup_pulang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toleransi_pulang` int(11) DEFAULT NULL COMMENT 'dalam menit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id`, `kode_shift`, `nama`, `jam_buka_datang`, `jam_tepat_datang`, `jam_tutup_datang`, `toleransi_datang`, `jam_buka_istirahat`, `jam_tepat_istirahat`, `jam_tutup_istirahat`, `toleransi_istirahat`, `jam_buka_pulang`, `jam_tepat_pulang`, `jam_tutup_pulang`, `toleransi_pulang`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, '12', 'Shift A2 Pagi', '06:00', '06:00', '06:10', 10, '12:00', '12:00', '13:00', 0, '16:00', '16:00', '16:30', 0, '2022-06-25 06:43:57', '2023-03-01 06:10:06', '2023-03-01 06:10:06'),
(3, '11', 'SHIFT MALAM', '22:00', '00:00', '23:00', 10, '12:29', '12:30', '12:31', 5, '12:35', '12:40', '12:41', 0, '2022-06-25 05:56:42', '2023-03-01 05:58:15', '2023-03-01 05:58:15'),
(4, '01', 'Reguler', '05:03:00', '08:00:00', '08:30:00', 10, '12:00:00', '12:00:00', '12:00:00', NULL, '17:00:00', '17:00:00', '23:30:00', NULL, '2023-03-01 05:58:06', '2023-04-12 05:28:13', NULL),
(5, '02', 'Sore', '14:45:00', '15:00:00', '15:20:00', 20, '18:00:00', '18:00:00', '19:00:00', 0, '23:00:00', '23:00:00', '23:10:00', 10, '2023-03-14 07:28:54', '2023-03-14 07:28:54', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `skpd`
--

CREATE TABLE `skpd` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_skpd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kordinat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak` int(11) NOT NULL DEFAULT 0,
  `polygon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `skpd`
--

INSERT INTO `skpd` (`id`, `kode_skpd`, `nama`, `singkatan`, `kordinat`, `latitude`, `longitude`, `jarak`, `polygon`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '102102', 'Dinas Komunikasi & Informatika', 'Diskominfo-SP', NULL, NULL, NULL, 0, NULL, '2022-06-24 15:08:50', '2022-09-01 00:02:43', '2022-09-01 00:02:43'),
(2, '102104', 'Kepegawaian Daerah', 'BKD', '2.1389616477968745, 117.50275430755585', '2.1389616477969', '117.50275430756', 651, NULL, '2022-06-28 14:28:37', '2023-03-01 04:38:41', '2023-03-01 04:38:41'),
(3, '1', 'Human Resource', 'HR', '-7.004861636750791, 110.42249366184808', '-7.0048616367508', '110.42249366185', 100, NULL, '2022-08-31 23:40:23', '2023-03-01 04:38:44', '2023-03-01 04:38:44'),
(4, '2', 'Pemasaran', 'MKT', '-7.004861636750791, 110.42249366184808', '-7.0048616367508', '110.42249366185', 100, NULL, '2022-08-31 23:46:13', '2023-03-01 04:38:48', '2023-03-01 04:38:48'),
(5, '3', 'Operasional', 'OP', '-7.004861636750791, 110.42249366184808', '-7.0048616367508', '110.42249366185', 100, NULL, '2022-08-31 23:54:11', '2023-03-01 04:38:51', '2023-03-01 04:38:51'),
(6, '5', 'Staf', 'staf', '2.1389616477968745, 117.50275430755585', '2.1389616477969', '117.50275430756', 100, NULL, '2022-10-22 03:59:42', '2023-03-01 04:38:54', '2023-03-01 04:38:54'),
(7, '111111', 'Telkonot', 'TLT', '-8.1277966,112.7509655', '-8.1277966', '112.7509655', 1349, '[[{\"lat\":-8.126283901061166,\"lng\":112.74294548765532},{\"lat\":-8.133633639269245,\"lng\":112.75255931575214},{\"lat\":-8.124287128114265,\"lng\":112.76071390208425},{\"lat\":-8.12016609722336,\"lng\":112.75101423623656}]]', '2023-02-17 15:27:52', '2023-03-01 04:38:57', '2023-03-01 04:38:57'),
(8, '01', 'Head Office PT. Deta Sukses Makmur', 'DSM HO', '-7.006793068102385, 110.41733718795163', '-7.006793068102385', '110.41733718795163', 100, NULL, '2023-03-01 04:39:12', '2023-04-03 13:48:34', NULL),
(9, '04', 'Duta Kekar Plastindo', 'DSM DKP', '-7.430180, 110.804071', '-7.430180', '110.804071', 100, NULL, '2023-03-01 04:40:25', '2023-03-01 04:40:25', NULL),
(10, '05', 'Grapari Telkomsel Yogyakarta', 'DSM Tsel Yogya', '-7.782966,110.361411', '-7.782966', '110.361411', 100, NULL, '2023-03-01 04:44:45', '2023-04-03 13:46:18', NULL),
(11, '06', 'Grapari Telkomsel Solo', 'DSM Telkomsel Solo', '-7.568469752514895, 110.81659026910465', '-7.568469752514895', '110.81659026910465', 100, NULL, '2023-03-01 04:46:48', '2023-03-01 04:46:48', NULL),
(12, '03', 'Jaya Mandiri Plasindo', 'DSM JMP', '-7.4285714909850435, 110.80366654414584', '-7.4285714909850435', '110.80366654414584', 100, NULL, '2023-03-01 04:51:55', '2023-03-01 04:51:55', NULL),
(13, '02', 'Branch Medan', 'DSM MDN', '3°38\'22.3\"N 98°40\'39.2\"E', NULL, NULL, 100, NULL, '2023-03-01 04:53:09', '2023-03-01 04:53:09', NULL),
(14, '07', 'Branch Pekanbaru DSM', 'DSM Pekanbaru', '-2.9375038929811503, 104.68114065445539', '-2.9375038929811503', '104.68114065445539', 100, NULL, '2023-03-01 05:09:40', '2023-03-01 05:09:40', NULL),
(15, '08', 'TELEPERFORMANCE Indonesia', 'DSM_TP_SEMARANG', '-6.985329919289893, 110.41413962221428', '-6.985329919289893', '110.41413962221428', 100, NULL, '2023-04-04 00:34:54', '2023-04-04 00:34:54', NULL),
(16, '09', 'DSM Kantor Cabang Jakarta', 'DSM Jakarta', '-6.326785908126411, 107.14234434636435', '-6.326785908126411', '107.14234434636435', 100, NULL, '2023-04-12 04:08:27', '2023-04-12 04:38:44', NULL),
(17, '10', 'DSM Cabang Surabaya', 'DSM Surabaya', '7.275774,112.732294', '7.275774', '112.732294', 100, NULL, '2023-04-12 04:16:13', '2023-04-12 04:16:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_pegawai`
--

CREATE TABLE `status_pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `status_pegawai`
--

INSERT INTO `status_pegawai` (`id`, `kode_status`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'Tetap', '2022-06-24 14:29:50', '2022-06-24 14:29:50', NULL),
(2, '2', 'Kontrak', '2022-06-24 14:30:01', '2022-06-24 14:30:01', NULL),
(3, '3', 'Pinjaman', '2022-06-29 09:48:38', '2022-07-17 01:41:19', '2022-07-17 01:41:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suku`
--

CREATE TABLE `suku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_suku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suku`
--

INSERT INTO `suku` (`id`, `kode_suku`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '64', 'Velit deleniti sint', '2022-06-26 04:10:51', '2022-06-26 04:10:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkat`
--

CREATE TABLE `tingkat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_skpd` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_tingkat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_jabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_eselon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji_pokok` double DEFAULT NULL,
  `tunjangan` double DEFAULT NULL,
  `kordinat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tingkat`
--

INSERT INTO `tingkat` (`id`, `kode_skpd`, `parent_id`, `kode_tingkat`, `jenis_jabatan`, `nama`, `kode_eselon`, `gaji_pokok`, `tunjangan`, `kordinat`, `latitude`, `longitude`, `jarak`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, '04', NULL, 'JMP STP', '2', 'SATPAM', '3', 4000000, 500000, '-7.42818359133644, 110.80649484042875', '-7.42818359133644', ' 110.80649484042875', 100, '2023-03-14 08:58:57', '2023-03-14 08:58:57', NULL),
(8, '01', NULL, 'DSM 01', '1', 'DIREKSI', '1', 10000000, 10000000, NULL, '0', '0', 100, '2023-04-03 13:51:35', '2023-04-03 13:51:35', NULL),
(9, '01', NULL, 'DSM 02', '1', 'ADMIN_HR', '2', 1, 1, NULL, '0', '0', 100, '2023-04-03 13:52:58', '2023-04-03 13:53:06', NULL),
(10, '01', NULL, 'DSM 03', '1', 'BUK', '2', 1, 1, NULL, '0', '0', 100, '2023-04-03 13:53:57', '2023-04-03 13:53:57', NULL),
(11, '01', NULL, 'DSM 04', '1', 'General Manager', '2', 1, 1, NULL, '0', '0', 100, '2023-04-03 13:54:52', '2023-04-03 13:54:52', NULL),
(12, '01', NULL, 'DSM 05', '1', 'Person in Charge', '3', 1, 1, NULL, '0', '0', 100, '2023-04-03 14:02:00', '2023-04-03 14:02:00', NULL),
(13, '01', NULL, 'DSM 06', '1', 'Finance', '3', 0, 0, '-7.006793068102385, 110.41733718795163', '-7.006793068102385', ' 110.41733718795163', 100, '2023-04-12 03:48:24', '2023-04-12 03:48:24', NULL),
(14, '01', NULL, 'DSM 07', '1', 'General Affair', '3', 0, 0, '-7.006793068102385, 110.41733718795163', '-7.006793068102385', ' 110.41733718795163', 100, '2023-04-12 03:50:45', '2023-04-12 03:50:45', NULL),
(15, '01', NULL, 'DSM 08', '1', 'HR Rekrut', '4', 0, 0, '-7.006793068102385, 110.41733718795163', '-7.006793068102385', ' 110.41733718795163', 100, '2023-04-12 03:52:51', '2023-04-12 03:52:51', NULL),
(16, '03', NULL, 'DSM 0271', '1', 'Person in Charge', '4', 0, 0, '-7.4285714909850435, 110.80366654414584', '-7.4285714909850435', ' 110.80366654414584', 100, '2023-04-12 03:56:29', '2023-04-12 03:56:29', NULL),
(17, '09', NULL, 'DSM 021', '1', 'Person in Charge', '4', 0, 0, '-6.326787, 107.142356', '-6.326787', ' 107.142356', 100, '2023-04-12 04:09:52', '2023-04-12 04:09:52', NULL),
(18, '10', NULL, 'DSM 031', '1', 'Person in Charge', '4', 0, 0, '7.275774,112.732294', '7.275774', '112.732294', 100, '2023-04-12 04:17:05', '2023-04-12 04:17:05', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_izin`
--

CREATE TABLE `total_izin` (
  `id` int(11) NOT NULL,
  `nip` varchar(191) NOT NULL,
  `kode_cuti` varchar(191) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `periode_bulan` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `total_izin`
--

INSERT INTO `total_izin` (`id`, `nip`, `kode_cuti`, `total`, `periode_bulan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, '28', '1', 0, '2023-02', '2023-02-26 13:53:47', NULL, NULL),
(7, '66', '1', 6, '2023-02', '2023-02-26 13:53:47', '2023-02-26 14:07:51', NULL),
(8, '10', '1', 0, '2023-02', '2023-02-26 13:53:47', NULL, NULL),
(9, '111111', '1', 0, '2023-02', '2023-02-26 13:53:47', NULL, NULL),
(10, '77', '1', 0, '2023-02', '2023-02-26 13:53:47', NULL, NULL),
(11, '28', 'M', 0, '2023-04', '2023-04-03 21:27:32', NULL, NULL),
(12, '10', 'M', 0, '2023-04', '2023-04-03 21:27:32', NULL, NULL),
(13, '111111', 'M', 0, '2023-04', '2023-04-03 21:27:32', NULL, NULL),
(14, '28', 'I', 0, '2023-04', '2023-04-03 21:27:44', NULL, NULL),
(15, '10', 'I', 0, '2023-04', '2023-04-03 21:27:44', NULL, NULL),
(16, '111111', 'I', 0, '2023-04', '2023-04-03 21:27:44', NULL, NULL),
(17, '28', 'S', 0, '2023-04', '2023-04-03 21:28:01', NULL, NULL),
(18, '10', 'S', 0, '2023-04', '2023-04-03 21:28:01', NULL, NULL),
(19, '111111', 'S', 0, '2023-04', '2023-04-03 21:28:01', NULL, NULL),
(20, '28', 'C', 0, '2023-04', '2023-04-03 21:28:08', NULL, NULL),
(21, '10', 'C', 0, '2023-04', '2023-04-03 21:28:08', NULL, NULL),
(22, '111111', 'C', 0, '2023-04', '2023-04-03 21:28:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_izin_detail`
--

CREATE TABLE `total_izin_detail` (
  `id` int(11) NOT NULL,
  `nip` int(11) NOT NULL,
  `kode_cuti` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `periode_bulan` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `total_izin_detail`
--

INSERT INTO `total_izin_detail` (`id`, `nip`, `kode_cuti`, `tanggal`, `periode_bulan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:00:40', NULL, NULL),
(6, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:04:27', NULL, NULL),
(7, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:05:28', NULL, NULL),
(8, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:05:57', NULL, NULL),
(9, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:06:06', NULL, NULL),
(10, 66, 1, '2023-02-26', '2023-02', '2023-02-26 14:07:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_presensi`
--

CREATE TABLE `total_presensi` (
  `id` int(11) NOT NULL,
  `nip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masuk` int(11) NOT NULL DEFAULT 0,
  `telat` int(11) NOT NULL DEFAULT 0,
  `alfa` int(11) NOT NULL DEFAULT 0,
  `periode_bulan` varchar(12) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `total_presensi`
--

INSERT INTO `total_presensi` (`id`, `nip`, `masuk`, `telat`, `alfa`, `periode_bulan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(23, '28', 0, 0, 0, '2023-04', '2023-02-26 13:45:20', 0, '2023-04-16 11:25:27', 0, NULL),
(24, '66', 0, 0, 0, '2023-04', '2023-02-26 13:45:20', 0, '2023-02-26 14:07:51', 0, NULL),
(25, '10', 0, 0, 0, '2023-04', '2023-02-26 13:45:20', 0, '2023-04-16 11:25:27', 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_presensi_detail`
--

CREATE TABLE `total_presensi_detail` (
  `id` int(11) NOT NULL,
  `nip` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '1 : Masuk\r\n2 : Telat\r\n3 : Alpha\r\n4 : Izin\r\n',
  `kode_cuti` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'ini terisi jika status 4',
  `tanggal_datang` datetime DEFAULT NULL,
  `kordinat_datang` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_datang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanggal_istirahat` datetime DEFAULT NULL,
  `kordinat_istirahat` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_istirahat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanggal_pulang` datetime DEFAULT NULL,
  `kordinat_pulang` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto_pulang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periode_bulan` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `umk`
--

CREATE TABLE `umk` (
  `id` int(11) NOT NULL,
  `kode_umk` int(20) NOT NULL,
  `kode_kabupaten` varchar(10) DEFAULT NULL,
  `nama_umk` text NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `wilayah` varchar(191) DEFAULT NULL,
  `tahun` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `umk`
--

INSERT INTO `umk` (`id`, `kode_umk`, `kode_kabupaten`, `nama_umk`, `nominal`, `wilayah`, `tahun`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 123123, '3507', 'Malang', 3000000, NULL, '2023', NULL, '2023-03-08 22:42:28', '2023-03-08 22:42:28'),
(2, 1234, '1101', 'Aceh', 800000, NULL, '2023', NULL, '2023-03-08 22:47:20', '2023-03-08 22:47:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar_depan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_belakang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_agama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_kawin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_suku` bigint(20) UNSIGNED DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_ktp` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kordinat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maks_cuti` int(11) NOT NULL DEFAULT 12,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `owner` int(11) NOT NULL DEFAULT 0 COMMENT '1: owner 0: non owner',
  `fcm_token_web` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm_token_android` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `nik`, `name`, `gelar_depan`, `gelar_belakang`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kode_agama`, `kode_status`, `kode_kawin`, `kode_suku`, `golongan_darah`, `alamat`, `alamat_ktp`, `image`, `email`, `no_hp`, `kordinat`, `latitude`, `longitude`, `jarak`, `email_verified_at`, `password`, `remember_token`, `maks_cuti`, `deleted_at`, `created_at`, `updated_at`, `owner`, `fcm_token_web`, `fcm_token_android`) VALUES
(2, '28', '36', 'Ananda Adi Kusuma', NULL, 'S.Kom', 'Semarang', '1990-11-25', 'perempuan', 'islam', '1', 'kawin', 64, 'O', 'Jl. Cinde Selatan No 64 A Semarang', 'Jl. Cinde Selatan No 64 A Semarang', 'data_pegawai/28/foto/1681051158_amir-seilsepour-5vg_SarQimA-unsplash.jpg', 'adminjaringan@gmail.com', '6285712893128', '-7.006793068102385, 110.41733718795163', '-7.006793068102385', '110.41733718795163', 0, NULL, '$2y$10$h1U6QImUsXPnPx31LxjTmupUC75DZE.62rSTw0EaPZiqfSLyGEuAu', NULL, 11, NULL, '2022-06-26 04:11:08', '2023-04-14 00:41:05', 0, NULL, NULL),
(3, '66', '83', 'BUDI', 'Dr', 'ST, MT', 'Berau', '2012-02-11', 'laki-laki', 'islam', '2', 'belum kawin', 64, 'B', 'Durian', 'biduk', 'jampack/dist/img/businessman.png', 'cv.karyamuda.km@gmail.com', '085316787777', '-7.147382932171307, 110.4144753843769', '-7.1473829321713', '110.41447538438', 2147483647, NULL, '$2y$10$l/qWZ0e1kxR2qdw4V11djOLbHmiCBrI4hDBCvRSLaKf13nE9L0eSu', NULL, 12, '2023-03-14 07:39:17', '2022-06-26 05:11:51', '2023-03-14 07:39:17', 0, NULL, NULL),
(4, '10', '10', 'Agus Maryadi', NULL, 'S.H', 'Semarang', '1990-08-03', 'perempuan', 'islam', '2', 'kawin', 64, 'O', 'Semarang', 'Semarang', 'data_pegawai/10/foto/1680758852_logan-weaver-lgnwvr-IVXoVHXqVCY-unsplash.jpg', 'agus@detasuksesmakmur.com', '08571212121211', NULL, NULL, NULL, 0, NULL, '$2y$10$yEhXY7pLJMfcFJW2cJm8aOoVEfIKFxgjjEf4Hgo7ion9S9Ccrh0Fe', NULL, 12, NULL, '2022-08-03 09:04:58', '2023-04-06 05:27:32', 0, NULL, NULL),
(22, NULL, NULL, 'owner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'owner@gmail.com', NULL, NULL, NULL, NULL, 0, NULL, '$2y$10$4jUWDksXe559stZnEB..f.c0roORJZ9ARn.Vt9ozjmtDp.uz2TxmC', NULL, 12, NULL, '2023-04-13 23:41:59', '2023-04-13 23:41:59', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `villages`
--

CREATE TABLE `villages` (
  `id` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `visit_lokasi`
--

CREATE TABLE `visit_lokasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_visit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kordinat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jarak` int(11) NOT NULL,
  `polygon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visit_lokasi`
--

INSERT INTO `visit_lokasi` (`id`, `kode_visit`, `qr`, `nama`, `kordinat`, `jarak`, `polygon`, `created_at`, `updated_at`) VALUES
(1, '4e4d902a-37a1-4005-839b-fce03784ef29', '', 'PT. Telkom Sumatra', '-4.008623719794147, 119.62394763518633', 5000, '[[{\"lat\":-4.008607572949019,\"lng\":119.6238212181534},{\"lat\":-4.008917947940568,\"lng\":119.62380512357512},{\"lat\":-4.008992866024305,\"lng\":119.62456425118431},{\"lat\":-4.008626302477701,\"lng\":119.62457229847347}]]', '2022-08-29 02:55:28', '2023-02-23 01:31:20'),
(2, '578b7d6c-4300-4fbc-8cd5-e5eba61046a6', '', 'Assumenda laborum fu', '-4.008427, 119.622869', 2147483647, '', '2022-08-29 03:57:20', '2022-08-29 03:57:20'),
(3, 'fe561a8f-d6b9-4d1c-a785-92cba469c32e', '3a90ab91-5551-47b4-bfc7-100f2d480450.svg', 'Telkomsel', '-8.1093477,112.7086424', 1255, '[[{\"lat\":-8.105753661926638,\"lng\":112.70354944176579},{\"lat\":-8.113146261664273,\"lng\":112.70440781927442},{\"lat\":-8.113868519856402,\"lng\":112.7115323737833},{\"lat\":-8.109534951159272,\"lng\":112.71548091032307},{\"lat\":-8.103714300140087,\"lng\":112.71101734021573}]]', '2023-02-17 15:10:50', '2023-02-27 10:16:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aktifitas`
--
ALTER TABLE `aktifitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `app_status_function`
--
ALTER TABLE `app_status_function`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_kurang_payroll`
--
ALTER TABLE `daftar_kurang_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `daftar_tambah_payroll`
--
ALTER TABLE `daftar_tambah_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_payroll`
--
ALTER TABLE `data_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_pengajuan_cuti`
--
ALTER TABLE `data_pengajuan_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_pengajuan_lembur`
--
ALTER TABLE `data_pengajuan_lembur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_pengajuan_reimbursement`
--
ALTER TABLE `data_pengajuan_reimbursement`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_presensi`
--
ALTER TABLE `data_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_visit`
--
ALTER TABLE `data_visit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `districts`
--
ALTER TABLE `districts`
  ADD KEY `districts_regency_id_foreign` (`regency_id`),
  ADD KEY `districts_id_index` (`id`);

--
-- Indeks untuk tabel `eselon`
--
ALTER TABLE `eselon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `generate_payroll`
--
ALTER TABLE `generate_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `imei`
--
ALTER TABLE `imei`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lainnya`
--
ALTER TABLE `lainnya`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi_detail`
--
ALTER TABLE `lokasi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `ms_absensi`
--
ALTER TABLE `ms_absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_lembur`
--
ALTER TABLE `ms_lembur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lembur_jam_unique` (`jam`);

--
-- Indeks untuk tabel `ms_pengurangan`
--
ALTER TABLE `ms_pengurangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_potongan`
--
ALTER TABLE `ms_potongan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_tambahan`
--
ALTER TABLE `ms_tambahan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_tunjangan`
--
ALTER TABLE `ms_tunjangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `payroll_kurang`
--
ALTER TABLE `payroll_kurang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payroll_tambah`
--
ALTER TABLE `payroll_tambah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `provinces`
--
ALTER TABLE `provinces`
  ADD KEY `provinces_id_index` (`id`);

--
-- Indeks untuk tabel `ref_city`
--
ALTER TABLE `ref_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `prov_code` (`parent`);

--
-- Indeks untuk tabel `regencies`
--
ALTER TABLE `regencies`
  ADD KEY `regencies_province_id_foreign` (`province_id`),
  ADD KEY `regencies_id_index` (`id`);

--
-- Indeks untuk tabel `reimbursement`
--
ALTER TABLE `reimbursement`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_bahasa`
--
ALTER TABLE `riwayat_bahasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_cuti`
--
ALTER TABLE `riwayat_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_kgb`
--
ALTER TABLE `riwayat_kgb`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_kursus`
--
ALTER TABLE `riwayat_kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_lainnya`
--
ALTER TABLE `riwayat_lainnya`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_lhkasn`
--
ALTER TABLE `riwayat_lhkasn`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_lhkpn`
--
ALTER TABLE `riwayat_lhkpn`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_organisasi`
--
ALTER TABLE `riwayat_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_penghargaan`
--
ALTER TABLE `riwayat_penghargaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_pmk`
--
ALTER TABLE `riwayat_pmk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_potongan`
--
ALTER TABLE `riwayat_potongan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_shift`
--
ALTER TABLE `riwayat_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_spt`
--
ALTER TABLE `riwayat_spt`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_status`
--
ALTER TABLE `riwayat_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat_tunjangan`
--
ALTER TABLE `riwayat_tunjangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skpd`
--
ALTER TABLE `skpd`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `status_pegawai`
--
ALTER TABLE `status_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suku`
--
ALTER TABLE `suku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tingkat_kode_tingkat_unique` (`kode_tingkat`);

--
-- Indeks untuk tabel `total_izin`
--
ALTER TABLE `total_izin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `total_izin_detail`
--
ALTER TABLE `total_izin_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `total_presensi`
--
ALTER TABLE `total_presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `total_presensi_detail`
--
ALTER TABLE `total_presensi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `umk`
--
ALTER TABLE `umk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `villages`
--
ALTER TABLE `villages`
  ADD KEY `villages_district_id_foreign` (`district_id`),
  ADD KEY `villages_id_index` (`id`);

--
-- Indeks untuk tabel `visit_lokasi`
--
ALTER TABLE `visit_lokasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aktifitas`
--
ALTER TABLE `aktifitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `app_status_function`
--
ALTER TABLE `app_status_function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `daftar_kurang_payroll`
--
ALTER TABLE `daftar_kurang_payroll`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `daftar_tambah_payroll`
--
ALTER TABLE `daftar_tambah_payroll`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `data_payroll`
--
ALTER TABLE `data_payroll`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `data_pengajuan_cuti`
--
ALTER TABLE `data_pengajuan_cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `data_pengajuan_lembur`
--
ALTER TABLE `data_pengajuan_lembur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `data_pengajuan_reimbursement`
--
ALTER TABLE `data_pengajuan_reimbursement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `data_presensi`
--
ALTER TABLE `data_presensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `data_visit`
--
ALTER TABLE `data_visit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `eselon`
--
ALTER TABLE `eselon`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `generate_payroll`
--
ALTER TABLE `generate_payroll`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `imei`
--
ALTER TABLE `imei`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lainnya`
--
ALTER TABLE `lainnya`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `lokasi_detail`
--
ALTER TABLE `lokasi_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `ms_absensi`
--
ALTER TABLE `ms_absensi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `ms_lembur`
--
ALTER TABLE `ms_lembur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `ms_pengurangan`
--
ALTER TABLE `ms_pengurangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ms_potongan`
--
ALTER TABLE `ms_potongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ms_tambahan`
--
ALTER TABLE `ms_tambahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `ms_tunjangan`
--
ALTER TABLE `ms_tunjangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `payroll_kurang`
--
ALTER TABLE `payroll_kurang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `payroll_tambah`
--
ALTER TABLE `payroll_tambah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `penghargaan`
--
ALTER TABLE `penghargaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ref_city`
--
ALTER TABLE `ref_city`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id entry', AUTO_INCREMENT=515;

--
-- AUTO_INCREMENT untuk tabel `reimbursement`
--
ALTER TABLE `reimbursement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `riwayat_bahasa`
--
ALTER TABLE `riwayat_bahasa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `riwayat_cuti`
--
ALTER TABLE `riwayat_cuti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kgb`
--
ALTER TABLE `riwayat_kgb`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `riwayat_kursus`
--
ALTER TABLE `riwayat_kursus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `riwayat_lainnya`
--
ALTER TABLE `riwayat_lainnya`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_lhkasn`
--
ALTER TABLE `riwayat_lhkasn`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_lhkpn`
--
ALTER TABLE `riwayat_lhkpn`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_organisasi`
--
ALTER TABLE `riwayat_organisasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pendidikan`
--
ALTER TABLE `riwayat_pendidikan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `riwayat_penghargaan`
--
ALTER TABLE `riwayat_penghargaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pmk`
--
ALTER TABLE `riwayat_pmk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_potongan`
--
ALTER TABLE `riwayat_potongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `riwayat_shift`
--
ALTER TABLE `riwayat_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `riwayat_spt`
--
ALTER TABLE `riwayat_spt`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_status`
--
ALTER TABLE `riwayat_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat_tunjangan`
--
ALTER TABLE `riwayat_tunjangan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `skpd`
--
ALTER TABLE `skpd`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `status_pegawai`
--
ALTER TABLE `status_pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `suku`
--
ALTER TABLE `suku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `total_izin`
--
ALTER TABLE `total_izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `total_izin_detail`
--
ALTER TABLE `total_izin_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `total_presensi`
--
ALTER TABLE `total_presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `total_presensi_detail`
--
ALTER TABLE `total_presensi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `umk`
--
ALTER TABLE `umk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `visit_lokasi`
--
ALTER TABLE `visit_lokasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_regency_id_foreign` FOREIGN KEY (`regency_id`) REFERENCES `regencies` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `regencies`
--
ALTER TABLE `regencies`
  ADD CONSTRAINT `regencies_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `villages`
--
ALTER TABLE `villages`
  ADD CONSTRAINT `villages_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
