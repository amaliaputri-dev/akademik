<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $current_user = NULL;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'cookie'));
		$this->load->model('Siakad_model');
	}

	protected function getCurrentUser()
	{
		if ($this->current_user !== NULL)
		{
			return $this->current_user;
		}

		$token = get_cookie($this->getAuthCookieName(), TRUE);

		if (!$token)
		{
			return NULL;
		}

		$parts = explode('|', $token);

		if (count($parts) !== 2)
		{
			$this->clearAuthUser();
			return NULL;
		}

		list($identity, $signature) = $parts;
		$expected = hash_hmac('sha256', $identity, $this->getAuthSecret());

		if (!hash_equals($expected, $signature))
		{
			$this->clearAuthUser();
			return NULL;
		}

		$user = $this->Siakad_model->getUserByIdentity($identity);

		if (!$user)
		{
			$this->clearAuthUser();
			return NULL;
		}

		$this->current_user = $user;
		return $this->current_user;
	}

	protected function requireAuth()
	{
		if (!$this->getCurrentUser())
		{
			redirect('login');
		}
	}

	protected function setAuthUser($user)
	{
		$identity = $user['identity'];
		$signature = hash_hmac('sha256', $identity, $this->getAuthSecret());

		set_cookie(array(
			'name' => $this->getAuthCookieName(),
			'value' => $identity . '|' . $signature,
			'expire' => 7200,
			'path' => config_item('cookie_path'),
			'secure' => config_item('cookie_secure'),
			'httponly' => TRUE,
			'samesite' => 'Lax'
		));

		$this->current_user = $user;
	}

	protected function clearAuthUser()
	{
		delete_cookie($this->getAuthCookieName(), config_item('cookie_domain'), config_item('cookie_path'));
		$this->current_user = NULL;
	}

	private function getAuthCookieName()
	{
		return 'akademik_auth';
	}

	private function getAuthSecret()
	{
		$key = (string) config_item('encryption_key');

		if ($key !== '')
		{
			return $key;
		}

		return sha1(APPPATH . config_item('base_url') . 'akademik-auth');
	}
}
