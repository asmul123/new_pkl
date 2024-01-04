<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Instruktur</h5>
                        <?= $this->session->flashdata('pesan'); ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('pembimbing/instrukturadd') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Instruktur</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Nama Pembimbing" autofocus />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIP/NIK</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-card"></i></span>
                                    <input type="text" name="nid" class="form-control" placeholder="NIP/NIK" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Pengguna" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kata Sandi</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-key"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" name="position" class="form-control" placeholder="Jabatan" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Photo Pembimbing</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                                    <input type="file" name="photo" class="form-control" placeholder="Pilih Photo Pembimbing" />
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Nama Dudika</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="dudika_id" class="form-control" placeholder="Nama Dudika" id="dudika">
                                        <option value="" selected>Pilih Dudika</option>
                                        <?php foreach ($dudika as $d) {  ?>
                                            <option value="<?= $d->dudika_id ?>"><?= $d->name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                    <small class="text-danger"><?= form_error('dudika_id'); ?></small>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('#dudika').change(function() {
                                        var id = $(this).val();
                                        $.ajax({
                                            url: "<?php echo base_url('pembimbing/getploating'); ?>",
                                            method: "POST",
                                            data: {
                                                id: id
                                            },
                                            async: true,
                                            dataType: 'json',
                                            success: function(data) {

                                                var html = '<option value="">Pilih Peserta</option>';
                                                var i;
                                                for (i = 0; i < data.length; i++) {
                                                    html += '<option value="' + data[i].ploating_id + '">' + data[i].name + ' (' + data[i].class + ')</option>';
                                                }
                                                $('#peserta').html(html);

                                                $.ajax({
                                                    url: "<?php echo base_url('pembimbing/getdate'); ?>",
                                                    method: "POST",
                                                    data: {
                                                        id: id
                                                    },
                                                    async: true,
                                                    dataType: 'json',
                                                    success: function(data) {

                                                        document.getElementById("start_date").value = data.sd;
                                                        document.getElementById("finish_date").value = data.fd;

                                                    }
                                                });

                                            }
                                        });
                                        return false;
                                    });
                                });
                            </script>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Mulai PKL</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" name="start_date" class="form-control" placeholder="Tanggal PKL" id="start_date" />
                                            <small class="text-danger"><?= form_error('start_date'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label class="form-label">Tanggal Selesai PKL</label>
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
                                        <option value="" selected>Pilih Hari Libur</option>
                                        <option value="0">Minggu</option>
                                        <option value="1">Senin</option>
                                        <option value="2">Selasa</option>
                                        <option value="3">Rabu</option>
                                        <option value="4">Kamis</option>
                                        <option value="5">Jumat</option>
                                        <option value="6">Sabtu</option>
                                    </select>
                                    <small class="text-danger"><?= form_error('off_days[]'); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Peserta Didik</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <select name="ploating_id[]" class="form-control" placeholder="Nama Peserta" id="peserta" multiple>
                                    </select>
                                    <small class="text-danger"><?= form_error('ploating_id[]'); ?></small>
                                </div>
                            </div>
                            <a href="<?= base_url('pembimbing/instruktur') ?>" class="btn btn-warning">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->