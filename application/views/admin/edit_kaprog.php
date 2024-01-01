<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Kaprog</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('admin/kaprogedit/' . $kaprogID) ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Kaprog</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-run"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Kaprog" autofocus value="<?= $kaprog->name ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NIK</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="nid" class="form-control" placeholder="NIP/NIK" value="<?= $kaprog->nid ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Pengguna" value="<?= $kaprog->email ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi<sub>(kosongkan jika tidak ingin merubah)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" name="position" class="form-control" placeholder="Jabatan" value="<?= $kaprog->position ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Keahlian</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <select name="major_id" class="form-control" placeholder="Program Keahlian">
                                        <option value="">Pilih Program Keahlian</option>
                                        <?php foreach ($program as $p) {  ?>
                                            <option value="<?= $p->major_id ?>" <?php if ($kaprog->major_id == $p->major_id) {
                                                                                    echo "selected";
                                                                                } ?>><?= $p->major ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo Kaprog<sub>(abaikan jika tidak ingin merubah)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="photo" class="form-control" placeholder="Pilih Photo Kaprog" />
                                </div>
                            </div>
                            <a href="<?= base_url('admin/kaprog') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->