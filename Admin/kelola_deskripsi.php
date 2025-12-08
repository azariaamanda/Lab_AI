<?php
session_start();
require_once '../koneksi.php';

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_profil = $_POST['id_profil'];
    $isi = $_POST['isi'];

    $query_update = "UPDATE profil_lab SET isi = $1 WHERE id_profil = $2 AND tipe_konten = 'Deskripsi'";
    $result_update = pg_query_params($conn, $query_update, [$isi, $id_profil]);

    if ($result_update) {
        $_SESSION['message'] = 'Data Deskripsi berhasil diperbarui!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal memperbarui Deskripsi: ' . pg_last_error($conn);
        $_SESSION['message_type'] = 'error';
    }
    header('Location: kelola_deskripsi.php');
    exit;
}

// Ambil data Deskripsi
$query_deskripsi = "SELECT * FROM profil_lab WHERE tipe_konten = 'Deskripsi' LIMIT 1";
$result_deskripsi = pg_query($conn, $query_deskripsi);
$deskripsi = pg_fetch_assoc($result_deskripsi);

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Deskripsi - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <link rel="stylesheet" href="css/form.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="dashboard-content">
            <?php include 'header.php'; ?>
            <div class="page-header">
                <h1 class="page-title">Kelola Deskripsi Laboratorium</h1>
                <p class="page-subtitle">Atur teks deskripsi yang tampil di halaman Beranda.</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 900px; margin: auto;">
                <form action="kelola_deskripsi.php" method="POST" class="data-form">
                    <input type="hidden" name="id_profil" value="<?php echo $deskripsi['id_profil'] ?? ''; ?>">
                    <div class="form-card">
                        <div class="form-header">
                            <h3><i class="fas fa-align-left"></i> Deskripsi Laboratorium</h3>
                        </div>
                        <div class="form-body">
                            <div class="form-group">
                                <label for="isi_deskripsi" class="form-label required">Isi Deskripsi</label>
                                <textarea id="isi_deskripsi" name="isi" rows="8" class="form-control" required><?php echo htmlspecialchars($deskripsi['isi'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/dashboardJS.js"></script>
</body>
</html>