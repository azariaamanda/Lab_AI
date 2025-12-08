<?php
require_once '../koneksi. php';

$error = '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

// Ambil semua data jenis galeri
try {
    $query = "SELECT * FROM jenis_galeri ORDER BY nama_jenis_galeri";
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $jenis_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $jenis_list = [];
}

// Proses tambah jenis galeri
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $nama = $_POST['nama'] ?? '';
    
    if (empty($nama)) {
        $error = "Nama jenis galeri harus diisi!";
    } else {
        try {
            $query = "CALL sp_insert_jenis_galeri(:nama)";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([':nama' => $nama]);
            $success = "Jenis galeri berhasil ditambahkan!";
            // Refresh data
            $query = "SELECT * FROM jenis_galeri ORDER BY nama_jenis_galeri";
            $stmt = $koneksi->prepare($query);
            $stmt->execute();
            $jenis_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

// Proses edit jenis galeri
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'] ?? '';
    $nama = $_POST['nama'] ?? '';
    
    if (empty($id) || empty($nama)) {
        $error = "Semua field harus diisi!";
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
            $query = "SELECT * FROM jenis_galeri ORDER BY nama_jenis_galeri";
            $stmt = $koneksi->prepare($query);
            $stmt->execute();
            $jenis_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Kelola Jenis Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Kelola Jenis Galeri</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Tambah Jenis Galeri</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="tambah">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Jenis Galeri</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Daftar Jenis Galeri</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($jenis_list as $item): ?>
                                    <tr>
                                        <td><? php echo $item['id_jenis_galeri']; ?></td>
                                        <td><?php echo htmlspecialchars($item['nama_jenis_galeri']); ?></td>
                                        <td>
                                            <a href="edit_jenis_galeri.php?id=<?php echo $item['id_jenis_galeri']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="hapus_jenis_galeri.php? id=<?php echo $item['id_jenis_galeri']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus? ')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle. min.js"></script>
</body>
</html>