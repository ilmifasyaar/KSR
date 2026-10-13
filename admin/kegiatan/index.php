
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

// Pengaturan navbar
$pageHeading = "Kegiatan";
$pageDescription = "Kelola kegiatan KSR PMI UNPAS";
$currentPage = "kegiatan";

require_once __DIR__ . "/../assets/navbar.php";
?>

<!-- CONTENT KEGIATAN -->
<section class="content">

    <div class="content-header">

        <div>
            <h2>Data Kegiatan</h2>

            <p>
                Kelola data kegiatan yang ditampilkan pada website.
            </p>
        </div>

        <div class="header-actions">

            <!-- FILTER KATEGORI -->
            <form method="GET" action="" class="category-filter">

                <i class="bi bi-funnel"></i>

                <select name="kategori" onchange="this.form.submit()">

                    <option value="">
                        Semua Kategori
                    </option>

                    <?php foreach ($kategori as $itemKategori): ?>

                        <option
                            value="<?= htmlspecialchars((string) $itemKategori['id_kategori']) ?>"
                            <?= ($selectedKategori == $itemKategori['id_kategori']) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($itemKategori['nama_kategori']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </form>

            <!-- TAMBAH KEGIATAN -->
            <a href="tambah.php" class="btn-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah Kegiatan
            </a>

        </div>

    </div>

    <!-- TABEL KEGIATAN -->
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

                                <!-- NOMOR -->
                                <td>
                                    <?= $index + 1 ?>
                                </td>

                                <!-- GAMBAR -->
                                <td>

                                    <?php if (!empty($item["gambar"])): ?>

                                        <img
                                            src="../uploads/kegiatan/<?= htmlspecialchars($item["gambar"]) ?>"
                                            alt="<?= htmlspecialchars($item["judul"]) ?>"
                                            class="activity-image"
                                        >

                                    <?php else: ?>

                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    <?php endif; ?>

                                </td>

                                <!-- JUDUL -->
                                <td>
                                    <div class="activity-title">
                                        <?= htmlspecialchars($item["judul"]) ?>
                                    </div>
                                </td>

                                <!-- KATEGORI -->
                                <td>
                                    <span class="category-badge">
                                        <?= htmlspecialchars($item["nama_kategori"]) ?>
                                    </span>
                                </td>

                                <!-- DESKRIPSI -->
                                <td>
                                    <div class="activity-description">
                                        <?= htmlspecialchars($item["deskripsi"]) ?>
                                    </div>
                                </td>

                                <!-- TANGGAL -->
                                <td>
                                    <?= date(
                                        "d M Y",
                                        strtotime($item["tanggal"])
                                    ) ?>
                                </td>

                                <!-- AKSI -->
                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="edit.php?id=<?= urlencode((string) $item["id"]) ?>"
                                            class="btn-action btn-edit"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <a
                                            href="hapus.php?id=<?= urlencode((string) $item["id"]) ?>"
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

<?php require_once __DIR__ . "/../assets/footer.php"; ?>
