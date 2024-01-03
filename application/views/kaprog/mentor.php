<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Pembimbing</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pembimbing</th>
                                <th>NIP/NIK</th>
                                <th>Jabatan</th>
                                <th>Program Keahlian</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="<?= base_url('kaprog/mentoradd') ?>"><i class="bx bx-plus me-1"></i> Tambah</a></li>
                                            <li><a class="dropdown-item" href="<?= base_url('kaprog/mentorimport') ?>"><i class="bx bx-upload me-1"></i> Import</a></li>
                                        </ul>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            $no = 0;
                            foreach ($mentor as $m) {
                            ?>
                                <tr>
                                    <td><img src="<?= base_url('public/assets/img/avatars/' . $m->photo) ?>" width="50px" /></td>
                                    <td><?= $m->name ?></td>
                                    <td><?= $m->nid ?></td>
                                    <td><?= $m->position ?></td>
                                    <td><?= $m->major ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= base_url('kaprog/mentoredit/' . $m->mentor_id) ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item" href="<?= base_url('kaprog/mentorhapus/' . $m->mentor_id) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bx bx-trash me-1"></i> Hapus</a>
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