<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Isi Izin Orang Tua</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('peserta/izinisi/' . $ploating_id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <input type="text" class="form-control" value="<?= $ploating->dudika ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Orang Tua</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" value="<?= $biodata->parent ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Orang Tua</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                    <textarea class="form-control" disabled><?= $biodata->parent_address ?></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak Orang Tua</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" class="form-control" value="<?= $biodata->parent_contact ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Menyatakan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-check"></i></span>
                                    <select name="status" class="form-control">
                                        <option value="1">Mengijinkan</option>
                                        <option value="2">Tidak Mengijinkan</option>
                                    </select>
                                    <small class="text-danger"><?= form_error('status'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Mulai PKL</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="text" class="form-control" value="<?= date_indo($ploating->start_date) ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Selesai PKL</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="text" class="form-control" value="<?= date_indo($ploating->finish_date) ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= base_url('peserta/biodata') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->