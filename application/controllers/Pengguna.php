<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Pengguna_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('surel')) {
			$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
			// $data['rekammedis'] = $this->db->get('rekam_medis')->result_array();
			$data['title'] = 'Halaman Pengguna';

			$this->load->view('template/auth_header', $data);
			$this->load->view('pengguna/index', $data);
			$this->load->view('template/auth_modal', $data);
			$this->load->view('template/auth_footer');
		} else {
			redirect('auth');
		}
	}

	public function auth_edit_rekammedis($id = null)
	{
		if ($this->session->has_userdata('surel')) {
			// $id = $this->input->post('22');
			$kabupaten = $this->input->post('kabupaten');
			$data['rekammedis'] = $this->db->get_where('rekam_medis', ['id' => $id])->row_array();
			$data['lokasi'] = $this->db->get_where('inf_lokasi', ['lokasi_ID' => $kabupaten])->row_array();
			$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
			$data['lokasi_kabupaten'] = $this->db->select('*')->from('inf_lokasi')
				->group_start()
				->where('lokasi_propinsi', '34')->or_where('lokasi_propinsi', '33')
				->group_end()
				->group_start()
				->where('lokasi_kecamatan', '0')
				->where('lokasi_kelurahan', '0')
				->where('lokasi_kabupatenkota !=', '0')
				->group_end()
				->order_by('lokasi_ID', 'ASC')
				->get()->result_array();
			$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
			$data['title'] = 'Edit Data Pasien';
			$this->load->view('template/auth_header', $data);
			$this->load->view('pengguna/editRekamMedis', $data);
			$this->load->view('template/auth_modal', $data);
			$this->load->view('template/auth_footer');
		} else {
			redirect('auth');
		}
	}

	function get_data_user()
	{
		$list = $this->Pengguna_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			// $row[] = $field->id;
			$row[] = $no;
			$row[] = $field->nomor_rm;
			$row[] = $field->nama;
			$row[] = $field->pekerjaan;
			$row[] = $field->dusun;
			$row[] = $field->kelurahan;
			$row[] = $field->id;
			$row[] = $field->id;
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
	public function editRekamMedis()
	{
		if ($this->session->has_userdata('surel')) {
			$this->form_validation->set_rules('nomorktp', 'Nomor KTP', 'trim');
			$this->form_validation->set_rules('id', 'Id', 'trim');
			$this->form_validation->set_rules('nomorrm', 'Nomor RM', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('nomor_hp', 'Nomor Telpon', 'trim');
			$this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim');
			$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('dusun', 'Kelurahan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);

			if ($this->form_validation->run() == false) {
				$id = $this->input->post('idpasien');
				$kabupaten = $this->input->post('kabupaten');
				$data['rekammedis'] = $this->db->get_where('rekam_medis', ['id' => $id])->row_array();
				$data['lokasi'] = $this->db->get_where('inf_lokasi', ['lokasi_ID' => $kabupaten])->row_array();
				$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
				$data['lokasi_kabupaten'] = $this->db->select('*')->from('inf_lokasi')
					->group_start()
					->where('lokasi_propinsi', '34')->or_where('lokasi_propinsi', '33')
					->group_end()
					->group_start()
					->where('lokasi_kecamatan', '0')
					->where('lokasi_kelurahan', '0')
					->where('lokasi_kabupatenkota !=', '0')
					->group_end()
					->order_by('lokasi_ID', 'ASC')
					->get()->result_array();
				$data['title'] = 'Edit Data Pasien';
				$this->load->view('template/auth_header', $data);
				$this->load->view('pengguna/editRekamMedis', $data);
				$this->load->view('template/auth_modal', $data);
				$this->load->view('template/auth_footer');
			} else {
				$data = [
					'id' => htmlspecialchars($this->input->post('id', true)),
					'nomor_rm' => htmlspecialchars($this->input->post('nomorrm', true)),
					'nomor_ktp' => htmlspecialchars($this->input->post('nomorktp', true)),
					'nomor_hp' => htmlspecialchars($this->input->post('nomor_hp', true)),
					'tanggal_lahir' => htmlspecialchars($this->input->post('tanggal_lahir', true)),
					'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin', true)),
					'nama' => htmlspecialchars($this->input->post('nama', true)),
					'alamat' => htmlspecialchars($this->input->post('alamat', true)),
					'pekerjaan' => htmlspecialchars($this->input->post('pekerjaan'), true),
					'kabupaten_kota' => htmlspecialchars($this->input->post('kabupaten'), true),
					'kecamatan' => htmlspecialchars($this->input->post('kecamatan'), true),
					'kelurahan' => htmlspecialchars($this->input->post('kelurahan'), true),
					'dusun' => htmlspecialchars($this->input->post('dusun'), true),
					'updated_at' => date("Y-m-d H:i"),
				];
				$nomorrm = htmlspecialchars($this->input->post('nomorrm', true));
				$nama = htmlspecialchars($this->input->post('nama', true));
				$this->db->replace('rekam_medis', $data);
				$this->session->set_flashdata('pesan_registrasi', '<div class="alert alert-success" role="alert">No RM ' . $nomorrm . ' dengan nama ' . $nama . ' Berhasil diperbarui!</div>');
				redirect('pengguna');
			}
		} else {
			redirect('auth');
		}
	}

	public function hapusRekamMedis($idpasien = NULL)
	{
		// $nomorrm = htmlspecialchars($this->input->post('nomorrm', true));
		// $nama = htmlspecialchars($this->input->post('nama', true));
		// $idpasien = htmlspecialchars($this->input->post('idpasien', true));
		if ($this->session->has_userdata('surel')) {
			$this->db->where('id', $idpasien);
			$this->db->delete('rekam_medis');
			$this->session->set_flashdata('pesan_registrasi', '<div class="alert alert-success" role="alert">Data berhasil duhapus!</div>');
			redirect('pengguna');
		} else {
			redirect('auth');
		}
	}

	public function tambahRekamMedis()
	{
		if ($this->session->has_userdata('surel')) {
			$this->form_validation->set_rules('nomorktp', 'Nomor KTP', 'trim|is_unique[rekam_medis.nomor_ktp]', ['is_unique' => 'Nomor KTP telah teregistrasi!']);
			$this->form_validation->set_rules('nomorrm', 'Nomor RM', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('nomor_hp', 'Nomor Telpon', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);
			$this->form_validation->set_rules('dusun', 'Kelurahan', 'required|trim', ['required' => 'Lengkapi kolom ini!']);


			$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
			$data['rekammedis'] = $this->db->get('rekam_medis')->result_array();
			$data['lokasi'] = $this->db->get('inf_lokasi')->result_array();
			// $data['lokasi_kabupaten'] = $this->db->get_where('inf_lokasi', ['lokasi_propinsi' => '33', 'lokasi_kecamatan' => '0',  'lokasi_kabupatenkota !=' => 0])->result_array();
			$data['lokasi_kabupaten'] = $this->db->select('*')->from('inf_lokasi')
				->group_start()
				->where('lokasi_propinsi', '34')->or_where('lokasi_propinsi', '33')
				->group_end()
				->group_start()
				->where('lokasi_kecamatan', '0')
				->where('lokasi_kelurahan', '0')
				->where('lokasi_kabupatenkota !=', '0')
				->group_end()
				->order_by('lokasi_ID', 'ASC')
				->get()->result_array();

			if ($this->form_validation->run() == false) {
				$data['title'] = 'Tambah Rekam Medis';
				$this->load->view('template/auth_header', $data);
				$this->load->view('pengguna/tambahRekamMedis', $data);
				$this->load->view('template/auth_modal', $data);
				$this->load->view('template/auth_footer');
			} else {
				$data = [
					'nomor_rm' => htmlspecialchars($this->input->post('nomorrm', true)),
					'nomor_ktp' => htmlspecialchars($this->input->post('nomorktp', true)),
					'nomor_hp' => htmlspecialchars($this->input->post('nomor_hp', true)),
					'nama' => htmlspecialchars($this->input->post('nama', true)),
					'tanggal_lahir' => htmlspecialchars($this->input->post('tanggal_lahir', true)),
					'alamat' => htmlspecialchars($this->input->post('alamat', true)),
					'pekerjaan' => htmlspecialchars($this->input->post('pekerjaan'), true),
					'kabupaten_kota' => htmlspecialchars($this->input->post('kabupaten'), true),
					'kecamatan' => htmlspecialchars($this->input->post('kecamatan'), true),
					'kelurahan' => htmlspecialchars($this->input->post('kelurahan'), true),
					'dusun' => htmlspecialchars($this->input->post('dusun'), true),
					'tanggal_buat' => time()


				];
				$nomorrm = htmlspecialchars($this->input->post('nomorrm', true));
				$nama = htmlspecialchars($this->input->post('nama', true));
				$this->db->insert('rekam_medis', $data);
				$this->session->set_flashdata('pesan_registrasi', '<div class="alert alert-success" role="alert">No RM ' . $nomorrm . ' dengan nama ' . $nama . ' Berhasil ditambahkan!</div>');
				redirect('pengguna');
			}
		}
	}

	public function listKota()
	{
		// Ambil data ID Provinsi yang dikirim via ajax post
		$id_kabupaten = $this->input->post('id_kabupaten');

		$kecamatan = $this->db->get_where('inf_lokasi', ['lokasi_propinsi' => '34', 'lokasi_kabupatenkota' => $id_kabupaten, 'lokasi_kecamatan !=' => 0,  'lokasi_kelurahan' => '0'])->result_array();

		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "<option value=''>Pilih</option>";

		foreach ($kecamatan as $data) {
			$id = $data['lokasi_kecamatan'];
			$nama = $data['lokasi_nama'];
			$lists .= "<option value='" . $id . "'>" . $nama . "</option>"; // Tambahkan tag option ke variabel $lists
		}

		$callback = array('list_kota' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}

	public function listKecamatan()
	{
		// Ambil data ID Provinsi yang dikirim via ajax post
		$id_kabupaten = $this->input->post('id_kabupaten');
		$id_kecamatan = $this->input->post('id_kecamatan');

		$kelurahan = $this->db->get_where('inf_lokasi', ['lokasi_propinsi' => '34', 'lokasi_kabupatenkota' => $id_kabupaten, 'lokasi_kecamatan' => $id_kecamatan,  'lokasi_kelurahan !=' => 0])->result_array();

		// Buat variabel untuk menampung tag-tag option nya
		// Set defaultnya dengan tag option Pilih
		$lists = "<option value=''>Pilih</option>";

		foreach ($kelurahan as $data) {
			$id = $data['lokasi_kecamatan'];
			$nama = $data['lokasi_nama'];
			$lists .= "<option value='" . $id . "'>" . $nama . "</option>"; // Tambahkan tag option ke variabel $lists
		}

		$callback = array('list_kecamatan' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}

	function detailPengguna($id = null)
	{
		$data = array();
		$data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
		$data['title'] = 'Halaman Pengguna';
		$data['pasien'] = $this->Pengguna_model->get_by_id($id);
		$data['riwayat'] = $this->Pengguna_model->get_new_riwayat_by_id($id);
		// print_r($data['riwayat']);
		// echo ($this->db->last_query());
		// die();
		$this->load->view('template/auth_header', $data);
		$this->load->view('pengguna/riwayatPasien', $data);
		$this->load->view('template/auth_modal', $data);
		$this->load->view('template/auth_footer');
	}
}
