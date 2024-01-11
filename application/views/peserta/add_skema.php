<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ajukan Skema</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('peserta/skemaadd') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="ploating_id" class="form-control" placeholder="Nama Dudika">
                                        <option value="" selected>Pilih Dudika</option>
                                        <?php foreach ($dudika as $d) {  ?>
                                            <option value="<?= $d->ploating_id ?>"><?= $d->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('dudika_id'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Mulai Skema</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="start_date" class="form-control" placeholder="Tanggal PKL" id="start_date" />
                                            <small class="text-danger"><?= form_error('start_date'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Selesai Skema</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="finish_date" class="form-control" placeholder="Tanggal PKL" id="finish_date" />
                                            <small class="text-danger"><?= form_error('finish_date'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Waktu Masuk</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="start_time" class="form-control" placeholder="Waktu PKL" />
                                            <small class="text-danger"><?= form_error('start_time'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Waktu Pulang</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" name="finish_time" class="form-control" placeholder="Waktu PKL" />
                                            <small class="text-danger"><?= form_error('finish_time'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hari Libur</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <select name="off_days[]" class="form-control" placeholder="Hari Libur Kerja" multiple>
                                        <option value="">Pilih Hari Libur</option>
                                        <option value="1">Minggu</option>
                                        <option value="2">Senin</option>
                                        <option value="3">Selasa</option>
                                        <option value="4">Rabu</option>
                                        <option value="5">Kamis</option>
                                        <option value="6">Jumat</option>
                                        <option value="7">Sabtu</option>
                                    </select>
                                    <small class="text-danger"><?= form_error('off_days[]'); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('peserta/presensi') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->