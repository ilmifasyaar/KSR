
<?php

require_once "../includes/auth.php";

$pageHeading = "Dashboard";
$pageDescription = "Kelola website KSR PMI Unit Universitas Pasundan";
$currentPage = "dashboard";

require_once __DIR__ . "/assets/navbar.php";

?>

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
            <h3>Aksi Cepat</h3>
        </div>

        <div class="quick-actions">

            <a href="berita/tambah.php" class="quick-action">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Berita</span>
            </a>

            <a href="kegiatan/tambah.php" class="quick-action">
                <i class="bi bi-calendar-plus"></i>
                <span>Tambah Kegiatan</span>
            </a>

            <a href="anggota/tambah.php" class="quick-action">
                <i class="bi bi-person-plus"></i>
                <span>Tambah Anggota</span>
            </a>

            <a href="sertifikat/tambah.php" class="quick-action">
                <i class="bi bi-award"></i>
                <span>Tambah Prestasi</span>
            </a>

        </div>

    </div>


    <!-- INFO -->

    <div class="dashboard-card">

        <div class="dashboard-card-header">
            <h3>Informasi</h3>
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

<?php require_once __DIR__ . "/assets/footer.php"; ?>
