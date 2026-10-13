
<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

$error = "";

$stmtKategori = $pdo->query("
    SELECT id_kategori, nama_kategori
    FROM kategori
    ORDER BY nama_kategori ASC
");

$kategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $judul = trim($_POST["judul"] ?? "");
    $deskripsi = trim($_POST["deskripsi"] ?? "");
    $tanggal = $_POST["tanggal"] ?? "";
    $id_kategori = (int) ($_POST["id_kategori"] ?? 0);

    $gambar = null;

    if (
        $judul === "" ||
        $deskripsi === "" ||
        $tanggal === "" ||
        $id_kategori <= 0
    ) {

        $error = "Semua field wajib diisi.";

    } else {

        /* =========================
           UPLOAD GAMBAR
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

                    $extension = $allowed[$mime];

                    $gambar = uniqid("kegiatan_", true) . "." . $extension;

                    $uploadDir = "../uploads/kegiatan/";

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    if (
                        !move_uploaded_file(
                            $tmpName,
                            $uploadDir . $gambar
                        )
                    ) {

                        $error = "Gagal menyimpan gambar.";
                        $gambar = null;
                    }
                }
            }
        }

        /* =========================
           INSERT DATABASE
        ========================= */

        if ($error === "") {

            try {

                $stmt = $pdo->prepare("
                    INSERT INTO kegiatan
                    (
                        judul,
                        gambar,
                        deskripsi,
                        tanggal,
                        id_kategori
                    )
                    VALUES
                    (
                        :judul,
                        :gambar,
                        :deskripsi,
                        :tanggal,
                        :id_kategori
                    )
                ");

                $stmt->execute([
                    ":judul" => $judul,
                    ":gambar" => $gambar,
                    ":deskripsi" => $deskripsi,
                    ":tanggal" => $tanggal,
                    ":id_kategori" => $id_kategori
                ]);

                header("Location: index.php");
                exit;

            } catch (PDOException $e) {

                if (
                    $gambar &&
                    file_exists("../uploads/kegiatan/" . $gambar)
                ) {
                    unlink("../uploads/kegiatan/" . $gambar);
                }

                $error = "Gagal menyimpan data kegiatan.";
            }
        }
    }
}

/* =========================
   PENGATURAN NAVBAR
========================= */

$pageHeading = "Tambah Kegiatan";
$pageDescription = "Tambahkan kegiatan baru";
$currentPage = "kegiatan";

require_once __DIR__ . "/../assets/navbar.php";
?>

<!-- CONTENT -->

<section class="content">

    <div class="form-card">

        <div class="form-card-header">

            <h2>
                Form Kegiatan
            </h2>

            <a
                href="index.php"
                class="btn-secondary"
            >
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

        <form
            method="POST"
            enctype="multipart/form-data"
        >

            <div class="form-group">

                <label for="judul">
                    Judul Kegiatan
                </label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    maxlength="150"
                    value="<?= htmlspecialchars($_POST["judul"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                    placeholder="Masukkan judul kegiatan"
                    required
                >

            </div>

            <div class="form-row">

                <div class="form-group">

                    <label for="id_kategori">
                        Kategori
                    </label>

                    <select
                        id="id_kategori"
                        name="id_kategori"
                        required
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        <?php foreach ($kategori as $item): ?>

                            <option
                                value="<?= htmlspecialchars((string) $item["id_kategori"], ENT_QUOTES, "UTF-8") ?>"
                                <?= (
                                    ($_POST["id_kategori"] ?? "") == $item["id_kategori"]
                                ) ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($item["nama_kategori"], ENT_QUOTES, "UTF-8") ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="tanggal">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="<?= htmlspecialchars($_POST["tanggal"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                        required
                    >

                </div>

            </div>

            <div class="form-group">

                <label for="gambar">
                    Gambar Kegiatan
                </label>

                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Format JPG, PNG, WEBP. Maksimal 5MB.
                </small>

            </div>

            <div class="form-group">

                <label for="deskripsi">
                    Deskripsi
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="7"
                    placeholder="Masukkan deskripsi kegiatan"
                    required
                ><?= htmlspecialchars($_POST["deskripsi"] ?? "", ENT_QUOTES, "UTF-8") ?></textarea>

            </div>

            <div class="form-actions">

                <a
                    href="index.php"
                    class="btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    <i class="bi bi-save"></i>
                    Simpan Kegiatan
                </button>

            </div>

        </form>

    </div>

</section>

<?php require_once __DIR__ . "/../assets/footer.php"; ?>
