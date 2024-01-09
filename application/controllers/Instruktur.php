<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instruktur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email') or $this->session->userdata('role_id') != 4) {
			redirect(base_url('auth'));
		}
		$this->load->model('Instruktur_model');
	}

	public function index()
	{
		$this->load->model('Presensi_model');
		$this->load->model('Jurnal_model');
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Beranda Instruktur - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dashboard";
		$data['panduan'] = $this->Instruktur_model->getPanduan($biodata->instruktur_id)->document;
		$data['presensi'] = $this->Presensi_model->getPresenceThisInstruktur($biodata->instruktur_id, '1');
		$data['jurnal'] = $this->Jurnal_model->getJurnalThisInstruktur($biodata->instruktur_id, '1');
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('instruktur/beranda', $data);
		$this->load->view('templates/footer');
	}

	public function terimapresence($presenceID)
	{
		$this->load->model('Presensi_model');
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		$cekpresence = $this->Presensi_model->cekPresensceInstruktur($biodata->instruktur_id, $presenceID);
		if ($cekpresence != 0) {
			$data = [
				'status' => '2'
			];
			$this->db->set($data);
			$this->db->where('presence_id', $presenceID);
			$this->db->update('presences');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url());
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert">Data Tidak ditemukan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>');
			redirect(base_url());
		}
	}

	public function tolakpresence($presenceID)
	{
		$this->load->model('Presensi_model');
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Konfirmasi Tolak Kehadiran - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dashboard";
		$data['presenceID'] = $presenceID;
		$this->form_validation->set_rules('reason', 'Alasan Penolakan', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('instruktur/tolak_presensi', $data);
			$this->load->view('templates/footer');
		} else {
			$reason = $this->input->post('reason');
			$cekpresence = $this->Presensi_model->cekPresensceInstruktur($biodata->instruktur_id, $presenceID);
			if ($cekpresence != 0) {
				$data = [
					'status' => '3',
					'reason' => $reason
				];
				$this->db->set($data);
				$this->db->where('presence_id', $presenceID);
				$this->db->update('presences');
				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert">Data Tidak ditemukan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>');
				redirect(base_url());
			}
		}
	}

	public function jurnalproses($jurnalID)
	{
		$this->load->model('Jurnal_model');
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Detail Jurnal - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dashboard";
		$data['jurnalID'] = $jurnalID;
		$data['jurnal'] = $this->Jurnal_model->getThisJurnalDetail($jurnalID);
		$this->form_validation->set_rules('noted', 'Catatan Instruktur', 'required|trim');
		$this->form_validation->set_rules('status', 'Keterangan Jurnal', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('instruktur/proses_jurnal', $data);
			$this->load->view('templates/footer');
		} else {
			$noted = $this->input->post('noted');
			$status = $this->input->post('status');
			$cekjurnal = $this->Jurnal_model->cekThisJurnalInstruktur($biodata->instruktur_id, $jurnalID);
			if ($cekjurnal != 0) {
				$data = [
					'status' => $status,
					'instruktur_noted' => $noted
				];
				$this->db->set($data);
				$this->db->where('jurnal_detail_id', $jurnalID);
				$this->db->update('jurnal_details');
				$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil disimpan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert">Data Tidak ditemukan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>');
				redirect(base_url());
			}
		}
	}

	public function biodata()
	{
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Biodata Instruktur - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "biodata";
		$data['biodata'] = $biodata;
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('instruktur/biodata', $data);
		$this->load->view('templates/footer');
	}

	public function update()
	{
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		if ($biodata) {
			if (isset($_POST['image'])) {
				$data = $_POST['image'];
				$image_array_1 = explode(";", $data);
				$image_array_2 = explode(",", $image_array_1[1]);
				$data = base64_decode($image_array_2[1]);
				$photo = 'i' . $biodata->instruktur_id . time() . '.png';
				$image_name = './public/assets/img/avatars/' . $photo;
				file_put_contents($image_name, $data);
				if ($biodata->photo != "no_image.png") {
					unlink('./public/assets/img/avatars/' . $biodata->photo);
				}
				$data_photo = [
					'photo' => $photo
				];
				$this->db->set($data_photo);
				$this->db->where('instruktur_id', $biodata->instruktur_id);
				$this->db->update('instrukturs');
				redirect(base_url('instruktur/biodata'));
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Gambar Harus di Upload</div>');
				redirect(base_url('instruktur/biodata'));
			}
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Silahkan login terlebih dahulu</div>');
			redirect(base_url());
		}
	}

	public function simpan()
	{
		$biodata = $this->Instruktur_model->getBioInstruktur($this->session->userdata('email'));
		if ($biodata) {
			$name = $this->input->post('name');
			$nid = $this->input->post('nid');
			$position = $this->input->post('position');
			$dudika = $this->input->post('dudika');
			$address = $this->input->post('address');
			$head = $this->input->post('head');
			$head_nip = $this->input->post('head_nip');
			$head_position = $this->input->post('head_position');
			$data = [
				'name' => $name,
				'nid' => $nid,
				'position' => $position
			];
			$this->db->set($data);
			$this->db->where('instruktur_id', $biodata->instruktur_id);
			$this->db->update('instrukturs');
			$data2 = [
				'name' => $dudika,
				'address' => $address,
				'head' => $head,
				'head_nip' => $head_nip,
				'head_position' => $head_position
			];
			$this->db->set($data2);
			$this->db->where('dudika_id', $biodata->dudika_id);
			$this->db->update('dudikas');
			redirect(base_url('instruktur/biodata'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>');
			redirect(base_url('instruktur/biodata'));
		}
	}
}
