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
}
