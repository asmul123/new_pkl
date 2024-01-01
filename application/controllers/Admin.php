<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email') or $this->session->userdata('role_id') != 1) {
			redirect(base_url('auth'));
		}
		$this->load->model('Admin_model');
	}

	public function index()
	{
		$biodata = $this->Admin_model->getBioAdmin($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = "Admin";
		$header['title'] = "Beranda Admin - Jurnal PKL Online SMKN 1 GARUT";
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('admin/beranda');
		$this->load->view('templates/footer');
	}

	public function kegiatan()
	{
		$this->load->model('Kegiatan_model');
		$biodata = $this->Admin_model->getBioAdmin($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = "Admin";
		$header['title'] = "Daftar Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$data['kegiatan'] = $this->Kegiatan_model->getEvents();
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('admin/kegiatan', $data);
		$this->load->view('templates/footer');
	}

	public function kegiatanadd()
	{
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Admin_model->getBioAdmin($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = "Admin";
		$header['title'] = "Tambah Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$data['program'] = $this->Program_model->getMajors();
		$data['tapel'] = $this->Tapel_model->getTapels();
		$this->form_validation->set_rules('event_name', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('start_date', 'Tanggal Mulai Kegiatan', 'required|trim');
		$this->form_validation->set_rules('finish_date', 'Tanggal Akhir Kegiatan', 'required|trim');
		$this->form_validation->set_rules('major_id', 'Program Keahlian', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('admin/add_kegiatan', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addkegiatan();
		}
	}

	private function _addkegiatan()
	{
		$event_name = $this->input->post('event_name');
		$start_date = $this->input->post('start_date');
		$finish_date = $this->input->post('finish_date');
		$major_id = $this->input->post('major_id');
		$tapel_id = $this->input->post('tapel_id');
		$email = $this->session->userdata('email');
		$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
		$config['upload_path']          = './public/assets/documents/';
		$config['allowed_types']        = 'pdf';
		$config['overwrite'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('document')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			$document = "";
		} else {
			$document = $this->upload->data('file_name');
		}
		if ($user_id) {
			$data = [
				'event_name' => $event_name,
				'start_date' => $start_date,
				'finish_date' => $finish_date,
				'major_id' => $major_id,
				'tapel_id' => $tapel_id,
				'user_id' => $user_id,
				'document' => $document,
			];
			$this->db->insert('events', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url('admin/kegiatan'));
		} else {
			redirect(base_url());
		}
	}

	public function kegiatanedit($eventID)
	{
		$this->load->model('Kegiatan_model');
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Admin_model->getBioAdmin($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = "Admin";
		$header['title'] = "Edit Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$data['kegiatan'] = $this->Kegiatan_model->getThisEvent($eventID);
		$data['program'] = $this->Program_model->getMajors();
		$data['tapel'] = $this->Tapel_model->getTapels();
		$data['eventID'] = $eventID;
		$this->form_validation->set_rules('event_name', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('start_date', 'Tanggal Mulai Kegiatan', 'required|trim');
		$this->form_validation->set_rules('finish_date', 'Tanggal Akhir Kegiatan', 'required|trim');
		$this->form_validation->set_rules('major_id', 'Program Keahlian', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('admin/edit_kegiatan', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editkegiatan($eventID);
		}
	}

	private function _editkegiatan($eventID)
	{
		$event_name = $this->input->post('event_name');
		$start_date = $this->input->post('start_date');
		$finish_date = $this->input->post('finish_date');
		$major_id = $this->input->post('major_id');
		$tapel_id = $this->input->post('tapel_id');
		$email = $this->session->userdata('email');
		$olddocument = $this->Kegiatan_model->getThisEvent($eventID)->document;
		$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
		$config['upload_path']          = './public/assets/documents/';
		$config['allowed_types']        = 'pdf';
		$config['overwrite'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('document')) {
			$document = $olddocument;
		} else {
			$document = $this->upload->data('file_name');
			unlink('./public/assets/documents/' . $olddocument);
		}
		if ($user_id) {
			$data = [
				'event_name' => $event_name,
				'start_date' => $start_date,
				'finish_date' => $finish_date,
				'major_id' => $major_id,
				'tapel_id' => $tapel_id,
				'user_id' => $user_id,
				'document' => $document,
			];
			$this->db->set($data);
			$this->db->where('event_id', $eventID);
			$this->db->update('events');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url('admin/kegiatan'));
		} else {
			redirect(base_url());
		}
	}
}
