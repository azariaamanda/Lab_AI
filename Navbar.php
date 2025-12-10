<?php
require 'koneksi.php';

// Ambil data navbar
$nav_query = "SELECT * FROM vw_navbar ORDER BY id_navbar";
$nav_result = pg_query($conn, $nav_query);

// Reset pointer untuk navbar
pg_result_seek($nav_result, 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styleberanda.css">
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
                    
                    <!-- Profile Ring Component -->
                    <?php include 'ProfileRing.php'; ?>
                    
                    <!-- Mobile Menu Toggle -->
                    <div class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>
        </header>
