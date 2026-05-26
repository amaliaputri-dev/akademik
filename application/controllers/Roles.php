<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAuth();
		$this->load->model('Mahasiswa_model');
		$this->requireAdminAccess();
	}

	public function index()
	{
		$current_user = $this->getCurrentUser();

		$data['page_title'] = 'Role Kampus';
		$data['active_menu'] = 'roles';
		$data['navigation'] = $this->Siakad_model->getNavigation($current_user);
		$data['portal_navigation'] = $this->Siakad_model->getPortalNavigation($current_user);
		$data['current_user'] = $current_user;
		$data['role_ui'] = $this->Siakad_model->getRoleUiContext($current_user);
		$data['roles'] = $this->Siakad_model->getCampusRoles();
		$data['feature_matrix'] = $this->Siakad_model->getFeatureAccessMatrix();
		$data['total_mahasiswa'] = $this->Mahasiswa_model->getTotalMahasiswa();
		$data['total_roles'] = count($data['roles']);

		$this->load->view('roles_view', $data);
	}

	public function detail($slug = '')
	{
		$current_user = $this->getCurrentUser();
		$role = $this->Siakad_model->getRoleBySlug($slug);

		if (!$role)
		{
			show_404();
		}

		$data['page_title'] = $role['name'];
		$data['active_menu'] = 'roles';
		$data['navigation'] = $this->Siakad_model->getNavigation($current_user);
		$data['portal_navigation'] = $this->Siakad_model->getPortalNavigation($current_user);
		$data['current_user'] = $current_user;
		$data['role_ui'] = $this->Siakad_model->getRoleUiContext($current_user);
		$data['roles'] = $this->Siakad_model->getCampusRoles();
		$data['role'] = $role;

		$this->load->view('role_detail_view', $data);
	}

	private function requireAdminAccess()
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->isAdmin($current_user))
		{
			show_error('Akses khusus admin.', 403, 'Forbidden');
		}
	}
}
