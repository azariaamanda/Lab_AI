<?php
include "koneksi.php";
include 'Navbar.php';

$filter = isset($_GET['kategori']) ? $_GET['kategori'] : "all";

// statistik
$total_foto   = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri WHERE id_jenis_galeri = 1"), 0, 0);
$total_video  = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri WHERE id_jenis_galeri = 2"), 0, 0);
$total_kegiatan = pg_fetch_result(pg_query($conn, "SELECT COUNT(*) FROM galeri"), 0, 0);
$tahun = date("Y");

// filter 
if ($filter === "all") {
    $query = pg_query($conn, 
        "SELECT * FROM galeri ORDER BY id_galeri DESC" // Sebaiknya tambahkan paginasi di sini
    );
} else {
    $id_kategori = intval($filter);
    // Gunakan parameterized query untuk keamanan
    $query = pg_query_params($conn, 
        "SELECT * FROM galeri 
         WHERE id_kategori_galeri = $1 
         ORDER BY id_galeri DESC",
        array($id_kategori)
    );
}


// CEK ERROR
if (!$query) {
    die("Query galeri gagal: " . pg_last_error($conn));
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stylegaleri.css">
    <link rel="stylesheet" href="css/styleFooter.css">
</head>

<body>

<!-- HEADER BERITA -->
<section class="berita-header" style="background-image: url('img/header/headerjti.jpg');">
    <div class="overlay">
        <div class="container">
            <h1 class="berita-title">BERITA</h1>
        </div>
    </div>
</section>

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
  <!-- Implementasi paginasi diperlukan di sini -->
  <!-- <button>&laquo; Previous</button> -->
  <!-- <button>Next &raquo;</button> -->
</div>
</body>
<?php include 'footer.php'; ?>
</html>
