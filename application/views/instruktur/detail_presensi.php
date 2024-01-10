<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/pesertadetail/' . $partisipant_id) ?>"><i class="bx bx-user me-1"></i> Profile Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('instruktur/presensidetail/' . $partisipant_id) ?>"><i class="bx bx-bell me-1"></i> Presensi Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/jurnaldetail/' . $partisipant_id) ?>"><i class="bx bx-notepad me-1"></i> Jurnal Peserta</a>
          </li>
        </ul>
        <div class="card mb-4">
          <h5 class="card-header">Presensi Peserta</h5>
          <!-- Account -->
          <div class="card-body">
            rekap
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
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
                      <th>Keterlambatan</th>
                      <th>Status</th>
                      <th>Aksi</th>
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
                      $keterlambatan = "";
                      $date = $dt->format("Y-m-d");
                      $presencethisdate = $this->Presensi_model->getPresenceThisDate($ploating->ploating_id, $date);
                      $ploatingthisdate = $this->Scheme_model->getWorkingScheme($ploating->ploating_id, $date)->row();
                      if ($ploatingthisdate) {
                        $libur = explode("#", $ploatingthisdate->off_days);
                        $working_time = $ploatingthisdate->start_time;
                      } else {
                        $libur =  explode("#", $ploating->off_days);
                        $working_time = $ploating->start_time;
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
                        if ($pm > $working_time) {
                          $first  = new DateTime($working_time);
                          $second = new DateTime($pm);
                          $keterlambatan = $first->diff($second);
                          $keterlambatan = $keterlambatan->format('%H:%I:%S'); // -> 00:25:25
                        } else {
                          $keterlambatan = "Tepat Waktu";
                        }
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
                        <td><?= $keterlambatan ?></td>
                        <td><?= $sk ?></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <?php if ($presencethisdate) {
                              ?>
                                <a class="dropdown-item" href="<?= base_url('instruktur/presensiedit/' . $presencethisdate->presence_id) ?>"><i class="bx bx-edit-alt me-1"></i> Ubah Status</a>
                                <a class="dropdown-item" href="<?= base_url('instruktur/lateddelete/' . $presencethisdate->presence_id) ?>"><i class="bx bx-refresh me-1"></i> Hapus Keterlambatan</a>
                                <a class="dropdown-item" href="<?= base_url('instruktur/presensidelete/' . $presencethisdate->presence_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus Presensi</a>
                              <?php
                              } else {
                              ?>
                                <a class="dropdown-item" href="<?= base_url('instruktur/presensibyinstruktur/' . $partisipant_id . '/' . $date) ?>"><i class="bx bx-bell me-1"></i> Presensi oleh Instruktur</a>
                              <?php
                              }
                              ?>
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
        <!-- /Account -->
      </div>
    </div>
  </div>
  <!-- / Content -->