<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Pengguna_model');
        $this->load->model('Periksa_model');
        $this->load->model('Dokter_model');
        $this->load->model('Antre_model');
        $this->load->helper(array('form', 'url', 'pasien'));
    }

    function index()
    {
        if ($this->session->has_userdata('surel')) {
            $data['pengguna'] = $this->db->get_where('pengguna', ['surel' => $this->session->userdata('surel')])->row_array();
            // $data['rekammedis'] = $this->db->get('rekam_medis')->result_array();
            $data['title'] = 'Halaman Export';
            $data['dokter'] = $this->Dokter_model->get_all();

            $this->load->view('template/auth_header', $data);
            $this->load->view('pengguna/export', $data);
            $this->load->view('template/auth_modal', $data);
            $this->load->view('template/auth_footer');
        } else {
            redirect('auth');
        }
    }

    function exportExcel()
    {
        $this->form_validation->set_rules('dokter', 'Dokter', 'trim');
        $this->form_validation->set_rules('month', 'month', 'required|trim', ['required' => 'Lengkapi kolom ini!']);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('export', '<div class="alert alert-danger" role="alert">Gagal mengunduh laporan</div>');
            redirect('export');
        }
        $month = date("m", strtotime($this->input->post('month', true)));
        $year = date("Y", strtotime($this->input->post('month', true)));
        $dokter = $this->input->post('dokter', true);
        $nama_dokter['nama_dokter'] = 'Semua Dokter';
        if ($dokter) {
            $nama_dokter = $this->Dokter_model->get_by_id($dokter);
        }
        $title_file = 'Laporan Pasien ' . $nama_dokter['nama_dokter'] . ' Bulan ' . $month . ' Tahun ' . $year . ' Klinik Kolbu';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_header = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ]
        ];

        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', $title_file); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "Tanggal"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "Waktu"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "Nama Dokter"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "Nomor RM"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F3', "Nama Pasien"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "Umur"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "Jenis Kelamin"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "Pasien Status"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "Alamat"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K3', "Diagnosa"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('L3', "Total Tindakan"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('M3', "Total Biaya");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A1')->applyFromArray($style_header);
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $periksa = $this->Periksa_model->get_all_riwayat($month, $year, $dokter);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        if (!empty($periksa)) {
            foreach ($periksa as $item) { // Lakukan looping pada variabel siswa
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, date("d F Y", strtotime($item->created_at)));
                $sheet->setCellValue('C' . $numrow, date("H:i", strtotime($item->created_at)));
                $sheet->setCellValue('D' . $numrow, $item->nama_dokter);
                $sheet->setCellValue('E' . $numrow, $item->nomor_rm);
                $sheet->setCellValue('F' . $numrow, $item->nama_pasien);
                $sheet->setCellValue('G' . $numrow, count_age($item->tanggal_lahir));
                $sheet->setCellValue('H' . $numrow, $item->jenis_kelamin);
                $sheet->setCellValue('I' . $numrow, check_pasien_status($item->rekam_medis_created_at));
                $sheet->setCellValue('J' . $numrow, $item->alamat);
                $sheet->setCellValue('K' . $numrow, $item->diagnosa);
                $sheet->setCellValue('L' . $numrow, $item->total_tindakan);
                $sheet->setCellValue('M' . $numrow, $item->total_biaya);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
                $sheet->getStyle('M' . $numrow)->applyFromArray($style_row);

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping
            }
        } else {
            $sheet->setCellValue('A4', "Tidak Ada Data Pada Bulan $month Tahun $year"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A4:N4'); // Set Merge Cell pada kolom A1 sampai E1
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(10); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(25); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(35); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(50); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Pasien");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $title_file . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
