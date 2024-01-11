<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang <?= $name ?>! 🎉</h5>
                                <p class="mb-4">
                                    Berikut panduan pelaksanaan PKL Tahun ini.
                                </p>

                                <a href="<?= base_url('public/assets/documents/' . $panduan) ?>" class="btn btn-sm btn-outline-primary" target="_blank">Unduh Panduan</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="<?= base_url('public') ?>/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <h5 class="card-header">Presensi Peserta PKL</h5>
                    <div class="card-body">
                        <?= $this->session->flashdata('pesan'); ?>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless" id="example">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Aksi</th>
                                        <th>Nama Peserta</th>
                                        <th>Tanggal</th>
                                        <th>Presensi Masuk</th>
                                        <th>Photo Presensi Masuk</th>
                                        <th>Presensi Pulang</th>
                                        <th>Photo Presensi Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($presensi as $p) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= ++$no ?></th>
                                            <td>
                                                <a href="<?= base_url('instruktur/terimapresence/' . $p->presence_id) ?>" class="btn btn-sm btn-primary">Terima</a>
                                                <a href="<?= base_url('instruktur/tolakpresence/' . $p->presence_id) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                            </td>
                                            <td><?= $p->name ?></td>
                                            <td><?= longdate_indo($p->presence_date) ?></td>
                                            <td><?= $p->started_time ?></td>
                                            <td><img src='<?= base_url('public/assets/img/presences/' . $p->started_photo) ?>' width='100px' /></td>
                                            <td><?= $p->finished_time ?></td>
                                            <td>
                                                <?php if ($p->finished_time != "00:00:00") {
                                                ?>
                                                    <img src='<?= base_url('public/assets/img/presences/' . $p->finished_photo) ?>' width='100px' />
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <h5 class="card-header">Jurnal Peserta PKL</h5>
                    <div class="card-body">
                        <?= $this->session->flashdata('pesan'); ?>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless" id="example2">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Aksi</th>
                                        <th>Nama Peserta</th>
                                        <th>Tanggal</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Pekerjaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($jurnal as $j) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= ++$no ?></th>
                                            <td>
                                                <a href="<?= base_url('instruktur/jurnalproses/' . $j->jurnal_detail_id) ?>" class="btn btn-sm btn-primary">Proses</a>
                                            </td>
                                            <td><?= $j->name ?></td>
                                            <td><?= longdate_indo($j->jurnal_date) ?></td>
                                            <td><?= $j->division ?></td>
                                            <td><?= $j->working_name ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <h5 class="card-header">Pengajuan Skema Peserta PKL</h5>
                    <div class="card-body">
                        <?= $this->session->flashdata('pesan'); ?>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless" id="example3">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Aksi</th>
                                        <th>Nama Peserta</th>
                                        <th>Rentang Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Hari Libur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($skema as $s) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= ++$no ?></th>
                                            <td>
                                                <a href="<?= base_url('instruktur/terimaskema/' . $s->scheme_id) ?>" class="btn btn-sm btn-primary">Terima</a>
                                                <a href="<?= base_url('instruktur/tolakskema/' . $s->scheme_id) ?>" class="btn btn-sm btn-danger">Tolak</a>
                                            </td>
                                            <td><?= $s->name ?></td>
                                            <td><?= date_indo($s->start_date) . " s.d. " . date_indo($s->finish_date) ?></td>
                                            <td><?= $s->start_time ?></td>
                                            <td><?= $s->finish_time ?></td>
                                            <td>
                                                <ul>
                                                    <?php
                                                    $off_days = explode("#", $s->off_days);
                                                    $count = count($off_days);
                                                    for ($i = 1; $i < $count; $i++) {
                                                        echo "<li>" . nomor_hari($off_days[$i]) . "</li>";
                                                    }
                                                    ?>
                                                </ul>
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
        <!-- / Content -->