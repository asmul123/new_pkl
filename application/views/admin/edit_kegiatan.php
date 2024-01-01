<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <?= $this->session->flashdata('pesan'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('admin/kegiatanedit/' . $eventID) ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Kegiatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-run"></i></span>
                                    <input type="text" name="event_name" class="form-control" placeholder="Nama Kegiatan" autofocus value="<?= $kegiatan->event_name ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Kegiatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="start_date" class="form-control" placeholder="Tanggal Mulai Kegiatan" value="<?= $kegiatan->start_date ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai Kegiatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="finish_date" class="form-control" placeholder="Tanggal Selesai Kegiatan" value="<?= $kegiatan->finish_date ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Keahlian</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <select name="major_id" class="form-control" placeholder="Program Keahlian">
                                        <option value="">Pilih Program Keahlian</option>
                                        <?php foreach ($program as $p) {  ?>
                                            <option value="<?= $p->major_id ?>" <?php if ($p->major_id == $kegiatan->major_id) {
                                                                                    echo "selected";
                                                                                } ?>><?= $p->major ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <select name="tapel_id" class="form-control" placeholder="Tahun Pelajaran">
                                        <option value="" selected>Pilih Tahun Pelajaran</option>
                                        <?php foreach ($tapel as $tp) {  ?>
                                            <option value="<?= $tp->tapel_id ?>" <?php if ($tp->tapel_id == $kegiatan->tapel_id) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $tp->tapel ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Panduan Kegiatan <sub>(Abaikan jika tidak ingin merubah)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="document" class="form-control" placeholder="Pilih Dokumen Kegiatan" />
                                </div>
                            </div>
                            <a href="<?= base_url('admin/kegiatan') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->