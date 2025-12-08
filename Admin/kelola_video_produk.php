<?php
require_once '../koneksi. php';

$error = '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

// Ambil semua data video produk
try {
    $query = "SELECT * FROM video_produk ORDER BY id_video DESC";
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $video_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $video_list = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Video Produk</title>
    <link href="https://cdn.jsdelivr. net/npm/bootstrap@5. 1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Kelola Video Produk</h1>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><? php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><? php echo $success; ?></div>
                <?php endif; ?>
                
                <a href="tambah_video_produk. php" class="btn btn-primary mb-3">+ Tambah Video</a>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>URL YouTube</th>
                                <th>Preview</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($video_list as $item): ?>
                            <tr>
                                <td><?php echo $item['id_video']; ?></td>
                                <td><?php echo htmlspecialchars($item['url_youtube']); ?></td>
                                <td>
                                    <a href="<?php echo htmlspecialchars($item['url_youtube']); ?>" target="_blank" class="btn btn-sm btn-info">Tonton</a>
                                </td>
                                <td>
                                    <a href="edit_video_produk.php?id=<? php echo $item['id_video']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="hapus_video_produk.php? id=<?php echo $item['id_video']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>