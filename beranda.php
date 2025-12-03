<?php
    require 'koneksi.php';

    // Ambil data navbar
    $nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
    $nav_result = pg_query($conn, $nav_query);

    // Ambil data nav banner
    $banner_query = "SELECT * FROM vw_nav_banner ORDER BY id_navBanner";
    $banner_result = pg_query($conn, $banner_query);

    // Ambil deskripsi lab
    $query_deskripsi = "SELECT * FROM vw_deskripsi_lab LIMIT 1";
    $result_deskripsi = pg_query($conn, $query_deskripsi);
    $deskripsi_lab = pg_fetch_assoc($result_deskripsi);
    
    // Ambil 4 berita terbaru
    $berita_query = "
        SELECT id_berita, nama_kategori_berita, judul_berita, tanggal_berita, deskripsi_singkat, isi_berita, gambar_berita, link_berita
        FROM vw_berita
        ORDER BY tanggal_berita DESC
        LIMIT 4
    ";
    $berita_result = pg_query($conn, $berita_query);

    // Hitung total berita
    $total_result = pg_query($conn, "SELECT COUNT(*) FROM vw_berita");
    $total_berita = pg_fetch_result($total_result, 0, 0);


    // Ambil data video produk
    $video_query = "SELECT * FROM vw_video_produk LIMIT 1";
    $video_result = pg_query($conn, $video_query);
    $video_url = "";
    if($video_result && pg_num_rows($video_result) > 0){
        $video_data = pg_fetch_assoc($video_result);
        $video_url = $video_data['url_youtube'];
    }
    // Fungsi untuk mendapatkan ID YouTube dari URL
    function getYoutubeId($url) {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }

    // Ambil total berita untuk tombol "Lihat Lainnya"
    $count_berita_query = "SELECT COUNT(*) as total FROM vw_berita";
    $count_result = pg_query($conn, $count_berita_query);
    $total_berita = 0;
    if($count_result){
        $count_data = pg_fetch_assoc($count_result);
        $total_berita = $count_data['total'];
    }
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
        <link rel="stylesheet" href="css/styleBeranda.css">
    </head>
    <body>
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

        <!-- HERO SECTION -->
        <section class="hero-section" style="background-image: url('img/logo/JTIHero.png');">
            <div class="hero-overlay"></div>
            <div class="hero-text-center">
                <h1>LABORATORY<br>APPLIED INFORMATICS</h1>
            </div>
            <!-- NAV BANNER MENYATU DI BAWAH HERO -->
            <div class="hero-banner-nav">
                <div class="banner-icons">
                    <?php if($banner_result && pg_num_rows($banner_result) > 0): ?>
                        <?php while($banner = pg_fetch_assoc($banner_result)): ?>
                            <a href="<?php echo htmlspecialchars($banner['url_navbanner']); ?>" class="icon-item">
                                <img
                                    src="<?php echo htmlspecialchars($banner['icon_navBanner']); ?>"
                                    alt="<?php echo htmlspecialchars($banner['nama']); ?>"
                                    class="icon-banner-img">
                                <p><?php echo htmlspecialchars($banner['nama']); ?></p>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- LAB DESCRIPTION -->
        <section class="lab-description">
            <div class="container">
                <div class="description-content">
                    <p class="description-text">
                        <?php echo $deskripsi_lab['isi']; ?>
                    </p>
                </div>
            </div>
        </section>

        <!-- BERITA -->

        <section class="berita-section">
            <div class="container">
                <div class="section-header">
                    <h3 class="section-title">BERITA LABORATORIUM</h3>
                    <p class="section-subtitle">
                        Stories about people, research, and innovation across the Laboratories
                    </p>
                    <div class="title-line"></div>
                </div>

                <div class="berita-grid-layout">
                    <?php if ($berita_result && pg_num_rows($berita_result) > 0): ?>
                        <?php
                            $berita_array = [];
                            while ($row = pg_fetch_assoc($berita_result)) {
                                $berita_array[] = $row;
                            }
                        ?>

                        <!-- Kolom kiri: berita pertama -->
                        <div class="berita-left-column">
                            <?php
                                $berita = $berita_array[0];
                                $gambar = !empty($berita['gambar_berita']) ? $berita['gambar_berita'] : 'img/berita/default.jpg';
                            ?>
                            <div class="berita-card featured">
                                <div class="berita-img-side">
                                    <img src="<?php echo htmlspecialchars($gambar); ?>" alt="Gambar Berita">
                                </div>
                                <div class="berita-content">
                                    <div class="berita-date">
                                        <span class="date-day"><?php echo date('d', strtotime($berita['tanggal_berita'])); ?></span>
                                        <span class="date-month"><?php echo date('M', strtotime($berita['tanggal_berita'])); ?></span>
                                        <span class="date-year"><?php echo date('Y', strtotime($berita['tanggal_berita'])); ?></span>
                                    </div>
                                    <div class="berita-category">
                                        <?php echo htmlspecialchars($berita['nama_kategori_berita']); ?>
                                    </div>
                                    <h4 class="berita-title">
                                        <?php echo htmlspecialchars($berita['judul_berita']); ?>
                                    </h4>
                                    <p class="berita-excerpt">
                                        <?php
                                            $excerpt = !empty($berita['deskripsi_singkat']) ? $berita['deskripsi_singkat'] : substr($berita['isi_berita'], 0, 150);
                                            echo htmlspecialchars($excerpt) . '...';
                                        ?>
                                    </p>
                                    <a href="berita_detail.php?id=<?php echo $berita['id_berita']; ?>" class="berita-link">
                                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom kanan: berita ke-2, ke-3, ke-4 -->
                        <div class="berita-right-column">
                            <?php for ($i = 1; $i < count($berita_array); $i++): ?>
                                <?php
                                    $berita = $berita_array[$i];
                                    $gambar = !empty($berita['gambar_berita']) ? $berita['gambar_berita'] : 'img/berita/default.jpg';
                                ?>
                                <div class="berita-card">
                                    <div class="berita-img-side">
                                        <img src="<?php echo htmlspecialchars($gambar); ?>" alt="Gambar Berita">
                                    </div>
                                    <div class="berita-content">
                                        <div class="berita-date">
                                            <span class="date-day"><?php echo date('d', strtotime($berita['tanggal_berita'])); ?></span>
                                            <span class="date-month"><?php echo date('M', strtotime($berita['tanggal_berita'])); ?></span>
                                            <span class="date-year"><?php echo date('Y', strtotime($berita['tanggal_berita'])); ?></span>
                                        </div>
                                        <div class="berita-category">
                                            <?php echo htmlspecialchars($berita['nama_kategori_berita']); ?>
                                        </div>
                                        <h4 class="berita-title">
                                            <?php echo htmlspecialchars($berita['judul_berita']); ?>
                                        </h4>
                                        <a href="berita_detail.php?id=<?php echo $berita['id_berita']; ?>" class="berita-link">
                                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php else: ?>
                        <p>Tidak ada berita tersedia.</p>
                    <?php endif; ?>
                </div>

                <?php if ($total_berita > 4): ?>
                    <div class="text-center mt-5">
                        <div class="berita-box">
                            <a href="Berita.php" class="btn-view-more">
                                <span>Berita Lainnya</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
            <!-- PRODUK SECTION -->
        <section id="produk" class="produk-section">
            <div class="container">
                <!-- Header Section -->
                <div class="produk-header">
                    <h3 class="produk-title">PRODUK</h3>
                    <p class="produk-subtitle">Innovation from the Laboratory Applied Informatics</p>
                </div>

                <!-- Video Produk -->
                <div class="video-section">
                    <div class="video-container">
                        <?php if (!empty($video_url)): ?>
                            <div class="video-wrapper">
                                <iframe
                                    src="https://www.youtube.com/embed/<?php echo getYoutubeId($video_url); ?>"
                                    title="Video Produk Laboratory Applied Informatics"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        <?php else: ?>
                            <div class="video-placeholder">
                                <i class="fas fa-play-circle fa-4x"></i>
                                <p>Video produk akan ditampilkan di sini</p>
                                <small>Pastikan data video tersedia di database</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tombol Lihat Lainnya -->
                <div class="text-center mt-5">
                    <div class="produk-box">
                        <a href="Produk.php" class="btn-view-more">
                            <span>Lihat Lainnya</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        </main>

        <!-- FOOTER -->
        <footer class="footer-section">
            <div class="container">
                <div class="footer-content">
                    <!-- Footer akan ditambahkan sesuai kebutuhan -->
                    <p class="footer-text">© 2025 Laboratory Applied Informatics - Politeknik Negeri Malang</p>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Custom JS -->
        <script src="js/beranda.js"></script>
    </body>
    </html>