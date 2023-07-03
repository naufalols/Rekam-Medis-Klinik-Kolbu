<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Pengguna_model');
		$this->load->model('Antre_model');
		$this->load->model('Dokter_model');
		$this->load->helper(array('form', 'url', 'rekam_medis'));
	}

	public function index()
	{
		if ($this->session->has_userdata('surel')) {
			$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
			$data['title'] = 'Halaman Pengguna';
			$data['antre'] = $this->Antre_model->get_all();
			if (isset($_GET['lastMonth']) && isset($_GET['currentYear'])) {
				$data['dokter'] = $this->Dokter_model->count_all_periksa($lastMonth, $currentYear);
			} else {
				$lastMonth = date('m');
				$currentYear = date('Y');
				$data['dokter'] = $this->Dokter_model->count_all_periksa($lastMonth, $currentYear);
			}
			$data['card_dashboard']['count_rekam_medis_month_before'] = count_records_month($this->db, 1);

			$this->load->view('template/auth_header', $data);
			$this->load->view('pengguna/dokter', $data);
			$this->load->view('template/auth_modal', $data);
			$this->load->view('template/auth_footer');
		} else {
			redirect('auth');
		}
	}

	function store()
	{
		$this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('dokter', '<div class="alert alert-danger" role="alert">Gagal menambahkan dokter</div>');
			redirect('dokter');
		}

		$data = array(
			'nama_dokter' => $_POST['nama_dokter'],
			'created_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "created_at" value
			'updated_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "updated_at" value
		);
		if ($this->Dokter_model->saverecords($data)) {
			$this->session->set_flashdata('dokter', '<div class="alert alert-success" role="alert">Berhasil ditambahkan</div>');
			redirect('dokter');
		}

		redirect('dashboard');
	}
}
