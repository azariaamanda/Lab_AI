<?php
    require 'koneksi.php';
    include 'Navbar.php';

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
        <!-- HEADER -->
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