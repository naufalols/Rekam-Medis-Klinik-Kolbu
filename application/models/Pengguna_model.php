<?php

/**
 * 
 */
class Pengguna_model extends CI_Model
{
	var $table = 'rekam_medis'; //nama tabel dari database
	var $column_order = array(null, 'nomor_rm', 'nama', 'alamat', 'pekerjaan', 'dusun', 'kelurahan'); //field yang ada di table user
	var $column_search = array('nomor_rm', 'nama', 'alamat', 'dusun', 'kelurahan'); //field yang diizin untuk pencarian 
	var $order = array('nomor_rm' => 'asc'); // default order 

	function __construct()
	{
		parent::__construct();
	}

	public function getAllRM()
	{
		$this->datatables->select('nomor_rm,nama,alamat,pekerjaan,tanggal_buat');
		$this->datatables->from('rekam_medis');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-xs" data-kode="$1" data-nama="$2" data-harga="$3" data-kategori="$4">Edit</a>  <a href="javascript:void(0);" class="hapus_record btn btn-danger btn-xs" data-kode="$1">Hapus</a>', 'barang_kode,barang_nama,barang_harga,kategori_id,kategori_nama');
		return $this->datatables->generate();
	}

	private function _get_datatables_query()
	{

		$this->db->from($this->table);

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

	function get_by_id($id)
	{
		$this->db->select('rekam_medis.*, inf_lokasi.lokasi_nama');
		$this->db->from($this->table);
		$this->db->join('inf_lokasi', 'inf_lokasi.lokasi_ID = rekam_medis.kabupaten_kota', 'left');
		$this->db->where('rekam_medis.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function check_new_pasien($id)
	{
		$userID = $id;
		$currentMonth = date('m');
		$output = '';
		$this->db->select('id, nama, tanggal_buat');
		$this->db->from('rekam_medis');
		$this->db->where("id", $userID);
		$this->db->where("MONTH(FROM_UNIXTIME(tanggal_buat)) != $currentMonth");
		$this->db->where_not_in('id', function ($subquery) {
			$subquery->select('id_rm');
			$subquery->from('periksa');
			$subquery->where('id_rm IS NOT NULL', NULL, FALSE);
		});
		$query = $this->db->get();
		$result = $query->row();

		if ($result) {
			$user = new stdClass();
			$user->id = $result->id;
			$user->nama = $result->nama;
			$user->tanggal_buat = date('d F Y', strtotime($result->tanggal_buat));

			// Determine if the user is old or new
			$user->status = (strtotime($result->tanggal_buat) < strtotime(date('Y-m-01'))) ? 'Lama' : 'Baru';

			$output = (strtotime($result->tanggal_buat) < strtotime(date('Y-m-01'))) ? 'Lama' : 'Baru';
		}

		return $output;
	}

	function get_riwayat_by_id($id)
	{
		$this->db->select('periksa.*, tindakan.tindakan, tindakan.tindakan_biaya, dokter.nama_dokter');
		$this->db->from('periksa');
		$this->db->join(
			'(SELECT id_periksa, GROUP_CONCAT(nama) AS tindakan, GROUP_CONCAT(biaya) AS tindakan_biaya FROM tindakan GROUP BY id_periksa) tindakan',
			'tindakan.id_periksa = periksa.id'
		);
		$this->db->join('dokter', 'dokter.id = periksa.id_dokter');
		$query = $this->db->get();
		return $query->result();
	}

	function get_new_riwayat_by_id($id)
	{
		$this->db->select('periksa.*, tindakan.tindakan, tindakan.tindakan_biaya, dokter.nama_dokter');
		$this->db->from('periksa');
		$this->db->join(
			'(SELECT id_periksa, GROUP_CONCAT(nama) AS tindakan, GROUP_CONCAT(biaya) AS tindakan_biaya FROM tindakan GROUP BY id_periksa) tindakan',
			'tindakan.id_periksa = periksa.id',
		);
		$this->db->join('dokter', 'dokter.id = periksa.id_dokter');
		$this->db->join('rekam_medis', 'rekam_medis.id = periksa.id_rm');
		$this->db->where('id_rm', $id);
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
			$obj->id_dokter = $row->id_dokter;
			$obj->diagnosa = $row->diagnosa;
			$obj->deskripsi = $row->deskripsi;
			$obj->created_at = $row->created_at;
			$obj->updated_at = $row->updated_at;
			$obj->tindakan = $tindakan;
			$obj->nama_dokter = $row->nama_dokter;

			$output[] = $obj;
		}

		// Convert the output array to an object
		return $output;
	}

	function get_all_riwayat()
	{
		$this->db->select('periksa.*, tindakan.tindakan, tindakan.tindakan_biaya, dokter.nama_dokter');
		$this->db->from('periksa');
		$this->db->join(
			'(SELECT id_periksa, GROUP_CONCAT(nama) AS tindakan, GROUP_CONCAT(biaya) AS tindakan_biaya FROM tindakan GROUP BY id_periksa) tindakan',
			'tindakan.id_periksa = periksa.id',
		);
		$this->db->join('dokter', 'dokter.id = periksa.id_dokter');
		$this->db->join('rekam_medis', 'rekam_medis.id = periksa.id_rm');
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
			$obj->id_dokter = $row->id_dokter;
			$obj->diagnosa = $row->diagnosa;
			$obj->deskripsi = $row->deskripsi;
			$obj->created_at = $row->created_at;
			$obj->updated_at = $row->updated_at;
			$obj->tindakan = $tindakan;
			$obj->nama_dokter = $row->nama_dokter;

			$output[] = $obj;
		}

		// Convert the output array to an object
		return $output;
	}
}
