<?php
require 'koneksi.php';
include 'Navbar.php';

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
