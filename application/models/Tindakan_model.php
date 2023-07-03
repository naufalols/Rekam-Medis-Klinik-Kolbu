<?php

class Tindakan_model extends CI_Model
{
    protected $table = 'tindakan';

    // function get_all()
    // {
    //     $this->db->select('*');
    //     $this->db->from($this->table);
    //     $this->db->join('rekam_medis', 'rekam_medis.id = tindakan.id_rm');
    //     $this->db->join('tindakan', 'tindakan.id = tindakan.id_tindakan');
    //     $this->db->join('dokter', 'dokter.id = tindakan.id_dokter');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function saverecords($data)
    {
        $this->db->insert_batch($this->table, $data);
        return $this->db->insert_id();
    }

    function deleterecords($data)
    {
        $result = $this->db->delete($this->table, $data);
        return $result;
    }

    function check($data)
    {
        $query = null;  //emptying in case 

        $query = $this->db->get_where($this->table, $data);

        $count = $query->num_rows();  //counting result from query

        if ($count === 0) {
            return true;
        }
        return false;
    }
}
