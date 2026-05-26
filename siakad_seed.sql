CREATE TABLE IF NOT EXISTS roles (
	id INT AUTO_INCREMENT PRIMARY KEY,
	slug VARCHAR(50) NOT NULL UNIQUE,
	name VARCHAR(100) NOT NULL,
	level_label VARCHAR(100) NOT NULL,
	focus TEXT NOT NULL,
	color VARCHAR(30) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	fakultas_id INT DEFAULT NULL,
	name VARCHAR(120) NOT NULL,
	identity VARCHAR(120) NOT NULL UNIQUE,
	password VARCHAR(120) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS dosen (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT DEFAULT NULL,
	nidn VARCHAR(30) NOT NULL UNIQUE,
	nama VARCHAR(120) NOT NULL,
	prodi VARCHAR(100) NOT NULL,
	status_jabatan VARCHAR(100) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	KEY idx_dosen_user_id (user_id),
	CONSTRAINT fk_dosen_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mata_kuliah (
	id INT AUTO_INCREMENT PRIMARY KEY,
	kode VARCHAR(20) NOT NULL UNIQUE,
	nama VARCHAR(120) NOT NULL,
	sks INT NOT NULL,
	semester INT NOT NULL,
	prodi VARCHAR(100) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jadwal_kuliah (
	id INT AUTO_INCREMENT PRIMARY KEY,
	hari VARCHAR(30) NOT NULL,
	waktu VARCHAR(50) NOT NULL,
	mata_kuliah VARCHAR(120) NOT NULL,
	dosen VARCHAR(120) NOT NULL,
	ruang VARCHAR(120) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS krs (
	id INT AUTO_INCREMENT PRIMARY KEY,
	mahasiswa_id INT DEFAULT NULL,
	nim VARCHAR(20) NOT NULL,
	nama VARCHAR(120) NOT NULL,
	semester INT NOT NULL,
	sks_diambil INT NOT NULL,
	status_krs VARCHAR(80) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS nilai_mahasiswa (
	id INT AUTO_INCREMENT PRIMARY KEY,
	mahasiswa_id INT DEFAULT NULL,
	nim VARCHAR(20) NOT NULL,
	nama VARCHAR(120) NOT NULL,
	ips DECIMAL(3,2) NOT NULL,
	ipk DECIMAL(3,2) NOT NULL,
	status_nilai VARCHAR(100) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mahasiswa (
	id INT AUTO_INCREMENT PRIMARY KEY,
	jurusan_id INT DEFAULT NULL,
	nim VARCHAR(20) NOT NULL UNIQUE,
	nama VARCHAR(120) NOT NULL,
	jurusan VARCHAR(120) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS kalender_akademik (
	id INT AUTO_INCREMENT PRIMARY KEY,
	tanggal_label VARCHAR(60) NOT NULL,
	agenda VARCHAR(200) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS system_highlights (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(120) NOT NULL,
	text_value TEXT NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quick_menus (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(120) NOT NULL,
	description TEXT NOT NULL,
	url_path VARCHAR(150) NOT NULL,
	badge VARCHAR(40) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS announcements (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(150) NOT NULL,
	content TEXT NOT NULL,
	date_label VARCHAR(50) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS portal_navigation (
	id INT AUTO_INCREMENT PRIMARY KEY,
	menu_key VARCHAR(50) NOT NULL UNIQUE,
	label VARCHAR(80) NOT NULL,
	url_path VARCHAR(150) NOT NULL,
	heading VARCHAR(80) DEFAULT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS portal_navigation_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	navigation_id INT NOT NULL,
	label VARCHAR(120) NOT NULL,
	description VARCHAR(200) NOT NULL,
	icon_code VARCHAR(12) NOT NULL,
	url_path VARCHAR(150) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_nav_items_navigation FOREIGN KEY (navigation_id) REFERENCES portal_navigation(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_features (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	feature_label VARCHAR(150) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_role_features_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_summary_stats (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	label VARCHAR(100) NOT NULL,
	value_text VARCHAR(50) NOT NULL,
	note TEXT NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_role_stats_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_workflows (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	step_text VARCHAR(200) NOT NULL,
	owner_text VARCHAR(100) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_role_workflows_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_inbox (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	item_text VARCHAR(200) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_role_inbox_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_modules (
	id INT AUTO_INCREMENT PRIMARY KEY,
	role_id INT NOT NULL,
	module_text VARCHAR(150) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_role_modules_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_feature_matrix (
	id INT AUTO_INCREMENT PRIMARY KEY,
	feature_name VARCHAR(150) NOT NULL,
	rektor_access VARCHAR(30) NOT NULL,
	wakil_rektor_access VARCHAR(30) NOT NULL,
	baak_access VARCHAR(30) NOT NULL,
	dekan_kaprodi_access VARCHAR(30) NOT NULL,
	keuangan_access VARCHAR(30) NOT NULL,
	dosen_access VARCHAR(30) NOT NULL,
	mahasiswa_access VARCHAR(30) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS student_profile (
	id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT DEFAULT NULL,
	name VARCHAR(120) NOT NULL,
	role_name VARCHAR(80) NOT NULL,
	semester INT NOT NULL,
	ipk DECIMAL(3,2) NOT NULL,
	program_studi VARCHAR(100) NOT NULL,
	nim VARCHAR(30) NOT NULL,
	greeting VARCHAR(160) NOT NULL,
	KEY idx_student_profile_user_id (user_id),
	CONSTRAINT fk_student_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS student_schedule (
	id INT AUTO_INCREMENT PRIMARY KEY,
	date_label VARCHAR(60) NOT NULL,
	total_text VARCHAR(150) NOT NULL,
	course VARCHAR(150) NOT NULL,
	time_label VARCHAR(60) NOT NULL,
	lecturer VARCHAR(120) NOT NULL,
	room VARCHAR(160) NOT NULL,
	sks_label VARCHAR(20) NOT NULL,
	meeting_label VARCHAR(60) NOT NULL,
	attendance_label VARCHAR(80) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS billing_summary (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(120) NOT NULL,
	message TEXT NOT NULL,
	status_label VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mini_calendar_events (
	id INT AUTO_INCREMENT PRIMARY KEY,
	month_label VARCHAR(40) NOT NULL,
	date_label VARCHAR(30) NOT NULL,
	text_value VARCHAR(160) NOT NULL,
	urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS notifications (
	id INT AUTO_INCREMENT PRIMARY KEY,
	total_count INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jurusan (
	id INT AUTO_INCREMENT PRIMARY KEY,
	fakultas_id INT DEFAULT NULL,
	kode_jurusan VARCHAR(20) NOT NULL UNIQUE,
	nama_jurusan VARCHAR(120) NOT NULL UNIQUE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	KEY idx_jurusan_fakultas_id (fakultas_id),
	CONSTRAINT fk_jurusan_fakultas FOREIGN KEY (fakultas_id) REFERENCES fakultas(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS portal_features (
	id INT AUTO_INCREMENT PRIMARY KEY,
	slug VARCHAR(80) NOT NULL UNIQUE,
	title VARCHAR(150) NOT NULL,
	category VARCHAR(80) NOT NULL,
	description TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS portal_feature_stats (
	id INT AUTO_INCREMENT PRIMARY KEY,
	feature_id INT NOT NULL,
	label VARCHAR(100) NOT NULL,
	value_text VARCHAR(60) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_feature_stats_feature FOREIGN KEY (feature_id) REFERENCES portal_features(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS portal_feature_items (
	id INT AUTO_INCREMENT PRIMARY KEY,
	feature_id INT NOT NULL,
	title VARCHAR(180) NOT NULL,
	meta_text VARCHAR(200) NOT NULL,
	urutan INT NOT NULL DEFAULT 0,
	CONSTRAINT fk_feature_items_feature FOREIGN KEY (feature_id) REFERENCES portal_features(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO roles (id, slug, name, level_label, focus, color) VALUES
(1, 'rektor', 'Rektor', 'Pimpinan Tertinggi', 'Arah kebijakan, capaian institusi, dan keputusan strategis kampus.', 'emerald'),
(2, 'wakil-rektor', 'Wakil Rektor', 'Pimpinan Bidang', 'Koordinasi akademik, SDM, kemahasiswaan, dan operasional lintas unit.', 'gold'),
(3, 'dekan', 'Dekan', 'Pimpinan Fakultas', 'Kontrol mutu akademik, dosen, dan kurikulum pada level fakultas.', 'burgundy'),
(4, 'wakil-dekan', 'Wakil Dekan', 'Koordinator Fakultas', 'Koordinasi operasional fakultas, jadwal, dan tindak lanjut akademik semester aktif.', 'amber'),
(5, 'baak', 'BAAK', 'Admin Akademik', 'Pelayanan administrasi akademik harian, kalender, KRS, jadwal, dan arsip.', 'teal'),
(6, 'dekan-kaprodi', 'Dekan / Kaprodi', 'Pimpinan Program', 'Kontrol kurikulum, distribusi kelas, dan performa dosen serta mahasiswa per prodi.', 'plum'),
(7, 'keuangan', 'Keuangan', 'Administrasi Pembayaran', 'Validasi UKT, daftar ulang, dan status finansial mahasiswa sebelum aktivasi semester.', 'copper'),
(8, 'dosen', 'Dosen', 'Pengajar', 'Presensi, input nilai, perwalian, dan pengelolaan kelas yang diampu.', 'indigo'),
(9, 'mahasiswa', 'Mahasiswa', 'Pengguna Akademik', 'Akses KRS, jadwal, nilai, status registrasi, dan layanan akademik pribadi.', 'sky'),
(10, 'admin', 'Administrator', 'Super Admin', 'Kontrol penuh untuk kelola seluruh data akademik, pengguna, dan konfigurasi sistem.', 'crimson');

DELETE FROM users;
INSERT INTO users (id, role_id, fakultas_id, name, identity, password) VALUES
(1, 1, NULL, 'Prof. Dr. Ahmad Nugraha', 'rektor@kampus.ac.id', 'rektor123'),
(2, 2, NULL, 'Dr. Sinta Maharani', 'warek@kampus.ac.id', 'warek123'),
(3, 3, 1, 'Prof. Lestari Wulandari', 'dekan@kampus.ac.id', 'dekan123'),
(4, 4, 1, 'Dr. Bayu Adinata', 'wadek@kampus.ac.id', 'wadek123'),
(5, 5, NULL, 'Admin BAAK', 'baak@kampus.ac.id', 'baak123'),
(6, 6, 1, 'Agus Saputra, S.Kom., M.T', 'kaprodi@kampus.ac.id', 'kaprodi123'),
(7, 7, NULL, 'Staf Keuangan', 'keuangan@kampus.ac.id', 'keuangan123'),
(8, 8, 1, 'Dr. Rina Pratama, M.Kom', 'dosen@kampus.ac.id', 'dosen123'),
(9, 9, 1, 'Andi Prasetyo', 'mahasiswa@kampus.ac.id', 'mahasiswa123'),
(10, 10, NULL, 'Super Admin', 'admin@kampus.ac.id', 'admin123');

DELETE FROM dosen;
INSERT INTO dosen (user_id, nidn, nama, prodi, status_jabatan) VALUES
(8, '0112038901', 'Dr. Rina Pratama, M.Kom', 'Informatika', 'Dosen Tetap'),
(6, '0215079102', 'Agus Saputra, S.Kom., M.T', 'Sistem Informasi', 'Kaprodi'),
(NULL, '0311088803', 'Maya Lestari, M.Cs', 'Teknik Komputer', 'Dosen Tetap'),
(NULL, '0410119204', 'Fajar Ramadhan, S.T., M.Kom', 'Informatika', 'Koordinator Lab');

DELETE FROM jurusan;
DELETE FROM fakultas;
INSERT INTO fakultas (id, kode_fakultas, nama_fakultas) VALUES
(1, 'FTI', 'Fakultas Teknologi Informasi'),
(2, 'FEB', 'Fakultas Ekonomi dan Bisnis');

INSERT INTO jurusan (fakultas_id, kode_jurusan, nama_jurusan) VALUES
(1, 'IF', 'Informatika'),
(1, 'SI', 'Sistem Informasi'),
(1, 'TK', 'Teknik Komputer');

DELETE FROM mata_kuliah;
INSERT INTO mata_kuliah (kode, nama, sks, semester, prodi) VALUES
('IF201', 'Struktur Data', 3, 3, 'Informatika'),
('SI204', 'Analisis Proses Bisnis', 3, 3, 'Sistem Informasi'),
('IF305', 'Pemrograman Web', 3, 5, 'Informatika'),
('TK302', 'Jaringan Komputer', 3, 5, 'Teknik Komputer'),
('UM101', 'Pancasila', 2, 1, 'Umum');

DELETE FROM jadwal_kuliah;
INSERT INTO jadwal_kuliah (hari, waktu, mata_kuliah, dosen, ruang) VALUES
('Senin', '08:00 - 10:30', 'Struktur Data', 'Dr. Rina Pratama, M.Kom', 'Lab Komputer 1'),
('Selasa', '10:30 - 13:00', 'Analisis Proses Bisnis', 'Agus Saputra, S.Kom., M.T', 'Ruang 2.3'),
('Rabu', '13:00 - 15:30', 'Pemrograman Web', 'Fajar Ramadhan, S.T., M.Kom', 'Lab Web'),
('Kamis', '08:00 - 10:30', 'Jaringan Komputer', 'Maya Lestari, M.Cs', 'Lab Jaringan');

DELETE FROM mahasiswa;
INSERT INTO mahasiswa (id, jurusan_id, nim, nama, jurusan) VALUES
(1, 1, '2210110001', 'Andi Prasetyo', 'Informatika'),
(2, 2, '102', 'Budi', 'Sistem Informasi'),
(3, 3, '103', 'Citra', 'Teknik Komputer'),
(4, 1, '104', 'Doni', 'Informatika');

DELETE FROM krs;
INSERT INTO krs (mahasiswa_id, nim, nama, semester, sks_diambil, status_krs) VALUES
(1, '2210110001', 'Andi Prasetyo', 4, 21, 'Disetujui'),
(2, '102', 'Budi', 4, 20, 'Menunggu Validasi'),
(3, '103', 'Citra', 6, 22, 'Disetujui'),
(4, '104', 'Doni', 2, 18, 'Perlu Revisi');

DELETE FROM nilai_mahasiswa;
INSERT INTO nilai_mahasiswa (mahasiswa_id, nim, nama, ips, ipk, status_nilai) VALUES
(1, '2210110001', 'Andi Prasetyo', 3.72, 3.68, 'Baik Sekali'),
(2, '102', 'Budi', 3.40, 3.45, 'Baik'),
(3, '103', 'Citra', 3.88, 3.81, 'Cumlaude Track'),
(4, '104', 'Doni', 3.15, 3.22, 'Stabil');

DELETE FROM kalender_akademik;
INSERT INTO kalender_akademik (tanggal_label, agenda, urutan) VALUES
('03 Juni 2026', 'Pembukaan pengisian KRS semester ganjil', 1),
('10 Juni 2026', 'Batas akhir persetujuan dosen wali', 2),
('17 Juni 2026', 'Publikasi jadwal kuliah dan ruang', 3),
('24 Juni 2026', 'Awal perkuliahan aktif', 4);

DELETE FROM system_highlights;
INSERT INTO system_highlights (title, text_value, urutan) VALUES
('Registrasi Akademik', 'Pantau status daftar ulang, pembayaran, dan aktivasi mahasiswa per semester.', 1),
('Monitoring Perkuliahan', 'Siapkan integrasi presensi, jadwal kelas, dan beban mengajar dosen.', 2),
('Evaluasi Hasil Studi', 'Buka ruang untuk nilai, KHS, IPK, dan analitik performa mahasiswa.', 3);

DELETE FROM quick_menus;
INSERT INTO quick_menus (title, description, url_path, badge, urutan) VALUES
('Data Mahasiswa', 'Kelola identitas, jurusan, dan data akademik mahasiswa.', 'mahasiswa', 'Aktif', 1),
('Data Dosen', 'Lihat tenaga pengajar, prodi, dan distribusi peran akademik.', 'akademik/dosen', 'Aktif', 2),
('Jadwal Kuliah', 'Susun jadwal perkuliahan, ruang, dan jam belajar.', 'akademik/jadwal', 'Aktif', 3),
('KRS & Nilai', 'Pantau pengisian KRS, validasi perwalian, dan hasil studi mahasiswa.', 'akademik/krs', 'Aktif', 4);

DELETE FROM announcements;
INSERT INTO announcements (title, content, date_label, urutan) VALUES
('Semester Baru Siap Dibuka', 'Dashboard ini sudah disiapkan sebagai fondasi SIAKAD dan dapat dilanjutkan ke modul KRS, jadwal, dan nilai.', '25 Mei 2026', 1),
('Integrasi Database Aktif', 'Seluruh data portal kini diprioritaskan dari database MySQL agar siap dikembangkan menjadi aplikasi akademik penuh.', '25 Mei 2026', 2);

DELETE FROM portal_navigation_items;
DELETE FROM portal_navigation;
INSERT INTO portal_navigation (id, menu_key, label, url_path, heading, urutan) VALUES
(1, 'dashboard', 'Beranda', 'dashboard', NULL, 1),
(2, 'jadwal_portal', 'Jadwal', '#', 'Jadwal', 2),
(3, 'akademik_portal', 'Akademik', '#', 'Akademik', 3),
(4, 'tingkat_akhir_portal', 'Tingkat Akhir', '#', 'Tingkat Akhir', 4),
(5, 'hasil_studi_portal', 'Hasil Studi', '#', 'Hasil Studi', 5);

INSERT INTO portal_navigation_items (navigation_id, label, description, icon_code, url_path, urutan) VALUES
(2, 'Pengumuman', 'Informasi kegiatan kampus', 'PG', 'portal/feature/pengumuman', 1),
(2, 'Kalender Akademik', 'Periksa kegiatan perkuliahan', 'KA', 'portal/feature/kalender-akademik', 2),
(2, 'Jadwal Minggu Ini', 'Aktivitas seminggu ke depan', 'JM', 'portal/feature/jadwal-minggu-ini', 3),
(2, 'Jadwal Semester', 'Kegiatan Anda satu semester', 'JS', 'portal/feature/jadwal-semester', 4),
(3, 'Pengisian Kartu Rencana Studi', 'Tentukan rencana kuliah', 'KRS', 'portal/feature/pengisian-krs', 1),
(3, 'Riwayat KRS', 'Rekap rencana kuliah Anda', 'RK', 'portal/feature/riwayat-krs', 2),
(3, 'Kurikulum Mahasiswa', 'Ketentuan proses perkuliahan', 'KM', 'portal/feature/kurikulum-mahasiswa', 3),
(3, 'Mengulang', 'Histori perbaikan mata kuliah', 'MG', 'portal/feature/mengulang', 4),
(3, 'Nilai Mahasiswa', 'Kualitas perkuliahan Anda', 'NM', 'portal/feature/nilai-mahasiswa', 5),
(3, 'Aktivitas & Prestasi', 'Kegiatan mahasiswa wali', 'AP', 'portal/feature/aktivitas-prestasi', 6),
(4, 'Konsultasi', 'Temukan solusi masalah Anda', 'KS', 'portal/feature/konsultasi', 1),
(4, 'Kegiatan Pendukung', 'Salurkan bakat Anda di sini', 'KP', 'portal/feature/kegiatan-pendukung', 2),
(4, 'Daftar Proposal', 'Buat karya Anda sekarang juga', 'DP', 'portal/feature/daftar-proposal', 3),
(4, 'Daftar Tugas Akhir', 'Selesaikan karya Anda saat ini', 'TA', 'portal/feature/daftar-tugas-akhir', 4),
(4, 'Pengajuan Yudisium', 'Ajukan diri untuk yudisium', 'YD', 'portal/feature/pengajuan-yudisium', 5),
(4, 'Pengajuan Wisuda', 'Konfirmasi kehadiran Anda', 'WS', 'portal/feature/pengajuan-wisuda', 6),
(5, 'Kartu Hasil Studi', 'Laporan periode Anda', 'KHS', 'portal/feature/kartu-hasil-studi', 1),
(5, 'Transkrip', 'Hasil perkuliahan Anda', 'TR', 'portal/feature/transkrip', 2);

DELETE FROM role_features;
INSERT INTO role_features (role_id, feature_label, urutan) VALUES
(1, 'Dashboard KPI kampus', 1),(1, 'Persetujuan kebijakan akademik', 2),(1, 'Monitoring akreditasi', 3),(1, 'Laporan mutu dan performa fakultas', 4),
(2, 'Monitoring beban dosen', 1),(2, 'Validasi agenda semester', 2),(2, 'Pemantauan unit akademik', 3),(2, 'Tindak lanjut laporan pimpinan', 4),
(3, 'Kelola kalender akademik', 1),(3, 'Buka-tutup KRS', 2),(3, 'Manajemen jadwal kuliah', 3),(3, 'Cetak KHS dan transkrip', 4),
(4, 'Pemetaan kurikulum', 1),(4, 'Distribusi dosen pengampu', 2),(4, 'Evaluasi kelas', 3),(4, 'Rekap capaian prodi', 4),
(5, 'Status pembayaran UKT', 1),(5, 'Validasi registrasi', 2),(5, 'Laporan tunggakan', 3),(5, 'Sinkronisasi aktivasi mahasiswa', 4),
(6, 'Input presensi', 1),(6, 'Input nilai', 2),(6, 'Validasi KRS mahasiswa wali', 3),(6, 'Bahan ajar dan kelas', 4),
(7, 'Isi KRS', 1),(7, 'Lihat jadwal', 2),(7, 'Unduh KHS', 3),(7, 'Pantau status administrasi', 4);

DELETE FROM role_summary_stats;
INSERT INTO role_summary_stats (role_id, label, value_text, note, urutan) VALUES
(1, 'Laporan Menunggu', '6', 'Ringkasan mutu, keuangan, dan akademik tingkat universitas.', 1),
(1, 'Agenda Strategis', '4', 'Agenda senat, evaluasi semester, dan target akreditasi.', 2),
(1, 'Fakultas Dipantau', '5', 'Rekap capaian KPI seluruh fakultas aktif.', 3),
(2, 'Unit Terkait', '8', 'Sinkronisasi lintas unit akademik dan operasional kampus.', 1),
(2, 'Isu Prioritas', '5', 'Monitoring layanan mahasiswa, dosen, dan proses semester.', 2),
(2, 'Persetujuan Aktif', '9', 'Persetujuan agenda, kelas, dan kebutuhan unit.', 3),
(3, 'KRS Berjalan', '124', 'Pengisian dan validasi KRS semester aktif.', 1),
(3, 'Jadwal Diterbitkan', '42', 'Kelas yang sudah siap tayang ke portal mahasiswa.', 2),
(3, 'Layanan Tiket', '18', 'Permintaan surat, transkrip, dan koreksi data.', 3),
(4, 'Kelas Dipantau', '19', 'Distribusi kelas aktif di bawah prodi atau fakultas.', 1),
(4, 'Dosen Pengampu', '12', 'Penugasan pengajaran semester berjalan.', 2),
(4, 'Evaluasi Kurikulum', '3', 'Mata kuliah yang masuk tinjauan kurikulum.', 3),
(5, 'Tagihan Aktif', '87', 'Mahasiswa dengan proses verifikasi pembayaran berjalan.', 1),
(5, 'Sudah Lunas', '214', 'Mahasiswa yang siap aktivasi akademik.', 2),
(5, 'Perlu Tindak Lanjut', '23', 'Tunggakan dan klarifikasi administrasi.', 3),
(6, 'Kelas Diampu', '4', 'Kelas aktif yang harus dikelola selama semester.', 1),
(6, 'Nilai Draft', '36', 'Komponen penilaian yang belum dipublikasikan.', 2),
(6, 'Mahasiswa Wali', '21', 'Mahasiswa yang masuk bimbingan akademik.', 3),
(7, 'SKS Diambil', '21', 'Beban studi pada semester aktif.', 1),
(7, 'Jadwal Mingguan', '6', 'Jumlah sesi kelas yang tampil di jadwal.', 2),
(7, 'Dokumen Tersedia', '5', 'KRS, KHS, transkrip ringkas, dan surat aktif.', 3);

DELETE FROM role_workflows;
INSERT INTO role_workflows (role_id, step_text, owner_text, urutan) VALUES
(1, 'Menerima dashboard ringkasan universitas', 'Sistem', 1),(1, 'Meninjau KPI mutu dan akademik', 'Rektor', 2),(1, 'Menyetujui kebijakan semester', 'Rektorat', 3),
(2, 'Memeriksa status unit akademik', 'Wakil Rektor', 1),(2, 'Koordinasi dengan BAAK dan prodi', 'Pimpinan Bidang', 2),(2, 'Meneruskan keputusan ke unit kerja', 'Sekretariat', 3),
(3, 'Membuka periode registrasi dan KRS', 'BAAK', 1),(3, 'Memverifikasi jadwal dan ruang', 'BAAK', 2),(3, 'Menerbitkan KHS dan arsip akademik', 'BAAK', 3),
(4, 'Mengecek kurikulum dan sebaran kelas', 'Kaprodi', 1),(4, 'Menentukan dosen pengampu', 'Dekan / Kaprodi', 2),(4, 'Evaluasi hasil pembelajaran', 'Pimpinan Prodi', 3),
(5, 'Memvalidasi pembayaran UKT', 'Keuangan', 1),(5, 'Sinkronisasi status registrasi', 'Keuangan', 2),(5, 'Menyerahkan status aktivasi ke BAAK', 'Administrasi', 3),
(6, 'Menerima jadwal mengajar', 'Sistem', 1),(6, 'Memvalidasi KRS mahasiswa wali', 'Dosen', 2),(6, 'Input nilai dan presensi', 'Dosen', 3),
(7, 'Cek status registrasi semester', 'Mahasiswa', 1),(7, 'Isi KRS dan kirim ke dosen wali', 'Mahasiswa', 2),(7, 'Pantau jadwal dan hasil studi', 'Mahasiswa', 3);

DELETE FROM role_inbox;
INSERT INTO role_inbox (role_id, item_text, urutan) VALUES
(1, 'Laporan evaluasi tengah semester', 1),(1, 'Usulan pembukaan kelas internasional', 2),(1, 'Notulensi rapat senat akademik', 3),
(2, 'Permintaan penyesuaian kalender', 1),(2, 'Monitoring kehadiran dosen lintas fakultas', 2),(2, 'Rencana kegiatan kemahasiswaan', 3),
(3, 'Permohonan koreksi KRS', 1),(3, 'Jadwal bentrok ruang kuliah', 2),(3, 'Cetak ulang KHS mahasiswa', 3),
(4, 'Usulan dosen pengampu', 1),(4, 'Review CPL dan RPS', 2),(4, 'Permintaan kelas tambahan', 3),
(5, 'Validasi bukti transfer UKT', 1),(5, 'Mahasiswa belum daftar ulang', 2),(5, 'Sinkronisasi status pembayaran', 3),
(6, 'Mahasiswa menunggu persetujuan KRS', 1),(6, 'Reminder input nilai UTS', 2),(6, 'Permintaan konsultasi akademik', 3),
(7, 'KRS disetujui dosen wali', 1),(7, 'Jadwal revisi mata kuliah', 2),(7, 'KHS semester lalu sudah terbit', 3);

DELETE FROM role_modules;
INSERT INTO role_modules (role_id, module_text, urutan) VALUES
(1, 'Executive dashboard', 1),(1, 'Laporan akreditasi', 2),(1, 'Monitoring fakultas', 3),(1, 'Persetujuan kebijakan', 4),
(2, 'Kontrol mutu akademik', 1),(2, 'Pengawasan unit', 2),(2, 'Monitoring dosen', 3),(2, 'Tindak lanjut kebijakan', 4),
(3, 'Kalender akademik', 1),(3, 'Registrasi mahasiswa', 2),(3, 'Jadwal kuliah', 3),(3, 'Arsip akademik', 4),
(4, 'Kurikulum prodi', 1),(4, 'Distribusi kelas', 2),(4, 'Evaluasi dosen', 3),(4, 'Rekap hasil studi', 4),
(5, 'UKT & tagihan', 1),(5, 'Validasi pembayaran', 2),(5, 'Laporan tunggakan', 3),(5, 'Sinkronisasi aktivasi', 4),
(6, 'Kelas diampu', 1),(6, 'Presensi', 2),(6, 'Input nilai', 3),(6, 'Perwalian', 4),
(7, 'Portal KRS', 1),(7, 'Jadwal pribadi', 2),(7, 'Nilai dan KHS', 3),(7, 'Layanan administrasi', 4);

DELETE FROM role_feature_matrix;
INSERT INTO role_feature_matrix (feature_name, rektor_access, wakil_rektor_access, baak_access, dekan_kaprodi_access, keuangan_access, dosen_access, mahasiswa_access, urutan) VALUES
('Dashboard Strategis', 'Ya', 'Ya', 'Terbatas', 'Ya', 'Terbatas', 'Tidak', 'Tidak', 1),
('Persetujuan KRS', 'Tidak', 'Monitor', 'Monitor', 'Monitor', 'Tidak', 'Ya', 'Ajukan', 2),
('Kelola Jadwal', 'Monitor', 'Monitor', 'Ya', 'Ya', 'Tidak', 'Lihat', 'Lihat', 3),
('Input Nilai', 'Tidak', 'Monitor', 'Arsip', 'Monitor', 'Tidak', 'Ya', 'Lihat', 4),
('Validasi Registrasi', 'Monitor', 'Monitor', 'Ya', 'Tidak', 'Ya', 'Tidak', 'Cek Status', 5);

DELETE FROM student_profile;
INSERT INTO student_profile (user_id, name, role_name, semester, ipk, program_studi, nim, greeting) VALUES
(9, 'Andi Prasetyo', 'Mahasiswa', 4, 3.74, 'Informatika', '2210110001', 'Hai, ANDI PRASETYO');

DELETE FROM student_schedule;
INSERT INTO student_schedule (date_label, total_text, course, time_label, lecturer, room, sks_label, meeting_label, attendance_label, urutan) VALUES
('Senin, 25 Mei 2026', 'Anda memiliki 2 aktivitas perkuliahan', 'Bahasa Inggris 2 (MI4AP)', '08:50 - 09:30 WIB', 'Ikhwan Muslim, S.S., M.Pd', 'Ruang 4.5A Gedung A Lantai 4', '2 SKS', 'Pertemuan ke 10', 'Hadir (10 / 16)', 1),
('Senin, 25 Mei 2026', 'Anda memiliki 2 aktivitas perkuliahan', 'Pemrograman Mobile 1 (MI4AP)', '13:30 - 15:00 WIB', 'Iwan Jaya, S.Kom., M.Kom', 'Ruang Lab WTD Gedung A Lantai 3', '3 SKS', 'Pertemuan ke 9', 'Kehadiran Belum Tercatat', 2);

DELETE FROM billing_summary;
INSERT INTO billing_summary (title, message, status_label) VALUES
('Belum Ada Tagihan Baru', 'Terima kasih telah melunasi tagihan akademik di periode ini.', 'Lunas');

DELETE FROM mini_calendar_events;
INSERT INTO mini_calendar_events (month_label, date_label, text_value, urutan) VALUES
('May, 2026', '25 Mei', 'Perkuliahan minggu ke-10', 1),
('May, 2026', '27 Mei', 'Validasi KRS mahasiswa wali', 2),
('May, 2026', '31 Mei', 'Batas input nilai tugas', 3);

DELETE FROM notifications;
INSERT INTO notifications (total_count) VALUES (94);

DELETE FROM portal_feature_items;
DELETE FROM portal_feature_stats;
DELETE FROM portal_features;
INSERT INTO portal_features (id, slug, title, category, description) VALUES
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

INSERT INTO portal_feature_stats (feature_id, label, value_text, urutan) VALUES
(1, 'Pengumuman Aktif', '4', 1),(1, 'Mendesak', '1', 2),(1, 'Sudah Dibaca', '12', 3),
(2, 'Agenda Bulan Ini', '8', 1),(2, 'Tenggat Dekat', '3', 2),(2, 'Periode Aktif', 'Minggu 10', 3),
(3, 'Total Kelas', '6', 1),(3, 'Praktikum', '2', 2),(3, 'Konsultasi', '1', 3),
(4, 'Total Mata Kuliah', '7', 1),(4, 'Total SKS', '21', 2),(4, 'Ruang Dipakai', '5', 3),
(5, 'SKS Maksimum', '24', 1),(5, 'SKS Dipilih', '21', 2),(5, 'Status', 'Menunggu Validasi', 3),
(6, 'Semester Tercatat', '4', 1),(6, 'SKS Lulus', '63', 2),(6, 'IPK Sementara', '3.74', 3),
(7, 'Total MK', '48', 1),(7, 'MK Lulus', '17', 2),(7, 'Sisa SKS', '81', 3),
(8, 'Pernah Mengulang', '1', 1),(8, 'Nilai Membaik', '1', 2),(8, 'Sedang Proses', '0', 3),
(9, 'IPS Terakhir', '3.81', 1),(9, 'IPK', '3.74', 2),(9, 'Predikat', 'Sangat Baik', 3),
(10, 'Kegiatan Aktif', '3', 1),(10, 'Prestasi Tercatat', '2', 2),(10, 'Portofolio', 'Lengkap', 3),
(11, 'Sesi Bulan Ini', '4', 1),(11, 'Pembimbing', '2', 2),(11, 'Status', 'Aktif', 3),
(12, 'Workshop', '2', 1),(12, 'Seminar', '1', 2),(12, 'Sertifikat', '3', 3),
(13, 'Proposal Diajukan', '1', 1),(13, 'Status', 'Review', 2),(13, 'Revisi', '2', 3),
(14, 'Progress', '72%', 1),(14, 'Bab Selesai', '4', 2),(14, 'Target Sidang', 'Juli 2026', 3),
(15, 'Dokumen Lengkap', '6', 1),(15, 'Kurang', '1', 2),(15, 'Status', 'Persiapan', 3),
(16, 'Periode Wisuda', 'Gelombang 2', 1),(16, 'Status', 'Belum Dibuka', 2),(16, 'Checklist', '70%', 3),
(17, 'Semester Tersedia', '4', 1),(17, 'IPS Terakhir', '3.81', 2),(17, 'Status', 'Terverifikasi', 3),
(18, 'Mata Kuliah Lulus', '17', 1),(18, 'Total SKS', '63', 2),(18, 'IPK', '3.74', 3);

INSERT INTO portal_feature_items (feature_id, title, meta_text, urutan) VALUES
(1, 'Perubahan ruang kuliah Pemrograman Mobile 1', 'Ruang berpindah ke Lab WTD A Lt.3', 1),
(1, 'Pembukaan pengajuan beasiswa internal', 'Periode pengisian 25 Mei - 10 Juni 2026', 2),
(1, 'Batas akhir validasi KRS', 'Mahasiswa wajib final sebelum 10 Juni 2026', 3),
(2, '03 Juni 2026', 'Pembukaan pengisian KRS semester ganjil', 1),
(2, '10 Juni 2026', 'Batas akhir persetujuan dosen wali', 2),
(2, '17 Juni 2026', 'Publikasi jadwal kuliah dan ruang', 3),
(3, 'Senin - Bahasa Inggris 2', '08:50 - 09:30 WIB - Ruang 4.5A', 1),
(3, 'Rabu - Pemrograman Web', '13:00 - 15:30 WIB - Lab Web', 2),
(3, 'Jumat - Konsultasi Dosen Wali', '09:00 - 10:00 WIB - Online', 3),
(4, 'Struktur Data', 'Senin - 08:00 - 10:30 - Lab Komputer 1', 1),
(4, 'Pemrograman Mobile 1', 'Senin - 13:30 - 15:00 - Lab WTD', 2),
(4, 'Bahasa Inggris 2', 'Senin - 08:50 - 09:30 - Ruang 4.5A', 3),
(5, 'Pemrograman Mobile 1', '3 SKS - Wajib - Kelas MI4AP', 1),
(5, 'Bahasa Inggris 2', '2 SKS - Wajib - Kelas MI4AP', 2),
(5, 'Jaringan Komputer', '3 SKS - Pilihan - Kelas TK5A', 3),
(6, 'Semester 1', '20 SKS - Disetujui - IPS 3.58', 1),
(6, 'Semester 2', '22 SKS - Disetujui - IPS 3.72', 2),
(6, 'Semester 3', '21 SKS - Disetujui - IPS 3.81', 3),
(7, 'Kelompok Dasar', 'Matematika, Algoritma, Bahasa Inggris', 1),
(7, 'Kelompok Inti', 'Struktur Data, Basis Data, Web, Mobile', 2),
(7, 'Kelompok Penunjang', 'Kewirausahaan, Etika Profesi', 3),
(8, 'Logika Informatika', 'Nilai awal C - Perbaikan menjadi B+', 1),
(8, 'Praktikum Dasar', 'Tidak ada pengulangan aktif', 2),
(8, 'Evaluasi Semester', 'Konsultasikan dengan dosen wali bila perlu', 3),
(9, 'Struktur Data', 'A- - 3 SKS', 1),
(9, 'Pemrograman Web', 'A - 3 SKS', 2),
(9, 'Bahasa Inggris 2', 'B+ - 2 SKS', 3),
(10, 'Asisten Laboratorium Web', 'Semester Genap 2025/2026', 1),
(10, 'Juara 2 Hackathon Internal', 'Kategori aplikasi pendidikan', 2),
(10, 'Seminar Nasional IT', 'Peserta aktif dan pemakalah', 3),
(11, 'Konsultasi Proposal', 'Rabu, 27 Mei 2026 - Online', 1),
(11, 'Review Bab 2', 'Senin, 1 Juni 2026 - Ruang Dosen', 2),
(11, 'Catatan Pembimbing', 'Perbaiki metodologi dan tinjauan pustaka', 3),
(12, 'Workshop Penulisan Ilmiah', '31 Mei 2026 - Aula Kampus', 1),
(12, 'Pelatihan Referensi Mendeley', 'Online - Gratis', 2),
(12, 'Seminar Metodologi Penelitian', 'Wajib untuk mahasiswa tingkat akhir', 3),
(13, 'Sistem Informasi Akademik Berbasis Web', 'Status review oleh kaprodi', 1),
(13, 'Catatan Revisi 1', 'Tambahkan studi literatur terbaru', 2),
(13, 'Catatan Revisi 2', 'Perjelas skenario pengujian sistem', 3),
(14, 'Bab 1 - Pendahuluan', 'Selesai', 1),
(14, 'Bab 2 - Tinjauan Pustaka', 'Selesai dengan revisi minor', 2),
(14, 'Bab 4 - Implementasi', 'Sedang disusun', 3),
(15, 'Transkrip sementara', 'Sudah diunggah', 1),
(15, 'Bukti bebas pustaka', 'Menunggu verifikasi', 2),
(15, 'Surat bebas administrasi', 'Sudah terbit', 3),
(16, 'Form pendaftaran wisuda', 'Akan dibuka setelah yudisium', 1),
(16, 'Konfirmasi toga', 'Menunggu pengumuman BAAK', 2),
(16, 'Cetak kartu peserta', 'Tersedia setelah pembayaran valid', 3),
(17, 'KHS Semester 1', '20 SKS - IPS 3.58', 1),
(17, 'KHS Semester 2', '22 SKS - IPS 3.72', 2),
(17, 'KHS Semester 3', '21 SKS - IPS 3.81', 3),
(18, 'Algoritma Pemrograman', 'A - 3 SKS', 1),
(18, 'Basis Data', 'A- - 3 SKS', 2),
(18, 'Pemrograman Web', 'A - 3 SKS', 3);
