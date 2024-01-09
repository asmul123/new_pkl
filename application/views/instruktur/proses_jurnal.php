<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Proses Jurnal</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('instruktur/jurnalproses/' . $jurnalID) ?>">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <input type="text" class="form-control" value="<?= $jurnal->division ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea class="form-control" disabled><?= $jurnal->working_name ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rencana Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea class="form-control" disabled><?= $jurnal->working_plan ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hasil Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea class="form-control" disabled><?= $jurnal->working_goal ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Instruktur</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <textarea name="noted" class="form-control" placeholder="Isi Catatan Instruktur" autofocus></textarea>
                                    <small class="text-danger"><?= form_error('noted'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Jurnal</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-notepad"></i></span>
                                    <select name="status" class="form-control">
                                        <option value="2">Diterima</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                    <small class="text-danger"><?= form_error('status'); ?></small>
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