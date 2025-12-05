<?php
require 'koneksi.php';
include 'Navbar.php';

// Ambil data navbar
    $nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
    $nav_result = pg_query($conn, $nav_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
    <link rel="stylesheet" href="css/style-common.css">
    <link rel="stylesheet" href="css/style-index.css">
    <link rel="stylesheet" href="css/StyleFooter.css">
</head>
<body>



<!-- Hero Section -->
<div class="hero">
    <img src="img/logo/gedung-sipil.jpg" alt="Gedung Sipil Politeknik Negeri Malang"/>
    <h1>ANGGOTA</h1>
</div>

<!-- Main Content -->
<main class="container">
    <!-- Kepala Laboratorium Section -->
    <div class="member-section">
        <h2>KEPALA LABORATORIUM</h2>
        <div class="research-grid" style="justify-content: center;">
            <!-- Head Researcher Card -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Kepala Laboratorium">
                    </div>
                </div>
                <div class="card-label">Kepala Lab</div>
                <div class="card-content">
                    <h4>Ir. Yan Watequlis Syaifudin, S.T., M.M.T., Ph.D</h4>
                    <p>Fokus pada inovasi dan penerapan teknologi terapan untuk industri.</p>
                    <a href="pages/profil-peneliti.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Peneliti Section -->
    <div class="member-section">
        <h2>PENELITI</h2>
        <div class="research-grid">
            <!-- Researcher Card 1 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Peneliti">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Iana Yoga Saputra, S.Kom., M.M.T.</h4>
                    <p>Information Extraction, Text Mining, Natural Language Processing, Text Mining, Digital Image Processing</p>
                    <a href="pages/profil-peneliti.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Researcher Card 2 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Peneliti">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Pramana Yoga Saputra, S.Kom., M.M.T.</h4>
                    <p>Information Extraction, Text Mining, Social Media Analytics, Digital Image Processing</p>
                    <a href="pages/profil-peneliti.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Researcher Card 3 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Peneliti">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Pramana Yoga Sap S.Kom., M.M.T.</h4>
                    <p>Information Extraction, Text Mining, Social Media Analytics, Digital Image Processing</p>
                    <a href="pages/profil-peneliti.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Asisten Laboratorium Section -->
    <div class="member-section">
        <h2>ASISTEN LABORATORIUM</h2>
        <div class="research-grid">
            <!-- Assistant Card 1 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Asisten">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Ahmad Zulkifli</h4>
                    <p>D4 Sistem Informasi Bisnis</p>
                    <a href="pages/profil.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Assistant Card 2 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Asisten">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Rina Amelia</h4>
                    <p>D4 Teknik Informatika</p>
                    <a href="pages/profil.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Assistant Card 3 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Asisten">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Fajar Nugroho</h4>
                    <p>D4 Sistem Informasi Bisnis</p>
                    <a href="pages/profil.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Magang Section -->
    <div class="member-section">
        <h2>MAGANG</h2>
        <div class="research-grid">
            <!-- Intern Card 1 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Magang">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Siti Fatimah</h4>
                    <p>D3 Manajemen Informatika</p>
                    <a href="pages/profil-magang.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Intern Card 2 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Magang">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Eko Prasetyo</h4>
                    <p>D3 Manajemen Informatika</p>
                    <a href="pages/profil-magang.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>

            <!-- Intern Card 3 -->
            <div class="research-card">
                <div class="card-avatar">
                    <div class="card-avatar-circle">
                        <img src="img/avatar-default.png" alt="Avatar Magang">
                    </div>
                </div>
                <div class="card-label">Anggota</div>
                <div class="card-content">
                    <h4>Andini Eka Amalia</h4>
                    <p>D4 Sistem Informasi Bisnis</p>
                    <a href="pages/profil-magang.php">
                        <button class="card-button">Profil</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include 'footer.php'; ?>
</body>
</html>