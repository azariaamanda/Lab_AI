<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data misi yang akan diedit
$query_select = "SELECT * FROM profil_lab WHERE id_profil = $1 AND tipe_konten = 'Misi'";
$result_select = pg_query_params($conn, $query_select, [$id]);
$misi = pg_fetch_assoc($result_select);

if (!$misi) {
    $_SESSION['message'] = 'Data Misi tidak ditemukan.';
    $_SESSION['message_type'] = 'error';
    header('Location: kelola_misi.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $isi = $_POST['isi'] ?? '';

    if (empty($judul) || empty($isi)) {
        $_SESSION['message'] = 'Judul dan Isi Misi wajib diisi.';
        $_SESSION['message_type'] = 'error';
    } else {
        $query_update = "UPDATE profil_lab SET judul = $1, isi = $2 WHERE id_profil = $3";
        $result_update = pg_query_params($conn, $query_update, [$judul, $isi, $id]);

        if ($result_update) {
            $_SESSION['message'] = 'Poin Misi berhasil diperbarui!';
            $_SESSION['message_type'] = 'success';
            header('Location: kelola_misi.php');
            exit;
        } else {
            $_SESSION['message'] = 'Gagal memperbarui Misi: ' . pg_last_error($conn);
            $_SESSION['message_type'] = 'error';
        }
    }
    header("Location: edit_misi.php?id=$id");
    exit;
}

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Misi - Dashboard</title>
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
                <h1 class="page-title">Edit Poin Misi</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 800px; margin: auto;">
                <form action="edit_misi.php?id=<?php echo $id; ?>" method="POST" class="data-form">
                    <div class="form-card">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="judul" class="form-label required">Judul Misi</label>
                                <input type="text" id="judul" name="judul" class="form-control" value="<?php echo htmlspecialchars($misi['judul']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="isi" class="form-label required">Isi Misi</label>
                                <textarea id="isi" name="isi" rows="4" class="form-control" required><?php echo htmlspecialchars($misi['isi']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="kelola_misi.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
</body>
</html>