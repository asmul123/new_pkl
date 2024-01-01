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
	}

	public function index()
	{
		$header['title'] = "Beranda Admin";
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('admin/beranda');
			$this->load->view('templates/footer');
	}

}
