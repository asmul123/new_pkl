<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Peserta Terploating</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless" id="example" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Tahun Pelajaran</th>
                                <th>Dudika</th>
                                <th>Instruktur</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Akhir</th>
                                <th>Jam Masuk Kantor</th>
                                <th>Jam Pulang Kantor</th>
                                <th>Hari Libur</th>
                                <th>Kehadiran</th>
                                <th>Jurnal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            foreach ($peserta as $p) {
                            ?>
                                <tr>
                                    <td><img src="<?= base_url('public/assets/img/avatars/' . $p->photo) ?>" width="50px" /></td>
                                    <td><?= $p->peserta ?></td>
                                    <td><?= $p->class ?></td>
                                    <td><?= $p->tapel ?></td>
                                    <td><?= $p->dudika ?></td>
                                    <td><?= $p->instruktur ?></td>
                                    <td><?= date_indo($p->sd) ?></td>
                                    <td><?= date_indo($p->fd) ?></td>
                                    <td><?= $p->st ?></td>
                                    <td><?= $p->ft ?></td>
                                    <td>
                                        <ul>
                                            <?php
                                            $off_days = explode("#", $p->off_days);
                                            $count = count($off_days);
                                            for ($i = 1; $i < $count; $i++) {
                                                echo "<li>" . nomor_hari($off_days[$i]) . "</li>";
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td><a href="#" class="btn btn-xs btn-info">Lihat</a></td>
                                    <td><a href="#" class="btn btn-xs btn-warning">Lihat</a></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/ploatingedit/' . $p->ploating_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/pesertaedit/' . $p->partisipant_id) ?>"><i class="bx bx-refresh me-1"></i> Reset Akun</a>
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/ploatinghapus/' . $p->ploating_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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
        <!--/ Striped Rows -->
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Peserta Belum Terploating</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless" id="example" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Tahun Pelajaran</th>
                                <th>Dudika</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            foreach ($peserta_belum as $p) {
                            ?>
                                <tr>
                                    <td><img src="<?= base_url('public/assets/img/avatars/' . $p->photo) ?>" width="50px" /></td>
                                    <td><?= $p->peserta ?></td>
                                    <td><?= $p->class ?></td>
                                    <td><?= $p->tapel ?></td>
                                    <td><?= $p->dudika ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/ploatingedit/' . $p->ploating_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/pesertaedit/' . $p->partisipant_id) ?>"><i class="bx bx-refresh me-1"></i> Reset Akun</a>
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/ploatinghapus/' . $p->ploating_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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
        <!--/ Striped Rows -->
    </div>
</div>
<!-- / Content -->