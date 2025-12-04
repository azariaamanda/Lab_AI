<?php
    require 'koneksi.php';

    $q = "SELECT * FROM vw_mitra ORDER BY nama_kategori, nama_mitra";
    $r = pg_query($conn, $q);

    $nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
    $nav_result = pg_query($conn, $nav_query);


    $mitra = [
        'Industri' => [],
        'Pendidikan' => [],
        'Pemerintahan' => [],
        'Internasional' => []
    ];

    while ($row = pg_fetch_assoc($r)) {
        $mitra[$row['nama_kategori']][] = $row;
    }
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Mitra</title>
    <link rel="stylesheet" href="css/StyleNavbar.css">
    <link rel="stylesheet" href="css/StyleMitra.css">
    <link rel="stylesheet" href="css/StyleFooter.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        <!-- HEADER BERITA -->
        <section class="mitra-header" style="background-image: url('img/header/headerjti.jpg');">
            <div class="overlay" >
                <div class="container">
                    <h1 class="mitra-title">MITRA</h1>
                </div>
            </div>
        </section>

    <main>
        <section>
            <div class="section-title">
                <div class="fancy-heading"><h2>INDUSTRY PARTNER</h2></div>
            </div>

            <div class="grid">
                <?php foreach ($mitra['Industri'] as $m): ?>
                <div class="flip-card small">
                    <div class="flip-inner">
                    <div class="flip-front">
                        <div class="front-img">
                        <img src="<?= $m['logo_mitra'] ?>" class="img-logo">
                        </div>
                        <div class="front-text"><?= $m['nama_mitra'] ?></div>
                    </div>
                    <div class="flip-back"><?= $m['desk_mitra'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section>
            <div class="section-title">
                <div class="fancy-heading"><h2>EDUCATIONAL INSTITUTIONS</h2></div>
            </div>

            <div class="grid">
                <?php foreach ($mitra['Pendidikan'] as $m): ?>
                <div class="flip-card small">
                    <div class="flip-inner">
                    <div class="flip-front">
                        <div class="front-img">
                        <img src="<?= $m['logo_mitra'] ?>" class="img-logo">
                        </div>
                        <div class="front-text"><?= $m['nama_mitra'] ?></div>
                    </div>
                    <div class="flip-back"><?= $m['desk_mitra'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section>
            <div class="section-title">
                <div class="fancy-heading"><h2>GOVERNMENT INSTITUTIONS</h2></div>
            </div>

            <div class="grid">
                <?php foreach ($mitra['Pemerintahan'] as $m): ?>
                <div class="flip-card small">
                    <div class="flip-inner">
                    <div class="flip-front">
                        <div class="front-img">
                        <img src="<?= $m['logo_mitra'] ?>" class="img-logo">
                        </div>
                        <div class="front-text"><?= $m['nama_mitra'] ?></div>
                    </div>
                    <div class="flip-back"><?= $m['desk_mitra'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section>
            <div class="section-title">
                <div class="fancy-heading"><h2>INTERNATIONAL INSTITUTIONS</h2></div>
            </div>

            <div class="grid">
                <?php foreach ($mitra['Internasional'] as $m): ?>
                <div class="flip-card small">
                    <div class="flip-inner">
                    <div class="flip-front">
                        <div class="front-img">
                        <img src="<?= $m['logo_mitra'] ?>" class="img-logo">
                        </div>
                        <div class="front-text"><?= $m['nama_mitra'] ?></div>
                    </div>
                    <div class="flip-back"><?= $m['desk_mitra'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>