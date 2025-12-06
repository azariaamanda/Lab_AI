<?php
require 'koneksi.php';
include 'Navbar.php';

$nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
$nav_result = pg_query($conn, $nav_query);

$layanan_query = "SELECT * FROM vw_layanan ORDER BY id_layanan";
$layanan_result = pg_query($conn, $layanan_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan</title>
    <link rel="stylesheet" href="css/StyleLayanan.css">
    <link rel="stylesheet" href="css/StyleFooter.css">
</head>
<body>

<section class="berita-header" style="background-image: url('img/header/headerjti.jpg');">
    <div class="overlay">
        <div class="container">
            <h1 class="berita-title">LAYANAN</h1>
        </div>
    </div>
</section>

<section class="intro">
    <p>Ajukan permohonan dan akses berbagai layanan yang tersedia di laboratorium kami</p>
</section>

<section class="cards">

<?php while($row = pg_fetch_assoc($layanan_result)) : ?>

    <div class="card">
        <div class="icon">
            <img src="img/icon-layanan/<?php echo $row['nama_layanan']; ?>.png" alt="">
        </div>

        <h3><?= $row['nama_layanan']; ?></h3>
        <p><?= $row['deskripsi_layanan']; ?></p>

        <a href="<?= $row['url_layanan']; ?>" class="btn">
            <?= $row['id_layanan'] == 3 ? "Ajukan Peminjaman" : "Daftar Sekarang"; ?>
        </a>
    </div>

<?php endwhile; ?>

</section>

<?php include 'footer.php'; ?>
</body>
</html>
