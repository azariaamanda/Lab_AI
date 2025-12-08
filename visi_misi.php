<?php
require 'koneksi.php';
include 'Navbar.php';

 // AMBIL VISI
    
$qVisi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Visi' LIMIT 1";
$rVisi = pg_query($conn, $qVisi);
$visi = pg_fetch_assoc($rVisi);


    // AMBIL MISI (banyak baris)
$qMisi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Misi' ORDER BY id_profil ASC";
$rMisi = pg_query($conn, $qMisi);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vision and Mission - Applied Informatics</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylevisi.css" />
    <link rel="stylesheet" href="css/styleFooter.css" />
  </head>
  <body>
    
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

<?php include 'footer.php'; ?>
</html>
