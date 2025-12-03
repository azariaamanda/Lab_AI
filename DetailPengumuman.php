<?php
require 'koneksi.php';

// Ambil pengumuman terbaru (atau pakai WHERE)
$query = "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 1";
$result = pg_query($conn, $query);

$data = pg_fetch_assoc($result);
$isi = !empty($data['isi_pengumuman']) ? nl2br($data['isi_pengumuman']) : "Belum ada isi pengumuman.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $data['judul_pengumuman']; ?></title>

  <!-- FONT -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="StyleNavbar.css">
  <link rel="stylesheet" href="DPstyle.css">
  <link rel="stylesheet" href="StyleFooter.css">
</head>

<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="nav-bg">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8"/>
      <path opacity="0.9" d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z" fill="white"/>
    </svg>
  </div>

  <div class="nav-content">
    <div class="logo">
      <img src="img/logo/logo.png" alt="logo">
    </div>

    <nav>
      <ul>
        <li><a href="Beranda.php">Beranda</a></li>
        <li><a href="Produk.php">Produk</a></li>
        <li><a href="Mitra.php">Mitra</a></li>
        <li><a href="Berita.php">Berita</a></li>
        <li><a href="Galeri.php">Galeri</a></li>
        <li><a href="Layanan.php">Layanan</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- HERO -->
<div class="hero">
  <img src="img/logo/gedung-sipil.jpg" alt="hero">
  <h1>PENGUMUMAN</h1>
</div>

<!-- CONTENT -->
<div class="content-section">
    <h2><?php echo $data['judul_pengumuman']; ?></h2>

    <div class="date-info">
        📅 <?php echo date("d F Y", strtotime($data['tanggal_pengumuman'])); ?>
    </div>

    <p><?php echo $isi; ?></p>
</div>

<!-- ANNOUNCEMENT SECTION -->
<div class="announcement-section">
    <img src="img/logo/logo.png">
    <h3>PENGUMUMAN</h3>
    <p>Pengumuman dan informasi penting Lab Applied Informatics</p>
    <a href="semua_pengumuman.php" class="btn-explore">Jelajahi Semua Artikel →</a>
</div>

<!-- FOOTER -->
<?php include "footer.php"; ?>

</body>
</html>
