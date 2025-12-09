<?php
require_once '../koneksi.php'; 

if(isset($_POST['submit'])) {

    // mysqli_real_escape_string → pg_escape_string
    $nip     = pg_escape_string($conn, $_POST['nip']);
    $nidn    = pg_escape_string($conn, $_POST['nidn']);
    $nama    = pg_escape_string($conn, $_POST['nama_dosen']);
    $prodi   = pg_escape_string($conn, $_POST['program_studi']);
    $jabatan = pg_escape_string($conn, $_POST['jabatan']);
    $email   = pg_escape_string($conn, $_POST['email_dosen']);
    $website = pg_escape_string($conn, $_POST['website_dosen']);
    $bidang  = pg_escape_string($conn, $_POST['bidang_keahlian']);
    
    // ================= FILE UPLOAD (TIDAK DIUBAH) =================
    $foto = '';
    if(isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto_profil']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if(in_array($ext, $allowed)) {
            $newname = time() . '_' . $filename;
            $upload_dir = 'uploads/dosen/';
            
            if(!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if(move_uploaded_file($_FILES['foto_profil']['tmp_name'], $upload_dir . $newname)) {
                $foto = $newname;
            }
        }
    }

    // ================= INSERT PostgreSQL =================
    $query = "
        INSERT INTO profil_dosen 
        (nip, nidn, nama_dosen, program_studi, jabatan, email_dosen, website_dosen, bidang_keahlian, foto_profil) 
        VALUES 
        ('$nip', '$nidn', '$nama', '$prodi', '$jabatan', '$email', '$website', '$bidang', '$foto')
    ";

    if(pg_query($conn, $query)) {
        header("Location: kelola_dosen.php?success=tambah");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-user-plus"></i> Tambah Data Dosen</h1>
                <p class="text-muted">Tambahkan profil dosen baru</p>
            </div>
            <div class="header-right">
                <a href="kelola_dosen.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <?php if(isset($error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= $error ?>
        </div>
        <?php endif; ?>

        <div class="info-banner">
            <div class="info-content">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>Informasi</h4>
                    <small>Lengkapi semua data dosen dengan benar. Field bertanda (*) wajib diisi.</small>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-grid">

                    <div class="form-column">
                        <div class="form-group">
                            <label for="nip" class="form-label required">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-control" required>
                            <small class="form-help">Nomor Induk Pegawai</small>
                        </div>

                        <div class="form-group">
                            <label for="nidn" class="form-label required">NIDN</label>
                            <input type="text" id="nidn" name="nidn" class="form-control" required>
                            <small class="form-help">Nomor Induk Dosen Nasional</small>
                        </div>

                        <div class="form-group">
                            <label for="nama_dosen" class="form-label required">Nama Lengkap</label>
                            <input type="text" id="nama_dosen" name="nama_dosen" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="program_studi" class="form-label required">Program Studi</label>
                            <select id="program_studi" name="program_studi" class="form-control" required>
                                <option value="">Pilih Program Studi</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi Bisnis">Sistem Informasi Bisnis</option>
                                <option value="Pengembangan Piranti Lunak Situs">Pengembangan Piranti Lunak Situs</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label for="jabatan" class="form-label required">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email_dosen" class="form-label required">Email</label>
                            <input type="email" id="email_dosen" name="email_dosen" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="website_dosen" class="form-label">Website</label>
                            <input type="text" id="website_dosen" name="website_dosen" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                            <input type="text" id="bidang_keahlian" name="bidang_keahlian" class="form-control">
                            <small class="form-help">Pisahkan dengan koma jika lebih dari satu</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto_profil" class="form-label">Foto Profil</label>
                    <input type="file" id="foto_profil" name="foto_profil" class="form-control" accept="image/*">
                </div>

                <div class="form-actions">
                    <a href="kelola_dosen.php" class="btn btn-outline">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
