```php
<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $judul = trim($_POST["judul"] ?? "");
    $deskripsi = trim($_POST["deskripsi"] ?? "");
    $tanggal = $_POST["tanggal"] ?? "";
    $gambar = null;

    if ($judul === "" || $deskripsi === "" || $tanggal === "") {
        $error = "Judul, deskripsi, dan tanggal wajib diisi.";
    } elseif (
        !isset($_FILES["gambar"]) ||
        $_FILES["gambar"]["error"] === UPLOAD_ERR_NO_FILE
    ) {
        $error = "Gambar sertifikat wajib diunggah.";
    } elseif ($_FILES["gambar"]["error"] !== UPLOAD_ERR_OK) {
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

            if (!is_dir($uploadDir) &&
                !mkdir($uploadDir, 0755, true) &&
                !is_dir($uploadDir)
            ) {
                $error = "Folder upload tidak dapat dibuat.";
            } else {

                $gambar = uniqid("sertifikat_", true)
                    . "." . $allowed[$mime];

                if (!move_uploaded_file($tmpName, $uploadDir . $gambar)) {
                    $error = "Gagal menyimpan gambar.";
                    $gambar = null;
                }
            }
        }
    }

    if ($error === "") {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO sertifikat
                    (judul, gambar, deskripsi, tanggal)
                VALUES
                    (:judul, :gambar, :deskripsi, :tanggal)
            ");

            $stmt->execute([
                ":judul" => $judul,
                ":gambar" => $gambar,
                ":deskripsi" => $deskripsi,
                ":tanggal" => $tanggal
            ]);

            header("Location: index.php?status=tambah");
            exit;

        } catch (PDOException $e) {

            if ($gambar && file_exists($uploadDir . $gambar)) {
                unlink($uploadDir . $gambar);
            }

            $error = "Gagal menyimpan sertifikat. Periksa struktur database.";
        }
    }
}

$pageHeading = "Tambah Sertifikat";
$pageDescription = "Tambahkan sertifikat baru";
$currentPage = "sertifikat";

require_once __DIR__ . "/../assets/navbar.php";
?>

<section class="content">

    <div class="page-title">
        <h1>Tambah Sertifikat</h1>
        <span>Masukkan data sertifikat baru</span>
    </div>

    <div class="form-card">

        <div class="form-card-header">
            <h2>Form Sertifikat</h2>
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
                    value="<?= htmlspecialchars($_POST["judul"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="<?= htmlspecialchars($_POST["tanggal"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Sertifikat</label>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >
                <small>Format JPG, PNG, atau WEBP. Maksimal 5MB.</small>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="7"
                    required
                ><?= htmlspecialchars($_POST["deskripsi"] ?? "", ENT_QUOTES, "UTF-8") ?></textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-secondary">Batal</a>

                <button type="submit" class="btn-primary">
                    <i class="bi bi-save"></i>
                    Simpan Sertifikat
                </button>
            </div>

        </form>

    </div>

</section>

<?php require_once __DIR__ . "/../assets/footer.php"; ?>
```