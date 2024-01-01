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
		$biodata = $this->Peserta_model->getBioPeserta($this->session->userdata('email'));
		$header['title'] = "Beranda Peserta";
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('peserta/beranda');
		$this->load->view('templates/footer');
	}
}
