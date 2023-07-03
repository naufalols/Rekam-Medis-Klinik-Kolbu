

<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('pengguna/');?>">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Pengguna <sup>:)</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">




    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Menu
    </div>

    <!-- Nav Item - Pages Collapse Menu -->


    <!-- Nav Item - Charts -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('pengguna/');?>">
        <i class="fas fa-fw fa-search"></i>
        <span>Cari Data</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('pengguna/tambahRekamMedis');?>">
          <i class="fas fa-fw fa-plus-square"></i>
          <span>Tambahkan Data</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>



            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

              <!-- Nav Item - Search Dropdown (Visible Only XS) -->
              <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                  <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </li>




              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $pengguna['nama']; ?></span>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                  </a>
                </div>
              </li>

            </ul>

          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">


            <div class="form-row">
              <!-- Page Heading -->
              <h1 class="h3 mb-2 text-gray-800">Tabel data Rekam Medis Kolbu</h1> &nbsp;

              <?= $this->session->flashdata('pesan_registrasi'); ?>
            </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">

              <div class="card-body">
                <div class="table-responsive">
                  <table class="display nowrap" id="dataTableRM" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No RM</th>
                        <th>Nama</th>
                        <!-- <th>Pekerjaan</th>
                        <th>Alamat</th> -->
                        <th>Dusun</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach( $rekammedis as $row): ?>
                      <tr>
                        <td style="text-transform: capitalize;"><?= $row['nomor_rm']; ?></td>
                        <td><?= $row['nama']; ?></td>
                       <!--  <td><?= $row['pekerjaan']; ?></td>
                        <td><?= $row['alamat']; ?></td> -->
                        <td><?= $row['dusun']; ?></td>
                        <td align="center"> 
                          <form  method="post">
                            <input type="hidden" name="idpasien" value="<?= $row['id']; ?>">
                            <input type="hidden" name="kabupaten" value="<?= $row['kabupaten_kota']; ?>">
                            <div class="">
                              <div class="btn-group btn-group-sm">
                                <div data-toggle="tooltip" data-placement="left" title="Sunting!">
                                  <button type="submit" formaction="<?= base_url('pengguna/editRekamMedis'); ?>" class="btn btn-circle btn-primary btn-sm" >
                                    <i class="fas fa-pen"></i>
                                  </button>
                                </div>
                                <div data-toggle="tooltip" data-placement="left" title="Hapus!">
                                  <button type="button" formaction="" class="btn btn-circle btn-danger btn-sm"  data-toggle="modal" onclick="confirm_modal('<?= base_url('pengguna/hapusRekamMedis/'.$row['id']); ?>','<?= $row['nama']; ?>');" data-target="#myModal">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
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

    
   


