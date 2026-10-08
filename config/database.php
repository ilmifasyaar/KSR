<?php

$host = "localhost";
$port = "5432";
$dbname = "ksr";
$username = "postgres";
$password = "revan2712";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Koneksi PostgreSQL gagal: " . $e->getMessage());
}