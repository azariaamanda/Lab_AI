<?php
session_start();
require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data banner yang akan diedit
$query_select = "SELECT * FROM nav_banner WHERE id_navbanner = $1";
$result_select = pg_query_params($conn, $query_select, [$id]);
$banner = pg_fetch_assoc($result_select);

if (!$banner) {
    $_SESSION['message'] = 'Nav Banner tidak ditemukan.';
    $_SESSION['message_type'] = 'error';
    header('Location: kelola_nav_banner.php');
    exit;
}

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $url_navbanner = $_POST['url_navbanner'] ?? '';
    $icon_new = $_FILES['icon_navbanner'] ?? null;
    $icon_lama = $banner['icon_navbanner'];

    if (empty($nama) || empty($url_navbanner)) {
        $_SESSION['message'] = 'Nama dan URL tidak boleh kosong.';
        $_SESSION['message_type'] = 'error';
    } else {
        $new_icon_path = $icon_lama;
        // Jika ada ikon baru diunggah
        if ($icon_new && $icon_new['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../'; // Path relatif dari file ini ke root
            $allowed_types = ['image/png'];
            $max_size = 1 * 1024 * 1024;

            if (in_array($icon_new['type'], $allowed_types) && $icon_new['size'] <= $max_size) {
                // Hapus ikon lama
                if (!empty($icon_lama) && file_exists($upload_dir . $icon_lama)) {
                    unlink($upload_dir . $icon_lama);
                }
                // Buat nama file baru dan pindahkan
                $file_extension = pathinfo($icon_new['name'], PATHINFO_EXTENSION);
                $new_filename = 'img/nav-banner/' . strtolower(str_replace(' ', '_', $nama)) . '.' . $file_extension;
                move_uploaded_file($icon_new['tmp_name'], $upload_dir . $new_filename);
                $new_icon_path = $new_filename;
            } else {
                $_SESSION['message'] = 'Ikon tidak valid (format atau ukuran salah).';
                $_SESSION['message_type'] = 'error';
                header("Location: edit_nav_banner.php?id=$id");
                exit;
            }
        }

        // Update database
        $query_update = "UPDATE nav_banner SET nama = $1, url_navbanner = $2, icon_navbanner = $3 WHERE id_navbanner = $4";
        $result_update = pg_query_params($conn, $query_update, [$nama, $url_navbanner, $new_icon_path, $id]);

        if ($result_update) {
            $_SESSION['message'] = 'Nav Banner berhasil diperbarui!';
            $_SESSION['message_type'] = 'success';
            header('Location: kelola_nav_banner.php');
            exit;
        } else {
            $_SESSION['message'] = 'Gagal memperbarui data: ' . pg_last_error($conn);
            $_SESSION['message_type'] = 'error';
        }
    }
    header("Location: edit_nav_banner.php?id=$id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nav Banner - Dashboard</title>
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
                <h1 class="page-title">Edit Nav Banner</h1>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <div class="form-container" style="max-width: 700px; margin: auto;">
                <form action="edit_nav_banner.php?id=<?php echo $id; ?>" method="POST" class="data-form" enctype="multipart/form-data">
                    <div class="form-card">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="nama" class="form-label required">Nama Item</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($banner['nama']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="url_navbanner" class="form-label required">URL Tujuan</label>
                                <input type="text" id="url_navbanner" name="url_navbanner" class="form-control" value="<?php echo htmlspecialchars($banner['url_navbanner']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="icon_navbanner" class="form-label">Ganti Ikon (Opsional)</label>
                                <input type="file" id="icon_navbanner" name="icon_navbanner" class="form-control" accept="image/png">
                                <div class="form-help">Biarkan kosong jika tidak ingin mengganti ikon.</div>
                                <div style="margin-top: 10px;">
                                    <p>Ikon saat ini:</p>
                                    <img src="../<?php echo htmlspecialchars($banner['icon_navbanner']); ?>" alt="Ikon saat ini" style="width: 60px; height: 60px; background: #eee; padding: 5px; border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="kelola_nav_banner.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/dashboardJS.js"></script>
</body>
</html>