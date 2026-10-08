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


    if ($judul === "" || $deskripsi === "" || $tanggal === "" || $id_kategori <= 0) {

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

                if ($gambar && file_exists("../uploads/kegiatan/" . $gambar)) {

                    unlink("../uploads/kegiatan/" . $gambar);

                }

                $error = "Gagal menyimpan data kegiatan.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Kegiatan</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="/KSR/admin/assets/admin.css"
    >

</head>

<body>


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


<main class="main-content">

    <header class="topbar">

        <div class="page-title">

            <button
                class="sidebar-toggle"
                id="sidebarToggle"
            >
                <i class="bi bi-list"></i>
            </button>

            <div>

                <h1>Tambah Kegiatan</h1>

                <span>
                    Tambahkan kegiatan baru
                </span>

            </div>

        </div>

    </header>


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

                    <?= htmlspecialchars($error) ?>

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
                        value="<?= htmlspecialchars($_POST["judul"] ?? "") ?>"
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
                                    value="<?= $item["id_kategori"] ?>"
                                    <?= (
                                        ($_POST["id_kategori"] ?? "") == $item["id_kategori"]
                                    ) ? "selected" : "" ?>
                                >

                                    <?= htmlspecialchars($item["nama_kategori"]) ?>

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
                            value="<?= htmlspecialchars($_POST["tanggal"] ?? "") ?>"
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
                    ><?= htmlspecialchars($_POST["deskripsi"] ?? "") ?></textarea>

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