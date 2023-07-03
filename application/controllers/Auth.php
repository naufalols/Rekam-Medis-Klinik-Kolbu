<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		if ($this->session->has_userdata('surel')) {
			redirect('dashboard');
		} else {
			$this->form_validation->set_rules('surel', 'Surel', 'required|trim|valid_email');
			$this->form_validation->set_rules('katasandi', 'Katasandi', 'required|trim');
			if ($this->form_validation->run() == false) {
				$data['title'] = 'Masuk Rekam Medis';
				$this->load->view('template/auth_login_header', $data);
				$this->load->view('auth/login');
				$this->load->view('template/auth_footer');
			} else {
				$this->_login();
			}
		}
	}

	private function _login()
	{
		$surel = $this->input->post('surel');
		$katasandi = $this->input->post('katasandi');

		$pengguna = $this->db->get_where('pengguna', ['surel' => $surel])->row_array();
		if ($pengguna) {
			if ($pengguna['is_active'] == 1) {
				if (password_verify($katasandi, $pengguna['katasandi'])) {
					$data = [
						'surel' => $pengguna['surel'],
						'role_id' => $pengguna['role_id']
					];
					$this->session->set_userdata($data);
					redirect('dashboard');
				} else {
					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email  atau Katasandi salah!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email yang anda masukkan belum aktifasi!</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email yang anda masukkan belum terdaftar!</div>');
			redirect('auth');
		}
	}

	public function registrasi()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('surel', 'Surel', 'required|trim|valid_email|is_unique[pengguna.surel]', ['is_unique' => 'Surel telah registrasi!']);
		$this->form_validation->set_rules('katasandi1', 'Password', 'required|trim|min_length[8]|matches[katasandi2]', ['matches' => 'Katasandi tidak sama', 'min_length' => 'Katasandi Kurang dari 8 ']);
		$this->form_validation->set_rules('katasandi2', 'Password', 'required|trim|matches[katasandi1]');


		if ($this->form_validation->run() == false) {
			$data['title'] = 'Registrasi Rekam Medis';
			$this->load->view('template/auth_header', $data);
			$this->load->view('auth/registrasi');
			$this->load->view('template/auth_footer');
		} else {
			$data = [
				'nama' => htmlspecialchars($this->input->post('nama', true)),
				'surel' => htmlspecialchars($this->input->post('surel', true)),
				'katasandi' => password_hash($this->input->post('katasandi1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1,
				'tanggal_buat' => time(),
				'gambar' => 'default.jpg'


			];

			$this->db->insert('pengguna', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Selamat Registrasi Anda berhasil. Silahkan Login!</div>');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('surel');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Anda telah logout!</div>');
		redirect('auth');
	}
}
