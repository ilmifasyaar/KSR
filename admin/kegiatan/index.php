<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

// Ambil kategori untuk filter
$stmtKategori = $pdo->query("
    SELECT id_kategori, nama_kategori
    FROM kategori
    ORDER BY nama_kategori ASC
");

$kategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

// Ambil kategori yang dipilih
$selectedKategori = $_GET['kategori'] ?? '';

// Query kegiatan
$sql = "
    SELECT
        k.id,
        k.judul,
        k.gambar,
        k.deskripsi,
        k.tanggal,
        k.id_kategori,
        kt.nama_kategori
    FROM kegiatan k
    INNER JOIN kategori kt
        ON k.id_kategori = kt.id_kategori
";

$params = [];

if ($selectedKategori !== '') {
    $sql .= " WHERE k.id_kategori = :id_kategori";
    $params[':id_kategori'] = $selectedKategori;
}

$sql .= " ORDER BY k.tanggal DESC, k.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$kegiatan = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kegiatan - Admin KSR PMI UNPAS</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="/KSR/admin/assets/admin.css?v=2"
    >
</head>

<body>

<!-- SIDEBAR -->

<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">

        <a href="../index.php" class="sidebar-logo">

            <img
                src="../../assets/img/ksr.png"
                alt="Logo KSR"
            >

            <span>KSR PMI UNPAS</span>

        </a>

    </div>

    <nav class="sidebar-menu">

        <div class="menu-title">
            Dashboard
        </div>

        <ul>

            <li>
                <a href="../index.php">
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
                <a href="../berita/index.php">
                    <i class="bi bi-newspaper"></i>
                    <span>Berita</span>
                </a>
            </li>

            <li>
                <a href="index.php" class="active">
                    <i class="bi bi-calendar-event"></i>
                    <span>Kegiatan</span>
                </a>
            </li>

            <li>
                <a href="../kategori/index.php">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li>
                <a href="../anggota/index.php">
                    <i class="bi bi-people"></i>
                    <span>Anggota</span>
                </a>
            </li>

            <li>
                <a href="../struktur/index.php">
                    <i class="bi bi-diagram-3"></i>
                    <span>Struktur Organisasi</span>
                </a>
            </li>

            <li>
                <a href="../sertifikat/index.php">
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
                <a href="../../index.php" target="_blank">
                    <i class="bi bi-globe2"></i>
                    <span>Lihat Website</span>
                </a>
            </li>

            <li>
                <a href="../logout.php" class="logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>

    </nav>

</aside>


<!-- MAIN -->

<main class="main-content">

    <!-- TOPBAR -->

    <header class="topbar">

        <div class="page-title">

            <button
                class="sidebar-toggle"
                id="sidebarToggle"
            >
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h1>Kegiatan</h1>
                <span>Kelola kegiatan KSR PMI UNPAS</span>
            </div>

        </div>


        <div class="admin-profile">

            <div class="admin-avatar">
                <?= strtoupper(substr($_SESSION["admin_nama"], 0, 1)) ?>
            </div>

            <div class="admin-info">

                <strong>
                    <?= htmlspecialchars($_SESSION["admin_nama"]) ?>
                </strong>

                <span>
                    Administrator
                </span>

            </div>

        </div>

    </header>


    <!-- CONTENT -->

    <section class="content">

        <div class="content-header">

            <div>

                <h2>
                    Data Kegiatan
                </h2>

                <p>
                    Kelola data kegiatan yang ditampilkan pada website.
                </p>

            </div>

            <div class="header-actions">

<div class="header-actions">

    <form method="GET" action="" class="category-filter">

        <i class="bi bi-funnel"></i>

        <select name="kategori" onchange="this.form.submit()">

            <option value="">
                Semua Kategori
            </option>

            <?php foreach ($kategori as $itemKategori): ?>

                <option
                    value="<?= $itemKategori['id_kategori'] ?>"
                    <?= ($selectedKategori == $itemKategori['id_kategori']) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($itemKategori['nama_kategori']) ?>
                </option>

            <?php endforeach; ?>

        </select>

    </form>


    <a
        href="tambah.php"
        class="btn-primary"
    >
        <i class="bi bi-plus-lg"></i>
        Tambah Kegiatan
    </a>

</div>



            </div>

        </div>


        <div class="table-card">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Gambar</th>

                            <th>Judul</th>

                            <th>Kategori</th>

                            <th>Deskripsi</th>

                            <th>Tanggal</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if (count($kegiatan) > 0): ?>

                        <?php foreach ($kegiatan as $index => $item): ?>

                            <tr>

                                <td>
                                    <?= $index + 1 ?>
                                </td>


                                <td>

                                    <?php if (!empty($item["gambar"])): ?>

                                        <img
                                            src="../../uploads/kegiatan/<?= htmlspecialchars($item["gambar"]) ?>"
                                            alt="<?= htmlspecialchars($item["judul"]) ?>"
                                            class="activity-image"
                                        >

                                    <?php else: ?>

                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="activity-title">

                                        <?= htmlspecialchars($item["judul"]) ?>

                                    </div>

                                </td>


                                <td>

                                    <span class="category-badge">

                                        <?= htmlspecialchars($item["nama_kategori"]) ?>

                                    </span>

                                </td>


                                <td>

                                    <div class="activity-description">

                                        <?= htmlspecialchars($item["deskripsi"]) ?>

                                    </div>

                                </td>


                                <td>

                                    <?= date(
                                        "d M Y",
                                        strtotime($item["tanggal"])
                                    ) ?>

                                </td>


                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="edit.php?id=<?= $item["id"] ?>"
                                            class="btn-action btn-edit"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a
                                            href="hapus.php?id=<?= $item["id"] ?>"
                                            class="btn-action btn-delete"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus kegiatan ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <i class="bi bi-calendar-x"></i>

                                    <h3>
                                        Belum Ada Kegiatan
                                    </h3>

                                    <p>
                                        Silakan tambahkan kegiatan baru.
                                    </p>



                                </div>

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </section>

</main>


<script>

const sidebarToggle =
    document.getElementById("sidebarToggle");

const sidebar =
    document.getElementById("sidebar");

if (sidebarToggle) {

    sidebarToggle.addEventListener("click", function () {

        sidebar.classList.toggle("show");

    });

}

</script>

</body>
</html>