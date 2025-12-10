<?php
require 'koneksi.php';

// Ambil ID berita dari URL
$id_berita = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data navbar
$nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
$nav_result = pg_query($conn, $nav_query);

// Ambil detail berita
$berita_query = "SELECT * FROM vw_berita WHERE id_berita = $id_berita";
$berita_result = pg_query($conn, $berita_query);
$berita = pg_fetch_assoc($berita_result);

// Jika berita tidak ditemukan, redirect ke halaman berita
if (!$berita) {
    header("Location: berita.php");
    exit();
}

// Ambil berita terkait (dari kategori yang sama, exclude berita saat ini)
$related_query = "SELECT * FROM vw_berita 
                  WHERE id_kategori_berita = {$berita['id_kategori_berita']} 
                  AND id_berita != $id_berita 
                  ORDER BY tanggal_berita DESC 
                  LIMIT 3";
$related_result = pg_query($conn, $related_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($berita['judul_berita']); ?> - Lab Applied Informatics</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styleDetailBerita.css">
</head>
<body>
    <!-- HEADER & NAVBAR -->
    <header class="header-section">
        <div class="header-bg">
            <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
                <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8"/>
                <path opacity="0.9" d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z" fill="white"/>
            </svg>
        </div>
        
        <div class="header-content">
            <div class="logo-section">
                <img src="img/logo/logo.png" alt="Lab AI Logo" class="logo">
            </div>
            
            <nav class="navbar-section">
                <ul class="nav-menu">
                    <?php 
                    pg_result_seek($nav_result, 0);
                    while($nav = pg_fetch_assoc($nav_result)): 
                    ?>
                        <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == basename($nav['url_nav'])) ? 'active' : ''; ?>">
                            <a href="<?php echo htmlspecialchars($nav['url_nav']); ?>" class="nav-link">
                                <?php echo htmlspecialchars($nav['nama_navbar']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </nav>
            <?php include 'ProfileRing.php'; ?>
            
            <div class="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- DETAIL BERITA -->
    <section class="detail-berita">
        <div class="container">
            <!-- Header Info -->
            <div class="berita-header-info">
                <div class="berita-meta">
                    <span class="berita-date">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo date('d F Y', strtotime($berita['tanggal_berita'])); ?>
                    </span>
                </div>
                <a href="berita.php" class="btn-back">Riset</a>
            </div>

            <!-- Judul -->
            <h1 class="berita-judul"><?php echo htmlspecialchars($berita['judul_berita']); ?></h1>

            <!-- Gambar Utama -->
            <div class="berita-image">
                <img src="<?php echo htmlspecialchars($berita['gambar_berita'] ?? 'img/berita/default.jpg'); ?>" 
                     alt="<?php echo htmlspecialchars($berita['judul_berita']); ?>"
                     onerror="this.src='img/berita/default.jpg'">
            </div>

            <!-- Konten -->
            <div class="berita-content">
                <?php echo nl2br(htmlspecialchars($berita['isi_berita'])); ?>
            </div>
        </div>
    </section>

    <!-- BERITA TERKAIT -->
    <section class="berita-related">
        <div class="container">
            <div class="section-header">
                <div class="logo-circle">
                    <img src="img/logo/logo-icon.png" alt="Logo">
                </div>
                <h2>BERITA</h2>
            </div>
            <p class="section-subtitle">Riset terbaru, inovasi, dan pencapaian Lab Applied Informatics</p>

            <div class="related-grid">
                <?php while ($related = pg_fetch_assoc($related_result)): ?>
                    <div class="related-card">
                        <div class="related-img">
                            <img src="<?php echo htmlspecialchars($related['gambar_berita'] ?? 'img/berita/default.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($related['judul_berita']); ?>"
                                 onerror="this.src='img/berita/default.jpg'">
                        </div>
                        <div class="related-content">
                            <span class="related-kategori"><?php echo htmlspecialchars($related['nama_kategori_berita']); ?></span>
                            <h3><?php echo htmlspecialchars($related['judul_berita']); ?></h3>
                            <a href="detail_berita.php?id=<?php echo $related['id_berita']; ?>" class="related-link">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="btn-center">
                <a href="berita.php" class="btn-more">
                    Jelajahi Semua Artikel <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.querySelector('.mobile-menu-toggle')?.addEventListener('click', function() {
            document.querySelector('.nav-menu')?.classList.toggle('show');
        });
    </script>
</body>
</html>