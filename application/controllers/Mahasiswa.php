<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAuth();

		$this->load->model('Mahasiswa_model');
	}

	public function index()
	{
		$this->requireModuleAccess('mahasiswa', 'view');
		$this->renderIndex();
	}

	public function edit($id)
	{
		$this->requireModuleAccess('mahasiswa', 'update');
		$this->requireScopedRecordAccess('mahasiswa', (int) $id);
		$this->renderIndex((int) $id);
	}

	public function create()
	{
		$this->requireModuleAccess('mahasiswa', 'create');

		$data = $this->collectMahasiswaInput();
		$this->requireJurusanScope($data['jurusan']);
		$this->Mahasiswa_model->createMahasiswa($data);
		$this->session->set_flashdata('success_message', 'Data mahasiswa berhasil ditambahkan.');

		redirect('mahasiswa');
	}

	public function create_jurusan()
	{
		$this->requireModuleAccess('jurusan', 'create');
		$data = $this->collectJurusanInput();
		$this->requireFakultasScope($data['fakultas_id']);
		$this->Mahasiswa_model->createJurusan($data);
		$this->session->set_flashdata('success_message', 'Data jurusan berhasil ditambahkan.');

		redirect('mahasiswa');
	}

	public function create_fakultas()
	{
		$this->requireModuleAccess('fakultas', 'create');
		$data = $this->collectFakultasInput();
		$this->requireFakultasScope(!empty($this->getCurrentUser()['fakultas_id']) ? $this->getCurrentUser()['fakultas_id'] : 0);
		$this->Mahasiswa_model->createFakultas($data);
		$this->session->set_flashdata('success_message', 'Data fakultas berhasil ditambahkan.');

		redirect('mahasiswa');
	}

	public function update($id)
	{
		$this->requireModuleAccess('mahasiswa', 'update');
		$this->requireScopedRecordAccess('mahasiswa', (int) $id);

		$data = $this->collectMahasiswaInput();
		$this->requireJurusanScope($data['jurusan']);
		$this->Mahasiswa_model->updateMahasiswa((int) $id, $data);
		$this->session->set_flashdata('success_message', 'Data mahasiswa berhasil diperbarui.');

		redirect('mahasiswa');
	}

	public function delete($id)
	{
		$this->requireModuleAccess('mahasiswa', 'delete');
		$this->requireScopedRecordAccess('mahasiswa', (int) $id);
		$this->Mahasiswa_model->deleteMahasiswa((int) $id);
		$this->session->set_flashdata('success_message', 'Data mahasiswa berhasil dihapus.');

		redirect('mahasiswa');
	}

	public function edit_jurusan($id)
	{
		$this->requireModuleAccess('jurusan', 'update');
		$this->requireScopedRecordAccess('jurusan', (int) $id);
		$this->renderIndex(NULL, (int) $id);
	}

	public function update_jurusan($id)
	{
		$this->requireModuleAccess('jurusan', 'update');
		$this->requireScopedRecordAccess('jurusan', (int) $id);
		$data = $this->collectJurusanInput();
		$this->requireFakultasScope($data['fakultas_id']);
		$this->Mahasiswa_model->updateJurusan((int) $id, $data);
		$this->session->set_flashdata('success_message', 'Data jurusan berhasil diperbarui.');

		redirect('mahasiswa');
	}

	public function delete_jurusan($id)
	{
		$this->requireModuleAccess('jurusan', 'delete');
		$this->requireScopedRecordAccess('jurusan', (int) $id);
		$this->Mahasiswa_model->deleteJurusan((int) $id);
		$this->session->set_flashdata('success_message', 'Data jurusan berhasil dihapus.');

		redirect('mahasiswa');
	}

	public function edit_fakultas($id)
	{
		$this->requireModuleAccess('fakultas', 'update');
		$this->requireScopedRecordAccess('fakultas', (int) $id);
		$this->renderIndex(NULL, NULL, (int) $id);
	}

	public function update_fakultas($id)
	{
		$this->requireModuleAccess('fakultas', 'update');
		$this->requireScopedRecordAccess('fakultas', (int) $id);
		$this->Mahasiswa_model->updateFakultas((int) $id, $this->collectFakultasInput());
		$this->session->set_flashdata('success_message', 'Data fakultas berhasil diperbarui.');

		redirect('mahasiswa');
	}

	public function delete_fakultas($id)
	{
		$this->requireModuleAccess('fakultas', 'delete');
		$this->requireScopedRecordAccess('fakultas', (int) $id);
		$this->Mahasiswa_model->deleteFakultas((int) $id);
		$this->session->set_flashdata('success_message', 'Data fakultas berhasil dihapus.');

		redirect('mahasiswa');
	}

	private function renderIndex($selected_id = NULL, $selected_jurusan_id = NULL, $selected_fakultas_id = NULL)
	{
		$current_user = $this->getCurrentUser();
		$selected = $selected_id ? $this->Mahasiswa_model->getMahasiswaById($selected_id) : NULL;
		$selected_jurusan = $selected_jurusan_id ? $this->Mahasiswa_model->getJurusanById($selected_jurusan_id) : NULL;
		$selected_fakultas = $selected_fakultas_id ? $this->Mahasiswa_model->getFakultasById($selected_fakultas_id) : NULL;

		$data['page_title'] = 'Data Mahasiswa';
		$data['active_menu'] = 'mahasiswa';
		$data['navigation'] = $this->Siakad_model->getNavigation($current_user);
		$data['portal_navigation'] = $this->Siakad_model->getPortalNavigation($current_user);
		$data['current_user'] = $current_user;
		$data['role_ui'] = $this->Siakad_model->getRoleUiContext($current_user);
		$data['mahasiswa'] = $this->Mahasiswa_model->getAllMahasiswa($current_user);
		$data['jurusan_list'] = $this->Mahasiswa_model->getAllJurusan($current_user);
		$data['fakultas_list'] = $this->Mahasiswa_model->getAllFakultas($current_user);
		$data['total_mahasiswa'] = $this->Mahasiswa_model->getTotalMahasiswa($current_user);
		$data['total_jurusan'] = $this->Mahasiswa_model->getTotalJurusan($current_user);
		$data['total_fakultas'] = $this->Mahasiswa_model->getTotalFakultas($current_user);
		$data['module_permissions'] = $this->Siakad_model->getModulePermissions($current_user);
		$data['can_create'] = $this->Siakad_model->canAccessModule($current_user, 'mahasiswa', 'create');
		$data['can_update'] = $this->Siakad_model->canAccessModule($current_user, 'mahasiswa', 'update');
		$data['can_delete'] = $this->Siakad_model->canAccessModule($current_user, 'mahasiswa', 'delete');
		$data['can_create_jurusan'] = $this->Siakad_model->canAccessModule($current_user, 'jurusan', 'create');
		$data['can_update_jurusan'] = $this->Siakad_model->canAccessModule($current_user, 'jurusan', 'update');
		$data['can_delete_jurusan'] = $this->Siakad_model->canAccessModule($current_user, 'jurusan', 'delete');
		$data['can_create_fakultas'] = $this->Siakad_model->canAccessModule($current_user, 'fakultas', 'create');
		$data['can_update_fakultas'] = $this->Siakad_model->canAccessModule($current_user, 'fakultas', 'update');
		$data['can_delete_fakultas'] = $this->Siakad_model->canAccessModule($current_user, 'fakultas', 'delete');
		$data['selected_mahasiswa'] = $selected;
		$data['selected_jurusan'] = $selected_jurusan;
		$data['selected_fakultas'] = $selected_fakultas;
		$data['success_message'] = $this->session->flashdata('success_message');
		$data['form_action'] = $selected
			? site_url('mahasiswa/update/' . $selected['id'])
			: site_url('mahasiswa/create');
		$data['jurusan_form_action'] = $selected_jurusan
			? site_url('mahasiswa/update_jurusan/' . $selected_jurusan['id'])
			: site_url('mahasiswa/create_jurusan');
		$data['fakultas_form_action'] = $selected_fakultas
			? site_url('mahasiswa/update_fakultas/' . $selected_fakultas['id'])
			: site_url('mahasiswa/create_fakultas');
		$data['cancel_url'] = site_url('mahasiswa');

		$this->load->view('mahasiswa_view', $data);
	}

	private function collectMahasiswaInput()
	{
		return array(
			'nim' => trim((string) $this->input->post('nim', TRUE)),
			'nama' => trim((string) $this->input->post('nama', TRUE)),
			'jurusan' => trim((string) $this->input->post('jurusan', TRUE))
		);
	}

	private function collectJurusanInput()
	{
		return array(
			'kode_jurusan' => trim((string) $this->input->post('kode_jurusan', TRUE)),
			'nama_jurusan' => trim((string) $this->input->post('nama_jurusan', TRUE)),
			'fakultas_id' => (int) $this->input->post('fakultas_id', TRUE)
		);
	}

	private function collectFakultasInput()
	{
		return array(
			'kode_fakultas' => trim((string) $this->input->post('kode_fakultas', TRUE)),
			'nama_fakultas' => trim((string) $this->input->post('nama_fakultas', TRUE))
		);
	}

	private function requireModuleAccess($module, $action)
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessModule($current_user, $module, $action))
		{
			show_error('Akses ditolak. Role Anda tidak memiliki izin ' . $action . ' untuk modul ini.', 403);
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

	private function requireJurusanScope($jurusan_name)
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessJurusanName($current_user, $jurusan_name))
		{
			show_error('Jurusan di luar cakupan fakultas Anda.', 403);
		}
	}

	private function requireFakultasScope($fakultas_id)
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessFacultyId($current_user, $fakultas_id))
		{
			show_error('Fakultas di luar cakupan akun Anda.', 403);
		}
	}
}
