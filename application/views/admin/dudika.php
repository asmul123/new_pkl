<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Dudika</h5>
            <?= $this->session->flashdata('pesan'); ?>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Dudika</th>
                            <th>Alamat</th>
                            <th>Pimpinan</th>
                            <th>Program Keahlian</th>
                            <th>Tahun Pelajaran</th>
                            <th>
                                <div class="btn-group">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('admin/dudikaadd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('admin/dudikaimport') ?>"><i class="bx bx-upload me-1"></i> Import</a></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $no = 0;
                        foreach ($dudika as $k) {
                        ?>
                            <tr>
                                <td><?= ++$no ?></td>
                                <td><?= $k->name ?></td>
                                <td><?= $k->address ?></td>
                                <td><?= $k->head ?></td>
                                <td><?= $k->major ?></td>
                                <td><?= $k->tapel ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?= base_url('admin/dudikaedit/' . $k->dudika_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="<?= base_url('admin/dudikahapus/' . $k->dudika_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>
    <!-- / Content -->