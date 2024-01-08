<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<style>
  .image_area {
    position: relative;
  }

  img {
    display: block;
    max-width: 100%;
  }

  .preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid red;
  }

  .modal-lg {
    max-width: 1000px !important;
  }

  .overlay {
    position: absolute;
    bottom: 10px;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.5);
    overflow: hidden;
    height: 0;
    transition: .5s ease;
    width: 100%;
  }

  .image_area:hover .overlay {
    height: 50%;
    cursor: pointer;
  }

  .text {
    color: #333;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
  }
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Profile Peserta</h5>
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img src="<?= base_url('public/assets/img/avatars/' . $photo) ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploaded_image" />
              <div class="button-wrapper">
                <form method="POST">
                  <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Ubah Photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                  </label>
                  <p class="text-muted mb-0">Klik untuk menganti photo</p>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Simpan Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="img-container">
                          <div class="row">
                            <div class="col-md-8">
                              <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                              <div class="preview"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="button" class="btn btn-primary" id="crop">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                  $(document).ready(function() {

                    var $modal = $('#modal');

                    var image = document.getElementById('sample_image');

                    var cropper;

                    $('#upload').change(function(event) {
                      var files = event.target.files;

                      var done = function(url) {
                        image.src = url;
                        $modal.modal('show');
                      };

                      if (files && files.length > 0) {
                        reader = new FileReader();
                        reader.onload = function(event) {
                          done(reader.result);
                        };
                        reader.readAsDataURL(files[0]);
                      }
                    });

                    $modal.on('shown.bs.modal', function() {
                      cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 3,
                        preview: '.preview'
                      });
                    }).on('hidden.bs.modal', function() {
                      cropper.destroy();
                      cropper = null;
                    });

                    $('#crop').click(function() {
                      canvas = cropper.getCroppedCanvas({
                        width: 400,
                        height: 400
                      });

                      canvas.toBlob(function(blob) {
                        url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function() {
                          var base64data = reader.result;
                          $.ajax({
                            url: '<?= base_url('peserta/update') ?>',
                            method: 'POST',
                            data: {
                              image: base64data
                            },
                            success: function(data) {
                              $modal.modal('hide');
                              location.reload();
                            }
                          });
                        };
                      });
                    });

                  });
                </script>
              </div>
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Nama Lengkap</label>
                <input class="form-control" type="text" value="<?= $biodata->name ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="lastName" class="form-label">NIS</label>
                <input class="form-control" type="text" value="<?= $biodata->nis ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">NISN</label>
                <input class="form-control" type="text" value="<?= $biodata->nisn ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Tempat Lahir</label>
                <input class="form-control" type="text" value="<?= $biodata->birth_place ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="phoneNumber">Tanggal Lahir</label>
                <input class="form-control" type="text" value="<?= date_indo($biodata->birth_date) ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Jenis Kelamin</label>
                <input class="form-control" type="text" value="<?php if ($biodata->gender == "L") {
                                                                  echo "Laki-laki";
                                                                } else {
                                                                  echo "Perempuan";
                                                                }  ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">Kelas</label>
                <input class="form-control" type="text" value="<?= $biodata->class ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="zipCode" class="form-label">Jurusan</label>
                <input class="form-control" type="text" value="<?= $biodata->major ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="country">Agama</label>
                <input class="form-control" type="text" value="<?= $biodata->religion ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="language" class="form-label">Alamat</label>
                <textarea class="form-control" disabled><?= $biodata->address ?></textarea>
              </div>
              <div class="mb-3 col-md-6">
                <label for="timeZones" class="form-label">No. HP</label>
                <input class="form-control" type="text" value="<?= $biodata->contact ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="currency" class="form-label">Nama Orang Tua</label>
                <input class="form-control" type="text" value="<?= $biodata->parent ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="timeZones" class="form-label">Alamat Orang Tua</label>
                <textarea class="form-control" disabled><?= $biodata->parent_address ?></textarea>
              </div>
              <div class="mb-3 col-md-6">
                <label for="currency" class="form-label">No. HP Orang Tua</label>
                <input class="form-control" type="text" value="<?= $biodata->parent_contact ?>" disabled />
              </div>
            </div>
            <div class="mt-2">
              <!-- Modal Backdrop -->
              <div class="col-lg-4 col-md-3">
                <div class="mt-3">
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModal">
                    Ubah Data
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                    <div class="modal-dialog">
                      <form class="modal-content" action="<?= base_url('peserta/simpan') ?>" method="POST">
                        <div class="modal-header">
                          <h5 class="modal-title" id="backDropModalTitle">Ubah Data</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="mb-3 col-md-6">
                              <label for="firstName" class="form-label">Nama Lengkap</label>
                              <input class="form-control" type="text" name="name" value="<?= $biodata->name ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="organization" class="form-label">Tempat Lahir</label>
                              <input class="form-control" type="text" name="birth_place" value="<?= $biodata->birth_place ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="phoneNumber">Tanggal Lahir</label>
                              <input class="form-control" type="date" name="birth_date" value="<?= $biodata->birth_date ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="address" class="form-label">Jenis Kelamin</label>
                              <select class="form-control" name="gender">
                                <option value="L" <?php if ($biodata->gender == "L") {
                                                    echo " selected";
                                                  } ?>>Laki-laki</option>
                                <option value="P" <?php if ($biodata->gender == "P") {
                                                    echo " selected";
                                                  } ?>>Perempuan</option>
                              </select>
                            </div>
                            <div class="mb-3 col-md-6">
                              <label class="form-label" for="country">Agama</label>
                              <input class="form-control" type="text" name="religion" value="<?= $biodata->religion ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="language" class="form-label">Alamat</label>
                              <textarea class="form-control" name="address"><?= $biodata->address ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="timeZones" class="form-label">No. HP</label>
                              <input class="form-control" type="text" name="contact" value="<?= $biodata->contact ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="currency" class="form-label">Nama Orang Tua</label>
                              <input class="form-control" type="text" name="parent" value="<?= $biodata->parent ?>" />
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="timeZones" class="form-label">Alamat Orang Tua</label>
                              <textarea class="form-control" name="parent_address"><?= $biodata->parent_address ?></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                              <label for="currency" class="form-label">No. HP Orang Tua</label>
                              <input class="form-control" type="text" name="parent_contact" value="<?= $biodata->parent_contact ?>" />
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Keluar
                          </button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
        <!-- /Account -->
      </div>
      <div class="card">
        <h5 class="card-header">Surat Ijin Orang Tua</h5>
        <div class="card-body">
          <?= $this->session->flashdata('pesan'); ?>
          <div class="table-responsive text-nowrap">
            <table class="table table-striped" width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Dudika</th>
                  <th>Keterangan</th>
                  <th>Surat Izin</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <?php
                $no = 0;
                foreach ($ploating as $p) {
                  $izin = $this->Izin_model->getParentPermission($p->ploating_id);
                  if ($izin) {
                    if ($izin->status == 1) {
                      $keterangan = "Mengijinkan";
                    } else {
                      $keterangan = "Tidak Mengijinkan";
                    }
                    if ($izin->document != "") {
                      $document = "<a href='" . base_url('public/assets/documents/' . $izin->document) . "' class='btn btn-xs btn-primary'>Lihat</a>";
                    } else {
                      $document = "-";
                    }
                  } else {
                    $keterangan = "Belum Menentukan";
                    $document = "-";
                  }
                ?>
                  <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $p->name ?></td>
                    <td><?= $keterangan ?></td>
                    <td><?= $document ?></td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?= base_url('peserta/izinisi/' . $p->ploating_id) ?>"><i class="bx bx-edit-alt me-1"></i> Isi Izin</a>
                          <a class="dropdown-item" href="<?= base_url('peserta/izinunduh/' . $p->ploating_id) ?>"><i class="bx bx-download me-1"></i> Unduh Izin</a>
                          <a class="dropdown-item" href="<?= base_url('peserta/izinunggah/' . $p->ploating_id) ?>"><i class="bx bx-upload me-1"></i> Unggah Izin</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->