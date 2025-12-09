<?php
require_once '../koneksi.php';

// Ambil daftar dosen
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

if(isset($_POST['submit'])) {
    // Escape input
    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $nama_sertifikasi = pg_escape_string($conn, $_POST['nama_sertifikasi']);
    $institusi = pg_escape_string($conn, $_POST['institusi_penerbit']);
    $tahun_terbit = pg_escape_string($conn, $_POST['tahun_terbit']);
    $tahun_kadaluarsa = pg_escape_string($conn, $_POST['tahun_kadaluarsa']);

    // Insert ke database (support null kadaluarsa)
    $query = "INSERT INTO sertifikasi_dosen (id_profil_dosen, nama_sertifikasi, institusi_penerbit, tahun_terbit, tahun_kadaluarsa) 
              VALUES ('$id_dosen', '$nama_sertifikasi', '$institusi', '$tahun_terbit', ".
              ($tahun_kadaluarsa ? "'$tahun_kadaluarsa'" : "NULL") .")";

    if(pg_query($conn, $query)) {
        header("Location: kelola_sertifikasi.php?success=tambah");
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
    <title>Tambah Sertifikasi - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-certificate"></i> Tambah Sertifikasi</h1>
                <p class="text-muted">Tambahkan sertifikasi dosen</p>
            </div>
            <div class="header-right">
                <a href="kelola_sertifikasi.php" class="btn btn-outline">
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
                    <small>Lengkapi data sertifikasi dosen. Field bertanda (*) wajib diisi.</small>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form action="" method="POST">
                <div class="form-grid">
                    <div class="form-column">

                        <div class="form-group">
                            <label class="form-label required">Nama Dosen</label>
                            <select name="id_profil_dosen" class="form-control" required>
                                <option value="">Pilih Dosen</option>
                                <?php while($dosen = pg_fetch_assoc($dosen_list)): ?>
                                    <option value="<?= $dosen['id_profil_dosen']; ?>">
                                        <?= htmlspecialchars($dosen['nama_dosen']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Nama Sertifikasi</label>
                            <input type="text" name="nama_sertifikasi" class="form-control" 
                                   placeholder="contoh: AWS Certified Solutions Architect" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Institusi Penerbit</label>
                            <input type="text" name="institusi_penerbit" class="form-control" 
                                   placeholder="contoh: Amazon Web Services" required>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label required">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control" 
                                   placeholder="2023" min="1980" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tahun Kadaluarsa</label>
                            <input type="number" name="tahun_kadaluarsa" class="form-control" 
                                   placeholder="2026 (kosongkan jika seumur hidup)" min="1980" max="2050">
                            <small class="form-help">Kosongkan jika tidak memiliki masa expired</small>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="kelola_sertifikasi.php" class="btn btn-outline">
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
