<? php
require_once '../koneksi.php';

$error = '';
$success = '';
$id = $_GET['id'] ??  '';

if (!$id) {
    header('Location: kelola_video_produk.php');
    exit;
}

// Ambil data video produk
try {
    $query = "SELECT * FROM video_produk WHERE id_video = :id";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$video) {
        header('Location: kelola_video_produk.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url_youtube = $_POST['url_youtube'] ?? '';
    
    if (empty($url_youtube)) {
        $error = "URL YouTube harus diisi!";
    } else {
        // Validasi format URL YouTube
        if (! preg_match('/^(https?:\/\/)?(www\.)?(youtube|youtu|youtube-nocookie)\.(com|be)\//', $url_youtube)) {
            $error = "URL YouTube tidak valid!";
        } else {
            try {
                $query = "CALL sp_update_video_produk(:id, :url)";
                $stmt = $koneksi->prepare($query);
                $stmt->execute([
                    ':id' => $id,
                    ':url' => $url_youtube
                ]);
                $success = "Video produk berhasil diperbarui!";
                // Refresh data
                $query = "SELECT * FROM video_produk WHERE id_video = :id";
                $stmt = $koneksi->prepare($query);
                $stmt->execute([':id' => $id]);
                $video = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video Produk</title>
    <link href="https://cdn. jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Edit Video Produk</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="url_youtube" class="form-label">URL YouTube</label>
                        <input type="url" class="form-control" id="url_youtube" name="url_youtube" 
                            value="<?php echo htmlspecialchars($video['url_youtube']); ?>" required>
                        <small class="form-text text-muted">Masukkan URL YouTube lengkap</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="kelola_video_produk.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn. jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>