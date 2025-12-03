<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Peneliti - Laboratory of Applied Informatics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style-common.css">
    <link rel="stylesheet" href="css/style-index.css">
    <style>
        body {
            background: #f6fafd;
        }
        .researcher-main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .researcher-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px;
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 32px;
        }
        .researcher-avatar {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            background: #1a5f7a;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .researcher-avatar img {
            width: 90%;
            height: 90%;
            object-fit: cover;
            border-radius: 8px;
        }
        .researcher-info {
            flex: 1;
        }
        .researcher-info h2 {
            color: #0A2346;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .researcher-social {
            margin-bottom: 18px;
        }
        .researcher-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f2f2f2;
            color: #1a5f7a;
            margin-right: 8px;
            font-size: 16px;
            border: 1.5px solid #e0e0e0;
            transition: all 0.2s;
            text-decoration: none;
        }
        .researcher-social a:hover {
            background: #1a5f7a;
            color: #fff;
        }
        .researcher-idbox {
            background: #f3f8fa;
            border-radius: 10px;
            padding: 18px 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            font-size: 14px;
            margin-top: 10px;
        }
        .researcher-idbox-col {
            min-width: 180px;
        }
        .researcher-idbox label {
            color: #888;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .researcher-idbox .id-value {
            color: #0A2346;
            font-weight: 600;
            font-size: 13px;
        }
        .researcher-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-bottom: 28px;
        }
        .researcher-box {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 22px;
        }
        .researcher-box h3 {
            color: #0A2346;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 12px;
            border-bottom: 2px solid #1a5f7a;
            padding-bottom: 4px;
        }
        .researcher-box .box-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .researcher-box .box-list li {
            background: #f3f8fa;
            border-radius: 7px;
            padding: 10px 14px;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .researcher-box .box-list li:last-child {
            margin-bottom: 0;
        }
        .researcher-box .cert-title {
            font-weight: 700;
            color: #1a5f7a;
            font-size: 13px;
        }
        .researcher-box .cert-detail {
            font-size: 12px;
            color: #666;
        }
        .researcher-tabs {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 0 0 18px 0;
        }
        .researcher-tabs-header {
            display: flex;
            gap: 18px;
            border-bottom: 2px solid #e0e0e0;
            padding: 0 22px;
        }
        .researcher-tabs-header button {
            background: none;
            border: none;
            color: #0A2346;
            font-weight: 700;
            font-size: 14px;
            padding: 16px 0 10px 0;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: border-color 0.2s;
        }
        .researcher-tabs-header button.active {
            border-bottom: 3px solid #1a5f7a;
            color: #1a5f7a;
        }
        .researcher-tabs-content {
            padding: 18px 22px 0 22px;
        }
        .researcher-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            background: #f8fafc;
            border-radius: 8px;
            overflow: hidden;
        }
        .researcher-table th, .researcher-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }
        .researcher-table th {
            background: #f3f8fa;
            color: #1a5f7a;
            font-weight: 700;
        }
        .researcher-table tr:last-child td {
            border-bottom: none;
        }
        @media (max-width: 900px) {
            .researcher-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .researcher-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 600px) {
            .researcher-card {
                padding: 24px 16px;
            }
            .researcher-grid {
                gap: 16px;
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
    <h1>PROFIL PENELITI</h1>
</div>

<!-- Main Content -->
<main class="researcher-main">
    <!-- Kartu Profil Peneliti -->
    <div class="researcher-card">
        <div class="researcher-avatar">
            <img src="../img/avatar-default.png" alt="Avatar Peneliti">
        </div>
        <div class="researcher-info">
            <h2>Ir. Yan Watequlis Syaifudin, S.T., M.M.T., Ph.D</h2>
            <div class="researcher-social">
                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" title="Google Scholar"><i class="fas fa-graduation-cap"></i></a>
                <a href="#" title="Sinta"><i class="fas fa-certificate"></i></a>
                <a href="#" title="ResearchGate"><i class="fab fa-researchgate"></i></a>
            </div>
            <div class="researcher-idbox">
                <div class="researcher-idbox-col">
                    <label>NIP</label>
                    <div class="id-value">198106162005011005</div>
                </div>
                <div class="researcher-idbox-col">
                    <label>NIDN</label>
                    <div class="id-value">0031068104</div>
                </div>
                <div class="researcher-idbox-col">
                    <label>PROGRAM STUDI</label>
                    <div class="id-value">Rekayasa Teknologi Informasi</div>
                </div>
                <div class="researcher-idbox-col">
                    <label>JABATAN</label>
                    <div class="id-value">Tenaga Pengajar</div>
                </div>
                <div class="researcher-idbox-col">
                    <label>EMAIL</label>
                    <div class="id-value">yan@polinema.ac.id</div>
                </div>
                <div class="researcher-idbox-col">
                    <label>WEBSITE</label>
                    <div class="id-value">-</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendidikan & Sertifikasi -->
    <div class="researcher-grid">
        <div class="researcher-box">
            <h3>Pendidikan</h3>
            <ul class="box-list">
                <li>
                    <span class="cert-title">S3 – Information and Communication Systems</span><br>
                    <span class="cert-detail">ITS Surabaya (sedang berlangsung)</span>
                </li>
                <li>
                    <span class="cert-title">S2 – Manajemen Teknologi</span><br>
                    <span class="cert-detail">ITS Surabaya (2012-2014)</span>
                </li>
                <li>
                    <span class="cert-title">S1 – Teknik Informatika</span><br>
                    <span class="cert-detail">ITS Surabaya (1999-2004)</span>
                </li>
            </ul>
        </div>
        <div class="researcher-box">
            <h3>Sertifikasi</h3>
            <ul class="box-list">
                <li>
                    <span class="cert-title">Cybersecurity Nexus - CSX Certificate and CSXP Certification</span><br>
                    <span class="cert-detail">ISACA (2021) | Sertifikat berlaku sampai Juli 2023</span>
                </li>
                <li>
                    <span class="cert-title">ISO/IEC 27001 Lead Auditor - Information Security Management System</span><br>
                    <span class="cert-detail">IRCA (2021) | Sertifikat berlaku sampai Juli 2023</span>
                </li>
                <li>
                    <span class="cert-title">Certified Assessor</span><br>
                    <span class="cert-detail">BNSP (2021) | Sertifikat berlaku sampai Juli 2024</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Publikasi, Riset, dll. -->
    <div class="researcher-tabs">
        <div class="researcher-tabs-header">
            <button class="active">Publikasi</button>
            <button>Riset</button>
            <button>Kekayaan Intelektual</button>
            <button>PPM</button>
            <span style="margin-left:auto;font-size:12px;color:#1dd1a1;font-weight:700;align-self:center;">Lihat Semua di SINTA</span>
        </div>
        <div class="researcher-tabs-content">
            <table class="researcher-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>JUDUL</th>
                        <th>TAHUN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="3" style="text-align:center;color:#aaa;">Data tidak tersedia.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../footer.html'; ?>

</body>
</html>