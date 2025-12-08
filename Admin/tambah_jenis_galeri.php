<?php
require_once '../koneksi.php';

$error = '';
$success = '';

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_jenis'] ?? '';
    
    // Validasi input
    if (empty($nama)) {
        $error = "Nama jenis galeri harus diisi!";
    } else {
        try {
            // Cek apakah nama sudah ada
            $query_check = "SELECT COUNT(*) as total FROM jenis_galeri WHERE LOWER(nama_jenis_galeri) = LOWER(:nama)";
            $stmt_check = $koneksi->prepare($query_check);
            $stmt_check->execute([':nama' => trim($nama)]);
            $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] > 0) {
                $error = "Nama jenis galeri sudah ada! ";
            } else {
                // Insert data
                $query = "CALL sp_insert_jenis_galeri(:nama)";
                $stmt = $koneksi->prepare($query);
                $stmt->execute([':nama' => trim($nama)]);
                
                $success = "Jenis galeri berhasil ditambahkan! ";
                $_POST = [];
            }
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
    <title>Tambah Jenis Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Tambah Jenis Galeri</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_jenis" class="form-label">Nama Jenis Galeri</label>
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="kelola_jenis_galeri.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1. 3/dist/js/bootstrap. bundle. min.js"></script>
</body>
</html>