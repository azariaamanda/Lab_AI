<?php
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/StyleNavbar.css">
  <link rel="stylesheet" href="css/StyleProduk.css">
  <link rel="stylesheet" href="css/StyleFooter.css">
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
  <h1>PRODUK</h1>
</div>


<!-- PRODUK SECTION -->
<div class="container">

<?php
// ambil semua data produk
$query = "SELECT * FROM produk ORDER BY id_produk ASC";
$result = pg_query($conn, $query);

$no = 1;
while ($row = pg_fetch_assoc($result)) :
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

      <a href="<?= $row['url_produk']; ?>" 
         target="_blank" 
         class="btn-gunakan"><?= $row['teks_button']; ?></a>
    </div>
  </div>

<?php 
$no++;
endwhile; 
?>
</div> 
<?php include 'footer.php'; ?>
</body>
</html>
