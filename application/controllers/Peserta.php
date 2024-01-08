<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email') or $this->session->userdata('role_id') != 5) {
			redirect(base_url('auth'));
		}
		$this->load->model('Peserta_model');
	}

	public function index()
	{
		$this->load->model('Ploating_model');
		$this->load->model('Scheme_model');
		$this->load->model('Presensi_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Beranda Peserta - Jurnal PKL Online SMKN 1 Garut";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['menuactive'] = "dashboard";
		$today = date('Y-m-d');
		$partisipantploating = $this->Ploating_model->getPartisipantPloating($biodata->partisipant_id, $today);
		$workingscheme = $this->Scheme_model->getWorkingScheme($partisipantploating->row()->ploating_id, $today);
		$presencenow = $this->Presensi_model->getPresenceNow($partisipantploating->row()->ploating_id);
		$data['day'] = date('w') + 1;
		$data['jumlah_ploating'] = $partisipantploating->num_rows();
		$data['ploating'] = $partisipantploating->row();
		$data['jumlah_scheme'] = $workingscheme->num_rows();
		$data['scheme'] = $workingscheme->row();
		$data['jumlah_presensi'] = $presencenow->num_rows();
		$data['presensi'] = $presencenow->row();

		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/beranda', $data);
		$this->load->view('templates/footer');
	}

	public function presensi()
	{
		$this->load->model('Ploating_model');
		$this->load->model('Scheme_model');
		$this->load->model('Presensi_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Riwayat Presensi Peserta - Jurnal PKL Online SMKN 1 Garut";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['menuactive'] = "presensi";
		$today = date('Y-m-d');
		$partisipantploating = $this->Ploating_model->getPartisipantPloating($biodata->partisipant_id, $today);
		$workingscheme = $this->Scheme_model->getWorkingScheme($partisipantploating->row()->ploating_id, $today);
		$presencenow = $this->Presensi_model->getPresenceNow($partisipantploating->row()->ploating_id);
		$data['day'] = date('w') + 1;
		$data['jumlah_ploating'] = $partisipantploating->num_rows();
		$data['ploating'] = $partisipantploating->row();
		$data['jumlah_scheme'] = $workingscheme->num_rows();
		$data['scheme'] = $workingscheme->row();
		$data['jumlah_presensi'] = $presencenow->num_rows();
		$data['presensi'] = $presencenow->row();

		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/presensi', $data);
		$this->load->view('templates/footer');
	}

	public function jurnal()
	{
		$this->load->model('Jurnal_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Jurnal Peserta - Jurnal PKL Online SMKN 1 Garut";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['menuactive'] = "jurnal";
		$data['jurnal'] = $this->Jurnal_model->getJurnalPartisipant($biodata->partisipant_id);

		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function jurnaldetail($jurnal_id)
	{
		$this->load->model('Jurnal_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Jurnal Peserta - Jurnal PKL Online SMKN 1 Garut";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['menuactive'] = "jurnal";
		$data['jurnal_id'] = $jurnal_id;
		$data['jurnaldetail'] = $this->Jurnal_model->getJurnalDetail($jurnal_id);

		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/detail_jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function biodata()
	{
		$this->load->model('Izin_model');
		$this->load->model('Ploating_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Biodata Peserta - Jurnal PKL Online SMKN 1 Garut";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['menuactive'] = "biodata";
		$data['biodata'] = $biodata;
		$data['ploating'] = $this->Ploating_model->getAllPloatingPartisipant($biodata->partisipant_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/biodata', $data);
		$this->load->view('templates/footer');
	}

	public function mulai($ploating_id)
	{
		$this->load->model('Presensi_model');
		$presencenow = $this->Presensi_model->getPresenceNow($ploating_id)->row();
		if (!$presencenow) {
			if (isset($_POST['image'])) {
				$data = $_POST['image'];
				$image_array_1 = explode(";", $data);
				$image_array_2 = explode(",", $image_array_1[1]);
				$data = base64_decode($image_array_2[1]);
				$presenceimg = $ploating_id . time() . '.png';
				$image_name = './public/assets/img/presences/' . $presenceimg;
				file_put_contents($image_name, $data);
				$data_absen = [
					'ploating_id' => $ploating_id,
					'presence_date' => date('Y-m-d'),
					'started_time' => date("H:i:s"),
					'started_photo' => $presenceimg,
					'status' => '1'
				];
				$this->db->insert('presences', $data_absen);
				redirect(base_url());
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gambar Harus di Upload</div>');
				redirect(base_url());
			}
		} else {
			if (isset($_POST['image'])) {
				$data = $_POST['image'];
				$image_array_1 = explode(";", $data);
				$image_array_2 = explode(",", $image_array_1[1]);
				$data = base64_decode($image_array_2[1]);
				$presenceimg = $ploating_id . time() . '.png';
				$image_name = './public/assets/img/presences/' . $presenceimg;
				file_put_contents($image_name, $data);
				$data_absen = [
					'finished_time' => date("H:i:s"),
					'finished_photo' => $presenceimg,
					'status' => '1'
				];
				$this->db->set($data_absen);
				$this->db->where('ploating_id', $ploating_id);
				$this->db->where('presence_date', date('Y-m-d'));
				$this->db->update('presences');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gambar Harus di Upload</div>');
				redirect(base_url());
			}
		}
	}

	public function update()
	{
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		if ($biodata) {
			if (isset($_POST['image'])) {
				$data = $_POST['image'];
				$image_array_1 = explode(";", $data);
				$image_array_2 = explode(",", $image_array_1[1]);
				$data = base64_decode($image_array_2[1]);
				$photo = $biodata->partisipant_id . time() . '.png';
				$image_name = './public/assets/img/avatars/' . $photo;
				file_put_contents($image_name, $data);
				if ($biodata->photo != "no_image.png") {
					unlink('./public/assets/img/avatars/' . $biodata->photo);
				}
				$data_photo = [
					'photo' => $photo
				];
				$this->db->set($data_photo);
				$this->db->where('partisipant_id', $biodata->partisipant_id);
				$this->db->update('partisipants');
				redirect(base_url('peserta/biodata'));
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gambar Harus di Upload</div>');
				redirect(base_url('peserta/biodata'));
			}
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Silahkan login terlebih dahulu</div>');
			redirect(base_url());
		}
	}

	public function simpan()
	{
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		if ($biodata) {
			$name = $this->input->post('name');
			$nis = $this->input->post('nis');
			$nisn = $this->input->post('nisn');
			$birth_place = $this->input->post('birth_place');
			$birth_date = $this->input->post('birth_date');
			$gender = $this->input->post('gender');
			$religion = $this->input->post('religion');
			$address = $this->input->post('address');
			$contact = $this->input->post('contact');
			$parent = $this->input->post('parent');
			$parent_address = $this->input->post('parent_address');
			$parent_contact = $this->input->post('parent_contact');
			$data = [
				'name' => $name,
				'nis' => $nis,
				'nisn' => $nisn,
				'birth_place' => $birth_place,
				'birth_date' => $birth_date,
				'gender' => $gender,
				'religion' => $religion,
				'address' => $address,
				'contact' => $contact,
				'parent' => $parent,
				'parent_address' => $parent_address,
				'parent_contact' => $parent_contact
			];
			$this->db->set($data);
			$this->db->where('partisipant_id', $biodata->partisipant_id);
			$this->db->update('partisipants');
			redirect(base_url('peserta/biodata'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
			redirect(base_url('peserta/biodata'));
		}
	}

	public function izinisi($ploating_id)
	{
		$this->load->model('Izin_model');
		$this->load->model('Ploating_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Izin - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "instruktur";
		$data['biodata'] = $biodata;
		$data['izin'] = $this->Izin_model->getParentPermission($ploating_id);
		$data['ploating'] = $this->Ploating_model->getThisPloating($ploating_id);
		$data['ploating_id'] = $ploating_id;
		$this->form_validation->set_rules('status', 'Keterangan Instruktur', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('peserta/isi_izin', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_isiizin($ploating_id);
		}
	}

	private function _isiizin($ploating_id)
	{
		$status = $this->input->post('status');
		$data = [
			'ploating_id' => $ploating_id,
			'status' => $status
		];
		$izin = $this->Izin_model->getParentPermission($ploating_id);
		if (!$izin) {
			$this->db->insert('parent_permissions', $data);
		} else {
			$this->db->set($data);
			$this->db->where('ploating_id', $ploating_id);
			$this->db->update('parent_permissions');
		}
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect(base_url('peserta/biodata'));
	}

	public function jurnaladd()
	{
		$this->load->model('Ploating_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Jurnal - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "jurnal";
		$data['biodata'] = $biodata;
		$data['ploating'] = $this->Ploating_model->getAllPloatingPartisipant($biodata->partisipant_id);
		$this->form_validation->set_rules('jurnal_date', 'Tanggal Jurnal', 'required|trim');
		$this->form_validation->set_rules('division', 'Unit Kerja', 'required|trim');
		$this->form_validation->set_rules('ploating_id', 'Nama Dudika', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('peserta/add_jurnal', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addjurnal();
		}
	}

	private function _addjurnal()
	{
		$jurnal_date = $this->input->post('jurnal_date');
		$division = $this->input->post('division');
		$ploating_id = $this->input->post('ploating_id');
		$data = [
			'ploating_id' => $ploating_id,
			'jurnal_date' => $jurnal_date,
			'division' => $division
		];
		$this->db->insert('jurnals', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect(base_url('peserta/jurnal'));
	}

	public function jurnaldetailadd($jurnal_id)
	{
		$this->load->model('Ploating_model');
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Jurnal - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "jurnal";
		$data['biodata'] = $biodata;
		$data['jurnal_id'] = $jurnal_id;
		$data['ploating'] = $this->Ploating_model->getAllPloatingPartisipant($biodata->partisipant_id);
		$this->form_validation->set_rules('working_name', 'Nama Pekerjaan', 'required|trim');
		$this->form_validation->set_rules('working_plan', 'Rencana Kegiatan', 'required|trim');
		$this->form_validation->set_rules('working_goal', 'Hasil Pekerjaan', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('peserta/add_jurnaldetail', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addjurnaldetail($jurnal_id);
		}
	}

	private function _addjurnaldetail($jurnal_id)
	{
		$working_name = $this->input->post('working_name');
		$working_plan = $this->input->post('working_plan');
		$working_goal = $this->input->post('working_goal');
		$data = [
			'working_name' => $working_name,
			'working_plan' => $working_plan,
			'working_goal' => $working_goal,
			'jurnal_id' => $jurnal_id
		];
		$this->db->insert('jurnal_details', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect(base_url('peserta/jurnaldetail/' . $jurnal_id));
	}
}
