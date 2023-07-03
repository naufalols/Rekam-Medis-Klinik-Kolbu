<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pasien</h1>
    </div>
    <?php echo validation_errors(); ?>
    <?= $this->session->flashdata('dokter'); ?>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('pengguna') ?>">Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Pasien</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->
    <div class="container-fluid p-0">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="<?= base_url('asset/img/avatar.png') ?>" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?= $pasien->nama ?></h4>
                                    <p class="text-secondary mb-1">RM <?= $pasien->nomor_rm ?></p>
                                    <p class="text-muted font-size-sm">Registrasi <?= date('d F Y', $pasien->tanggal_buat); ?></p>
                                    <!-- <button class="btn btn-primary">Follow</button>
                                    <button class="btn btn-outline-primary">Message</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Nama</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->nama ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">RM</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->nomor_rm ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">KTP</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->nomor_ktp ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Tgl Lahir</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->tanggal_lahir ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Jenis Kelamin</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->jenis_kelamin ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Telpon</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->nomor_hp ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Pekerjaan</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->pekerjaan ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Alamat</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->alamat ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Dusun</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->dusun ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Kelurahan</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->kelurahan ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Kecamatan</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->kecamatan ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="mb-0">Kabupaten</h6>
                                </div>
                                <div class="col-sm-8 text-secondary">
                                    <?= $pasien->lokasi_nama ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn btn-primary " target="__blank" href="<?= base_url('pengguna/auth_edit_rekammedis/') . $pasien->id ?>">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <?php if (!empty($riwayat)) : foreach ($riwayat as $item) : ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="d-flex align-items-center mb-3"><i class="text-primary mr-2"><?= date('d F Y, H:i', strtotime($item->created_at)); ?></i></h6>
                                    <small>Dokter</small>
                                    <p>
                                        <?= $item->nama_dokter ?>
                                    </p>
                                    <small>Diagnosa</small>
                                    <p>
                                        <?= $item->diagnosa ?>
                                    </p>

                                    <?php foreach ($item->tindakan as $key => $item_tindakan) : ?>
                                        <small>Tindakan <?= ++$key ?></small>
                                        <p>
                                            <?= $item_tindakan['tindakan'] ?> =
                                            Rp <?= number_format($item_tindakan['tindakan_biaya']) ?>
                                        </p>

                                    <?php endforeach ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-center p-5 bg-white">Belum ada riwayat</p>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>



</div>