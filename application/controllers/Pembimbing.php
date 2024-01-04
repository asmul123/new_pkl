<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembimbing extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('email') or $this->session->userdata('role_id') != 3) {
			redirect(base_url('auth'));
		}
		$this->load->model('Mentor_model');
	}

	public function index()
	{
		$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Beranda Pembimbing - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "dashboard";
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('pembimbing/beranda');
		$this->load->view('templates/footer');
	}

	public function instruktur()
	{
		$this->load->model('Instruktur_model');
		$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Instruktur - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "instruktur";
		$data['instruktur'] = $this->Instruktur_model->getInstrukturMentors($biodata->mentor_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('pembimbing/instruktur', $data);
		$this->load->view('templates/footer');
	}

	public function instrukturadd()
	{
		$this->load->model('Dudika_model');
		$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Instruktur - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "instruktur";
		$data['dudika'] = $this->Dudika_model->getDudikaPloatings($biodata->mentor_id);
		$this->form_validation->set_rules('name', 'Nama Instruktur', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Instruktur', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Instruktur', 'required|trim');
		$this->form_validation->set_rules('email', 'Email Instruktur', 'required|trim');
		$this->form_validation->set_rules('dudika_id', 'Nama Dudika', 'required|trim');
		$this->form_validation->set_rules('start_date', 'Tanggal Mulai PKL', 'required|trim');
		$this->form_validation->set_rules('start_time', 'Waktu Mulai PKL', 'required|trim');
		$this->form_validation->set_rules('finish_date', 'Tanggal Akhir PKL', 'required|trim');
		$this->form_validation->set_rules('finish_time', 'Waktu Akhir PKL', 'required|trim');
		$this->form_validation->set_rules('ploating_id[]', 'Peserta PKL', 'required|trim');
		$this->form_validation->set_rules('off_days[]', 'Hari Libur PKL', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('pembimbing/add_instruktur', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_addinstruktur();
		}
	}

	private function _addinstruktur()
	{
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$dudika_id = $this->input->post('dudika_id');
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$start_date = $this->input->post('start_date');
		$start_time = $this->input->post('start_time');
		$finish_date = $this->input->post('finish_date');
		$finish_time = $this->input->post('finish_time');
		$off_days = $this->input->post('off_days');
		$count_off = count($off_days);
		$offdays = "";
		for ($j = 0; $j < $count_off; $j++) {
			$offdays = $offdays . "#" . $off_days[$j];
		}
		$ploating_id = $this->input->post('ploating_id');
		$count_ploat = count($ploating_id);
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
				'role_id' => 4
			];
			$this->db->insert('users', $data);
			$user_id = $this->db->get_where('users', ['email' => $email])->row()->user_id;
			$data = [
				'name' => $name,
				'nid' => $nid,
				'position' => $position,
				'dudika_id' => $dudika_id,
				'user_id' => $user_id,
				'photo' => $photo
			];
			$this->db->insert('instrukturs', $data);
			$instruktur_id = $this->db->get_where('instrukturs', ['user_id' => $user_id])->row()->instruktur_id;
			for ($i = 0; $i < $count_ploat; $i++) {
				$data = [
					'start_date' => $start_date,
					'start_time' => $start_time,
					'finish_date' => $finish_date,
					'finish_time' => $finish_time,
					'off_days' => $offdays,
					'instruktur_id' => $instruktur_id,
				];
				$this->db->set($data);
				$this->db->where('ploating_id', $ploating_id[$i]);
				$this->db->update('ploatings');
			}
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('pembimbing/instruktur'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('pembimbing/instrukturadd'));
		}
	}

	public function instrukturedit($instrukturID)
	{
		$this->load->model('Instruktur_model');
		$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Instruktur - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "instruktur";
		$data['instruktur'] = $this->Instruktur_model->getThisInstruktur($instrukturID);
		$data['instrukturID'] = $instrukturID;
		$this->form_validation->set_rules('name', 'Nama Instruktur', 'required|trim');
		$this->form_validation->set_rules('nid', 'NIP/NIK Instruktur', 'required|trim');
		$this->form_validation->set_rules('position', 'Jabatan Instruktur', 'required|trim');
		$this->form_validation->set_rules('email', 'Email Instruktur', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('pembimbing/edit_instruktur', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editinstruktur($instrukturID);
		}
	}

	private function _editinstruktur($instrukturID)
	{
		$this->load->model('Instruktur_model');
		$instruktur = $this->Instruktur_model->getThisInstruktur($instrukturID);
		$name = $this->input->post('name');
		$nid = $this->input->post('nid');
		$position = $this->input->post('position');
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$user_id = $instruktur->user_id;
		$oldphoto = $instruktur->photo;
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
			$this->db->where('instruktur_id', $instrukturID);
			$this->db->update('instrukturs');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil diubah<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('pembimbing/instruktur'));
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible" role="alert">Gagal Menambahkan! Email Sudah Ada<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect(base_url('pembimbing/instrukturadd'));
		}
	}

	function getploating()
	{
		$this->load->model('Ploating_model');
		$dudika_id = $this->input->post('id', TRUE);
		$data = $this->Ploating_model->getPloatingDudika($dudika_id);
		echo json_encode($data);
	}

	function getdate()
	{
		$this->load->model('Ploating_model');
		$dudika_id = $this->input->post('id', TRUE);
		$data2 = $this->Ploating_model->getEventDudika($dudika_id);
		echo json_encode($data2);
	}

	public function peserta()
	{
		$this->load->model('Peserta_model');
		$biodata = $this->Mentor_model->getBioMentor($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Daftar Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "peserta";
		$data['peserta'] = $this->Peserta_model->getPesertaPloatings($biodata->mentor_id);
		$this->load->view('templates/header', $header);
		$this->load->view('templates/sidebar');
		$this->load->view('templates/navbar');
		$this->load->view('pembimbing/peserta', $data);
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
		$this->load->model('Kegiatan_model');
		$this->load->model('Dudika_model');
		$this->load->model('Mentor_model');
		$this->load->model('Peserta_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Tambah Penempatan Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "ploating";
		$data['kegiatan'] = $this->Kegiatan_model->getEventMajors($biodata->major_id);
		$data['dudika'] = $this->Dudika_model->getDudikaMajors($biodata->major_id);
		$data['mentor'] = $this->Mentor_model->getMentorMajors($biodata->major_id);
		$data['peserta'] = $this->Peserta_model->getPesertaMajors($biodata->major_id);
		$this->form_validation->set_rules('event_id', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('dudika_id', 'Nama Dudika', 'required|trim');
		$this->form_validation->set_rules('mentor_id', 'Nama Pembimbing', 'required|trim');
		$this->form_validation->set_rules('partisipant_id[]', 'Nama Peserta', 'required|trim');
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
		$event_id = $this->input->post('event_id');
		$dudika_id = $this->input->post('dudika_id');
		$mentor_id = $this->input->post('mentor_id');
		$partisipant_id = $this->input->post('partisipant_id');
		$count = count($partisipant_id);
		$no = 0;
		for ($i = 0; $i < $count; $i++) {
			$data = [
				'dudika_id' => $dudika_id,
				'event_id' => $event_id,
				'mentor_id' => $mentor_id,
				'partisipant_id' => $partisipant_id[$i]
			];
			$this->db->insert('ploatings', $data);
			$no++;
		}
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil ditambahkan ' . $no . ' data<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect(base_url('kaprog/ploating'));
	}

	public function ploatingedit($ploatingID)
	{
		$this->load->model('Kegiatan_model');
		$this->load->model('Dudika_model');
		$this->load->model('Mentor_model');
		$this->load->model('Peserta_model');
		$this->load->model('Ploating_model');
		$biodata = $this->Kaprog_model->getBioKaprog($this->session->userdata('email'));
		$header['photo'] = $biodata->photo;
		$header['name'] = $biodata->name;
		$header['role'] = $biodata->role;
		$header['title'] = "Edit Penempatan Peserta - Jurnal PKL Online SMKN 1 GARUT";
		$header['menuactive'] = "ploating";
		$data['kegiatan'] = $this->Kegiatan_model->getEventMajors($biodata->major_id);
		$data['dudika'] = $this->Dudika_model->getDudikaMajors($biodata->major_id);
		$data['mentor'] = $this->Mentor_model->getMentorMajors($biodata->major_id);
		$data['peserta'] = $this->Peserta_model->getPesertaMajors($biodata->major_id);
		$data['ploating'] = $this->Ploating_model->getThisPloating($ploatingID);
		$data['ploatingID'] = $ploatingID;
		$this->form_validation->set_rules('event_id', 'Nama Kegiatan', 'required|trim');
		$this->form_validation->set_rules('dudika_id', 'Nama Dudika', 'required|trim');
		$this->form_validation->set_rules('mentor_id', 'Nama Pembimbing', 'required|trim');
		$this->form_validation->set_rules('partisipant_id', 'Nama Peserta', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $header);
			$this->load->view('templates/sidebar');
			$this->load->view('templates/navbar');
			$this->load->view('kaprog/edit_ploating', $data);
			$this->load->view('templates/footer');
		} else {
			$this->_editploating($ploatingID);
		}
	}

	private function _editploating($ploatingID)
	{
		$event_id = $this->input->post('event_id');
		$dudika_id = $this->input->post('dudika_id');
		$mentor_id = $this->input->post('mentor_id');
		$partisipant_id = $this->input->post('partisipant_id');
		$data = [
			'dudika_id' => $dudika_id,
			'event_id' => $event_id,
			'mentor_id' => $mentor_id,
			'partisipant_id' => $partisipant_id
		];
		$this->db->set($data);
		$this->db->where('ploating_id', $ploatingID);
		$this->db->update('ploatings');
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible" role="alert">Data Berhasil mengubah data<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
		redirect(base_url('kaprog/ploating'));
	}
}
