<?php
$adminBase = "/KSR/admin";
$siteBase = "/KSR";
$pageHeading = $pageHeading ?? "Dashboard";
$pageDescription = $pageDescription ?? "Kelola website KSR PMI Unit Universitas Pasundan";
$currentPage = $currentPage ?? "dashboard";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - KSR PMI UNPAS</title>

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="<?= $adminBase ?>/assets/admin.css">
</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">

            <a href="<?= $siteBase ?>/index.php" class="sidebar-logo">

                <img src="<?= $siteBase ?>/assets/img/ksr.png" alt="Logo KSR">

                <span>KSR PMI UNPAS</span>

            </a>

        </div>

        <nav class="sidebar-menu">

            <div class="menu-title">
                Dashboard
            </div>

            <ul>

                <li>
                    <a href="<?= $adminBase ?>/index.php"
                        class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

            </ul>

            <div class="menu-title mt-4">
                Konten Website
            </div>

            <ul>

                <li>
                    <a href="<?= $adminBase ?>/berita/index.php"
                        class="<?= $currentPage === 'berita' ? 'active' : '' ?>">
                        <i class="bi bi-newspaper"></i>
                        <span>Berita</span>
                    </a>
                </li>

                <li>
                    <a href="<?= $adminBase ?>/kegiatan/index.php"
                        class="<?= $currentPage === 'kegiatan' ? 'active' : '' ?>">
                        <i class="bi bi-calendar-event"></i>
                        <span>Kegiatan</span>
                    </a>
                </li>

                <li>
                    <a href="<?= $adminBase ?>/anggota/index.php"
                        class="<?= $currentPage === 'anggota' ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        <span>Anggota</span>
                    </a>
                </li>

                <li>
                    <a href="<?= $adminBase ?>/struktur/index.php"
                        class="<?= $currentPage === 'struktur' ? 'active' : '' ?>">
                        <i class="bi bi-diagram-3"></i>
                        <span>Struktur Organisasi</span>
                    </a>
                </li>

                <li>
                    <a href="<?= $adminBase ?>/sertifikat/index.php"
                        class="<?= $currentPage === 'sertifikat' ? 'active' : '' ?>">
                        <i class="bi bi-award"></i>
                        <span>Sertifikat &amp; Prestasi</span>
                    </a>
                </li>

            </ul>

            <hr class="sidebar-divider">

            <div class="menu-title">
                Sistem
            </div>

            <ul>

                <li>
                    <a href="<?= $siteBase ?>/index.php" target="_blank">
                        <i class="bi bi-globe2"></i>
                        <span>Lihat Website</span>
                    </a>
                </li>

                <li>
                    <a href="<?= $adminBase ?>/logout.php" class="logout-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>

        </nav>

    </aside>


    <!-- =========================
         MAIN
    ========================== -->

    <main class="main-content">

        <!-- TOPBAR -->

        <header class="topbar">

            <div class="page-title">

                <div style="display:flex; align-items:center; gap:15px;">

                    <button
                        class="sidebar-toggle"
                        id="sidebarToggle"
                        type="button">
                        <i class="bi bi-list"></i>
                    </button>

                    <div>

                        <h1><?= htmlspecialchars($pageHeading, ENT_QUOTES, "UTF-8") ?></h1>

                        <p>
                            <?= htmlspecialchars($pageDescription, ENT_QUOTES, "UTF-8") ?>
                        </p>

                    </div>

                </div>

            </div>

            <div class="admin-profile">

                <div class="admin-avatar">
                    <?= strtoupper(substr($_SESSION["admin_nama"], 0, 1)) ?>
                </div>

                <div class="admin-info">

                    <div class="admin-name">
                        <?= htmlspecialchars($_SESSION["admin_nama"]) ?>
                    </div>

                    <div class="admin-role">
                        Admin Website
                    </div>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <div class="content">