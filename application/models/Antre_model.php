<?php

class Antre_model extends CI_Model
{
    protected $table = 'antre';

    function get_all()
    {
        $this->db->select('antre.id as antre_id, rekam_medis.id as rekam_medis_id, rekam_medis.nomor_rm, rekam_medis.nama, rekam_medis.dusun');
        $this->db->from($this->table);
        $this->db->join('rekam_medis', 'rekam_medis.id = antre.id_rm');
        $query = $this->db->get();
        return $query->result();
    }

    function saverecords($data)
    {
        if ($this->check($data)) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
        return false;
    }

    function deleterecords($data)
    {
        $result = $this->db->delete($this->table, $data);
        return $result;
    }

    function check($data)
    {
        $query = null;  //emptying in case 
        $query = $this->db->get_where($this->table, array('id_rm' => $data['id_rm']));
        $count = $query->num_rows();  //counting result from query
        if ($count === 0) {
            return true;
        }
        return false;
    }
}
