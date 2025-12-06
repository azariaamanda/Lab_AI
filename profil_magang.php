<?php
include "koneksi.php";

$query = pg_query($conn, "SELECT * FROM profil_mahasiswa");

if (!$query) {
  die("Query gagal: " . pg_last_error($conn));
}

$data = pg_fetch_assoc($query);

if (!$data) {
  die("Data kosong! Tabel profil_mahasiswa belum punya data.");
}
$foto_path = !empty($data['foto_3x4']) ? $data['foto_3x4'] : 'img/avatar-default.png';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Magang - Laboratory of Applied Informatics</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="css/style-common.css" />
    <link rel="stylesheet" href="css/style-index.css" />

    <!-- Profile Card Styles -->
    <style>
            .navbar {
        position: relative;
        width: 100%;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .nav-bg {
        position: absolute;
        top: -2px;
        left: 0;
        width: 100%;
        height: 90px;
        z-index: 1;
        margin-top: 2px;
        }

        .nav-bg svg {
        width: 100%;
        height: 100%;
        display: block;
        }

        .nav-content {
        position: relative;
        z-index: 10;
        width: 1100px;
        padding: 0 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        }

        .logo img {
        height: 55px;
        position: relative;
        z-index: 20;
        top: -10px;
        }

        nav ul {
        display: flex;
        list-style: none;
        gap: 30px;
        margin: 0;
        padding: 0;
        margin-bottom: 20px;
        }

        nav a {
        text-decoration: none;
        color: #08385f;
        font-weight: 600;
        font-size: 20px;
        transition: 0.25s;
        }

        nav a:hover {
        color: #ff8a00;
        }
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
        width: 160px;
        height: 200px;
        background: linear-gradient(135deg, #1a5f7a 0%, #0d3d52 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 16px rgba(26, 95, 122, 0.2);
      }

      .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
      }

      .profile-name {
        color: #0a2346;
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
        color: #0a2346;
        transition: all 0.3s;
      }

      .social-icon:hover {
        background-color: #0a2346;
        color: white;
        border-color: #0a2346;
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
        color: #0a2346;
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

    <header class="navbar">
      <div class="nav-bg">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
          <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8" />
          <path
            opacity="0.9"
            d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z"
            fill="white"
          />
        </svg>
      </div>

     <div class="nav-content">
    <div class="logo">
      <img src="img/logo.png" alt="logo">
    </div>

    <nav>
      <ul>
        <li><a href="Beranda.php">Beranda</a></li>
        <li><a href="Produk.php">Produk</a></li>
        <li><a href="Mitra.php">Mitra</a></li>
        <li><a href="Berita.php">Berita</a></li>
        <li><a href="Galeri.php">Galeri</a></li>
        <li><a href="layanan.php">Layanan</a></li>
      </ul>
    </nav>
  </div>
</header>

    <!-- Main Content -->
    <main class="container">
      <div class="profile-card">

        <!-- Avatar -->
        <div class="profile-avatar-container">
            <div class="profile-avatar">
                <img src="<?= $foto_path; ?>" alt="Avatar Magang" />
            </div>
        </div>

        <!-- Nama -->
        <h2 class="profile-name">
          <?= $data['nama_lengkap']; ?>
        </h2>

        <!-- Badge -->
        <div class="profile-badge" style="background-color: #54a0ff">
          Magang
        </div>

        <!-- Social -->
    <!-- Social Links -->
        <div class="profile-social">
        <a
            href="<?= !empty($data['linkedin']) ? $data['linkedin'] : '#'; ?>"
            class="social-icon linkedin"
            title="LinkedIn"
            target="_blank"
        >
            <i class="fab fa-linkedin"></i>
        </a>
        <a
            href="<?= !empty($data['github']) ? $data['github'] : '#'; ?>"
            class="social-icon github"
            title="GitHub"
            target="_blank"
        >
            <i class="fab fa-github"></i>
        </a>
        </div>


        <!-- Detail -->
        <div class="profile-details-grid">

          <div class="detail-box">
            <label>NIM</label>
           <p><?= $data['nim'] ?? '-'; ?></p>
          </div>

          <div class="detail-box">
            <label>PROGRAM STUDI</label>
            <p><?= $data['program_studi'] ?? '-'; ?></p>
          </div>

          <div class="detail-box">
            <label>SEMESTER</label>
            <p><?= $data['semester'] ?? '-'; ?></p>
          </div>

          <div class="detail-box">
            <label>EMAIL</label>
            <p><?= $data['email'] ?? '-'; ?></p>
          </div>

          <div class="detail-box">
            <label>NO TELEPON</label>
            <p><?= $data['no_telp'] ?? '-'; ?></p>
          </div>

          <div class="detail-box">
            <label>DURASI MAGANG</label>
            <p><?= $data['durasi'] ?? '-'; ?></p>
          </div>

        </div>

      </div>
    </main>


  </body>
</html>