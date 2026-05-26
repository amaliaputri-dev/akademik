<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAuth();
		$this->load->model('Dashboard_model');
	}

	public function feature($slug = '')
	{
		$current_user = $this->getCurrentUser();

		if (!$this->Siakad_model->canAccessPortalFeature($current_user, $slug))
		{
			show_error('Akses ditolak. Role Anda tidak memiliki izin untuk fitur portal ini.', 403);
		}

		$feature = $this->Dashboard_model->getPortalFeature($slug);

		if (!$feature)
		{
			show_404();
		}

		$data['page_title'] = $feature['title'];
		$data['active_menu'] = $this->resolveActiveMenu($feature['category']);
		$data['navigation'] = $this->Siakad_model->getNavigation($current_user);
		$data['portal_navigation'] = $this->Siakad_model->getPortalNavigation($current_user);
		$data['current_user'] = $current_user;
		$data['role_ui'] = $this->Siakad_model->getRoleUiContext($current_user);
		$data['notification_count'] = $this->Dashboard_model->getNotificationCount();
		$data['feature'] = $feature;

		$this->load->view('portal_feature_view', $data);
	}

	private function resolveActiveMenu($category)
	{
		$map = array(
			'Jadwal' => 'jadwal_portal',
			'Akademik' => 'akademik_portal',
			'Tingkat Akhir' => 'tingkat_akhir_portal',
			'Hasil Studi' => 'hasil_studi_portal'
		);

		return isset($map[$category]) ? $map[$category] : 'dashboard';
	}
}
