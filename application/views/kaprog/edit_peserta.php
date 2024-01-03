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
                        <form method="POST" action="<?= base_url('kaprog/pesertaedit/' . $partisipantID) ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Peserta</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Peserta" autofocus value="<?= $peserta->name ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="nisn" class="form-control" placeholder="NISN" value="<?= $peserta->nisn ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="class" class="form-control" placeholder="Kelas" value="<?= $peserta->class ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <select name="tapel_id" class="form-control" placeholder="Tahun Pelajaran">
                                        <option value="">Pilih Tahun Pelajaran</option>
                                        <?php foreach ($tapel as $tp) {  ?>
                                            <option value="<?= $tp->tapel_id ?>" <?php if ($peserta->tapel_id == $tp->tapel_id) {
                                                                                        echo "selected";
                                                                                    } ?>><?= $tp->tapel ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Pengguna" value="<?= $peserta->email ?>" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi<sub>(kosongkan jika tidak ingin mengganti kata sandi)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo Peserta<sub>(kosongkan jika tidak ingin mengganti photo)</sub></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="photo" class="form-control" placeholder="Pilih Photo Peserta" />
                                </div>
                            </div>
                            <a href="<?= base_url('kaprog/peserta') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->