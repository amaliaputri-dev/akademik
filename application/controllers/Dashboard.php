<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->requireAuth();

		$this->load->model('Mahasiswa_model');
		$this->load->model('Dashboard_model');
	}

	public function index()
	{
		$current_user = $this->getCurrentUser();

		$data['page_title'] = 'Dashboard SIAKAD';
		$data['active_menu'] = 'dashboard';
		$data['navigation'] = $this->Siakad_model->getNavigation($current_user);
		$data['portal_navigation'] = $this->Siakad_model->getPortalNavigation($current_user);
		$data['current_user'] = $current_user;
		$data['role_ui'] = $this->Siakad_model->getRoleUiContext($current_user);
		$data['notification_count'] = $this->Dashboard_model->getNotificationCount();
		$data['total_mahasiswa'] = $this->Mahasiswa_model->getTotalMahasiswa($current_user);
		$data['total_jurusan'] = $this->Mahasiswa_model->getTotalJurusan($current_user);
		$data['mahasiswa_terbaru'] = $this->Mahasiswa_model->getMahasiswaTerbaru(5, $current_user);
		$data['quick_menus'] = $this->Dashboard_model->getQuickMenusByRole($current_user);
		$data['announcements'] = $this->Dashboard_model->getAnnouncements($current_user);
		$data['calendar_items'] = $this->Siakad_model->getAcademicCalendar();
		$data['highlights'] = $this->Siakad_model->getSystemHighlights();
		$data['student_snapshot'] = $this->Dashboard_model->getStudentSnapshot($current_user);
		$data['role_kpis'] = $this->Dashboard_model->getRoleKpis($current_user);
		$data['today_schedule'] = $this->Dashboard_model->getTodaySchedule($current_user);
		$data['billing_summary'] = $this->Dashboard_model->getBillingSummary($current_user);
		$data['mini_calendar'] = $this->Dashboard_model->getAcademicMiniCalendar();
		$data['dashboard_context'] = $this->Dashboard_model->getRoleDashboardContext($current_user);

		$this->load->view('dashboard_view', $data);
	}
}
