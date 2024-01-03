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
                                    <?= date('l, d F Y'); ?>
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
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="<?= base_url('public') ?>/assets/img/icons/unicons/bell.svg" alt="chart success" class="rounded" width="100px" />
                                <hr>
                                <small class="text-success fw-semibold">Saatnya Masuk Kantor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="<?= base_url('public') ?>/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                    </div>
                                </div>
                                <span>07:00:00</span>
                                <h6 class="card-title mb-2 mt-2">Masuk Kantor</h6>
                                <small class="text-success fw-semibold"><i class="bx bx-right-arrow-alt"></i> 00:00:00</small>
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
                                <span>16:00:00</span>
                                <h6 class="card-title mb-2 mt-2">Pulang Kantor</h6>
                                <small class="text-success fw-semibold"><i class="bx bx-left-arrow-alt"></i>00:00:00</small>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                            <th>Table heading</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                        </tr>
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