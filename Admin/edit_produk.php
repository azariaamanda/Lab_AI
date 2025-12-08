<?php
require_once '../koneksi.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: kelola_produk.php');
    exit;
}

// Ambil data produk
try {
    $query = "SELECT * FROM produk WHERE id_produk = :id";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    $produk = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produk) {
        header('Location: kelola_produk.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deskripsi = $_POST['deskripsi'] ?? '';
    $teks_button = $_POST['teks_button'] ?? '';
    $url = $_POST['url'] ?? '';
    $logo = $_POST['logo'] ?? '';
    
    if (empty($deskripsi) || empty($teks_button) || empty($url)) {
        $error = "Semua field wajib diisi!";
    } else {
        try {
            $query = "CALL sp_update_produk(:id, :deskripsi, :teks_button, :url, :logo)";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':deskripsi' => $deskripsi,
                ':teks_button' => $teks_button,
                ':url' => $url,
                ':logo' => $logo ?: null
            ]);
            $success = "Produk berhasil diperbarui!";
            // Refresh data
            $query = "SELECT * FROM produk WHERE id_produk = :id";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([':id' => $id]);
            $produk = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Edit Produk</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><? php echo htmlspecialchars($produk['deskripsi_produk']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="teks_button" class="form-label">Teks Button</label>
                        <input type="text" class="form-control" id="teks_button" name="teks_button" 
                            value="<?php echo htmlspecialchars($produk['teks_button']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="url" class="form-label">URL Produk</label>
                        <input type="url" class="form-control" id="url" name="url" 
                            value="<?php echo htmlspecialchars($produk['url_produk']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo Produk (URL)</label>
                        <input type="url" class="form-control" id="logo" name="logo"
                            value="<?php echo htmlspecialchars($produk['logo_produk']); ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="kelola_produk.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>