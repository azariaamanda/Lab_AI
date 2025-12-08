<? php
require_once '../koneksi.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? '';

if (! $id) {
    header('Location: kelola_layanan.php');
    exit;
}

// Ambil data layanan
try {
    $query = "SELECT * FROM layanan WHERE id_layanan = :id";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    $layanan = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$layanan) {
        header('Location: kelola_layanan.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $url = $_POST['url'] ?? '';
    
    if (empty($nama) || empty($deskripsi)) {
        $error = "Nama dan deskripsi layanan harus diisi! ";
    } else {
        try {
            $query = "CALL sp_update_layanan(:id, :nama, :deskripsi, :url)";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':nama' => $nama,
                ':deskripsi' => $deskripsi,
                ':url' => $url ?: null
            ]);
            $success = "Layanan berhasil diperbarui!";
            // Refresh data
            $query = "SELECT * FROM layanan WHERE id_layanan = :id";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([':id' => $id]);
            $layanan = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1. 3/dist/css/bootstrap. min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Edit Layanan</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ? ></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ? ></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                            value="<?php echo htmlspecialchars($layanan['nama_layanan']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Layanan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><? php echo htmlspecialchars($layanan['deskripsi_layanan']); ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="url" class="form-label">URL Layanan</label>
                        <input type="url" class="form-control" id="url" name="url" 
                            value="<? php echo htmlspecialchars($layanan['url_layanan']); ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="kelola_layanan.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle. min.js"></script>
</body>
</html>