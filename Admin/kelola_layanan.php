<?php
require_once '../koneksi.php';

$error = '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

// Ambil semua data layanan
try {
    $query = "SELECT * FROM layanan ORDER BY nama_layanan";
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $layanan_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $layanan_list = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1. 3/dist/css/bootstrap. min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Kelola Layanan</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ? ></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ? ></div>
                <?php endif; ?>
                
                <a href="tambah_layanan. php" class="btn btn-primary mb-3">+ Tambah Layanan</a>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Layanan</th>
                                <th>Deskripsi</th>
                                <th>URL</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($layanan_list as $item): ?>
                            <tr>
                                <td><?php echo $item['id_layanan']; ?></td>
                                <td><?php echo htmlspecialchars($item['nama_layanan']); ?></td>
                                <td><?php echo substr(htmlspecialchars($item['deskripsi_layanan']), 0, 50) .  '...'; ?></td>
                                <td>
                                    <? php if($item['url_layanan']): ?>
                                        <a href="<?php echo htmlspecialchars($item['url_layanan']); ?>" target="_blank" class="btn btn-sm btn-info">Buka</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_layanan.php?id=<? php echo $item['id_layanan']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="hapus_layanan.php? id=<?php echo $item['id_layanan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min. js"></script>
</body>
</html>