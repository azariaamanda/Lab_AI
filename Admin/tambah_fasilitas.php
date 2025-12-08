<?php
session_start();
require_once '../koneksi.php';

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fasilitas = $_POST['nama_fasilitas'] ?? '';
    $gambar_fasilitas = $_FILES['gambar_fasilitas'] ?? null;

    if (empty($nama_fasilitas) || !$gambar_fasilitas || $gambar_fasilitas['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = 'Nama fasilitas dan gambar wajib diisi.';
        $_SESSION['message_type'] = 'error';
        header('Location: tambah_fasilitas.php');
        exit;
    }

    // Proses upload gambar
    $upload_dir = '../img/fasilitas/';
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($gambar_fasilitas['type'], $allowed_types)) {
        $_SESSION['message'] = 'Format gambar harus JPG, JPEG, atau PNG.';
        $_SESSION['message_type'] = 'error';
    } elseif ($gambar_fasilitas['size'] > $max_size) {
        $_SESSION['message'] = 'Ukuran gambar tidak boleh lebih dari 2MB.';
        $_SESSION['message_type'] = 'error';
    } else {
        $file_extension = pathinfo($gambar_fasilitas['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid('fasilitas_', true) . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($gambar_fasilitas['tmp_name'], $target_file)) {
            // Simpan ke database
            $query = "INSERT INTO fasilitas (nama_fasilitas, gambar_fasilitas) VALUES ($1, $2)";
            $result = pg_query_params($conn, $query, [$nama_fasilitas, $new_filename]);

            if ($result) {
                $_SESSION['message'] = 'Fasilitas baru berhasil ditambahkan!';
                $_SESSION['message_type'] = 'success';
                header('Location: kelola_fasilitas.php');
                exit;
            } else {
                $_SESSION['message'] = 'Gagal menyimpan data ke database: ' . pg_last_error($conn);
                $_SESSION['message_type'] = 'error';
                unlink($target_file); // Hapus file jika query gagal
            }
        } else {
            $_SESSION['message'] = 'Gagal mengunggah gambar.';
            $_SESSION['message_type'] = 'error';
        }
    }
    header('Location: tambah_fasilitas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fasilitas - Dashboard</title>
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
                <h1 class="page-title">Tambah Fasilitas Baru</h1>
                <p class="page-subtitle">Isi formulir untuk menambahkan fasilitas laboratorium.</p>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 700px; margin: auto;">
                <form action="tambah_fasilitas.php" method="POST" class="data-form" enctype="multipart/form-data">
                    <div class="form-card">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="nama_fasilitas" class="form-label required">Nama Fasilitas</label>
                                <input type="text" id="nama_fasilitas" name="nama_fasilitas" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar_fasilitas" class="form-label required">Gambar Fasilitas</label>
                                <input type="file" id="gambar_fasilitas" name="gambar_fasilitas" class="form-control" accept="image/png, image/jpeg, image/jpg" required>
                                <div class="form-help">Format: JPG, JPEG, PNG. Ukuran maks: 2MB.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="kelola_fasilitas.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Fasilitas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
</body>
</html>