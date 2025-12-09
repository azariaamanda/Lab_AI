<?php
require_once '../koneksi.php'; 

if(!isset($_GET['id'])) {
    header("Location: kelola_publikasi.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

$query = "SELECT * FROM publikasi_dosen WHERE id_publikasi = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_publikasi.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

if(isset($_POST['submit'])) {
    $id_dosen = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $jenis = pg_escape_string($conn, $_POST['id_jenis_publikasi']);
    $judul = pg_escape_string($conn, $_POST['judul_publikasi']);
    $tahun = pg_escape_string($conn, $_POST['tahun']);
    $url = pg_escape_string($conn, $_POST['url_publikasi']);
    
    $query = "UPDATE publikasi_dosen SET 
              id_profil_dosen = '$id_dosen',
              id_jenis_publikasi = '$jenis',
              judul_publikasi = '$judul',
              tahun = '$tahun',
              url_publikasi = '$url'
              WHERE id_publikasi = '$id'";
    
    if(pg_query($conn, $query)) {
        header("Location: kelola_publikasi.php?success=edit");
        exit();
    } else {
        $error = "Gagal mengupdate data: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Publikasi - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-left">
                <h1><i class="fas fa-book"></i> Edit Publikasi</h1>
                <p class="text-muted">Update data publikasi dosen</p>
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

        <div class="form-container">
            <form action="" method="POST">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label for="id_profil_dosen" class="form-label required">Nama Dosen</label>
                            <select id="id_profil_dosen" name="id_profil_dosen" class="form-control" required>
                                <option value="">Pilih Dosen</option>
                                <?php while($dosen = pg_fetch_assoc($dosen_list)): ?>
                                    <option value="<?= $dosen['id_profil_dosen']; ?>"
                                        <?= $dosen['id_profil_dosen'] == $data['id_profil_dosen'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($dosen['nama_dosen']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_jenis_publikasi" class="form-label required">Jenis Publikasi</label>
                            <select id="id_jenis_publikasi" name="id_jenis_publikasi" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Jurnal" <?= $data['id_jenis_publikasi']=='Jurnal'?'selected':''; ?>>Jurnal</option>
                                <option value="Konferensi" <?= $data['id_jenis_publikasi']=='Konferensi'?'selected':''; ?>>Konferensi</option>
                                <option value="Buku" <?= $data['id_jenis_publikasi']=='Buku'?'selected':''; ?>>Buku</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="judul_publikasi" class="form-label required">Judul Publikasi</label>
                            <input type="text" id="judul_publikasi" name="judul_publikasi" class="form-control" 
                                   value="<?= htmlspecialchars($data['judul_publikasi']); ?>" required>
                        </div>
                    </div>

                    <div class="form-column">
                        <div class="form-group">
                            <label for="tahun" class="form-label required">Tahun Publikasi</label>
                            <input type="number" id="tahun" name="tahun" class="form-control"
                                   value="<?= htmlspecialchars($data['tahun']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="url_publikasi" class="form-label">URL Publikasi</label>
                            <input type="url" id="url_publikasi" name="url_publikasi" class="form-control"
                                   value="<?= htmlspecialchars($data['url_publikasi']); ?>">
                            <small class="form-help">Link ke publikasi online (opsional)</small>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="kelola_publikasi.php" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
