<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="card">
        <h5 class="card-header">Jurnal PKL</h5>
        <div class="card-body">
          <?= $this->session->flashdata('pesan'); ?>
          <div class="table-responsive text-nowrap">
            <table class="table table-borderless" id="example">
              <thead>
                <tr class="text-nowrap">
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Dudika</th>
                  <th>Unit Kerja/Pekerjaan</th>
                  <th>Catatan</th>
                  <th>
                    <div class="btn-group">
                      <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('peserta/jurnaladd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
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
                foreach ($jurnal as $j) {
                ?>
                  <tr>
                    <th scope="row"><?= ++$no ?></th>
                    <td><?= date_indo($j->jurnal_date); ?></td>
                    <td><?= $j->dudika ?></td>
                    <td><?= $j->division ?></td>
                    <td><a href="<?= base_url('peserta/jurnaldetail/' . $j->jurnal_id) ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?= base_url('peserta/jurnaledit/' . $j->jurnal_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                          <a class="dropdown-item" href="<?= base_url('peserta/jurnalhapus/' . $j->jurnal_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->