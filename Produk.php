<?php
require 'koneksi.php';
include 'Navbar.php';

// Query navbar
$nav_query  = "SELECT * FROM vw_navbar ORDER BY id_navbar";
$nav_result = pg_query($conn, $nav_query);

// Query produk
$query  = "SELECT * FROM produk ORDER BY id_produk ASC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk</title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/StyleProduk.css">
  <link rel="stylesheet" href="css/StyleFooter.css">
</head>

<body>

<header class="header-section">
  <div class="header-bg">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8"/>
      <path opacity="0.9" d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z" fill="white"/>
    </svg>
  </div>

  <div class="container">
    <div class="header-content">
      <div class="logo-section">
        <img src="img/logo/logo.png" alt="Lab AI Logo" class="logo">
      </div>
      <nav class="navbar-section">
        <ul class="nav-menu">
          <?php while($nav = pg_fetch_assoc($nav_result)): ?>
            <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) === basename($nav['url_nav'])) ? 'active' : '' ?>">
              <a href="<?= htmlspecialchars($nav['url_nav']); ?>" class="nav-link">
                <?= htmlspecialchars($nav['nama_navbar']); ?>
              </a>
            </li>
          <?php endwhile; ?>
        </ul>
      </nav>

      <div class="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </div>
</header>


<!-- HEADER PRODUK -->
<section class="berita-header" style="background-image: url('img/header/headerjti.jpg');">
  <div class="overlay">
    <div class="container">
      <h1 class="berita-title">PRODUK</h1>
    </div>
  </div>
</section>

<section class="kategori-section">
  <div class="container produk-wrapper">
    <?php 
      $no = 1;
      while ($row = pg_fetch_assoc($result)): 
    ?>
    <div class="produk-card">
      <input type="checkbox" id="produk<?= $no ?>" class="toggle">
      <label for="produk<?= $no ?>" class="produk-header">
        <div class="produk-left">
          <img src="<?= $row['logo_produk']; ?>" class="produk-logo" alt="logo-produk">
        </div>
        <div class="dropdown-icon">
          <span class="circle-indicator"></span>
          <span class="simple-arrow"></span>
        </div>
      </label>
      <div class="produk-content">
        <p><?= $row['deskripsi_produk']; ?></p>
        <a href="<?= $row['url_produk']; ?>" target="_blank" class="btn-gunakan">
          <?= $row['teks_button']; ?>
        </a>
      </div>
    </div>
    <?php
    $no++;
    endwhile;
    ?>
  </div>
</section>

<?php include 'footer.php';?>

</body>
</html>
