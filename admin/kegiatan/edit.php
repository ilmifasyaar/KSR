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

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Kegiatan</title>

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


<aside class="sidebar">

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

            <h1>Edit Kegiatan</h1>

            <span>
                Perbarui data kegiatan
            </span>

        </div>

    </header>


    <section class="content">

        <div class="form-card">

            <div class="form-card-header">

                <h2>
                    Edit Kegiatan
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

                    <label>
                        Judul Kegiatan
                    </label>

                    <input
                        type="text"
                        name="judul"
                        maxlength="150"
                        value="<?= htmlspecialchars(
                            $_POST["judul"] ?? $kegiatan["judul"]
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Kategori
                        </label>

                        <select
                            name="id_kategori"
                            required
                        >

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            <?php foreach ($kategori as $item): ?>

                                <?php
                                $selected =
                                    ($_POST["id_kategori"] ?? $kegiatan["id_kategori"])
                                    == $item["id_kategori"];
                                ?>

                                <option
                                    value="<?= $item["id_kategori"] ?>"
                                    <?= $selected ? "selected" : "" ?>
                                >

                                    <?= htmlspecialchars(
                                        $item["nama_kategori"]
                                    ) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="<?= htmlspecialchars(
                                $_POST["tanggal"] ?? $kegiatan["tanggal"]
                            ) ?>"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Gambar Saat Ini
                    </label>

                    <?php if (!empty($kegiatan["gambar"])): ?>

                        <div class="current-image">

                            <img
                                src="../../uploads/kegiatan/<?= htmlspecialchars($kegiatan["gambar"]) ?>"
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

                    <label>
                        Ganti Gambar
                    </label>

                    <input
                        type="file"
                        name="gambar"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small>
                        Kosongkan jika tidak ingin mengganti gambar.
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="7"
                        required
                    ><?= htmlspecialchars(
                        $_POST["deskripsi"] ?? $kegiatan["deskripsi"]
                    ) ?></textarea>

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
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </section>

</main>

</body>
</html>