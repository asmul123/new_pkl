<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tolak Presensi</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('instruktur/tolakpresence/' . $presenceID) ?>">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <input type="text" name="reason" class="form-control" placeholder="Masukan Alasan Penolakan" autofocus />
                                    <small class="text-danger"><?= form_error('reason'); ?></small>
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