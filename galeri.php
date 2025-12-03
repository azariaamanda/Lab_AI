<?php
include "koneksi.php";

$filter = isset($_GET['kategori']) ? $_GET['kategori'] : "all";

// statistik
$total_foto   = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri WHERE id_jenis_galeri = 1"), 0, 0);
$total_video  = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri WHERE id_jenis_galeri = 2"), 0, 0);
$total_kegiatan = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri"), 0, 0);
$tahun = date("Y");

// filter 
if ($filter === "all") {
    $query = pg_query($conn, 
        "SELECT * FROM galeri ORDER BY id_galeri DESC"
    );
} else {
    $id = intval($filter);
    $query = pg_query($conn, 
        "SELECT * FROM galeri 
         WHERE id_kategori_galeri = $id 
         ORDER BY id_galeri DESC"
    );
}


// CEK ERROR
if (!$query) {
    die("Query galeri gagal: " . pg_last_error($conn));
}

// footer
  $footer_query = pg_query($conn, "SELECT * FROM footer LIMIT 1");
if (!$footer_query) {
    die("Query footer gagal: " . pg_last_error($conn));
}

$footer = pg_fetch_assoc($footer_query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
    <link rel="stylesheet" href="css/stylegaleri.css">
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
  <h1>GALERI</h1>
</div>

<!-- STATISTIK -->
<div class="stats">
  <div class="stats-box">
    <h2><?= $total_foto ?></h2>
    <p>Total Foto</p>
  </div>

  <div class="stats-box">
    <h2><?= $total_video ?></h2>
    <p>Video Dokumentasi</p>
  </div>

  <div class="stats-box">
    <h2><?= $total_kegiatan ?></h2>
    <p>Total Kegiatan</p>
  </div>

  <div class="stats-box">
    <h2><?= $tahun ?></h2>
    <p>Tahun Sekarang</p>
  </div>
</div>

<!-- FILTER -->
<div class="filter">
  <a href="galeri.php?kategori=all">
    <button class="filter-btn <?= $filter=='all' ? 'active':'' ?>">Semua</button>
  </a>

  <a href="galeri.php?kategori=1">
    <button class="filter-btn <?= $filter==1 ? 'active':'' ?>">Riset</button>
  </a>

  <a href="galeri.php?kategori=2">
    <button class="filter-btn <?= $filter==2 ? 'active':'' ?>">Kegiatan Lab</button>
  </a>

  <a href="galeri.php?kategori=3">
    <button class="filter-btn <?= $filter==3 ? 'active':'' ?>">Kompetisi</button>
  </a>

  <a href="galeri.php?kategori=4">
    <button class="filter-btn <?= $filter==4 ? 'active':'' ?>">Kolaborasi</button>
  </a>

  <a href="galeri.php?kategori=5">
    <button class="filter-btn <?= $filter==5 ? 'active':'' ?>">Workshop</button>
  </a>

  <a href="galeri.php?kategori=6">
    <button class="filter-btn <?= $filter==6 ? 'active':'' ?>">Pengabdian</button>
  </a>
</div>

<!-- GALLERY -->
<div class="gallery-grid">

  <?php $no = 1; while ($row = pg_fetch_assoc($query)) : ?>
    <div class="grid-item item<?= $no ?>">
      <div class="effect effect-one">
        <img src="<?= $row['media_galeri'] ?>" alt="Galeri">

        <div class="tab-text">
          <h2><?= $row['judul_galeri'] ?? 'Judul Galeri' ?></h2>
        </div>
      </div>
    </div>
  <?php $no++; endwhile; ?>

</div>

<!-- PAGINATION -->
<div class="pagination">
  <button>&laquo; Previous</button>
  <button>Next &raquo;</button>
</div>
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
