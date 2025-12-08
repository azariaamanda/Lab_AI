<?php
require 'koneksi.php';

// Ambil filter kategori
$selected_kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

// Ambil kategori
$kategori_query = "SELECT DISTINCT nama_kategori_berita FROM vw_berita ORDER BY nama_kategori_berita";
$kategori_result = pg_query($conn, $kategori_query);

// Ambil berita berdasarkan filter
if ($selected_kategori == 'Semua') {
    $berita_query = "SELECT * FROM vw_berita ORDER BY tanggal_berita DESC";
} else {
    // Menggunakan pg_query_params untuk mencegah SQL Injection
    $berita_query = pg_query_params($conn, "SELECT * FROM vw_berita WHERE nama_kategori_berita = $1 ORDER BY tanggal_berita DESC", array($selected_kategori));
}

$berita_result = pg_query($conn, $berita_query);

// Simpan kategori dalam array
$categories = array();
while ($kat = pg_fetch_assoc($kategori_result)) {
    $categories[] = $kat;
}

//Pengumuman
$pengumuman_query = "SELECT id_pengumuman, judul_pengumuman, tanggal_pengumuman, isi_pengumuman FROM vw_pengumuman ORDER BY tanggal_pengumuman DESC LIMIT 3";
$pengumuman_result = pg_query($conn, $pengumuman_query);

//Agenda
$agenda_query = "SELECT * FROM vw_agenda ORDER BY tanggal_agenda ASC LIMIT 3";
$agenda_result = pg_query($conn, $agenda_query);

?>

<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Beranda - Laboratory Applied Informatics</title>
        
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/styleBerita.css">
        <link rel="stylesheet" href="css/styleFooter.css">
    </head>
    <body>
        <?php
            // Sertakan Navbar di sini agar variabel $nav_result tersedia
            include 'Navbar.php';
            // Reset pointer setelah digunakan di Navbar.php jika perlu
            pg_result_seek($nav_result, 0);
        ?>
        <!-- HEADER & NAVBAR -->
        <header class="header-section">
            <!-- Background SVG -->
            <div class="header-bg">
                <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
                    <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8"/>
                    <path opacity="0.9" d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z" fill="white"/>
                </svg>
            </div>
            
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <div class="logo-section">
                        <div class="logo-img">
                            <img src="img/logo/logo.png" alt="Lab AI Logo" class="logo">
                        </div>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <nav class="navbar-section">
                        <ul class="nav-menu">
                                <?php while($nav = pg_fetch_assoc($nav_result)): ?>
                                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == basename($nav['url_nav'])) ? 'active' : ''; ?>">
                                        <a href="<?php echo htmlspecialchars($nav['url_nav']); ?>" class="nav-link">
                                            <?php echo htmlspecialchars($nav['nama_navbar']); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                        </ul>
                    </nav>
                    
                    <!-- Mobile Menu Toggle -->
                    <div class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </header>

    <!-- HEADER BERITA -->
    <section class="berita-header" style="background-image: url('img/header/headerjti.jpg');">
        <div class="overlay" >
            <div class="container">
                <h1 class="berita-title">BERITA</h1>
            </div>
        </div>
    </section>

    <!-- KATEGORI FILTER -->
   <section class="kategori-section">
    <div class="container kategori-wrapper">
        <div class="kategori-left">
            <h2 class="kategori-label">KATEGORI</h2>
            <span class="kategori-line"></span>
        </div>

        <ul class="kategori-list">
            <li>
                <a href="?kategori=Semua" 
                   class="kategori-link <?php echo $selected_kategori == 'Semua' ? 'active' : ''; ?>">
                    Semua
                </a>
            </li>

            <?php foreach ($categories as $kat): 
                $isActive = ($selected_kategori == $kat['nama_kategori_berita']);
            ?>
            <li>
                <a href="?kategori=<?php echo urlencode($kat['nama_kategori_berita']); ?>" 
                   class="kategori-link <?php echo $isActive ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($kat['nama_kategori_berita']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>


    <!-- LIST BERITA -->
    <section class="berita-section">
        <div class="container">
            <?php if (pg_num_rows($berita_result) > 0): ?>
                <div class="berita-grid">
                    <?php while ($berita = pg_fetch_assoc($berita_result)): ?>
                        <div class="berita-card">
                            <div class="berita-img-container">
                                <img src="<?php echo htmlspecialchars($berita['gambar_berita'] ?? 'img/berita/default.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($berita['judul_berita']); ?>" 
                                     class="berita-img"
                                     onerror="this.src='img/berita/default.jpg'">
                            </div>
                            <div class="berita-content">
                                <div class="berita-meta">
                                    <span class="berita-kategori"><?php echo htmlspecialchars($berita['nama_kategori_berita']); ?></span>
                                    <span class="berita-tanggal">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo date('d F Y', strtotime($berita['tanggal_berita'])); ?>
                                    </span>
                                </div>
                                <h3 class="berita-judul">
                                    <a href="<?php echo htmlspecialchars($berita['link_berita']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($berita['judul_berita']); ?>
                                    </a>
                                </h3>
                                <p class="berita-deskripsi">
                                    <?php 
                                    $deskripsi = $berita['deskripsi_singkat'] ?? 
                                               (strlen($berita['isi_berita']) > 150 ? 
                                                substr($berita['isi_berita'], 0, 150) . '...' : 
                                                $berita['isi_berita']);
                                    echo htmlspecialchars($deskripsi);
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-berita text-center py-5">
                    <i class="far fa-newspaper fa-3x mb-3 text-muted"></i>
                    <h3>Tidak ada berita untuk kategori ini</h3>
                    <p>Silakan pilih kategori lain atau coba lagi nanti.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="nav-pagination">
        <a href="#" class="nav-btn prev" aria-label="Previous">
            ‹
        </a>
        <a href="#" class="nav-btn next" aria-label="Next">
            ›
        </a>
    </div>

    <div class="info-section">
    <div class="container">
        <div class="section-header">
            <h2>PENGUMUMAN</h2>
            <span class="line"></span>
        </div>
        <div class="info-wrapper">

            <!-- PENGUMUMAN -->
            <div class="info-left">

                <div class="card pengumuman-card">
                    <?php while ($p = pg_fetch_assoc($pengumuman_result)) : ?>
                    <div class="pengumuman-item">
                        <span class="date">
                            <i class="fa-regular fa-calendar"></i>
                            <?= date('d F Y', strtotime($p['tanggal_pengumuman'])) ?>
                        </span>
                        <h3><?= htmlspecialchars($p['judul_pengumuman']) ?></h3>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- AGENDA -->
            <div class="info-right">
                <div class="agenda-card">
                    <h3>Agenda Mendatang</h3>
                    <p class="agenda-sub">Jadwal kegiatan dan peminjaman fasilitas</p>

                    <?php while ($a = pg_fetch_assoc($agenda_result)) : ?>
                    <div class="agenda-item kategori-<?= $a['id_kategori_agenda'] ?>">
                        <h4><?= htmlspecialchars($a['judul_agenda']) ?></h4>
                        <ul class="agenda-detail">
                            <li><i class="fa-regular fa-calendar"></i> <?= date('d F Y', strtotime($a['tanggal_agenda'])) ?></li>
                            <li><i class="fa-regular fa-clock"></i> <?= $a['jam_mulai'] ?> - <?= $a['jam_selesai'] ?></li>
                            <li><i class="fa-regular fa-user"></i> <?= htmlspecialchars($a['pihak_terkait']) ?></li>
                        </ul>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

        </div>
    </div>
</div>
</section>




    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle menu mobile
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-menu').classList.toggle('show');
        });

        // Filter kategori aktif
        document.querySelectorAll('.kategori-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.kategori-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>