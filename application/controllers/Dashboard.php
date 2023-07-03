<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
			$data['dokter'] = $this->Dokter_model->get_all();
			$data['card_dashboard']['count_rekam_medis'] = count_rekam_medis($this->db);
			$data['card_dashboard']['count_rekam_medis_month'] = count_records_this_month($this->db);
			$data['card_dashboard']['count_periksa_month'] = count_periksa_records_this_month($this->db);
			$data['card_dashboard']['count_rekam_medis_month_before'] = count_records_month($this->db, 1);
			$data['search_header'] = (isset($_GET['search_header'])) ? $_GET['search_header'] : '';
			// echo $data['search_header'];
			// die();
			$this->load->view('template/auth_header', $data);
			$this->load->view('pengguna/dashboard', $data);
			$this->load->view('template/auth_modal', $data);
			$this->load->view('template/auth_footer');
		} else {
			redirect('auth');
		}
	}

	function get_data_rm()
	{
		$list = $this->Pengguna_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			// $row[] = $field->id;
			$row[] = $field->nomor_rm;
			$row[] = $field->nama;
			$row[] = $field->dusun;
			$row[] = $field->id;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Pengguna_model->count_all(),
			"recordsFiltered" => $this->Pengguna_model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}
}
