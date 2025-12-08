<? php
require_once '../koneksi.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: kelola_jenis_galeri.php');
    exit;
}

try {
    $query = "CALL sp_delete_jenis_galeri(:id)";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    
    header('Location: kelola_jenis_galeri.php?success=Data berhasil dihapus');
    exit;
} catch (PDOException $e) {
    header('Location: kelola_jenis_galeri.php? error=' . urlencode($e->getMessage()));
    exit;
}
?>