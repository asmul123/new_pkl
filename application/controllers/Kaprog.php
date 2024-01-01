<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('kaprog/beranda');
		$this->load->view('templates/footer');
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
		$data['dudika'] = $this->Dudika_model->getDudikas();
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('admin/dudika', $data);
		$this->load->view('templates/footer');
	}

	public function dudikaadd()
	{
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
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
			$this->_adddudika();
		}
	}

	private function _adddudika()
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

	public function dudikaedit($eventID)
	{
		$this->load->model('Kegiatan_model');
		$this->load->model('Program_model');
		$this->load->model('Tapel_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
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
			$this->_editdudika($eventID);
		}
	}

	private function _editdudika($eventID)
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

	public function kaprog()
	{
		$this->load->model('Kaprog_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Kaprog - Jurnal PKL Online SMKN 1 GARUT";
		$data['kaprog'] = $this->Kaprog_model->getKaprogs();
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('admin/kaprog', $data);
		$this->load->view('templates/footer');
	}

	public function kaprogadd()
	{
		$this->load->model('Program_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Kaprog - Jurnal PKL Online SMKN 1 GARUT";
		$data['program'] = $this->Program_model->getMajors();
		$this->form_validation->set_rules('name', 'Nama Kaprog', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Kaprog', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Kaprog', 'required|trim');
		$this->form_validation->set_rules('major_id', 'Program Keahlian', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('admin/add_kaprog', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addkaprog();
		}
	}

	private function _addkaprog()
	{
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$major_id = $this->input->post('major_id');
		$major_id = $this->input->post('major_id');
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
				'role_id' => 2
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
			$this->db->insert('kaprogs', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('admin/kaprog'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('admin/kaprogadd'));
		}
	}

	public function kaprogedit($kaprogID)
	{
		$this->load->model('Kaprog_model');
		$this->load->model('Program_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Kaprog - Jurnal PKL Online SMKN 1 GARUT";
		$data['kaprog'] = $this->Kaprog_model->getThisKaprog($kaprogID);
		$data['program'] = $this->Program_model->getMajors();
		$data['kaprogID'] = $kaprogID;
		$this->form_validation->set_rules('name', 'Nama Kaprog', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Kaprog', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Kaprog', 'required|trim');
		$this->form_validation->set_rules('major_id', 'Program Keahlian', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('admin/edit_kaprog', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editkaprog($kaprogID);
		}
	}

	private function _editkaprog($kaprogID)
	{
		$this->load->model('Kaprog_model');
		$kaprog = $this->Kaprog_model->getThisKaprog($kaprogID);
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$major_id = $this->input->post('major_id');
		$major_id = $this->input->post('major_id');
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$user_id = $kaprog->user_id;
		$oldphoto = $kaprog->photo;
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
				'major_id' => $major_id,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->set($data);
			$this->db->where('kaprog_id', $kaprogID);
			$this->db->update('kaprogs');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('admin/kaprog'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('admin/kaprogadd'));
		}
	}
}
