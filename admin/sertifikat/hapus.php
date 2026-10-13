```php
<?php

require_once "../../includes/auth.php";
require_once "../../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT gambar
    FROM sertifikat
    WHERE id = :id
");

$stmt->execute([":id" => $id]);
$sertifikat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sertifikat) {
    header("Location: index.php");
    exit;
}

try {

    $stmt = $pdo->prepare("
        DELETE FROM sertifikat
        WHERE id = :id
    ");

    $stmt->execute([":id" => $id]);

    /* HAPUS FILE GAMBAR */

    if (!empty($sertifikat["gambar"])) {

        $gambar = basename($sertifikat["gambar"]);
        $gambarPath = __DIR__ . "/../uploads/sertifikat/" . $gambar;

        if (is_file($gambarPath)) {
            unlink($gambarPath);
        }
    }

    header("Location: index.php?status=hapus");
    exit;

} catch (PDOException $e) {

    header("Location: index.php?status=gagal");
    exit;
}