<?php
// AMBIL KONEKSI
include "koneksi.php";

// QUERY DATA
$scope_query     = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='scope'");
$priority_query  = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='priority_topic'");
$blueprint_query = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='blueprint'");

// footer
  $footer_query = pg_query($conn, "SELECT * FROM footer LIMIT 1");
if (!$footer_query) {
    die("Query footer gagal: " . pg_last_error($conn));
}

$footer = pg_fetch_assoc($footer_query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Research Framework</title>
    <link rel="stylesheet" href="css/styleresearch.css" />
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
      <img src="img/logo.png" alt="logo">
    </div>

    <nav>
      <ul>
        <li><a href="Beranda.php">Beranda</a></li>
        <li><a href="Produk.php">Produk</a></li>
        <li><a href="Mitra.php">Mitra</a></li>
        <li><a href="Berita.php">Berita</a></li>
        <li><a href="Galeri.php">Galeri</a></li>
        <li><a href="layanan.php">Layanan</a></li>
      </ul>
    </nav>
  </div>
</header>

<!-- HERO -->
<div class="hero">
  <img src="img/gedung-sipil.jpg" alt="hero">
  <h1>RESEARCH FRAMEWORK</h1>
</div>

<!-- SCOPE SECTION -->
<!-- SCOPE SECTION -->
<section class="scope-section">
  <h2>SCOPE</h2>

  <div class="scope-container">
    <?php 
    $scope_data = [];
    while ($row = pg_fetch_assoc($scope_query)) {
      $scope_data[] = $row;
    }
    
    $total = count($scope_data);
    foreach ($scope_data as $index => $row) { 
      // Tambahkan class center-card jika item ganjil dan ini item terakhir
      $extra_class = ($total % 2 != 0 && $index == $total - 1) ? ' center-card' : '';
    ?>
      <div class="scope-card<?= $extra_class ?>">
        <div class="icon-circle">
          <img src="<?= $row['icon_rf'] ?>" width="64">
        </div>
        <h3><?= $row['judul_rf'] ?></h3>
        <p><?= $row['deskripsi_rf'] ?></p>
      </div>
    <?php } ?>
  </div>
</section>

<!-- PRIORITY IMAGE SECTION -->
<section class="priority-img-section">
  <h2>PRIORITY RESEARCH TOPICS</h2>

  <div class="priority-img-cards">
    <?php while ($row = pg_fetch_assoc($priority_query)) { ?>
      <div class="priority-chip">
        <div class="chip-icon">
          <img src="<?= $row['icon_rf'] ?>" width="64">
        </div>
        <?= $row['deskripsi_rf'] ?>
      </div>
    <?php } ?>
  </div>
</section>

<!-- PRIORITY GRID SECTION -->
<section class="priority-grid-section">
  <h2>PRIORITY RESEARCH TOPICS</h2>

  <div class="grid-container">
    <?php while ($row = pg_fetch_assoc($blueprint_query)) { ?>
      <div class="grid-card">
        <div class="grid-icon">
          <img src="<?= $row['icon_rf'] ?>" width="64">
        </div>
        <h3><?= $row['judul_rf'] ?></h3>
        <p><?= $row['deskripsi_rf'] ?></p>
      </div>
    <?php } ?>
  </div>
</section>
</body>
<!-- Footer -->
<footer class="footer">
    <div class="footer-top-border"></div>

    <div class="footer-container">
        <!-- Logo + Deskripsi -->
        <div class="footer-col footer-logo">
            <img src="<?= $footer['url_logo'] ?>" alt="Logo" />
            <p><?= $footer['deskripsi_footer'] ?></p>
        </div>

        <!-- Menu -->
        <div class="footer-col">
            <h4>MENU</h4>
            <ul>
                <li><a href="Beranda.php">Beranda</a></li>
                <li><a href="Produk.php">Produk</a></li>
                <li><a href="Mitra.php">Mitra</a></li>
                <li><a href="Berita.php">Berita</a></li>
                <li><a href="Galeri.php">Galeri</a></li>
                <li><a href="Layanan.php">Layanan</a></li>
            </ul>
        </div>

        <!-- Layanan -->
        <div class="footer-col">
            <h4>LAYANAN</h4>
            <ul>
                <li>Pendaftaran Asisten Lab</li>
                <li>Pendaftaran Magang</li>
                <li>Peminjaman Fasilitas</li>
            </ul>
        </div>

        <!-- Jam Kerja -->
        <div class="footer-col">
            <h4>JAM KERJA</h4>
            <ul>
                <li><?= $footer['jam_kerja'] ?></li>
            </ul>
        </div>

        <div class="footer-right">
            <div class="footer-map">
                <iframe
                    src="<?= $footer['link_maps'] ?>"
                    width="360"
                    height="200"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>

            <p><img src="img/footer/email.png" /> <?= $footer['email'] ?></p>

            <p>
                <img src="img/footer/maps.png" /> <?= nl2br($footer['alamat']) ?>
            </p>
        </div>
    </div>

    <div class="footer-bottom-border"></div>

    <div class="footer-bottom">
        Copyright © <?= date("Y") ?> Lab Applied Informatics - Politeknik Negeri Malang. All
        Rights Reserved.
    </div>
</footer>
</html>
