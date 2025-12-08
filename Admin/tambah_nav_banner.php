<?php
session_start();
require_once '../koneksi.php';

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $url_navbanner = $_POST['url_navbanner'] ?? '';
    $icon_navbanner = $_FILES['icon_navbanner'] ?? null;

    if (empty($nama) || empty($url_navbanner) || !$icon_navbanner || $icon_navbanner['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['message'] = 'Semua field wajib diisi.';
        $_SESSION['message_type'] = 'error';
        header('Location: tambah_nav_banner.php');
        exit;
    }

    // Proses upload gambar
    $upload_dir = '../img/nav-banner/';
    $allowed_types = ['image/png'];
    $max_size = 1 * 1024 * 1024; // 1MB

    if (!in_array($icon_navbanner['type'], $allowed_types)) {
        $_SESSION['message'] = 'Format ikon harus PNG.';
        $_SESSION['message_type'] = 'error';
    } elseif ($icon_navbanner['size'] > $max_size) {
        $_SESSION['message'] = 'Ukuran ikon tidak boleh lebih dari 1MB.';
        $_SESSION['message_type'] = 'error';
    } else {
        $file_extension = pathinfo($icon_navbanner['name'], PATHINFO_EXTENSION);
        $new_filename = strtolower(str_replace(' ', '_', $nama)) . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($icon_navbanner['tmp_name'], $target_file)) {
            $db_path = 'img/nav-banner/' . $new_filename;
            $query = "INSERT INTO nav_banner (nama, url_navbanner, icon_navbanner) VALUES ($1, $2, $3)";
            $result = pg_query_params($conn, $query, [$nama, $url_navbanner, $db_path]);

            if ($result) {
                $_SESSION['message'] = 'Nav Banner baru berhasil ditambahkan!';
                $_SESSION['message_type'] = 'success';
                header('Location: kelola_nav_banner.php');
                exit;
            } else {
                $_SESSION['message'] = 'Gagal menyimpan data: ' . pg_last_error($conn);
                $_SESSION['message_type'] = 'error';
                unlink($target_file);
            }
        } else {
            $_SESSION['message'] = 'Gagal mengunggah ikon.';
            $_SESSION['message_type'] = 'error';
        }
    }
    header('Location: tambah_nav_banner.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nav Banner - Dashboard</title>
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
                <h1 class="page-title">Tambah Nav Banner Baru</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 700px; margin: auto;">
                <form action="tambah_nav_banner.php" method="POST" class="data-form" enctype="multipart/form-data">
                    <div class="form-card">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="nama" class="form-label required">Nama Item</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="url_navbanner" class="form-label required">URL Tujuan</label>
                                <input type="text" id="url_navbanner" name="url_navbanner" class="form-control" placeholder="Contoh: profil.php" required>
                            </div>
                            <div class="form-group">
                                <label for="icon_navbanner" class="form-label required">Ikon (PNG)</label>
                                <input type="file" id="icon_navbanner" name="icon_navbanner" class="form-control" accept="image/png" required>
                                <div class="form-help">Format: PNG. Ukuran maks: 1MB.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="kelola_nav_banner.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
</body>
</html>