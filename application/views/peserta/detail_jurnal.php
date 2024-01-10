<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="card">
        <h5 class="card-header">Detail Jurnal PKL</h5>
        <div class="card-body">
          <?= $this->session->flashdata('pesan'); ?>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr class="text-nowrap">
                  <th>#</th>
                  <th>Nama Pekerjaan</th>
                  <th>Perencanaan Kegiatan</th>
                  <th>Pelaksanaan Kegiatan</th>
                  <th>Catatan Instruktur</th>
                  <th>Keterangan</th>
                  <th>
                    <div class="btn-group">
                      <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('peserta/jurnaldetailadd/' . $jurnal_id) ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                      </ul>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                // $monday_this_week = date("Y-m-d", strtotime('monday this week'));
                // $begin = new DateTime($ploating->start_date);
                // $end = new DateTime(date('Y-m-d'));

                // $interval = DateInterval::createFromDateString('1 day');
                // $period = new DatePeriod($begin, $interval, $end);
                $no = 0;
                // foreach ($period as $dt) {
                //   $date = $dt->format("Y-m-d");
                foreach ($jurnaldetail as $j) {
                  $status = $j->status;
                ?>
                  <tr>
                    <th scope="row"><?= ++$no ?></th>
                    <td><?= $j->working_name; ?></td>
                    <td><?= $j->working_plan ?></td>
                    <td><?= $j->working_goal ?></td>
                    <td><?= $j->instruktur_noted ?></td>
                    <td><?php
                        if ($status == 2) {
                        ?>
                        <button class="btn btn-sm btn-success">Diterima</button>
                      <?php
                        } else if ($status == 3) {
                      ?>
                        <button class="btn btn-sm btn-danger">Ditolak</button>
                      <?php
                        } else {
                      ?>
                        <button class="btn btn-sm btn-warning">Belum diperiksa</button>
                      <?php
                        }
                      ?>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?= base_url('peserta/jurnaldetailedit/' . $j->jurnal_detail_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                          <a class="dropdown-item" href="<?= base_url('peserta/jurnaldetailhapus/' . $j->jurnal_detail_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <a href="<?= base_url('peserta/jurnal') ?>" class="btn btn-sm btn-warning">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->