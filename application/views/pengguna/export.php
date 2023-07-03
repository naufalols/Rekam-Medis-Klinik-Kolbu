<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Export Laporan Periksa</h1>
    </div>
    <?php echo validation_errors(); ?>
    <?= $this->session->flashdata('export'); ?>


    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opsi:</div>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <form action="<?= base_url('export/exportExcel') ?>" method="post" id="formExport">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Dokter</label>
                            <select class="form-control" name="dokter" id="">
                                <option value="">Semua Dokter</option>
                                <?php foreach ($dokter as $item) : ?>
                                    <option value="<?= $item->id ?>"><?= $item->nama_dokter ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Tanggal</label>
                                <input type="month" name="month" id="month" class="form-control" required>
                            </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">Unduh</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>