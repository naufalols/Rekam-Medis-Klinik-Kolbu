<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrean extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model');
        $this->load->model('Antre_model');
        $this->load->helper(array('form', 'url'));
    }

    function index()
    {
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
    public function store($id)
    {
        $data = array(
            'id_rm' => $id,
            'created_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "created_at" value
            'updated_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "updated_at" value
        );
        $result = $this->Antre_model->saverecords($data);
        if ($result > 0) {
            $this->session->set_flashdata('antrean', '<div class="alert alert-success" role="alert">Berhasil ditambahkan ke antrean</div>');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('antrean', '<div class="alert alert-danger" role="alert">Gagal ditambahkan ke antrean</div>');
            redirect('dashboard');
        }
    }

    public function update(Int $id = null)
    {
        # code...
    }

    public function destroy(Int $id = null)
    {
        $data = array('id' => $id);
        $result = $this->Antre_model->deleterecords($data);
        if ($result > 0) {
            redirect('dashboard');
        } else {
            redirect('dashboard');
        }
    }
}
