<?php
require_once '../koneksi.php'; // sudah konek PG

// Ambil list dosen
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

// Jika submit
if(isset($_POST['submit'])) {
    $id_dosen       = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $jenjang        = pg_escape_string($conn, $_POST['jenjang']);
    $prodi          = pg_escape_string($conn, $_POST['program_studi']);
    $universitas    = pg_escape_string($conn, $_POST['universitas']);
    $tahun_mulai    = pg_escape_string($conn, $_POST['tahun_mulai']);
    $tahun_selesai  = pg_escape_string($conn, $_POST['tahun_selesai']);

    $query = "INSERT INTO pendidikan_dosen 
                (id_profil_dosen, jenjang, program_studi, universitas, tahun_mulai, tahun_selesai)
              VALUES 
                ('$id_dosen', '$jenjang', '$prodi', '$universitas', '$tahun_mulai', '$tahun_selesai')";

    if(pg_query($conn, $query)) {
        header("Location: kelola_pendidikan_dosen.php?success=tambah");
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
    <title>Tambah Pendidikan Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-graduation-cap"></i> Tambah Pendidikan Dosen</h1>
            <p class="text-muted">Tambahkan riwayat pendidikan dosen</p>
        </div>
        <div class="header-right">
            <a href="kelola_pendidikan_dosen.php" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <?php if(isset($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= $error; ?>
    </div>
    <?php endif; ?>

    <div class="info-banner">
        <div class="info-content">
            <i class="fas fa-info-circle"></i>
            <div>
                <h4>Informasi</h4>
                <small>Lengkapi riwayat pendidikan dosen. Field bertanda (*) wajib diisi.</small>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="POST">
            <div class="form-grid">

                <!-- Kolom 1 -->
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
                        <label class="form-label required">Jenjang</label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="S1">S1 (Sarjana)</option>
                            <option value="S2">S2 (Magister)</option>
                            <option value="S3">S3 (Doktor)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Program Studi</label>
                        <input type="text" name="program_studi" class="form-control"
                               placeholder="contoh: Teknik Informatika" required>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">Universitas</label>
                        <input type="text" name="universitas" class="form-control"
                               placeholder="Nama universitas" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" class="form-control"
                               placeholder="2015" min="1980" max="2030" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" class="form-control"
                               placeholder="2019" min="1980" max="2030" required>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <a href="kelola_pendidikan_dosen.php" class="btn btn-outline">
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
