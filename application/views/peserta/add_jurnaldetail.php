<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Catatan Jurnal</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('peserta/jurnaldetailadd/' . $jurnal_id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea name="working_name" class="form-control" placeholder="Nama Pekerjaan"></textarea>
                                    <small class="text-danger"><?= form_error('working_name'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rencana Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea name="working_plan" class="form-control" placeholder="Rencana Pekerjaan"></textarea>
                                    <small class="text-danger"><?= form_error('working_plan'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hasil Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea name="working_goal" class="form-control" placeholder="Hasil Pekerjaan"></textarea>
                                    <small class="text-danger"><?= form_error('working_goal'); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('peserta/jurnaldetail/' . $jurnal_id) ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->