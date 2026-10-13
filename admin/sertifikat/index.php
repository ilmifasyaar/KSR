```php
<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

// Ambil data sertifikat
$stmt = $pdo->query("
    SELECT id, judul, gambar, deskripsi, tanggal
    FROM sertifikat
    ORDER BY tanggal DESC, id DESC
");

$sertifikat = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pengaturan navbar
$pageHeading = "Sertifikat";
$pageDescription = "Kelola sertifikat dan prestasi KSR PMI UNPAS";
$currentPage = "sertifikat";

require_once __DIR__ . "/../assets/navbar.php";
?>

<!-- CONTENT SERTIFIKAT -->
<section class="content">

    <div class="content-header">

        <div>
            <h2>Data Sertifikat</h2>

            <p>
                Kelola sertifikat dan prestasi yang ditampilkan pada website.
            </p>
        </div>

        <!-- TAMBAH SERTIFIKAT -->
        <div class="header-actions">

            <a href="tambah.php" class="btn-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah Sertifikat
            </a>

        </div>

    </div>

    <!-- NOTIFIKASI STATUS -->
    <?php if (isset($_GET["status"]) && $_GET["status"] === "tambah"): ?>

        <div class="alert-success">
            Sertifikat berhasil ditambahkan.
        </div>

    <?php elseif (isset($_GET["status"]) && $_GET["status"] === "edit"): ?>

        <div class="alert-success">
            Sertifikat berhasil diperbarui.
        </div>

    <?php elseif (isset($_GET["status"]) && $_GET["status"] === "hapus"): ?>

        <div class="alert-success">
            Sertifikat berhasil dihapus.
        </div>

    <?php endif; ?>

    <!-- TABEL SERTIFIKAT -->
    <div class="table-card">

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($sertifikat) > 0): ?>

                        <?php foreach ($sertifikat as $index => $item): ?>

                            <tr>

                                <!-- NOMOR -->
                                <td>
                                    <?= $index + 1 ?>
                                </td>

                                <!-- GAMBAR -->
                                <td>

                                    <?php if (!empty($item["gambar"])): ?>

                                        <img
                                            src="../uploads/sertifikat/<?= htmlspecialchars(basename($item["gambar"]), ENT_QUOTES, "UTF-8") ?>"
                                            alt="<?= htmlspecialchars($item["judul"], ENT_QUOTES, "UTF-8") ?>"
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
                                        <?= htmlspecialchars(
                                            $item["judul"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </div>
                                </td>

                                <!-- DESKRIPSI -->
                                <td>
                                    <div class="activity-description">
                                        <?= htmlspecialchars(
                                            mb_strimwidth(
                                                $item["deskripsi"] ?? "",
                                                0,
                                                100,
                                                "...",
                                                "UTF-8"
                                            ),
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </div>
                                </td>

                                <!-- TANGGAL -->
                                <td>
                                    <?= !empty($item["tanggal"])
                                        ? date("d M Y", strtotime($item["tanggal"]))
                                        : "-" ?>
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
                                            onclick="return confirm('Yakin ingin menghapus sertifikat ini?')"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6">

                                <div class="empty-state">

                                    <i class="bi bi-award"></i>

                                    <h3>
                                        Belum Ada Sertifikat
                                    </h3>

                                    <p>
                                        Silakan tambahkan sertifikat baru.
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
