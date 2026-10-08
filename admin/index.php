<?php

require_once "../includes/auth.php";

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
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Admin CSS -->
    <link rel="stylesheet" href="assets/admin.css">
</head>

<body>
    

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">

            <a href="../index.php" class="sidebar-logo">

                <img src="../assets/img/ksr.png" alt="Logo KSR">

                <span>KSR PMI UNPAS</span>

            </a>

        </div>

        <nav class="sidebar-menu">

            <div class="menu-title">
                Dashboard
            </div>

            <ul>

                <li>
                    <a href="index.php" class="active">
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
                    <a href="berita/index.php">
                        <i class="bi bi-newspaper"></i>
                        <span>Berita</span>
                    </a>
                </li>

                <li>
                    <a href="kegiatan/index.php">
                        <i class="bi bi-calendar-event"></i>
                        <span>Kegiatan</span>
                    </a>
                </li>

                <li>
                    <a href="anggota/index.php">
                        <i class="bi bi-people"></i>
                        <span>Anggota</span>
                    </a>
                </li>

                <li>
                    <a href="struktur/index.php">
                        <i class="bi bi-diagram-3"></i>
                        <span>Struktur Organisasi</span>
                    </a>
                </li>

                <li>
                    <a href="sertifikat/index.php">
                        <i class="bi bi-award"></i>
                        <span>Sertifikat & Prestasi</span>
                    </a>
                </li>

            </ul>


            <hr class="sidebar-divider">


            <div class="menu-title">
                Sistem
            </div>

            <ul>

                <li>
                    <a href="../index.php" target="_blank">
                        <i class="bi bi-globe2"></i>
                        <span>Lihat Website</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php" class="logout-link">
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
                        type="button"
                    >
                        <i class="bi bi-list"></i>
                    </button>

                    <div>

                        <h1>Dashboard</h1>

                        <p>
                            Kelola website KSR PMI Unit Universitas Pasundan
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


            <!-- WELCOME -->

            <div class="welcome-card">

                <h2>
                    Selamat Datang di Admin Panel 👋
                </h2>

                <p>
                    Kelola informasi, berita, kegiatan,
                    anggota, struktur organisasi, dan prestasi KSR
                    PMI Unit Universitas Pasundan.
                </p>

            </div>


            <!-- STATISTICS -->

            <div class="stat-grid">

                <div class="stat-card">

                    <div class="stat-info">

                        <span>Total Berita</span>

                        <h3>0</h3>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-newspaper"></i>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>Total Kegiatan</span>

                        <h3>0</h3>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>Total Anggota</span>

                        <h3>0</h3>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-info">

                        <span>Prestasi</span>

                        <h3>0</h3>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-award"></i>
                    </div>

                </div>

            </div>


            <!-- DASHBOARD GRID -->

            <div class="dashboard-grid">


                <!-- QUICK ACTION -->

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <h3>
                            Aksi Cepat
                        </h3>

                    </div>


                    <div class="quick-actions">

                        <a
                            href="berita/tambah.php"
                            class="quick-action"
                        >

                            <i class="bi bi-plus-circle"></i>

                            <span>
                                Tambah Berita
                            </span>

                        </a>


                        <a
                            href="kegiatan/tambah.php"
                            class="quick-action"
                        >

                            <i class="bi bi-calendar-plus"></i>

                            <span>
                                Tambah Kegiatan
                            </span>

                        </a>


                        <a
                            href="anggota/tambah.php"
                            class="quick-action"
                        >

                            <i class="bi bi-person-plus"></i>

                            <span>
                                Tambah Anggota
                            </span>

                        </a>


                        <a
                            href="sertifikat/tambah.php"
                            class="quick-action"
                        >

                            <i class="bi bi-award"></i>

                            <span>
                                Tambah Prestasi
                            </span>

                        </a>

                    </div>

                </div>


                <!-- INFO -->

                <div class="dashboard-card">

                    <div class="dashboard-card-header">

                        <h3>
                            Informasi
                        </h3>

                    </div>

                    <p style="color:#777; font-size:14px; line-height:1.7;">

                        Gunakan menu di sebelah kiri
                        untuk mengelola seluruh konten
                        website KSR PMI Unit Universitas Pasundan.

                    </p>

                    <p style="color:#777; font-size:14px; line-height:1.7;">

                        Data yang ditambahkan melalui
                        panel admin nantinya akan tersimpan
                        di PostgreSQL.

                    </p>

                </div>

            </div>

        </div>

    </main>


    <!-- SIDEBAR SCRIPT -->

    <script>

        const sidebar = document.getElementById("sidebar");
        const sidebarToggle = document.getElementById("sidebarToggle");

        sidebarToggle.addEventListener("click", function () {

            sidebar.classList.toggle("show");

        });

    </script>

</body>

</html>