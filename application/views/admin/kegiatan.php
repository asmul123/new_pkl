<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <?= $this->session->flashdata('pesan'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Kegiatan</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Program Keahlian</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Panduan</th>
                            <th>
                                <div class="btn-group">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= base_url('admin/kegiatanadd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                                        <li><a class="dropdown-item" href="<?= base_url('admin/kegiatanimport') ?>"><i class="bx bx-upload me-1"></i> Import</a></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php
                        $no = 0;
                        foreach ($kegiatan as $k) {
                        ?>
                            <tr>
                                <td><?= ++$no ?></td>
                                <td><?= $k->event_name ?></td>
                                <td><?= $k->major ?></td>
                                <td><?= longdate_indo($k->start_date) ?></td>
                                <td><?= longdate_indo($k->finish_date) ?></td>
                                <td><a href="<?= base_url('public/assets/documents/' . $k->document) ?>" class="btn btn-outline-primary"><i class="bx bx-download"></i></a></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?= base_url('admin/kegiatanedit/' . $k->event_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="<?= base_url('admin/kegiatanhapus/' . $k->event_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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