<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Periksa</h1>
    </div>
    <?php echo validation_errors(); ?>
    <?= $this->session->flashdata('periksa'); ?>
    <!-- Content Row -->

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Periksa</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('pengguna/tambahRekamMedis') ?>">Tambah Baru</a>
                            <!-- <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a> -->
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="ui celled table table-sm table-hover display single line striped" id="dataTablePeriksa" width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pukul</th>
                                    <th>Nama Dokter</th>
                                    <th>RM</th>
                                    <th>Nama Pasien</th>
                                    <!-- <th>Alamat</th> -->
                                    <th>Diagnosa</th>
                                    <th>Tindakan</th>
                                    <th>Total Biaya</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>