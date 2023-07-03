<?php

class Dokter_model extends CI_Model
{
    protected $table = 'dokter';

    function get_all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function count_all_periksa($lastMonth = null, $currentYear = null)
    {

        $this->db->select('dokter.*, COALESCE(periksa_counts.periksa_count, 0) AS periksa_count, COALESCE(tindakan_counts.tindakan_count, 0) AS tindakan_count, COALESCE(tindakan_counts.tindakan_sum_biaya, 0) AS tindakan_sum_biaya');
        $this->db->from($this->table);
        $this->db->join('(SELECT id_dokter, COUNT(id) AS periksa_count FROM periksa WHERE MONTH(created_at) = ' . $lastMonth . ' AND YEAR(created_at) = ' . $currentYear . ' GROUP BY id_dokter) AS periksa_counts', 'periksa_counts.id_dokter = dokter.id', 'left');
        $this->db->join('(SELECT periksa.id_dokter, COUNT(tindakan.id) AS tindakan_count, SUM(tindakan.biaya) AS tindakan_sum_biaya FROM periksa LEFT JOIN tindakan ON tindakan.id_periksa = periksa.id WHERE MONTH(periksa.created_at) = ' . $lastMonth . ' AND YEAR(periksa.created_at) = ' . $currentYear . ' GROUP BY periksa.id_dokter) AS tindakan_counts', 'tindakan_counts.id_dokter = dokter.id', 'left');
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
        $query = $this->db->get_where($this->table, $data);
        $count = $query->num_rows();  //counting result from query
        if ($count === 0) {
            return true;
        }
        return false;
    }
}
