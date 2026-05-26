-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2026 pada 07.04
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akademik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `date_label` varchar(50) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `date_label`, `urutan`) VALUES
(1, 'Semester Baru Siap Dibuka', 'Dashboard ini sudah disiapkan sebagai fondasi SIAKAD dan dapat dilanjutkan ke modul KRS, jadwal, dan nilai.', '25 Mei 2026', 1),
(2, 'Integrasi Database Aktif', 'Seluruh data portal kini diprioritaskan dari database MySQL agar siap dikembangkan menjadi aplikasi akademik penuh.', '25 Mei 2026', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `billing_summary`
--

CREATE TABLE `billing_summary` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `message` text NOT NULL,
  `status_label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `billing_summary`
--

INSERT INTO `billing_summary` (`id`, `title`, `message`, `status_label`) VALUES
(1, 'Belum Ada Tagihan Baru', 'Terima kasih telah melunasi tagihan akademik di periode ini.', 'Lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nidn` varchar(30) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `status_jabatan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id`, `user_id`, `nidn`, `nama`, `prodi`, `status_jabatan`, `created_at`) VALUES
(1, 6, '0112038901', 'Dr. Rina Pratama, M.Kom', 'Informatika', 'Dosen Tetap', '2026-05-25 05:23:00'),
(2, 4, '0215079102', 'Agus Saputra, S.Kom., M.T', 'Sistem Informasi', 'Kaprodi', '2026-05-25 05:23:00'),
(3, NULL, '0311088803', 'Maya Lestari, M.Cs', 'Teknik Komputer', 'Dosen Tetap', '2026-05-25 05:23:00'),
(4, NULL, '0410119204', 'Fajar Ramadhan, S.T., M.Kom', 'Informatika', 'Koordinator Lab', '2026-05-25 05:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fakultas`
--

CREATE TABLE `fakultas` (
  `id` int(11) NOT NULL,
  `kode_fakultas` varchar(20) NOT NULL,
  `nama_fakultas` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fakultas`
--

INSERT INTO `fakultas` (`id`, `kode_fakultas`, `nama_fakultas`, `created_at`) VALUES
(1, 'FTI', 'Fakultas Teknologi Informasi', '2026-05-26 04:39:29'),
(2, 'FEB', 'Fakultas Ekonomi dan Bisnis', '2026-05-26 04:39:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_kuliah`
--

CREATE TABLE `jadwal_kuliah` (
  `id` int(11) NOT NULL,
  `hari` varchar(30) NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `mata_kuliah` varchar(120) NOT NULL,
  `dosen` varchar(120) NOT NULL,
  `ruang` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_kuliah`
--

INSERT INTO `jadwal_kuliah` (`id`, `hari`, `waktu`, `mata_kuliah`, `dosen`, `ruang`, `created_at`) VALUES
(1, 'Senin', '08:00 - 10:30', 'Struktur Data', 'Dr. Rina Pratama, M.Kom', 'Lab Komputer 1', '2026-05-25 05:23:00'),
(2, 'Selasa', '10:30 - 13:00', 'Analisis Proses Bisnis', 'Agus Saputra, S.Kom., M.T', 'Ruang 2.3', '2026-05-25 05:23:00'),
(3, 'Rabu', '13:00 - 15:30', 'Pemrograman Web', 'Fajar Ramadhan, S.T., M.Kom', 'Lab Web', '2026-05-25 05:23:00'),
(4, 'Kamis', '08:00 - 10:30', 'Jaringan Komputer', 'Maya Lestari, M.Cs', 'Lab Jaringan', '2026-05-25 05:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `fakultas_id` int(11) DEFAULT NULL,
  `kode_jurusan` varchar(20) NOT NULL,
  `nama_jurusan` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `fakultas_id`, `kode_jurusan`, `nama_jurusan`, `created_at`) VALUES
(1, 1, 'IF', 'Informatika', '2026-05-26 04:39:29'),
(2, 1, 'SI', 'Sistem Informasi', '2026-05-26 04:39:29'),
(3, 1, 'TK', 'Teknik Komputer', '2026-05-26 04:39:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kalender_akademik`
--

CREATE TABLE `kalender_akademik` (
  `id` int(11) NOT NULL,
  `tanggal_label` varchar(60) NOT NULL,
  `agenda` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kalender_akademik`
--

INSERT INTO `kalender_akademik` (`id`, `tanggal_label`, `agenda`, `urutan`) VALUES
(1, '03 Juni 2026', 'Pembukaan pengisian KRS semester ganjil', 1),
(2, '10 Juni 2026', 'Batas akhir persetujuan dosen wali', 2),
(3, '17 Juni 2026', 'Publikasi jadwal kuliah dan ruang', 3),
(4, '24 Juni 2026', 'Awal perkuliahan aktif', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `krs`
--

CREATE TABLE `krs` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) DEFAULT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `semester` int(11) NOT NULL,
  `sks_diambil` int(11) NOT NULL,
  `status_krs` varchar(80) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `krs`
--

INSERT INTO `krs` (`id`, `mahasiswa_id`, `nim`, `nama`, `semester`, `sks_diambil`, `status_krs`, `created_at`) VALUES
(1, 1, '101', 'Andi', 4, 21, 'Disetujui', '2026-05-25 05:23:00'),
(2, 2, '102', 'Budi', 4, 20, 'Menunggu Validasi', '2026-05-25 05:23:00'),
(3, 3, '103', 'Citra', 6, 22, 'Disetujui', '2026-05-25 05:23:00'),
(4, 4, '104', 'Doni', 2, 18, 'Perlu Revisi', '2026-05-25 05:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `jurusan_id` int(11) DEFAULT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `jurusan_id`, `nim`, `nama`, `jurusan`, `created_at`) VALUES
(1, 1, '101', 'Andi', 'Informatika', '2026-04-06 04:39:38'),
(2, 2, '102', 'Budi', 'Sistem Informasi', '2026-04-06 04:39:38'),
(3, 3, '103', 'Citra', 'Teknik Komputer', '2026-04-06 04:39:38'),
(4, 1, '104', 'Doni', 'Informatika', '2026-04-06 04:39:38'),
(5, NULL, '105', 'Eka', 'Teknik Jaringan', '2026-04-06 04:39:38'),
(6, 2, '106', 'Farah', 'Sistem Informasi', '2026-04-06 04:39:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `sks` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id`, `kode`, `nama`, `sks`, `semester`, `prodi`, `created_at`) VALUES
(1, 'IF201', 'Struktur Data', 3, 3, 'Informatika', '2026-05-25 05:23:00'),
(2, 'SI204', 'Analisis Proses Bisnis', 3, 3, 'Sistem Informasi', '2026-05-25 05:23:00'),
(3, 'IF305', 'Pemrograman Web', 3, 5, 'Informatika', '2026-05-25 05:23:00'),
(4, 'TK302', 'Jaringan Komputer', 3, 5, 'Teknik Komputer', '2026-05-25 05:23:00'),
(5, 'UM101', 'Pancasila', 2, 1, 'Umum', '2026-05-25 05:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mini_calendar_events`
--

CREATE TABLE `mini_calendar_events` (
  `id` int(11) NOT NULL,
  `month_label` varchar(40) NOT NULL,
  `date_label` varchar(30) NOT NULL,
  `text_value` varchar(160) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mini_calendar_events`
--

INSERT INTO `mini_calendar_events` (`id`, `month_label`, `date_label`, `text_value`, `urutan`) VALUES
(1, 'May, 2026', '25 Mei', 'Perkuliahan minggu ke-10', 1),
(2, 'May, 2026', '27 Mei', 'Validasi KRS mahasiswa wali', 2),
(3, 'May, 2026', '31 Mei', 'Batas input nilai tugas', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_mahasiswa`
--

CREATE TABLE `nilai_mahasiswa` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) DEFAULT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `ips` decimal(3,2) NOT NULL,
  `ipk` decimal(3,2) NOT NULL,
  `status_nilai` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_mahasiswa`
--

INSERT INTO `nilai_mahasiswa` (`id`, `mahasiswa_id`, `nim`, `nama`, `ips`, `ipk`, `status_nilai`, `created_at`) VALUES
(1, 1, '101', 'Andi', 3.72, 3.68, 'Baik Sekali', '2026-05-25 05:23:00'),
(2, 2, '102', 'Budi', 3.40, 3.45, 'Baik', '2026-05-25 05:23:00'),
(3, 3, '103', 'Citra', 3.88, 3.81, 'Cumlaude Track', '2026-05-25 05:23:00'),
(4, 4, '104', 'Doni', 3.15, 3.22, 'Stabil', '2026-05-25 05:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `total_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `total_count`) VALUES
(1, 94);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal_features`
--

CREATE TABLE `portal_features` (
  `id` int(11) NOT NULL,
  `slug` varchar(80) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category` varchar(80) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portal_features`
--

INSERT INTO `portal_features` (`id`, `slug`, `title`, `category`, `description`) VALUES
(1, 'pengumuman', 'Pengumuman Kampus', 'Jadwal', 'Informasi resmi kampus terkait agenda kuliah, kegiatan, dan layanan akademik.'),
(2, 'kalender-akademik', 'Kalender Akademik', 'Jadwal', 'Agenda semester yang membantu mahasiswa, dosen, dan admin memantau ritme perkuliahan.'),
(3, 'jadwal-minggu-ini', 'Jadwal Minggu Ini', 'Jadwal', 'Ringkasan aktivitas perkuliahan dan agenda akademik selama satu minggu ke depan.'),
(4, 'jadwal-semester', 'Jadwal Semester', 'Jadwal', 'Kelas semester aktif dengan sebaran waktu, dosen, dan ruang perkuliahan.'),
(5, 'pengisian-krs', 'Pengisian Kartu Rencana Studi', 'Akademik', 'Tentukan mata kuliah semester aktif dan kirim ke dosen wali untuk validasi.'),
(6, 'riwayat-krs', 'Riwayat KRS', 'Akademik', 'Lihat histori rencana studi dari semester ke semester.'),
(7, 'kurikulum-mahasiswa', 'Kurikulum Mahasiswa', 'Akademik', 'Susunan mata kuliah wajib, pilihan, dan capaian belajar program studi.'),
(8, 'mengulang', 'Riwayat Mengulang Mata Kuliah', 'Akademik', 'Pantau mata kuliah yang pernah diambil ulang untuk perbaikan nilai.'),
(9, 'nilai-mahasiswa', 'Nilai Mahasiswa', 'Akademik', 'Detail nilai per mata kuliah dan performa semester aktif.'),
(10, 'aktivitas-prestasi', 'Aktivitas & Prestasi', 'Akademik', 'Dokumentasi kegiatan mahasiswa, kompetisi, dan rekam prestasi akademik/non-akademik.'),
(11, 'konsultasi', 'Konsultasi', 'Tingkat Akhir', 'Ruang konsultasi akademik dan pengerjaan tugas akhir bersama dosen pembimbing.'),
(12, 'kegiatan-pendukung', 'Kegiatan Pendukung', 'Tingkat Akhir', 'Workshop, seminar, dan pelatihan yang mendukung penyelesaian studi akhir.'),
(13, 'daftar-proposal', 'Daftar Proposal', 'Tingkat Akhir', 'Pantau tahapan pengajuan proposal dan dokumen pendukung penelitian.'),
(14, 'daftar-tugas-akhir', 'Daftar Tugas Akhir', 'Tingkat Akhir', 'Ringkasan progres naskah tugas akhir dari proposal sampai sidang.'),
(15, 'pengajuan-yudisium', 'Pengajuan Yudisium', 'Tingkat Akhir', 'Persiapan dokumen kelulusan dan kelayakan mengikuti yudisium.'),
(16, 'pengajuan-wisuda', 'Pengajuan Wisuda', 'Tingkat Akhir', 'Konfirmasi tahapan wisuda dan kebutuhan administrasi akhir mahasiswa.'),
(17, 'kartu-hasil-studi', 'Kartu Hasil Studi', 'Hasil Studi', 'Ringkasan nilai resmi per semester yang siap diunduh dan dicetak.'),
(18, 'transkrip', 'Transkrip Nilai', 'Hasil Studi', 'Rekap seluruh mata kuliah yang telah ditempuh beserta bobot nilai dan IPK.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal_feature_items`
--

CREATE TABLE `portal_feature_items` (
  `id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `title` varchar(180) NOT NULL,
  `meta_text` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portal_feature_items`
--

INSERT INTO `portal_feature_items` (`id`, `feature_id`, `title`, `meta_text`, `urutan`) VALUES
(1, 1, 'Perubahan ruang kuliah Pemrograman Mobile 1', 'Ruang berpindah ke Lab WTD A Lt.3', 1),
(2, 1, 'Pembukaan pengajuan beasiswa internal', 'Periode pengisian 25 Mei - 10 Juni 2026', 2),
(3, 1, 'Batas akhir validasi KRS', 'Mahasiswa wajib final sebelum 10 Juni 2026', 3),
(4, 2, '03 Juni 2026', 'Pembukaan pengisian KRS semester ganjil', 1),
(5, 2, '10 Juni 2026', 'Batas akhir persetujuan dosen wali', 2),
(6, 2, '17 Juni 2026', 'Publikasi jadwal kuliah dan ruang', 3),
(7, 3, 'Senin - Bahasa Inggris 2', '08:50 - 09:30 WIB - Ruang 4.5A', 1),
(8, 3, 'Rabu - Pemrograman Web', '13:00 - 15:30 WIB - Lab Web', 2),
(9, 3, 'Jumat - Konsultasi Dosen Wali', '09:00 - 10:00 WIB - Online', 3),
(10, 4, 'Struktur Data', 'Senin - 08:00 - 10:30 - Lab Komputer 1', 1),
(11, 4, 'Pemrograman Mobile 1', 'Senin - 13:30 - 15:00 - Lab WTD', 2),
(12, 4, 'Bahasa Inggris 2', 'Senin - 08:50 - 09:30 - Ruang 4.5A', 3),
(13, 5, 'Pemrograman Mobile 1', '3 SKS - Wajib - Kelas MI4AP', 1),
(14, 5, 'Bahasa Inggris 2', '2 SKS - Wajib - Kelas MI4AP', 2),
(15, 5, 'Jaringan Komputer', '3 SKS - Pilihan - Kelas TK5A', 3),
(16, 6, 'Semester 1', '20 SKS - Disetujui - IPS 3.58', 1),
(17, 6, 'Semester 2', '22 SKS - Disetujui - IPS 3.72', 2),
(18, 6, 'Semester 3', '21 SKS - Disetujui - IPS 3.81', 3),
(19, 7, 'Kelompok Dasar', 'Matematika, Algoritma, Bahasa Inggris', 1),
(20, 7, 'Kelompok Inti', 'Struktur Data, Basis Data, Web, Mobile', 2),
(21, 7, 'Kelompok Penunjang', 'Kewirausahaan, Etika Profesi', 3),
(22, 8, 'Logika Informatika', 'Nilai awal C - Perbaikan menjadi B+', 1),
(23, 8, 'Praktikum Dasar', 'Tidak ada pengulangan aktif', 2),
(24, 8, 'Evaluasi Semester', 'Konsultasikan dengan dosen wali bila perlu', 3),
(25, 9, 'Struktur Data', 'A- - 3 SKS', 1),
(26, 9, 'Pemrograman Web', 'A - 3 SKS', 2),
(27, 9, 'Bahasa Inggris 2', 'B+ - 2 SKS', 3),
(28, 10, 'Asisten Laboratorium Web', 'Semester Genap 2025/2026', 1),
(29, 10, 'Juara 2 Hackathon Internal', 'Kategori aplikasi pendidikan', 2),
(30, 10, 'Seminar Nasional IT', 'Peserta aktif dan pemakalah', 3),
(31, 11, 'Konsultasi Proposal', 'Rabu, 27 Mei 2026 - Online', 1),
(32, 11, 'Review Bab 2', 'Senin, 1 Juni 2026 - Ruang Dosen', 2),
(33, 11, 'Catatan Pembimbing', 'Perbaiki metodologi dan tinjauan pustaka', 3),
(34, 12, 'Workshop Penulisan Ilmiah', '31 Mei 2026 - Aula Kampus', 1),
(35, 12, 'Pelatihan Referensi Mendeley', 'Online - Gratis', 2),
(36, 12, 'Seminar Metodologi Penelitian', 'Wajib untuk mahasiswa tingkat akhir', 3),
(37, 13, 'Sistem Informasi Akademik Berbasis Web', 'Status review oleh kaprodi', 1),
(38, 13, 'Catatan Revisi 1', 'Tambahkan studi literatur terbaru', 2),
(39, 13, 'Catatan Revisi 2', 'Perjelas skenario pengujian sistem', 3),
(40, 14, 'Bab 1 - Pendahuluan', 'Selesai', 1),
(41, 14, 'Bab 2 - Tinjauan Pustaka', 'Selesai dengan revisi minor', 2),
(42, 14, 'Bab 4 - Implementasi', 'Sedang disusun', 3),
(43, 15, 'Transkrip sementara', 'Sudah diunggah', 1),
(44, 15, 'Bukti bebas pustaka', 'Menunggu verifikasi', 2),
(45, 15, 'Surat bebas administrasi', 'Sudah terbit', 3),
(46, 16, 'Form pendaftaran wisuda', 'Akan dibuka setelah yudisium', 1),
(47, 16, 'Konfirmasi toga', 'Menunggu pengumuman BAAK', 2),
(48, 16, 'Cetak kartu peserta', 'Tersedia setelah pembayaran valid', 3),
(49, 17, 'KHS Semester 1', '20 SKS - IPS 3.58', 1),
(50, 17, 'KHS Semester 2', '22 SKS - IPS 3.72', 2),
(51, 17, 'KHS Semester 3', '21 SKS - IPS 3.81', 3),
(52, 18, 'Algoritma Pemrograman', 'A - 3 SKS', 1),
(53, 18, 'Basis Data', 'A- - 3 SKS', 2),
(54, 18, 'Pemrograman Web', 'A - 3 SKS', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal_feature_stats`
--

CREATE TABLE `portal_feature_stats` (
  `id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value_text` varchar(60) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portal_feature_stats`
--

INSERT INTO `portal_feature_stats` (`id`, `feature_id`, `label`, `value_text`, `urutan`) VALUES
(1, 1, 'Pengumuman Aktif', '4', 1),
(2, 1, 'Mendesak', '1', 2),
(3, 1, 'Sudah Dibaca', '12', 3),
(4, 2, 'Agenda Bulan Ini', '8', 1),
(5, 2, 'Tenggat Dekat', '3', 2),
(6, 2, 'Periode Aktif', 'Minggu 10', 3),
(7, 3, 'Total Kelas', '6', 1),
(8, 3, 'Praktikum', '2', 2),
(9, 3, 'Konsultasi', '1', 3),
(10, 4, 'Total Mata Kuliah', '7', 1),
(11, 4, 'Total SKS', '21', 2),
(12, 4, 'Ruang Dipakai', '5', 3),
(13, 5, 'SKS Maksimum', '24', 1),
(14, 5, 'SKS Dipilih', '21', 2),
(15, 5, 'Status', 'Menunggu Validasi', 3),
(16, 6, 'Semester Tercatat', '4', 1),
(17, 6, 'SKS Lulus', '63', 2),
(18, 6, 'IPK Sementara', '3.74', 3),
(19, 7, 'Total MK', '48', 1),
(20, 7, 'MK Lulus', '17', 2),
(21, 7, 'Sisa SKS', '81', 3),
(22, 8, 'Pernah Mengulang', '1', 1),
(23, 8, 'Nilai Membaik', '1', 2),
(24, 8, 'Sedang Proses', '0', 3),
(25, 9, 'IPS Terakhir', '3.81', 1),
(26, 9, 'IPK', '3.74', 2),
(27, 9, 'Predikat', 'Sangat Baik', 3),
(28, 10, 'Kegiatan Aktif', '3', 1),
(29, 10, 'Prestasi Tercatat', '2', 2),
(30, 10, 'Portofolio', 'Lengkap', 3),
(31, 11, 'Sesi Bulan Ini', '4', 1),
(32, 11, 'Pembimbing', '2', 2),
(33, 11, 'Status', 'Aktif', 3),
(34, 12, 'Workshop', '2', 1),
(35, 12, 'Seminar', '1', 2),
(36, 12, 'Sertifikat', '3', 3),
(37, 13, 'Proposal Diajukan', '1', 1),
(38, 13, 'Status', 'Review', 2),
(39, 13, 'Revisi', '2', 3),
(40, 14, 'Progress', '72%', 1),
(41, 14, 'Bab Selesai', '4', 2),
(42, 14, 'Target Sidang', 'Juli 2026', 3),
(43, 15, 'Dokumen Lengkap', '6', 1),
(44, 15, 'Kurang', '1', 2),
(45, 15, 'Status', 'Persiapan', 3),
(46, 16, 'Periode Wisuda', 'Gelombang 2', 1),
(47, 16, 'Status', 'Belum Dibuka', 2),
(48, 16, 'Checklist', '70%', 3),
(49, 17, 'Semester Tersedia', '4', 1),
(50, 17, 'IPS Terakhir', '3.81', 2),
(51, 17, 'Status', 'Terverifikasi', 3),
(52, 18, 'Mata Kuliah Lulus', '17', 1),
(53, 18, 'Total SKS', '63', 2),
(54, 18, 'IPK', '3.74', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal_navigation`
--

CREATE TABLE `portal_navigation` (
  `id` int(11) NOT NULL,
  `menu_key` varchar(50) NOT NULL,
  `label` varchar(80) NOT NULL,
  `url_path` varchar(150) NOT NULL,
  `heading` varchar(80) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portal_navigation`
--

INSERT INTO `portal_navigation` (`id`, `menu_key`, `label`, `url_path`, `heading`, `urutan`) VALUES
(1, 'dashboard', 'Beranda', 'dashboard', NULL, 1),
(2, 'jadwal_portal', 'Jadwal', '#', 'Jadwal', 2),
(3, 'akademik_portal', 'Akademik', '#', 'Akademik', 3),
(4, 'tingkat_akhir_portal', 'Tingkat Akhir', '#', 'Tingkat Akhir', 4),
(5, 'hasil_studi_portal', 'Hasil Studi', '#', 'Hasil Studi', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `portal_navigation_items`
--

CREATE TABLE `portal_navigation_items` (
  `id` int(11) NOT NULL,
  `navigation_id` int(11) NOT NULL,
  `label` varchar(120) NOT NULL,
  `description` varchar(200) NOT NULL,
  `icon_code` varchar(12) NOT NULL,
  `url_path` varchar(150) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `portal_navigation_items`
--

INSERT INTO `portal_navigation_items` (`id`, `navigation_id`, `label`, `description`, `icon_code`, `url_path`, `urutan`) VALUES
(1, 2, 'Pengumuman', 'Informasi kegiatan kampus', 'PG', 'portal/feature/pengumuman', 1),
(2, 2, 'Kalender Akademik', 'Periksa kegiatan perkuliahan', 'KA', 'portal/feature/kalender-akademik', 2),
(3, 2, 'Jadwal Minggu Ini', 'Aktivitas seminggu ke depan', 'JM', 'portal/feature/jadwal-minggu-ini', 3),
(4, 2, 'Jadwal Semester', 'Kegiatan Anda satu semester', 'JS', 'portal/feature/jadwal-semester', 4),
(5, 3, 'Pengisian Kartu Rencana Studi', 'Tentukan rencana kuliah', 'KRS', 'portal/feature/pengisian-krs', 1),
(6, 3, 'Riwayat KRS', 'Rekap rencana kuliah Anda', 'RK', 'portal/feature/riwayat-krs', 2),
(7, 3, 'Kurikulum Mahasiswa', 'Ketentuan proses perkuliahan', 'KM', 'portal/feature/kurikulum-mahasiswa', 3),
(8, 3, 'Mengulang', 'Histori perbaikan mata kuliah', 'MG', 'portal/feature/mengulang', 4),
(9, 3, 'Nilai Mahasiswa', 'Kualitas perkuliahan Anda', 'NM', 'portal/feature/nilai-mahasiswa', 5),
(10, 3, 'Aktivitas & Prestasi', 'Kegiatan mahasiswa wali', 'AP', 'portal/feature/aktivitas-prestasi', 6),
(11, 4, 'Konsultasi', 'Temukan solusi masalah Anda', 'KS', 'portal/feature/konsultasi', 1),
(12, 4, 'Kegiatan Pendukung', 'Salurkan bakat Anda di sini', 'KP', 'portal/feature/kegiatan-pendukung', 2),
(13, 4, 'Daftar Proposal', 'Buat karya Anda sekarang juga', 'DP', 'portal/feature/daftar-proposal', 3),
(14, 4, 'Daftar Tugas Akhir', 'Selesaikan karya Anda saat ini', 'TA', 'portal/feature/daftar-tugas-akhir', 4),
(15, 4, 'Pengajuan Yudisium', 'Ajukan diri untuk yudisium', 'YD', 'portal/feature/pengajuan-yudisium', 5),
(16, 4, 'Pengajuan Wisuda', 'Konfirmasi kehadiran Anda', 'WS', 'portal/feature/pengajuan-wisuda', 6),
(17, 5, 'Kartu Hasil Studi', 'Laporan periode Anda', 'KHS', 'portal/feature/kartu-hasil-studi', 1),
(18, 5, 'Transkrip', 'Hasil perkuliahan Anda', 'TR', 'portal/feature/transkrip', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `quick_menus`
--

CREATE TABLE `quick_menus` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `url_path` varchar(150) NOT NULL,
  `badge` varchar(40) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `quick_menus`
--

INSERT INTO `quick_menus` (`id`, `title`, `description`, `url_path`, `badge`, `urutan`) VALUES
(1, 'Data Mahasiswa', 'Kelola identitas, jurusan, dan data akademik mahasiswa.', 'mahasiswa', 'Aktif', 1),
(2, 'Data Dosen', 'Lihat tenaga pengajar, prodi, dan distribusi peran akademik.', 'akademik/dosen', 'Aktif', 2),
(3, 'Jadwal Kuliah', 'Susun jadwal perkuliahan, ruang, dan jam belajar.', 'akademik/jadwal', 'Aktif', 3),
(4, 'KRS & Nilai', 'Pantau pengisian KRS, validasi perwalian, dan hasil studi mahasiswa.', 'akademik/krs', 'Aktif', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level_label` varchar(100) NOT NULL,
  `focus` text NOT NULL,
  `color` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `level_label`, `focus`, `color`, `created_at`) VALUES
(1, 'rektor', 'Rektor', 'Pimpinan Tertinggi', 'Arah kebijakan, capaian institusi, dan keputusan strategis kampus.', 'emerald', '2026-05-25 05:23:00'),
(2, 'wakil-rektor', 'Wakil Rektor', 'Pimpinan Bidang', 'Koordinasi akademik, SDM, kemahasiswaan, dan operasional lintas unit.', 'gold', '2026-05-25 05:23:00'),
(3, 'baak', 'BAAK', 'Admin Akademik', 'Pelayanan administrasi akademik harian, kalender, KRS, jadwal, dan arsip.', 'teal', '2026-05-25 05:23:00'),
(4, 'dekan-kaprodi', 'Dekan / Kaprodi', 'Pimpinan Program', 'Kontrol kurikulum, distribusi kelas, dan performa dosen serta mahasiswa per prodi.', 'plum', '2026-05-25 05:23:00'),
(5, 'keuangan', 'Keuangan', 'Administrasi Pembayaran', 'Validasi UKT, daftar ulang, dan status finansial mahasiswa sebelum aktivasi semester.', 'copper', '2026-05-25 05:23:00'),
(6, 'dosen', 'Dosen', 'Pengajar', 'Presensi, input nilai, perwalian, dan pengelolaan kelas yang diampu.', 'indigo', '2026-05-25 05:23:00'),
(7, 'mahasiswa', 'Mahasiswa', 'Pengguna Akademik', 'Akses KRS, jadwal, nilai, status registrasi, dan layanan akademik pribadi.', 'sky', '2026-05-25 05:23:00'),
(8, 'admin', 'Administrator', 'Super Admin', 'Kontrol penuh untuk kelola seluruh data akademik, pengguna, dan konfigurasi sistem.', 'crimson', '2026-05-25 14:20:34'),
(9, 'dekan', 'Dekan', 'Pimpinan Fakultas', 'Kontrol mutu akademik, dosen, dan kurikulum pada level fakultas.', 'burgundy', '2026-05-26 04:39:29'),
(10, 'wakil-dekan', 'Wakil Dekan', 'Koordinator Fakultas', 'Koordinasi operasional fakultas, jadwal, dan tindak lanjut akademik semester aktif.', 'amber', '2026-05-26 04:39:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_features`
--

CREATE TABLE `role_features` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `feature_label` varchar(150) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_features`
--

INSERT INTO `role_features` (`id`, `role_id`, `feature_label`, `urutan`) VALUES
(1, 1, 'Dashboard KPI kampus', 1),
(2, 1, 'Persetujuan kebijakan akademik', 2),
(3, 1, 'Monitoring akreditasi', 3),
(4, 1, 'Laporan mutu dan performa fakultas', 4),
(5, 2, 'Monitoring beban dosen', 1),
(6, 2, 'Validasi agenda semester', 2),
(7, 2, 'Pemantauan unit akademik', 3),
(8, 2, 'Tindak lanjut laporan pimpinan', 4),
(9, 3, 'Kelola kalender akademik', 1),
(10, 3, 'Buka-tutup KRS', 2),
(11, 3, 'Manajemen jadwal kuliah', 3),
(12, 3, 'Cetak KHS dan transkrip', 4),
(13, 4, 'Pemetaan kurikulum', 1),
(14, 4, 'Distribusi dosen pengampu', 2),
(15, 4, 'Evaluasi kelas', 3),
(16, 4, 'Rekap capaian prodi', 4),
(17, 5, 'Status pembayaran UKT', 1),
(18, 5, 'Validasi registrasi', 2),
(19, 5, 'Laporan tunggakan', 3),
(20, 5, 'Sinkronisasi aktivasi mahasiswa', 4),
(21, 6, 'Input presensi', 1),
(22, 6, 'Input nilai', 2),
(23, 6, 'Validasi KRS mahasiswa wali', 3),
(24, 6, 'Bahan ajar dan kelas', 4),
(25, 7, 'Isi KRS', 1),
(26, 7, 'Lihat jadwal', 2),
(27, 7, 'Unduh KHS', 3),
(28, 7, 'Pantau status administrasi', 4),
(29, 8, 'CRUD seluruh data master', 1),
(30, 8, 'Kelola pengguna dan role', 2),
(31, 8, 'Monitoring seluruh modul akademik', 3),
(32, 8, 'Kontrol konfigurasi portal', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_feature_matrix`
--

CREATE TABLE `role_feature_matrix` (
  `id` int(11) NOT NULL,
  `feature_name` varchar(150) NOT NULL,
  `rektor_access` varchar(30) NOT NULL,
  `wakil_rektor_access` varchar(30) NOT NULL,
  `baak_access` varchar(30) NOT NULL,
  `dekan_kaprodi_access` varchar(30) NOT NULL,
  `keuangan_access` varchar(30) NOT NULL,
  `dosen_access` varchar(30) NOT NULL,
  `mahasiswa_access` varchar(30) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_feature_matrix`
--

INSERT INTO `role_feature_matrix` (`id`, `feature_name`, `rektor_access`, `wakil_rektor_access`, `baak_access`, `dekan_kaprodi_access`, `keuangan_access`, `dosen_access`, `mahasiswa_access`, `urutan`) VALUES
(1, 'Dashboard Strategis', 'Ya', 'Ya', 'Terbatas', 'Ya', 'Terbatas', 'Tidak', 'Tidak', 1),
(2, 'Persetujuan KRS', 'Tidak', 'Monitor', 'Monitor', 'Monitor', 'Tidak', 'Ya', 'Ajukan', 2),
(3, 'Kelola Jadwal', 'Monitor', 'Monitor', 'Ya', 'Ya', 'Tidak', 'Lihat', 'Lihat', 3),
(4, 'Input Nilai', 'Tidak', 'Monitor', 'Arsip', 'Monitor', 'Tidak', 'Ya', 'Lihat', 4),
(5, 'Validasi Registrasi', 'Monitor', 'Monitor', 'Ya', 'Tidak', 'Ya', 'Tidak', 'Cek Status', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_inbox`
--

CREATE TABLE `role_inbox` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `item_text` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_inbox`
--

INSERT INTO `role_inbox` (`id`, `role_id`, `item_text`, `urutan`) VALUES
(1, 1, 'Laporan evaluasi tengah semester', 1),
(2, 1, 'Usulan pembukaan kelas internasional', 2),
(3, 1, 'Notulensi rapat senat akademik', 3),
(4, 2, 'Permintaan penyesuaian kalender', 1),
(5, 2, 'Monitoring kehadiran dosen lintas fakultas', 2),
(6, 2, 'Rencana kegiatan kemahasiswaan', 3),
(7, 3, 'Permohonan koreksi KRS', 1),
(8, 3, 'Jadwal bentrok ruang kuliah', 2),
(9, 3, 'Cetak ulang KHS mahasiswa', 3),
(10, 4, 'Usulan dosen pengampu', 1),
(11, 4, 'Review CPL dan RPS', 2),
(12, 4, 'Permintaan kelas tambahan', 3),
(13, 5, 'Validasi bukti transfer UKT', 1),
(14, 5, 'Mahasiswa belum daftar ulang', 2),
(15, 5, 'Sinkronisasi status pembayaran', 3),
(16, 6, 'Mahasiswa menunggu persetujuan KRS', 1),
(17, 6, 'Reminder input nilai UTS', 2),
(18, 6, 'Permintaan konsultasi akademik', 3),
(19, 7, 'KRS disetujui dosen wali', 1),
(20, 7, 'Jadwal revisi mata kuliah', 2),
(21, 7, 'KHS semester lalu sudah terbit', 3),
(22, 8, 'Review data mahasiswa baru', 1),
(23, 8, 'Sinkronisasi jadwal dan mata kuliah', 2),
(24, 8, 'Audit perubahan nilai semester aktif', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_modules`
--

CREATE TABLE `role_modules` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_text` varchar(150) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_modules`
--

INSERT INTO `role_modules` (`id`, `role_id`, `module_text`, `urutan`) VALUES
(1, 1, 'Executive dashboard', 1),
(2, 1, 'Laporan akreditasi', 2),
(3, 1, 'Monitoring fakultas', 3),
(4, 1, 'Persetujuan kebijakan', 4),
(5, 2, 'Kontrol mutu akademik', 1),
(6, 2, 'Pengawasan unit', 2),
(7, 2, 'Monitoring dosen', 3),
(8, 2, 'Tindak lanjut kebijakan', 4),
(9, 3, 'Kalender akademik', 1),
(10, 3, 'Registrasi mahasiswa', 2),
(11, 3, 'Jadwal kuliah', 3),
(12, 3, 'Arsip akademik', 4),
(13, 4, 'Kurikulum prodi', 1),
(14, 4, 'Distribusi kelas', 2),
(15, 4, 'Evaluasi dosen', 3),
(16, 4, 'Rekap hasil studi', 4),
(17, 5, 'UKT & tagihan', 1),
(18, 5, 'Validasi pembayaran', 2),
(19, 5, 'Laporan tunggakan', 3),
(20, 5, 'Sinkronisasi aktivasi', 4),
(21, 6, 'Kelas diampu', 1),
(22, 6, 'Presensi', 2),
(23, 6, 'Input nilai', 3),
(24, 6, 'Perwalian', 4),
(25, 7, 'Portal KRS', 1),
(26, 7, 'Jadwal pribadi', 2),
(27, 7, 'Nilai dan KHS', 3),
(28, 7, 'Layanan administrasi', 4),
(29, 8, 'Manajemen mahasiswa', 1),
(30, 8, 'Manajemen dosen', 2),
(31, 8, 'Master akademik', 3),
(32, 8, 'Validasi KRS dan nilai', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_summary_stats`
--

CREATE TABLE `role_summary_stats` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value_text` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_summary_stats`
--

INSERT INTO `role_summary_stats` (`id`, `role_id`, `label`, `value_text`, `note`, `urutan`) VALUES
(1, 1, 'Laporan Menunggu', '6', 'Ringkasan mutu, keuangan, dan akademik tingkat universitas.', 1),
(2, 1, 'Agenda Strategis', '4', 'Agenda senat, evaluasi semester, dan target akreditasi.', 2),
(3, 1, 'Fakultas Dipantau', '5', 'Rekap capaian KPI seluruh fakultas aktif.', 3),
(4, 2, 'Unit Terkait', '8', 'Sinkronisasi lintas unit akademik dan operasional kampus.', 1),
(5, 2, 'Isu Prioritas', '5', 'Monitoring layanan mahasiswa, dosen, dan proses semester.', 2),
(6, 2, 'Persetujuan Aktif', '9', 'Persetujuan agenda, kelas, dan kebutuhan unit.', 3),
(7, 3, 'KRS Berjalan', '124', 'Pengisian dan validasi KRS semester aktif.', 1),
(8, 3, 'Jadwal Diterbitkan', '42', 'Kelas yang sudah siap tayang ke portal mahasiswa.', 2),
(9, 3, 'Layanan Tiket', '18', 'Permintaan surat, transkrip, dan koreksi data.', 3),
(10, 4, 'Kelas Dipantau', '19', 'Distribusi kelas aktif di bawah prodi atau fakultas.', 1),
(11, 4, 'Dosen Pengampu', '12', 'Penugasan pengajaran semester berjalan.', 2),
(12, 4, 'Evaluasi Kurikulum', '3', 'Mata kuliah yang masuk tinjauan kurikulum.', 3),
(13, 5, 'Tagihan Aktif', '87', 'Mahasiswa dengan proses verifikasi pembayaran berjalan.', 1),
(14, 5, 'Sudah Lunas', '214', 'Mahasiswa yang siap aktivasi akademik.', 2),
(15, 5, 'Perlu Tindak Lanjut', '23', 'Tunggakan dan klarifikasi administrasi.', 3),
(16, 6, 'Kelas Diampu', '4', 'Kelas aktif yang harus dikelola selama semester.', 1),
(17, 6, 'Nilai Draft', '36', 'Komponen penilaian yang belum dipublikasikan.', 2),
(18, 6, 'Mahasiswa Wali', '21', 'Mahasiswa yang masuk bimbingan akademik.', 3),
(19, 7, 'SKS Diambil', '21', 'Beban studi pada semester aktif.', 1),
(20, 7, 'Jadwal Mingguan', '6', 'Jumlah sesi kelas yang tampil di jadwal.', 2),
(21, 7, 'Dokumen Tersedia', '5', 'KRS, KHS, transkrip ringkas, dan surat aktif.', 3),
(22, 8, 'Modul Dikelola', '6', 'Mahasiswa, dosen, mata kuliah, jadwal, KRS, dan nilai.', 1),
(23, 8, 'Hak Akses', 'Penuh', 'Bisa menambah, mengubah, dan menghapus seluruh data inti.', 2),
(24, 8, 'Status Sistem', 'Aktif', 'Akun admin default tersedia untuk bootstrap aplikasi.', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_workflows`
--

CREATE TABLE `role_workflows` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `step_text` varchar(200) NOT NULL,
  `owner_text` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_workflows`
--

INSERT INTO `role_workflows` (`id`, `role_id`, `step_text`, `owner_text`, `urutan`) VALUES
(1, 1, 'Menerima dashboard ringkasan universitas', 'Sistem', 1),
(2, 1, 'Meninjau KPI mutu dan akademik', 'Rektor', 2),
(3, 1, 'Menyetujui kebijakan semester', 'Rektorat', 3),
(4, 2, 'Memeriksa status unit akademik', 'Wakil Rektor', 1),
(5, 2, 'Koordinasi dengan BAAK dan prodi', 'Pimpinan Bidang', 2),
(6, 2, 'Meneruskan keputusan ke unit kerja', 'Sekretariat', 3),
(7, 3, 'Membuka periode registrasi dan KRS', 'BAAK', 1),
(8, 3, 'Memverifikasi jadwal dan ruang', 'BAAK', 2),
(9, 3, 'Menerbitkan KHS dan arsip akademik', 'BAAK', 3),
(10, 4, 'Mengecek kurikulum dan sebaran kelas', 'Kaprodi', 1),
(11, 4, 'Menentukan dosen pengampu', 'Dekan / Kaprodi', 2),
(12, 4, 'Evaluasi hasil pembelajaran', 'Pimpinan Prodi', 3),
(13, 5, 'Memvalidasi pembayaran UKT', 'Keuangan', 1),
(14, 5, 'Sinkronisasi status registrasi', 'Keuangan', 2),
(15, 5, 'Menyerahkan status aktivasi ke BAAK', 'Administrasi', 3),
(16, 6, 'Menerima jadwal mengajar', 'Sistem', 1),
(17, 6, 'Memvalidasi KRS mahasiswa wali', 'Dosen', 2),
(18, 6, 'Input nilai dan presensi', 'Dosen', 3),
(19, 7, 'Cek status registrasi semester', 'Mahasiswa', 1),
(20, 7, 'Isi KRS dan kirim ke dosen wali', 'Mahasiswa', 2),
(21, 7, 'Pantau jadwal dan hasil studi', 'Mahasiswa', 3),
(22, 8, 'Masuk ke dashboard admin', 'Administrator', 1),
(23, 8, 'Kelola data inti kampus pada tiap modul', 'Administrator', 2),
(24, 8, 'Pantau perubahan dan validasi hasil input', 'Administrator', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_profile`
--

CREATE TABLE `student_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `role_name` varchar(80) NOT NULL,
  `semester` int(11) NOT NULL,
  `ipk` decimal(3,2) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `nim` varchar(30) NOT NULL,
  `greeting` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `student_profile`
--

INSERT INTO `student_profile` (`id`, `user_id`, `name`, `role_name`, `semester`, `ipk`, `program_studi`, `nim`, `greeting`) VALUES
(1, 7, 'Farikurniawan', 'Mahasiswa', 4, 3.74, 'Informatika', '2210110001', 'Hai, FARIKURNIAWAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_schedule`
--

CREATE TABLE `student_schedule` (
  `id` int(11) NOT NULL,
  `date_label` varchar(60) NOT NULL,
  `total_text` varchar(150) NOT NULL,
  `course` varchar(150) NOT NULL,
  `time_label` varchar(60) NOT NULL,
  `lecturer` varchar(120) NOT NULL,
  `room` varchar(160) NOT NULL,
  `sks_label` varchar(20) NOT NULL,
  `meeting_label` varchar(60) NOT NULL,
  `attendance_label` varchar(80) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `student_schedule`
--

INSERT INTO `student_schedule` (`id`, `date_label`, `total_text`, `course`, `time_label`, `lecturer`, `room`, `sks_label`, `meeting_label`, `attendance_label`, `urutan`) VALUES
(1, 'Senin, 25 Mei 2026', 'Anda memiliki 2 aktivitas perkuliahan', 'Bahasa Inggris 2 (MI4AP)', '08:50 - 09:30 WIB', 'Ikhwan Muslim, S.S., M.Pd', 'Ruang 4.5A Gedung A Lantai 4', '2 SKS', 'Pertemuan ke 10', 'Hadir (10 / 16)', 1),
(2, 'Senin, 25 Mei 2026', 'Anda memiliki 2 aktivitas perkuliahan', 'Pemrograman Mobile 1 (MI4AP)', '13:30 - 15:00 WIB', 'Iwan Jaya, S.Kom., M.Kom', 'Ruang Lab WTD Gedung A Lantai 3', '3 SKS', 'Pertemuan ke 9', 'Kehadiran Belum Tercatat', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_highlights`
--

CREATE TABLE `system_highlights` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `text_value` text NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `system_highlights`
--

INSERT INTO `system_highlights` (`id`, `title`, `text_value`, `urutan`) VALUES
(1, 'Registrasi Akademik', 'Pantau status daftar ulang, pembayaran, dan aktivasi mahasiswa per semester.', 1),
(2, 'Monitoring Perkuliahan', 'Siapkan integrasi presensi, jadwal kelas, dan beban mengajar dosen.', 2),
(3, 'Evaluasi Hasil Studi', 'Buka ruang untuk nilai, KHS, IPK, dan analitik performa mahasiswa.', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `fakultas_id` int(11) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `identity` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `fakultas_id`, `name`, `identity`, `password`, `created_at`) VALUES
(1, 1, NULL, 'Prof. Dr. Ahmad Nugraha', 'rektor@kampus.ac.id', 'rektor123', '2026-05-25 05:23:00'),
(2, 2, NULL, 'Dr. Sinta Maharani', 'warek@kampus.ac.id', 'warek123', '2026-05-25 05:23:00'),
(3, 3, NULL, 'Admin BAAK', 'baak@kampus.ac.id', 'baak123', '2026-05-25 05:23:00'),
(4, 4, 1, 'Agus Saputra, S.Kom., M.T', 'kaprodi@kampus.ac.id', 'kaprodi123', '2026-05-25 05:23:00'),
(5, 5, NULL, 'Staf Keuangan', 'keuangan@kampus.ac.id', 'keuangan123', '2026-05-25 05:23:00'),
(6, 6, 1, 'Dr. Rina Pratama, M.Kom', 'dosen@kampus.ac.id', 'dosen123', '2026-05-25 05:23:00'),
(7, 7, 1, 'Andi Prasetyo', 'mahasiswa@kampus.ac.id', 'mahasiswa123', '2026-05-25 05:23:00'),
(8, 8, NULL, 'Super Admin', 'admin@kampus.ac.id', 'admin123', '2026-05-25 14:20:34'),
(9, 9, 1, 'Prof. Lestari Wulandari', 'dekan@kampus.ac.id', 'dekan123', '2026-05-26 04:39:29'),
(10, 10, 1, 'Dr. Bayu Adinata', 'wadek@kampus.ac.id', 'wadek123', '2026-05-26 04:39:29');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `billing_summary`
--
ALTER TABLE `billing_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `idx_dosen_user_id` (`user_id`);

--
-- Indeks untuk tabel `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_fakultas` (`kode_fakultas`),
  ADD UNIQUE KEY `nama_fakultas` (`nama_fakultas`);

--
-- Indeks untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_jurusan` (`kode_jurusan`),
  ADD UNIQUE KEY `nama_jurusan` (`nama_jurusan`),
  ADD KEY `idx_jurusan_fakultas_id` (`fakultas_id`);

--
-- Indeks untuk tabel `kalender_akademik`
--
ALTER TABLE `kalender_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indeks untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indeks untuk tabel `mini_calendar_events`
--
ALTER TABLE `mini_calendar_events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `portal_features`
--
ALTER TABLE `portal_features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `portal_feature_items`
--
ALTER TABLE `portal_feature_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feature_items_feature` (`feature_id`);

--
-- Indeks untuk tabel `portal_feature_stats`
--
ALTER TABLE `portal_feature_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feature_stats_feature` (`feature_id`);

--
-- Indeks untuk tabel `portal_navigation`
--
ALTER TABLE `portal_navigation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_key` (`menu_key`);

--
-- Indeks untuk tabel `portal_navigation_items`
--
ALTER TABLE `portal_navigation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nav_items_navigation` (`navigation_id`);

--
-- Indeks untuk tabel `quick_menus`
--
ALTER TABLE `quick_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `role_features`
--
ALTER TABLE `role_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_features_role` (`role_id`);

--
-- Indeks untuk tabel `role_feature_matrix`
--
ALTER TABLE `role_feature_matrix`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role_inbox`
--
ALTER TABLE `role_inbox`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_inbox_role` (`role_id`);

--
-- Indeks untuk tabel `role_modules`
--
ALTER TABLE `role_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_modules_role` (`role_id`);

--
-- Indeks untuk tabel `role_summary_stats`
--
ALTER TABLE `role_summary_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_stats_role` (`role_id`);

--
-- Indeks untuk tabel `role_workflows`
--
ALTER TABLE `role_workflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_workflows_role` (`role_id`);

--
-- Indeks untuk tabel `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student_profile_user_id` (`user_id`);

--
-- Indeks untuk tabel `student_schedule`
--
ALTER TABLE `student_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `system_highlights`
--
ALTER TABLE `system_highlights`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identity` (`identity`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `billing_summary`
--
ALTER TABLE `billing_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kalender_akademik`
--
ALTER TABLE `kalender_akademik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `krs`
--
ALTER TABLE `krs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `mini_calendar_events`
--
ALTER TABLE `mini_calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `portal_features`
--
ALTER TABLE `portal_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `portal_feature_items`
--
ALTER TABLE `portal_feature_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `portal_feature_stats`
--
ALTER TABLE `portal_feature_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `portal_navigation`
--
ALTER TABLE `portal_navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `portal_navigation_items`
--
ALTER TABLE `portal_navigation_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `quick_menus`
--
ALTER TABLE `quick_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `role_features`
--
ALTER TABLE `role_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `role_feature_matrix`
--
ALTER TABLE `role_feature_matrix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `role_inbox`
--
ALTER TABLE `role_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `role_modules`
--
ALTER TABLE `role_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `role_summary_stats`
--
ALTER TABLE `role_summary_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `role_workflows`
--
ALTER TABLE `role_workflows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `student_profile`
--
ALTER TABLE `student_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `student_schedule`
--
ALTER TABLE `student_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `system_highlights`
--
ALTER TABLE `system_highlights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `fk_dosen_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `fk_jurusan_fakultas` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `portal_feature_items`
--
ALTER TABLE `portal_feature_items`
  ADD CONSTRAINT `fk_feature_items_feature` FOREIGN KEY (`feature_id`) REFERENCES `portal_features` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `portal_feature_stats`
--
ALTER TABLE `portal_feature_stats`
  ADD CONSTRAINT `fk_feature_stats_feature` FOREIGN KEY (`feature_id`) REFERENCES `portal_features` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `portal_navigation_items`
--
ALTER TABLE `portal_navigation_items`
  ADD CONSTRAINT `fk_nav_items_navigation` FOREIGN KEY (`navigation_id`) REFERENCES `portal_navigation` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_features`
--
ALTER TABLE `role_features`
  ADD CONSTRAINT `fk_role_features_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_inbox`
--
ALTER TABLE `role_inbox`
  ADD CONSTRAINT `fk_role_inbox_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_modules`
--
ALTER TABLE `role_modules`
  ADD CONSTRAINT `fk_role_modules_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_summary_stats`
--
ALTER TABLE `role_summary_stats`
  ADD CONSTRAINT `fk_role_stats_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_workflows`
--
ALTER TABLE `role_workflows`
  ADD CONSTRAINT `fk_role_workflows_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `student_profile`
--
ALTER TABLE `student_profile`
  ADD CONSTRAINT `fk_student_profile_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
