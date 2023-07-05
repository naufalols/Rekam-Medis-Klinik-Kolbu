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
                <div class="col-md-8 p-4">
                    <h6 class="d-flex align-items-center mb-3"><i class="text-primary mr-2"><?= date('d F Y, H:i', strtotime($riwayat_detail->created_at)); ?></i></h6>
                    <form action="<?= base_url('periksa/update/') . $riwayat_detail->id ?>" method="post" id="formEditPeriksa">
                        <input type="hidden" name="id_rm" id="id_rm" value="<?= $riwayat_detail->id_rm ?>">
                        <input type="hidden" name="id_periksa" id="id_periksa" value="<?= $riwayat_detail->id ?>">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="font-weight-bold">Dokter</label>
                            <select class="form-control" name="id_dokter" id="" required>
                                <?php foreach ($dokter as $item) : ?>
                                    <option value="<?= $item->id ?>" <?= ((empty($riwayat_detail->id_dokter) ? set_value('id_dokter') : $riwayat_detail->id_dokter) == $item->id) ? 'selected' : '' ?>><?= $item->nama_dokter ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="font-weight-bold">Diagnosa</label>
                            <textarea name="diagnosa" required class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $riwayat_detail->diagnosa ?></textarea>
                        </div>
                        <div class="divider" style="margin-bottom: 100px;"></div>
                        <div id="formTindakan">
                            <?php foreach ($riwayat_detail->tindakan as $item) : ?>
                                <input type="hidden" name="id_tindakan[]" value="<?= $item['id'] ?>" id="">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="">Tindakan</label>
                                            <input name="tindakan[]" type="text" value="<?= $item['tindakan'] ?>" class="form-control" id="" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="">Biaya</label>
                                            <input name="biaya_tindakan[]" type="number" value="<?= $item['tindakan_biaya'] ?>" class="form-control" id="" required>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label class="font-weight-bold invisible" for="">Hapus</label>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRowTindakan()"><i class="fas fa-times text-light"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>

                </div>
            </div>

        </div>
    </div>



</div>