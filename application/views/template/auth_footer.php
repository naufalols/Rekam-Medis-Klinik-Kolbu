  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('asset/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('asset/'); ?>js/sb-admin-2.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('vendor/'); ?>DataTables/datatables.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#dataTableRM').DataTable({
        "deferRender": true,
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "dom": "flrtpi",

        "oLanguage": {
          "sSearch": "Search:",
          "sLoadingRecords": "Please wait - loading...",
          "sProcessing": "Please wait - loading..."

        },
        "order": [],

        "ajax": {
          "url": "<?php echo base_url('pengguna/get_data_user') ?>",
          "type": "POST"
        },


        "columnDefs": [{
            "render": editButton,
            "targets": [7],
            "data": null,
            "orderable": false,
            // "defaultContent": '<button class="btn btn-primary">Edit</button><button class="btn btn-danger">Delete</button>',
            "defaultContent": '<button class="btn btn-sm btn-primary">Edit</button>',
          },
          {
            "render": deleteButton,
            "targets": [8],
            "data": null,
            "orderable": false,
            "defaultContent": '<button class="btn btn-sm btn-danger">Hapus</button>',
          },
          {
            "render": detailButton,
            "targets": [6],
            "data": null,
            "orderable": false,
            "defaultContent": '<button class="btn btn-sm btn-danger">Hapus</button>',
          },
        ],




      });

      var tableDashboard = $('#dataTableRMdashboard').DataTable({
        "deferRender": true,
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "dom": "ftp",

        "oLanguage": {
          "sSearch": "Search:",
          "sLoadingRecords": "Please wait - loading...",
          "sProcessing": "Please wait - loading..."

        },

        "ajax": {
          "url": "<?php echo base_url('dashboard/get_data_rm') ?>",
          "type": "POST"
        },


        "columnDefs": [{
          "render": actionButton,
          "targets": [3],
          "data": null,
          "orderable": false,
        }, ],
      });

      $('#search_header').on('keyup', function() {
        tableDashboard.search(this.value).draw();
      });
    });

    $('#dataTablePeriksa').DataTable({
      "deferRender": true,
      "stateSave": true,
      "processing": true,
      "serverSide": true,
      "dom": "lrtpi",

      "oLanguage": {
        "sSearch": "Search:",
        "sLoadingRecords": "Please wait - loading...",
        "sProcessing": "Please wait - loading..."

      },
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('periksa/get_data_periksa') ?>",
        "type": "POST"
      },
    });

    function actionButton(full) {
      var link = '<?= base_url("antrean/store/") ?>';
      return '<a href="' + link + full[3] + '" class="btn btn-primary btn-sm float-right">Tambahkan</a>&nbsp;<button onclick="detailPasien(' + full[3] + ')" class="btn btn-secondary btn-sm float-right">Detail</button>';
    }

    function addButton(full) {
      var link = '<?= base_url("pengguna/auth_edit_rekammedis/") ?>';
      return '<a href="' + link + full[3] + '" class="btn btn-primary btn-sm float-right">Tambahkan</a>';
    }

    function detailButton(full) {
      var link = '<?= base_url("pengguna/detailPengguna/") ?>';
      return '<a href="' + link + full[6] + '" class="btn btn-secondary btn-sm rounded-circle border-0"><i class="fa fa-fw fa-eye"></i></a>';
    }

    function editButton(full) {
      var link = '<?= base_url("pengguna/auth_edit_rekammedis/") ?>';
      return '<a href="' + link + full[6] + '" class="btn btn-primary btn-sm rounded-circle border-0"><i class="fa fa-fw fa-pencil-alt"></i></a>';
    }

    function deleteButton(full) {
      var link = '<?= base_url("pengguna/hapusRekamMedis/") ?>' + full[6];
      link = "'" + link + "'";
      var title = full[2];
      title = "'" + title + "'";
      return '<a href="javascript:void(0)" onClick="confirm_modal(' + link + ',' + title + ')" class="btn btn-danger btn-sm rounded-circle border-0"><i class="fas fa-fw fa-trash"></i></a>';
    }
  </script>

  <script>
    $('#dataTableRM tbody').on('click', 'button', function() {
      alert('mantap');
    })
  </script>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
  <script>
    function confirm_modal(delete_url, title) {
      jQuery('#modaldeleterekammedis').modal('show', {
        backdrop: 'static',
        keyboard: false
      });
      jQuery("#modaldeleterekammedis .grt").text(title);
      document.getElementById('delete_link_m_n').setAttribute("href", delete_url);
      document.getElementById('delete_link_m_n').focus();
    }
  </script>
  <script>
    function idpasien() {
      var a = document.getElementById('idpasien').value;
      var link = '<?= base_url("pengguna/auth_edit_rekammedis/") ?>'
      document.getElementById('disini').setAttribute("href", link + a);
    }
  </script>

  <script>
    function periksa(rekam_medis_id, antre_id) {
      $.ajax({
        url: '<?= base_url('periksa/get_rekammedis/') ?>' + rekam_medis_id,
        type: 'get',
        dataType: 'JSON',
        success: function(res) {
          $('#dataPasien li:first').html('Nama Pasien: <b>' + res.nama + '</b>');
          $('#dataPasien li:eq(1)').html('Rekam Medis: <b>' + res.nomor_rm + '</b>');
          $('#dataPasien li:eq(2)').html('Dusun: <b>' + res.dusun + '</b>');
          $('#id_rm').val(rekam_medis_id);
          $('#id_antre').val(antre_id);
          $('#modalPeriksa').modal('show', {
            backdrop: 'static',
            keyboard: false
          });
        },
        error: function(params) {
          alert('terjadi kesalahan dalam server');
        }
      });
    }

    function detailPasien(rekam_medis_id) {
      document.querySelector('#listDetailPasien li:first-child').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(2)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(3)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(4)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(5)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(6)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(7)').innerHTML = '';
      document.querySelector('#listDetailPasien li:nth-child(8)').innerHTML = '';
      $.ajax({
        url: '<?= base_url('periksa/get_rekammedis/') ?>' + rekam_medis_id,
        type: 'get',
        dataType: 'JSON',
        success: function(res) {
          console.log(res);
          document.querySelector('#listDetailPasien li:first-child').innerHTML = 'Rekam Medis: <b>' + res.nomor_rm + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(2)').innerHTML = 'Nama : <b>' + res.nama + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(3)').innerHTML = 'Alamat : <b>' + res.alamat + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(4)').innerHTML = 'Pekerjaan: <b>' + res.pekerjaan + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(5)').innerHTML = 'Dusun: <b>' + res.dusun + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(6)').innerHTML = 'Kelurahan: <b>' + res.kelurahan + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(7)').innerHTML = 'Kecamatan: <b>' + res.kecamatan + '</b>';
          document.querySelector('#listDetailPasien li:nth-child(8)').innerHTML = 'Kabupaten: <b>' + res.lokasi_nama + '</b>';
          var link_antre = '<?= base_url("antrean/store/") ?>' + rekam_medis_id;
          var link_antre = '<?= base_url("pengguna/detailPengguna/") ?>' + rekam_medis_id;
          document.querySelector('#buttonListPasienAddAntrean').href = link_antre;
          document.querySelector('#buttonListPasienDetail').href = link_antre;
          $('#modalDetailPasien').modal('show', {
            backdrop: 'static',
            keyboard: false
          });
        },
        error: function(params) {
          alert('terjadi kesalahan dalam server');
        }
      });
    }

    function addTindakan() {
      var tindakan = $('#formTindakan');
      var form = '<div class="row">' +
        '<div class="col-7">' +
        '<div class="form-group">' +
        '<label class="font-weight-bold" for="">Tindakan</label>' +
        '<input name="tindakan[]" required type="text" class="form-control" id="">' +
        '</div>' +
        '</div>' +
        '<div class="col-4">' +
        '<div class="form-group">' +
        '<label class="font-weight-bold" for="">Biaya</label>' +
        '<input name="biaya_tindakan[]" required type="number" class="form-control" id="">' +
        '</div>' +
        '</div>' +
        '<div class="col-1">' +
        '<div class="form-group">' +
        '<label class="font-weight-bold invisible" for="">Hapus</label>' +
        '<button class="btn btn-sm btn-danger" onclick="deleteRowTindakan()"><i class="fas fa-times text-light"></i></button>' +
        '</div>' +
        '</div>' +
        '</div>';
      tindakan.append(form);
    }

    function deleteRowTindakan() {
      // Get the parent row of the clicked delete button
      var row = $(event.target).closest('.row');

      // Remove the row from the DOM
      row.remove();
    }
  </script>


  </body>

  </html>