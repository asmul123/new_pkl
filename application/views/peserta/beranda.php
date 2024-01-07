    <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
    <script src="https://unpkg.com/dropzone"></script>
    <script src="https://unpkg.com/cropperjs"></script>

    <style>
        .image_area {
            position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>
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
                                        Sudahkah <span class="fw-bold">Anda</span> melakuan presensi hari ini. Jangan lupa untuk selalu mencatat kegiatan anda.
                                    </p>

                                    <a href="<?= base_url('peserta/jurnal') ?>" class="btn btn-sm btn-outline-primary">Lihat Jurnal</a>
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
                <div class="col-lg-12 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="alert alert-info text-center" role="alert">
                                        <div style="font-size: 48px;" id="jam"></div>
                                        <?= longdate_indo(date('Y-m-d')); ?>
                                        <script type="text/javascript">
                                            window.onload = function() {
                                                jam();
                                            }

                                            function jam() {
                                                var e = document.getElementById('jam'),
                                                    d = new Date(),
                                                    h, m, s;
                                                h = d.getHours();
                                                m = set(d.getMinutes());
                                                s = set(d.getSeconds());

                                                e.innerHTML = h + ':' + m + ':' + s;

                                                setTimeout('jam()', 1000);
                                            }

                                            function set(e) {
                                                e = e < 10 ? '0' + e : e;
                                                return e;
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 order-1">
                    <?php
                    if ($jumlah_ploating == 0) {
                    ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mb-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="alert alert-success text-center" role="alert">
                                            Anda tidak memiliki jadwal PKL
                                        </div>
                                        <img src="<?= base_url('public') ?>/assets/img/icons/unicons/bell.svg" alt="chart success" class="rounded" width="100px" />
                                        <hr>
                                        <small class="text-success fw-semibold">Saatnya Masuk Kantor</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12 mb-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="alert alert-success text-center" role="alert">
                                            Lokasi PKL : <?= $ploating->name ?><br>
                                            Waktu PKL : <?= date_indo($ploating->start_date) . " s.d. " . date_indo($ploating->finish_date) ?><br>
                                            Skema Absen :
                                            <?php
                                            if ($jumlah_presensi == 0) {
                                                $status = "belum_absen";
                                            } else {
                                                if ($presensi->finished_time == "00:00:00") {
                                                    $status = "belum_pulang";
                                                } else {
                                                    $status = "sudah_absen";
                                                }
                                            }

                                            if ($jumlah_scheme == 0) {
                                                echo "Default";
                                                $off_days = explode("#", $ploating->off_days);
                                                $start_time = $ploating->start_time;
                                                $dt1 = strtotime($start_time);
                                                $presence_time = strtotime("-1 hour", $dt1);
                                                $presence_time = date("H:i:s", $presence_time);
                                                $finish_time = $ploating->finish_time;
                                                if (in_array($day, $off_days)) {
                                                    $working_status = "libur";
                                                } else {
                                                    $working_status = "masuk";
                                                }
                                            } else {
                                                echo "Flexible";
                                                $off_days = explode("#", $scheme->off_days);
                                                $start_time = $scheme->start_time;
                                                $dt1 = strtotime($start_time);
                                                $presence_time = strtotime("-1 hour", $dt1);
                                                $presence_time = date("H:i:s", $presence_time);
                                                $finish_time = $scheme->finish_time;
                                                if (in_array($day, $off_days)) {
                                                    $working_status = "libur";
                                                } else {
                                                    $working_status = "masuk";
                                                }
                                                $skema = "Flexible";
                                            } ?>
                                            <hr>
                                        </div>
                                        <?php
                                        if ($working_status == "masuk" and date("H:i:s") >= $presence_time and $status == "belum_absen") {
                                        ?>
                                            <form method="post">
                                                <label for="upload_image">
                                                    <img src="<?= base_url('public') ?>/assets/img/icons/unicons/bell.png" id="uploaded_image" class="img-responsive img-circle" width="100px" />
                                                    <div class="overlay">
                                                        <div class="text">Click to Presence</div>
                                                    </div>
                                                    <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                                </label>
                                            </form>
                                            <hr>
                                            <small class="text-warning fw-semibold">Saatnya Presensi Masuk</small>
                                        <?php
                                        } else if ($working_status == "masuk" and date("H:i:s") <= $finish_time and $status == "belum_pulang") {
                                        ?>
                                            <small class="text-success fw-semibold">Sudah Presensi Masuk, dan Belum Saatnya Pulang</small>
                                        <?php
                                        } else if ($working_status == "masuk" and date("H:i:s") >= $finish_time and $status == "belum_pulang") {
                                        ?>
                                            <form method="post">
                                                <label for="upload_image">
                                                    <img src="<?= base_url('public') ?>/assets/img/icons/unicons/bell.png" id="uploaded_image" class="img-responsive img-circle" width="100px" />
                                                    <div class="overlay">
                                                        <div class="text">Click to Presence</div>
                                                    </div>
                                                    <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                                </label>
                                            </form>
                                            <hr>
                                            <small class="text-warning fw-semibold">Saatnya Presensi Pulang</small>
                                        <?php
                                        } else if ($working_status == "masuk" and $status == "sudah_absen") {
                                        ?>
                                            <small class="text-success fw-semibold">Anda Telah Melakukan Presensi</small>
                                        <?php
                                        } else if ($working_status == "masuk") {
                                        ?>
                                            <small class="text-warning fw-semibold">Belum Saatnya Melakukan Presensi!<br>
                                                <blink><sup>
                                                        presensi dapat dilakukan 1 jam sebelum jam masuk kerja
                                                    </sup></blink>
                                            </small>
                                        <?php
                                        } else {
                                        ?>
                                            <small class="text-danger fw-semibold">Selamat Menikmati Hari Libur Anda!</small>
                                        <?php
                                        }
                                        ?>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalFullTitle">Simpan Presensi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="img-container">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <img src="" id="sample_image" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="preview"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="button" class="btn btn-primary" id="crop">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {

                                                var $modal = $('#modal');

                                                var image = document.getElementById('sample_image');

                                                var cropper;

                                                $('#upload_image').change(function(event) {
                                                    var files = event.target.files;

                                                    var done = function(url) {
                                                        image.src = url;
                                                        $modal.modal('show');
                                                    };

                                                    if (files && files.length > 0) {
                                                        reader = new FileReader();
                                                        reader.onload = function(event) {
                                                            done(reader.result);
                                                        };
                                                        reader.readAsDataURL(files[0]);
                                                    }
                                                });

                                                $modal.on('shown.bs.modal', function() {
                                                    cropper = new Cropper(image, {
                                                        aspectRatio: 1,
                                                        viewMode: 3,
                                                        preview: '.preview'
                                                    });
                                                }).on('hidden.bs.modal', function() {
                                                    cropper.destroy();
                                                    cropper = null;
                                                });

                                                $('#crop').click(function() {
                                                    canvas = cropper.getCroppedCanvas({
                                                        width: 400,
                                                        height: 400
                                                    });

                                                    canvas.toBlob(function(blob) {
                                                        url = URL.createObjectURL(blob);
                                                        var reader = new FileReader();
                                                        reader.readAsDataURL(blob);
                                                        reader.onloadend = function() {
                                                            var base64data = reader.result;
                                                            $.ajax({
                                                                url: '<?= base_url('peserta/mulai/' . $ploating->ploating_id) ?>',
                                                                method: 'POST',
                                                                data: {
                                                                    image: base64data
                                                                },
                                                                success: function(data) {
                                                                    $modal.modal('hide');
                                                                    location.reload();
                                                                }
                                                            });
                                                        };
                                                    });
                                                });

                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($working_status == "masuk") {
                        ?>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="<?= base_url('public') ?>/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                                </div>
                                            </div>
                                            <span><?= $start_time ?></span>
                                            <h6 class="card-title mb-2 mt-2">Masuk Kantor</h6>
                                            <small class="text-success fw-semibold"><i class="bx bx-right-arrow-alt"></i><?php if ($jumlah_presensi == 0) {
                                                                                                                                echo "00:00:00";
                                                                                                                            } else {
                                                                                                                                echo $presensi->started_time;
                                                                                                                            } ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex align-items-start justify-content-between">
                                                <div class="avatar flex-shrink-0">
                                                    <img src="<?= base_url('public') ?>/assets/img/icons/unicons/chart.png" class="rounded" />
                                                </div>
                                            </div>
                                            <span><?= $finish_time ?></span>
                                            <h6 class="card-title mb-2 mt-2">Pulang Kantor</h6>
                                            <small class="text-primary fw-semibold"><i class="bx bx-left-arrow-alt"></i><?php if ($jumlah_presensi == 0) {
                                                                                                                            echo "00:00:00";
                                                                                                                        } else {
                                                                                                                            echo $presensi->finished_time;
                                                                                                                        } ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    <?php } ?>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <h5 class="card-header m-0 me-2 pb-3">Kehadiran di Minggu ini</h5>
                                <!-- Responsive Table -->
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
                                            for ($i = 0; $i <= 6; $i++) :
                                                $j = $i + 1;
                                                $date = date('Y-m-d', strtotime("+$i days", strtotime($monday_this_week)));
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
                                                    <th scope="row"><?= $i + 1 ?></th>
                                                    <td><?php echo longdate_indo($date); ?></td>
                                                    <td><?= $pm ?></td>
                                                    <td><?= $ppm ?></td>
                                                    <td><?= $pp ?></td>
                                                    <td><?= $ppp ?></td>
                                                    <td><?= $sk ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                    <!--/ Responsive Table -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->