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

<!-- (Delete Modal)-->
<div class="modal fade" id="modaldeleterekammedis" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">

      <div class="modal-header">
        <h4 class="modal-title" style="text-align:center;">Anda yakin menghapus data <span class="grt"></span> ?</h4>

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <span id="preloader-delete"></span>
        </br>
        <a class="btn btn-danger" id="delete_link_m_n" href="">Delete</a>
        <button type="button" class="btn btn-info" data-dismiss="modal" id="delete_cancel_link">Cancel</button>

      </div>
    </div>
  </div>
</div>

<!-- edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">masukkan nomor ID pasien </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <input id="idpasien" class="form-control" type="number" min="1" value="" oninput="idpasien()">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <a id="disini" class="btn btn-primary" href="#">Sunting</a>
      </div>
    </div>
  </div>
</div>

<!-- modal add data periksa -->
<div class="modal fade bd-example-modal-lg" id="modalPeriksa" tabindex="-1" role="dialog" aria-labelledby="modalPeriksa" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Periksa Pasien</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush mb-3" id="dataPasien">
          <li class="list-group-item">Nama Pasien : </li>
          <li class="list-group-item">Rekam Medis : </li>
          <li class="list-group-item">Dusun : </li>
        </ul>

        <form action="<?= base_url('periksa/store') ?>" method="post" id="formPeriksa">
          <input type="hidden" name="id_rm" id="id_rm" value="">
          <input type="hidden" name="id_antre" id="id_antre" value="">
          <div class="form-group">
            <label for="exampleFormControlTextarea1" class="font-weight-bold">Dokter</label>
            <select class="form-control" name="id_dokter" id="" required>
              <?php foreach ($dokter as $item) : ?>
                <option value="<?= $item->id ?>"><?= $item->nama_dokter ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1" class="font-weight-bold">Diagnosa</label>
            <textarea name="diagnosa" required class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <button type="button" class="btn btn-sm btn-primary float-right" onclick="addTindakan()">Tindakan +</button>
          <div class="divider" style="margin-bottom: 100px;"></div>
          <div id="formTindakan">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  <label class="font-weight-bold" for="">Tindakan</label>
                  <input name="tindakan[]" type="text" class="form-control" id="" required>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label class="font-weight-bold" for="">Biaya</label>
                  <input name="biaya_tindakan[]" type="number" class="form-control" id="" required>
                </div>
              </div>
              <div class="col-1">
                <div class="form-group">
                  <label class="font-weight-bold invisible" for="">Hapus</label>
                  <button type="button" class="btn btn-sm btn-danger" onclick="deleteRowTindakan()"><i class="fas fa-times text-light"></i></button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <button type="submit" form="formPeriksa" id="disini" class="btn btn-primary" href="#">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- modal add dokter -->
<div class="modal fade bd-example-modal-lg" id="modalAddDokter" tabindex="-1" role="dialog" aria-labelledby="modalAddDokter" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Tambah Dokter</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="<?= base_url('dokter/store') ?>" method="post" id="formAddDokter">
          <div class="form-group">
            <label for="exampleFormControlTextarea1" class="font-weight-bold">Nama Dokter</label>
            <input type="text" class="form-control" name="nama_dokter" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <button type="submit" form="formAddDokter" id="disini" class="btn btn-primary" href="#">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- modal detail pasien -->
<div class="modal fade bd-example-modal-lg" id="modalDetailPasien" tabindex="-1" role="dialog" aria-labelledby="modalDetailPasien" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pasien</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

        <ul class="list-group" id="listDetailPasien">
          <li class="list-group-item">Rekam Medis: </li>
          <li class="list-group-item">Nama: </li>
          <li class="list-group-item">Alamat: </li>
          <li class="list-group-item">Pekerjaan: </li>
          <li class="list-group-item">Dusun: </li>
          <li class="list-group-item">Kelurahan: </li>
          <li class="list-group-item">Kecamatan: </li>
          <li class="list-group-item">Kabupaten: </li>
          <li class="list-group-item">Riwayat: <a class="btn btn-sm btn-secondary" href="#" id="buttonListPasienDetail">Lihat riwayat lengkap</a></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
        <a class="btn btn-primary" id="buttonListPasienAddAntrean" href="#">Tambahkan ke Antrean</a>
      </div>
    </div>
  </div>
</div>