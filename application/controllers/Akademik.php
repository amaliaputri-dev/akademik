<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akademik extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAuth();
		$this->load->model('Mahasiswa_model');
	}

	public function dosen()
	{
		$this->requireModuleAccess('dosen', 'view');
		$this->renderModule('dosen');
	}

	public function mata_kuliah()
	{
		$this->requireModuleAccess('mata_kuliah', 'view');
		$this->renderModule('mata_kuliah');
	}

	public function jadwal()
	{
		$this->requireModuleAccess('jadwal', 'view');
		$this->renderModule('jadwal');
	}

	public function krs()
	{
		$this->requireModuleAccess('krs', 'view');
		$this->renderModule('krs');
	}

	public function nilai()
	{
		$this->requireModuleAccess('nilai', 'view');
		$this->renderModule('nilai');
	}

	public function edit($module_key, $id)
	{
		$this->requireModuleAccess($module_key, 'update');
		$this->requireScopedRecordAccess($this->getModuleConfig($module_key)['table'], (int) $id);
		$this->renderModule($module_key, (int) $id);
	}

	public function create($module_key)
	{
		$this->requireModuleAccess($module_key, 'create');

		$config = $this->getModuleConfig($module_key);
		$data = $this->collectModuleInput($config);
		$this->requireScopedPayloadAccess($config['table'], $data);
		$this->Siakad_model->createRecord($config['table'], $data);
		$this->session->set_flashdata('success_message', 'Data ' . $config['label'] . ' berhasil ditambahkan.');

		redirect($config['route']);
	}

	public function update($module_key, $id)
	{
		$this->requireModuleAccess($module_key, 'update');

		$config = $this->getModuleConfig($module_key);
		$this->requireScopedRecordAccess($config['table'], (int) $id);
		$data = $this->collectModuleInput($config);
		$this->requireScopedPayloadAccess($config['table'], $data);
		$this->Siakad_model->updateRecord($config['table'], (int) $id, $data);
		$this->session->set_flashdata('success_message', 'Data ' . $config['label'] . ' berhasil diperbarui.');

		redirect($config['route']);
	}

	public function delete($module_key, $id)
	{
		$this->requireModuleAccess($module_key, 'delete');

		$config = $this->getModuleConfig($module_key);
		$this->requireScopedRecordAccess($config['table'], (int) $id);
		$this->Siakad_model->deleteRecord($config['table'], (int) $id);
		$this->session->set_flashdata('success_message', 'Data ' . $config['label'] . ' berhasil dihapus.');

		redirect($config['route']);
	}

	private function renderModule($module_key, $selected_id = NULL)
	{
		$config = $this->getModuleConfig($module_key);
		$current_user = $this->getCurrentUser();
		$rows = $config['fetcher']($current_user);
		$selected = $selected_id ? $this->Siakad_model->getRecordById($config['table'], $selected_id) : NULL;

		$data = array(
			'page_title' => $config['title'],
			'active_menu' => $config['active_menu'],
			'navigation' => $this->Siakad_model->getNavigation($current_user),
			'portal_navigation' => $this->Siakad_model->getPortalNavigation($current_user),
			'current_user' => $current_user,
			'role_ui' => $this->Siakad_model->getRoleUiContext($current_user),
			'module_title' => $config['title'],
			'module_key' => $module_key,
			'module_label' => $config['label'],
			'module_description' => $config['description'],
			'module_stats' => $this->buildModuleStats($module_key, $rows),
			'table_headers' => array_values(array_column(isset($config['table_fields']) ? $config['table_fields'] : $config['fields'], 'label')),
			'table_rows' => $rows,
			'table_keys' => array_keys(isset($config['table_fields']) ? $config['table_fields'] : $config['fields']),
			'calendar_items' => $this->Siakad_model->getAcademicCalendar(),
			'module_permissions' => $this->Siakad_model->getModulePermissions($current_user),
			'can_create' => $this->Siakad_model->canAccessModule($current_user, $module_key, 'create'),
			'can_update' => $this->Siakad_model->canAccessModule($current_user, $module_key, 'update'),
			'can_delete' => $this->Siakad_model->canAccessModule($current_user, $module_key, 'delete'),
			'selected_record' => $selected,
			'module_fields' => $config['fields'],
			'field_options' => $this->getFieldOptions($module_key, $current_user),
			'form_action' => $selected
				? site_url('akademik/update/' . $module_key . '/' . $selected['id'])
				: site_url('akademik/create/' . $module_key),
			'cancel_url' => site_url($config['route']),
			'success_message' => $this->session->flashdata('success_message')
		);

		$this->load->view('module_view', $data);
	}

	private function getModuleConfig($module_key)
	{
		$modules = array(
			'dosen' => array(
				'label' => 'dosen',
				'title' => 'Dosen & Tenaga Pengajar',
				'active_menu' => 'dosen',
				'route' => 'akademik/dosen',
				'table' => 'dosen',
				'description' => 'Kelola data dosen, distribusi prodi, dan peran pengajaran dalam sistem akademik.',
				'fetcher' => function ($current_user) {
					return $this->Siakad_model->getDosen($current_user);
				},
				'fields' => array(
					'nidn' => array('label' => 'NIDN', 'type' => 'text'),
					'nama' => array('label' => 'Nama Dosen', 'type' => 'text'),
					'prodi' => array('label' => 'Program Studi', 'type' => 'text'),
					'status_jabatan' => array('label' => 'Peran', 'type' => 'text')
				)
			),
			'mata_kuliah' => array(
				'label' => 'mata kuliah',
				'title' => 'Master Mata Kuliah',
				'active_menu' => 'mata_kuliah',
				'route' => 'akademik/mata_kuliah',
				'table' => 'mata_kuliah',
				'description' => 'Daftar mata kuliah inti dan umum yang siap dipakai untuk penjadwalan serta KRS.',
				'fetcher' => function ($current_user) {
					return $this->Siakad_model->getMataKuliah($current_user);
				},
				'fields' => array(
					'kode' => array('label' => 'Kode', 'type' => 'text'),
					'nama' => array('label' => 'Mata Kuliah', 'type' => 'text'),
					'sks' => array('label' => 'SKS', 'type' => 'number', 'min' => '0'),
					'semester' => array('label' => 'Semester', 'type' => 'number', 'min' => '1'),
					'prodi' => array('label' => 'Prodi', 'type' => 'text')
				)
			),
			'jadwal' => array(
				'label' => 'jadwal',
				'title' => 'Jadwal Perkuliahan',
				'active_menu' => 'jadwal',
				'route' => 'akademik/jadwal',
				'table' => 'jadwal_kuliah',
				'description' => 'Rancang distribusi hari, jam, ruang, dan pengampu agar operasional kuliah lebih tertata.',
				'fetcher' => function ($current_user) {
					return $this->Siakad_model->getJadwalKuliah($current_user);
				},
				'fields' => array(
					'hari' => array('label' => 'Hari', 'type' => 'text'),
					'waktu' => array('label' => 'Waktu', 'type' => 'text'),
					'mata_kuliah' => array('label' => 'Mata Kuliah', 'type' => 'text'),
					'dosen' => array('label' => 'Dosen', 'type' => 'text'),
					'ruang' => array('label' => 'Ruang', 'type' => 'text')
				)
			),
			'krs' => array(
				'label' => 'KRS',
				'title' => 'KRS & Perwalian',
				'active_menu' => 'krs',
				'route' => 'akademik/krs',
				'table' => 'krs',
				'description' => 'Pantau progres pengisian KRS, total SKS, dan status validasi dosen wali setiap mahasiswa.',
				'fetcher' => function ($current_user) {
					return $this->Siakad_model->getKrsAktif($current_user);
				},
				'fields' => array(
					'mahasiswa_id' => array('label' => 'Mahasiswa', 'type' => 'select'),
					'semester' => array('label' => 'Semester', 'type' => 'number', 'min' => '1'),
					'sks_diambil' => array('label' => 'SKS Diambil', 'type' => 'number', 'min' => '0'),
					'status_krs' => array('label' => 'Status', 'type' => 'text')
				),
				'table_fields' => array(
					'nim' => array('label' => 'NIM'),
					'nama' => array('label' => 'Mahasiswa'),
					'semester' => array('label' => 'Semester'),
					'sks_diambil' => array('label' => 'SKS Diambil'),
					'status_krs' => array('label' => 'Status')
				)
			),
			'nilai' => array(
				'label' => 'nilai',
				'title' => 'Nilai & Hasil Studi',
				'active_menu' => 'nilai',
				'route' => 'akademik/nilai',
				'table' => 'nilai_mahasiswa',
				'description' => 'Ringkasan capaian akademik mahasiswa untuk mendukung publikasi KHS dan evaluasi belajar.',
				'fetcher' => function ($current_user) {
					return $this->Siakad_model->getNilaiMahasiswa($current_user);
				},
				'fields' => array(
					'mahasiswa_id' => array('label' => 'Mahasiswa', 'type' => 'select'),
					'ips' => array('label' => 'IPS', 'type' => 'number', 'step' => '0.01', 'min' => '0'),
					'ipk' => array('label' => 'IPK', 'type' => 'number', 'step' => '0.01', 'min' => '0'),
					'status_nilai' => array('label' => 'Catatan', 'type' => 'text')
				),
				'table_fields' => array(
					'nim' => array('label' => 'NIM'),
					'nama' => array('label' => 'Mahasiswa'),
					'ips' => array('label' => 'IPS'),
					'ipk' => array('label' => 'IPK'),
					'status_nilai' => array('label' => 'Catatan')
				)
			)
		);

		if (!isset($modules[$module_key]))
		{
			show_404();
		}

		return $modules[$module_key];
	}

	private function getFieldOptions($module_key, $current_user)
	{
		if ($module_key === 'dosen' || $module_key === 'mata_kuliah')
		{
			$jurusan = $this->Mahasiswa_model->getAllJurusan($current_user);
			$prodi = array();

			foreach ($jurusan as $item)
			{
				$prodi[$item['nama_jurusan']] = $item['kode_jurusan'] . ' - ' . $item['nama_jurusan'];
			}

			return array('prodi' => $prodi);
		}

		if ($module_key === 'jadwal')
		{
			$mata_kuliah = $this->Siakad_model->getMataKuliah($current_user);
			$dosen = $this->Siakad_model->getDosen($current_user);
			$options = array('mata_kuliah' => array(), 'dosen' => array());

			foreach ($mata_kuliah as $item)
			{
				$options['mata_kuliah'][$item['nama']] = $item['kode'] . ' - ' . $item['nama'];
			}

			foreach ($dosen as $item)
			{
				$options['dosen'][$item['nama']] = $item['nidn'] . ' - ' . $item['nama'];
			}

			return $options;
		}

		if ($module_key === 'krs' || $module_key === 'nilai')
		{
			$mahasiswa = $this->Mahasiswa_model->getAllMahasiswa($current_user);
			$options = array('mahasiswa_id' => array());

			foreach ($mahasiswa as $item)
			{
				$options['mahasiswa_id'][(int) $item['id']] = $item['nim'] . ' - ' . $item['nama'];
			}

			return $options;
		}

		return array();
	}

	private function collectModuleInput($config)
	{
		$data = array();

		foreach ($config['fields'] as $field => $meta)
		{
			$data[$field] = trim((string) $this->input->post($field, TRUE));
		}

		if (isset($data['mahasiswa_id']) && (int) $data['mahasiswa_id'] > 0)
		{
			$mahasiswa = $this->Mahasiswa_model->getMahasiswaById((int) $data['mahasiswa_id']);

			if ($mahasiswa)
			{
				$data['mahasiswa_id'] = (int) $mahasiswa['id'];
				$data['nim'] = $mahasiswa['nim'];
				$data['nama'] = $mahasiswa['nama'];
			}
		}

		return $data;
	}

	private function buildModuleStats($module_key, $rows)
	{
		switch ($module_key)
		{
			case 'dosen':
				$prodi = array_unique(array_column($rows, 'prodi'));
				$koordinator = array_filter($rows, function ($item) {
					return stripos($item['status_jabatan'], 'kaprodi') !== FALSE || stripos($item['status_jabatan'], 'koordinator') !== FALSE;
				});

				return array(
					array('label' => 'Total Dosen', 'value' => count($rows)),
					array('label' => 'Prodi Aktif', 'value' => count($prodi)),
					array('label' => 'Koordinator', 'value' => count($koordinator))
				);

			case 'mata_kuliah':
				$semester = array_unique(array_column($rows, 'semester'));
				$mk_umum = array_filter($rows, function ($item) {
					return strtolower($item['prodi']) === 'umum';
				});

				return array(
					array('label' => 'Total MK', 'value' => count($rows)),
					array('label' => 'Semester Tersedia', 'value' => count($semester)),
					array('label' => 'MK Umum', 'value' => count($mk_umum))
				);

			case 'jadwal':
				$ruang = array_unique(array_column($rows, 'ruang'));
				$lab = array_filter($rows, function ($item) {
					return stripos($item['ruang'], 'lab') !== FALSE;
				});

				return array(
					array('label' => 'Kelas Minggu Ini', 'value' => count($rows)),
					array('label' => 'Ruang Aktif', 'value' => count($ruang)),
					array('label' => 'Lab Terpakai', 'value' => count($lab))
				);

			case 'krs':
				$approved = array_filter($rows, function ($item) {
					return strtolower($item['status_krs']) === 'disetujui';
				});

				return array(
					array('label' => 'KRS Aktif', 'value' => count($rows)),
					array('label' => 'Sudah Disetujui', 'value' => count($approved)),
					array('label' => 'Perlu Tindak Lanjut', 'value' => count($rows) - count($approved))
				);

			case 'nilai':
				$ips = array_column($rows, 'ips');

				return array(
					array('label' => 'Data KHS', 'value' => count($rows)),
					array('label' => 'IPS Tertinggi', 'value' => !empty($ips) ? max($ips) : '0.00'),
					array('label' => 'Status Tercatat', 'value' => count($rows))
				);
		}

		return array();
	}

	private function requireModuleAccess($module, $action)
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessModule($current_user, $module, $action))
		{
			show_error('Akses ditolak. Role Anda tidak memiliki izin ' . $action . ' untuk modul ' . $module . '.', 403);
		}
	}

	private function requireScopedRecordAccess($table, $id)
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessTableRecord($current_user, $table, $id))
		{
			show_error('Akses lintas fakultas ditolak.', 403);
		}
	}

	private function requireScopedPayloadAccess($table, $data)
	{
		$current_user = $this->getCurrentUser();

		if ($table === 'dosen' || $table === 'mata_kuliah')
		{
			if (!$this->Siakad_model->canAccessJurusanName($current_user, $data['prodi']))
			{
				show_error('Program studi di luar cakupan fakultas Anda.', 403);
			}
		}

		if ($table === 'jadwal_kuliah')
		{
			$row = $this->db->select('prodi')->where('nama', $data['mata_kuliah'])->get('mata_kuliah')->row_array();

			if (!$row || !$this->Siakad_model->canAccessJurusanName($current_user, $row['prodi']))
			{
				show_error('Jadwal untuk mata kuliah di luar cakupan fakultas Anda.', 403);
			}
		}
	}
}
