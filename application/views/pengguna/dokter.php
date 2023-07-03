<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dokter</h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modalAddDokter"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokter</button>
    </div>
    <?php echo validation_errors(); ?>
    <?= $this->session->flashdata('dokter'); ?>


    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Dokter Klinik Kolbu</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                            <a class="dropdown-item" href="<?= base_url('pengguna/tambahDokter') ?>">Tambah Baru</a>
                            <!-- <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a> -->
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="ui celled table table-sm table-hover display single line striped" id="" width="100%" cellspacing="1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Total Periksa</th>
                                    <th>Total Tindakan</th>
                                    <th>Total Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dokter as $key => $item) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $item->nama_dokter ?></td>
                                        <td><?= $item->periksa_count ?></td>
                                        <td><?= $item->tindakan_count ?></td>
                                        <td>Rp <?= number_format($item->tindakan_sum_biaya) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>