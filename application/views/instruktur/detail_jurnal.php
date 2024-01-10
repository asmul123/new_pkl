<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/pesertadetail/' . $partisipant_id) ?>"><i class="bx bx-user me-1"></i> Profile Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('instruktur/presensidetail/' . $partisipant_id) ?>"><i class="bx bx-bell me-1"></i> Presensi Peserta</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('instruktur/jurnaldetail/' . $partisipant_id) ?>"><i class="bx bx-notepad me-1"></i> Jurnal Peserta</a>
          </li>
        </ul>
        <div class="card mb-4">
          <h5 class="card-header">Jurnal Peserta</h5>
          <!-- Account -->
          <div class="card-body">
            rekap
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
              tabel
            </div>
          </div>
        </div>
        <!-- /Account -->
      </div>
    </div>
  </div>
  <!-- / Content -->