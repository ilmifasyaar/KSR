<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}


/* =========================
   AMBIL DATA KEGIATAN
========================= */

$stmt = $pdo->prepare("
    SELECT *
    FROM kegiatan
    WHERE id = :id
");

$stmt->execute([
    ":id" => $id
]);

$kegiatan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kegiatan) {

    header("Location: index.php");
    exit;

}


/* =========================
   AMBIL KATEGORI
========================= */

$stmtKategori = $pdo->query("
    SELECT id_kategori, nama_kategori
    FROM kategori
    ORDER BY nama_kategori ASC
");

$kategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $judul = trim($_POST["judul"] ?? "");
    $deskripsi = trim($_POST["deskripsi"] ?? "");
    $tanggal = $_POST["tanggal"] ?? "";
    $id_kategori = (int) ($_POST["id_kategori"] ?? 0);

    $gambarBaru = null;


    if (
        $judul === "" ||
        $deskripsi === "" ||
        $tanggal === "" ||
        $id_kategori <= 0
    ) {

        $error = "Semua field wajib diisi.";

    } else {


        /* =========================
           UPLOAD GAMBAR BARU
        ========================= */

        if (
            isset($_FILES["gambar"]) &&
            $_FILES["gambar"]["error"] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES["gambar"]["error"] !== UPLOAD_ERR_OK) {

                $error = "Gagal mengupload gambar.";

            } elseif ($_FILES["gambar"]["size"] > 5 * 1024 * 1024) {

                $error = "Ukuran gambar maksimal 5MB.";

            } else {

                $finfo = new finfo(FILEINFO_MIME_TYPE);

                $mime = $finfo->file(
                    $_FILES["gambar"]["tmp_name"]
                );

                $allowed = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp"
                ];

                if (!isset($allowed[$mime])) {

                    $error = "Format gambar tidak valid.";

                } else {

                    $extension = $allowed[$mime];

                    $gambarBaru =
                        uniqid("kegiatan_", true)
                        . "."
                        . $extension;

                    $uploadDir = "../../uploads/kegiatan/";

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    if (
                        !move_uploaded_file(
                            $_FILES["gambar"]["tmp_name"],
                            $uploadDir . $gambarBaru
                        )
                    ) {

                        $error = "Gagal menyimpan gambar.";

                        $gambarBaru = null;
                    }
                }
            }
        }


        /* =========================
           UPDATE
        ========================= */

        if ($error === "") {

            try {

                if ($gambarBaru) {

                    $stmt = $pdo->prepare("
                        UPDATE kegiatan
                        SET
                            judul = :judul,
                            gambar = :gambar,
                            deskripsi = :deskripsi,
                            tanggal = :tanggal,
                            id_kategori = :id_kategori
                        WHERE id = :id
                    ");

                    $stmt->execute([
                        ":judul" => $judul,
                        ":gambar" => $gambarBaru,
                        ":deskripsi" => $deskripsi,
                        ":tanggal" => $tanggal,
                        ":id_kategori" => $id_kategori,
                        ":id" => $id
                    ]);

                    if (
                        !empty($kegiatan["gambar"]) &&
                        file_exists(
                            "../../uploads/kegiatan/"
                            . $kegiatan["gambar"]
                        )
                    ) {

                        unlink(
                            "../../uploads/kegiatan/"
                            . $kegiatan["gambar"]
                        );

                    }

                } else {

                    $stmt = $pdo->prepare("
                        UPDATE kegiatan
                        SET
                            judul = :judul,
                            deskripsi = :deskripsi,
                            tanggal = :tanggal,
                            id_kategori = :id_kategori
                        WHERE id = :id
                    ");

                    $stmt->execute([
                        ":judul" => $judul,
                        ":deskripsi" => $deskripsi,
                        ":tanggal" => $tanggal,
                        ":id_kategori" => $id_kategori,
                        ":id" => $id
                    ]);
                }


                header("Location: index.php");
                exit;

            } catch (PDOException $e) {

                if (
                    $gambarBaru &&
                    file_exists(
                        "../../uploads/kegiatan/"
                        . $gambarBaru
                    )
                ) {

                    unlink(
                        "../../uploads/kegiatan/"
                        . $gambarBaru
                    );

                }

                $error = "Gagal memperbarui kegiatan.";
            }
        }
    }
}
/* =========================
   PENGATURAN NAVBAR
========================= */

$pageHeading = "Edit Kegiatan";
$pageDescription = "Perbarui data kegiatan";
$currentPage = "kegiatan";

require_once __DIR__ . "/../assets/navbar.php";
?>


```php
<section class="content">

    <div class="page-title">

        <h1>Edit Kegiatan</h1>

        <span>
            Perbarui data kegiatan
        </span>

    </div>

    <div class="form-card">

        <div class="form-card-header">

            <h2>Edit Kegiatan</h2>

            <a href="index.php" class="btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </div>

        <?php if ($error): ?>

            <div class="alert-error">
                <i class="bi bi-exclamation-circle"></i>

                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>

        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">

                <label for="judul">Judul Kegiatan</label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    maxlength="150"
                    value="<?= htmlspecialchars($_POST["judul"] ?? $kegiatan["judul"], ENT_QUOTES, "UTF-8") ?>"
                    required
                >

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label for="id_kategori">Kategori</label>

                    <select id="id_kategori" name="id_kategori" required>

                        <option value="">-- Pilih Kategori --</option>

                        <?php foreach ($kategori as $item): ?>

                            <?php
                            $selected =
                                ($_POST["id_kategori"] ?? $kegiatan["id_kategori"])
                                == $item["id_kategori"];
                            ?>

                            <option
                                value="<?= htmlspecialchars((string) $item["id_kategori"], ENT_QUOTES, "UTF-8") ?>"
                                <?= $selected ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($item["nama_kategori"], ENT_QUOTES, "UTF-8") ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="tanggal">Tanggal</label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="<?= htmlspecialchars($_POST["tanggal"] ?? $kegiatan["tanggal"], ENT_QUOTES, "UTF-8") ?>"
                        required
                    >

                </div>

            </div>

            <div class="form-group">

                <label>Gambar Saat Ini</label>

                <?php if (!empty($kegiatan["gambar"])): ?>

                    <div class="current-image">

                        <img
                            src="../../uploads/kegiatan/<?= htmlspecialchars($kegiatan["gambar"], ENT_QUOTES, "UTF-8") ?>"
                            alt="Gambar kegiatan"
                        >

                    </div>

                <?php else: ?>

                    <div class="no-image">
                        <i class="bi bi-image"></i>
                    </div>

                <?php endif; ?>

            </div>

            <div class="form-group">

                <label for="gambar">Ganti Gambar</label>

                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Kosongkan jika tidak ingin mengganti gambar.
                    Format JPG, PNG, atau WEBP, maksimal 5MB.
                </small>

            </div>

            <div class="form-group">

                <label for="deskripsi">Deskripsi</label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="7"
                    required
                ><?= htmlspecialchars($_POST["deskripsi"] ?? $kegiatan["deskripsi"], ENT_QUOTES, "UTF-8") ?></textarea>

            </div>

            <div class="form-actions">

                <a href="index.php" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</section>

<?php require_once __DIR__ . "/../assets/footer.php"; ?>
```