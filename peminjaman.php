<?php
include "koneksi.php";
include "Navbar.php";

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

    // Query insert menggunakan parameterized query untuk keamanan
    $query = " 
        INSERT INTO peminjaman 
        (id_fasilitas, nama_lengkap, nim, program_studi, semester, email, tanggal_pinjam, rencana_tanggal_kembali, keperluan)
        VALUES 
        ($1, $2, $3, $4, $5, $6, $7, $8, $9)
    ";

    $params = array(
        $id_fasilitas,
        $nama,
        $nim,
        $prodi,
        $semester,
        $email,
        $tgl_pinjam,
        $tgl_kembali,
        $keperluan
    );
    $result = pg_query_params($conn, $query, $params);

    if ($result) {
        echo "<script>alert('Peminjaman berhasil diajukan!'); window.location='peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . pg_last_error($conn) . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman Fasilitas</title>
    <link rel="stylesheet" href="css/stylepeminjaman.css" />
    <link rel="stylesheet" href="css/styleFooter.css" />
  </head>
  <body>

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

  <?php include 'footer.php'; ?>
</html>
