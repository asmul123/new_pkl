<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Peserta</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('kaprog/ploatingaadd') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="dudika_id" class="form-control" placeholder="Nama Dudika">
                                        <option value="" selected>Pilih Dudika</option>
                                        <?php foreach ($dudika as $d) {  ?>
                                            <option value="<?= $d->dudika_id ?>"><?= $d->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pembimbing</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <select name="mentor_id" class="form-control" placeholder="Nama Pembimbing">
                                        <option value="" selected>Pilih Pembimbing</option>
                                        <?php foreach ($mentor as $m) {  ?>
                                            <option value="<?= $m->mentor_id ?>"><?= $m->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Peserta</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <select name="partisipant_id[]" class="form-control" placeholder="Nama Peserta" multiple>
                                        <option value="" selected>Pilih Peserta</option>
                                        <?php foreach ($peserta as $p) {  ?>
                                            <option value="<?= $p->partisipant_id ?>"><?= $p->class . " | " . $p->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
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