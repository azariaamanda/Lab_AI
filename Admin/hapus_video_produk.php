<?php
require_once '../koneksi.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: kelola_video_produk.php');
    exit;
}

try {
    $query = "CALL sp_delete_video_produk(:id)";
    $stmt = $koneksi->prepare($query);
    $stmt->execute([':id' => $id]);
    
    header('Location: kelola_video_produk. php?success=Data berhasil dihapus');
    exit;
} catch (PDOException $e) {
    header('Location: kelola_video_produk.php?error=' .  urlencode($e->getMessage()));
    exit;
}
?>