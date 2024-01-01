<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('email')) {
			if ($this->session->userdata('role_id') == 1) {
				redirect(base_url('admin'));
			} else
			if ($this->session->userdata('role_id') == 2) {
				redirect(base_url('kakom'));
			} else
			if ($this->session->userdata('role_id') == 3) {
				redirect(base_url('pembimbing'));
			} else
			if ($this->session->userdata('role_id') == 4) {
				redirect(base_url('instruktur'));
			} else
			if ($this->session->userdata('role_id') == 5) {
				redirect(base_url('peserta'));
			}
		}
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Kata Sandi', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$users = $this->db->get_where('users', ['email' => $email])->row_array();
		// var_dump($users);
		// die;

		if ($users) {
			if (password_verify($password, $users['password'])) {
				// var_dump($users);
				// die;
				$data = [
					'email' => $users['email'],
					'role_id' => $users['role_id']
				];
				$this->session->set_userdata($data);
				$data = [
					'last_login' => date('Y-m-d H:i:sa')
				];
				$this->db->set($data);
				$this->db->where('user_id', $users['user_id']);
				$this->db->update('users');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Kata Sandi anda salah</div>');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Mohon Maaf, Email anda tidak teregistrasi</div>');
			redirect(base_url());
		}
	}
}
