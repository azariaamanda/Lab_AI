<?php
include "koneksi.php";


    // AMBIL VISI
    
$qVisi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Visi' LIMIT 1";
$rVisi = pg_query($conn, $qVisi);
$visi = pg_fetch_assoc($rVisi);


    // AMBIL MISI (banyak baris)
$qMisi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Misi' ORDER BY id_profil ASC";
$rMisi = pg_query($conn, $qMisi);

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
    <title>Vision and Mission - Applied Informatics</title>
    <link rel="stylesheet" href="stylevisi.css" />
  </head>
  <body>
    <!-- NAVBAR -->
    <header class="navbar">
      <div class="nav-bg">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
          <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8" />
          <path
            opacity="0.9"
            d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z"
            fill="white"
          />
        </svg>
      </div>

      <div class="nav-content">
        <div class="logo">
          <img src="img/logo.png" alt="logo" />
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
      <img src="img/gedung-sipil.jpg" alt="hero" />
      <h1>VISION AND MISSION</h1>
    </div>

    <!-- VISION -->
    <section class="vision">
      <h1><?= $visi['judul'] ?></h1>
      <p>
        <?= nl2br($visi['isi']) ?>
      </p>
    </section>

    <!-- MISSION -->
    <section class="mission">
      <h1>OUR MISION</h1>

      <?php
      $number = 1;
      while ($m = pg_fetch_assoc($rMisi)) :
      ?>
      <div class="mission-card">
        <div class="number"><?= $number ?></div>
        <div class="text">
          <h3><?= $m['judul'] ?></h3>
          <p><?= nl2br($m['isi']) ?></p>
        </div>
      </div>
      <?php
      $number++;
      endwhile;
      ?>
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
