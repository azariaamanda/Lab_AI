<?php
require_once '../koneksi.php';

// ======================== CEK ID ========================
if(!isset($_GET['id'])) {
    header("Location: kelola_pendidikan_dosen.php?error=ID tidak ditemukan");
    exit();
}

$id = pg_escape_string($conn, $_GET['id']);

// ======================== GET DATA UTAMA ========================
$query = "SELECT * FROM pendidikan_dosen WHERE id_pendidikan = '$id'";
$result = pg_query($conn, $query);

if(pg_num_rows($result) == 0) {
    header("Location: kelola_pendidikan_dosen.php?error=Data tidak ditemukan");
    exit();
}

$data = pg_fetch_assoc($result);

// ======================== LIST DOSEN ========================
$query_dosen = "SELECT id_profil_dosen, nama_dosen FROM profil_dosen ORDER BY nama_dosen";
$dosen_list = pg_query($conn, $query_dosen);

// ======================== UPDATE ========================
if(isset($_POST['submit'])) {
    $id_dosen       = pg_escape_string($conn, $_POST['id_profil_dosen']);
    $jenjang        = pg_escape_string($conn, $_POST['jenjang']);
    $prodi          = pg_escape_string($conn, $_POST['program_studi']);
    $universitas    = pg_escape_string($conn, $_POST['universitas']);
    $tahun_mulai    = pg_escape_string($conn, $_POST['tahun_mulai']);
    $tahun_selesai  = pg_escape_string($conn, $_POST['tahun_selesai']);

    $query = "UPDATE pendidikan_dosen SET 
                id_profil_dosen = '$id_dosen',
                jenjang = '$jenjang',
                program_studi = '$prodi',
                universitas = '$universitas',
                tahun_mulai = '$tahun_mulai',
                tahun_selesai = '$tahun_selesai'
              WHERE id_pendidikan = '$id'";

    if(pg_query($conn, $query)) {
        header("Location: kelola_pendidikan_dosen.php?success=edit");
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
    <title>Edit Pendidikan Dosen - Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-graduation-cap"></i> Edit Pendidikan Dosen</h1>
            <p class="text-muted">Update riwayat pendidikan dosen</p>
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
        <?= $error ?>
    </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST">
            <div class="form-grid">

                <!-- Kolom kiri -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">Nama Dosen</label>
                        <select name="id_profil_dosen" class="form-control" required>
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
                        <label class="form-label required">Jenjang</label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="S1" <?= $data['jenjang']=='S1'?'selected':'' ?>>S1</option>
                            <option value="S2" <?= $data['jenjang']=='S2'?'selected':'' ?>>S2</option>
                            <option value="S3" <?= $data['jenjang']=='S3'?'selected':'' ?>>S3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Program Studi</label>
                        <input type="text" name="program_studi" class="form-control"
                               value="<?= htmlspecialchars($data['program_studi']); ?>" required>
                    </div>
                </div>

                <!-- Kolom kanan -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">Universitas</label>
                        <input type="text" name="universitas" class="form-control"
                               value="<?= htmlspecialchars($data['universitas']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tahun Mulai</label>
                        <input type="number" name="tahun_mulai" class="form-control"
                               value="<?= htmlspecialchars($data['tahun_mulai']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tahun Selesai</label>
                        <input type="number" name="tahun_selesai" class="form-control"
                               value="<?= htmlspecialchars($data['tahun_selesai']); ?>" required>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <a href="kelola_pendidikan_dosen.php" class="btn btn-outline"><i class="fas fa-times"></i> Batal</a>
                <button name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Data</button>
            </div>

        </form>
    </div>

</div>
</body>
</html>
