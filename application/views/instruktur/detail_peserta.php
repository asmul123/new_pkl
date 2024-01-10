<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('instruktur/pesertadetail/' . $partisipant_id) ?>"><i class="bx bx-user me-1"></i> Profile Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/presensidetail/' . $partisipant_id) ?>"><i class="bx bx-bell me-1"></i> Presensi Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/jurnaldetail/' . $partisipant_id) ?>"><i class="bx bx-notepad me-1"></i> Jurnal Peserta</a>
          </li>
        </ul>
        <div class="card mb-4">
          <h5 class="card-header">Profile Peserta</h5>
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img src="<?= base_url('public/assets/img/avatars/' . $peserta->photo) ?>" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploaded_image" />
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Nama Lengkap</label>
                <input class="form-control" type="text" value="<?= $peserta->name ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="lastName" class="form-label">NIS</label>
                <input class="form-control" type="text" value="<?= $peserta->nis ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">NISN</label>
                <input class="form-control" type="text" value="<?= $peserta->nisn ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Tempat Lahir</label>
                <input class="form-control" type="text" value="<?= $peserta->birth_place ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="phoneNumber">Tanggal Lahir</label>
                <input class="form-control" type="text" value="<?= date_indo($peserta->birth_date) ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Jenis Kelamin</label>
                <input class="form-control" type="text" value="<?php if ($peserta->gender == "L") {
                                                                  echo "Laki-laki";
                                                                } else {
                                                                  echo "Perempuan";
                                                                }  ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="state" class="form-label">Kelas</label>
                <input class="form-control" type="text" value="<?= $peserta->class ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="zipCode" class="form-label">Jurusan</label>
                <input class="form-control" type="text" value="<?= $peserta->major ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label" for="country">Agama</label>
                <input class="form-control" type="text" value="<?= $peserta->religion ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="language" class="form-label">Alamat</label>
                <textarea class="form-control" disabled><?= $peserta->address ?></textarea>
              </div>
              <div class="mb-3 col-md-6">
                <label for="timeZones" class="form-label">No. HP</label>
                <input class="form-control" type="text" value="<?= $peserta->contact ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="currency" class="form-label">Nama Orang Tua</label>
                <input class="form-control" type="text" value="<?= $peserta->parent ?>" disabled />
              </div>
              <div class="mb-3 col-md-6">
                <label for="timeZones" class="form-label">Alamat Orang Tua</label>
                <textarea class="form-control" disabled><?= $peserta->parent_address ?></textarea>
              </div>
              <div class="mb-3 col-md-6">
                <label for="currency" class="form-label">No. HP Orang Tua</label>
                <input class="form-control" type="text" value="<?= $peserta->parent_contact ?>" disabled />
              </div>
            </div>
          </div>
        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>
  <!-- / Content -->