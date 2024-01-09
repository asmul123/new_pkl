<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ganti Akun</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('auth/setting') ?>">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="<?= $akun->email ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi Lama</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="old_password" class="form-control" placeholder="Kata Sandi Lama" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi Baru</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi Baru" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Kata Sandi Baru" />
                                </div>
                            </div>
                            <a href="<?= base_url() ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->