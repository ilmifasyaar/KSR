```php
<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, judul, gambar, deskripsi, tanggal
    FROM sertifikat
    WHERE id = :id
");

$stmt->execute([":id" => $id]);
$sertifikat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sertifikat) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $judul = trim($_POST["judul"] ?? "");
    $deskripsi = trim($_POST["deskripsi"] ?? "");
    $tanggal = $_POST["tanggal"] ?? "";
    $gambarBaru = null;

    if ($judul === "" || $deskripsi === "" || $tanggal === "") {
        $error = "Judul, deskripsi, dan tanggal wajib diisi.";
    } else {

        /* UPLOAD GAMBAR BARU JIKA DIPILIH */

        if (
            isset($_FILES["gambar"]) &&
            $_FILES["gambar"]["error"] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES["gambar"]["error"] !== UPLOAD_ERR_OK) {
                $error = "Gagal mengunggah gambar.";
            } elseif ($_FILES["gambar"]["size"] > 5 * 1024 * 1024) {
                $error = "Ukuran gambar maksimal 5MB.";
            } else {

                $tmpName = $_FILES["gambar"]["tmp_name"];
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($tmpName);

                $allowed = [
                    "image/jpeg" => "jpg",
                    "image/png"  => "png",
                    "image/webp" => "webp"
                ];

                if (!isset($allowed[$mime])) {
                    $error = "Format gambar harus JPG, PNG, atau WEBP.";
                } else {

                    $uploadDir = __DIR__ . "/../uploads/sertifikat/";

                    if (
                        !is_dir($uploadDir) &&
                        !mkdir($uploadDir, 0755, true) &&
                        !is_dir($uploadDir)
                    ) {
                        $error = "Folder upload tidak dapat dibuat.";
                    } else {

                        $gambarBaru = uniqid("sertifikat_", true)
                            . "." . $allowed[$mime];

                        if (!move_uploaded_file(
                            $tmpName,
                            $uploadDir . $gambarBaru
                        )) {
                            $error = "Gagal menyimpan gambar.";
                            $gambarBaru = null;
                        }
                    }
                }
            }
        }

        /* UPDATE DATA */

        if ($error === "") {

            $uploadDir = __DIR__ . "/../uploads/sertifikat/";

            try {

                if ($gambarBaru !== null) {

                    $stmt = $pdo->prepare("
                        UPDATE sertifikat
                        SET judul = :judul,
                            gambar = :gambar,
                            deskripsi = :deskripsi,
                            tanggal = :tanggal
                        WHERE id = :id
                    ");

                    $stmt->execute([
                        ":judul" => $judul,
                        ":gambar" => $gambarBaru,
                        ":deskripsi" => $deskripsi,
                        ":tanggal" => $tanggal,
                        ":id" => $id
                    ]);

                    /* HAPUS GAMBAR LAMA SETELAH UPDATE BERHASIL */

                    if (!empty($sertifikat["gambar"])) {
                        $gambarLama = basename($sertifikat["gambar"]);

                        if (is_file($uploadDir . $gambarLama)) {
                            unlink($uploadDir . $gambarLama);
                        }
                    }

                } else {

                    $stmt = $pdo->prepare("
                        UPDATE sertifikat
                        SET judul = :judul,
                            deskripsi = :deskripsi,
                            tanggal = :tanggal
                        WHERE id = :id
                    ");

                    $stmt->execute([
                        ":judul" => $judul,
                        ":deskripsi" => $deskripsi,
                        ":tanggal" => $tanggal,
                        ":id" => $id
                    ]);
                }

                header("Location: index.php?status=edit");
                exit;

            } catch (PDOException $e) {

                if (
                    $gambarBaru !== null &&
                    is_file($uploadDir . $gambarBaru)
                ) {
                    unlink($uploadDir . $gambarBaru);
                }

                $error = "Gagal memperbarui sertifikat.";
            }
        }
    }
}

$pageHeading = "Edit Sertifikat";
$pageDescription = "Perbarui data sertifikat";
$currentPage = "sertifikat";

require_once __DIR__ . "/../assets/navbar.php";
?>

<section class="content">

    <div class="page-title">
        <h1>Edit Sertifikat</h1>
        <span>Perbarui data sertifikat</span>
    </div>

    <div class="form-card">

        <div class="form-card-header">
            <h2>Form Edit Sertifikat</h2>

            <a href="index.php" class="btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        <?php if ($error !== ""): ?>
            <div class="alert-error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="judul">Judul Sertifikat</label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    maxlength="150"
                    value="<?= htmlspecialchars($_POST["judul"] ?? $sertifikat["judul"], ENT_QUOTES, "UTF-8") ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>

                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="<?= htmlspecialchars($_POST["tanggal"] ?? $sertifikat["tanggal"], ENT_QUOTES, "UTF-8") ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Gambar Saat Ini</label>

                <?php if (!empty($sertifikat["gambar"])): ?>
                    <div class="current-image">
                        <img
                            src="../uploads/sertifikat/<?= rawurlencode(basename($sertifikat["gambar"])) ?>"
                            alt="Gambar sertifikat"
                            style="max-width: 250px; height: auto;"
                        >
                    </div>
                <?php else: ?>
                    <p>Belum ada gambar.</p>
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
                ><?= htmlspecialchars($_POST["deskripsi"] ?? $sertifikat["deskripsi"], ENT_QUOTES, "UTF-8") ?></textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-secondary">Batal</a>

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