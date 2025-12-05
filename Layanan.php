<?php
require 'koneksi.php';
include 'Navbar.php';

// Ambil data navbar
    $nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
    $nav_result = pg_query($conn, $nav_query);
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
    <link rel="stylesheet" href="css/StyleLayanan.css">
    <link rel="stylesheet" href="css/StyleFooter.css">
</head>
<body>

   <section class="berita-header" style="background-image: url('img/header/headerjti.jpg');">
        <div class="overlay" >
            <div class="container">
                <h1 class="berita-title">BERITA</h1>
            </div>
        </div>
    </section

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
