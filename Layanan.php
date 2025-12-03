<?php
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- LINK CSS -->
    <link rel="stylesheet" href="StyleNavbar.css">
    <link rel="stylesheet" href="StyleLayanan.css">
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
    <img src="img/logo/gedung-sipil.jpg" alt="hero"/>
    <h1>LAYANAN</h1>
</div>

<!-- INTRO -->
<section class="intro">
    <p>Ajukan permohonan dan akses berbagai layanan yang tersedia di laboratorium kami</p>
</section>

<!-- CARDS -->
<section class="cards">

    <div class="card">
        <div class="icon">
            <img src="img/icon-layanan/Pendaftaran Aslab.png" alt="">
        </div>
        <h3>Pendaftaran Asisten Lab</h3>
        <p>Daftar sebagai Asisten Laboratorium. Dapatkan pengalaman praktis dan kembangkan keterampilan teknis Anda.</p>
        <a href="PendaftaranAslab.php" class="btn">Daftar Sekarang</a>
    </div>

    <div class="card">
        <div class="icon">
            <img src="img/icon-layanan/Pendaftaran Magang.png" alt="">
        </div>
        <h3>Pendaftaran Magang</h3>
        <p>Dapatkan pengalaman kerja nyata dan kesempatan belajar langsung dari praktisi berpengalaman.</p>
        <a href="prosespendaftaran.php" class="btn">Daftar Sekarang</a>
    </div>

    <div class="card">
        <div class="icon">
            <img src="img/icon-layanan/Peminjaman fasilitas.png" alt="">
        </div>
        <h3>Peminjaman Fasilitas</h3>
        <p>Ajukan peminjaman fasilitas laboratorium untuk mendukung kegiatan akademik dan penelitian.</p>
        <a href="peminjaman.php" class="btn">Ajukan Peminjaman</a>
    </div>

</section>

<?php include 'footer.php'; ?>
</body>
</html>
