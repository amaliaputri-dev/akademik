<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		if ($this->getCurrentUser())
		{
			redirect('dashboard');
		}

		$data['page_title'] = 'Login SIAKAD';
		$data['roles'] = $this->Siakad_model->getCampusRoles();
		$data['error_message'] = $this->input->get('error', TRUE) ? 'Login gagal. Periksa kembali username atau password Anda.' : '';
		$data['success_message'] = $this->input->get('logout', TRUE) ? 'Sesi login sudah diakhiri.' : '';
		$data['last_identity'] = $this->input->get('identity', TRUE);

		$this->load->view('login_view', $data);
	}

	public function attempt()
	{
		$identity = trim((string) $this->input->post('identity', TRUE));
		$password = trim((string) $this->input->post('password', TRUE));

		$user = $this->Siakad_model->authenticateUser($identity, $password);

		if (!$user)
		{
			redirect('login?error=1&identity=' . rawurlencode($identity));
		}

		$this->setAuthUser($user);
		redirect('dashboard');
	}

	public function logout()
	{
		$this->clearAuthUser();
		redirect('login?logout=1');
	}
}
