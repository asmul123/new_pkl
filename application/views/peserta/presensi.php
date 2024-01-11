<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="card">
        <h5 class="card-header">Riwayat Presensi</h5>
        <div class="card-body">
          <?= $this->session->flashdata('pesan'); ?>
          <div class="table-responsive text-nowrap">
            <table class="table table-borderless" id="example">
              <thead>
                <tr class="text-nowrap">
                  <th>#</th>
                  <th>Tanggal</th>
                  <th>Presensi Masuk</th>
                  <th>Photo Presensi Masuk</th>
                  <th>Presensi Pulang</th>
                  <th>Photo Presensi Pulang</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $monday_this_week = date("Y-m-d", strtotime('monday this week'));
                $begin = new DateTime($ploating->start_date);
                $end = new DateTime(date('Y-m-d'));
                $end->modify('+1 day');

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);
                $no = 0;
                foreach ($period as $dt) {
                  $date = $dt->format("Y-m-d");
                  $presencethisdate = $this->Presensi_model->getPresenceThisDate($ploating->ploating_id, $date);
                  $ploatingthisdate = $this->Scheme_model->getWorkingScheme($ploating->ploating_id, $date)->row();
                  if ($ploatingthisdate) {
                    $libur = explode("#", $ploatingthisdate->off_days);
                  } else {
                    $libur =  explode("#", $ploating->off_days);
                  }
                  $today = date('w', strtotime($date)) + 1;
                  if ($date < $ploating->start_date or $date > $ploating->finish_date) {
                    $pm = "<button class='btn btn-sm btn-success'>Diluar Jadwal PKL</button>";
                    $ppm = "<button class='btn btn-sm btn-success'>Diluar Jadwal PKL</button>";
                    $pp = "<button class='btn btn-sm btn-success'>Diluar Jadwal PKL</button>";
                    $ppp = "<button class='btn btn-sm btn-success'>Diluar Jadwal PKL</button>";
                    $sk = "<button class='btn btn-sm btn-success'>Diluar Jadwal PKL</button>";
                  } else if (in_array($today, $libur)) {
                    $pm = "<button class='btn btn-sm btn-danger'>Libur</button>";
                    $ppm = "<button class='btn btn-sm btn-danger'>Libur</button>";
                    $pp = "<button class='btn btn-sm btn-danger'>Libur</button>";
                    $ppp = "<button class='btn btn-sm btn-danger'>Libur</button>";
                    $sk = "<button class='btn btn-sm btn-danger'>Libur</button>";
                  } else if ($presencethisdate) {
                    $pm = $presencethisdate->started_time;
                    $ppm = "<img src='" . base_url('public/assets/img/presences/' . $presencethisdate->started_photo) . "' width='100px' />";
                    $pp = $presencethisdate->finished_time;
                    if ($pp == "00:00:00") {
                      $ppp = "-";
                    } else {
                      $ppp = "<img src='" . base_url('public/assets/img/presences/' . $presencethisdate->finished_photo) . "' width='100px' />";
                    }
                    if ($presencethisdate->status == 1) {
                      $sk = "<button class='btn btn-sm btn-warning'>Menunggu Persetujuan</button>";
                    } else if ($presencethisdate->status == 2) {
                      $sk = "<button class='btn btn-sm btn-success'>Disetujui</button>";
                    } else if ($presencethisdate->status == 3) {
                      $sk = "<button class='btn btn-sm btn-danger' 
                      data-bs-toggle='tooltip'
                      data-bs-offset='0,4'
                      data-bs-placement='top'
                      data-bs-html='true'
                      title='<span>" . $presencethisdate->reason . "</span>'>Ditolak</button>";
                    }
                  } else {
                    $pm = "-";
                    $ppm = "-";
                    $pp = "-";
                    $ppp = "-";
                    if (date('Y-m-d') <= $date) {
                      $sk = "<button class='btn btn-sm btn-primary'>Belum Melakukan Presensi</button>";
                    } else {
                      $sk = "<button class='btn btn-sm btn-info'>Tidak Melakukan Presensi</button>";
                    }
                  }
                ?>
                  <tr>
                    <th scope="row"><?= ++$no ?></th>
                    <td><?php echo longdate_indo($date); ?></td>
                    <td><?= $pm ?></td>
                    <td><?= $ppm ?></td>
                    <td><?= $pp ?></td>
                    <td><?= $ppp ?></td>
                    <td><?= $sk ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="card">
        <h5 class="card-header">Skema Presensi</h5>
        <div class="card-body">
          <?= $this->session->flashdata('pesan'); ?>
          <div class="table-responsive text-nowrap">
            <table class="table table-borderless" id="example2">
              <thead>
                <tr class="text-nowrap">
                  <th>#</th>
                  <th>Rentang Tanggal</th>
                  <th>Dudika</th>
                  <th>Waktu Masuk</th>
                  <th>Waktu Pulang</th>
                  <th>Hari Libur</th>
                  <th>Status</th>
                  <th>
                    <div class="btn-group">
                      <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('peserta/skemaadd') ?>"><i class="bx bx-plus me-1"></i> Ajukan Skema</a></li>
                      </ul>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 0;
                foreach ($allploating as $ap) {
                ?>
                  <tr>
                    <th scope="row"><?= ++$no ?></th>
                    <td><?= date_indo($ap->start_date) . " s.d. " . date_indo($ap->finish_date); ?></td>
                    <td><?= $ap->name ?></td>
                    <td><?= $ap->start_time ?></td>
                    <td><?= $ap->finish_time ?></td>
                    <td>
                      <ul>
                        <?php
                        $off_days = explode("#", $ap->off_days);
                        $count = count($off_days);
                        for ($i = 1; $i < $count; $i++) {
                          echo "<li>" . nomor_hari($off_days[$i]) . "</li>";
                        }
                        ?>
                      </ul>
                    </td>
                    <td><button class="btn btn-sm btn-info">Default</button></td>
                    <td></td>
                  </tr>
                <?php } ?>
                <?php
                foreach ($workingscheme as $ws) {
                ?>
                  <tr>
                    <th scope="row"><?= ++$no ?></th>
                    <td><?= date_indo($ws->start_date) . " s.d. " . date_indo($ws->finish_date); ?></td>
                    <td><?= $ws->name ?></td>
                    <td><?= $ws->start_time ?></td>
                    <td><?= $ws->finish_time ?></td>
                    <td>
                      <ul>
                        <?php
                        $off_days = explode("#", $ws->off_days);
                        $count = count($off_days);
                        for ($i = 1; $i < $count; $i++) {
                          echo "<li>" . nomor_hari($off_days[$i]) . "</li>";
                        }
                        ?>
                      </ul>
                    </td>
                    <td>
                      <?php
                      if ($ws->status == "1") {
                      ?>
                        <button class="btn btn-sm btn-warning">Diajukan</button>
                      <?php
                      } else if ($ws->status == "2") {
                      ?>
                        <button class="btn btn-sm btn-success">Disetujui</button>
                      <?php
                      } elseif ($ws->status == "3") {
                      ?>
                        <button class="btn btn-sm btn-danger">Ditolak</button>
                      <?php
                      }
                      ?>
                    </td>
                    <td>
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url('peserta/skemaedit/' . $ws->scheme_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item" href="<?= base_url('peserta/skemahapus/' . $ws->scheme_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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