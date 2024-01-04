<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="<?= base_url('public/assets/img/logo.png') ?>" width="50px" />
                        </span>
                        <span class="app-brand-text menu-text fw-bolder ms-2">
                            Jurnal PKL Online<br>
                            <h5>SMKN 1 GARUT</h5>
                        </span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <li class="menu-item<?php if ($menuactive == "dashboard") {
                                            echo " active";
                                        } ?>">
                        <a href="<?= base_url() ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <?php
                    if ($this->session->userdata('role_id') == 1) {
                    ?>
                        <!-- Menu Admin -->
                        <li class="menu-item<?php if ($menuactive == "kegiatan") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('admin/kegiatan') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-run"></i>
                                <div data-i18n="Analytics">Kegiatan</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "dudika") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('admin/dudika') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-buildings"></i>
                                <div data-i18n="Analytics">Dudika</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "kaprog") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('admin/kaprog') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Kaprog</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "mentor") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('admin/mentor') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Pembimbing</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "jurusan") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('admin/jurusan') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                                <div data-i18n="Analytics">Program Keahlian</div>
                            </a>
                        </li>
                        <!-- Akhir Menu Admin -->
                    <?php
                    } else if ($this->session->userdata('role_id') == 2) {
                    ?>
                        <!-- Menu Kaprog -->
                        <li class="menu-item<?php if ($menuactive == "kegiatan") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('kaprog/kegiatan') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-run"></i>
                                <div data-i18n="Analytics">Kegiatan</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "dudika") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('kaprog/dudika') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-buildings"></i>
                                <div data-i18n="Analytics">Dudika</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "mentor") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('kaprog/mentor') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Pembimbing</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "peserta") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('kaprog/peserta') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Peserta</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "ploating") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('kaprog/ploating') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user-check"></i>
                                <div data-i18n="Analytics">Penempatan Peserta</div>
                            </a>
                        </li>
                        <!-- Akhir Menu Kaprog -->
                    <?php
                    } else if ($this->session->userdata('role_id') == 3) {
                    ?>
                        <!-- Menu Pembimbing -->
                        <li class="menu-item<?php if ($menuactive == "instruktur") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('pembimbing/instruktur') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Instruktur</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "peserta") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('pembimbing/peserta') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Peserta</div>
                            </a>
                        </li>
                        <!-- Akhir Menu Pembimbing -->
                    <?php
                    } else if ($this->session->userdata('role_id') == 5) {
                    ?>
                        <!-- Menu Peserta -->
                        <li class="menu-item<?php if ($menuactive == "presensi") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('peserta/presensi') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-calendar"></i>
                                <div data-i18n="Analytics">Presensi</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "jurnal") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('peserta/jurnal') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-notepad"></i>
                                <div data-i18n="Analytics">Jurnal</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "biodata") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('peserta/biodata') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user"></i>
                                <div data-i18n="Analytics">Biodata</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "dudika") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('peserta/dudika') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-buildings"></i>
                                <div data-i18n="Analytics">Dudika</div>
                            </a>
                        </li>
                        <li class="menu-item<?php if ($menuactive == "laporan") {
                                                echo " active";
                                            } ?>">
                            <a href="<?= base_url('peserta/laporan') ?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-archive-in"></i>
                                <div data-i18n="Analytics">Laporan</div>
                            </a>
                        </li>
                        <!-- Akhir Menu Peserta -->
                    <?php
                    }
                    ?>
                    <li class="menu-item">
                        <a href="<?= base_url('keluar') ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-power-off"></i>
                            <div data-i18n="Analytics">Keluar</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->