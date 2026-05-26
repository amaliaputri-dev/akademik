<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function getStudentSnapshot($current_user = NULL)
	{
		$current_name = !empty($current_user['name']) ? $current_user['name'] : 'Pengguna';
		$current_role = !empty($current_user['role_name']) ? $current_user['role_name'] : 'Pengguna';
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$current_identity = !empty($current_user['identity']) ? $current_user['identity'] : '-';
		$current_user_id = !empty($current_user['id']) ? (int) $current_user['id'] : 0;
		$is_mahasiswa = $current_role_slug === 'mahasiswa';
		$is_dosen = $current_role_slug === 'dosen';
		$profile = $is_mahasiswa ? $this->getStudentProfileByUser($current_user_id) : NULL;

		if ($profile)
		{
			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => (int) $profile['semester'],
				'ipk' => $profile['ipk'],
				'program' => $profile['program_studi'],
				'nim' => $profile['nim'],
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Saat ini Anda berada di Semester ' . (int) $profile['semester'] . ' dengan IPK ' . $profile['ipk'] . '.',
				'detail_label' => 'Lihat transkrip',
				'detail_url' => site_url('portal/feature/transkrip')
			);
		}

		if ($is_dosen)
		{
			$dosen = $this->db
				->where('user_id', $current_user_id)
				->get('dosen')
				->row_array();
			$kelas_diampu = (int) $this->db
				->where('dosen', !empty($dosen['nama']) ? $dosen['nama'] : $current_name)
				->count_all_results('jadwal_kuliah');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => !empty($dosen['prodi']) ? $dosen['prodi'] : '-',
				'nim' => !empty($dosen['nidn']) ? $dosen['nidn'] : '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda mengampu ' . $kelas_diampu . ' kelas aktif dan dapat melanjutkan validasi KRS, presensi, serta input nilai.',
				'detail_label' => 'Buka modul dosen',
				'detail_url' => site_url('akademik/dosen')
			);
		}

		if ($current_role_slug === 'baak')
		{
			$mahasiswa_total = (int) $this->db->count_all('mahasiswa');
			$krs_pending = (int) $this->db
				->where('LOWER(status_krs) !=', 'disetujui')
				->count_all_results('krs');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Administrasi Akademik',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda memantau ' . $mahasiswa_total . ' mahasiswa dengan ' . $krs_pending . ' KRS yang masih perlu tindak lanjut administrasi.',
				'detail_label' => 'Buka operasional BAAK',
				'detail_url' => site_url('akademik/krs')
			);
		}

		if ($current_role_slug === 'admin')
		{
			$roles_total = (int) $this->db->count_all('roles');
			$users_total = (int) $this->db->count_all('users');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Kontrol Sistem',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda mengelola ' . $roles_total . ' role kampus dan ' . $users_total . ' akun pengguna lintas modul.',
				'detail_label' => 'Buka matriks role',
				'detail_url' => site_url('roles')
			);
		}

		if ($current_role_slug === 'rektor')
		{
			$mahasiswa_total = (int) $this->db->count_all('mahasiswa');
			$dosen_total = (int) $this->db->count_all('dosen');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Pimpinan Universitas',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Dashboard strategis ini merangkum ' . $mahasiswa_total . ' mahasiswa aktif dan ' . $dosen_total . ' dosen untuk keputusan tingkat universitas.',
				'detail_label' => 'Buka data mahasiswa',
				'detail_url' => site_url('mahasiswa')
			);
		}

		if ($current_role_slug === 'wakil-rektor')
		{
			$jadwal_total = (int) $this->db->count_all('jadwal_kuliah');
			$krs_total = (int) $this->db->count_all('krs');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Koordinasi Lintas Unit',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda mengoordinasikan ' . $jadwal_total . ' jadwal aktif dan memantau ' . $krs_total . ' proses KRS lintas unit akademik.',
				'detail_label' => 'Buka jadwal kuliah',
				'detail_url' => site_url('akademik/jadwal')
			);
		}

		if ($current_role_slug === 'dekan')
		{
			$dosen_total = (int) $this->db->count_all('dosen');
			$mk_total = (int) $this->db->count_all('mata_kuliah');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Pimpinan Fakultas',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda memantau ' . $dosen_total . ' dosen dan kesiapan ' . $mk_total . ' mata kuliah pada level fakultas.',
				'detail_label' => 'Buka data dosen',
				'detail_url' => site_url('akademik/dosen')
			);
		}

		if ($current_role_slug === 'wakil-dekan')
		{
			$jadwal_total = (int) $this->db->count_all('jadwal_kuliah');
			$krs_total = (int) $this->db->count_all('krs');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Operasional Fakultas',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda mengoordinasikan ' . $jadwal_total . ' jadwal aktif dan memantau ' . $krs_total . ' proses akademik fakultas.',
				'detail_label' => 'Buka jadwal kuliah',
				'detail_url' => site_url('akademik/jadwal')
			);
		}

		if ($current_role_slug === 'dekan-kaprodi')
		{
			$dosen_total = (int) $this->db->count_all('dosen');
			$mk_total = (int) $this->db->count_all('mata_kuliah');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Kurikulum & Prodi',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda mengawasi distribusi ' . $dosen_total . ' dosen dan kesiapan ' . $mk_total . ' mata kuliah di level prodi/fakultas.',
				'detail_label' => 'Buka mata kuliah',
				'detail_url' => site_url('akademik/mata_kuliah')
			);
		}

		if ($current_role_slug === 'keuangan')
		{
			$mahasiswa_total = (int) $this->db->count_all('mahasiswa');

			return array(
				'name' => $current_name,
				'role' => $current_role,
				'semester' => 0,
				'ipk' => '0.00',
				'program' => 'Pembayaran Akademik',
				'nim' => '-',
				'identity' => $current_identity,
				'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
				'summary' => 'Anda memantau kesiapan registrasi dan status administrasi untuk ' . $mahasiswa_total . ' mahasiswa semester aktif.',
				'detail_label' => 'Buka data mahasiswa',
				'detail_url' => site_url('mahasiswa')
			);
		}

		return array(
			'name' => $current_name,
			'role' => $current_role,
			'semester' => 0,
			'ipk' => '0.00',
			'program' => '-',
			'nim' => '-',
			'identity' => $current_identity,
			'greeting' => 'Hai, ' . $this->formatGreetingName($current_name),
			'summary' => 'Anda login sebagai ' . $current_role . ' dan dapat mengakses layanan sesuai hak akun ini.',
			'detail_label' => 'Buka dashboard',
			'detail_url' => site_url('dashboard')
		);
	}

	private function formatGreetingName($name)
	{
		$name = trim((string) $name);

		if ($name === '')
		{
			return 'Pengguna';
		}

		return strtoupper($name);
	}

	private function getNilaiTableName()
	{
		if ($this->db->table_exists('nilai_mahasiswa'))
		{
			return 'nilai_mahasiswa';
		}

		return 'nilai';
	}

	public function getTodaySchedule($current_user = NULL)
	{
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$current_name = !empty($current_user['name']) ? $current_user['name'] : '';
		$current_user_id = !empty($current_user['id']) ? (int) $current_user['id'] : 0;

		if ($current_role_slug === 'mahasiswa')
		{
			return $this->getStudentSchedulePanel($current_user_id);
		}

		if ($current_role_slug === 'dosen')
		{
			return $this->getLecturerSchedule($current_user_id, $current_name);
		}

		if ($current_role_slug === 'baak')
		{
			return $this->getRoleOperationsPanel(
				'Panel Operasional BAAK',
				'Antrian layanan akademik semester aktif.',
				'Semester Aktif',
				site_url('akademik/jadwal'),
				'Buka modul akademik',
				array(
					array('title' => 'Registrasi & Layanan Mahasiswa', 'meta' => 'Kelola identitas mahasiswa, tiket akademik, dan status layanan semester.'),
					array('title' => 'Jadwal Kuliah & Ruang', 'meta' => 'Pastikan jadwal, ruang, dan bentrok kelas tertangani sebelum publikasi.'),
					array('title' => 'Validasi KRS & Arsip Nilai', 'meta' => 'Monitor progres persetujuan KRS dan kesiapan publikasi hasil studi.')
				)
			);
		}

		if ($current_role_slug === 'admin')
		{
			return $this->getRoleOperationsPanel(
				'Kontrol Sistem Admin',
				'Area kontrol penuh untuk seluruh data master dan proses akademik.',
				'Semua Modul',
				site_url('roles/detail/admin'),
				'Lihat akses admin',
				array(
					array('title' => 'Kelola Role & Pengguna', 'meta' => 'Pastikan pembagian hak akses kampus sesuai struktur kerja yang diinginkan.'),
					array('title' => 'Audit Data Akademik', 'meta' => 'Tinjau sinkronisasi mahasiswa, dosen, mata kuliah, jadwal, KRS, dan nilai.'),
					array('title' => 'Monitoring Semester Aktif', 'meta' => 'Pantau modul operasional inti dan tindak lanjut data yang perlu diperbaiki.')
				)
			);
		}

		return $this->getRoleOperationsPanel(
			'Ringkasan Role Kampus',
			'Panel utama disesuaikan dengan fokus kerja role yang sedang login.',
			'Role Aktif',
			!empty($current_role_slug) ? site_url('roles/detail/' . $current_role_slug) : site_url('roles'),
			'Lihat detail role',
			$this->buildGenericRoleItems($current_role_slug)
		);
	}

	public function getRoleKpis($current_user = NULL)
	{
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$current_user_id = !empty($current_user['id']) ? (int) $current_user['id'] : 0;
		$mahasiswa_total = (int) $this->db->count_all('mahasiswa');
		$dosen_total = (int) $this->db->count_all('dosen');
		$jadwal_total = (int) $this->db->count_all('jadwal_kuliah');
		$mk_total = (int) $this->db->count_all('mata_kuliah');
		$krs_total = (int) $this->db->count_all('krs');
		$nilai_total = (int) $this->db->count_all($this->getNilaiTableName());
		$users_total = (int) $this->db->count_all('users');
		$roles_total = (int) $this->db->count_all('roles');
		$krs_pending = (int) $this->db
			->where('LOWER(status_krs) !=', 'disetujui')
			->count_all_results('krs');

		if ($current_role_slug === 'mahasiswa')
		{
			$profile = $this->getStudentProfileByUser($current_user_id);
			$semester = !empty($profile['semester']) ? (int) $profile['semester'] : 0;
			$ipk = !empty($profile['ipk']) ? $profile['ipk'] : '0.00';
			$tagihan = $this->db->get('billing_summary')->row_array();

			return array(
				array('label' => 'Semester Aktif', 'value' => (string) $semester, 'tone' => 'blue'),
				array('label' => 'IPK Sementara', 'value' => (string) $ipk, 'tone' => 'gold'),
				array('label' => 'KRS Tercatat', 'value' => (string) $krs_total, 'tone' => 'green'),
				array('label' => 'Status Tagihan', 'value' => !empty($tagihan['status_label']) ? $tagihan['status_label'] : '-', 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'dosen')
		{
			$kelas_diampu = (int) $this->db
				->where('dosen', $this->getLecturerDisplayName($current_user_id, !empty($current_user['name']) ? $current_user['name'] : ''))
				->count_all_results('jadwal_kuliah');

			return array(
				array('label' => 'Kelas Diampu', 'value' => (string) $kelas_diampu, 'tone' => 'blue'),
				array('label' => 'KRS Dipantau', 'value' => (string) $krs_total, 'tone' => 'gold'),
				array('label' => 'Nilai Tersedia', 'value' => (string) $nilai_total, 'tone' => 'green'),
				array('label' => 'Jadwal Aktif', 'value' => (string) $jadwal_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'baak')
		{
			return array(
				array('label' => 'Mahasiswa Aktif', 'value' => (string) $mahasiswa_total, 'tone' => 'blue'),
				array('label' => 'KRS Pending', 'value' => (string) $krs_pending, 'tone' => 'gold'),
				array('label' => 'Jadwal Terbit', 'value' => (string) $jadwal_total, 'tone' => 'green'),
				array('label' => 'Nilai Tercatat', 'value' => (string) $nilai_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'admin')
		{
			return array(
				array('label' => 'Akun Pengguna', 'value' => (string) $users_total, 'tone' => 'blue'),
				array('label' => 'Role Kampus', 'value' => (string) $roles_total, 'tone' => 'gold'),
				array('label' => 'Modul Akademik', 'value' => '6', 'tone' => 'green'),
				array('label' => 'Data Mahasiswa', 'value' => (string) $mahasiswa_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'rektor')
		{
			return array(
				array('label' => 'Mahasiswa Aktif', 'value' => (string) $mahasiswa_total, 'tone' => 'blue'),
				array('label' => 'Dosen Aktif', 'value' => (string) $dosen_total, 'tone' => 'gold'),
				array('label' => 'Jadwal Semester', 'value' => (string) $jadwal_total, 'tone' => 'green'),
				array('label' => 'KRS Berjalan', 'value' => (string) $krs_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'wakil-rektor')
		{
			return array(
				array('label' => 'Jadwal Aktif', 'value' => (string) $jadwal_total, 'tone' => 'blue'),
				array('label' => 'KRS Pending', 'value' => (string) $krs_pending, 'tone' => 'gold'),
				array('label' => 'Dosen Terlibat', 'value' => (string) $dosen_total, 'tone' => 'green'),
				array('label' => 'Mata Kuliah', 'value' => (string) $mk_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'dekan-kaprodi')
		{
			return array(
				array('label' => 'Dosen Prodi', 'value' => (string) $dosen_total, 'tone' => 'blue'),
				array('label' => 'Mata Kuliah', 'value' => (string) $mk_total, 'tone' => 'gold'),
				array('label' => 'Jadwal Kelas', 'value' => (string) $jadwal_total, 'tone' => 'green'),
				array('label' => 'Nilai Masuk', 'value' => (string) $nilai_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'dekan')
		{
			return array(
				array('label' => 'Dosen Fakultas', 'value' => (string) $dosen_total, 'tone' => 'blue'),
				array('label' => 'Mata Kuliah', 'value' => (string) $mk_total, 'tone' => 'gold'),
				array('label' => 'Jadwal Kelas', 'value' => (string) $jadwal_total, 'tone' => 'green'),
				array('label' => 'Nilai Masuk', 'value' => (string) $nilai_total, 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'wakil-dekan')
		{
			return array(
				array('label' => 'Jadwal Aktif', 'value' => (string) $jadwal_total, 'tone' => 'blue'),
				array('label' => 'KRS Pending', 'value' => (string) $krs_pending, 'tone' => 'gold'),
				array('label' => 'Mahasiswa Aktif', 'value' => (string) $mahasiswa_total, 'tone' => 'green'),
				array('label' => 'Jurusan', 'value' => (string) $this->db->count_all('jurusan'), 'tone' => 'slate')
			);
		}

		if ($current_role_slug === 'keuangan')
		{
			return array(
				array('label' => 'Mahasiswa Terkait', 'value' => (string) $mahasiswa_total, 'tone' => 'blue'),
				array('label' => 'KRS Berjalan', 'value' => (string) $krs_total, 'tone' => 'gold'),
				array('label' => 'KRS Pending', 'value' => (string) $krs_pending, 'tone' => 'green'),
				array('label' => 'Jadwal Semester', 'value' => (string) $jadwal_total, 'tone' => 'slate')
			);
		}

		return array(
			array('label' => 'Mahasiswa', 'value' => (string) $mahasiswa_total, 'tone' => 'blue'),
			array('label' => 'Dosen', 'value' => (string) $dosen_total, 'tone' => 'gold'),
			array('label' => 'Jadwal', 'value' => (string) $jadwal_total, 'tone' => 'green'),
			array('label' => 'KRS', 'value' => (string) $krs_total, 'tone' => 'slate')
		);
	}

	public function getBillingSummary($current_user = NULL)
	{
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($current_role_slug === 'dosen')
		{
			return array(
				'title' => 'Status Akademik Dosen',
				'message' => 'Fokus hari ini pada jadwal mengajar, validasi KRS mahasiswa wali, dan ketuntasan input nilai.',
				'status' => 'Aktif'
			);
		}

		if ($current_role_slug === 'baak')
		{
			$jadwal_total = (int) $this->db->count_all('jadwal_kuliah');
			$krs_pending = (int) $this->db
				->where('LOWER(status_krs) !=', 'disetujui')
				->count_all_results('krs');

			return array(
				'title' => 'Layanan BAAK Berjalan',
				'message' => $jadwal_total . ' jadwal aktif dan ' . $krs_pending . ' KRS masih perlu validasi atau koreksi administratif.',
				'status' => 'Aktif'
			);
		}

		if ($current_role_slug === 'admin')
		{
			$users_total = (int) $this->db->count_all('users');
			$roles_total = (int) $this->db->count_all('roles');

			return array(
				'title' => 'Kontrol Sistem Aktif',
				'message' => $roles_total . ' role dan ' . $users_total . ' akun pengguna berada dalam cakupan kendali admin sistem.',
				'status' => 'Aktif'
			);
		}

		if ($current_role_slug === 'rektor')
		{
			$mahasiswa_total = (int) $this->db->count_all('mahasiswa');

			return array(
				'title' => 'Ringkasan Strategis',
				'message' => 'Fokus pimpinan saat ini pada mutu akademik, kesiapan semester, dan layanan untuk ' . $mahasiswa_total . ' mahasiswa aktif.',
				'status' => 'Strategis'
			);
		}

		if ($current_role_slug === 'wakil-rektor')
		{
			$jadwal_total = (int) $this->db->count_all('jadwal_kuliah');

			return array(
				'title' => 'Koordinasi Lintas Unit',
				'message' => 'Prioritas hari ini adalah sinkronisasi agenda semester dan pengawasan ' . $jadwal_total . ' sesi kuliah aktif lintas unit.',
				'status' => 'Koordinasi'
			);
		}

		if ($current_role_slug === 'dekan')
		{
			return array(
				'title' => 'Kontrol Fakultas',
				'message' => 'Pantau distribusi dosen, kurikulum, jadwal, dan hasil studi pada tingkat fakultas.',
				'status' => 'Fakultas'
			);
		}

		if ($current_role_slug === 'wakil-dekan')
		{
			return array(
				'title' => 'Operasional Fakultas',
				'message' => 'Fokus hari ini pada sinkronisasi jadwal, KRS, dan kebutuhan layanan akademik fakultas.',
				'status' => 'Koordinasi'
			);
		}

		if ($current_role_slug === 'dekan-kaprodi')
		{
			$mk_total = (int) $this->db->count_all('mata_kuliah');

			return array(
				'title' => 'Kontrol Prodi',
				'message' => 'Pantau distribusi kelas, dosen pengampu, dan kesiapan ' . $mk_total . ' mata kuliah pada semester aktif.',
				'status' => 'Prodi'
			);
		}

		if ($current_role_slug === 'keuangan')
		{
			$krs_total = (int) $this->db->count_all('krs');

			return array(
				'title' => 'Administrasi Pembayaran',
				'message' => 'Sinkronisasi pembayaran dan registrasi akademik sedang dipantau untuk ' . $krs_total . ' proses KRS semester aktif.',
				'status' => 'Keuangan'
			);
		}

		if ($current_role_slug !== 'mahasiswa')
		{
			return array(
				'title' => 'Ringkasan Role',
				'message' => 'Dashboard ini menampilkan panel kerja utama sesuai role akun yang sedang digunakan.',
				'status' => 'Aktif'
			);
		}

		$row = $this->db->get('billing_summary')->row_array();

		return $row ? array(
			'title' => $row['title'],
			'message' => $row['message'],
			'status' => $row['status_label']
		) : array('title' => '-', 'message' => '-', 'status' => '-');
	}

	public function getAcademicMiniCalendar()
	{
		$rows = $this->db
			->order_by('urutan', 'ASC')
			->get('mini_calendar_events')
			->result_array();

		return array(
			'month' => !empty($rows) ? $rows[0]['month_label'] : '-',
			'events' => array_map(function ($row) {
				return array('date' => $row['date_label'], 'text' => $row['text_value']);
			}, $rows)
		);
	}

	public function getNotificationCount()
	{
		$row = $this->db->get('notifications')->row_array();
		return $row ? (int) $row['total_count'] : 0;
	}

	public function getQuickMenus()
	{
		$rows = $this->db
			->order_by('urutan', 'ASC')
			->get('quick_menus')
			->result_array();

		return array_map(function ($row) {
			return array(
				'title' => $row['title'],
				'description' => $row['description'],
				'url' => site_url($row['url_path']),
				'badge' => $row['badge']
			);
		}, $rows);
	}

	public function getQuickMenusByRole($current_user = NULL)
	{
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($current_role_slug === 'mahasiswa')
		{
			return array(
				array('title' => 'Isi KRS', 'description' => 'Atur rencana studi semester aktif dan kirim ke dosen wali.', 'url' => site_url('portal/feature/pengisian-krs'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal Semester', 'description' => 'Lihat semua jadwal kuliah, ruang, dan jam belajar Anda.', 'url' => site_url('portal/feature/jadwal-semester'), 'badge' => 'Aktif'),
				array('title' => 'Nilai Mahasiswa', 'description' => 'Pantau nilai per mata kuliah dan performa semester berjalan.', 'url' => site_url('portal/feature/nilai-mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'Transkrip', 'description' => 'Buka rekap mata kuliah lulus dan IPK sementara Anda.', 'url' => site_url('portal/feature/transkrip'), 'badge' => 'Aktif')
			);
		}

		if ($current_role_slug === 'dosen')
		{
			return array(
				array('title' => 'Data Dosen', 'description' => 'Lihat profil pengajar, prodi, dan distribusi peran akademik.', 'url' => site_url('akademik/dosen'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal Mengajar', 'description' => 'Pantau kelas yang diampu berikut ruang dan waktu perkuliahan.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Aktif'),
				array('title' => 'Validasi KRS', 'description' => 'Tinjau status KRS mahasiswa wali yang masih menunggu persetujuan.', 'url' => site_url('akademik/krs'), 'badge' => 'Aktif'),
				array('title' => 'Input Nilai', 'description' => 'Masuk ke modul nilai untuk menuntaskan publikasi hasil studi.', 'url' => site_url('akademik/nilai'), 'badge' => 'Aktif')
			);
		}

		if ($current_role_slug === 'baak')
		{
			return array(
				array('title' => 'Layanan Mahasiswa', 'description' => 'Buka modul mahasiswa untuk memantau identitas dan layanan akademik.', 'url' => site_url('mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal Kuliah', 'description' => 'Atur jadwal, ruang kuliah, dan kesiapan publikasi kelas.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Aktif'),
				array('title' => 'Validasi KRS', 'description' => 'Monitor progres pengisian dan persetujuan KRS semester aktif.', 'url' => site_url('akademik/krs'), 'badge' => 'Aktif'),
				array('title' => 'Arsip Nilai', 'description' => 'Akses rekap nilai dan hasil studi untuk kebutuhan layanan akademik.', 'url' => site_url('akademik/nilai'), 'badge' => 'Aktif')
			);
		}

		if ($current_role_slug === 'admin')
		{
			return array(
				array('title' => 'Role Kampus', 'description' => 'Tinjau struktur peran, fokus kerja, dan cakupan modul setiap role.', 'url' => site_url('roles'), 'badge' => 'Aktif'),
				array('title' => 'Data Mahasiswa', 'description' => 'Kelola identitas, jurusan, dan data akademik mahasiswa.', 'url' => site_url('mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'Data Dosen', 'description' => 'Pantau data tenaga pengajar dan distribusi prodi.', 'url' => site_url('akademik/dosen'), 'badge' => 'Aktif'),
				array('title' => 'Master Akademik', 'description' => 'Masuk ke jadwal, KRS, nilai, dan mata kuliah sebagai admin penuh.', 'url' => site_url('akademik/mata_kuliah'), 'badge' => 'Aktif')
			);
		}

		if ($current_role_slug === 'rektor')
		{
			return array(
				array('title' => 'Data Mahasiswa', 'description' => 'Lihat skala layanan akademik mahasiswa secara menyeluruh.', 'url' => site_url('mahasiswa'), 'badge' => 'Monitor'),
				array('title' => 'Data Dosen', 'description' => 'Pantau distribusi tenaga pengajar dan cakupan pengampu.', 'url' => site_url('akademik/dosen'), 'badge' => 'Monitor'),
				array('title' => 'Jadwal Kuliah', 'description' => 'Periksa kesiapan operasional semester dari level universitas.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Monitor'),
				array('title' => 'KRS Semester', 'description' => 'Pantau aktivitas KRS sebagai indikator kesiapan semester.', 'url' => site_url('akademik/krs'), 'badge' => 'Strategis')
			);
		}

		if ($current_role_slug === 'wakil-rektor')
		{
			return array(
				array('title' => 'Operasional Akademik', 'description' => 'Pantau mahasiswa, dosen, dan agenda semester lintas unit.', 'url' => site_url('mahasiswa'), 'badge' => 'Koordinasi'),
				array('title' => 'Jadwal Kuliah', 'description' => 'Monitor kesiapan ruang dan distribusi sesi perkuliahan.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Aktif'),
				array('title' => 'KRS', 'description' => 'Lihat progres validasi KRS sebagai indikator kesiapan semester.', 'url' => site_url('akademik/krs'), 'badge' => 'Aktif'),
				array('title' => 'Data Dosen', 'description' => 'Pantau distribusi pengampu untuk sinkronisasi unit akademik.', 'url' => site_url('akademik/dosen'), 'badge' => 'Monitor')
			);
		}

		if ($current_role_slug === 'dekan')
		{
			return array(
				array('title' => 'Data Dosen', 'description' => 'Pantau dosen fakultas dan distribusi pengampu.', 'url' => site_url('akademik/dosen'), 'badge' => 'Aktif'),
				array('title' => 'Jurusan', 'description' => 'Kelola master jurusan dan sebaran mahasiswa fakultas.', 'url' => site_url('mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'Mata Kuliah', 'description' => 'Kontrol kurikulum dan kesiapan mata kuliah fakultas.', 'url' => site_url('akademik/mata_kuliah'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal', 'description' => 'Monitor distribusi kelas dan ruang kuliah.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Monitor')
			);
		}

		if ($current_role_slug === 'wakil-dekan')
		{
			return array(
				array('title' => 'Jurusan', 'description' => 'Pantau jurusan dan basis mahasiswa pada level fakultas.', 'url' => site_url('mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal Kuliah', 'description' => 'Koordinasikan distribusi ruang dan sesi kelas.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Aktif'),
				array('title' => 'KRS', 'description' => 'Lihat progres KRS sebagai indikator kesiapan semester.', 'url' => site_url('akademik/krs'), 'badge' => 'Monitor'),
				array('title' => 'Nilai', 'description' => 'Pantau hasil studi untuk tindak lanjut akademik fakultas.', 'url' => site_url('akademik/nilai'), 'badge' => 'Monitor')
			);
		}

		if ($current_role_slug === 'dekan-kaprodi')
		{
			return array(
				array('title' => 'Data Dosen', 'description' => 'Pantau dosen pengampu, koordinator, dan distribusi beban ajar.', 'url' => site_url('akademik/dosen'), 'badge' => 'Aktif'),
				array('title' => 'Mata Kuliah', 'description' => 'Kontrol kesiapan kurikulum dan daftar mata kuliah prodi.', 'url' => site_url('akademik/mata_kuliah'), 'badge' => 'Aktif'),
				array('title' => 'Jadwal', 'description' => 'Monitor distribusi kelas dan kebutuhan ruang kuliah.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Aktif'),
				array('title' => 'Nilai', 'description' => 'Lihat hasil studi untuk evaluasi performa perkuliahan.', 'url' => site_url('akademik/nilai'), 'badge' => 'Monitor')
			);
		}

		if ($current_role_slug === 'keuangan')
		{
			return array(
				array('title' => 'Data Mahasiswa', 'description' => 'Pantau basis mahasiswa yang terdampak status administrasi.', 'url' => site_url('mahasiswa'), 'badge' => 'Aktif'),
				array('title' => 'KRS', 'description' => 'Lihat progres KRS sebagai indikasi aktivasi semester mahasiswa.', 'url' => site_url('akademik/krs'), 'badge' => 'Monitor'),
				array('title' => 'Pengumuman', 'description' => 'Buka informasi umum kampus yang berhubungan dengan layanan semester.', 'url' => site_url('portal/feature/pengumuman'), 'badge' => 'Info'),
				array('title' => 'Jadwal Kuliah', 'description' => 'Pantau periode akademik yang berdampak pada administrasi mahasiswa.', 'url' => site_url('akademik/jadwal'), 'badge' => 'Referensi')
			);
		}

		return $this->getQuickMenus();
	}

	public function getAnnouncements($current_user = NULL)
	{
		$announcements = $this->db
			->select('title, content, date_label AS date')
			->order_by('urutan', 'ASC')
			->get('announcements')
			->result_array();

		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($current_role_slug === 'dosen')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Dosen',
				'content' => 'Lengkapi presensi kelas, validasi KRS mahasiswa wali, dan pantau tenggat input nilai semester aktif.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'mahasiswa')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Mahasiswa',
				'content' => 'Periksa status KRS, kehadiran kuliah, dan jadwal pembaruan KHS pada portal akademik.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'baak')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder BAAK',
				'content' => 'Periksa pembukaan KRS, jadwal kelas, dan permintaan layanan akademik mahasiswa yang masih antre.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'admin')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Admin',
				'content' => 'Tinjau pembagian role, konsistensi data master, dan kesiapan modul operasional semester aktif.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'rektor')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Rektor',
				'content' => 'Pantau kesiapan semester, mutu layanan akademik, dan isu strategis lintas unit yang perlu keputusan pimpinan.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'wakil-rektor')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Wakil Rektor',
				'content' => 'Sinkronkan agenda unit kerja, jadwal kuliah, dan progres KRS untuk menjaga ritme semester tetap stabil.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'dekan')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Dekan',
				'content' => 'Pantau mutu akademik fakultas, distribusi dosen, dan kesiapan kurikulum semester aktif.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'wakil-dekan')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Wakil Dekan',
				'content' => 'Sinkronkan jadwal kelas, tindak lanjut KRS, dan layanan operasional akademik fakultas.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'dekan-kaprodi')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Dekan / Kaprodi',
				'content' => 'Periksa distribusi dosen, kesiapan kurikulum, dan performa kelas aktif di lingkungan prodi atau fakultas.',
				'date' => date('d M Y')
			));
		}
		elseif ($current_role_slug === 'keuangan')
		{
			array_unshift($announcements, array(
				'title' => 'Reminder Keuangan',
				'content' => 'Pastikan sinkronisasi status pembayaran dan registrasi akademik tidak menghambat proses semester aktif.',
				'date' => date('d M Y')
			));
		}

		return $announcements;
	}

	public function getRoleDashboardContext($current_user = NULL)
	{
		$current_role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($current_role_slug === 'mahasiswa')
		{
			return array(
				'service_title' => 'Layanan Akademik Mahasiswa',
				'service_description' => 'Pintasan cepat ke layanan utama mahasiswa selama semester berjalan.',
				'side_title' => 'Total Tagihan',
				'side_icon' => 'RP'
			);
		}

		if ($current_role_slug === 'dosen')
		{
			return array(
				'service_title' => 'Ruang Kerja Dosen',
				'service_description' => 'Akses cepat untuk kelas yang diampu, perwalian, dan evaluasi hasil studi.',
				'side_title' => 'Fokus Mengajar',
				'side_icon' => 'DS'
			);
		}

		if ($current_role_slug === 'baak')
		{
			return array(
				'service_title' => 'Ruang Kerja BAAK',
				'service_description' => 'Akses cepat untuk layanan administrasi akademik, jadwal, KRS, dan arsip hasil studi.',
				'side_title' => 'Fokus Operasional',
				'side_icon' => 'BK'
			);
		}

		if ($current_role_slug === 'admin')
		{
			return array(
				'service_title' => 'Pusat Kendali Admin',
				'service_description' => 'Kontrol penuh untuk data master, role, dan modul akademik lintas unit.',
				'side_title' => 'Kontrol Sistem',
				'side_icon' => 'AD'
			);
		}

		if ($current_role_slug === 'rektor')
		{
			return array(
				'service_title' => 'Ringkasan Strategis Rektor',
				'service_description' => 'Akses cepat ke area monitoring universitas, mutu akademik, dan layanan lintas unit.',
				'side_title' => 'Fokus Strategis',
				'side_icon' => 'RK'
			);
		}

		if ($current_role_slug === 'wakil-rektor')
		{
			return array(
				'service_title' => 'Koordinasi Wakil Rektor',
				'service_description' => 'Akses cepat untuk memantau operasional akademik, agenda semester, dan sinkronisasi unit kerja.',
				'side_title' => 'Sinkronisasi Unit',
				'side_icon' => 'WR'
			);
		}

		if ($current_role_slug === 'dekan')
		{
			return array(
				'service_title' => 'Kontrol Akademik Fakultas',
				'service_description' => 'Akses cepat ke dosen, jurusan, kurikulum, dan jadwal pada level fakultas.',
				'side_title' => 'Fokus Fakultas',
				'side_icon' => 'DK'
			);
		}

		if ($current_role_slug === 'wakil-dekan')
		{
			return array(
				'service_title' => 'Operasional Wakil Dekan',
				'service_description' => 'Akses cepat untuk sinkronisasi jurusan, jadwal, KRS, dan evaluasi semester.',
				'side_title' => 'Sinkronisasi Fakultas',
				'side_icon' => 'WD'
			);
		}

		if ($current_role_slug === 'dekan-kaprodi')
		{
			return array(
				'service_title' => 'Kontrol Akademik Prodi',
				'service_description' => 'Akses cepat untuk kurikulum, dosen pengampu, jadwal, dan evaluasi hasil studi.',
				'side_title' => 'Fokus Prodi',
				'side_icon' => 'DK'
			);
		}

		if ($current_role_slug === 'keuangan')
		{
			return array(
				'service_title' => 'Administrasi Keuangan Akademik',
				'service_description' => 'Akses cepat ke area yang membantu verifikasi registrasi dan sinkronisasi layanan pembayaran.',
				'side_title' => 'Fokus Keuangan',
				'side_icon' => 'KU'
			);
		}

		return array(
			'service_title' => 'Layanan Akademik',
			'service_description' => 'Pintasan cepat ke modul yang paling sering dipakai pada portal akademik.',
			'side_title' => 'Ringkasan Akses',
			'side_icon' => 'UB'
		);
	}

	private function getLecturerSchedule($user_id, $fallback_name)
	{
		$lecturer_name = $this->getLecturerDisplayName($user_id, $fallback_name);
		$rows = $this->db
			->where('dosen', $lecturer_name)
			->order_by('id', 'ASC')
			->get('jadwal_kuliah')
			->result_array();

		if (empty($rows))
		{
			return array(
				'title' => 'Jadwal Mengajar Dosen',
				'total_text' => 'Belum ada kelas aktif yang terjadwal',
				'date_label' => '-',
				'action_label' => 'Buka modul jadwal',
				'action_url' => site_url('akademik/jadwal'),
				'items' => array()
			);
		}

		return array(
			'title' => 'Jadwal Mengajar Dosen',
			'total_text' => 'Anda mengampu ' . count($rows) . ' sesi perkuliahan aktif.',
			'date_label' => 'Semester Aktif',
			'action_label' => 'Buka modul jadwal',
			'action_url' => site_url('akademik/jadwal'),
			'items' => array_map(function ($row, $index) {
				return array(
					'course' => $row['mata_kuliah'],
					'time' => $row['hari'] . ', ' . $row['waktu'],
					'lecturer' => $row['dosen'],
					'room' => $row['ruang'],
					'sks' => 'Kelas aktif',
					'meeting' => 'Sesi ke-' . ($index + 1),
					'attendance' => 'Siap presensi'
				);
			}, $rows, array_keys($rows))
		);
	}

	private function getStudentSchedulePanel($user_id = 0)
	{
		$profile = $this->getStudentProfileByUser($user_id);
		$rows = $this->db
			->order_by('urutan', 'ASC')
			->get('student_schedule')
			->result_array();

		if (empty($rows))
		{
			return array(
				'panel_type' => 'schedule',
				'title' => 'Jadwal Kuliah Mahasiswa',
				'total_text' => 'Belum ada jadwal',
				'date_label' => '-',
				'action_label' => 'Lihat jadwal semester',
				'action_url' => site_url('portal/feature/jadwal-semester'),
				'items' => array()
			);
		}

		return array(
			'panel_type' => 'schedule',
			'title' => 'Jadwal Kuliah Mahasiswa',
			'date_label' => $rows[0]['date_label'],
			'total_text' => !empty($profile['name']) ? 'Jadwal kuliah untuk ' . $profile['name'] : $rows[0]['total_text'],
			'action_label' => 'Lihat jadwal semester',
			'action_url' => site_url('portal/feature/jadwal-semester'),
			'items' => array_map(function ($row) {
				return array(
					'course' => $row['course'],
					'time' => $row['time_label'],
					'lecturer' => $row['lecturer'],
					'room' => $row['room'],
					'sks' => $row['sks_label'],
					'meeting' => $row['meeting_label'],
					'attendance' => $row['attendance_label']
				);
			}, $rows)
		);
	}

	private function getStudentProfileByUser($user_id)
	{
		if ($user_id <= 0)
		{
			return NULL;
		}

		return $this->db
			->where('user_id', $user_id)
			->get('student_profile')
			->row_array();
	}

	private function getLecturerDisplayName($user_id, $fallback_name)
	{
		if ($user_id > 0)
		{
			$dosen = $this->db
				->select('nama')
				->where('user_id', $user_id)
				->get('dosen')
				->row_array();

			if (!empty($dosen['nama']))
			{
				return $dosen['nama'];
			}
		}

		return $fallback_name;
	}

	private function getRoleOperationsPanel($title, $total_text, $date_label, $action_url, $action_label, $items)
	{
		return array(
			'panel_type' => 'operations',
			'title' => $title,
			'total_text' => $total_text,
			'date_label' => $date_label,
			'action_label' => $action_label,
			'action_url' => $action_url,
			'items' => $items
		);
	}

	private function buildGenericRoleItems($role_slug)
	{
		$map = array(
			'rektor' => array(
				array('title' => 'Kebijakan Akademik', 'meta' => 'Pantau laporan strategis universitas dan arah keputusan semester.'),
				array('title' => 'Mutu & KPI Kampus', 'meta' => 'Lihat ringkasan performa fakultas, unit, dan target mutu.'),
				array('title' => 'Monitoring Lintas Unit', 'meta' => 'Tinjau isu prioritas yang perlu keputusan pimpinan.')
			),
			'wakil-rektor' => array(
				array('title' => 'Sinkronisasi Unit', 'meta' => 'Koordinasikan operasional akademik lintas fakultas dan layanan kampus.'),
				array('title' => 'Agenda Semester', 'meta' => 'Awasi persetujuan agenda dan kebutuhan unit akademik.'),
				array('title' => 'Tindak Lanjut Pimpinan', 'meta' => 'Pastikan isu prioritas segera diteruskan ke unit terkait.')
			),
			'dekan-kaprodi' => array(
				array('title' => 'Kontrol Kurikulum', 'meta' => 'Pantau sebaran mata kuliah dan evaluasi kurikulum prodi.'),
				array('title' => 'Distribusi Dosen', 'meta' => 'Tinjau penugasan dosen pengampu dan kebutuhan kelas.'),
				array('title' => 'Rekap Prodi', 'meta' => 'Lihat capaian kelas, performa dosen, dan hasil studi mahasiswa.')
			),
			'keuangan' => array(
				array('title' => 'Validasi Pembayaran', 'meta' => 'Periksa status UKT dan daftar ulang mahasiswa semester aktif.'),
				array('title' => 'Sinkronisasi Registrasi', 'meta' => 'Pastikan mahasiswa lunas siap diaktifkan ke sistem akademik.'),
				array('title' => 'Tindak Lanjut Tagihan', 'meta' => 'Pantau tunggakan dan kasus yang perlu klarifikasi administrasi.')
			)
		);

		return isset($map[$role_slug]) ? $map[$role_slug] : array(
			array('title' => 'Akses Role', 'meta' => 'Tinjau cakupan fitur yang tersedia untuk akun ini.'),
			array('title' => 'Modul Aktif', 'meta' => 'Masuk ke modul yang relevan dengan pekerjaan Anda.'),
			array('title' => 'Agenda Semester', 'meta' => 'Pantau informasi penting akademik yang sedang berjalan.')
		);
	}

	public function getPortalFeature($slug)
	{
		$feature = $this->db
			->where('slug', $slug)
			->get('portal_features')
			->row_array();

		if (!$feature)
		{
			return NULL;
		}

		$feature['stats'] = $this->db
			->select('label, value_text AS value')
			->where('feature_id', $feature['id'])
			->order_by('urutan', 'ASC')
			->get('portal_feature_stats')
			->result_array();
		$feature['list'] = $this->db
			->select('title, meta_text AS meta')
			->where('feature_id', $feature['id'])
			->order_by('urutan', 'ASC')
			->get('portal_feature_items')
			->result_array();

		return $feature;
	}
}
