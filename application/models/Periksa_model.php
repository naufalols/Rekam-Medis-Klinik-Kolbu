<?php

class Periksa_model extends CI_Model
{
    protected $table = 'periksa';
    var $column_order = array(null, 'periksa.*', 'tindakan.tindakan', 'tindakan.tindakan_biaya', 'tindakan.total_biaya', 'rekam_medis.nama', 'rekam_medis.nomor_rm', 'rekam_medis.alamat', 'dokter.nama_dokter'); //field yang ada di table user
    var $column_search = array('nama_dokter', 'created_at', 'nomor_rm',); //field yang diizin untuk pencarian 
    var $order = array('periksa.created_at' => 'desc'); // default order 

    function get_all()
    {
        $this->db->select('periksa.*, inf_lokasi.lokasi_nama');
        $this->db->from($this->table);
        $this->db->join('rekam_medis', 'rekam_medis.id = periksa.id_rm');
        $this->db->join('inf_lokasi', 'inf_lokasi.id = rekam_medis.kabupaten_kota');
        $this->db->join('tindakan', 'tindakan.id = periksa.id_tindakan');
        $this->db->join('dokter', 'dokter.id = periksa.id_dokter');
        $query = $this->db->get();
        return $query->result();
    }

    function saverecords($data)
    {
        $this->db->insert($this->table, $data);
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

    function get_all_riwayat($month = null, $year = null, $dokter = null)
    {
        $this->db->select('periksa.*, rekam_medis.jenis_kelamin, rekam_medis.tanggal_buat AS rekam_medis_created_at, rekam_medis.nomor_rm, rekam_medis.tanggal_lahir, rekam_medis.nama AS nama_pasien, rekam_medis.alamat, tindakan.tindakan, tindakan.total_tindakan, tindakan.tindakan_biaya, tindakan.total_biaya, dokter.nama_dokter');
        $this->db->from('periksa');
        $this->db->join(
            '(SELECT id_periksa, GROUP_CONCAT(nama) AS tindakan, COUNT(id_periksa) AS total_tindakan, GROUP_CONCAT(biaya) AS tindakan_biaya, SUM(biaya) AS total_biaya FROM tindakan WHERE MONTH(created_at) = ' . $month . ' AND YEAR(created_at) = ' . $year . ' GROUP BY id_periksa) tindakan',
            'tindakan.id_periksa = periksa.id',
        );
        $this->db->join('dokter', 'dokter.id = periksa.id_dokter');
        $this->db->join('rekam_medis', 'rekam_medis.id = periksa.id_rm');
        if ($dokter) {
            $this->db->where('dokter.id = ', $dokter);
        }
        $query = $this->db->get();
        $result = $query->result();
        $output = [];
        // Process the result
        foreach ($result as $row) {
            $tindakanArr = explode(',', $row->tindakan);
            $tindakanBiayaArr = explode(',', $row->tindakan_biaya);

            // Build the tindakan array
            $tindakan = [];
            for ($i = 0; $i < count($tindakanArr); $i++) {
                $tindakan[] = [
                    'tindakan' => $tindakanArr[$i],
                    'tindakan_biaya' => $tindakanBiayaArr[$i]
                ];
            }
            // Build the final result array
            // Build the final result object
            $obj = new stdClass();
            $obj->id = $row->id;
            $obj->id_rm = $row->id_rm;
            $obj->nomor_rm = $row->nomor_rm;
            $obj->id_dokter = $row->id_dokter;
            $obj->nama_pasien = $row->nama_pasien;
            $obj->tanggal_lahir = $row->tanggal_lahir;
            $obj->jenis_kelamin = $row->jenis_kelamin;
            $obj->alamat = $row->alamat;
            $obj->diagnosa = $row->diagnosa;
            $obj->deskripsi = $row->deskripsi;
            $obj->created_at = $row->created_at;
            $obj->updated_at = $row->updated_at;
            $obj->tindakan = $tindakan; // array
            $obj->total_tindakan = $row->total_tindakan;
            $obj->total_biaya = $row->total_biaya;
            $obj->nama_dokter = $row->nama_dokter;
            $obj->rekam_medis_created_at = $row->rekam_medis_created_at;

            $output[] = $obj;
        }

        // Convert the output array to an object
        return $output;
    }

    // DataTables ===================================================================================================
    private function _get_datatables_query()
    {
        $this->db->select('periksa.*, tindakan.tindakan, tindakan.tindakan_biaya, tindakan.total_biaya, rekam_medis.nama, rekam_medis.nomor_rm, rekam_medis.alamat, dokter.nama_dokter');
        $this->db->from($this->table);
        $this->db->join(
            '(SELECT id_periksa, COUNT(id) AS tindakan, GROUP_CONCAT(biaya) AS tindakan_biaya, SUM(biaya) AS total_biaya FROM tindakan GROUP BY id_periksa) tindakan',
            'tindakan.id_periksa = periksa.id',
        );
        $this->db->join('dokter', 'dokter.id = periksa.id_dokter');
        $this->db->join('rekam_medis', 'rekam_medis.id = periksa.id_rm');

        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
