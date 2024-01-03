<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Penempatan Peserta</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless" id="example" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pembimbing</th>
                                <th>Nama Dudika</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Tahun Pelajaran</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('kaprog/ploatingadd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                                        </ul>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            $no = 0;
                            foreach ($ploating as $p) {
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $p->pembimbing ?></td>
                                    <td><?= $p->dudika ?></td>
                                    <td><?= $p->peserta ?></td>
                                    <td><?= $p->class ?></td>
                                    <td><?= $p->tapel ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('kaprog/ploatingedit/' . $p->ploating_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="<?= base_url('kaprog/ploatinghapus/' . $p->ploating_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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
    <!-- / Content -->