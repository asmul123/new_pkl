<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Kaprog extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email') or $this->session->userdata('role_id') != 2) {
			redirect(base_url('auth'));
		}
		$this->load->model('Kaprog_model');
	}

	public function index()
	{
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Beranda Kaprog - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dashboard";
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/beranda');
		$this->load->view('templates/footer');
		// $this->load->view('datatable');
	}

	public function kegiatan()
	{
		$this->load->model('Kegiatan_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$data['kegiatan'] = $this->Kegiatan_model->getEventMajors($biodata->major_id);
		$header['menuactive'] = "kegiatan";
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/kegiatan', $data);
		$this->load->view('templates/footer');
	}

	public function kegiatanadd()
	{
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "kegiatan";
		$data['program'] = $this->Program_model->getMajors();
		$data['tapel'] = $this->Tapel_model->getTapels();
		$this->form_validation->set_rules('event_name', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('start_date', 'Tanggal Mulai Kegiatan', 'required|trim');
		$this->form_validation->set_rules('finish_date', 'Tanggal Akhir Kegiatan', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/add_kegiatan', $data);
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
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;
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
			redirect(base_url('kaprog/kegiatan'));
		} else {
			redirect(base_url());
		}
	}

	public function kegiatanedit($eventID)
	{
		$this->load->model('Kegiatan_model');
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Kegiatan - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "kegiatan";
		$data['kegiatan'] = $this->Kegiatan_model->getThisEvent($eventID);
		$data['program'] = $this->Program_model->getMajors();
		$data['tapel'] = $this->Tapel_model->getTapels();
		$data['eventID'] = $eventID;
		$this->form_validation->set_rules('event_name', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('start_date', 'Tanggal Mulai Kegiatan', 'required|trim');
		$this->form_validation->set_rules('finish_date', 'Tanggal Akhir Kegiatan', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/edit_kegiatan', $data);
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
				'tapel_id' => $tapel_id,
				'user_id' => $user_id,
				'document' => $document,
			];
			$this->db->set($data);
			$this->db->where('event_id', $eventID);
			$this->db->update('events');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url('kaprog/kegiatan'));
		} else {
			redirect(base_url());
		}
	}

	public function dudika()
	{
		$this->load->model('Dudika_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Dudika - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dudika";
		$data['dudika'] = $this->Dudika_model->getDudikaMajors($biodata->major_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/dudika', $data);
		$this->load->view('templates/footer');
	}

	public function dudikaadd()
	{
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Dudika - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dudika";
		$data['tapel'] = $this->Tapel_model->getTapels();
		$this->form_validation->set_rules('name', 'Nama Dudika', 'required|trim');
		$this->form_validation->set_rules('address', 'Alamat Dudika', 'required|trim');
		$this->form_validation->set_rules('head', 'Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('head_nip', 'NIP/NIK Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('head_position', 'Jabatan Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/add_dudika', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_adddudika();
		}
	}

	private function _adddudika()
	{
		$name = $this->input->post('name');
		$address = $this->input->post('address');
		$head = $this->input->post('head');
		$head_nip = $this->input->post('head_nip');
		$head_position = $this->input->post('head_position');
		$tapel_id = $this->input->post('tapel_id');
		$email = $this->session->userdata('email');
		$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;
		$config['upload_path']          = './public/assets/img/logos/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('logo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			$logo = "no_image.png";
		} else {
			$logo = $this->upload->data('file_name');
		}
		if ($user_id) {
			$data = [
				'name' => $name,
				'address' => $address,
				'head' => $head,
				'head_nip' => $head_nip,
				'head_position' => $head_position,
				'logo' => $logo,
				'major_id' => $major_id,
				'tapel_id' => $tapel_id,
				'user_id' => $user_id
			];
			$this->db->insert('dudikas', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url('kaprog/dudika'));
		} else {
			redirect(base_url());
		}
	}

	public function dudikaedit($dudikaID)
	{
		$this->load->model('Dudika_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Dudika - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dudika";
		$data['dudika'] = $this->Dudika_model->getThisDudika($dudikaID);
		$data['tapel'] = $this->Tapel_model->getTapels();
		$data['dudikaID'] = $dudikaID;
		$this->form_validation->set_rules('name', 'Nama Dudika', 'required|trim');
		$this->form_validation->set_rules('address', 'Alamat Dudika', 'required|trim');
		$this->form_validation->set_rules('head', 'Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('head_nip', 'NIP/NIK Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('head_position', 'Jabatan Pimpinan Dudika', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/edit_dudika', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editdudika($dudikaID);
		}
	}

	private function _editdudika($dudikaID)
	{
		$name = $this->input->post('name');
		$address = $this->input->post('address');
		$head = $this->input->post('head');
		$head_nip = $this->input->post('head_nip');
		$head_position = $this->input->post('head_position');
		$tapel_id = $this->input->post('tapel_id');
		$email = $this->session->userdata('email');
		$oldlogo = $this->Dudika_model->getThisDudika($dudikaID)->logo;
		$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
		$config['upload_path']          = './public/assets/img/logos/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('logo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			$logo = $oldlogo;
		} else {
			$logo = $this->upload->data('file_name');
			if ($oldlogo != "no_image.png") {
				unlink('./public/assets/img/logos/' . $oldlogo);
			}
		}
		if ($user_id) {
			$data = [
				'name' => $name,
				'address' => $address,
				'head' => $head,
				'head_nip' => $head_nip,
				'head_position' => $head_position,
				'logo' => $logo,
				'tapel_id' => $tapel_id,
				'user_id' => $user_id
			];
			$this->db->set($data);
			$this->db->where('dudika_id', $dudikaID);
			$this->db->update('dudikas');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url('kaprog/dudika'));
		} else {
			redirect(base_url());
		}
	}

	public function mentor()
	{
		$this->load->model('Mentor_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Pembimbing - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "mentor";
		$data['mentor'] = $this->Mentor_model->getMentorMajors($biodata->major_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/mentor', $data);
		$this->load->view('templates/footer');
	}

	public function mentoradd()
	{
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Pembimbing - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "mentor";
		$this->form_validation->set_rules('name', 'Nama Pembimbing', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Pembimbing', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Pembimbing', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/add_mentor');
			$this->load->view('templates/footer');
		} else {
			$this->_addmentor();
		}
	}

	private function _addmentor()
	{
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$cek_email = $this->db->get_where('users', ['email' => $email])->num_rows();
		$config['upload_path']          = './public/assets/img/avatars/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = false;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			$photo = "no_image.png";
		} else {
			$photo = $this->upload->data('file_name');
		}
		if ($cek_email == 0) {
			$data = [
				'email' => $email,
				'password' => $password,
				'role_id' => 3
			];
			$this->db->insert('users', $data);
			$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
			$data = [
				'name' => $name,
				'nid' => $nid,
				'position' => $position,
				'major_id' => $major_id,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->insert('mentors', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/mentor'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/mentoradd'));
		}
	}

	public function mentoredit($mentorID)
	{
		$this->load->model('Mentor_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Pembimbing - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "mentor";
		$data['mentor'] = $this->Mentor_model->getThismentor($mentorID);
		$data['mentorID'] = $mentorID;
		$this->form_validation->set_rules('name', 'Nama Pembimbing', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Pembimbing', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Pembimbing', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/edit_mentor', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editmentor($mentorID);
		}
	}

	private function _editmentor($mentorID)
	{
		$this->load->model('mentor_model');
		$mentor = $this->Mentor_model->getThisMentor($mentorID);
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$user_id = $mentor->user_id;
		$oldphoto = $mentor->photo;
		$cek_email = $this->db->get_where('users', ['email' => $email, 'user_id !=' => $user_id])->num_rows();
		$config['upload_path']          = './public/assets/img/avatars/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = false;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			$photo = $oldphoto;
		} else {
			$photo = $this->upload->data('file_name');
			if ($oldphoto != "no_image.png") {
				unlink('./public/assets/img/avatars/' . $oldphoto);
			}
		}
		if ($cek_email == 0) {
			if ($password != "") {
				$data = [
					'email' => $email,
					'password' => $password
				];
			} else {
				$data = [
					'email' => $email
				];
			}
			$this->db->set($data);
			$this->db->where('user_id', $user_id);
			$this->db->update('users');
			$data = [
				'name' => $name,
				'nid' => $nid,
				'position' => $position,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->set($data);
			$this->db->where('mentor_id', $mentorID);
			$this->db->update('mentors');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/mentor'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/mentoradd'));
		}
	}

	public function peserta()
	{
		$this->load->model('Peserta_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "peserta";
		$data['peserta'] = $this->Peserta_model->getPesertaMajors($biodata->major_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/peserta', $data);
		$this->load->view('templates/footer');
	}

	public function pesertaadd()
	{
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "peserta";
		$data['tapel'] = $this->Tapel_model->getTapels();
		$this->form_validation->set_rules('name', 'Nama Peserta', 'required|trim');
		$this->form_validation->set_rules('nisn', 'NISN Peserta', 'required|trim');
		$this->form_validation->set_rules('class', 'Kelas Peserta', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran Peserta', 'required|trim');
		$this->form_validation->set_rules('email', 'Email Peserta', 'required|trim');
		$this->form_validation->set_rules('password', 'Kata Sandi Peserta', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/add_peserta', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addpeserta();
		}
	}

	private function _addpeserta()
	{
		$name = $this->input->post('name');
		$nisn = $this->input->post('nisn');
		$class = $this->input->post('class');
		$tapel_id = $this->input->post('tapel_id');
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$cek_email = $this->db->get_where('users', ['email' => $email])->num_rows();
		$config['upload_path']          = './public/assets/img/avatars/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = false;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			$photo = "no_image.png";
		} else {
			$photo = $this->upload->data('file_name');
		}
		if ($cek_email == 0) {
			$data = [
				'email' => $email,
				'password' => $password,
				'role_id' => 5
			];
			$this->db->insert('users', $data);
			$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
			$data = [
				'name' => $name,
				'nisn' => $nisn,
				'class' => $class,
				'tapel_id' => $tapel_id,
				'major_id' => $major_id,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->insert('partisipants', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/peserta'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/pesertaadd'));
		}
	}

	public function pesertaimport()
	{
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Import Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "peserta";
		$data['tapel'] = $this->Tapel_model->getTapels();
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran Peserta', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/import_peserta', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_importpeserta();
		}
	}

	private function _importpeserta()
	{
		$tapel_id = $this->input->post('tapel_id');
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;

		$file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		if (isset($_FILES['data_peserta']['name']) && in_array($_FILES['data_peserta']['type'], $file_mimes)) {
			$fileName = time() . $_FILES['data_peserta']['name'];
			$config['upload_path'] = './public/assets/documents/'; //buat folder dengan nama assets di root folder
			$config['file_name'] = str_replace(" ", "", $fileName);
			$config['allowed_types'] = 'xls|xlsx|csv';
			$config['max_size'] = 10000;
			$arr_file = explode('.', $_FILES['data_peserta']['name']);
			$extension = end($arr_file);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('data_peserta')) {
				$inputFileName = './public/assets/documents/' . $config['file_name'];
				if ('csv' == $extension) {
					$reader = new Csv();
				} else if ('xlsx' == $extension) {
					$reader = new Xlsx();
				} else if ('xls' == $extension) {
					$reader = new Xls();
				}

				try {
					$spreadsheet = $reader->load($inputFileName);
					$sheetData = $spreadsheet->getActiveSheet()->toArray();
					$sheetRows = $spreadsheet->getActiveSheet()->getHighestRow();
					$gagal = 0;
					$berhasil = 0;
					if (intval($sheetRows) >= 2) {
						for ($i = 1; $i < count($sheetData); $i++) {
							$cekNISN = $this->db->get_where('partisipants', ['nisn' => $sheetData[$i][2]])->num_rows();
							$cekEmail = $this->db->get_where('users', ['email' => $sheetData[$i][13]])->num_rows();
							if ($cekNISN == 0) {
								if ($cekEmail == 0) {
									$data2 = array(
										'email' => $sheetData[$i][13],
										'password' => password_hash($sheetData[$i][14], PASSWORD_DEFAULT),
										'role_id' => '5'
									);
									$this->db->insert('users', $data2);
									$user_id = $this->db->get_where('users', ['email' => $sheetData[$i][13]])->row()->user_id;
									$data = array(
										'name' => $sheetData[$i][0],
										'nis' => $sheetData[$i][1],
										'nisn' => $sheetData[$i][2],
										'birth_place' => $sheetData[$i][3],
										'birth_date' => $sheetData[$i][4],
										'gender' => $sheetData[$i][5],
										'class' => $sheetData[$i][6],
										'major_id' => $major_id,
										'religion' => $sheetData[$i][7],
										'address' => $sheetData[$i][8],
										'contact' => $sheetData[$i][9],
										'parent' => $sheetData[$i][10],
										'parent_address' => $sheetData[$i][11],
										'parent_contact' => $sheetData[$i][12],
										'user_id' => $user_id,
										'photo' => 'no_image.png',
										'tapel_id' => $tapel_id
									);
									$this->db->insert('partisipants', $data);
									$berhasil++;
								} else {
									$gagal++;
								}
							} else {
								$gagal++;
							}
						}
					} else {
						$this->session->set_flashdata('pesan', '<div class="alert alert-warning left-icon-alert" role="alert">
																	<strong>Perhatian!</strong> File excel anda kosong.
																</div>');
						redirect(base_url('kaprog/pesertaimport'));
					}
				} catch (Exception $e) {
					var_dump($e);
				}
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-warning left-icon-alert" role="alert">
                                                            <strong>Perhatian!</strong> <br>
                                                            <ul>															
                                                                <li>' . $this->upload->display_errors() . '</li>															
                                                            </ul>						
                                                        </div>');
				redirect(base_url('kaprog/pesertaimport'));
			}
			unlink($inputFileName);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success left-icon-alert" role="alert">
														<strong>Status Import!</strong> Berhasil : ' . $berhasil . ' data, Gagal : ' . $gagal . ' data
													</div>');
			redirect('kaprog/peserta');
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger left-icon-alert" role="alert">
														<strong>Perhatian!</strong> Import Gagal.
													</div>');
			redirect('kaprog/pesertaimport');
		}
	}

	public function pesertaedit($partisipantID)
	{
		$this->load->model('Tapel_model');
		$this->load->model('Peserta_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Pembimbing - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "peserta";
		$data['tapel'] = $this->Tapel_model->getTapels();
		$data['peserta'] = $this->Peserta_model->getThisPeserta($partisipantID);
		$data['partisipantID'] = $partisipantID;
		$this->form_validation->set_rules('name', 'Nama Peserta', 'required|trim');
		$this->form_validation->set_rules('nisn', 'NISN Peserta', 'required|trim');
		$this->form_validation->set_rules('class', 'Kelas Peserta', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran Peserta', 'required|trim');
		$this->form_validation->set_rules('email', 'Email Peserta', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/edit_peserta', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editpeserta($partisipantID);
		}
	}

	private function _editpeserta($partisipantID)
	{
		$this->load->model('Peserta_model');
		$peserta = $this->Peserta_model->getThisPeserta($partisipantID);
		$name = $this->input->post('name');
		$nisn = $this->input->post('nisn');
		$class = $this->input->post('class');
		$tapel_id = $this->input->post('tapel_id');
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$oldphoto = $peserta->photo;
		$cek_email = $this->db->get_where('users', ['email' => $email, 'user_id !=' => $peserta->user_id])->num_rows();
		$config['upload_path']          = './public/assets/img/avatars/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = false;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			$photo = $oldphoto;
		} else {
			$photo = $this->upload->data('file_name');
			if ($oldphoto != "no_image.png") {
				unlink('./public/assets/img/avatars/' . $oldphoto);
			}
		}
		if ($cek_email == 0) {
			if ($password == "") {
				$data = [
					'email' => $email
				];
			} else {
				$data = [
					'email' => $email,
					'password' => $password
				];
			}
			$this->db->set($data);
			$this->db->where('user_id', $peserta->user_id);
			$this->db->update('users');
			$data = [
				'name' => $name,
				'nisn' => $nisn,
				'class' => $class,
				'tapel_id' => $tapel_id,
				'photo' => $photo
			];
			$this->db->set($data);
			$this->db->where('partisipant_id', $partisipantID);
			$this->db->update('partisipants');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/peserta'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Mengubah data! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/pesertaedit'));
		}
	}
	public function ploating()
	{
		$this->load->model('Ploating_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "ploating";
		$data['ploating'] = $this->Ploating_model->getPloatingPeserta($biodata->major_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/ploating', $data);
		$this->load->view('templates/footer');
	}

	public function ploatingadd()
	{
		$this->load->model('Dudika_model');
		$this->load->model('Mentor_model');
		$this->load->model('Peserta_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Penempatan Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "ploating";
		$data['dudika'] = $this->Dudika_model->getDudikaMajors($biodata->major_id);
		$data['mentor'] = $this->Mentor_model->getMentorMajors($biodata->major_id);
		$data['peserta'] = $this->Peserta_model->getPesertaMajors($biodata->major_id);
		$this->form_validation->set_rules('name', 'Nama Peserta', 'required|trim');
		$this->form_validation->set_rules('nisn', 'NISN Peserta', 'required|trim');
		$this->form_validation->set_rules('class', 'Kelas Peserta', 'required|trim');
		$this->form_validation->set_rules('tapel_id', 'Tahun Pelajaran Peserta', 'required|trim');
		$this->form_validation->set_rules('email', 'Email Peserta', 'required|trim');
		$this->form_validation->set_rules('password', 'Kata Sandi Peserta', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/add_ploating', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addploating();
		}
	}

	private function _addploating()
	{
		$name = $this->input->post('name');
		$nisn = $this->input->post('nisn');
		$class = $this->input->post('class');
		$tapel_id = $this->input->post('tapel_id');
		$major_id = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'))->major_id;
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$cek_email = $this->db->get_where('users', ['email' => $email])->num_rows();
		$config['upload_path']          = './public/assets/img/avatars/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['overwrite'] = false;
		$config['remove_spaces'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">'
				. $this->upload->display_errors() .
				'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			$photo = "no_image.png";
		} else {
			$photo = $this->upload->data('file_name');
		}
		if ($cek_email == 0) {
			$data = [
				'email' => $email,
				'password' => $password,
				'role_id' => 5
			];
			$this->db->insert('users', $data);
			$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
			$data = [
				'name' => $name,
				'nisn' => $nisn,
				'class' => $class,
				'tapel_id' => $tapel_id,
				'major_id' => $major_id,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->insert('partisipants', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/peserta'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('kaprog/pesertaadd'));
		}
	}
}
