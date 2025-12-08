<?php
// AMBIL KONEKSI
include "koneksi.php";
include "Navbar.php";

// QUERY DATA
$scope_query     = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='scope'");
$priority_query  = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='priority_topic'");
$blueprint_query = pg_query($conn, "SELECT * FROM research_framework WHERE tipe_rf='blueprint'");
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
<?php include 'footer.php'; ?>
</html>
