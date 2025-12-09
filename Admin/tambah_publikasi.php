<?php
require_once '../koneksi.php';

$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

if(isset($_POST['submit'])) {
    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $jenis = pg_escape_string($conn, $_POST['id_jenis_publikasi']);
    $judul = pg_escape_string($conn, $_POST['judul_publikasi']);
    $tahun = pg_escape_string($conn, $_POST['tahun']);
    $url = pg_escape_string($conn, $_POST['url_publikasi']);
    
    $query = "INSERT INTO publikasi_dosen (id_profil_dosen, id_jenis_publikasi, judul_publikasi, tahun, url_publikasi) 
              VALUES ('$id_dosen', '$jenis', '$judul', '$tahun', '$url')";
    
    if(pg_query($conn, $query)) {
        header("Location: kelola_publikasi.php?success=tambah");
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
    <title>Tambah Publikasi - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-book"></i> Tambah Publikasi</h1>
                <p class="text-muted">Tambahkan publikasi ilmiah dosen</p>
            </div>
            <div class="header-right">
                <a href="kelola_publikasi.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <?php if(isset($error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <div class="info-banner">
            <div class="info-content">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>Informasi</h4>
                    <small>Lengkapi data publikasi dosen. Field bertanda (*) wajib diisi.</small>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form action="" method="POST">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="id_profil_dosen" class="form-label required">Nama Dosen</label>
                            <select id="id_profil_dosen" name="id_profil_dosen" class="form-control" required>
                                <option value="">Pilih Dosen</option>
                                <?php while($dosen = pg_fetch_assoc($dosen_list)): ?>
                                    <option value="<?= $dosen['id_profil_dosen']; ?>">
                                        <?= htmlspecialchars($dosen['nama_dosen']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_jenis_publikasi" class="form-label required">Jenis Publikasi</label>
                            <select id="id_jenis_publikasi" name="id_jenis_publikasi" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Jurnal">Jurnal</option>
                                <option value="Konferensi">Konferensi</option>
                                <option value="Buku">Buku</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="judul_publikasi" class="form-label required">Judul Publikasi</label>
                            <input type="text" id="judul_publikasi" name="judul_publikasi" class="form-control" 
                                   placeholder="Judul lengkap publikasi" required>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label for="tahun" class="form-label required">Tahun Publikasi</label>
                            <input type="number" id="tahun" name="tahun" class="form-control" 
                                   placeholder="2023" min="1980" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label for="url_publikasi" class="form-label">URL Publikasi</label>
                            <input type="url" id="url_publikasi" name="url_publikasi" class="form-control" 
                                   placeholder="https://doi.org/... (opsional)">
                            <small class="form-help">Link ke publikasi online (DOI, repository, dll)</small>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="kelola_publikasi.php" class="btn btn-outline">
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
