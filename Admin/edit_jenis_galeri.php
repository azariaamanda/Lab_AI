<?php
require_once '../koneksi. php';

$error = '';
$success = '';
$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: kelola_jenis_galeri.php');
    exit;
}

// Ambil data jenis galeri
try {
    $query = "SELECT * FROM jenis_galeri WHERE id_jenis_galeri = :id";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    $jenis = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$jenis) {
        header('Location: kelola_jenis_galeri. php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    
    if (empty($nama)) {
        $error = "Nama jenis galeri harus diisi!";
    } else {
        try {
            $query = "CALL sp_update_jenis_galeri(:id, :nama)";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':nama' => $nama
            ]);
            $success = "Jenis galeri berhasil diperbarui!";
            // Refresh data
            $query = "SELECT * FROM jenis_galeri WHERE id_jenis_galeri = :id";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([':id' => $id]);
            $jenis = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Edit Jenis Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Edit Jenis Galeri</h1>
                
                <? php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <? php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Jenis Galeri</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                            value="<?php echo htmlspecialchars($jenis['nama_jenis_galeri']); ? >" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="kelola_jenis_galeri.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>