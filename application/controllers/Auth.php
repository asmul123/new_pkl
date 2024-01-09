<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->userdata('email')) {
			if ($this->session->userdata('role_id') == 1) {
				redirect(base_url('admin'));
			} else
			if ($this->session->userdata('role_id') == 2) {
				redirect(base_url('kaprog'));
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
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Kata Sandi', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login');
		} else {
			$this->_login();
		}
	}

	public function setting()
	{
		$this->load->model('Akun_model');
		if ($this->session->userdata('role_id') == 1) {
			$this->load->model('Admin_model');
			$biodata = $this->Admin_model->getBioAdmin($this->session->userdata('email'));
		} else
		if ($this->session->userdata('role_id') == 2) {
			$this->load->model('Kaprog_model');
			$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		} else
		if ($this->session->userdata('role_id') == 3) {
			$this->load->model('Mentor_model');
			$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		} else
		if ($this->session->userdata('role_id') == 4) {
			$this->load->model('Instruktur_model');
			$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		} else
		if ($this->session->userdata('role_id') == 5) {
			$this->load->model('Peserta_model');
			$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		} else {
			redirect(base_url());
		}
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('old_password', 'Kata Sandi Lama', 'required');
		$this->form_validation->set_rules('password', 'Kata Sandi Baru', 'required');
		$this->form_validation->set_rules('confirm_password', 'Konfirmasi Kata Sandi', 'required');
		if ($this->form_validation->run() == false) {
			$header['photo'] = $biodata->photo;
			$header['name'] = $biodata->name;
			$header['role'] = $biodata->role;
			$header['title'] = "Setting Akun - Jurnal PKL Online SMKN 1 GARUT";
			$header['menuactive'] = "dashboard";
			$data['akun'] = $this->Akun_model->getAkun($this->db->get_where('users', ['email' => $this->session->userdata('email')])->row()->user_id);
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('auth/setting', $data);
			$this->load->view('templates/footer');
		} else {
			$email = $this->input->post('email');
			$old_password = $this->input->post('old_password');
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			$user_id = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row()->user_id;
			$cek = $this->db->get_where('users', ['email' => $email])->num_rows();
			if ($cek >= 1 and $email != $this->session->userdata('email')) {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email telah digunakan, silahkan gunakan email yang lain</div>');
				redirect(base_url('auth/setting'));
			} else {
				$users = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
				if ($password == $confirm_password) {
					if (password_verify($old_password, $users['password'])) {
						$data = [
							'email' => $email,
							'password' => password_hash($password, PASSWORD_DEFAULT)
						];
						$this->db->set($data);
						$this->db->where('user_id', $user_id);
						$update = $this->db->update('users');
						if ($update and $email != $this->session->userdata('email')) {
							$data2 = [
								'email' => $email
							];
							$this->session->unset_userdata('email');
							$this->session->set_userdata($data2);
						}
						$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Akun Berhasil diganti</div>');
						redirect(base_url('auth/setting'));
					} else {
						$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Kata Sandi Lama tidak Sesuai</div>');
						redirect(base_url('auth/setting'));
					}
				} else {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Konfirmasi Kata Sandi Lama tidak Sesuai</div>');
					redirect(base_url('auth/setting'));
				}
			}
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
