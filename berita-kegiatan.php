<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Berita & Kegiatan | KSR PMI UNPAS</title>
  <link rel="icon" href="assets/img/ksr.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page news-page">
  <nav class="navbar navbar-expand-lg navbar-ksr navbar-inner-page fixed-top"><div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php#beranda"><img src="assets/img/ksr.png" alt="Logo KSR PMI UNPAS" class="navbar-logo"><span class="navbar-brand-text"><strong>KSR PMI</strong><small>UNIVERSITAS PASUNDAN</small></span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navNews" aria-controls="navNews" aria-expanded="false" aria-label="Buka navigasi"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navNews"><ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2"><li class="nav-item"><a class="nav-link" href="index.php#tentang">Tentang</a></li><li class="nav-item"><a class="nav-link" href="berita-kegiatan.php">Kegiatan</a></li><li class="nav-item"><a class="nav-link" href="index.php#struktur">Struktur</a></li><li class="nav-item"><a class="nav-link" href="index.php#birokrasi">Birokrasi</a></li><li class="nav-item"><a class="nav-link" href="index.php#achievement">Pencapaian</a></li></ul></div>
  </div></nav>
  <main class="inner-main">
    <section class="inner-hero news-hero"><div class="container" data-aos="fade-up"><a class="inner-back-link" href="index.php#kegiatan"><i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda</a><span class="section-kicker d-block mt-4">Kabar KSR</span><h1>Berita <span>& Kegiatan</span></h1><p>Ikuti cerita, kegiatan, dan aksi kemanusiaan KSR PMI Unit Universitas Pasundan.</p></div></section>
    <section class="py-5"><div class="container py-2">
      <div class="news-page-toolbar mb-4" data-aos="fade-up"><div><span class="section-kicker">Informasi Terbaru</span><h2 class="text-danger fw-bold mb-1">Cerita dari lapangan</h2><p class="text-muted mb-0">Pilih berita untuk membaca rangkuman lengkap kegiatan.</p></div><div class="news-filter"><label for="sortBerita" class="form-label fw-semibold mb-1">Urutkan berita</label><select id="sortBerita" class="form-select"><option value="terbaru">Terbaru → Terlama</option><option value="terlama">Terlama → Terbaru</option><option value="default">Urutan awal</option></select></div></div>
      <div class="row g-4" id="daftarBerita" aria-live="polite"></div>
      <div class="news-editor-note mt-5"><i class="bi bi-info-circle me-2"></i>Berita pada tampilan ini masih memakai data contoh yang tertanam di front end. Pengelolaan berita dari panel admin memerlukan penyambungan backend pada tahap terpisah.</div>
    </div></section>
  </main>
  <footer class="footer text-white py-4"><div class="container d-flex flex-column flex-md-row justify-content-between gap-2"><span>KSR PMI Unit Universitas Pasundan</span><a class="text-white" href="index.php#beranda">Kembali ke beranda</a><span class="small">© 2026 KSR PMI UNPAS</span></div></footer>
  <div class="modal fade" id="detailBeritaModal" tabindex="-1" aria-labelledby="detailBeritaModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><div><div id="detailTanggal" class="small text-muted mb-1"></div><h2 id="detailBeritaModalLabel" class="modal-title text-danger fw-bold fs-4">Detail Berita</h2></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div><div class="modal-body"><img id="detailGambar" class="img-fluid rounded-3 shadow-sm mb-4 detail-gambar" alt=""><div id="detailKonten" class="detail-konten"></div></div></div></div></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script><script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script><script src="assets/js/script.js"></script>
</body>
</html>
