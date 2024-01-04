<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Peserta</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('kaprog/ploatingedit/' . $ploatingID) ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Kegiatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-run"></i></span>
                                    <select name="event_id" class="form-control" placeholder="Nama Kegiatan">
                                        <option value="">Pilih Kegiatan</option>
                                        <?php foreach ($kegiatan as $k) {  ?>
                                            <option value="<?= $k->event_id ?>" <?php if ($k->event_id == $ploating->event_id) {
                                                                                    echo "selected";
                                                                                } ?>><?= $k->event_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('event_id'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="dudika_id" class="form-control" placeholder="Nama Dudika">
                                        <option value="">Pilih Dudika</option>
                                        <?php foreach ($dudika as $d) {  ?>
                                            <option value="<?= $d->dudika_id ?>" <?php if ($d->dudika_id == $ploating->dudika_id) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $d->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('dudika_id'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pembimbing</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <select name="mentor_id" class="form-control" placeholder="Nama Pembimbing">
                                        <option value="">Pilih Pembimbing</option>
                                        <?php foreach ($mentor as $m) {  ?>
                                            <option value="<?= $m->mentor_id ?>" <?php if ($m->mentor_id == $ploating->mentor_id) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $m->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('mentor_id'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Peserta</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <select name="partisipant_id" class="form-control" placeholder="Nama Peserta">
                                        <option value="">Pilih Peserta</option>
                                        <?php foreach ($peserta as $p) {  ?>
                                            <option value="<?= $p->partisipant_id ?>" <?php if ($p->partisipant_id == $ploating->partisipant_id) {
                                                                                            echo "selected";
                                                                                        } ?>><?= $p->class . " | " . $p->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('partisipant_id'); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('kaprog/ploating') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->