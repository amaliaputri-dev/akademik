<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siakad_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->ensureJurusanTable();
		$this->ensureUserFacultyColumn();
		$this->ensureAcademicRelations();
		$this->ensureCoreRoles();
		$this->ensureAdminRole();
		$this->ensureDefaultRoleUsers();
		$this->ensureUserRelations();
	}

	public function getNavigation($current_user = NULL)
	{
		$menus = array(
			array('key' => 'dashboard', 'label' => 'Dashboard', 'url' => site_url('dashboard')),
			array('key' => 'mahasiswa', 'label' => 'Mahasiswa', 'url' => site_url('mahasiswa')),
			array('key' => 'dosen', 'label' => 'Dosen', 'url' => site_url('akademik/dosen')),
			array('key' => 'mata_kuliah', 'label' => 'Mata Kuliah', 'url' => site_url('akademik/mata_kuliah')),
			array('key' => 'jadwal', 'label' => 'Jadwal', 'url' => site_url('akademik/jadwal')),
			array('key' => 'krs', 'label' => 'KRS', 'url' => site_url('akademik/krs')),
			array('key' => 'nilai', 'label' => 'Nilai', 'url' => site_url('akademik/nilai'))
		);

		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($role_slug === 'mahasiswa')
		{
			return array(
				array('key' => 'dashboard', 'label' => 'Beranda', 'url' => site_url('dashboard')),
				array('key' => 'jadwal', 'label' => 'Jadwal', 'url' => site_url('portal/feature/jadwal-semester')),
				array('key' => 'krs', 'label' => 'KRS', 'url' => site_url('portal/feature/pengisian-krs')),
				array('key' => 'nilai', 'label' => 'Nilai', 'url' => site_url('portal/feature/nilai-mahasiswa'))
			);
		}

		if ($role_slug === 'dosen')
		{
			return array(
				array('key' => 'dashboard', 'label' => 'Dashboard Dosen', 'url' => site_url('dashboard')),
				array('key' => 'dosen', 'label' => 'Profil Dosen', 'url' => site_url('akademik/dosen')),
				array('key' => 'jadwal', 'label' => 'Jadwal Mengajar', 'url' => site_url('akademik/jadwal')),
				array('key' => 'krs', 'label' => 'Perwalian', 'url' => site_url('akademik/krs')),
				array('key' => 'nilai', 'label' => 'Input Nilai', 'url' => site_url('akademik/nilai'))
			);
		}

		if ($role_slug === 'admin')
		{
			return array(
				array('key' => 'dashboard', 'label' => 'Dashboard Admin', 'url' => site_url('dashboard')),
				array('key' => 'mahasiswa', 'label' => 'Mahasiswa', 'url' => site_url('mahasiswa')),
				array('key' => 'dosen', 'label' => 'Dosen', 'url' => site_url('akademik/dosen')),
				array('key' => 'mata_kuliah', 'label' => 'Mata Kuliah', 'url' => site_url('akademik/mata_kuliah')),
				array('key' => 'jadwal', 'label' => 'Jadwal', 'url' => site_url('akademik/jadwal')),
				array('key' => 'krs', 'label' => 'KRS', 'url' => site_url('akademik/krs')),
				array('key' => 'nilai', 'label' => 'Nilai', 'url' => site_url('akademik/nilai')),
				array('key' => 'roles', 'label' => 'Role Kampus', 'url' => site_url('roles'))
			);
		}

		if ($role_slug === 'baak')
		{
			return array(
				array('key' => 'dashboard', 'label' => 'Dashboard BAAK', 'url' => site_url('dashboard')),
				array('key' => 'mahasiswa', 'label' => 'Mahasiswa', 'url' => site_url('mahasiswa')),
				array('key' => 'jadwal', 'label' => 'Jadwal Kuliah', 'url' => site_url('akademik/jadwal')),
				array('key' => 'krs', 'label' => 'Validasi KRS', 'url' => site_url('akademik/krs')),
				array('key' => 'nilai', 'label' => 'Arsip Nilai', 'url' => site_url('akademik/nilai'))
			);
		}

		return $menus;
	}

	public function getPortalNavigation($current_user = NULL)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		if ($role_slug !== '' && $role_slug !== 'mahasiswa')
		{
			return $this->buildOperationalNavigation($current_user);
		}

		$menus = $this->db
			->order_by('urutan', 'ASC')
			->get('portal_navigation')
			->result_array();

		foreach ($menus as &$menu)
		{
			$menu['url'] = $this->buildUrl($menu['url_path']);
			$menu['children'] = $this->db
				->where('navigation_id', $menu['id'])
				->order_by('urutan', 'ASC')
				->get('portal_navigation_items')
				->result_array();

			foreach ($menu['children'] as &$child)
			{
				$child['icon'] = $child['icon_code'];
				$child['url'] = $this->buildUrl($child['url_path']);
			}
		}

		return $menus;
	}

	public function getRoleUiContext($current_user = NULL)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';

		$contexts = array(
			'mahasiswa' => array(
				'brand_kicker' => 'Portal Mahasiswa',
				'brand_title' => 'Ruang Akademik Mahasiswa',
				'brand_subtitle' => 'KRS, jadwal kuliah, nilai, dan progres studi pribadi dalam satu tempat.',
				'utility_text' => 'Akses mandiri untuk seluruh kebutuhan studi mahasiswa selama semester berjalan.',
				'utility_pills' => array('Mode Mahasiswa', 'Layanan Studi'),
				'avatar_label' => 'MHS'
			),
			'dosen' => array(
				'brand_kicker' => 'Portal Dosen',
				'brand_title' => 'Ruang Kerja Pengajar',
				'brand_subtitle' => 'Pantau kelas diampu, perwalian, presensi, dan evaluasi hasil studi.',
				'utility_text' => 'Pusat kerja dosen untuk pengajaran, validasi KRS, dan tindak lanjut akademik.',
				'utility_pills' => array('Mode Dosen', 'Kelas Aktif'),
				'avatar_label' => 'DSN'
			),
			'admin' => array(
				'brand_kicker' => 'Portal Admin',
				'brand_title' => 'Pusat Kendali Akademik',
				'brand_subtitle' => 'Kelola data inti kampus, operasional semester, dan kontrol sistem.',
				'utility_text' => 'Mode operasional penuh untuk administrasi dan pengelolaan modul akademik.',
				'utility_pills' => array('Mode Admin', 'CRUD Aktif'),
				'avatar_label' => 'ADM'
			),
			'baak' => array(
				'brand_kicker' => 'Portal BAAK',
				'brand_title' => 'Operasional Akademik',
				'brand_subtitle' => 'Kendalikan layanan registrasi, jadwal, KRS, dan arsip akademik.',
				'utility_text' => 'Ruang kerja administrasi akademik untuk pengaturan semester dan layanan kampus.',
				'utility_pills' => array('Mode BAAK', 'Semester Aktif'),
				'avatar_label' => 'BAA'
			),
			'dekan' => array(
				'brand_kicker' => 'Portal Dekan',
				'brand_title' => 'Pimpinan Fakultas',
				'brand_subtitle' => 'Kontrol mutu akademik fakultas, distribusi dosen, dan arah kurikulum.',
				'utility_text' => 'Ruang kerja dekan untuk memantau kualitas akademik dan performa fakultas.',
				'utility_pills' => array('Mode Dekan', 'Fakultas'),
				'avatar_label' => 'DK'
			),
			'wakil-dekan' => array(
				'brand_kicker' => 'Portal Wakil Dekan',
				'brand_title' => 'Koordinasi Fakultas',
				'brand_subtitle' => 'Sinkronisasi jadwal, layanan akademik, dan kebutuhan operasional fakultas.',
				'utility_text' => 'Ruang kerja wakil dekan untuk koordinasi semester dan tindak lanjut operasional.',
				'utility_pills' => array('Mode Wadek', 'Operasional'),
				'avatar_label' => 'WD'
			)
		);

		$default = array(
			'brand_kicker' => 'SIM Akademik',
			'brand_title' => 'Universitas Bani Saleh',
			'brand_subtitle' => 'Portal akademik terpadu untuk administrasi, perkuliahan, dan hasil studi',
			'utility_text' => 'Portal kampus terintegrasi untuk operasional akademik, persetujuan, dan layanan mahasiswa.',
			'utility_pills' => array('Semester Ganjil 2026/2027', 'Portal Akademik'),
			'avatar_label' => 'UBS'
		);

		return isset($contexts[$role_slug]) ? $contexts[$role_slug] : $default;
	}

	public function getDosen($current_user = NULL)
	{
		$query = $this->db
			->select('id, nidn, nama, prodi, status_jabatan')
			->from('dosen');

		$this->applyFacultyProgramScope($query, $current_user, 'prodi');

		return $query
			->order_by('nama', 'ASC')
			->get()
			->result_array();
	}

	public function getMataKuliah($current_user = NULL)
	{
		$query = $this->db
			->select('id, kode, nama, sks, semester, prodi')
			->from('mata_kuliah');

		$this->applyFacultyProgramScope($query, $current_user, 'prodi');

		return $query
			->order_by('semester', 'ASC')
			->order_by('kode', 'ASC')
			->get()
			->result_array();
	}

	public function getJadwalKuliah($current_user = NULL)
	{
		$query = $this->db
			->select('jadwal_kuliah.id, jadwal_kuliah.hari, jadwal_kuliah.waktu, jadwal_kuliah.mata_kuliah, jadwal_kuliah.dosen, jadwal_kuliah.ruang')
			->from('jadwal_kuliah')
			->join('mata_kuliah', 'mata_kuliah.nama = jadwal_kuliah.mata_kuliah', 'left');

		$this->applyFacultyProgramScope($query, $current_user, 'mata_kuliah.prodi');

		return $query
			->order_by('jadwal_kuliah.id', 'ASC')
			->get()
			->result_array();
	}

	public function getKrsAktif($current_user = NULL)
	{
		$query = $this->db
			->select('krs.id, krs.mahasiswa_id, COALESCE(mahasiswa.nim, krs.nim) AS nim, COALESCE(mahasiswa.nama, krs.nama) AS nama, krs.semester, krs.sks_diambil, krs.status_krs', FALSE)
			->from('krs')
			->join('mahasiswa', 'mahasiswa.id = krs.mahasiswa_id', 'left');

		$this->applyStudentRecordScope($query, $current_user, 'krs.mahasiswa_id', 'krs.nim');
		$this->applyFacultyRecordScope($query, $current_user, 'krs.mahasiswa_id', 'krs.nim');

		return $query
			->order_by('nim', 'ASC')
			->get()
			->result_array();
	}

	public function getNilaiMahasiswa($current_user = NULL)
	{
		$query = $this->db
			->select('nilai_mahasiswa.id, nilai_mahasiswa.mahasiswa_id, COALESCE(mahasiswa.nim, nilai_mahasiswa.nim) AS nim, COALESCE(mahasiswa.nama, nilai_mahasiswa.nama) AS nama, nilai_mahasiswa.ips, nilai_mahasiswa.ipk, nilai_mahasiswa.status_nilai', FALSE)
			->from('nilai_mahasiswa')
			->join('mahasiswa', 'mahasiswa.id = nilai_mahasiswa.mahasiswa_id', 'left');

		$this->applyStudentRecordScope($query, $current_user, 'nilai_mahasiswa.mahasiswa_id', 'nilai_mahasiswa.nim');
		$this->applyFacultyRecordScope($query, $current_user, 'nilai_mahasiswa.mahasiswa_id', 'nilai_mahasiswa.nim');

		return $query
			->order_by('nim', 'ASC')
			->get()
			->result_array();
	}

	public function getAcademicCalendar()
	{
		return $this->db
			->select('tanggal_label AS tanggal, agenda')
			->order_by('urutan', 'ASC')
			->get('kalender_akademik')
			->result_array();
	}

	public function getSystemHighlights()
	{
		return $this->db
			->select('title, text_value AS text')
			->order_by('urutan', 'ASC')
			->get('system_highlights')
			->result_array();
	}

	public function getCampusRoles()
	{
		$roles = $this->db
			->select('id, slug, name, level_label AS level, focus, color')
			->order_by('id', 'ASC')
			->get('roles')
			->result_array();

		foreach ($roles as &$role)
		{
			$role['features'] = $this->pluckRoleTable('role_features', 'feature_label', $role['id']);
		}

		return $roles;
	}

	public function getRoleBySlug($slug)
	{
		$role = $this->db
			->select('id, slug, name, level_label AS level, focus, color')
			->where('slug', $slug)
			->get('roles')
			->row_array();

		if (!$role)
		{
			return NULL;
		}

		$role['features'] = $this->pluckRoleTable('role_features', 'feature_label', $role['id']);
		$role['summary_stats'] = $this->db
			->select('label, value_text AS value, note')
			->where('role_id', $role['id'])
			->order_by('urutan', 'ASC')
			->get('role_summary_stats')
			->result_array();
		$role['workflows'] = $this->db
			->select('step_text AS step, owner_text AS owner')
			->where('role_id', $role['id'])
			->order_by('urutan', 'ASC')
			->get('role_workflows')
			->result_array();
		$role['inbox'] = $this->pluckRoleTable('role_inbox', 'item_text', $role['id']);
		$role['modules'] = $this->pluckRoleTable('role_modules', 'module_text', $role['id']);

		return $role;
	}

	public function getRoleFeatureMatrix()
	{
		return $this->db
			->select('feature_name AS feature, rektor_access AS rektor, wakil_rektor_access AS `wakil-rektor`, baak_access AS baak, dekan_kaprodi_access AS `dekan-kaprodi`, keuangan_access AS keuangan, dosen_access AS dosen, mahasiswa_access AS mahasiswa', FALSE)
			->order_by('urutan', 'ASC')
			->get('role_feature_matrix')
			->result_array();
	}

	public function authenticateUser($identity, $password)
	{
		$user = $this->getUserByIdentity($identity, TRUE);

		if (!$user || $user['password'] !== $password)
		{
			return NULL;
		}

		unset($user['password']);
		return $user;
	}

	public function getUserByIdentity($identity, $include_password = FALSE)
	{
		$select = 'users.id, users.name, users.identity, users.fakultas_id, fakultas.nama_fakultas, roles.slug AS role_slug, roles.name AS role_name';

		if ($include_password)
		{
			$select .= ', users.password';
		}

		$user = $this->db
			->select($select)
			->from('users')
			->join('roles', 'roles.id = users.role_id')
			->join('fakultas', 'fakultas.id = users.fakultas_id', 'left')
			->where('LOWER(users.identity)', strtolower(trim($identity)))
			->get()
			->row_array();

		if (!$user)
		{
			return NULL;
		}

		if (!$include_password)
		{
			unset($user['password']);
		}

		return $user;
	}

	public function isAdminUser($user = NULL)
	{
		return !empty($user['role_slug']) && $user['role_slug'] === 'admin';
	}

	public function getModulePermissions($user = NULL)
	{
		$permissions = array(
			'mahasiswa' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'jurusan' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'fakultas' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'dosen' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'mata_kuliah' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'jadwal' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'krs' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'nilai' => array('view' => FALSE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE),
			'roles' => array('view' => TRUE, 'create' => FALSE, 'update' => FALSE, 'delete' => FALSE)
		);

		$role_slug = !empty($user['role_slug']) ? $user['role_slug'] : '';

		switch ($role_slug)
		{
			case 'admin':
				foreach ($permissions as $module => $actions)
				{
					foreach ($actions as $action => $value)
					{
						if ($module !== 'roles')
						{
							$permissions[$module][$action] = TRUE;
						}
					}
				}
				break;

			case 'baak':
				$permissions['mahasiswa'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['jurusan'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['fakultas'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['dosen']['view'] = TRUE;
				$permissions['mata_kuliah']['view'] = TRUE;
				$permissions['jadwal'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['krs'] = array('view' => TRUE, 'create' => FALSE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['nilai'] = array('view' => TRUE, 'create' => FALSE, 'update' => TRUE, 'delete' => FALSE);
				break;

			case 'dosen':
				$permissions['dosen']['view'] = TRUE;
				$permissions['jadwal']['view'] = TRUE;
				$permissions['krs'] = array('view' => TRUE, 'create' => FALSE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['nilai'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				break;

			case 'dekan':
				$permissions['mahasiswa']['view'] = TRUE;
				$permissions['jurusan'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['fakultas']['view'] = TRUE;
				$permissions['dosen'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['mata_kuliah'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['jadwal'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['krs']['view'] = TRUE;
				$permissions['nilai']['view'] = TRUE;
				break;

			case 'wakil-dekan':
				$permissions['mahasiswa']['view'] = TRUE;
				$permissions['jurusan'] = array('view' => TRUE, 'create' => FALSE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['fakultas']['view'] = TRUE;
				$permissions['dosen']['view'] = TRUE;
				$permissions['mata_kuliah']['view'] = TRUE;
				$permissions['jadwal'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['krs']['view'] = TRUE;
				$permissions['nilai']['view'] = TRUE;
				break;

			case 'dekan-kaprodi':
				$permissions['mahasiswa']['view'] = TRUE;
				$permissions['jurusan'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['fakultas']['view'] = TRUE;
				$permissions['dosen'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['mata_kuliah'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['jadwal'] = array('view' => TRUE, 'create' => TRUE, 'update' => TRUE, 'delete' => FALSE);
				$permissions['krs']['view'] = TRUE;
				$permissions['nilai']['view'] = TRUE;
				break;

			case 'keuangan':
				$permissions['mahasiswa']['view'] = TRUE;
				$permissions['krs']['view'] = TRUE;
				break;

			case 'rektor':
			case 'wakil-rektor':
				$permissions['mahasiswa']['view'] = TRUE;
				$permissions['jurusan']['view'] = TRUE;
				$permissions['fakultas']['view'] = TRUE;
				$permissions['dosen']['view'] = TRUE;
				$permissions['mata_kuliah']['view'] = TRUE;
				$permissions['jadwal']['view'] = TRUE;
				$permissions['krs']['view'] = TRUE;
				$permissions['nilai']['view'] = TRUE;
				break;

			case 'mahasiswa':
				break;
		}

		return $permissions;
	}

	public function canAccessModule($user, $module, $action = 'view')
	{
		$permissions = $this->getModulePermissions($user);

		return isset($permissions[$module], $permissions[$module][$action])
			? (bool) $permissions[$module][$action]
			: FALSE;
	}

	public function canAccessPortalFeature($user, $slug)
	{
		$role_slug = !empty($user['role_slug']) ? $user['role_slug'] : '';
		$slug = trim((string) $slug);

		$allowed = array(
			'mahasiswa' => array(
				'pengumuman', 'kalender-akademik', 'jadwal-minggu-ini', 'jadwal-semester',
				'pengisian-krs', 'riwayat-krs', 'kurikulum-mahasiswa', 'mengulang',
				'nilai-mahasiswa', 'aktivitas-prestasi', 'konsultasi', 'kegiatan-pendukung',
				'daftar-proposal', 'daftar-tugas-akhir', 'pengajuan-yudisium',
				'pengajuan-wisuda', 'kartu-hasil-studi', 'transkrip'
			),
			'dosen' => array('pengumuman', 'kalender-akademik'),
			'baak' => array('pengumuman', 'kalender-akademik', 'jadwal-semester'),
			'admin' => array('pengumuman', 'kalender-akademik', 'jadwal-semester'),
			'rektor' => array('pengumuman', 'kalender-akademik'),
			'wakil-rektor' => array('pengumuman', 'kalender-akademik'),
			'dekan' => array('pengumuman', 'kalender-akademik'),
			'wakil-dekan' => array('pengumuman', 'kalender-akademik'),
			'dekan-kaprodi' => array('pengumuman', 'kalender-akademik'),
			'keuangan' => array('pengumuman', 'kalender-akademik')
		);

		return isset($allowed[$role_slug]) && in_array($slug, $allowed[$role_slug], TRUE);
	}

	public function getFeatureAccessMatrix()
	{
		$roles = array(
			'admin' => 'Admin',
			'rektor' => 'Rektor',
			'wakil-rektor' => 'WR',
			'dekan' => 'Dekan',
			'wakil-dekan' => 'Wadek',
			'baak' => 'BAAK',
			'dekan-kaprodi' => 'Dekan/Kaprodi',
			'keuangan' => 'Keuangan',
			'dosen' => 'Dosen',
			'mahasiswa' => 'Mahasiswa'
		);

		$definitions = array(
			array('feature' => 'Lihat Data Mahasiswa', 'module' => 'mahasiswa', 'action' => 'view'),
			array('feature' => 'CRUD Data Mahasiswa', 'module' => 'mahasiswa', 'action' => 'update'),
			array('feature' => 'Kelola Jurusan', 'module' => 'jurusan', 'action' => 'update'),
			array('feature' => 'Kelola Fakultas', 'module' => 'fakultas', 'action' => 'update'),
			array('feature' => 'Lihat Data Dosen', 'module' => 'dosen', 'action' => 'view'),
			array('feature' => 'Kelola Data Dosen', 'module' => 'dosen', 'action' => 'update'),
			array('feature' => 'Kelola Mata Kuliah', 'module' => 'mata_kuliah', 'action' => 'update'),
			array('feature' => 'Kelola Jadwal', 'module' => 'jadwal', 'action' => 'update'),
			array('feature' => 'Validasi / Kelola KRS', 'module' => 'krs', 'action' => 'update'),
			array('feature' => 'Input / Kelola Nilai', 'module' => 'nilai', 'action' => 'update'),
			array('feature' => 'Akses Portal Mahasiswa', 'portal_slug' => 'pengisian-krs'),
			array('feature' => 'Lihat Role Kampus', 'module' => 'roles', 'action' => 'view')
		);

		$matrix = array();

		foreach ($definitions as $definition)
		{
			$row = array('feature' => $definition['feature']);

			foreach ($roles as $slug => $label)
			{
				$user = array('role_slug' => $slug);

				if (isset($definition['portal_slug']))
				{
					$allowed = $this->canAccessPortalFeature($user, $definition['portal_slug']);
				}
				else
				{
					$allowed = $this->canAccessModule($user, $definition['module'], $definition['action']);
				}

				$row[$slug] = $allowed ? 'Ya' : 'Tidak';
			}

			$matrix[] = $row;
		}

		return array('columns' => $roles, 'rows' => $matrix);
	}

	public function getRecordById($table, $id)
	{
		return $this->db
			->where('id', (int) $id)
			->get($table)
			->row_array();
	}

	public function createRecord($table, $data)
	{
		$this->db->insert($table, $data);
		return (int) $this->db->insert_id();
	}

	public function updateRecord($table, $id, $data)
	{
		return $this->db
			->where('id', (int) $id)
			->update($table, $data);
	}

	public function deleteRecord($table, $id)
	{
		return $this->db
			->where('id', (int) $id)
			->delete($table);
	}

	public function canAccessFacultyId($user, $fakultas_id)
	{
		$fakultas_id = (int) $fakultas_id;

		if ($fakultas_id <= 0 || !$this->isFacultyScopedUser($user))
		{
			return TRUE;
		}

		return !empty($user['fakultas_id']) && (int) $user['fakultas_id'] === $fakultas_id;
	}

	public function canAccessJurusanName($user, $jurusan_name)
	{
		if (!$this->isFacultyScopedUser($user))
		{
			return TRUE;
		}

		$row = $this->db
			->select('fakultas_id')
			->where('nama_jurusan', trim((string) $jurusan_name))
			->get('jurusan')
			->row_array();

		return $row ? $this->canAccessFacultyId($user, $row['fakultas_id']) : FALSE;
	}

	public function canAccessTableRecord($user, $table, $id)
	{
		if (!$this->isFacultyScopedUser($user))
		{
			return TRUE;
		}

		$id = (int) $id;

		switch ($table)
		{
			case 'fakultas':
				$row = $this->getRecordById('fakultas', $id);
				return $row ? $this->canAccessFacultyId($user, $row['id']) : FALSE;

			case 'jurusan':
				$row = $this->getRecordById('jurusan', $id);
				return $row ? $this->canAccessFacultyId($user, $row['fakultas_id']) : FALSE;

			case 'mahasiswa':
				$row = $this->getRecordById('mahasiswa', $id);
				return $row ? $this->canAccessJurusanName($user, $row['jurusan']) : FALSE;

			case 'dosen':
				$row = $this->getRecordById('dosen', $id);
				return $row ? $this->canAccessJurusanName($user, $row['prodi']) : FALSE;

			case 'mata_kuliah':
				$row = $this->getRecordById('mata_kuliah', $id);
				return $row ? $this->canAccessJurusanName($user, $row['prodi']) : FALSE;

			case 'jadwal_kuliah':
				$row = $this->getRecordById('jadwal_kuliah', $id);

				if (!$row)
				{
					return FALSE;
				}

				$mk = $this->db
					->select('prodi')
					->where('nama', $row['mata_kuliah'])
					->get('mata_kuliah')
					->row_array();

				return $mk ? $this->canAccessJurusanName($user, $mk['prodi']) : FALSE;

			case 'krs':
			case 'nilai_mahasiswa':
				$row = $this->getRecordById($table, $id);

				if (!$row)
				{
					return FALSE;
				}

				$mhs = $this->db
					->select('jurusan')
					->where('nim', $row['nim'])
					->get('mahasiswa')
					->row_array();

				return $mhs ? $this->canAccessJurusanName($user, $mhs['jurusan']) : FALSE;
		}

		return TRUE;
	}

	private function pluckRoleTable($table, $column, $role_id)
	{
		$rows = $this->db
			->select($column)
			->where('role_id', $role_id)
			->order_by('urutan', 'ASC')
			->get($table)
			->result_array();

		return array_map(function ($row) use ($column) {
			return $row[$column];
		}, $rows);
	}

	private function buildUrl($path)
	{
		return $path === '#' ? '#' : site_url($path);
	}

	private function isFacultyScopedUser($user)
	{
		$role_slug = !empty($user['role_slug']) ? $user['role_slug'] : '';
		return in_array($role_slug, array('dekan', 'wakil-dekan', 'dekan-kaprodi', 'dosen', 'mahasiswa'), TRUE)
			&& !empty($user['fakultas_id']);
	}

	private function buildOperationalNavigation($current_user = NULL)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$items = array();

		$items[] = array('key' => 'dashboard', 'label' => 'Dashboard', 'url' => site_url('dashboard'));

		if ($role_slug === 'dosen')
		{
			$items[] = array(
				'key' => 'dosen',
				'label' => 'Pengajaran',
				'url' => '#',
				'heading' => 'Area Dosen',
				'children' => array(
					array('label' => 'Profil Dosen', 'description' => 'Lihat data dosen dan peran akademik.', 'icon' => 'DS', 'url' => site_url('akademik/dosen')),
					array('label' => 'Jadwal Mengajar', 'description' => 'Pantau kelas aktif yang Anda ampu.', 'icon' => 'JD', 'url' => site_url('akademik/jadwal')),
					array('label' => 'Perwalian KRS', 'description' => 'Tinjau pengajuan mahasiswa wali.', 'icon' => 'KR', 'url' => site_url('akademik/krs')),
					array('label' => 'Input Nilai', 'description' => 'Masuk ke modul evaluasi hasil studi.', 'icon' => 'NL', 'url' => site_url('akademik/nilai'))
				)
			);

			return $items;
		}

		if ($role_slug === 'baak')
		{
			$items[] = array(
				'key' => 'mahasiswa',
				'label' => 'Layanan Akademik',
				'url' => '#',
				'heading' => 'Operasional BAAK',
				'children' => array(
					array('label' => 'Mahasiswa', 'description' => 'Pantau identitas dan status layanan mahasiswa.', 'icon' => 'MH', 'url' => site_url('mahasiswa')),
					array('label' => 'Jadwal Kuliah', 'description' => 'Atur jadwal, ruang, dan kesiapan kelas.', 'icon' => 'JW', 'url' => site_url('akademik/jadwal')),
					array('label' => 'Validasi KRS', 'description' => 'Monitor progres persetujuan KRS semester aktif.', 'icon' => 'KR', 'url' => site_url('akademik/krs')),
					array('label' => 'Arsip Nilai', 'description' => 'Akses rekap nilai dan hasil studi.', 'icon' => 'NL', 'url' => site_url('akademik/nilai'))
				)
			);

			return $items;
		}

		$items[] = array(
			'key' => 'mahasiswa',
			'label' => 'Data Akademik',
			'url' => '#',
			'heading' => 'Master Akademik',
			'children' => array(
				array('label' => 'Mahasiswa', 'description' => 'Kelola identitas dan data mahasiswa.', 'icon' => 'MH', 'url' => site_url('mahasiswa')),
				array('label' => 'Dosen', 'description' => 'Kelola tenaga pengajar dan distribusi prodi.', 'icon' => 'DS', 'url' => site_url('akademik/dosen')),
				array('label' => 'Mata Kuliah', 'description' => 'Kontrol kurikulum dan data mata kuliah.', 'icon' => 'MK', 'url' => site_url('akademik/mata_kuliah'))
			)
		);
		$items[] = array(
			'key' => 'jadwal',
			'label' => 'Operasional',
			'url' => '#',
			'heading' => 'Semester Aktif',
			'children' => array(
				array('label' => 'Jadwal', 'description' => 'Atur ruang, hari, dan jam kuliah.', 'icon' => 'JW', 'url' => site_url('akademik/jadwal')),
				array('label' => 'KRS', 'description' => 'Pantau validasi rencana studi.', 'icon' => 'KR', 'url' => site_url('akademik/krs')),
				array('label' => 'Nilai', 'description' => 'Monitor hasil studi dan publikasi nilai.', 'icon' => 'NL', 'url' => site_url('akademik/nilai'))
			)
		);

		return $items;
	}

	private function ensureAdminRole()
	{
		$role = $this->db
			->where('slug', 'admin')
			->get('roles')
			->row_array();

		if (!$role)
		{
			$this->db->insert('roles', array(
				'slug' => 'admin',
				'name' => 'Administrator',
				'level_label' => 'Super Admin',
				'focus' => 'Kontrol penuh untuk kelola seluruh data akademik, pengguna, dan konfigurasi sistem.',
				'color' => 'crimson'
			));
			$role_id = (int) $this->db->insert_id();
		}
		else
		{
			$role_id = (int) $role['id'];
		}

		$this->ensureRoleDetailSeeds($role_id);
		$this->ensureAdminUser($role_id);
	}

	private function ensureRoleDetailSeeds($role_id)
	{
		if ((int) $this->db->where('role_id', $role_id)->count_all_results('role_features') === 0)
		{
			$this->db->insert_batch('role_features', array(
				array('role_id' => $role_id, 'feature_label' => 'CRUD seluruh data master', 'urutan' => 1),
				array('role_id' => $role_id, 'feature_label' => 'Kelola pengguna dan role', 'urutan' => 2),
				array('role_id' => $role_id, 'feature_label' => 'Monitoring seluruh modul akademik', 'urutan' => 3),
				array('role_id' => $role_id, 'feature_label' => 'Kontrol konfigurasi portal', 'urutan' => 4)
			));
		}

		if ((int) $this->db->where('role_id', $role_id)->count_all_results('role_summary_stats') === 0)
		{
			$this->db->insert_batch('role_summary_stats', array(
				array('role_id' => $role_id, 'label' => 'Modul Dikelola', 'value_text' => '6', 'note' => 'Mahasiswa, dosen, mata kuliah, jadwal, KRS, dan nilai.', 'urutan' => 1),
				array('role_id' => $role_id, 'label' => 'Hak Akses', 'value_text' => 'Penuh', 'note' => 'Bisa menambah, mengubah, dan menghapus seluruh data inti.', 'urutan' => 2),
				array('role_id' => $role_id, 'label' => 'Status Sistem', 'value_text' => 'Aktif', 'note' => 'Akun admin default tersedia untuk bootstrap aplikasi.', 'urutan' => 3)
			));
		}

		if ((int) $this->db->where('role_id', $role_id)->count_all_results('role_workflows') === 0)
		{
			$this->db->insert_batch('role_workflows', array(
				array('role_id' => $role_id, 'step_text' => 'Masuk ke dashboard admin', 'owner_text' => 'Administrator', 'urutan' => 1),
				array('role_id' => $role_id, 'step_text' => 'Kelola data inti kampus pada tiap modul', 'owner_text' => 'Administrator', 'urutan' => 2),
				array('role_id' => $role_id, 'step_text' => 'Pantau perubahan dan validasi hasil input', 'owner_text' => 'Administrator', 'urutan' => 3)
			));
		}

		if ((int) $this->db->where('role_id', $role_id)->count_all_results('role_inbox') === 0)
		{
			$this->db->insert_batch('role_inbox', array(
				array('role_id' => $role_id, 'item_text' => 'Review data mahasiswa baru', 'urutan' => 1),
				array('role_id' => $role_id, 'item_text' => 'Sinkronisasi jadwal dan mata kuliah', 'urutan' => 2),
				array('role_id' => $role_id, 'item_text' => 'Audit perubahan nilai semester aktif', 'urutan' => 3)
			));
		}

		if ((int) $this->db->where('role_id', $role_id)->count_all_results('role_modules') === 0)
		{
			$this->db->insert_batch('role_modules', array(
				array('role_id' => $role_id, 'module_text' => 'Manajemen mahasiswa', 'urutan' => 1),
				array('role_id' => $role_id, 'module_text' => 'Manajemen dosen', 'urutan' => 2),
				array('role_id' => $role_id, 'module_text' => 'Master akademik', 'urutan' => 3),
				array('role_id' => $role_id, 'module_text' => 'Validasi KRS dan nilai', 'urutan' => 4)
			));
		}
	}

	private function ensureAdminUser($role_id)
	{
		$exists = $this->db
			->where('LOWER(identity)', 'admin@kampus.ac.id')
			->count_all_results('users');

		if ((int) $exists === 0)
		{
			$this->db->insert('users', array(
				'role_id' => $role_id,
				'name' => 'Super Admin',
				'identity' => 'admin@kampus.ac.id',
				'password' => 'admin123'
			));
		}
	}

	private function ensureJurusanTable()
	{
		if (!$this->db->table_exists('fakultas'))
		{
			$this->db->query("
				CREATE TABLE fakultas (
					id INT AUTO_INCREMENT PRIMARY KEY,
					kode_fakultas VARCHAR(20) NOT NULL UNIQUE,
					nama_fakultas VARCHAR(120) NOT NULL UNIQUE,
					created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
			");
		}

		if ((int) $this->db->count_all('fakultas') === 0)
		{
			$this->db->insert_batch('fakultas', array(
				array('kode_fakultas' => 'FTI', 'nama_fakultas' => 'Fakultas Teknologi Informasi'),
				array('kode_fakultas' => 'FEB', 'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis')
			));
		}

		if (!$this->db->table_exists('jurusan'))
		{
			$this->db->query("
				CREATE TABLE jurusan (
					id INT AUTO_INCREMENT PRIMARY KEY,
					fakultas_id INT DEFAULT NULL,
					kode_jurusan VARCHAR(20) NOT NULL UNIQUE,
					nama_jurusan VARCHAR(120) NOT NULL UNIQUE,
					created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					KEY idx_jurusan_fakultas_id (fakultas_id),
					CONSTRAINT fk_jurusan_fakultas FOREIGN KEY (fakultas_id) REFERENCES fakultas(id) ON DELETE SET NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
			");
		}
		elseif (!$this->db->field_exists('fakultas_id', 'jurusan'))
		{
			$this->db->query('ALTER TABLE jurusan ADD COLUMN fakultas_id INT NULL AFTER id');
		}

		if ((int) $this->db->count_all('jurusan') === 0)
		{
			$fakultas = $this->db->get('fakultas')->result_array();
			$fakultas_map = array();

			foreach ($fakultas as $row)
			{
				$fakultas_map[$row['kode_fakultas']] = (int) $row['id'];
			}

			$this->db->insert_batch('jurusan', array(
				array('fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL, 'kode_jurusan' => 'IF', 'nama_jurusan' => 'Informatika'),
				array('fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL, 'kode_jurusan' => 'SI', 'nama_jurusan' => 'Sistem Informasi'),
				array('fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL, 'kode_jurusan' => 'TK', 'nama_jurusan' => 'Teknik Komputer')
			));
		}
	}

	private function ensureCoreRoles()
	{
		$roles = array(
			'dekan' => array('name' => 'Dekan', 'level_label' => 'Pimpinan Fakultas', 'focus' => 'Kontrol mutu akademik, dosen, dan kurikulum pada level fakultas.', 'color' => 'burgundy'),
			'wakil-dekan' => array('name' => 'Wakil Dekan', 'level_label' => 'Koordinator Fakultas', 'focus' => 'Koordinasi operasional fakultas, jadwal, dan tindak lanjut akademik semester aktif.', 'color' => 'amber')
		);

		foreach ($roles as $slug => $role)
		{
			$exists = $this->db->where('slug', $slug)->count_all_results('roles');

			if ((int) $exists === 0)
			{
				$this->db->insert('roles', array(
					'slug' => $slug,
					'name' => $role['name'],
					'level_label' => $role['level_label'],
					'focus' => $role['focus'],
					'color' => $role['color']
				));
			}
		}
	}

	private function ensureAcademicRelations()
	{
		if (!$this->db->table_exists('mahasiswa'))
		{
			$this->db->query("
				CREATE TABLE mahasiswa (
					id INT AUTO_INCREMENT PRIMARY KEY,
					jurusan_id INT DEFAULT NULL,
					nim VARCHAR(20) NOT NULL UNIQUE,
					nama VARCHAR(120) NOT NULL,
					jurusan VARCHAR(120) NOT NULL,
					created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
			");
		}
		elseif (!$this->db->field_exists('jurusan_id', 'mahasiswa'))
		{
			$this->db->query('ALTER TABLE mahasiswa ADD COLUMN jurusan_id INT NULL AFTER id');
		}

		if (!$this->db->field_exists('mahasiswa_id', 'krs'))
		{
			$this->db->query('ALTER TABLE krs ADD COLUMN mahasiswa_id INT NULL AFTER id');
		}

		if (!$this->db->field_exists('mahasiswa_id', 'nilai_mahasiswa'))
		{
			$this->db->query('ALTER TABLE nilai_mahasiswa ADD COLUMN mahasiswa_id INT NULL AFTER id');
		}

		$this->syncAcademicRelations();
	}

	private function syncAcademicRelations()
	{
		$this->db->query("
			UPDATE mahasiswa m
			JOIN jurusan j ON j.nama_jurusan = m.jurusan
			SET m.jurusan_id = j.id
			WHERE (m.jurusan_id IS NULL OR m.jurusan_id = 0)
		");

		$this->db->query("
			UPDATE krs k
			JOIN mahasiswa m ON m.nim = k.nim
			SET k.mahasiswa_id = m.id, k.nama = m.nama
			WHERE k.mahasiswa_id IS NULL OR k.mahasiswa_id = 0
		");

		$this->db->query("
			UPDATE nilai_mahasiswa n
			JOIN mahasiswa m ON m.nim = n.nim
			SET n.mahasiswa_id = m.id, n.nama = m.nama
			WHERE n.mahasiswa_id IS NULL OR n.mahasiswa_id = 0
		");
	}

	private function ensureUserFacultyColumn()
	{
		if (!$this->db->field_exists('fakultas_id', 'users'))
		{
			$this->db->query('ALTER TABLE users ADD COLUMN fakultas_id INT NULL AFTER role_id');
		}
	}

	private function ensureDefaultRoleUsers()
	{
		$fakultas_rows = $this->db->select('id, kode_fakultas')->get('fakultas')->result_array();
		$fakultas_map = array();

		foreach ($fakultas_rows as $fakultas)
		{
			$fakultas_map[$fakultas['kode_fakultas']] = (int) $fakultas['id'];
		}

		$defaults = array(
			'rektor' => array('name' => 'Prof. Dr. Ahmad Nugraha', 'identity' => 'rektor@kampus.ac.id', 'password' => 'rektor123', 'fakultas_id' => NULL),
			'wakil-rektor' => array('name' => 'Dr. Sinta Maharani', 'identity' => 'warek@kampus.ac.id', 'password' => 'warek123', 'fakultas_id' => NULL),
			'dekan' => array('name' => 'Prof. Lestari Wulandari', 'identity' => 'dekan@kampus.ac.id', 'password' => 'dekan123', 'fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL),
			'wakil-dekan' => array('name' => 'Dr. Bayu Adinata', 'identity' => 'wadek@kampus.ac.id', 'password' => 'wadek123', 'fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL),
			'baak' => array('name' => 'Admin BAAK', 'identity' => 'baak@kampus.ac.id', 'password' => 'baak123', 'fakultas_id' => NULL),
			'dekan-kaprodi' => array('name' => 'Agus Saputra, S.Kom., M.T', 'identity' => 'kaprodi@kampus.ac.id', 'password' => 'kaprodi123', 'fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL),
			'keuangan' => array('name' => 'Staf Keuangan', 'identity' => 'keuangan@kampus.ac.id', 'password' => 'keuangan123', 'fakultas_id' => NULL),
			'dosen' => array('name' => 'Dr. Rina Pratama, M.Kom', 'identity' => 'dosen@kampus.ac.id', 'password' => 'dosen123', 'fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL),
			'mahasiswa' => array('name' => 'Andi Prasetyo', 'identity' => 'mahasiswa@kampus.ac.id', 'password' => 'mahasiswa123', 'fakultas_id' => isset($fakultas_map['FTI']) ? $fakultas_map['FTI'] : NULL)
		);

		$roles = $this->db
			->select('id, slug')
			->where_in('slug', array_keys($defaults))
			->get('roles')
			->result_array();

		foreach ($roles as $role)
		{
			$slug = $role['slug'];
			$account = $defaults[$slug];
			$exists = $this->db
				->where('LOWER(identity)', strtolower($account['identity']))
				->count_all_results('users');

			if ((int) $exists === 0)
			{
				$this->db->insert('users', array(
					'role_id' => (int) $role['id'],
					'fakultas_id' => $account['fakultas_id'],
					'name' => $account['name'],
					'identity' => $account['identity'],
					'password' => $account['password']
				));
			}
			else
			{
				$this->db
					->where('LOWER(identity)', strtolower($account['identity']))
					->update('users', array('fakultas_id' => $account['fakultas_id']));
			}
		}
	}

	private function ensureUserRelations()
	{
		if (!$this->db->field_exists('user_id', 'dosen'))
		{
			$this->db->query('ALTER TABLE dosen ADD COLUMN user_id INT NULL AFTER id');
		}

		if (!$this->db->field_exists('user_id', 'student_profile'))
		{
			$this->db->query('ALTER TABLE student_profile ADD COLUMN user_id INT NULL AFTER id');
		}

		$this->syncDefaultUserRelations();
		$this->ensureRelationIndexes();
		$this->ensureRelationForeignKeys();
	}

	private function syncDefaultUserRelations()
	{
		$this->db->query("
			UPDATE dosen d
			JOIN users u ON u.identity = 'dosen@kampus.ac.id'
			SET d.user_id = u.id
			WHERE d.nidn = '0112038901' AND (d.user_id IS NULL OR d.user_id = 0)
		");

		$this->db->query("
			UPDATE dosen d
			JOIN users u ON u.identity = 'kaprodi@kampus.ac.id'
			SET d.user_id = u.id
			WHERE d.nidn = '0215079102' AND (d.user_id IS NULL OR d.user_id = 0)
		");

		$this->db->query("
			UPDATE student_profile sp
			JOIN users u ON u.identity = 'mahasiswa@kampus.ac.id'
			SET sp.user_id = u.id
			WHERE sp.nim = '2210110001' AND (sp.user_id IS NULL OR sp.user_id = 0)
		");
	}

	private function ensureRelationIndexes()
	{
		if (!$this->hasIndex('dosen', 'idx_dosen_user_id'))
		{
			$this->db->query('ALTER TABLE dosen ADD INDEX idx_dosen_user_id (user_id)');
		}

		if (!$this->hasIndex('student_profile', 'idx_student_profile_user_id'))
		{
			$this->db->query('ALTER TABLE student_profile ADD INDEX idx_student_profile_user_id (user_id)');
		}
	}

	private function ensureRelationForeignKeys()
	{
		if (!$this->hasForeignKey('dosen', 'fk_dosen_user'))
		{
			$this->db->query('ALTER TABLE dosen ADD CONSTRAINT fk_dosen_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
		}

		if (!$this->hasForeignKey('student_profile', 'fk_student_profile_user'))
		{
			$this->db->query('ALTER TABLE student_profile ADD CONSTRAINT fk_student_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL');
		}
	}

	private function hasIndex($table, $index_name)
	{
		$row = $this->db
			->query("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", array($index_name))
			->row_array();

		return !empty($row);
	}

	private function hasForeignKey($table, $constraint_name)
	{
		$row = $this->db
			->query(
				'SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_TYPE = ? AND CONSTRAINT_NAME = ?',
				array($table, 'FOREIGN KEY', $constraint_name)
			)
			->row_array();

		return !empty($row);
	}

	private function applyFacultyProgramScope($query, $current_user, $field)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$fakultas_id = !empty($current_user['fakultas_id']) ? (int) $current_user['fakultas_id'] : 0;

		if (!in_array($role_slug, array('dekan', 'wakil-dekan', 'dekan-kaprodi', 'dosen', 'mahasiswa'), TRUE) || $fakultas_id <= 0)
		{
			return;
		}

		$query->where($field . ' IN (SELECT nama_jurusan FROM jurusan WHERE fakultas_id = ' . $fakultas_id . ')', NULL, FALSE);
	}

	private function applyFacultyRecordScope($query, $current_user, $mahasiswa_id_field, $nim_field)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$fakultas_id = !empty($current_user['fakultas_id']) ? (int) $current_user['fakultas_id'] : 0;

		if (!in_array($role_slug, array('dekan', 'wakil-dekan', 'dekan-kaprodi', 'dosen'), TRUE) || $fakultas_id <= 0)
		{
			return;
		}

		$query->group_start()
			->where($mahasiswa_id_field . ' IN (SELECT mahasiswa.id FROM mahasiswa WHERE mahasiswa.jurusan_id IN (SELECT id FROM jurusan WHERE fakultas_id = ' . $fakultas_id . '))', NULL, FALSE)
			->or_where("$nim_field IN (SELECT nim FROM mahasiswa WHERE jurusan_id IN (SELECT id FROM jurusan WHERE fakultas_id = " . $fakultas_id . "))", NULL, FALSE)
			->group_end();
	}

	private function applyStudentRecordScope($query, $current_user, $mahasiswa_id_field, $nim_field)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$user_id = !empty($current_user['id']) ? (int) $current_user['id'] : 0;

		if ($role_slug !== 'mahasiswa' || $user_id <= 0)
		{
			return;
		}

		$profile = $this->db
			->select('nim')
			->where('user_id', $user_id)
			->get('student_profile')
			->row_array();

		if (!empty($profile['nim']))
		{
			$mahasiswa = $this->db
				->select('id')
				->where('nim', $profile['nim'])
				->get('mahasiswa')
				->row_array();

			$query->group_start()
				->where($nim_field, $profile['nim']);

			if (!empty($mahasiswa['id']))
			{
				$query->or_where($mahasiswa_id_field, (int) $mahasiswa['id']);
			}

			$query->group_end();
		}
	}
}
