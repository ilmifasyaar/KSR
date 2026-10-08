<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
    exit;
}


/* Ambil gambar */

$stmt = $pdo->prepare("
    SELECT gambar
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


try {

    $stmt = $pdo->prepare("
        DELETE FROM kegiatan
        WHERE id = :id
    ");

    $stmt->execute([
        ":id" => $id
    ]);


    /* Hapus file gambar */

    if (!empty($kegiatan["gambar"])) {

        $file =
            "../../uploads/kegiatan/"
            . $kegiatan["gambar"];

        if (file_exists($file)) {
            unlink($file);
        }

    }

} catch (PDOException $e) {

    die("Gagal menghapus kegiatan.");

}


header("Location: index.php");
exit;