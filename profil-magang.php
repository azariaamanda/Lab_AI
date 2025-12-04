<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Magang - Laboratory of Applied Informatics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style-common.css">
    <link rel="stylesheet" href="css/style-index.css">
    <style>
        /* Profile Card Styles */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            padding: 50px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            border: 2px solid #e8e8e8;
        }

        .profile-avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #1a5f7a 0%, #0d3d52 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(26, 95, 122, 0.2);
        }

        .profile-avatar img {
            width: 90%;
            height: 90%;
            object-fit: cover;
            border-radius: 8px;
        }

        .profile-name {
            color: #0A2346;
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0 15px 0;
            letter-spacing: 0.5px;
        }

        .profile-badge {
            display: inline-block;
            background: #1dd1a1;
            color: white;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .profile-social {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 35px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #d0d0d0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #0A2346;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: #0A2346;
            color: white;
            border-color: #0A2346;
        }

        .profile-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-top: 35px;
        }

        .detail-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            text-align: left;
        }

        .detail-box label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-box p {
            color: #0A2346;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 40px 25px;
            }

            .profile-avatar {
                width: 110px;
                height: 110px;
            }

            .profile-name {
                font-size: 20px;
            }

            .profile-details-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<header class="navbar">
    <div class="nav-shell">
        <div class="nav-curve" aria-hidden="true">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M 0,0 L 0,40 Q 0,80 60,80 L 1380,80 Q 1440,80 1440,40 L 1440,0 Z" fill="#ffffff"/>
            </svg>
        </div>
        <div class="nav-content">
            <div class="logo">
                <a href="../index.php"><img src="../img/logo/logo.png" alt="Laboratory of Applied Informatics"></a>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php">Beranda</a></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><a href="../index.php">Mitra</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="javascript:void(0);" onclick="return false;">Layanan</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Hero Section -->
<div class="hero">
    <img src="../img/logo/gedung-sipil.jpg" alt="Gedung Politeknik"/>
    <h1>PROFIL MAGANG</h1>
</div>

<!-- Main Content -->
<main class="container">
    <div class="profile-card">
        <!-- Avatar Container -->
        <div class="profile-avatar-container">
            <div class="profile-avatar">
                <img src="../img/avatar-default.png" alt="Avatar Magang">
            </div>
        </div>

        <!-- Profile Name -->
        <h2 class="profile-name">Andini Eka Amalia</h2>

        <!-- Badge -->
        <div class="profile-badge" style="background-color: #54a0ff;">Magang</div>

        <!-- Social Links -->
        <div class="profile-social">
            <a href="https://linkedin.com" class="social-icon linkedin" title="LinkedIn" target="_blank">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="https://github.com" class="social-icon github" title="GitHub" target="_blank">
                <i class="fab fa-github"></i>
            </a>
        </div>

        <!-- Profile Details Grid -->
        <div class="profile-details-grid">
            <div class="detail-box">
                <label>NIM</label>
                <p>24410790560</p>
            </div>
            <div class="detail-box">
                <label>PROGRAM STUDI</label>
                <p>D4 Sistem Informasi Bisnis</p>
            </div>
            <div class="detail-box">
                <label>SEMESTER</label>
                <p>Rekayasa Teknologi Informasi</p>
            </div>
            <div class="detail-box">
                <label>EMAIL</label>
                <p>andini@student.polinema.ac.id</p>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.html'; ?>

</body>
</html>