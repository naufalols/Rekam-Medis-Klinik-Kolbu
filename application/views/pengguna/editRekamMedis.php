<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="form-row">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Data Rekam Medis</h1>
    <?= $this->session->flashdata('pesan_registrasi'); ?>
  </div>

  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('pengguna') ?>">Pasien</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit data Pasien</li>
    </ol>
  </nav>
  <!-- /Breadcrumb -->
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <form method="post" action="<?= base_url('pengguna/editRekamMedis'); ?>">
        <div class="form-row">
          <div class="form-group col-md-3">
            <label>Nomor Rekam Medis</label>
            <input type="number" class="form-control " id="nomorrm" name="nomorrm" value="<?= (empty($rekammedis['nomor_rm'])) ? set_value('nomorrm') : $rekammedis['nomor_rm'] ?>">
            <input type="hidden" class="form-control " id="id" name="id" value="<?= (empty($rekammedis['id'])) ? set_value('id') : $rekammedis['id'] ?>">
            <?= form_error('nomorrm', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Nama</label>
            <input type="text" style="text-transform: uppercase;" class="form-control" id="nama" name="nama" value="<?= (empty($rekammedis['nama'])) ? set_value('nama') : $rekammedis['nama'] ?>">
            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" style="text-transform: uppercase;">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="L" <?= ((empty($rekammedis['jenis_kelamin']) ? set_value('jenis_kelamin') : $rekammedis['jenis_kelamin']) == 'L') ? 'selected' : '' ?>>Laki-laki</option>
              <option value="P" <?= ((empty($rekammedis['jenis_kelamin']) ? set_value('jenis_kelamin') : $rekammedis['jenis_kelamin']) == 'P') ? 'selected' : '' ?>>Perempuan</option>
            </select> <?= form_error('jenis_kelamin', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= (empty($rekammedis['tanggal_lahir'])) ? set_value('tanggal_lahir') : $rekammedis['tanggal_lahir'] ?>">
            <?= form_error('tanggal_lahir', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Nomor KTP</label>
            <input type="text" class="form-control" id="nomorktp" name="nomorktp" value="<?= (empty($rekammedis['nomor_ktp'])) ? set_value('nomorktp') : $rekammedis['nomor_ktp'] ?>">
            <?= form_error('nomorktp', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Nomor Telpon</label>
            <input type="number" style="text-transform: uppercase;" class="form-control" name="nomor_hp" id="" value="<?= (empty($rekammedis['nomor_hp'])) ? set_value('nomor_hp') : $rekammedis['nomor_hp'] ?>">
            <?= form_error('nomor_hp', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Pekerjaan</label>
            <input type="text" style="text-transform: uppercase;" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= (empty($rekammedis['pekerjaan'])) ? set_value('pekerjaan') : $rekammedis['pekerjaan'] ?>">
            <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Alamat</label>
            <textarea type="text" style="text-transform: uppercase;" class="form-control" name="alamat" id="inputAddress"><?= (empty($rekammedis['alamat'])) ? set_value('alamat') : $rekammedis['alamat'] ?></textarea>
            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Kabupaten / Kota</label>
            <select id="kabupaten" style="text-transform: uppercase" class="form-control" name="kabupaten" required>
              <?php
              foreach ($lokasi_kabupaten as $data) : ?>
                <option value="<?= $data['lokasi_ID'] ?>" <?= ((empty($rekammedis['kabupaten_kota']) ? set_value('kabupaten') : $rekammedis['kabupaten_kota']) == $data['lokasi_ID']) ? 'selected' : '' ?>><?= $data['lokasi_nama'] ?></option>";
              <?php endforeach; ?>
            </select>
            <?= form_error('kabupaten', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-6">
            <label>Kecamatan</label>
            <!--  <select id="kecamatan" class="form-control" name="kecamatan" required>
                      <option selected>Pilih Kecamatan</option>
                      <option>...</option>
                    </select> -->
            <input type="text" style="text-transform: uppercase" class="form-control" id="kecamatan" name="kecamatan" value="<?= (empty($rekammedis['kecamatan'])) ? set_value('kecamatan') : $rekammedis['kecamatan'] ?>">
            <?= form_error('kecamatan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Kelurahan</label>
            <!-- <select id="kelurahan" class="form-control" name="kelurahan" required>
                      <option selected>Pilih Kelurahan</option>
                      <option>...</option>
                    </select> -->
            <input type="text" style="text-transform: uppercase" class="form-control" id="kelurahan" name="kelurahan" value="<?= (empty($rekammedis['kelurahan'])) ? set_value('kelurahan') : $rekammedis['kelurahan'] ?>">
            <?= form_error('kelurahan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-6">
            <label>Dusun</label>
            <input type="text" style="text-transform: uppercase" class="form-control" id="dusun" name="dusun" value="<?= (empty($rekammedis['dusun'])) ? set_value('dusun') : $rekammedis['dusun'] ?>">
            <?= form_error('dusun', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Rekam Medis Kolbu 2019</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Keluar??</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Pilih "Logout" di bawah jika anda ingin keluar.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>