<?php
require_once '../koneksi.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? '';

if (! $id) {
    header('Location: kelola_galeri.php');
    exit;
}

// Ambil data galeri
try {
    $query = "SELECT * FROM galeri WHERE id_galeri = :id";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    $galeri = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$galeri) {
        header('Location: kelola_galeri.php');
        exit;
    }
} catch (PDOException $e) {
    $error = "Error: " .  $e->getMessage();
}

// Ambil data dropdown
try {
    $query_kategori = "SELECT * FROM kategori_galeri ORDER BY nama_kategori";
    $stmt_kategori = $koneksi->prepare($query_kategori);
    $stmt_kategori->execute();
    $kategori_list = $stmt_kategori->fetchAll(PDO::FETCH_ASSOC);
    
    $query_jenis = "SELECT * FROM jenis_galeri ORDER BY nama_jenis_galeri";
    $stmt_jenis = $koneksi->prepare($query_jenis);
    $stmt_jenis->execute();
    $jenis_list = $stmt_jenis->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = $_POST['id_kategori'] ?? '';
    $id_jenis = $_POST['id_jenis'] ?? '';
    $judul = $_POST['judul'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $media = $_POST['media'] ?? '';
    
    if (empty($id_kategori) || empty($id_jenis) || empty($judul) || empty($tanggal)) {
        $error = "Semua field harus diisi!";
    } else {
        try {
            $query = "CALL sp_update_galeri(:id_galeri, :id_kategori, :id_jenis, :judul, :tanggal, :media)";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([
                ':id_galeri' => $id,
                ':id_kategori' => $id_kategori,
                ':id_jenis' => $id_jenis,
                ':judul' => $judul,
                ':tanggal' => $tanggal,
                ':media' => $media ?: null
            ]);
            $success = "Galeri berhasil diperbarui!";
            // Refresh data
            $query = "SELECT * FROM galeri WHERE id_galeri = :id";
            $stmt = $koneksi->prepare($query);
            $stmt->execute([':id' => $id]);
            $galeri = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="mb-4">Edit Galeri</h1>
                
                <? php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <? php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori Galeri</label>
                        <select class="form-select" id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach($kategori_list as $kat): ?>
                                <option value="<?php echo $kat['id_kategori_galeri']; ?>" 
                                    <?php echo ($kat['id_kategori_galeri'] == $galeri['id_kategori_galeri']) ? 'selected' : ''; ? >>
                                    <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="id_jenis" class="form-label">Jenis Galeri</label>
                        <select class="form-select" id="id_jenis" name="id_jenis" required>
                            <option value="">-- Pilih Jenis --</option>
                            <?php foreach($jenis_list as $jen): ?>
                                <option value="<?php echo $jen['id_jenis_galeri']; ?>"
                                    <?php echo ($jen['id_jenis_galeri'] == $galeri['id_jenis_galeri']) ?  'selected' : ''; ? >>
                                    <?php echo htmlspecialchars($jen['nama_jenis_galeri']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Galeri</label>
                        <input type="text" class="form-control" id="judul" name="judul" 
                            value="<?php echo htmlspecialchars($galeri['judul_galeri']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                            value="<?php echo $galeri['tanggal_galeri']; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="media" class="form-label">URL Media (Foto/Video)</label>
                        <input type="url" class="form-control" id="media" name="media" 
                            value="<?php echo htmlspecialchars($galeri['media_galeri']); ?>" placeholder="https://...">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="kelola_galeri.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>