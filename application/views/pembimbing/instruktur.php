<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Instruktur</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Dudika</th>
                                <th>Nama Instruktur</th>
                                <th>Email</th>
                                <th>Jumlah Peserta</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('pembimbing/instrukturadd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                                        </ul>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            $no = 0;
                            foreach ($instruktur as $i) {
                            ?>
                                <tr>
                                    <td><?= ++$no ?></td>
                                    <td><?= $i->dudika ?></td>
                                    <td><?= $i->instruktur ?></td>
                                    <td><?= $i->email ?></td>
                                    <td><?= $i->jml_peserta ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/instrukturedit/' . $i->instruktur_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="<?= base_url('pembimbing/instrukturhapus/' . $i->instruktur_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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