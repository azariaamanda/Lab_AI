<?php
include "koneksi.php";

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama_lengkap'];
    $nim = $_POST['nim'];
    $prodi = $_POST['program_studi'];
    $semester = $_POST['semester'];
    $email = $_POST['email'];
    $id_fasilitas = $_POST['id_fasilitas'];
    $tgl_pinjam = $_POST['tanggal_pinjam'];
    $tgl_kembali = $_POST['tanggal_kembali'];
    $keperluan = $_POST['keperluan'];

    // Query insert
    $query = "
        INSERT INTO peminjaman 
        (id_fasilitas, nama_lengkap, nim, program_studi, semester, email, tanggal_pinjam, rencana_tanggal_kembali, keperluan)
        VALUES 
        ('$id_fasilitas', '$nama', '$nim', '$prodi', '$semester', '$email', '$tgl_pinjam', '$tgl_kembali', '$keperluan')
    ";

    $result = pg_query($conn, $query);

    if ($result) {
        echo "<script>alert('Peminjaman berhasil diajukan!'); window.location='peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . pg_last_error($conn) . "');</script>";
    }
}

// footer
  $footer_query = pg_query($conn, "SELECT * FROM footer LIMIT 1");
if (!$footer_query) {
    die("Query footer gagal: " . pg_last_error($conn));
}

$footer = pg_fetch_assoc($footer_query);

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman Fasilitas</title>
    <link rel="stylesheet" href="css/stylepeminjaman.css" />
  </head>
  <body>

    <!-- NAVBAR -->
    <header class="navbar">
      <div class="nav-bg">
        <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
          <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8" />
          <path opacity="0.9"
            d="M0 0H1440C1440 41.4214 1406.42 75 1365 75H75C33.5786 75 0 41.4214 0 0Z" 
            fill="white" />
        </svg>
      </div>

      <div class="nav-content">
        <div class="logo">
          <img src="img/logo.png" alt="logo" />
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

    <!-- HERO -->
    <div class="hero">
      <img src="img/gedung-sipil.jpg" alt="hero" />
      <h1>PEMINJAMAN</h1>
    </div>

    <!-- FORM -->
    <section class="main-content">
      <div class="form-container">
        <h2>Formulir Peminjaman Fasilitas Laboratorium</h2>
        <p class="subtitle">
          Laboratorium Teknologi Informasi - Tahun Akademik 2025/2026
        </p>

        <form method="POST">
          <div class="form-row">
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama_lengkap" required />
            </div>
            <div class="form-group">
              <label>NIM</label>
              <input type="text" name="nim" required />
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Program Studi</label>
              <select name="program_studi" required>
                <option disabled selected>Pilih Program Studi</option>
                <option>Teknik Informatika</option>
                <option>Sistem Informasi Bisnis</option>
                <option>Pengembangan Piranti Lunak Situs</option>
              </select>
            </div>

            <div class="form-group">
              <label>Semester</label>
              <select name="semester" required>
                <option disabled selected>Pilih Semester</option>
                <option>1</option><option>2</option><option>3</option>
                <option>4</option><option>5</option><option>6</option>
                <option>7</option><option>8</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" required />
            </div>

            <div class="form-group">
              <label>Fasilitas yang Dipinjam</label>
              <select name="id_fasilitas" required>
                <option disabled selected>Pilih Fasilitas</option>
                <option value="1">Ruang Laboratorium</option>
                <option value="2">Software & Tools Pengembangan</option>
                <option value="3">Perangkat Presentasi</option>
                <option value="4">Jaringan Internet & Server</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Tanggal Pinjam</label>
              <input type="date" name="tanggal_pinjam" required />
            </div>
            <div class="form-group">
              <label>Tanggal Kembali</label>
              <input type="date" name="tanggal_kembali" required />
            </div>
          </div>

          <div class="form-group full-width">
            <label>Keperluan Peminjaman</label>
            <textarea name="keperluan" required></textarea>
          </div>
          <div class="pernyataan">
            <h3>Pernyataan</h3>
            <div class="checkbox-group">
              <input type="checkbox" id="c1" />
              <label for="c1"
                >Saya bertanggung jawab penuh atas fasilitas yang
                dipinjam</label
              >
            </div>
            <div class="checkbox-group">
              <input type="checkbox" id="c2" />
              <label for="c2"
                >Saya akan mengganti kerusakan yang terjadi selama
                peminjaman</label
              >
            </div>
          </div>
          <button type="submit" class="btn-submit">Ajukan Peminjaman</button>
        </form>

      </div>
    </section>
  </body>

  <!-- Footer -->
<footer class="footer">
    <div class="footer-top-border"></div>

    <div class="footer-container">
        <!-- Logo + Deskripsi -->
        <div class="footer-col footer-logo">
            <img src="<?= $footer['url_logo'] ?>" alt="Logo" />
            <p><?= $footer['deskripsi_footer'] ?></p>
        </div>

        <!-- Menu -->
        <div class="footer-col">
            <h4>MENU</h4>
            <ul>
                <li><a href="Beranda.php">Beranda</a></li>
                <li><a href="Produk.php">Produk</a></li>
                <li><a href="Mitra.php">Mitra</a></li>
                <li><a href="Berita.php">Berita</a></li>
                <li><a href="Galeri.php">Galeri</a></li>
                <li><a href="Layanan.php">Layanan</a></li>
            </ul>
        </div>

        <!-- Layanan -->
        <div class="footer-col">
            <h4>LAYANAN</h4>
            <ul>
                <li>Pendaftaran Asisten Lab</li>
                <li>Pendaftaran Magang</li>
                <li>Peminjaman Fasilitas</li>
            </ul>
        </div>

        <!-- Jam Kerja -->
        <div class="footer-col">
            <h4>JAM KERJA</h4>
            <ul>
                <li><?= $footer['jam_kerja'] ?></li>
            </ul>
        </div>

        <div class="footer-right">
            <div class="footer-map">
                <iframe
                    src="<?= $footer['link_maps'] ?>"
                    width="360"
                    height="200"
                    style="border: 0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
            </div>

            <p><img src="img/footer/email.png" /> <?= $footer['email'] ?></p>

            <p>
                <img src="img/footer/maps.png" /> <?= nl2br($footer['alamat']) ?>
            </p>
        </div>
    </div>

    <div class="footer-bottom-border"></div>

    <div class="footer-bottom">
        Copyright © <?= date("Y") ?> Lab Applied Informatics - Politeknik Negeri Malang. All
        Rights Reserved.
    </div>
</footer>
</html>
