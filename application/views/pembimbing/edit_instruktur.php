<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Instruktur</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('pembimbing/instrukturedit/' . $instrukturID) ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Instruktur</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Instruktur" autofocus value="<?= $instruktur->instruktur ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NIK</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="nid" class="form-control" placeholder="NIP/NIK" value="<?= $instruktur->nid ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Pengguna" value="<?= $instruktur->email ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi<sub>(kosongkan jika tidak ingin merubah kata sandi)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" name="position" class="form-control" placeholder="Jabatan" value="<?= $instruktur->position ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo Instruktur<sub>(kosongkan jika tidak ingin merubah photo)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="photo" class="form-control" placeholder="Pilih Photo Instruktur" />
                                </div>
                            </div>
                            <a href="<?= base_url('pembimbing/instruktur') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->