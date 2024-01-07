<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Dudika</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('kaprog/dudikaadd') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Dudika" autofocus />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                    <textarea name="address" class="form-control" placeholder="Alamat Dudika"></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Pimpinan Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="head" class="form-control" placeholder="Nama Pimpinan Dudika" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NIK Pimpinan Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="head_nip" class="form-control" placeholder="NIP/NIK Pimpinan Dudika" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan Pimpinan Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-collection"></i></span>
                                    <input type="text" name="head_position" class="form-control" placeholder="Jabatan Pimpinan Dudika" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <select name="tapel_id" class="form-control" placeholder="Tahun Pelajaran">
                                        <option value="" selected>Pilih Tahun Pelajaran</option>
                                        <?php foreach ($tapel as $tp) {  ?>
                                            <option value="<?= $tp->tapel_id ?>"><?= $tp->tapel ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Logo Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="logo" class="form-control" placeholder="Pilih Logo Dudika" />
                                </div>
                            </div>
                            <a href="<?= base_url('kaprog/dudika') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->