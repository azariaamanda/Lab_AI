<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php';

$upload_directory = __DIR__ . "/uploads/aslab/";

if (!is_dir($upload_directory)) {
    mkdir($upload_directory, 0777, true);
}

$id_kategori_aslab = 1;

if (isset($_POST['submit_pendaftaran'])) {

    $nama       = $_POST['nama'];
    $nim        = $_POST['nim'];
    $program    = $_POST['program'];
    $semester   = $_POST['semester'];
    $email      = $_POST['email'];
    $telepon    = $_POST['telepon'];

    $jenis_pendaftaran = "Asisten Lab";
    $id_kategori_mhs   = $id_kategori_aslab;

    $durasi          = null;
    $transkrip_nilai = null;
    $surat_magang    = null;

    function handle_upload($file_key, $upload_dir, $required = false)
    {
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {

            if ($_FILES[$file_key]['size'] > 2 * 1024 * 1024) {
                die("<script>alert('Ukuran file $file_key melebihi 2MB.'); window.history.back();</script>");
            }

            $ext = strtolower(pathinfo($_FILES[$file_key]['name'], PATHINFO_EXTENSION));
            $allowed_doc = ['pdf','doc','docx'];
            $allowed_img = ['jpg','jpeg','png'];

            $is_doc = in_array($file_key, ['cv', 'portofolio']);
            $is_img = ($file_key === 'foto');

            if (($is_doc && !in_array($ext, $allowed_doc)) ||
                ($is_img && !in_array($ext, $allowed_img))) {

                die("<script>alert('Format file $file_key tidak valid!'); window.history.back();</script>");
            }

            $new_name = $file_key . '_' . time() . '_' . uniqid() . '.' . $ext;
            $target = $upload_dir . $new_name;

            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $target)) {
                return $new_name;
            } else {
                $err = $_FILES[$file_key]['error'];
                die("<script>alert('Gagal upload file $file_key. Kode: $err'); window.history.back();</script>");
            }

        } elseif ($required) {
            die("<script>alert('File $file_key wajib diunggah!'); window.history.back();</script>");
        }

        return null;
    }

    $foto_path        = handle_upload('foto', $upload_directory, true);
    $cv_path          = handle_upload('cv', $upload_directory, true);
    $portofolio_path  = handle_upload('portofolio', $upload_directory, false);

    $sql = "CALL sp_insert_pendaftaran($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)";

    $params = [
        $id_kategori_mhs,
        $jenis_pendaftaran,
        $nama,
        $nim,
        $program,
        $semester,
        $telepon,
        $email,
        $durasi,
        $foto_path,
        $transkrip_nilai,
        $cv_path,
        $portofolio_path,
        $surat_magang
    ];

    $result = pg_query_params($conn, $sql, $params);

    if ($result) {
        echo "<script>alert('Pendaftaran Aslab berhasil dikirim!'); window.location='PendaftaranAslab.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . pg_last_error($conn) . "');</script>";
    }

    pg_close($conn);
}
?>




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Asisten Laboratorium</title>
    <link rel="stylesheet" href="css/StyleNavbar.css" />
    <link rel="stylesheet" href="css/StylePendaftaran.css" />
    <link rel="stylesheet" href="css/StyleFooter" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

<header class="navbar">
  <div class="nav-bg">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <rect width="1440" height="90" fill="#0A2346" fill-opacity="0.8" />
      <path opacity="0.9" d="M0 0H1440C1440 41 1406 75 1365 75H75C33 75 0 41 0 0Z" 
        fill="white" />
    </svg>
  </div>

  <div class="nav-content">
    <div class="logo"><img src="img/logo/logo.png"></div>
    <nav>
      <ul>
        <li><a href="Beranda.php">Beranda</a></li>
        <li><a href="Produk.php">Produk</a></li>
        <li><a href="Mitra.php">Mitra</a></li>
        <li><a href="Berita.php">Berita</a></li>
        <li><a href="Galeri.php">Galeri</a></li>
        <li><a href="Layanan.php">Layanan</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="hero">
    <img src="img/header/headerjti.jpg" alt="hero" />
    <h1>PENDAFTARAN ASLAB</h1>
</div>

<section class="main-content">
  <div class="form-container">
    <h2>Formulir Pendaftaran Asisten Laboratorium</h2>
    <p class="subtitle">Laboratorium Teknologi Informasi — Tahun Akademik 2025/2026</p>

    <form method="POST" enctype="multipart/form-data">

      <div class="form-row">
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required>
          </div>
          <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="program">Program Studi</label>
            <select id="program" name="program" required>
              <option value="">Pilih Program Studi</option>
              <option value="Teknik Informatika">Teknik Informatika</option>
              <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
              <option value="Pengembangan Piranti Lunak Situs">Pengembangan Piranti Lunak Situs</option>
            </select>
          </div>
          <div class="form-group">
            <label for="semester">Semester</label>
            <select id="semester" name="semester" required>
              <option value="">Pilih Semester</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="telepon">No. Telepon</label>
            <input type="tel" id="telepon" name="telepon" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group file-upload">
            <label>Foto 3x4</label>
            <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png" required>
            <label for="foto" class="file-label">Pilih File</label>
            <div class="file-info">Format: JPG/PNG (Maks. 2MB)</div>
          </div>

          <div class="form-group file-upload">
            <label>Curriculum Vitae (CV)</label>
            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
            <label for="cv" class="file-label">Pilih File</label>
            <div class="file-info">Format: PDF/DOC (Maks. 2MB)</div>
          </div>
          <div class="form-group file-upload">
            <label>Portofolio</label>
            <input type="file" id="Portofolio" name="Portofolio" accept=".pdf,.doc,.docx" required>
            <label for="Portofolio" class="file-label">Pilih File</label>
            <div class="file-info">Format: PDF/DOC (Maks. 2MB) (Opsional)</div>
          </div>
        </div>

        <div class="pernyataan-section">
          <h3>Pernyataan</h3>
          <div class="checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" name="pernyataan1" required>
              <span>Saya menyatakan bahwa semua data yang diisi adalah benar dan dapat dipertanggungjawabkan.</span>
            </label>
          </div>
          <div class="checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" name="pernyataan2" required>
              <span>Saya bersedia mengikuti semua tahapan seleksi yang ditentukan.</span>
            </label>
          </div>
        </div>

      <button type="submit" name="submit_pendaftaran" class="btn-submit" style="margin-top: 20px;">Daftar Asisten Laboratorium</button>
    </form>

  </div>
</section>

<script>
function bindFileInput(inputId, textId) {
    const input = document.getElementById(inputId);
    const text = document.getElementById(textId);

    input.addEventListener('change', function() {
        let filename = this.files.length ? this.files[0].name : "Pilih file...";
        text.textContent = filename;
    });
}

bindFileInput("fileFoto", "fileFotoText");
bindFileInput("fileCv", "fileCvText");
bindFileInput("filePorto", "filePortoText");
</script>

</body>
<?php include 'footer.php'; ?>
</html>
