<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="form-row">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Rekam Medis</h1>

    <?= $this->session->flashdata('pesan_registrasi'); ?>
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">

    <div class="card-body">
      <form method="post" action="<?= base_url('pengguna/tambahRekamMedis'); ?>">
        <div class="form-row">
          <div class="form-group col-md-3">
            <label>Nomor Rekam Medis</label>
            <input autofocus type="number" class="form-control " id="nomorrm" name="nomorrm" value="<?= set_value('nomorrm') ?>">
            <?= form_error('nomorrm', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Nama</label>
            <input type="text" style="text-transform: uppercase;" class="form-control" id="nama" name="nama" placeholder="" value="<?= set_value('nama') ?>">
            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Nomor KTP</label>
            <input type="text" class="form-control" id="nomorktp" placeholder="" name="nomorktp" value="<?= set_value('nomorktp') ?>">
            <?= form_error('nomorktp', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Tanggal Lahir</label>
            <input type="date" style="text-transform: uppercase;" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="" value="<?= set_value('tanggal_lahir') ?>">
            <?= form_error('tanggal_lahir', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Nomor Telpon</label>
            <input type="number" style="text-transform: uppercase;" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="" value="<?= set_value('nomor_hp') ?>">
            <?= form_error('nomor_hp', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
          <div class="form-group col-md-4">
            <label>Pekerjaan</label>
            <input type="text" style="text-transform: uppercase;" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="" value="<?= set_value('pekerjaan') ?>">
            <?= form_error('pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Alamat</label>
            <textarea type="text" style="text-transform: uppercase;" class="form-control" name="alamat" placeholder="" id="inputAddress"><?= set_value('alamat') ?></textarea>
            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
          </div>
        </div>


        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Kabupaten / Kota</label>
            <select id="kabupaten" style="text-transform: uppercase" class="form-control" name="kabupaten" required>
              <option selected>Pilih Kabupaten Kota...</option>
              <?php
              foreach ($lokasi_kabupaten as $data) : ?>
                <option value="<?= $data['lokasi_ID'] ?>"><?= $data['lokasi_nama'] ?></option>";

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
            <input type="text" style="text-transform: uppercase" class="form-control" id="kecamatan" name="kecamatan" placeholder="" value="<?= set_value('kecamatan') ?>">
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
            <input type="text" style="text-transform: uppercase" class="form-control" id="kelurahan" name="kelurahan" placeholder="" value="<?= set_value('kelurahan') ?>">
            <?= form_error('kelurahan', '<small class="text-danger pl-3">', '</small>'); ?>

          </div>
          <div class="form-group col-md-6">
            <label>Dusun</label>
            <input type="text" style="text-transform: uppercase" class="form-control" id="dusun" name="dusun" placeholder="" value="<?= set_value('dusun') ?>">
            <?= form_error('dusun', '<small class="text-danger pl-3">', '</small>'); ?>

          </div>
        </div>

        <button type="submit" class="btn btn-primary">Tambahkan</button>
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