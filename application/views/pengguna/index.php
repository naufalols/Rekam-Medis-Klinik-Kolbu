<!-- Begin Page Content -->
<div class="container-fluid">


  <div class="form-row">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tabel data Rekam Medis Kolbu</h1> &nbsp;

    <?= $this->session->flashdata('pesan_registrasi'); ?>
  </div>
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="main-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pasien</li>
    </ol>
  </nav>
  <!-- /Breadcrumb -->
  <!-- DataTales Example -->
  <div class="card shadow mb-4">

    <div class="card-body">
      <div class="table-responsive">
        <table class="ui celled table table-sm table-hover display single line striped" id="dataTableRM" width="100%" cellspacing="1">
          <thead>
            <tr>
              <th>No</th>
              <th>RM</th>
              <th>Nama</th>
              <th>Pekerjaan</th>
              <th>Dusun</th>
              <th>Kelurahan</th>
              <th> </th>
              <th> </th>
              <th> </th>
            </tr>
          </thead>

        </table>
      </div>
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