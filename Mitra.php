<?php
    require 'koneksi.php';

    $q = "SELECT * FROM vw_mitra ORDER BY nama_kategori, nama_mitra";
    $r = pg_query($conn, $q);

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
                    <a href="layanan.php">Layanan</a>
                </ul>
            </nav>
        </div>
    </header>

    <div class="hero">
        <img src="img/logo/gedung-sipil.jpg" alt="hero"/>
        <h1>MITRA</h1>
    </div>

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