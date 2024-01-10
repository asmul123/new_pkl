<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Daftar Peserta Bimbingan</h5>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless" id="example" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Peserta</th>
                                <th>Kelas</th>
                                <th>Pembimbing</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php
                            foreach ($peserta as $p) {
                            ?>
                                <tr>
                                    <td><img src="<?= base_url('public/assets/img/avatars/' . $p->photo) ?>" width="50px" /></td>
                                    <td><?= $p->peserta ?></td>
                                    <td><?= $p->class ?></td>
                                    <td><?= $p->pembimbing ?></td>
                                    <td><a href="<?= base_url('instruktur/pesertadetail/' . $p->partisipant_id) ?>" class="btn btn-xs btn-info">Lihat</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>
</div>
<!-- / Content -->