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
            <table class="table">
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
                      $sk = "<button class='btn btn-sm btn-danger'>Ditolak</button>";
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
</div>
<!-- / Content -->