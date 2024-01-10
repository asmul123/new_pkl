<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Jurnal</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('peserta/jurnaledit/' . $jurnal_id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select name="ploating_id" class="form-control">
                                        <?php
                                        foreach ($ploating as $p) {
                                        ?>
                                            <option value="<?= $p->ploating_id ?>" <?php if ($p->ploating_id = $jurnal->ploating_id) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $p->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('ploating_id'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Jurnal</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="jurnal_date" class="form-control" value="<?= date($jurnal->jurnal_date) ?>" />
                                    <small class="text-danger"><?= form_error('jurnal_date'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                    <input type="text" name="division" class="form-control" value="<?= $jurnal->division ?>" />
                                    <small class="text-danger"><?= form_error('division'); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('peserta/jurnal') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->