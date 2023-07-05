<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Periksa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model');
        $this->load->model('Antre_model');
        $this->load->model('Periksa_model');
        $this->load->model('Dokter_model');
        $this->load->helper(array('form', 'url', 'periksa'));
    }

    function index()
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
            $data['periksa'] = $this->Pengguna_model->get_all_riwayat();
            $this->load->view('template/auth_header', $data);
            $this->load->view('pengguna/periksa', $data);
            $this->load->view('template/auth_modal', $data);
            $this->load->view('template/auth_footer');
        } else {
            redirect('auth');
        }
    }

    function get_data_periksa()
    {
        $base_url = base_url('pengguna/detailPengguna');
        $list = $this->Periksa_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $field->id;
            $row[] = date('d F Y', strtotime($field->created_at));
            $row[] = date('H:i', strtotime($field->created_at));
            $row[] = $field->nama_dokter;
            $row[] = "<a href=$base_url/$field->id_rm>$field->nomor_rm</a>";
            $row[] = "<a href=$base_url/$field->id_rm>$field->nama</a>";
            // $row[] = $field->alamat;
            $row[] = $field->diagnosa;
            $row[] = $field->tindakan;
            $row[] = 'Rp ' . number_format($field->total_biaya);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Periksa_model->count_all(),
            "recordsFiltered" => $this->Periksa_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function store()
    {
        $this->form_validation->set_rules('id_rm', 'Nomor RM', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');
        $this->form_validation->set_rules('tindakan[]', 'Tindakan', 'required');
        $this->form_validation->set_rules('biaya_tindakan[]', 'Biaya', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('periksa', '<div class="alert alert-danger" role="alert">Gagal ditambahkan ke periksa</div>');
            redirect('dashboard');
        }
        if (store_periksa($this->db)) {
            $this->session->set_flashdata('periksa', '<div class="alert alert-success" role="alert">Berhasil diperiksa</div>');
            redirect('dashboard');
        }

        redirect('dashboard');
    }

    public function edit(Int $id_rm = null, $id_periksa = null)
    {
        if ($this->session->has_userdata('surel')) {
            $data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
            $data['title'] = 'Halaman Pengguna';
            $data['pasien'] = $this->Pengguna_model->get_by_id($id_rm);
            $data['riwayat_detail'] = $this->Pengguna_model->get_new_riwayat_by_id_with_id_periksa($id_rm, $id_periksa);
            $data['dokter'] = $this->Dokter_model->get_all();
            // print_r($data['riwayat_detail']->tindakan);
            $this->load->view('template/auth_header', $data);
            $this->load->view('pengguna/editRiwayatPasien', $data);
            $this->load->view('template/auth_modal', $data);
            $this->load->view('template/auth_footer');
        } else {
            redirect('auth');
        }
    }

    public function update(Int $id = null)
    {
        $this->form_validation->set_rules('id_rm', 'Nomor RM', 'required');
        $this->form_validation->set_rules('id_periksa', 'Nomor RM', 'required');
        $this->form_validation->set_rules('id_dokter', 'Dokter', 'required');
        $this->form_validation->set_rules('diagnosa', 'Diagnosa', 'required');
        $this->form_validation->set_rules('id_tindakan[]', 'Tindakan', 'required');
        $this->form_validation->set_rules('tindakan[]', 'Tindakan', 'required');
        $this->form_validation->set_rules('biaya_tindakan[]', 'Biaya', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('periksa', '<div class="alert alert-danger" role="alert">Data diagnosa gagal diedit</div>');
            redirect('pengguna/detailPengguna/' . $_POST['id_rm']);
        }
        if (update_periksa($this->db)) {
            $this->session->set_flashdata('periksa', '<div class="alert alert-success" role="alert">Data diagnosa berhasil diedit</div>');
            redirect('pengguna/detailPengguna/' . $_POST['id_rm']);
        }

        redirect('pengguna/detailPengguna/' . $_POST['id_rm']);
    }

    public function destroy(Int $id = null)
    {
        $data = array('id_rm' => $id);
        $result = $this->Antre_model->deleterecords($data);
        if ($result > 0) {
            redirect('dashboard');
        } else {
            redirect('dashboard');
        }
    }

    function get_rekammedis($id)
    {
        $result = $this->Pengguna_model->get_by_id($id);
        echo json_encode($result);
    }
}
