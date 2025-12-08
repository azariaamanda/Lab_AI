<? php
require_once '../koneksi.php';

// Ambil semua data galeri
try {
    $query = "SELECT * FROM vw_galeri ORDER BY tanggal_galeri DESC";
    $stmt = $koneksi->prepare($query);
    $stmt->execute();
    $galeri_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $galeri_list = [];
}

// Ambil data untuk dropdown
try {
    // Ambil kategori galeri
    $query_kategori = "SELECT * FROM kategori_galeri ORDER BY nama_kategori";
    $stmt_kategori = $koneksi->prepare($query_kategori);
    $stmt_kategori->execute();
    $kategori_list = $stmt_kategori->fetchAll(PDO::FETCH_ASSOC);
    
    // Ambil jenis galeri
    $query_jenis = "SELECT * FROM jenis_galeri ORDER BY nama_jenis_galeri";
    $stmt_jenis = $koneksi->prepare($query_jenis);
    $stmt_jenis->execute();
    $jenis_list = $stmt_jenis->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
    $kategori_list = [];
    $jenis_list = [];
}
?>
<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Kelola Galeri</h1>
                
                <? php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <a href="tambah_galeri.php" class="btn btn-primary mb-3">+ Tambah Galeri</a>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Media</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($galeri_list as $item): ?>
                            <tr>
                                <td><?php echo $item['id_galeri']; ?></td>
                                <td><?php echo htmlspecialchars($item['judul_galeri']); ?></td>
                                <td><?php echo htmlspecialchars($item['nama_kategori']); ?></td>
                                <td><? php echo htmlspecialchars($item['nama_jenis_galeri']); ?></td>
                                <td><?php echo $item['tanggal_galeri']; ?></td>
                                <td>
                                    <? php if($item['media_galeri']): ?>
                                        <a href="<? php echo htmlspecialchars($item['media_galeri']); ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                    <? php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_galeri.php?id=<?php echo $item['id_galeri']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="hapus_galeri.php?id=<?php echo $item['id_galeri']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
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